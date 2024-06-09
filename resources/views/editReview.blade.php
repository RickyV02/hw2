<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="{{ URL::to('https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular') }}"
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to('assets/logo.png') }}" />
    <link rel="stylesheet" href="{{ URL::to('editReview.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ URL::to('editReview.js') }}" defer></script>
    <title>FlixNexus • Edit Review</title>
</head>

<body>
    <header>
        <h1>Edit Your Review for: </h1>
    </header>
    <div class="main">
        <img id="cover">
        <div data-id="{{ $id }}" data-username="{{ $userid }}" class="review-form">
            <h1></h1>
            <form method="post">
                @csrf
                <label for="review">Your Review:</label>
                <textarea id="review" name="review" rows="4" cols="50"></textarea>
                <p id="norev" class="nascosto">Insert a review with maximum 255 chars!</p>

                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" step="0.1">
                <p id="maxrat" class="nascosto">Insert a rating between 0 and 10!</p>

                <input type="submit" value="SUBMIT">
            </form>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>FlixNexus • Social Discovery</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ URL::to('home') }}">Home</a></li>
                    <li><a href="{{ URL::to('about') }}">About</a></li>
                    <li><a href="{{ URL::to('services') }}">Services</a></li>
                    <li><a href="{{ URL::to('terms') }}">Terms of Use</a></li>
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