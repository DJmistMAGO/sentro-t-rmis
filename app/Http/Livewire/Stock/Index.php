<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $products = Product::orderBy('quantity', 'asc')->get();

        return view('livewire.stock.index', compact('products'));
    }
}
