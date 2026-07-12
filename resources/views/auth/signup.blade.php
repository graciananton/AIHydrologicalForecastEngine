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
    <script>
        data = @json(
            [
                'error' => session('error'),
                'email' => session('email'),
                'request' => 'signup'
            ]
        );
        console.log(data);
        
        window.__REACT_DATA__ = data;
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>


