<table>
    <tr>
        @foreach ($array[0] as $key => $value)
            <th style='border:1px solid black;'>{{ $key }}</th>
        @endforeach
    </tr>
    @for ($i = 0; $i < count($array); $i++)
        <tr>
            @foreach ($array[$i] as $key => $value)
                <td style="border:1px solid black;">
                    {{ $value }}
                </td>
            @endforeach
        </tr>
    @endfor
</table>
