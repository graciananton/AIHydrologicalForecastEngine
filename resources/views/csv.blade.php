@php
    $keys = array_keys($results[0]);
@endphp

{{-- Header row --}}
@for ($i = 0; $i < count($keys); $i++)
    @php
        $key = $keys[$i];
    @endphp

    @if (is_array($results[0][$key]))
        @foreach ($results[0][$key] as $k => $v)
            {{ $k }},
        @endforeach
    @else
        {{ $key }},
    @endif
@endfor
{{ "\n" }}

{{-- Data rows --}}
@for ($i = 0; $i < count($results); $i++)
    @php
        $result = $results[$i];
    @endphp

    @foreach ($result as $key => $value)
        @if (is_array($value))
            @foreach ($value as $k => $v)
                {{ $v }},
            @endforeach
        @else
            {{ $value }},
        @endif
    @endforeach

    {{ "\n" }}
@endfor