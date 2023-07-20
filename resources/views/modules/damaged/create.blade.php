@extends('layouts.user_type.auth')
@livewireStyles()

@section('content')
<div class="row">
    <div class="col-md-12 mb-2">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h6 class="">Damage Product Information</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Reference No.</label>
                        <input type="text" name="" id="" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Prepared by</label>
                        <input type="text" name="" id="" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Date Preparation</label>
                        <input type="date" name="" id="" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-1">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">
                    <h6 class="">Purchased Item</h6>
                </div>
                <div class="card-tools">
                    <button class="btn btn-sm btn-primary">Add Item</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-5">
                        <label>Item Name</label>
                        <select name="" id="" class="form-control">
                            <option value="">Please Select</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Price.</label>
                        <input type="number" name="" id="" class="form-control" placeholder="">
                      </div>
                      <div class="form-group col-md-4">
                        <label>Quantity</label>
                        <input type="price" name="" id="" class="form-control" placeholder="">
                      </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{  route('purchased-product.index') }}" class="btn btn-danger me-2">Cancel</a>
                <button class="btn btn-success col-3">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@livewireScripts()
