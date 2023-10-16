<?php

namespace App\Http\Livewire\ReturnedProd;

use Livewire\Component;
use App\Models\ReturnProdInfo;

class Delete extends Component
{
    protected $listeners = ['delete'];
    public $prodPurInfo;

    public function deleteConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'id' => $this->prodPurInfo->id,
            'message' => 'Are you sure?',
        ]);
    }

    public function delete($id)
    {
        $prodPurInfo = ReturnProdInfo::where('id', $id)->first();
        if ($prodPurInfo != null) {
            $prodPurInfo->delete();
            return redirect()->route('purchased-product.index')->with('success', 'Product record deleted successfully.');
        }
        return redirect()->route('purchased-product.index')->with('error', 'Something went wrong');
    }

    public function render()
    {
        return view('livewire.returned-prod.delete');
    }
}
