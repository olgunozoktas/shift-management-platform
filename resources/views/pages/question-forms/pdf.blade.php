<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Question Form Details</title>
</head>
<body>
<table style="width: 100%; padding: 0 !important; margin: 0 !important;">
    <tr>
        <td colspan="2" style="float: right; text-align: right;">{{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</td>
    </tr>
    <tr>
        <td style="float: left; text-align: left;">
            @if($questionForm->show_logo == 'show' && isset($setting))
                <img src="{{ public_path($setting->logo_path) }}" alt="" style="width: 200px; height: 200px;">
            @else
                <h2>{{ $questionForm->description }}</h2>
            @endif
        </td>
        <td style="float: right; text-align: right">
            @if($questionForm->show_logo == 'show' && isset($setting))
                <h2>{{ $questionForm->description }}</h2>
            @endif
            User: {{ getCurrentUser()->name }}
        </td>
    </tr>
</table>
<br><br>

@foreach($questionForm->sections as $section)
    <div style="margin-bottom: 12px; padding: 2px 4px;">
        <p style="border-bottom: 1px solid #ccc">{{ $section['description'] }}</p>

        @foreach($section['questions'] as $key => $question)
            @if(!isset($question['hidden']))
                <div style="margin-bottom: 5px;">
                    <p>{{ $key + 1 }}. {{ $question['description'] }}</p>
                    <div style="margin-top: 5px; padding-left: 5px">
                        @if($question['question_type'] === 'text_box')
                            {{ $question['answer'] }}
                        @elseif($question['question_type'] === 'check_box')
                            @foreach($question['default_answers'] as $answer)
                                <div style="margin-top: 1px; margin-bottom: 4px;">
                                    <input type="checkbox" disabled @if($answer->is_answer) checked @endif>
                                    <label>{{ $answer->description }}</label>
                                </div>
                            @endforeach
                        @elseif($question['question_type'] === 'radio_button')
                            @foreach($question['default_answers'] as $answer)
                                <div style="margin-top: 1px; margin-bottom: 4px;">
                                    <input type="radio" disabled @if($answer->is_answer) checked @endif>
                                    <label>{{ $answer->description }}</label>
                                </div>
                            @endforeach

                            @if($question['extra_answer'] != null)
                                <textarea style="margin-top: 16px" disabled>{{ $question['extra_answer'] }}</textarea>
                            @endif
                        @elseif($question['question_type'] === 'drop_down')
                            @foreach($question['default_answers'] as $answer)
                                @if($answer->is_answer)
                                    {{ $answer->description }}
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endforeach

</body>
</html>
