<!DOCTYPE html>
<html>

<head>
    <title>Survey PDF</title>

    <style>
        :root {
            --green: rgb(1, 134, 1);
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
        }

        .logo img {
            width: 250px;
            margin-bottom: 8px;
            margin-right: 10px;
            display: inline-block;
        }

        .logo .text {
            display: inline-block;
            font-size: 4rem;
            font-weight: thin;
            color: var(--green);
        }

        .logo .sub-text {
            font-family: sans-serif;
            margin-top: -20px;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--green);
        }

        h1.title {
            color: var(--green);
            text-transform: capitalize;
        }

        div.sub-title {
            color: var(--green);
            text-transform: capitalize;
            margin-left: 10px;
            margin-top: -15px;
            margin-bottom: 20px;
        }

        .section div {
            display: inline-block;
            width: 45%;
        }

        .float-right {
            float: right;
        }

        .question {
            margin-left: 10px;
            margin-top: 20px;
        }

        .question-details {
            margin-left: 10px;
            margin-top: 20px;
        }

        input[type="checkbox"],
        input[type="radio"],
        input[type="text"],
        textarea {
            display: inline-block;
        }

        .d-inline-block {
            display: inline-block;
        }

        .mr {
            margin-right: 20px;
        }
        
        textarea {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <!-- Embed the SVG directly -->
            <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/app_splash.svg'))) }}"
                alt="Logo" class="logo">
            <div class="text">AGRI</div>
            <div class="sub-text">Masaganang Ani, Masaganang Buhay</div>
        </div>
        <h1 class="title">{{ $survey->title }}</h1>
        <div class="sub-title">{{ $survey->description }}</div>
        <div class="section">
            <div><strong>Farm Category:</strong> {{ $survey->farm_category }} </div>
            <div class="float-right">
                <strong>Expiry Date:</strong> {{ $survey->expiry_date }}</strong>
                <strong>Reward Points:</strong> {{ $survey->reward_points }}</strong>
            </div>
        </div>

        @foreach ($survey->questionnaires as $questionnaire)
            <div class="">
                <h1 class="title">{{ $questionnaire->questionnaire_title }}</h1>
                <div class="sub-title">{{ $questionnaire->description }}</div>
                @foreach ($questionnaire->questions as $no => $question)
                    <div class="question">
                        <div class="question-title">{{ $no + 1 }}. {{ ucfirst($question->field_name) }}</div>

                        <div class="question-details">
                            @if ($question->field_type == 'Checkbox')
                                @php
                                    $choices = explode(',', $question->choices);
                                @endphp
                                @foreach ($choices as $qc)
                                    <div class="d-inline-block">
                                        <input type="checkbox"
                                            {{ $question->is_required == 'required' ? 'required' : '' }}>
                                        <div class="d-inline-block mr">{{ $qc }}</div>
                                    </div>
                                @endforeach
                            @elseif ($question->field_type == 'Radio')
                                @php
                                    $choices = explode(',', $question->choices);
                                @endphp
                                @foreach ($choices as $qc)
                                    <div class="d-inline-block">
                                        <input type="radio" name="question_{{ $question->id }}"
                                            {{ $question->is_required == 'required' ? 'required' : '' }}>
                                        <div class="d-inline-block mr">{{ $qc }}</div>
                                    </div>
                                @endforeach
                            {{-- @elseif ($question->field_type == 'Text')
                                <input type="text" {{ $question->is_required == 'required' ? 'required' : '' }}> --}}
                            @elseif ($question->field_type == 'Textbox')
                                <textarea {{ $question->is_required == 'required' ? 'required' : '' }}></textarea>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</body>

</html>
