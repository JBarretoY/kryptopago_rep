<div>
    Hola {{ $name }} se necesita que valides la cuenta
    <a href="{{ env('URL_BASE_CLIENT').'/password-reset'/$token }}">Link</a>
</div>
