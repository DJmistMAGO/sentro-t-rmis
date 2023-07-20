@extends('layouts.user_type.auth')

@section('content')
<div class="row">
    <div class="col-md-6 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">
                    <h5 class="text-uppercase">Product Image</h5>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">
                    <h5 class="text-uppercase">Product Information</h5>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Product Brand</label>
                        <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Price</label>
                        <input type="number" step="any" name="" id="" class="form-control" placeholder="" aria-describedby="">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Quantity</label>
                        <input type="number" name="" id="" class="form-control" placeholder="" aria-describedby="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-footer col-md-12 d-flex justify-content-end">
            <a href="{{ url('product') }}" class="btn btn-danger me-2 col-md-3">Cancel</a>
            <button class="btn btn-info col-md-3">Submit</button>
        </div>
    </div>
</div>
@endsection
