@extends('layouts.app')
@livewireStyles()

@section('content')
    <form method="POST" action="{{ route('purchased-product.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-2">
                <x-card title="Purchased Product Information" :back-url="route('purchased-product.index')">
                    {{-- <div class="card-body pt-0"> --}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Reference No.</label>
                            <input type="text" name="reference_no" value="{{ old('reference_no') }}" id=""
                                class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Prepared by</label>
                            <input type="text" name="prepared_by" value="{{ old('prepared_by') }}" id=""
                                class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Date Preparation</label>
                            <input type="date" name="date_preparation" value="{{ old('date_preparation') }}"
                                id="" class="form-control" placeholder="">
                        </div>
                    </div>
                    {{-- </div> --}}
                </x-card>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1">
                <x-card title="SKCC Items" data-item-container>
                    {{-- <button type="button" class="btn btn-primary mb-3" data-add-item>Add new item</button> --}}
                    <div class="row border rounded-sm border-primary pt-3 m-1" data-parent>
                        <div class="form-group col-md-6">
                            <label>Select Product.</label>
                            <select name="prod[]" class="form-control">
                                <option value="">Please Select</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @selected(old('prod.0') == $product->id)>
                                        {{ $product->product_code . ' - ' . $product->product_name . ' - Php. ' . $product->price }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Quantity</label>
                            <div class="input-group">
                                <input type="number" name="qty[]" required class="form-control" step="0.01"
                                    min="1" value="{{ old('qty.0') }}">
                                <button class="btn btn-danger mb-0 input-group-append d-none" title="DELETE" data-item-hide
                                    data-remove-item type="button" id="button-addon2"><span
                                        class="fa fa-trash"></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3" data-button-container>
                        <button type="button" class="btn btn-primary" data-add-item>Add new Item</button>
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
