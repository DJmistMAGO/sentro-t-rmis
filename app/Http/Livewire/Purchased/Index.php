<?php

namespace App\Http\Livewire\Purchased;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\PurchaseProductInfo;
use PhpOffice\PhpWord\TemplateProcessor;

class Index extends Component
{

    public $dateInput;
    public $path_export = 'docx/stms.docx';

    public function render(Request $request)
    {
        $search = $request->input('search');
        $query = PurchaseProductInfo::with('purchasedProducts')->orderBy('reference_no', 'desc');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('reference_no', 'like', '%' . $search . '%')
                    ->orWhere('prepared_by', 'like', '%' . $search . '%')
                    ->orWhere('date_preparation', 'like', '%' . $search . '%');
            });
        }

        $purchaseProdInfo = $query->paginate(7);

        // group all the data by date
        $groupedDate = $purchaseProdInfo->groupBy(function ($item) {
            return $item->date_preparation;
        });

        // dd($groupedDate);

        return view('livewire.purchased.index', compact('purchaseProdInfo', 'groupedDate'));
    }

    public function exportPurchasedProducts()
    {

        $path = storage_path($this->path_export);
        $templateProcessor = new TemplateProcessor($path);

        $purchasedProducts = PurchaseProductInfo::with('purchasedProducts')->where('date_preparation', $this->dateInput)->get();

        if ($purchasedProducts->isEmpty()) {
            session()->flash('message', 'No records found for the selected date.');
        } else {

            $count = $purchasedProducts->count();

            if ($count > 0) {
                $templateProcessor->cloneRow('reference', $count);
            }

            $totalAll = 0;

            foreach ($purchasedProducts as $key => $transaction) {
                $templateProcessor->setValue('reference#' . ($key + 1), $transaction->reference_no);

                $total = $transaction->purchasedProducts->sum('total');
                $templateProcessor->setValue('total_transaction#' . ($key + 1), number_format($total, 2));

                $totalAll += $total;
            }

            $templateProcessor->setValue('total', number_format($totalAll, 2));


            $templateProcessor->setValue('date', date('F d, Y', strtotime($this->dateInput)));
            $templateProcessor->setValue('user', auth()->user()->name);



            $filename = 'Daily-sales-' . $this->dateInput;
            $tempPath = 'reports/' . $filename . '.docx';

            if (!file_exists(storage_path('reports'))) {
                mkdir(storage_path('reports'), 0777, true);
            }

            $templateProcessor->saveAs(storage_path($tempPath));
            return response()->download(storage_path($tempPath));

            // session()->flash('message', 'Data exported successfully.');
        }
    }
}
