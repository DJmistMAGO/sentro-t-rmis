<?php

namespace App\Http\Livewire\Purchased;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\PurchaseProductInfo;

class Index extends Component
{
    public function render(Request $request)
    {
        $search = $request->input('search');

        // Start with the Eloquent model and apply the necessary conditions.
        $query = PurchaseProductInfo::with('purchasedProducts')->orderBy('reference_no', 'asc');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('reference_no', 'like', '%' . $search . '%')
                    ->orWhere('prepared_by', 'like', '%' . $search . '%')
                    ->orWhere('date_preparation', 'like', '%' . $search . '%');
            });
        }

        $purchaseProdInfo = $query->paginate(7);

        return view('livewire.purchased.index', compact('purchaseProdInfo'));
    }
}
