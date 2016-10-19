<div class="relatedLinks">
    <h5>Related links</h5>
    <ul class="nav nav-stacked">
        @foreach($relatedLinks as $link)
            <li>
                <a href="#{{ $link['id']  }}">{{ $link['text'] or $link['id']}}</a>
            </li>
        @endforeach
    </ul>
</div>