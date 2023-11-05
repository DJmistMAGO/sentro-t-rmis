@extends('layouts.app')

@section('content')
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12 mt-2">
                <x-card title="Update Product Record" :back-url="route('product.index')">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name"
                                    class="form-control @error('product_name') is-invalid @enderror"
                                    value="{{ $product->product_name }}" required placeholder="Enter Product name">
                                @error('product_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Product Code</label>
                                <input type="text" name="product_code"
                                    class="form-control @error('product_code') is-invalid @enderror"
                                    value="{{ $product->product_code }}" required
                                    placeholder="Enter Product Code (e.g., STRIMS_001)">
                                @error('product_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Product Description <span
                                        class="text-info font-italic">(Optional)</span></label>
                                <textarea rows="3" name="description" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter a brief description of the product">{{ $product->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Supplier Info<span
                                        class="text-info font-italic">(Optional)</span></label>
                                <input type="text" name="supplier_info"
                                    class="form-control @error('supplier_info') is-invalid @enderror"
                                    value="{{ $product->supplier_info }}" placeholder="Enter Supplier Information">
                                @error('supplier_info')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-control @error('category') is-invalid @enderror"
                                    required>
                                    <option value="">--Please Select--</option>
                                    @foreach ($categories as $value => $category)
                                        <option value="{{ $value }}" @selected($product->category == $value)>
                                            {{ $category }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Product Quantity</label>
                                    <input type="number" name="quantity" step="0.01" min="1"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        value="{{ $product->quantity }}" required placeholder="1">
                                    @error('quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Unit of Measurement</label>
                                    <input type="text" name="unit"
                                        class="form-control @error('unit') is-invalid @enderror"
                                        value="{{ $product->unit }}" required placeholder="(e.g., kgs, boxex, etc.)">
                                    @error('unit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Product Price</label>
                                    <input type="text" name="price"
                                        class="form-control text-end @error('price') is-invalid @enderror"
                                        value="{{ $product->price }}" required placeholder="0.00">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror" value="{{ $product->image }}"
                                    id="image">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <img src="/img/{{ $product->image }}" alt="" id="preview"
                                    class="img-fluid img-thumbnail height-300">
                            </div>
                        </div>
                    </div>
                    <x-slot:footer>
                        <a href="{{ route('product.index') }}" class="btn bg-gradient-danger me-2 col-md-2">Cancel</a>
                        <button class="btn bg-gradient-info col-md-2" type="submit">Update</button>
                    </x-slot:footer>
                </x-card>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function previewImage() {
            var preview = document.querySelector('#preview');
            var file = document.querySelector('#image').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }

        var imageInput = document.querySelector('#image');
        imageInput.addEventListener('change', previewImage);
    </script>
    <script>
        const priceInput = document.querySelector('input[name="price"]');
        let cursorPosition = 0;

        priceInput.addEventListener('input', function() {
            // Get the cursor position before the input changes
            cursorPosition = this.selectionStart;

            // Remove any non-numeric characters (except dot)
            let inputValue = this.value.replace(/[^0-9.]/g, '');

            // Format as currency (PHP) with two decimal places
            inputValue = parseFloat(inputValue).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            this.value = inputValue;

            // Set the cursor position back to where it was
            this.setSelectionRange(cursorPosition, cursorPosition);
        });
    </script>
@endpush
