<!doctype html>
<html>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
    <title>AI Forecast Engine - Station Id</title>
</head>
<body>
    <?php
        $email = session()->getOldInput('email');
        $stationId = trim(session()->getOldInput('stationId'));

        $data = json_encode([
            "error" => session('error') ?? "",
            "email" => $email ? $email : "",
            "stationId" => $stationId ? $stationId : "",
            "request" => "signup",
        ]);
    ?>
    <script>
        const data = JSON.parse(@json($data));
        console.log(data);

        window.__REACT_DATA__ = data;
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>


