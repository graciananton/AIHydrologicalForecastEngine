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
        console.log(@json($readings))
        console.log(@json($weather))
        console.log(@json($status))
        window.__REACT_DATA__ = @json([$readings,$weather,$status]);
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
