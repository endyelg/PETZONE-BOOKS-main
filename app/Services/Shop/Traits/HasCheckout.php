<?php

namespace App\Services\Shop\Traits;

use App\Exceptions\InvalidCost;
use App\Support\Cost\Contract\CostInterface;
use Illuminate\Support\Facades\Log;

trait HasCheckout {
    public function validationCost(CostInterface $cost) {
        Log::info('Validating cost'); // Debugging log

        $totalCost = $cost->getTotalCost();
        Log::info('Total cost: ' . $totalCost); // Debugging log

        if ($totalCost <= 0) {
            Log::error('Invalid cost: ' . $totalCost); // Debugging log
            throw new InvalidCost('Invalid Cost!');
        }
    }
}