<p>
    <li><b>YodaBot</b> {{$reply}}
        <ul>
            @foreach($alternative as $data)
                <li>{{ $data }}</li>
            @endforeach
        </ul>
    </li>
</p>
