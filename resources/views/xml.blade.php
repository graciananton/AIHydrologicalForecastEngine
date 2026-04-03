<results>
@for ($i = 0; $i < count($results); $i++)
    <result>
        @foreach ($results[$i] as $key => $value)
            <{{ $key }}>{{ $value }}</{{ $key }}>
        @endforeach
    </result>
@endfor
</results>