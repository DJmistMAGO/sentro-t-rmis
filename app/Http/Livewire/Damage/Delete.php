<?php

namespace App\Http\Livewire\Damage;

use Livewire\Component;
use App\Models\DamageProdInfo;
use App\Models\DamageProduct;
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
        $prodPurInfo = DamageProdInfo::find($id);

        if ($prodPurInfo) {
            $product_items = DamageProduct::where('damage_prod_info_id', $id)->get();

            foreach ($product_items as $product_item) {
                $product = Product::find($product_item->product_id);

                if ($product) {
                    $product->update([
                        'quantity' => $product->quantity + $product_item->quantity,
                    ]);
                }
            }

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
