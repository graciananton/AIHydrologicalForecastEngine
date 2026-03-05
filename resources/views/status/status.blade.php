<!doctype html>
<html>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    <?php
    $data = [
    "weather" => $weather,
    "readings" => $readings,
    "status" => $status,
    "request" => $request
    ];

    $json = json_encode($data);
    ?>
    <script>
        /*console.log(@json($weather));
        console.log(@json($readings));
        //window.__REACT_DATA__ = @json(['readings'=>$readings]);*/
        //console.log(@json(['request'=>$request]));


        console.log(@json($weather));
        console.log(@json($status));
        console.log(@json($readings));
        console.log(@json($request));

        window.__REACT_DATA__ = {!! $json !!};
    </script>
    @if(session('success'))
        <div id='success'>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div id='error'>
            {{ session('error') }}
        </div>
    @endif
    <div id="react-root"></div>
</body>
</html>
