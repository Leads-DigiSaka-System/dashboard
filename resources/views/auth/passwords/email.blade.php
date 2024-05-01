@extends('layouts.auth')
@section('content')
 <div class="login_bg d-flex justify-content-center align-items-center">
        <div class="d-flex col-lg-5 align-items-center auth-bg px-2 p-lg-5 ">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto px-4">
                <div class="card1 p-4">
                    <div class="card-body login">
                      <!--   <img src="{{ asset('employer/images/logo.png') }}" style="height: 45px"> -->
                         @if (session('status'))

                        <div class="alert alert-success" role="alert">

                            {{ session('status') }}

                        </div>

                    @endif




                    <form method="POST" action="{{ route('password.email') }}">

                        @csrf



                        <h2 class="card-title fw-bold mb-1">Reset Password</h2>
            <p class="card-text mb-2">Please reset password your account and start the adventure</p>
                        <div class="form-group">

                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                             <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                     @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>
                        <div class="col-md-12">

                                <button type="submit" class="btn btn-primary w-100 mt-2 py-1">

                                    {{ __('Send Password Reset Link') }}

                                </button>

                            </div>

                        </div>

                    </form>
                    </div>
                </div>
                   </div>
        </div>
    </div>
@endsection
