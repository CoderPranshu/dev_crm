@component('mail::message')
{{-- You can use Markdown components for proper email formatting --}}

Hello {{ $candidateName }},

{!! nl2br(e($messageBody)) !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
