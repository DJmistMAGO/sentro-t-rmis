@extends('layouts.app')

@section('content')
    <div>
        <div class="container-fluid py-4 pt-0">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Profile Information</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user-management.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Full Name') }}</label>
                                    <div class="@error('name')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->name }}" type="text"
                                            placeholder="Juan Dela Cruz" id="" name="name">
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Birthdate') }}</label>
                                    <div class="@error('birthdate')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->birthdate }}" type="date"
                                            placeholder="juancruz@example.com" id="" name="birthdate">
                                        @error('birthdate')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Email') }}</label>
                                    <div class="@error('email')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->email }}" type="email"
                                            placeholder="juancruz@example.com" id="" name="email">
                                        @error('email')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Phone No.') }}</label>
                                    <div class="@error('contact_no')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="tel" placeholder="09123123122" id="number"
                                            name="contact_no" value="{{ auth()->user()->contact_no }}">
                                        @error('contact_no')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Location') }}</label>
                                    <div class="@error('address') border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="text"
                                            placeholder="Barangay, City/Town, Province" id="name" name="address"
                                            value="{{ auth()->user()->address }}">
                                            @error('address')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">ADD NEW STAFF</button>
                        </div> --}}
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Profile Information</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user-management.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Password') }}</label>
                                    <div class="@error('name')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ old('password') }}" type="password"
                                            placeholder="" id="" name="name">
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Confirmation Password') }}</label>
                                    <div class="@error('name')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ old('password') }}" type="password"
                                            placeholder="" id="" name="name">
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-primary btn-md mt-4 mb-4">CHANGE PASSWORD</button>
                        </div>
                    </form>
                </div>
            </div> wire:
        </div>
    </div>
@endsection
