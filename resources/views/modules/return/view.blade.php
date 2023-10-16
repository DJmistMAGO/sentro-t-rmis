@extends('layouts.app')
@livewireStyles()

@section('content')
    <form method="POST">
        @csrf
        {{-- @method('PUT') --}}
        <div class="row">
            <div class="col-md-12 mb-2">
                <x-card title="Returned Product Information" :back-url="route('returned-product.index')">
                    {{-- <div class="card-body pt-0"> --}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Reference No.</label>
                            <input type="text" name="reference_no" value="{{ $purchased->reference_no }}" readonly
                                class="form-control @error('reference_no') is-invalid @enderror" placeholder="">
                            @error('reference_no')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Prepared by</label>
                            <input type="text" name="prepared_by" value="{{ $purchased->prepared_by }}" readonly
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
                                value="{{ $purchased->date_preparation->format('Y-m-d') }}" readonly
                                class="form-control @error('date_preparation') is-invalid @enderror">
                            @error('date_preparation')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    {{-- </div> --}}
                </x-card>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1">
                <x-card title="Returned Items" data-item-container>
                    {{-- <button type="button" class="btn btn-primary mb-3" data-add-item>Add new item</button> --}}
                    @foreach ($purchased->returnProducts as $product)
                        <div class="row border rounded-sm border-primary pt-3 m-1" {{ $loop->first ? 'data-parent' : '' }}>
                            <input type="hidden" name="productId[]" value="{{ $product->id }}">
                            <div class="form-group col-md-6">
                                <label>Select Product.</label>
                                <select name="product_name[]" disabled
                                    class="form-control @error('product_name.0') is-invalid @enderror">
                                    <option value="">Please Select</option>
                                    @foreach ($products as $pd)
                                        <option value="{{ $pd->id }}" data-quantity="{{ $pd->quantity }}"
                                            @selected($product->product_id == $pd->id)>
                                            {{ $pd->product_code . ' - ' . $pd->product_name . ' - Php. ' . $pd->price }}
                                        </option>
                                    @endforeach
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
                                    <input type="number" min="1" step="0.01" name="quantity[]" readonly
                                        value="{{ $product->quantity }}"
                                        class="form-control @error('quantity.0') is-invalid @enderror">
                                    {{-- <button type="button" id="button-addon2"
                                        class="btn btn-outline-danger mb-0 input-group-append {{ $loop->first ? 'd-none' : '' }}"
                                        data-item-hide data-remove-item><span class="fa fa-trash"></span></button> --}}
                                    @error('quantity.0')
                                        <div class="invalid-feedback" style="display: inline-block !important;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <x-slot:footer>
                        <button type="submit" class="btn btn-info col-md-4">Create</button>
                    </x-slot:footer> --}}
                </x-card>
            </div>
        </div>
    </form>
@endsection

{{-- @livewireScripts() --}}
@push('scripts')
    <script>
        $(document).ready(function() {
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
