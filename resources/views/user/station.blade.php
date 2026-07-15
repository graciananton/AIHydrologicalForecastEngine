<!doctype html>
<html>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])

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
