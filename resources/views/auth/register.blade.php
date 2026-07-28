<!doctype html>
<html>
<title>AI Forecast Engine - Register</title>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
</head>
<body>
    <script>    
    window.__REACT_DATA__ = @json([
        'request'  => 'register',
        'error' => session('error') ?? null
    ]);
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>
