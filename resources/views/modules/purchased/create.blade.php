@extends('layouts.app')
@livewireStyles()

@section('content')
    <form method="POST" action="{{ route('purchased-product.store') }}" id="form101">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-2">
                <x-card title="Purchased Product Information" :back-url="route('purchased-product.index')">
                    {{-- <div class="card-body pt-0"> --}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Reference No.</label>
                            <input type="text" name="reference_no" value="{{ $reference_no }}" required
                                class="form-control @error('reference_no') is-invalid @enderror" placeholder="">
                            @error('reference_no')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Prepared by</label>
                            <input type="text" name="prepared_by" value="{{ auth()->user()->name }}" required
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
                    {{-- </div> --}}
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
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-quantity="{{ $product->quantity }}">
                                        {{ $product->product_code . ' - ' . $product->product_name . ' - Php. ' . $product->price . ' (Remaining: ' . $product->quantity . ' ' . $product->unit . ')' }}
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
        $(document).on("click", "[data-add-item]", function() {
            let _container = $(this).closest("[data-item-container]");
            if (_container) {
                let _template = _container.find("[data-parent]").first();
                if (_template) {
                    let clone = _template.clone();
                    $(clone)
                        .find(".row")
                        .each((index, item) => {
                            let attr = $(item).attr("data-parent");
                            if (typeof attr === "undefined" || attr === false) {
                                $(item).remove();
                            }
                        });
                    if ($(clone[0]).attr("data-parent") !== undefined) {
                        $(clone[0]).removeAttr("data-parent");
                        $(clone[0])
                            .find("[data-item-hide]")
                            .first()
                            .removeClass("d-none");
                        $(clone[0])
                            .find("input, select")
                            .each(function(index, item) {
                                item.value = "";
                            });
                        _container.append($(clone[0]));
                        updateProductList(clone);
                    }
                }
            }
        });

        $(document).on("click", "[data-remove-item]", function() {
            let _parent = $(this).closest(".row");
            _parent.remove();
        });

        $(document).on("change", "[name='product_name[]']", function() {
            let _this = $(this);
            let _parent = _this.closest(".row");
            let _quantity = _parent.find("[name='quantity[]']");
            let _selectedOption = _this.find("option:selected");
            let _max = _selectedOption.attr("data-quantity");
            _quantity.attr("max", _max);
            _quantity.val(1);
        });

        function updateProductList($dropdown) {
            var selectedProducts = [];
            $("select[name='product_name[]']").not($dropdown).each(function() {
                var selectedProduct = $(this).find(":selected").val();
                if (selectedProduct) {
                    selectedProducts.push(selectedProduct);
                }
            });

            $dropdown.find("option").each(function() {
                var optionValue = $(this).val();

                // Enable or disable options based on selected products
                if (selectedProducts.includes(optionValue)) {
                    $(this).prop("disabled", true);
                } else {
                    $(this).prop("disabled", false);
                }
            });
        }

        function updateProductListAndMaxAttribute(clone) {
            let _this = $(clone).find("[name='product_name[]']");
            let _parent = _this.closest(".row");
            let _quantity = _parent.find("[name='quantity[]']");
            let _selectedOption = _this.find("option:selected");
            let _max = _selectedOption.attr("data-quantity");
            _quantity.attr("max", _max);
            _quantity.val(1);

            let _selectedProductId = _selectedOption.val();
            let _productList = $("[name='product_name[]']");
            _productList.each(function(index, item) {
                if (item.value == _selectedProductId) {
                    $(item).remove();
                }
            });
        }
    </script>
@endpush
