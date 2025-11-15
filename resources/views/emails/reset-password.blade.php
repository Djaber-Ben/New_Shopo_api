{{-- <x-mail::message> --}}
@component('mail::message')
#مرحبًا،

تلقينا طلبًا لإعادة تعيين كلمة مرورك.
انقر على الزر أدناه لاختيار كلمة مرور جديدة:

{{-- <x-mail::button :url="''"> --}}
@component('mail::button', ['url' => $url])
إعادة تعيين كلمة المرور
@endcomponent
{{-- </x-mail::button> --}}
إذا لم تطلب إعادة تعيين كلمة المرور، يرجى تجاهل هذا البريد الإلكتروني.

شكرًا،<br>
{{ config('app.name') }}
@endcomponent
{{-- </x-mail::message> --}}
