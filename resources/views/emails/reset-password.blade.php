{{-- <x-mail::message> --}}
@component('mail::message')
# Hello,

We received a request to reset your password.  
Click the button below to choose a new password:

{{-- <x-mail::button :url="''"> --}}
@component('mail::button', ['url' => $url])
Reset Password
@endcomponent
{{-- </x-mail::button> --}}
If you didn’t request a password reset, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
{{-- </x-mail::message> --}}
