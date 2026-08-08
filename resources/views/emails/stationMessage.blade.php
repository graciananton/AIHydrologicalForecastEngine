<!doctype html>
<html>
<title>AI Forecast Engine - Station Message</title>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])

</head>
<body>
    <script>
        console.log("landed on stationmessage blade.php");
        data = @json(
            [
                'request' => $request,
                'stationId' => $stationId
            ]
        );
        window.__REACT_DATA__ = data;
        
    </script>
    <div id="react-root"></div>
</body>
</html>
