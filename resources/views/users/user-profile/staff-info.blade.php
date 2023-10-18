@extends('layouts.app')

@section('content')
    <div>
        <div class="container-fluid py-4 pt-0">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Profile Information</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user-management.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Full Name') }}</label>
                                    <input class="form-control @error('name') is-invalid @enderror"
                                        value="{{ $user->name }}" type="text" placeholder="Juan Dela Cruz"
                                        id="" name="name">
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
                                        value="{{ $user->birthdate->format('Y-m-d') }}" type="date"
                                        placeholder="juancruz@example.com" id="" name="birthdate">
                                    @error('birthdate')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Email') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror"
                                        value="{{ $user->email }}" type="email" placeholder="juancruz@example.com"
                                        id="" name="email">
                                    @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Phone No.') }}</label>
                                    <input class="form-control @error('contact_no') is-invalid @enderror" type="tel"
                                        placeholder="09123123122" id="number" name="contact_no"
                                        value="{{ $user->contact_no }}">
                                    @error('contact_no')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">{{ __('Location') }}</label>
                                    <input class="form-control @error('address') is-invalid @enderror" type="text"
                                        placeholder="Barangay, City/Town, Province" id="name" name="address"
                                        value="{{ $user->address }}">
                                    @error('address')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-primary btn-md mt-4 mb-4">UPDATE PROFILE
                                INFORMATION</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
