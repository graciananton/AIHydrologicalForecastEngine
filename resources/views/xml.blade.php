<pre>
{!! htmlspecialchars(
"<root>\n" .
collect($array)->map(function ($element) {
    $xml = "    <element>\n";
    foreach ($element as $key => $value) {
        $xml .= "        <{$key}>{$value}</{$key}>\n";
    }
    $xml .= "    </element>\n";
    return $xml;
})->implode('') .
"</root>"
) !!}
</pre>
