<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href='{{ URL::to("index.css") }}' />
    <link
        href=' {{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <script src="{{ URL::to("home.js") }}" defer></script>
    <title>FlixNexus • Home</title>
</head>

<body>
    <div class="container">
        <div class="overlay">
        </div>
        <div class="sfondo">
        </div>
    </div>
    <header>
        <section class="navsection">
            <h1 class="logo">
                <img src="{{ URL::to("assets/logo.png") }}">
                <p>FlixNexus</p>
            </h1>
            <nav>
                <a href="{{URL::to("logout")}}"><span>LOGOUT</span></a>
                <a href="{{ URL::to('profile?q=' . urlencode(session('username'))) }}"><span>PROFILE</span></a>
                <form method="post" action="{{URL::to("search")}}">
                    @csrf
                    <input type="text" autocomplete="off" id="movie_name" name="search">
                    <input type="submit" class="submit" value="">
                </form>
            </nav>
        </section>
    </header>
    <div class="wrapper">
        <h1 class="slogan">
            Search films you’ve watched.
        </h1>
        <h1 class="slogan">
            Track games you recently played.
        </h1>
        <h1 class="slogan">
            Get infos about them.
        </h1>
        <p id="spam">Welcome {{ session('username') }}!</p>
        <h1>
            Start looking for...
        </h1>
        <section class="livefeed" id="livefeed">
            <h1>10 WEEKLY RECOMMENDATION</h1>
            <div>
                @foreach (($weekly->data) as $item)
                <a href="{{ URL::to('result?id=' . urlencode($item->id)) }}"><img class="thumb"
                        src="{{ $item->primaryImage->imageUrl }}" data-id="{{ $item->id }}"></a>
                @endforeach
            </div>
        </section>
        <section class=" livefeed" id="randommovies">
            <h1>10 RANDOM MOVIES TO WATCH</h1>
            <div>
                @php
                $usedIds = [];
                $moviesCount = count($movies);
                @endphp

                @for ($i = 0; $i < 10; $i++) @php do { $randomMovie=$movies[random_int(0, $moviesCount - 1)];
                    $movieId=$randomMovie->imdbid;
                    } while (in_array($movieId, $usedIds));
                    @endphp

                    <a href="{{ URL::to('result?id=' . urlencode($movieId)) }}">>
                        <img class="thumb" src="{{ $randomMovie->image }}" data-id="{{ $movieId }}"
                            onerror="this.src=`{{ URL::to('assets/placeholder.png') }}`;">
                    </a>
                    @php
                    $usedIds[] = $movieId;
                    @endphp
                    @endfor

            </div>
        </section>
        <section class="livefeed" id="randomseries">
            <h1>10 RANDOM SERIES TO WATCH</h1>
            <div>
                @php
                $usedIds = [];
                $seriesCount = count($series);
                @endphp

                @for ($i = 0; $i < 10; $i++) @php do { $randomSeries=$series[random_int(0, $seriesCount - 1)];
                    $seriesId=$randomSeries->imdbid;
                    } while (in_array($seriesId, $usedIds));
                    $usedIds[] = $seriesId;
                    @endphp

                    <a href="{{ URL::to('result?id=' . urlencode($seriesId)) }}">
                        <img class="thumb" src="{{ $randomSeries->image }}" data-id="{{ $seriesId }}"
                            onerror="this.src=`{{ URL::to('assets/placeholder.png') }}`;">
                    </a>
                    @endfor
            </div>
        </section>
        <section class="livefeed" id="randomgames">
            <h1>DONT KNOW WHAT TO PLAY? TRY THESE!</h1>
            <div>
                @php
                $usedIndexes = [];
                $gamesCount = count($games);
                @endphp

                @for ($i = 0; $i < 20; $i++) @php do { $randomGame=$games[random_int(0, $gamesCount - 1)];
                    $imageId=$randomGame->cover->image_id;
                    } while (in_array($imageId, $usedIndexes));
                    $usedIndexes[] = $imageId;
                    @endphp

                    <a href="{{ URL::to('result?name=' . urlencode($randomGame->name) . '&qid=videoGame') }}">
                        <img class="thumb"
                            src="{{ URL::to('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $imageId . '.jpg') }}"
                            data-id="{{ $imageId }}">
                    </a>
                    @endfor
            </div>

        </section>
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