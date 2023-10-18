<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $products = Product::orderBy('quantity', 'asc')->get();

        $near_end = $products->filter(function ($product) {
            return $product->quantity <= 10;
        });

        $near_end_count = $near_end->count();

        return view('livewire.stock.index', compact('products', 'near_end_count'));
    }
}
