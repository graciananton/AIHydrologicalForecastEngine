<!doctype html>
<html>
<title>Verification Code</title>
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
                ['email' => session('email')],
                ['request'  => 'verificationCode']
            ]
    );
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
</body>
</html>
