@extends('layouts.admin')

@section('title')
    Survey
@endsection

@section('content')
    <!-- Main content -->

    <ul class="nav nav-tabs" rol="tablist" style="background: #fff; margin-top: -1rem;">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#nav-survey">Active</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-question" data-bs-toggle="tab">Questions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-questionnaire" data-bs-toggle="tab">Questionnaires</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#nav-survey-set" data-bs-toggle="tab">Survey Set</a>
        </li>
        {{-- <li class="nav-item">
    <a class="nav-link" href="#nav-jackpot-allstar" data-bs-toggle="tab">Jackpot Allstars</a>
  </li> --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">Survey Results</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" data-bs-toggle="tab" href="#nav-survey-v1">Version 1</a></li>
                <li><a class="nav-link" data-bs-toggle="tab" href="#nav-survey-v2">Version 2</a></li>
            </ul>
        </li>
    </ul>


    {{-- <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="background: #fff; margin-top: -1rem;">
      <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-survey" role="tab" aria-controls="nav-home" aria-selected="true">Surveys</a>
      <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-question" role="tab" aria-controls="nav-profile" aria-selected="false">Questions</a>
      <a class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" href="#nav-questionnaire" role="tab" aria-controls="nav-contact" aria-selected="false">Questionnaires</a>
      <a class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" href="#nav-survey-set" role="tab" aria-controls="nav-contact" aria-selected="false">Survey Set</a>

      <li class="nav-item dropdown">
          <a class="nav-link navs" data-bs-toggle="dropdown" href="#" role="button"
              aria-expanded="false">
              Survey Results
          </a>
          <ul class="dropdown-menu">
              <li><a class="nav-link navs" id="tab2" data-toggle="tab" href="#content2">Version 1</a></li>
              <li><a class="nav-link navs" id="tab2" data-toggle="tab" href="#content10">Version 2</a></li>
          </ul>
      </li>
    </div>
  </nav> --}}

    <div class="tab-content" id="nav-tabContent">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong class="d-block d-sm-inline-block-force">Well done!</strong> {{ $message }}
            </div><!-- alert -->
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong class="d-block d-sm-inline-block-force">Oh Snap!</strong> {{ $message }}
            </div><!-- alert -->
        @endif
        @include('survey.tabs.survey')
        @include('survey.tabs.question')
        @include('survey.tabs.questionnaire')
        @include('survey.tabs.survey_set')
        @include('survey.tabs.survey_result_v1')
        @include('survey.tabs.survey_result_v2')
        @include('survey.tabs.jackpot_allstar')
    </div>



    @push('page_script')
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        @include('include.dataTableScripts')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/pages/survey/index.js') }}"></script>
        <script src="{{ asset('js/pages/questions/index.js') }}"></script>
        <script src="{{ asset('js/pages/questionnaires/index.js') }}"></script>
        <script src="{{ asset('js/pages/survey_set/index.js') }}"></script>
        @include('survey.chartScript')
        @include('survey.chart_v2')
    @endpush
@endsection
