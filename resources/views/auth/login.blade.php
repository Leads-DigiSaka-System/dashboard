@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
    <!-- Login-->

    <div class="login_bg d-flex justify-content-center align-items-center" style="
    width: 60%;
    margin: 100px auto 0;">
        <div class="row col-lg-8 align-items-center auth-bg px-2 p-lg-5">
            <!-- Login Section -->
            <div class="col-lg-12 px-4">
                <h2 class="card-title fw-bold mb-1">Welcome to {{ config('app.name') }}</h2>
                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                <form class="auth-login-form mt-2" method="post" action="{{ url('/login') }}">
                    @csrf
                    <div class="mb-1">
                        <label class="form-label" for="login-email">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" id="login-email"
                            placeholder="Enter your email or employee Id"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                            <input type="password" name="password" id="login-password" placeholder="Enter Your Password"
                                class="form-control @error('password') is-invalid @enderror">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                            @if (session('error_message'))
                                <span class="error invalid-feedback" style="display: block;">{{ session('error_message') }}</span>
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
    </div>
    
    <!-- Webinars Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-3 shadow-sm">
                    <div class="card-body">
                        <h2>Webinars</h2>
                        <table class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Starts On</th>
                                    <th>Type</th>
                                    <th>Preview</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($webinars as $webinar)
                                    @php
                                        $startDate = strtotime($webinar->start_date);
                                        $currentDate = time();
                                        $isNotStarted = $webinar->status == 2 && $startDate > $currentDate;
                                        $isActive = $webinar->status == 1 || ($webinar->status == 2 && !$isNotStarted);
                                        $isFinished = $webinar->status == 0;
                                        $statusLabel = $isNotStarted ? 'Not Started' : ($isActive ? 'Active' : 'Finished');
                                        $imageUrl = Str::startsWith($webinar->image_source, ['http://', 'https://'])
                                                    ? $webinar->image_source
                                                    : Storage::url($webinar->image_source);
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="{{ $isNotStarted ? 'text-warning' : ($isActive ? 'text-success' : 'text-muted') }}">
                                                {{ $statusLabel }}
                                            </span>
                                            @if ($isNotStarted)
                                                <br>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($webinar->title, 20, '...') }}</td>
                                        <td>{{ $isNotStarted ? date('M d, Y H:i', $startDate) : '-' }}</td>
                                        <td>Webinar</td>
                                        <td class="text-center">
                                            @if ($webinar->type == 0)
                                                <div id="fb-root"></div>
                                                <script async defer crossorigin="anonymous"
                                                    src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0"></script>
                                                <div class="fb-video" data-href="{{ $webinar->link }}" data-width="300"
                                                    data-show-text="false"></div>
                                            @elseif($webinar->type == 1)
                                                <a href="{{ $webinar->link }}" target="_blank">
                                                    <img src="{{ $imageUrl }}" alt="Webinar Photo"
                                                        style="width: 300px; height: auto; object-fit: cover;">
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
