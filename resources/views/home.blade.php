<!doctype html>
<html>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
    <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    />
    <script 
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
    
    

    <title>AI Forecast Engine - Home</title>
</head>
<body>
    <script>
    let request = <?php echo json_encode($request); ?>;
    console.log(request);
    
    let elements = document.getElementsByTagName("title");
    console.log("Elements: ");
    console.log(elements);

    let element = elements[0]

    request = request.split("")
    request[0] = request[0].toUpperCase();
    requestStr = request.join("");

    element.innerHTML = "Hydrological Forecasting Systems - " + requestStr;

    </script>
    <script>
    window.__REACT_DATA__ = @json([
                        'request'  => $request
                    ]);
    </script>
    <div id="react-root"></div>
</body>
</html>


