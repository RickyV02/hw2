<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href='{{ URL::to("login.css") }}' />
    <link
        href=' {{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <script src="{{ URL::to("forgotten_password.js") }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FlixNexus • Forgotten Password</title>
</head>

<body>
    <form name="login" method="post" class="login-box">
        @csrf
        <h2>Forgotten Password</h2>
        <p id="status"></p>
        <input type="email" placeholder="Email" name="email" autocomplete="off" required value='{{ old("email") }}'>
        <p id="em" class="nascosto">Email format not valid!</p>
        <p id="em2" class="nascosto">Email not Registred!</p>
        <input type="submit" value="SEND EMAIL" class="button">
        <a href="{{URL::to("index")}}">Home Page</a>
    </form>
</body>

</html>