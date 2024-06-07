<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::to("search.css") }}">
    <link
        href='{{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <script src="{{ URL::to("search.js") }}" defer></script>
    <title>FlixNexus • Search&Results</title>
</head>

<body>
    <header>
        <h1>You searched for "{{ $name }}"</h1>
        <form method="post">
            @csrf
            <input type="text" autocomplete="off" name="search">
            <input type="submit" class="submit" value="">
        </form>
    </header>
    <section id="modal_search">
        @if (count($json->d) === 0)
        <h2>NO RESULTS!</h2>
        @else
        @foreach (($json->d) as $item)
        @php
        $nome = $item->l;
        $poster = isset($item->i) ? $item->i->imageUrl : URL::to('assets/placeholder.png');
        $href = $item->qid === "videoGame" ? URL::to('result') . "?name=" . urlencode($nome) . "&qid=videoGame" :
        URL::to('result') . "?id=" . urlencode($item->id) . "&qid=" . $item->qid;
        @endphp
        <a class="search" href="{{ URL::to($href) }}">
            <h2>{{ $nome }}</h2>
            <img class="cover" src="{{ URL::to($poster) }}">
        </a>
        @endforeach
        @endif
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