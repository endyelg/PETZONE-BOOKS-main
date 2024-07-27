<?php 

namespace App\Http\Controllers\Shop;

use App\Exceptions\InvalidCost;
use App\Http\Controllers\Controller;
use App\Services\Shop\Traits\HasCheckout;
use Illuminate\Http\Request;
use App\Support\Basket\BasketAtViews;
use App\Support\Cost\Contract\CostInterface;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade
use Carbon\Carbon; // Import Carbon for date handling

class CheckoutController extends Controller {
    use HasCheckout;

    protected $basketAtViews;
    protected $cost;

    public function __construct(BasketAtViews $basketAtViews, CostInterface $cost) {
        $this->basketAtViews = $basketAtViews;
        $this->cost = $cost;
    }

    /**
     * Show checkout form 
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkoutForm(Request $request) {
        $totalCost = $request->query('total_cost', 0);
        return view('frontend.checkout', ['totalCost' => $totalCost]);
    }

    /**
     * Process checkout and create order
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processCheckout(Request $request) {
        Log::info('processCheckout called'); // Debugging log

        // Validate the total cost before creating the order and clearing the cart
        try {
            $this->validationCost($this->cost);
        } catch (InvalidCost $event) {
            Log::error('Invalid cost during processCheckout: ' . $event->getMessage()); // Debugging log
            return redirect()->route('shop.basket.index')->with('error', $event->getMessage());
        }

        // Get the total cost
        $totalCost = $this->cost->getTotalCost();

        // Create the order with status and shipping
        $order = $this->createOrder($totalCost, $request->input('status'), $request->input('shipping'));

        // Clear the cart
        $this->clearCart();

        // Store the total cost in the session
        $request->session()->put('totalCost', $totalCost);

        // Redirect to the checkout form to display the checkout page
        Log::info('Redirecting to checkout form'); // Debugging log
        return redirect()->route('shop.checkout.index');
    }

    private function clearCart() {
        Log::info('Clearing cart'); // Debugging log
        $this->basketAtViews->clear(); // Assuming you have a clear method in BasketAtViews
    }

    private function createOrder($totalCost, $status, $shipping) {
        $user = Auth::user();

        Log::info('Creating order for user: ' . $user->id . ' with total cost: ' . $totalCost); // Debugging log

        // Create a new order
        $order = Order::create([
            'customer_id' => $user->id,
            'price' => $totalCost,
            'date_placed' => Carbon::now(), // Add the current timestamp
            'status' => $status, // Added status
            'shipping' => $shipping, // Added shipping
        ]);

        // Attach products to the order
        $products = $this->basketAtViews->giveSelectedProducts();
        foreach ($products as $product) {
            $order->products()->attach($product['id']);
        }

        return $order;
    }
}