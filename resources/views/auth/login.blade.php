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
    <script>
    window.__REACT_DATA__ = @json([
                    ['error'=>session('error')],
                    ['request'  => 'login']
                    ]);
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>


