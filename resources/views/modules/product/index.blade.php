@extends('layouts.user_type.auth')

@section('title')
    Product | Create
@endsection

@section('content')
    <x-success></x-success>
    <x-errors></x-errors>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">
                    <h5 class="d-none d-md-inline">PRODUCTS LIST</h5>
                </div>
                <div class="card-tool d-flex justify-content-end">
                    <form action="{{ route('product.index') }}" method="get">
                        <div class="col-md-10 me-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" placeholder="Search..." class="form-control">
                                <span class="input-group-text">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('product.create') }}" class="btn btn-sm bg-gradient-info">
                        <span><i class="fa fa-plus" aria-hidden="true"></i></span> Add New Product</a>
                </div>
            </div>
            <div class="card-body bg-white pt-0">
                <div class="row">
                    <div class="table-responsive p-0">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product
                                        Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Product Code
                                    </th>
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
                                        <td class="text-sm align-middle">
                                            <img src="/img/{{ $product->image }}" class="avatar avatar-sm me-3"
                                                alt="user1">
                                            {{ $product->product_name }}
                                        </td>
                                        <td class="text-sm align-middle">{{ $product->product_code }}</td>
                                        <td class="text-center text-sm align-middle">{{ $product->price }}</td>
                                        <td class="text-center text-sm align-middle">{{ $product->quantity }}</td>
                                        <td class="d-flex justify-content-center align-middle">
                                            <button class="btn btn-sm btn-warning me-1 px-3">Restock</button>
                                            <button class="btn btn-sm btn-success me-1 px-3">View</button>
                                            <button class="btn btn-sm btn-danger px-3">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No Products found!
                                        </td>
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

@push('scripts')
    @livewireScripts()

    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
@endpush
