<?php

namespace App\Http\Livewire\Purchased;

use Livewire\Component;
use App\Models\PurchaseProductInfo;
class Index extends Component
{
    public function render()
    {
        $purchaseProdInfo = PurchaseProductInfo::get();

        return view('livewire.purchased.index', compact('purchaseProdInfo'));
    }
}
