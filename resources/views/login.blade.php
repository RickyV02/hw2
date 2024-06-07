<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href='{{ URL::to("login.css") }}' />
    <link
        href=" {{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}"
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <script src='{{ URL::to("login.js") }}' defer></script>
    <title>FlixNexus • Login</title>
</head>

<body>
    <form name="login" method="post" class="login-box">
        @csrf
        <h2>Sign In</h2>
        <p>Keep in touch with your friends</p>

        @foreach($errors->all() as $err)
        <p class='errormsg'>{{ $err }}</p>
        @endforeach

        <input type="text" placeholder="Username/Email" name="username" autocomplete="off" required
            value='{{ old("username") }}'>
        <p id="nouser" class="nascosto">Insert username or email!</p>
        <div class="password-container">
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="pwd"
                value='{{ old("password") }}'>
            <img class="show-password" src="{{URL::to("assets/eye_visible_hide_hidden_show_icon_145988.svg")}}">
        </div>
        <p id="nopwd" class="nascosto">Insert password!</p>
        <div class="check">
            <input type="checkbox" name="rememberme" id="rememberme" {{ old('rememberme') ? 'checked' : '' }}>
            <label for="rememberme">Remember me</label>
        </div>
        <input type="submit" value="SIGN IN" class="button">
        <p>Did you forget the password?<a href="{{ URL::to("forgotten_password") }}"> Change it now!</a></p>
        <p>Not Registred yet? <a href="{{ URL::to("signup") }}">Sign up now!</a></p>
        <a href="{{ URL::to("home") }}">Home Page</a>
    </form>

</body>

</html>