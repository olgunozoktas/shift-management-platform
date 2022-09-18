<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $timeCard->job->job_title }}</title>
</head>
<body>
<table style="width: 100%; padding: 0 !important; margin: 0 !important;">
    <tr>
        <td colspan="2" style="float: right; text-align: right;">{{ \Carbon\Carbon::parse($timeCard->created_at)->tz('America/Los_Angeles')->toDateTimeString() }}</td>
    </tr>
    <tr>
        <td style="float: left; text-align: left;">
            <img src="{{ asset('logo/logo.jpg') }}" alt="" width="250">
        </td>
        <td style="float: right; text-align: right">
            <h2 style="padding: 0 !important; margin: 0 !important;">Field Report</h2><br><h4 style="margin-top: -10px;">{{ $timeCard->job->job_title }} / {{ $timeCard->job->formatted_job_number }}</h4></td>
    </tr>
</table>
<br><br>
<table style="width: 100%; padding: 0 !important; margin: 0 !important; border: 1px solid #ccc;">
    <thead style="border-bottom: 1px solid #ccc;">
        <tr style="text-align: center;">
            <th>Employee Name</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Total Hours Worked</th>
        </tr>
    </thead>
    <tbody>
        <tr style="text-align: center; word-wrap: break-word">
            <td>{{ $timeCard->employee->name }}</td>
            <td>{{ $timeCard->start_time }}</td>
            <td>{{ $timeCard->end_time }}</td>
            <td>{{ $timeCard->total_hours_worked }} Hours</td>
        </tr>
    </tbody>
</table>

<br>

<table style="width: 100%; padding: 0 !important; margin: 0 !important; border: 1px solid #ccc; table-layout: fixed">
    <thead style="border-bottom: 1px solid #ccc;">
    <tr>
        <th style="text-align: left;">Purchases</th>
    </tr>
    </thead>
    <tbody>
    <tr style="word-wrap: break-word">
        <td>{!! nl2br($timeCard->purchases) ?? '-' !!}</td>
    </tr>
    </tbody>
</table>

<br>

<table style="width: 100%; padding: 0 !important; margin: 0 !important; border: 1px solid #ccc; table-layout: fixed">
    <thead style="border-bottom: 1px solid #ccc;">
    <tr>
        <th style="text-align: left;">Shop Supplies</th>
    </tr>
    </thead>
    <tbody>
    <tr style="word-wrap: break-word">
        <td>{!! nl2br($timeCard->shop_supplies) ?? '-' !!}</td>
    </tr>
    </tbody>
</table>

<br>

<table style="width: 100%; padding: 0 !important; margin: 0 !important; border: 1px solid #ccc; table-layout: fixed">
    <thead style="border-bottom: 1px solid #ccc;">
    <tr>
        <th style="text-align: left;">Notes</th>
    </tr>
    </thead>
    <tbody>
    <tr style="word-wrap: break-word">
        <td>{!! nl2br($timeCard->notes) ?? '-' !!}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
