<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href='{{ URL::to("https://db.onlinewebfonts.com/c/f82a45d96a5a30abb6417c5b81fc416d?family=Graphik+LC+Web+Semibold+Regular") }}'
        rel="stylesheet">
    <link rel="icon" href="{{ URL::to("assets/logo.png") }}" />
    <link rel="stylesheet" href="{{ URL::to("search.css") }}">
    <script src="{{ URL::to("result.js") }}" defer></script>
    <title>FlixNexus • Search&Results</title>
</head>

<body>
    <header>
        <h1>Here's what we found</h1>
    </header>
    <section id="modal_search">
        @if ($type === 'videoGame')
        @foreach ($json as $game)
        <div class="modal_game">
            <form action="{{URL::to("review")}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $game->id }}">
                <input type="hidden" name="name" value="{{ $game->name }}">
                <input type="hidden" name="image"
                    value="{{ 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $game->cover->image_id . '.jpg' }}">
                <img class="cover"
                    src="{{ URL::to('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $game->cover->image_id . '.jpg') }}">
                <h3>Leave a Review !</h3>
            </form>
            <div>
                <p>{{ $game->name }}</p>
                @if (isset($game->platforms) && !empty($game->platforms))
                <p>Platforms:
                    @foreach ($game->platforms as $platform)
                    {{ $platform->name }}
                    @endforeach
                </p>
                @endif
                @if (isset($game->release_dates) && !empty($game->release_dates))
                <p>First Release Date: {{ $game->release_dates[0]->human }}</p>
                @endif
                @if (isset($game->summary) && !empty($game->summary))
                <p>Summary: {{ $game->summary }}</p>
                @endif
                @if (isset($game->storyline) && !empty($game->storyline))
                <p>Storyline: {{ $game->storyline }}</p>
                @endif
                @if (isset($game->genres) && !empty($game->genres))
                <p>Genres:
                    @foreach ($game->genres as $genre)
                    {{ $genre->name }}
                    @endforeach
                </p>
                @endif
                @if (isset($game->franchise) && !empty($game->franchise))
                <p>Franchise: {{ $game->franchise->name }}</p>
                @endif
                @if (isset($game->themes) && !empty($game->themes))
                <p>Themes:
                    @foreach ($game->themes as $theme)
                    {{ $theme->name }}
                    @endforeach
                </p>
                @endif
                @if (isset($game->expansions) && !empty($game->expansions))
                <p>Expansions:
                    @foreach ($game->expansions as $expansion)
                    {{ $expansion->name }}
                    @endforeach
                </p>
                @endif
                @if (isset($game->dlcs) && !empty($game->dlcs))
                <p>DLCs:
                    @foreach ($game->dlcs as $dlc)
                    {{ $dlc->name }}
                    @endforeach
                </p>
                @endif
                @if (isset($game->involved_companies) && !empty($game->involved_companies))
                <p>Involved Companies:
                    @foreach ($game->involved_companies as $company)
                    {{ $company->company->name }}
                    @endforeach
                </p>
                @endif
            </div>
        </div>
        @endforeach
        @elseif ($type === 'tt')
        <div class="modal_game">
            <form action="{{ URL::to("review") }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $json->id }}">
                <input type="hidden" name="name" value="{{ $json->titleText->text }}">
                <input type="hidden" name="image"
                    value="{{ isset($json->primaryImage) ? $json->primaryImage->url : 'assets/placeholder.png' }}">
                <img class="cover"
                    src="{{ isset($json->primaryImage) ? URL::to($json->primaryImage->url) : URL::to('assets/placeholder.png') }}">
                <h3>Leave a Review !</h3>
            </form>
            <div>
                <p>{{ $json->titleText->text }}</p>
                @if (isset($json->releaseDate) && !empty($json->releaseDate))
                <p>Release Date:
                    @if (isset($json->releaseDate->day))
                    {{ $json->releaseDate->day }}/
                    @endif
                    @if (isset($json->releaseDate->month))
                    {{ $json->releaseDate->month }}/
                    @endif
                    @if (isset($json->releaseDate->year))
                    {{ $json->releaseDate->year }}
                    @endif
                </p>
                @endif
                @if (isset($json->ratingsSummary->aggregateRating) && !empty($json->ratingsSummary->aggregateRating))
                <p>Rating Summary: {{ $json->ratingsSummary->aggregateRating }}</p>
                @endif
                @if (isset($json->metacritic) && !empty($json->metacritic))
                <p>Metacritic Score: {{ $json->metacritic->metascore->score }}</p>
                @endif
                @if (isset($json->canHaveEpisodes) && !empty($json->canHaveEpisodes))
                <p>Episodes: {{ $json->episodes->episodes->total }}</p>
                @endif
                @if (isset($json->genres->genres) && count($json->genres->genres) !== 0)
                <p>Genres:
                    @foreach ($json->genres->genres as $genre)
                    {{ $genre->text }}
                    @endforeach
                </p>
                @endif
                @if (isset($json->directors) && !empty($json->directors))
                <p>Director:
                    @foreach ($json->directors as $director)
                    @if (isset($director->credits) && !empty($director->credits))
                    {{ $director->credits[0]->name->nameText->text }}
                    @endif
                    @endforeach
                </p>
                @endif
                @if (isset($json->countriesOfOrigin) && !empty($json->countriesOfOrigin))
                <p>Countries of Origin:
                    @foreach ($json->countriesOfOrigin->countries as $country)
                    {{ $country->id }}
                    @endforeach
                </p>
                @endif
                @if (isset($json->nominations->total) && !empty($json->nominations->total))
                <p>Nominations: {{ $json->nominations->total }}</p>
                @endif
                @if (isset($json->production->edges) && !empty($json->production->edges))
                <p>Production Company: {{ $json->production->edges[0]->node->company->companyText->text }}</p>
                @endif
                @if (isset($json->productionBudget) && !empty($json->productionBudget))
                <p>Production Budget: {{ $json->productionBudget->budget->amount }}
                    {{ $json->productionBudget->budget->currency }}</p>
                @endif
                @if (isset($json->plot) && !empty($json->plot))
                <p>Plot: {{ $json->plot->plotText->plainText }}</p>
                @endif
                @if (isset($json->cast->edges) && !empty($json->cast->edges))
                <p>Cast:</p>
                <section class="credits">
                    @foreach ($json->cast->edges as $cast)
                    <a class="search" href="result?id={{ urlencode($cast->node->name->id) }}">
                        <p>{{ $cast->node->name->nameText->text }}</p>
                        @if (isset($cast->node->characters) && !empty($cast->node->characters))
                        @foreach ($cast->node->characters as $character)
                        <p>{{ $character->name }}</p>
                        @endforeach
                        @endif
                        <img
                            src="{{ isset($cast->node->name->primaryImage) ? URL::to($cast->node->name->primaryImage->url) : URL::to('assets/placeholder.png') }}">
                    </a>
                    @endforeach
                </section>
                @endif
            </div>
        </div>
        @elseif ($type === 'nm')
        <div class="modal_game">
            <img class="cover"
                src="{{ isset($json->primaryImage) ? URL::to($json->primaryImage->url) : URL::to('assets/placeholder.png') }}">
            <div>
                <p>{{ $json->nameText->text }}</p>
                @if (isset($json->birthDate) && !empty($json->birthDate))
                <p>Birth Date:
                    {{ $json->birthDate->dateComponents->day }}/{{ $json->birthDate->dateComponents->month }}/{{ $json->birthDate->dateComponents->year }}
                </p>
                @endif
                @if (isset($json->birthLocation) && !empty($json->birthLocation))
                <p>Birth Location: {{ $json->birthLocation->text }}</p>
                @endif
                @if (isset($json->deathDate) && !empty($json->deathDate))
                <p>Death Date:
                    {{ $json->deathDate->dateComponents->day }}/{{ $json->deathDate->dateComponents->month }}/{{ $json->deathDate->dateComponents->year }}
                </p>
                @endif
                @if (isset($json->deathLocation) && !empty($json->deathLocation))
                <p>Death Location: {{ $json->deathLocation->text }}</p>
                @endif
                @if (isset($json->deathCause) && !empty($json->deathCause))
                <p>Death Cause: {{ $json->deathCause->displayableProperty->value->plainText }}</p>
                @endif
                @if (isset($json->children) && !empty($json->children))
                <p>Children: {{ $json->children->total }}</p>
                @endif
                @if (isset($json->jobs) && count($json->jobs) > 0)
                <p>Jobs:
                    @foreach ($json->jobs as $job)
                    {{ $job->category->text }}
                    @endforeach
                </p>
                @endif
                @if (isset($json->wins->total) && !empty($json->wins->total))
                <p>Wins: {{ $json->wins->total }}</p>
                @endif
                @if (isset($json->nominations->total) && !empty($json->nominations->total))
                <p>Nominations: {{ $json->nominations->total }}</p>
                @endif
                @if (isset($json->knownForFeature->edges) && count($json->knownForFeature->edges) > 0)
                <p>Known For:</p>
                <section class="credits">
                    @foreach ($json->knownForFeature->edges as $edge)
                    <a class="search" href="result?id={{ urlencode($edge->node->title->id) }}">
                        <p>{{ $edge->node->title->titleText->text }}</p>
                        <img
                            src="{{ isset($edge->node->title->primaryImage) ? URL::to($edge->node->title->primaryImage->url) : URL::to('assets/placeholder.png') }}">
                    </a>
                    @endforeach
                </section>
                @endif
            </div>
        </div>
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