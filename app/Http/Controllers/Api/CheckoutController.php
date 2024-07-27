<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Support\Cost\ShippingCost;
use App\Support\Cost\Contract\CostInterface;
use App\Support\Basket\BasketAtViews;

class CheckoutController extends Controller {
    private $basketAtViews;
    private $cost;


    public function checkoutForm(Request $request) {
        $totalCost = $request->query('total_cost', 0);
        return view('frontend.checkout', ['totalCost' => $totalCost]);
    }

    public function __construct(BasketAtViews $basketAtViews, CostInterface $cost) {
        $this->basketAtViews = $basketAtViews;
        $this->cost = $cost;
    }

    public function processCheckout(Request $request) {
        Log::info('API processCheckout called');
        Log::info('Request data:', $request->all());

        // Validate the request
        $request->validate([
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Get the total cost including shipping
        $totalCost = $this->calculateTotalCost($request->products, $request->quantities);
        $shippingCost = new ShippingCost($this->cost);
        $totalCostWithShipping = $totalCost + $shippingCost->getCost();

        // Create the order
        $order = $this->createOrder($totalCostWithShipping, 'Pending', 'Pending');

        // Attach products to the order
        foreach ($request->products as $productId) {
            $quantity = $request->quantities[$productId];
            $order->products()->attach($productId, ['quantity' => $quantity]);
        }

        // Clear the user's cart
        $this->clearCart($user);

        // Return a JSON response with a redirect URL
        return response()->json([
            'message' => 'Order placed successfully',
            'order_id' => $order->id,
            'total_cost' => $totalCostWithShipping,
            'redirect' => route('api.checkout.index', ['total_cost' => $totalCostWithShipping])
        ], 200);
    }

    private function calculateTotalCost($productIds, $quantities) {
        $totalCost = 0;
        foreach ($productIds as $productId) {
            $product = Product::find($productId);
            $quantity = $quantities[$productId];
            $totalCost += $product->price * $quantity;
        }
        return $totalCost;
    }

    private function createOrder($totalCost, $status, $shipping) {
        Log::info('Creating order for user: ' . Auth::user()->id . ' with total cost: ' . $totalCost);

        // Create a new order
        return Order::create([
            'customer_id' => Auth::user()->id,
            'price' => $totalCost,
            'date_placed' => Carbon::now(),
            'status' => $status,
            'shipping' => $shipping,
        ]);
    }

    private function clearCart($user) {
        Log::info('Clearing cart'); // Debugging log
        $this->basketAtViews->clear(); // Assuming you have a clear method in BasketAtViews
    }
}