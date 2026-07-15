<!doctype html>
<html>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
    <title>AI Forecast Engine - Login</title>
</head>
<body>
    <?php
        $email = session()->getOldInput('email');

        $data = json_encode([
            "error" => session('error') ?? "",
            "email" => $email ? $email : "",
            "request" => "login",
        ]);
    ?>
    <script>
        console.log('script login blade page');
        const data = JSON.parse(@json($data));
        console.log(data);

        window.__REACT_DATA__ = data;
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>


