@extends('layouts.app')

@section('title')
    Product | Create
@endsection

@section('content')
    <x-success></x-success>
    <x-errors></x-errors>
    <div class="row">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center ">
                <h5 class="mb-0 text-uppercase">PRODUCTS LIST</h5>
                <div class="card-tool d-flex justify-content-end align-items-center align-middle">
                    <form action="{{ route('product.index') }}" method="get">
                        @csrf
                        <div class="form-group pt-3">
                            <input class="form-control form-control-sm d-none d-md-block me-3" type="search"
                                autocomplete="off" autofocus placeholder="Search..." name="search" style="width: 300px;">
                        </div>
                    </form>

                    <a href="{{ route('product.create') }}" class="btn btn-sm bg-gradient-info mb-0 align-middle">
                        <span><i class="fa fa-plus me-1" aria-hidden="true"></i></span> Add New Product</a>
                </div>
            </div>
            <div class="card-body p-3">
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
                                    <th class="text-uppercase  text-sm text-secondary font-weight-bolder opacity-10">
                                        Description</th>
                                    <th
                                        class="text-center text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Price
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Quantity</th>
                                    {{-- <th
                                        class="text-center text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Unit</th> --}}
                                    <th
                                        class="text-center text-uppercase text-sm text-secondary font-weight-bolder opacity-10">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="">
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
                                        <td class="text-sm text-center align-middle">{{ $product->product_code }}</td>
                                        <td class="text-sm text-center  align-middle" title="{{ $product->description }}">
                                            @if ($product->description == null)
                                                <span class="text-muted">No description</span>
                                            @endif
                                            {{ Str::words($product->description, 5, $end = '...') }}
                                        </td>
                                        <td class="text-center text-sm align-middle">{{ $product->price }}</td>
                                        <td class="text-center text-sm align-middle">{{ $product->quantity }}</td>
                                        {{-- <td class="text-center text-sm align-middle">{{ $product->unit }}</td> --}}
                                        <td class="align-middle text-center">
                                            <div class="align-middle">
                                                <button type="button" class="btn btn-sm bg-gradient-warning me-1 mb-0 px-3"
                                                    title="Delete" data-bs-toggle="modal"
                                                    data-bs-target="#confirmationModal{{ $product->id }}">
                                                    Restock
                                                </button>
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    class="btn bg-gradient-success btn-sm  me-1 mb-0 px-3">View</a>
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn bg-gradient-primary btn-sm  me-1 mb-0 px-3">Edit</a>
                                                @livewire('product.delete-product', ['product' => $product], key($product->id))

                                            </div>

                                        </td>
                                    </tr>
                                    <div class="modal fade" id="confirmationModal{{ $product->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true"
                                        data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-static">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmationModalLabel">Restock
                                                        {{ $product->product_name }}
                                                    </h5>
                                                    </button>
                                                </div>
                                                <form action="{{ route('product.restock', [$product->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body mt-2 mb-2">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Input Quantity</label>
                                                            <input type="number" name="restock" id=""
                                                                min="1" class="form-control text-end" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">Restock</button>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
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
