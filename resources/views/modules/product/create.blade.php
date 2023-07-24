@extends('layouts.app')

@section('content')
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12 mt-2">
                <x-card title="Create Product Record" :back-url="route('product.index')">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name"
                                    class="form-control @error('product_name') is-invalid @enderror"
                                    value="{{ old('product_name') }}" required placeholder="Enter Product name">
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
                                    value="{{ old('product_code') }}" required
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
                                <textarea rows="4" name="description" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter a brief description of the product">{{ old('description') }}</textarea>
                                @error('description')
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
                                    <option value="Cat 1">Marine and Boating Supplies</option>
                                    <option value="Cat 2">Home Improvement Materials</option>
                                    <option value="Cat 3">Pumps and Plumbing Supplies</option>
                                    <option value="Cat 4">Steel and Metal Products</option>
                                    <option value="Cat 5">Wood and Timber Products</option>
                                    <option value="Cat 5">Power Tools and Accessories</option>
                                    <option value="Cat 6">Paints and Coatings</option>
                                    <option value="Cat 7">Electrical and Lighting</option>
                                    <option value="Cat 8">Hardware and others</option>
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
                                    <label class="form-label">Product Price</label>
                                    <input type="number" step="0.01" min="1" name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}" required placeholder="0.00">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Product Quantity</label>
                                    <input type="number" name="quantity" step="0.01" min="1"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        value="{{ old('quantity') }}" required placeholder="1">
                                    @error('quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}"
                                    id="image" required>
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <img src="" alt="" id="preview" class="img-fluid img-thumbnail">
                            </div>
                        </div>
                    </div>
                    <x-slot:footer>
                        <a href="{{ route('product.index') }}" class="btn bg-gradient-danger me-2 col-md-2">Cancel</a>
                        <button class="btn bg-gradient-info col-md-2" type="submit">Submit</button>
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
@endpush
