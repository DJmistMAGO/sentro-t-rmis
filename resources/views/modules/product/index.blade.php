@extends('layouts.app')

@section('title')
    Product | Create
@endsection

@section('content')
    <x-success></x-success>
    <x-errors></x-errors>
    <div class="row">
        <div class="card bg-light col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center mb-0 bg-light">
                <div class="card-title">
                    <h5 class="d-none d-md-inline">PRODUCTS LIST</h5>
                </div>
                <div class="card-tool d-flex justify-content-end">
                    <form action="{{ route('product.index') }}" method="get">
                        <div class="col-md-10 me-2">
                            <input type="text" name="search" placeholder="Search..."
                                class="form-control form-control-sm">
                        </div>
                    </form>

                    <a href="{{ route('product.create') }}" class="btn btn-sm bg-gradient-info">
                        <span><i class="fa fa-plus" aria-hidden="true"></i></span> Add New Product</a>
                </div>
            </div>
            <div class="card-body bg-light pt-0 pb-0 pe-0">
                <div class="row">
                    <div class="table-responsive p-0 mb-0">
                        <table class="table table-sm mb-0 table-hover">
                            <thead class="thead-gray">
                                <tr>
                                    <th class="text-uppercase text-sm text-secondary font-weight-bolder opacity-10">Product
                                        Name</th>
                                    <th class="text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Product
                                        Code</th>
                                    <th class="text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Product
                                        Description</th>
                                    <th
                                        class="text-center text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Price
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Quantity</th>
                                    <th
                                        class="text-center text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="text-sm align-middle">
                                            @php
                                                $imagePath = '/img/' . $product->image;
                                            @endphp

                                            @if (file_exists(public_path($imagePath)))
                                                <img src="{{ $imagePath }}" class="avatar avatar-sm me-1" alt="img">
                                            @else
                                                <img src="{{ asset('assets/img/prd.webp') }}" class="avatar avatar-sm me-1"
                                                    alt="img">
                                            @endif
                                            {{ $product->product_name }}
                                        </td>
                                        <td class="text-sm align-middle">{{ $product->product_code }}</td>
                                        <td class="text-sm align-middle text-justify" title="{{ $product->description }}">
                                            {{ Str::words($product->description, 3, $end = '......') }}</td>
                                        <td class="text-center text-sm align-middle">{{ $product->price }}</td>
                                        <td class="text-center text-sm align-middle">{{ $product->quantity }}</td>
                                        <td class="align-middle text-center">
                                            <div class="align-middle">
                                                {{-- <button class="btn btn-sm btn-warning me-1 mb-0 px-3">Restock</button> --}}
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn bg-gradient-success btn-sm  me-1 mb-0 px-3">View</a>
                                                @livewire('product.delete-product', ['product' => $product], key($product->id))
                                            </div>
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
                        <div class="d-flex justify-content-center mb-0 mt-1">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
