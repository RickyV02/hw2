<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href=' {{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <link rel="stylesheet" href="{{URL::to("review.css")}}">
    <script src="{{URL::to("review.js")}}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FlixNexus • Review</title>
</head>

<body>
    <header>
        <h1>Leave a Review for: "{{ $name }}"</h1>
    </header>

    <div class="film-review">
        <div id="name" data-name="{{ $name }}" class="film-info">
            <h1>{{ $name }}</h1>
            <img id="cover" data-image="{{ $image }}" src="{{ URL::to($image) }}">
            <img id="heart" src="{{URL::to("assets/empty.svg") }}">
        </div>

        <div data-username="{{ $userid }}" data-id="{{ $id }}" class="review-form">
            <h1></h1>
            <form method="post">

                <label for="review">Your Review:</label>
                <textarea id="review" name="review" rows="4" cols="50"></textarea>
                <p id="norev" class="nascosto">Insert a review with maximum 255 chars!</p>


                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" step="0.1">
                <p id="maxrat" class="nascosto">Insert a rating between 0 and 10 !</p>

                <input type="submit" value="SUBMIT">
            </form>
            <div class="info">
                <h3>Info:</h3>
                <p id="likes"></p>
                <p id="reviews"></p>
            </div>
        </div>
    </div>


    <section id="other_reviews">
        <h1></h1>
        <div id="reviews-box">
        </div>
    </section>

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