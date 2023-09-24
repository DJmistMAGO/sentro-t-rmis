@extends('layouts.app')
@livewireStyles()

@section('content')
    <form method="POST" action="{{ route('purchased-product.store') }}" id="form101">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-2">
                <x-card title="Purchased Product Information" :back-url="route('purchased-product.index')">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Reference No.</label>
                            <input type="text" name="reference_no" value="{{ old('reference_no') }}" required
                                class="form-control @error('reference_no') is-invalid @enderror" placeholder="">
                            @error('reference_no')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Prepared by</label>
                            <input type="text" name="prepared_by" value="{{ old('prepared_by') }}" required
                                class="form-control @error('prepared_by') is-invalid @enderror" placeholder="">
                            @error('prepared_by')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Date Preparation</label>
                            <input type="date" name="date_preparation"
                                value="{{ old('date_preparation') ?? date('Y-m-d') }}" required
                                class="form-control @error('date_preparation') is-invalid @enderror">
                            @error('date_preparation')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1">
                <x-card title="Purchased Items" data-item-container>
                    <button type="button" class="btn btn-primary mb-3" data-add-item>Add new item</button>
                    <div class="row border rounded-sm border-primary pt-3 m-1" data-parent>
                        <div class="form-group col-md-6">
                            <label>Select Product.</label>
                            <select name="product_name[]" required
                                class="form-control @error('product_name.0') is-invalid @enderror">
                                <option value="">Please Select</option>
                                @forelse ($products as $product)
                                    <option value="{{ $product->id }}" data-quantity="{{ $product->quantity }}">
                                        {{ $product->product_code . ' - ' . $product->product_name . ' - Php. ' . $product->price . ' (Remaining: ' . $product->quantity . ' ' . $product->unit . ')' }}
                                    </option>
                                @empty
                                    <option value="">No Stocked Products Found</option>
                                @endforelse
                            </select>
                            @error('product_name.0')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Quantity</label>
                            <div class="input-group">
                                <input type="number" min="1" step="0.01" name="quantity[]" required
                                    class="form-control @error('quantity.0') is-invalid @enderror">
                                <button type="button" id="button-addon2"
                                    class="btn btn-outline-danger mb-0 input-group-append d-none" data-item-hide
                                    data-remove-item><span class="fa fa-trash"></span></button>
                                @error('quantity.0')
                                    <div class="invalid-feedback" style="display: inline-block !important;">
                                        {{ $message }}
                                    </div>
                                @enderror
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
@push('scripts')
    <script>
        $(document).ready(function() {

            // remove disabled attribute on create button once all required fields are filled
            $("input, select").on('input', function() {
                var empty = false;
                $('input, select').each(function() {
                    if ($(this).val() == '') {
                        empty = true;
                    }
                });

                // if empty fields found, disable the button
                if (empty) {
                    $('.btn-info').attr('disabled', 'disabled');
                    $('.btn-info').attr('title', 'Please fill out all required fields.');
                } else {
                    $('.btn-info').removeAttr('disabled');
                    $('.btn-info').removeAttr('title');
                }
            });



            // Listen for changes in the selected product
            $("select[name='product_name[]']").change(function() {
                // Get the selected product's quantity
                var selectedProduct = $(this).find(":selected");
                var productQuantity = selectedProduct.data("quantity");

                // Update the max attribute of the quantity input field
                $(this)
                    .closest(".row")
                    .find("input[name='quantity[]']")
                    .attr("max", productQuantity);
            });
        });
    </script>
@endpush
