@extends('layouts.app')
@livewireStyles()

@section('content')
<form method="POST" action="{{ route('returned-product.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h6 class="">Returned Product Information</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Reference No.</label>
                            <input type="text" value="{{ $reference_no }}" name="reference_no" id="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Prepared by</label>
                            <input type="text" name="prepared_by" id="" class="form-control" placeholder="" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Date Preparation</label>
                            <input type="date" value="{{ old('date_preparation') ?? date('Y-m-d') }}" name="date_preparation" id="" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-1">
        <x-card title="Returned Items" data-item-container>
            <button type="button" class="btn btn-primary mb-3" data-add-item>Add new item</button>
                <div class="row border rounded-sm border-primary pt-3 m-1" data-parent>
                    <div class="form-group col-md-6">
                        <label>Select Product.</label>
                        <select name="product_name[]" id="" class="form-control">
                            <option value="">Please Select</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_code . ' - '. $product->product_name .' - Php. '. $product->price  }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Quantity</label>
                        <div class="input-group">
                            <input type="number" name="quantity[]" class="form-control">
                            <button class="btn btn-outline-danger mb-0 input-group-append d-none" data-item-hide data-remove-item type="button" id="button-addon2"><span class="fa fa-trash"></span></button>
                        </div>
                    </div>
                </div>
                <x-slot:footer>
                    <button type="submit" class="btn btn-info col-md-4">Create</button>
                </x-slot:footer>
            </x-card>
        </div>
    </div>
</form>
@endsection

@livewireScripts()
