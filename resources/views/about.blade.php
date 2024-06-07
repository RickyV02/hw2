<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href='{{ URL::to("about.css") }}' />
    <link
        href=' {{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <title>FlixNexus • About Us</title>
</head>

<body>
    <div class="about-page">
        <div class="about-content">
            <h1>About Us</h1>
            <p>
                Welcome to FlixNexus!, your ultimate destination for exploring,
                sharing, and discovering your favorite movies and video games!
            </p>
            <p>
                Our platform brings together enthusiasts from all over the world to
                discuss, review, and recommend the latest releases and timeless
                classics.
            </p>
            <p>Join our vibrant community to:</p>
            <ul>
                <li>Discover new films and games</li>
                <li>Share your thoughts and reviews</li>
                <li>Connect with like-minded users</li>
                <li>Explore curated lists and recommendations</li>
            </ul>
            <p>Start your journey with FlixNexus today!</p>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <ul>
                <li><a href="{{URL::to("index")}}">Home</a></li>
                <li><a href="{{URL::to("services")}}">Services</a></li>
                <li><a href="{{URL::to("terms")}}">Terms of Use</a></li>
            </ul>
        </div>
    </footer>
</body>

</html>