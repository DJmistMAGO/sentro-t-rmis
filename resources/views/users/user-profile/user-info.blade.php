@extends('layouts.app')

@section('content')
    <div>
        <div class="container-fluid py-4 pt-0">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Profile Information</h6>
                    <x-success></x-success>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user-management.profile-update') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Full Name') }}</label>
                                    <input class="form-control @error('name') is-invalid @enderror"
                                        value="{{ auth()->user()->name }}" type="text" placeholder="Juan Dela Cruz"
                                        name="name">
                                    @error('name')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Birthdate') }}</label>
                                    <input class="form-control @error('birthdate') is-invalid @enderror"
                                        value="{{ auth()->user()->birthdate->format('Y-m-d') }}" type="date"
                                        placeholder="juancruz@example.com" name="birthdate">
                                    @error('birthdate')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Email') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror"
                                        value="{{ auth()->user()->email }}" type="email"
                                        placeholder="juancruz@example.com" name="email">
                                    @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Phone No.') }}</label>
                                    <input class="form-control @error('contact_no') is-invalid @enderror" type="tel"
                                        placeholder="09123123122" id="number" name="contact_no" maxlength="11"
                                        minlength="11" pattern="[0-9]{11}" value="{{ auth()->user()->contact_no }}">
                                    @error('contact_no')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Address') }}</label>
                                    <input class="form-control @error('address') is-invalid @enderror" type="text"
                                        placeholder="Barangay, City/Town, Province" id="name" name="address"
                                        value="{{ auth()->user()->address }}">
                                    @error('address')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4 px-3">SAVE CHANGES</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Profile Information</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user-management.password-update') }}" method="POST"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Password') }}</label>
                                    <input class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="new-password" value="{{ old('password') }}" type="password"
                                        placeholder="" name="password">
                                    @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""
                                        class="form-control-label">{{ __('Confirmation Password') }}</label>
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                        autocomplete="new-password" value="{{ old('password_confirmation') }}"
                                        type="password" placeholder="" name="password_confirmation">
                                    @error('password_confirmation')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-primary btn-md mt-4 mb-4">CHANGE
                                PASSWORD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
