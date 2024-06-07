<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href='{{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <link rel="stylesheet" href="{{ URL::to("profile.css") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ URL::to("profile.js") }}" defer></script>
    <title>FlixNexus•User Profile</title>
</head>

<body>
    <div class="profile-container">
        <div class="profile-header">
            <img id="main-avatar">
            <h1 data-username="{{ $q }}" id="main-username">{{ $q }}</h1>
        </div>
        <div class="user-info">
            @if ($user == $q)
            <p id="settings">Settings</p>
            @endif
            <p id="favourites"></p>
            <p id="written"></p>
        </div>
    </div>
    @if ($user == $q)
    <div id="updateResponse"></div>
    @endif
    <div id="profile-content" class="profile-content">
        <h1 id="movie-header" class="section-header">
            @if ($movieLikes->isEmpty())
            NO FAVOURITE MOVIES OR SHOWS YET
            @else
            FAVOURITE MOVIES & SHOWS
            @endif
        </h1>
        <section id="favourite-movies">
            @foreach ($movieLikes as $movie)
            <a href="{{ URL::to('result?id=' . urlencode($movie->FILM_ID)) }}">
                <img src="{{URL::to($movie->COVER)}}">
            </a>
            @endforeach
        </section>
        <h1 id="game-header" class="section-header">
            @if ($gameLikes->isEmpty())
            NO FAVOURITE GAMES YET
            @else
            FAVOURITE GAMES
            @endif
        </h1>
        <section id="favourite-games">
            @foreach ($gameLikes as $game)
            <a href="{{ URL::to('result?name=' . urlencode($game->GAME_NAME) . '&qid=videoGame') }}">
                <img src="{{ URL::to($game->COVER) }}">
            </a>
            @endforeach
        </section>
        <h1 id="my-header" class="section-header"></h1>
        <section id="your-reviews"></section>
        <h1 id="favourite-header" class="section-header"></h1>
        <section id="favourite-reviews"></section>
    </div>
    @if ($user == $q)
    <div id="settings-div" class="nascosto">
        <form method="post" class="nascosto" autocomplete="off" enctype="multipart/form-data">
            <h1 class="section-header">PROFILE SETTINGS</h1>
            <input type="email" placeholder="New Email" autocomplete="off" name="email">
            <p id="em" class="nascosto">Email format not valid!</p>
            <p id="em2" class="nascosto">Email already taken!</p>
            <div class="password-container">
                <input type="password" id="pwd_input" placeholder="New Password" autocomplete="off" name="password">
                <img class="show-password" src="{{URL::to("assets/eye_visible_hide_hidden_show_icon_145988.svg")}}">
            </div>
            <p id=" minlength" class="nascosto">Enter a password with at least 8 characters!</p>
            <p id="pwd" class="nascosto">Password must contain at least one Upper Case letter and a special
                character!
            </p>
            <label id="avatar" for="avatar">Upload New Profile Picture</label>
            <input id="file" type="file" accept=".jpg, .jpeg, image/gif, image/png" name="avatar">
            <p id="nosize" class="nascosto">The image must not exceed 5MB!</p>
            <p id="noext" class="nascosto">Allowed formats are .png, .jpeg, .jpg, and .gif!</p>
            <input type="submit" value="SUBMIT" class="submit">
        </form>
    </div>
    @endif
    <footer>
        <div class=" footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>FlixNexus • Social Discovery</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ URL::to("home") }}">Home</a></li>
                    <li><a href="{{ URL::to("about") }}">About</a></li>
                    <li><a href="{{ URL::to("services") }}">Services</a></li>
                    <li><a href="{{ URL::to("terms") }}">Terms of Use</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: FlixNexus@gmail.com</p>
                <p>Phone: (555) 123-4567</p>
            </div>
        </div>
    </footer>
</body>

</html>