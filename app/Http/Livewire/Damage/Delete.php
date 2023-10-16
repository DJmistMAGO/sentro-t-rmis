<?php

namespace App\Http\Livewire\Damage;

use Livewire\Component;
use App\Models\DamageProdInfo;

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
        $prodPurInfo = DamageProdInfo::where('id', $id)->first();
        if ($prodPurInfo != null) {
            $prodPurInfo->delete();
            return redirect()->route('damaged-product.index')->with('success', 'Product record deleted successfully.');
        }
        return redirect()->route('damaged-product.index')->with('error', 'Something went wrong');
    }
    public function render()
    {
        return view('livewire.damage.delete');
    }
}
