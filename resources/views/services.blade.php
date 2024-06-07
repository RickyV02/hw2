<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FlixNexus • Services</title>
    <link
        href=' {{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <link rel="stylesheet" href="{{URL::to("services.css")}}" />
</head>

<body>
    <div class="services-page">
        <div class="services-content">
            <h1>Our Services</h1>
            <p>
                Welcome to FlixNexus, your go-to platform for everything related to
                movies and video games. Our services include:
            </p>
            <h2>Film Reviews</h2>
            <p>
                Explore thousands of user-generated film reviews. Share your opinions
                and discover what others are saying about the latest releases and
                timeless classics.
            </p>
            <h2>Game Ratings</h2>
            <p>
                Rate and review your favorite video games. Join the discussion and
                connect with fellow gamers to share your gaming experiences and
                recommendations.
            </p>
            <h2>Community Forums</h2>
            <p>
                Engage with our vibrant community through our forums. Discuss your
                favorite films and games, share news and updates, and connect with
                like-minded users from around the world.
            </p>
            <h2>Curated Lists</h2>
            <p>
                Explore curated lists of films and games created by our community and
                staff. From must-watch movies to hidden gem video games, you'll find
                recommendations for every taste and preference.
            </p>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <ul>
                <li><a href="{{ URL::to("index") }}">Home</a></li>
                <li><a href="{{ URL::to("about") }}">About</a></li>
                <li><a href="{{ URL::to("terms") }}">Terms of Use</a></li>
            </ul>
        </div>
    </footer>
</body>

</html>