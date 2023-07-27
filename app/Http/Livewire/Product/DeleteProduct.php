<?php

namespace App\Http\Livewire\Product;

use App\Models\Product as ModelProduct;
use Livewire\Component;

class DeleteProduct extends Component
{
    protected $listeners = ['delete'];
    public $product;

    public function deleteConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'id' => $this->product->id,
            'message' => 'Are you sure?',
        ]);
    }

    public function delete($id)
    {
        $product = ModelProduct::where('id', $id)->first();
        if ($product != null) {
            $product->delete();
            return redirect()->route('product.index');
        }
        return redirect()->route('product.index')->with('error', 'Something went wrong');
    }

    public function render()
    {
        return view('livewire.product.delete-product');
    }
}
