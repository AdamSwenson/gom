<div class="relatedLinks">
    <h6>Related links</h6>
    <ul class="nav nav-stacked">
        @foreach($relatedLinks as $link)
            <li><a href="#{{ $link['id']  }}">{{ $link['text'] }}</a></li>
        @endforeach
    </ul>
</div>