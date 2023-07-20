@extends('layouts.user_type.auth')

@section('content')
<div class="row">
    <div class="card col-md-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">
                <h5>RETURNED PRODUCT</h5>
            </div>
            <div class="card-tool d-flex justify-content-end">
                <div class="col-md-5 me-2">
                    <input type="text" placeholder="Search..." class="form-control form-control-sm">
                </div>
                <a href="{{ route('returned-product.create') }}" class="btn btn-sm bg-gradient-info">Add New Product</a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Brand</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="../assets/img/prd.webp" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">test product</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-sm">test product</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="mb-0 text-sm">test product</p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="mb-0 text-sm">test product</p>
                                </td>
                                <td class="align-middle d-flex justify-content-center">
                                    <div>
                                        <button class="btn btn-sm btn-warning mb-0">Restock</button>
                                        <button class="btn btn-sm btn-success mb-0 mx-1">View</button>
                                        <button class="btn btn-sm btn-danger mb-0">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
