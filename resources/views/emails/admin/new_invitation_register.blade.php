@component('mail::message')
# Hola
<br>
hola! el usuario ***{{ $cliente->email}}*** Te envito a unirte a nuestra plataforma y usar un ticket para un evento
<br>
puedes unirte a travez del siguiente enlace:
<br><br>
{{ env('APP_URL') }}
<button class="btn">Acceder a la App</button>
@component('mail::button', [
    'url' => env('APP_URL')
])
    Ir a la web
@endcomponent

Notificaciones automatizadas desde la app
***{{ config('app.name') }}***
@endcomponent
