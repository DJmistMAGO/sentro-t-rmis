@extends('layouts.guest')

@section('content')
    <div class="container-fluid my-5 d-flex justify-content-center align-items-center">
        <div class="rounded  col-xs-8 col-sm-8 col-md-4 shadow-lg p-5 bg-light">
            <div class="card-header pb-0 text-center bg-transparent g-0">
                <img src="{{ asset('images/st2.png') }}" alt="logo" class=" pb-0 mb-0" height="100">
            </div>
            <div class="card-body mt-5">
            <h6 class="text-center">Enter email and password to log in.</h6>
                <form role="form" method="POST" action="/session">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" placeholder="Email" aria-label="Email"
                            aria-describedby="email-addon">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            id="password" placeholder="Password" aria-label="Password"
                            aria-describedby="password-addon">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-75 mt-4 mb-0">Sign
                            in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
