<?php

namespace App\Http\Livewire\Purchased;

use Livewire\Component;
use App\Models\PurchaseProductInfo;

class Index extends Component
{
    public function render()
    {

        $purchaseProdInfo = PurchaseProductInfo::with('purchasedProducts')->paginate(10);
        // dd($purchaseProdInfo);

        return view('livewire.purchased.index', compact('purchaseProdInfo'));
    }
}
