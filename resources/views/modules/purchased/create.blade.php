@extends('layouts.app')
{{-- @livewireStyles() --}}

@section('content')
    <form method="POST" action="{{ route('purchased-product.store') }}" id="form101" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-2">
                <x-card title="Sold Product Information" :back-url="route('purchased-product.index')">
                    {{-- <div class="card-body pt-0"> --}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Reference No.</label>
                            <input type="text" name="reference_no" value="{{ $reference_no }}" required
                                class="form-control @error('reference_no') is-invalid @enderror" readonly>
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
                <x-card title="Sold Items" data-item-container>
                    <button type="button" class="btn btn-primary mb-3" data-add-item>Add new item</button>
                    <div class="row border rounded-sm border-primary pt-3 m-1" data-parent>
                        <div class="form-group col-md-6">
                            <label>Select Product.</label>
                            <select name="product_name[]" required
                                class="form-control @error('product_name.0') is-invalid @enderror">
                                <option value="">Please Select</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-quantity="{{ $product->quantity }}"
                                        data-price="{{ $product->price }}">
                                        {{ $product->product_code . ' - ' . $product->product_name . ' - Php. ' . number_format((float) $product->price, 2) . ' (Remaining: ' . $product->quantity . ' ' . $product->unit . ')' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_name.0')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>Quantity</label>
                            <input type="number" min="0.25" step="0.25" name="quantity[]" required
                                class="form-control @error('quantity.0') is-invalid @enderror">
                            @error('quantity.0')
                                <div class="invalid-feedback" style="display: inline-block !important;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>Price</label>
                            <div class="input-group">
                                <input type="text" name="price[]" readonly
                                    class="form-control prices @error('price.0') is-invalid @enderror">
                                <button type="button" id="button-addon2"
                                    class="btn btn-outline-danger mb-0 input-group-append d-none" data-item-hide
                                    data-remove-item><span class="fa fa-trash"></span></button>
                                @error('price.0')
                                    <div class="invalid-feedback" style="display: inline-block !important;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <x-slot:footer>
                        <div class="form-group col-md-4">
                            <label>Total Price</label>
                            <div class="input-group">
                                <input type="text" id="totalPrice" readonly class="form-control">
                                <button type="submit" class="btn btn-info input-group-append mb-0">Create</button>
                            </div>
                        </div>
                    </x-slot:footer>
                </x-card>
            </div>
        </div>
    </form>
@endsection

{{-- @livewireScripts() --}}
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
            updateTotalPrice();

        });

        $(document).on("change", "[name='product_name[]']", function() {
            let _this = $(this);
            let _parent = _this.closest(".row");
            let _quantity = _parent.find("[name='quantity[]']");
            let _price = _parent.find("[name='price[]']");
            let _selectedOption = _this.find("option:selected");
            let _max = _selectedOption.attr("data-quantity");
            let _priceValue = _selectedOption.attr("data-price");
            _quantity.attr("max", _max);
            _quantity.val(1);

            let formattedPrice = number_format(_priceValue, 2);
            _price.val(formattedPrice);
            updateTotalPrice();

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
            let _price = _parent.find("[name='price[]']");
            let _selectedOption = _this.find("option:selected");
            let _max = _selectedOption.attr("data-quantity");
            let _priceValue = _selectedOption.attr("data-price");
            _quantity.attr("max", _max);
            _quantity.val(1);

            let formattedPrice = number_format(_priceValue, 2);
            _price.val(formattedPrice);
            updateTotalPrice();


            let _selectedProductId = _selectedOption.val();
            let _productList = $("[name='product_name[]']");
            _productList.each(function(index, item) {
                if (item.value == _selectedProductId) {
                    $(item).remove();
                }
            });
        }

        $(document).on("input", "[name='quantity[]']", function() {
            let _this = $(this);
            let _parent = _this.closest(".row");
            let _price = _parent.find("[name='price[]']");
            let _selectedOption = _parent.find("[name='product_name[]'] option:selected");
            let _priceValue = parseFloat(_selectedOption.attr("data-price"));
            let _quantity = _this.val();
            let _total = _priceValue * _quantity;

            // Format the total value using number_format
            let formattedTotal = number_format(_total, 2);

            _price.val(formattedTotal);
            updateTotalPrice();

        });

        // Define the number_format function
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }


        function updateTotalPrice() {
            let total = 0;
            $("input[name='price[]']").each(function() {
                let price = parseFloat($(this).val().replace(/[^\d.]/g,
                    '')); // Extract the numerical value from the input
                total += isNaN(price) ? 0 : price;
            });

            let formattedTotal = number_format(total, 2);
            $("#totalPrice").val(formattedTotal);
        }

        // Call the updateTotalPrice function whenever there's a change in item quantity or price
        $(document).on("input", "[name='quantity[]'], [name='price[]']", function() {
            updateTotalPrice();
        });
    </script>
@endpush
