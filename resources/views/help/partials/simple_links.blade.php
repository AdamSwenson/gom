@foreach($links as $link)
    <li><a href="#{{ $link['id']  }}">{{ $link['text'] }}</a></li>
@endforeach