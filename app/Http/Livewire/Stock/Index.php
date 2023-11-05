<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class Index extends Component
{
    public $path_export = 'docx/stocks.docx';

    public function export()
    {
        $code1 = Product::where('category', 'electrical')
        ->orderBy('quantity', 'asc')
        ->get();

        $code2 = Product::where('category', 'marine')
        ->orderBy('quantity', 'asc')
        ->get();

        $code3 = Product::where('category', 'home')
        ->orderBy('quantity', 'asc')
        ->get();

        $code4 = Product::where('category', 'pumps')
        ->orderBy('quantity', 'asc')
        ->get();

        $code5 = Product::where('category', 'steel')
        ->orderBy('quantity', 'asc')
        ->get();

        $code6 = Product::where('category', 'wood')
        ->orderBy('quantity', 'asc')
        ->get();

        $code7 = Product::where('category', 'power')
        ->orderBy('quantity', 'asc')
        ->get();

        $code8 = Product::where('category', 'paints')
        ->orderBy('quantity', 'asc')
        ->get();

        $code9 = Product::where('category', 'hardware')
        ->orderBy('quantity', 'asc')
        ->get();

        $path = storage_path($this->path_export);
        $templateProcessor = new TemplateProcessor($path);

        $templateProcessor->setValue('date', now()->format('F d, Y'));
        $templateProcessor->setValue('user', auth()->user()->name);

        $templateProcessor->cloneRow('code1', count($code1));

        foreach($code1 as $index => $code)
        {
            $templateProcessor->setValue('code1#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }

        $templateProcessor->cloneRow('code2', count($code2));

        foreach($code2 as $index => $code)
        {
            $templateProcessor->setValue('code2#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }

        $templateProcessor->cloneRow('code3', count($code3));

        foreach($code3 as $index => $code)
        {
            $templateProcessor->setValue('code3#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }

        $templateProcessor->cloneRow('code4', count($code4));

        foreach($code4 as $index => $code)
        {
            $templateProcessor->setValue('code4#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }

        $templateProcessor->cloneRow('code5', count($code5));

        foreach($code5 as $index => $code)
        {
            $templateProcessor->setValue('code5#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }

        $templateProcessor->cloneRow('code6', count($code6));

        foreach($code6 as $index => $code)
        {
            $templateProcessor->setValue('code6#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }


        $templateProcessor->cloneRow('code7', count($code7));

        foreach($code7 as $index => $code)
        {
            $templateProcessor->setValue('code7#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }


        $templateProcessor->cloneRow('code8', count($code8));

        foreach($code8 as $index => $code)
        {
            $templateProcessor->setValue('code8#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }

        $templateProcessor->cloneRow('code9', count($code9));

        foreach($code9 as $index => $code)
        {
            $templateProcessor->setValue('code9#' . ($index + 1), $code->product_code);
            $templateProcessor->setValue('name#' . ($index + 1), $code->product_name);
            $templateProcessor->setValue('qty#' . ($index + 1), $code->quantity);
        }





        $filename = 'STOCKS-' . now()->format('Y-m-d');
        $tempPath = 'reports/' . $filename . '.docx';

        $templateProcessor->saveAs($tempPath);
        return response()->download(public_path($tempPath));
    }

    public function render()
    {
        $products = Product::orderBy('quantity', 'asc')->get();

        $near_end = $products->filter(function ($product) {
            return $product->quantity <= 10;
        });

        $near_end_count = $near_end->count();

        return view('livewire.stock.index', compact('products', 'near_end_count'));
    }
}
