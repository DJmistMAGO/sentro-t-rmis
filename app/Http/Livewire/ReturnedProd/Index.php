<?php

namespace App\Http\Livewire\ReturnedProd;

use Livewire\Component;
use App\Models\ReturnProdInfo;

class Index extends Component
{
    public function render()
    {
        $returnedProdInfo = ReturnProdInfo::get();

        return view('livewire.returned-prod.index', compact('returnedProdInfo'));
    }
}
