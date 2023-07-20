@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="card col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">
                    <h5>PRODUCTS LIST</h5>
                </div>
                <div class="card-tool d-flex justify-content-end">
                    <form action="{{ route('product.index') }}" method="get">
                        <div class="col-md-10 me-2">
                            <div class="input-group input-group-sm">
                                <!-- Add the name attribute to the input field -->
                                <input type="text" name="search" placeholder="Search..." class="form-control">
                                <span class="input-group-text">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('product.create') }}" class="btn btn-sm bg-gradient-info">Add New Product</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Description</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Quantity</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ asset('images/st1.png') }}" class="avatar avatar-sm me-3"
                                                        alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $product->product_name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="mb-0 text-sm">
                                            {{ $product->description }}
                                        </td>
                                        <td class="align-middle text-center text-sm mb-0">
                                            {{ $product->price }}
                                        </td>
                                        <td class="align-middle text-center text-sm mb-0">
                                            {{ $product->quantity }}
                                        </td>
                                        <td class="align-middle d-flex justify-content-center">
                                            <button class="btn btn-sm btn-warning">Restock</button>
                                            <button class="btn btn-sm btn-success ms-1 me-1">View</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Products Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
