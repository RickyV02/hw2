<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{URL::to("login.css")}}" />
    <link
        href=" {{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}"
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <script src="{{URL::to("create_account.js")}}" defer></script>
    <title>FlixNexus • Create Account</title>
</head>

<body>
    <form name="login" method="post" class="login-box" enctype="multipart/form-data">
        @csrf
        <h2>Sign Up</h2>
        <p>Keep in touch with your friends</p>

        @foreach($errors->all() as $err)
        <p class='errormsg'>{{ $err }}</p>
        @endforeach

        <input type="email" placeholder="Email" name="email" autocomplete="off" required value='{{ old("email") }}'>
        <p id="em" class="nascosto">Email format not valid!</p>
        <p id="em2" class="nascosto">Email already taken!</p>
        <input type="text" placeholder="Username" name="username" autocomplete="off" required
            value='{{ old("username") }}'>
        <p id="user" class="nascosto">Username already taken!</p>
        <p id="nouser" class="nascosto">Enter username between 4 and 16 characters!!</p>
        <div class="password-container">
            <input type="password" placeholder="Password" name="password" class="pwd" autocomplete="off"
                value='{{ old("password") }}'>
            <img class="show-password" src="{{URL::to("assets/eye_visible_hide_hidden_show_icon_145988.svg")}}">
        </div>
        <p id="minlength" class="nascosto">Enter a password with at least 8 characters!</p>
        <p id="pwd" class="nascosto">Password must contain at least one Upper Case letter and a special character!
        </p>
        <div class="password-container">
            <input type="password" placeholder="Repeat Password" name="rpassword" class="pwd" autocomplete="off"
                required value='{{ old("rpassword") }}'>
            <img class="show-password" src="{{URL::to("assets/eye_visible_hide_hidden_show_icon_145988.svg")}}">
        </div>
        <p id="pwdmatch" class="nascosto">Passwords doesnt match!</p>
        <label id="avatar" for="avatar">Upload a Profile Picture</label>
        <input type="file" id="file" name="avatar" accept='.jpg, .jpeg, image/gif, image/png'>
        <p id="nosize" class="nascosto">The image must not exceed 5MB !</p>
        <p id="noext" class="nascosto">Allowed formats are . png, . jpeg, . jpg and . gif !</p>
        <div class=" check">
            <input type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }}>
            <label for="terms">I agree to the terms and conditions of FlixNexus</label>
        </div>
        <p id="noterms" class="nascosto">Accept the terms and conditions to proceed !</p>
        <input type="submit" value="SIGN UP" class="button">
        <p>Already Have an Account? <a href="{{URL::to("login")}}">Sign in now!</a></p>
        <a href="{{URL::to("index")}}">Home Page</a>
    </form>

</body>

</html>