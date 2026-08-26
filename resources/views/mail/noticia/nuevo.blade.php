@component('mail::message')
# Blog ISFT38
@component('mail::panel')
**{{ $noticia->titulo }}**
<p>{{ Str::limit($noticia->cuerpo, 200, '...') }}</p>
@component('mail::button', ['url' => $url])
Leer más...
@endcomponent
@endcomponent

Saludos,<br>
{{ config('app.name') }} 
@endcomponent