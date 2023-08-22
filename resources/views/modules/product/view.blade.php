@extends('layouts.app')

@section('content')
    {{-- <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf --}}
    <div class="row">
        <div class="col-md-12 mt-2">
            <x-card title="View Product Record" :back-url="route('product.index')">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}"
                                readonly placeholder="Enter Product name">

                        </div>
                        <div class="form-group">
                            <label class="form-label">Product Code</label>
                            <input type="text" name="product_code" class="form-control"
                                value="{{ $product->product_code }}" readonly
                                placeholder="Enter Product Code (e.g., STRIMS_001)">

                        </div>
                        <div class="form-group">
                            <label class="form-label">Product Description <span
                                    class="text-info font-italic">(Optional)</span></label>
                            <textarea rows="3" name="description" class="form-control" placeholder="Enter a brief description of the product"
                                readonly>{{ $product->description }}</textarea>

                        </div>
                        <div class="form-group">
                            <label class="form-label">Supplier Info<span
                                    class="text-info font-italic">(Optional)</span></label>
                            <input type="text" name="supplier_info" class="form-control" readonly
                                value="{{ $product->supplier_info }}" placeholder="Enter Supplier Information">

                        </div>
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control" disabled>
                                <option value="">--Please Select--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}" @selected($product->category == $category)>
                                        {{ $category }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">Product Price</label>
                                <input type="number" step="0.01" min="1" name="price" class="form-control"
                                    value="{{ $product->price }}" readonly placeholder="0.00">

                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Product Quantity</label>
                                <input type="number" name="quantity" step="0.01" min="1" class="form-control"
                                    value="{{ $product->quantity }}" readonly placeholder="1">

                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Unit of Measurement</label>
                                <input type="text" name="unit" class="form-control" value="{{ $product->unit }}"
                                    readonly placeholder="(e.g., kgs, boxex, etc.)">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Image</label>
                            {{-- <input type="file" name="image" class="form-control"  value="{{ $product->image }}" id="image" readonly>
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror --}}
                            <img src="/img/{{ $product->image }}" alt="" id="preview"
                                class="img-fluid img-thumbnail height-300">
                        </div>
                    </div>
                </div>
                <x-slot:footer>
                    {{-- <a href="{{ route('product.index') }}" class="btn bg-gradient-danger me-2 col-md-2">Cancel</a> --}}
                    <a href="{{ route('product.edit', $product->id) }}"
                        class="btn bg-gradient-info me-2 col-md-2">Update</a>
                    {{-- <button class="btn bg-gradient-info col-md-2" type="submit">Update</button> --}}
                </x-slot:footer>
            </x-card>
        </div>
    </div>
    {{-- </form> --}}
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
@endpush
