<!doctype html>
<html>
<title>Verification Message</title>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
</head>
<body>
    <script>
    window.__REACT_DATA__ = @json(
            [
                'error' => session('error'),
                'email' => session('email'),
                'request'  => 'verificationMessage'
            ]
    );
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>
