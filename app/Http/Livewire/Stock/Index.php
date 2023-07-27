<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $products = Product::all();

        return view('livewire.stock.index', compact('products'));
    }
}
