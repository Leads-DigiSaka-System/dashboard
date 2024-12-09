@php
    $userObj = auth()->user();
@endphp
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" style="text-decoration: none;" href="/dashboard">
                    <span class="brand-logo">
                        <img src="{{ asset('images/logo.png') }}" class="img-fluid"
                            style="max-width: 100px; height: auto;">
                    </span>
                    <h1 class="brand-text">{{ config('app.name') }}</h1>
                </a>
            </li>
            {{-- <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                </a>
            </li> --}}
        </ul>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-4 mb-2">
            <div class="col-lg-6 col-md-8 col-sm-10 mx-auto text-center">
                <div class="mx-auto">
                    <img src="{{ $userObj->profile_image ? $userObj->profile_image : asset('images/theme/portrait/small/avatar-s-13.jpg') }}"
                        alt="" class="rounded-circle img-fluid" style="max-width: 120px; height: auto;">
                </div>
                <h4 class="mt-2 text-xl font-weight-bold text-gray-600">
                    <!-- admin name -->
                    {{ ucfirst($userObj->full_name) }}
                </h4>
                <span class="text-gray-400">{{ $userObj->getUserRole->title ?? '' }}</span>
            </div>
        </div>
    </div>


    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class=" nav-item {{ request()->is('/') || request()->is('production') || request()->is('cutting') ? 'active' : '' }}">
                <a class="d-flex align-items-center" style="text-decoration: none;"
                    href="{{ route('dashboard.index') }}"><i data-feather="home"></i><span
                        class="menu-title text-truncate" data-i18n="Dashboards">Dashboard</span></a>
            </li>

            @if (Auth::user()->role != 5)
                <li class=" nav-item {{ request()->is('farmers') || request()->is('farmers/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('farmers.index') }}"><i data-feather="user"></i><span
                            class="menu-title text-truncate" data-i18n="Users">Farmers</span></a>
                </li>
                <li class=" nav-item {{ request()->is('leads') || request()->is('leads/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;" href="/leads"><i
                            data-feather="user"></i><span class="menu-title text-truncate"
                            data-i18n="Users">Users</span></a>
                </li>
                <li class=" nav-item {{ request()->is('farms') || request()->is('farms/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('farms.index') }}"><i data-feather="grid"></i><span
                            class="menu-title text-truncate" data-i18n="Kanban">Farms</span></a>
                </li>
                <li class=" nav-item {{ request()->is('survey') || request()->is('survey/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('survey.index') }}"><i data-feather="book"></i><span
                            class="menu-title text-truncate" data-i18n="Kanban">Survey</span></a>
                </li>
            @endif
            {{-- <li class=" nav-item {{request()->is('questions') || request()->is('questions/*')?'active':''}}">
                <a class="d-flex align-items-center" href="{{route('questions.index')}}"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Kanban">Questions</span></a>
            </li> 
            <li class=" nav-item {{request()->is('questionnaires') || request()->is('questionnaires/*')?'active':''}}">
                <a class="d-flex align-items-center" href="{{route('questionnaires.index')}}"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Kanban">Questionnaires</span></a>
            </li> 
            <li class=" nav-item {{request()->is('survey_set') || request()->is('survey_set/*')?'active':''}}">
                <a class="d-flex align-items-center" href="{{route('survey_set.index')}}"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Kanban">Survey Set</span></a>
            </li>  --}}
            @if (Auth::user()->role != 5)
                <li class=" nav-item {{ request()->is('contacts') || request()->is('contacts/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('contacts.index') }}"><i data-feather="book"></i><span
                            class="menu-title text-truncate" data-i18n="Kanban">Contacts</span></a>
                </li>
            @endif
{{-- 
            <li class=" nav-item {{ request()->is('JAS') || request()->is('JAS/*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" style="text-decoration: none;"
                    href="{{ route('jasProfiles.index') }}"><i data-feather="book"></i><span
                        class="menu-title text-truncate" data-i18n="Kanban">JAS</span></a>
            </li> --}}
            

            @if (Auth::user()->role != 5)
                <li class=" nav-item {{ request()->is('webinars') || request()->is('webinars/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('webinars.index') }}"><i data-feather="book"></i><span
                            class="menu-title text-truncate" data-i18n="Kanban">Webinars</span></a>
                </li>
            @endif
            @if (Auth::user()->role == 1 || Auth::user()->role == 0)
                <li class=" nav-item {{ request()->is('sales') || request()->is('sales/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('sales.index') }}"><i data-feather="book"></i><span
                            class="menu-title text-truncate" data-i18n="Kanban">Sales Team</span></a>
                </li>
            @endif
            {{-- @if (Auth::user()->role == 1 || Auth::user()->role == 0)
                <li class=" nav-item {{ request()->is('analytics') || request()->is('analytics/*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('analytics.index') }}"><i data-feather="bar-chart"></i><span
                            class="menu-title text-truncate" data-i18n="Kanban">Analytics</span></a>
                </li>
            @endif --}}




            <li class="nav-item" style="margin-top:50%;">
                <div>
                    {{-- <div class="divider"></div> --}}
                    <hr>
                    <a class="d-flex align-items-center" style="text-decoration: none; margin: 0 15px;"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i data-feather="log-out"></i>
                        <span class="menu-title text-truncate" data-i18n="Logout">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

    </div>
    <!-- Divider above logout button -->


</div>
<div>
   
</div>
<!-- END: Main Menu -->
