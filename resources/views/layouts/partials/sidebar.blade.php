
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="{{route('user.home')}}"><span class="brand-logo">
                <img src="{{asset('images/logo.png')}}">
                       </span>
                    <h2 class="brand-text">{{config('app.name')}}</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {{request()->is('/') || request()->is('production')|| request()->is('cutting')?'active':''}}">
                <a class="d-flex align-items-center" href="{{ route('dashboard.index') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboard</span></a>
            </li>

                <li class=" nav-item {{request()->is('farmers') || request()->is('farmers/*')?'active':''}}">
                    <a class="d-flex align-items-center" href="{{route('farmers.index')}}"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Users">Farmers</span></a>
                </li>
                <li class=" nav-item {{request()->is('leads') || request()->is('leads/*')?'active':''}}">
                    <a class="d-flex align-items-center" href="/leads"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Users">Users</span></a>
                </li> 
                 <li class=" nav-item {{request()->is('farms') || request()->is('farms/*')?'active':''}}">
                    <a class="d-flex align-items-center" href="{{route('farms.index')}}"><i data-feather="grid"></i><span class="menu-title text-truncate" data-i18n="Kanban">Farms</span></a>
                </li> 
                 <li class=" nav-item {{request()->is('survey') || request()->is('survey/*')?'active':''}}">
                    <a class="d-flex align-items-center" href="{{route('survey.index')}}"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Kanban">Survey</span></a>
                </li> 
                <li class=" nav-item {{request()->is('questions') || request()->is('questions/*')?'active':''}}">
                    <a class="d-flex align-items-center" href="{{route('questions.index')}}"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Kanban">Questions</span></a>
                </li> 
                <li class=" nav-item {{request()->is('questionnaires') || request()->is('questionnaires/*')?'active':''}}">
                    <a class="d-flex align-items-center" href="{{route('questionnaires.index')}}"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Kanban">Questionnaires</span></a>
                </li> 
        
            
        </ul>
    </div>
</div>
<!-- END: Main Menu