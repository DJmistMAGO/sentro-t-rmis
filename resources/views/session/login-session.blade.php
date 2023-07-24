@extends('layouts.user_type.guest')

@section('content')
    <main class="main-content mt-0"
        style="background-image:url('../images/login.svg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
        <section>
            <div class="page-header vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 d-flex justify-content-center mx-auto">
                            <div class="card card-plain mt-0">
                                <div class="card-header pb-0 text-center bg-transparent g-0">
                                    <img src="{{ asset('images/st2.png') }}" alt="logo" class="text- img-fluid pb-0 mb-0"
                                        height="200px">
                                    <h3 class="font-weight-bolder text-primary text-center mt-0 text-gradient mb-0">
                                        <span class="d-sm-inline d-md-none">Record Inventory Management
                                            System</span>
                                        <span class="d-none d-md-inline">Sentro Trading Record Inventory Management
                                            System</span>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="/session">
                                        @csrf
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" placeholder="Email"
                                                value="admin@sentrotrading.com" aria-label="Email"
                                                aria-describedby="email-addon">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                id="password" placeholder="Password" value="secret" aria-label="Password"
                                                aria-describedby="password-addon">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
