<?php

namespace App\Http\Livewire\ReturnedProd;

use Livewire\Component;
use App\Models\ReturnProdInfo;
use App\Models\ReturnProduct;
use App\Models\Product;

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
        $prodPurInfo = ReturnProdInfo::find($id);

        if ($prodPurInfo) {
            $product_items = ReturnProduct::where('return_prod_info_id', $id)->get();

            foreach ($product_items as $product_item) {
                $product = Product::find($product_item->product_id);

                if ($product) {
                    $product->update([
                        'quantity' => $product->quantity - $product_item->quantity,
                    ]);
                }
            }

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
