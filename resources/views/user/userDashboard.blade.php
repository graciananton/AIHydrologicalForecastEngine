<!doctype html>
<html>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
    <title>Hydrological Forecast Engine - User Station</title>
    <link rel="icon" type="image/x-icon" href="https://gracian.ca/forecasting/images/favicon/favicon.png">
</head>
<body>
    <script>

        data = @json(
            [
                'jobs' => $jobs,
                'users' => $user
            ]
        );
        
        console.log("Data");
        console.log(data);

        window.__REACT_DATA__ = data;
    </script>
    <div id="react-root"></div>
</body>
</html>
