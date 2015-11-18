<div class="relatedVideos">
    <h6>Video tutorials</h6>
    <ul class="nav nav-stacked">
        @foreach($links as $link)
            <li><a href="#{{ $link['id']  }}">{{ $link['text'] }}</a></li>
        @endforeach
    </ul>
</div>