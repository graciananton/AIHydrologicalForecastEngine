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
