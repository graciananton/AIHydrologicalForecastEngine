<results>
@foreach ($results as $result)
    <result>

        @foreach ($result as $key => $value)

            @if (is_array($value))

                @foreach ($value as $k => $v)
                    <{{ $k }}>{{ $v }}</{{ $k }}>
                @endforeach

            @else

                <{{ $key }}>{{ $value }}</{{ $key }}>

            @endif

        @endforeach

    </result>
@endforeach
</results>