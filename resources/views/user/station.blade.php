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
        console.log("Station in user");

        data = @json(
            [
                'request' => $request,
                'email' => $email,
                'stationId' => $stationId
            ]
        );
        
        console.log("Data");
        console.log(data);

        window.__REACT_DATA__ = data;
    </script>
    <div id="react-root"></div>
</body>
</html>
