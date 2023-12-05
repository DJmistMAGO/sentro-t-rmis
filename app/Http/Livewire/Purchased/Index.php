<?php

namespace App\Http\Livewire\Purchased;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\PurchaseProductInfo;
use PhpOffice\PhpWord\TemplateProcessor;

class Index extends Component
{

    public $from;
    public $to;
    public $selectedDay;
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

        if ($this->selectedDay == "today") {
            $purchasedProducts = PurchaseProductInfo::with('purchasedProducts')->where('date_preparation', now()->format('Y-m-d'))->get();

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
                    $templateProcessor->setValue('date#' . ($key + 1), $transaction->date_preparation->format('Y-m-d'));
                    $total = $transaction->purchasedProducts->sum('total');
                    $templateProcessor->setValue('total_transaction#' . ($key + 1), number_format($total, 2));
                    $totalAll += $total;
                }

                $templateProcessor->setValue('total', number_format($totalAll, 2));

                $templateProcessor->setValue('date', date('Y-m-d'));
                $templateProcessor->setValue('user', auth()->user()->name);



                $filename = 'Sales';
                $tempPath = 'reports/' . $filename . '.docx';

                if (!file_exists(storage_path('reports'))) {
                    mkdir(storage_path('reports'), 0777, true);
                }

                $templateProcessor->saveAs(storage_path($tempPath));
                return response()->download(storage_path($tempPath));
            }
        } else if ($this->selectedDay == "week") {
            $purchasedProducts = PurchaseProductInfo::with('purchasedProducts')->whereRaw('WEEK(date_preparation) = ' . date('W'))->get();

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
                    $templateProcessor->setValue('date#' . ($key + 1), $transaction->date_preparation->format('Y-m-d'));
                    $total = $transaction->purchasedProducts->sum('total');
                    $templateProcessor->setValue('total_transaction#' . ($key + 1), number_format($total, 2));
                    $totalAll += $total;
                }

                $templateProcessor->setValue('total', number_format($totalAll, 2));

                $templateProcessor->setValue('date', date('Y-m-d'));
                $templateProcessor->setValue('user', auth()->user()->name);



                $filename = 'Sales';
                $tempPath = 'reports/' . $filename . '.docx';

                if (!file_exists(storage_path('reports'))) {
                    mkdir(storage_path('reports'), 0777, true);
                }

                $templateProcessor->saveAs(storage_path($tempPath));
                return response()->download(storage_path($tempPath));
            }
        }
        else if($this->selectedDay == "month")
        {
            $purchasedProducts = PurchaseProductInfo::with('purchasedProducts')->whereMonth('date_preparation', now('m'))->get();

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
                    $templateProcessor->setValue('date#' . ($key + 1), $transaction->date_preparation->format('Y-m-d'));
                    $total = $transaction->purchasedProducts->sum('total');
                    $templateProcessor->setValue('total_transaction#' . ($key + 1), number_format($total, 2));
                    $totalAll += $total;
                }

                $templateProcessor->setValue('total', number_format($totalAll, 2));

                $templateProcessor->setValue('date', date('Y-m-d'));
                $templateProcessor->setValue('user', auth()->user()->name);



                $filename = 'Sales';
                $tempPath = 'reports/' . $filename . '.docx';

                if (!file_exists(storage_path('reports'))) {
                    mkdir(storage_path('reports'), 0777, true);
                }

                $templateProcessor->saveAs(storage_path($tempPath));
                return response()->download(storage_path($tempPath));
            }
        }
        else if($this->selectedDay == "year")
        {
            $purchasedProducts = PurchaseProductInfo::with('purchasedProducts')->whereYear('date_preparation', now('Y'))->get();

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
                    $templateProcessor->setValue('date#' . ($key + 1), $transaction->date_preparation->format('Y-m-d'));
                    $total = $transaction->purchasedProducts->sum('total');
                    $templateProcessor->setValue('total_transaction#' . ($key + 1), number_format($total, 2));
                    $totalAll += $total;
                }

                $templateProcessor->setValue('total', number_format($totalAll, 2));

                $templateProcessor->setValue('date', date('Y-m-d'));
                $templateProcessor->setValue('user', auth()->user()->name);



                $filename = 'Sales';
                $tempPath = 'reports/' . $filename . '.docx';

                if (!file_exists(storage_path('reports'))) {
                    mkdir(storage_path('reports'), 0777, true);
                }

                $templateProcessor->saveAs(storage_path($tempPath));
                return response()->download(storage_path($tempPath));
            }
        }
        else
        {
            $purchasedProducts = PurchaseProductInfo::with('purchasedProducts')->whereBetween('date_preparation', [$this->from, $this->to])->get();

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
                    $templateProcessor->setValue('date#' . ($key + 1), $transaction->date_preparation->format('Y-m-d'));
                    $total = $transaction->purchasedProducts->sum('total');
                    $templateProcessor->setValue('total_transaction#' . ($key + 1), number_format($total, 2));
                    $totalAll += $total;
                }

                $templateProcessor->setValue('total', number_format($totalAll, 2));

                $templateProcessor->setValue('date', date('Y-m-d'));
                $templateProcessor->setValue('user', auth()->user()->name);

                $filename = 'Sales';
                $tempPath = 'reports/' . $filename . '.docx';

                if (!file_exists(storage_path('reports'))) {
                    mkdir(storage_path('reports'), 0777, true);
                }

                $templateProcessor->saveAs(storage_path($tempPath));
                return response()->download(storage_path($tempPath));
            }
        }
        session()->flash('message', 'Please select a date.');
    }
}
