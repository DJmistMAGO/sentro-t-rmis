@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="card">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <div class="card-title">
                            <h5 class="text-uppercase">Product Information</h5>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="product_name"
                                        class="form-control @error('product_name') is-invalid @enderror" required
                                        placeholder="Enter Product name">
                                </div>
                                @error('product_name')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <div class="form-group">
                                    <label class="form-label">Product Code</label>
                                    <input type="text" name="product_code"
                                        class="form-control @error('product_code') is-invalid @enderror" required
                                        placeholder="Enter Product Code (e.g., STRIMS_001)">
                                </div>
                                @error('product_code')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <div class="form-group">
                                    <label class="form-label">Product Description <span
                                            class="text-info font-italic">(Optional)</span></label>
                                    <input type="text" name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Enter Product Description">
                                </div>
                                @error('description')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-control @error('category') is-invalid @enderror"
                                        required>
                                        <option value="">--Please Select--</option>
                                        <option value="Cat 1">Category Sample 1</option>
                                        <option value="Cat 2">Category Sample 2</option>
                                        <option value="Cat 3">Category Sample 3</option>
                                        <option value="Cat 4">Category Sample 4</option>
                                    </select>
                                </div>
                                @error('category')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Product Price</label>
                                        <input type="number" step="0.01" min="1" name="price"
                                            class="form-control @error('price') is-invalid @enderror" required
                                            placeholder="0.00">
                                    </div>
                                    @error('price')
                                        <span class="error invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Product Quantity</label>
                                        <input type="number" name="qty" step="0.01" min="1"
                                            class="form-control @error('quantity') is-invalid @enderror" required
                                            placeholder="1">
                                    </div>
                                    @error('quantity')
                                        <span class="error invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror"
                                        value="{{ old('image') }}" id="image" required>
                                    <img src="" alt="" id="preview" class="img-fluid img-thumbnail">
                                </div>
                                @error('image')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-md-12 d-flex justify-content-end">
                        {{-- <a href="{{ url('product') }}" class="btn btn-danger me-2 col-md-2">Cancel</a> --}}
                        <button class="btn btn-info col-md-2" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
