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
        /*window.__REACT_DATA__ = @json(
            [
                'error' => session('error'),
                'email' => session('email'),
                'request'  => 'login'
            ]
        );
        */
        data = @json(
            [
                'error' => session('error'),
                'email' => session('email'),
                'request' => 'stationId'
            ]
        );
        console.log(data);
        
        window.__REACT_DATA__ = data;
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>


