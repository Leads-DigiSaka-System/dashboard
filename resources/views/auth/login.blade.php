@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
    <!-- Login-->

    <div class="login_bg d-flex justify-content-center align-items-center">
        <div class="row col-lg-8 align-items-center auth-bg px-2 p-lg-5">
            <!-- Login Section -->
            <div class="col-lg-5 px-4">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto px-4">
                    <h2 class="card-title fw-bold mb-1">Welcome to {{ config('app.name') }}</h2>
                    <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                    <form class="auth-login-form mt-2" method="post" action="{{ url('/login') }}">
                        @csrf
                        <div class="mb-1">
                            <label class="form-label" for="login-email">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}" id="login-email"
                                placeholder="Enter your email or employee Id"
                                class="form-control @error('email') is-invalid error @enderror">
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <div
                                class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                                <input type="password" name="password" id="login-password" placeholder="Enter Your Password"
                                    class="form-control form-control-merge @error('password') is-invalid error @enderror">
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                @if (session('error_message'))
                                    <span class="error invalid-feedback"
                                        style="display: block;">{{ session('error_message') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check d-flex justify-content-between align-items-center">
                                <span>
                                    <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                                    <label class="form-check-label" for="remember-me"> Remember Me</label>
                                </span>
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 mt-2 py-1" tabindex="4" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
            <!-- Webinars Section -->
            <div class="col-lg-7">
                <div class="tab-pane fade show" id="content13" style="padding-right: 10px;">
                    <!-- Card for Webinars Section -->
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <h2 class="">Webinars</h2>
                            <div class="row">
                                @foreach ($webinars as $webinar)
                                    <div class="col-md-12 col-lg-6 mb-3">
                                        <div class="card rounded-3 shadow-sm">
                                            <div class="card-body">
                                                <div class="webinar-status">
                                                    @if ($webinar->status == 2)
                                                        @php
                                                            $startDate = strtotime($webinar->start_date);
                                                            $currentDate = time();
                                                        @endphp
                                                        @if ($startDate > $currentDate)
                                                            <span class="not-started">Not Started</span>
                                                            <br>
                                                            <small>Starts on: {{ date('M d, Y H:i', $startDate) }}</small>
                                                        @else
                                                            <span class="active-now">Active</span>
                                                        @endif
                                                    @elseif ($webinar->status == 1)
                                                        <span class="active-now">Active</span>
                                                    @elseif ($webinar->status == 0)
                                                        <span class="finished">Finished</span>
                                                    @endif
                                                </div>
                                                <h3 class="webinar-title">
                                                    {{ Str::limit($webinar->title, 20, '...') }}
                                                </h3>

                                                <!-- Conditionally display video or photo based on $webinar->type -->
                                                @if ($webinar->type == 0)
                                                    <!-- Display Facebook Video -->
                                                    <div id="fb-root"></div>
                                                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0">
                                                    </script>
                                                    <div class="fb-video" data-href="{{ $webinar->link }}" data-width="250"
                                                        data-show-text="false"></div>
                                                @elseif($webinar->type == 1)
                                                    <!-- Display Photo with Link -->
                                                    <a href="{{ $webinar->link }}" target="_blank">
                                                        <img src="{{ $webinar->image_source }}" alt="Webinar Photo"
                                                            style="width:100%; max-height:150px; object-fit:cover;">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </div>

    <style>
        .active-now {
            color: green;
            font-weight: bold;
        }

        .finished {
            color: red;
            font-weight: bold;
        }

        .not-started {
            color: orange;
            font-weight: bold;
        }

        .webinar-status {
            margin-bottom: 10px;
        }

        .webinar-title {
            font-size: 1.5rem;
            margin: 0;
        }

        .card {
            margin-top: 20px;
        }
    </style>
    </div>
    </div>
    <!-- /Login-->
    </div>
@endsection
