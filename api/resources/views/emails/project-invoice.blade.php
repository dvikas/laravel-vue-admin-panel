@component('mail::message')
Hello {{ $project->customer->name }},

Please find attached invoice for project **{{ $project->slug }}**

Thanks,<br>
{{ config('app.name') }}
@endcomponent
