<!DOCTYPE html>
<html>
<head>
    <title>Survey PDF</title>
    <style>
        body {
            font-family: 'Courier', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>{{ $survey->title }}</h1>
    <p><strong>Description:</strong> {{ $survey->description }}</p>
    <p><strong>Farm Category:</strong> {{ $survey->farm_category }}</p>
    <p><strong>Expiry Date:</strong> {{ $survey->expiry_date }}</p>
    <p><strong>Reward Points:</strong> {{ $survey->reward_points }}</p>

    @foreach ($survey->questionnaires as $questionnaire)
        <h2>{{ $questionnaire->questionnaire_title }}</h2>
        <p>{{ $questionnaire->description }}</p>
        <table>
            <thead>
                <tr>
                    <th>Question ID</th>
                    <th>Field Name</th>
                    <th>Field Type</th>
                    <th>Choices</th>
                    <th>Conditional</th>
                    <th>Sub Questionnaire</th>
                    <th>Is Required</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questionnaire->questions as $question)
                    <tr>
                        <td>{{ $question->question_id }}</td>
                        <td>{{ $question->field_name }}</td>
                        <td>{{ $question->field_type }}</td>
                        <td>{{ $question->choices }}</td>
                        <td>{{ $question->conditional ? 'Yes' : 'No' }}</td>
                        <td>{{ is_array($question->sub_questionnaire) ? implode(', ', $question->sub_questionnaire) : $question->sub_questionnaire }}</td>
                        <td>{{ $question->is_required }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
