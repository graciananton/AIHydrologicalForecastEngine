<!doctype html>
<html>
<title>AI Forecast Engine - Dashboard</title>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="https://gracian.ca/forecasting/images/favicon/favicon.png">
</head>
<body>
    <?php
    /*
    $data = [
    "request" => $request
    ];

    $json = json_encode($data);
    */
    ?>
    <script>
        
        data = @json(
            [
            'request' => 'dashboard'
            ]
            )

        console.log(data);
        window.__REACT_DATA__ = data;
    </script>

    <div id="react-root"></div>
</body>
</html>
