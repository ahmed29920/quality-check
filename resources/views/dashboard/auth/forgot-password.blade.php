@extends('dashboard.layouts.auth')

@section('content')
    <div class="page-header min-vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-8">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-bolder text-info text-gradient">Forgot Password?</h3>
                            <p class="mb-0">Enter your email address and we'll send you a password reset link.</p>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{ route('forgot-password.send') }}" method="post">
                                @csrf

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <label>Email Address</label>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email address"
                                        aria-label="Email" value="{{ old('email') }}" aria-describedby="email-addon">
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Send Reset Link</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-sm mx-auto">
                                Remember your password?
                                <a href="{{ route('login') }}" class="text-info text-gradient font-weight-bold">Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                        <div class="oblique-image  position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                            style="background-image:url('{{ asset('dashboard/img/logo.png') }}');background-size: contain;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
