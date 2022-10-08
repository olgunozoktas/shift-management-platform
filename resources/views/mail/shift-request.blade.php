@component('mail::message')
# Shift Request

{{ $user }} requested to pick up your shift which scheduled on date {{ $date }} and at {{ $time }}.

@component('mail::button', ['url' => $url])
  View Request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
