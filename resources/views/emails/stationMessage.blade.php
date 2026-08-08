<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Station Message</title>

<div class="stationMessage">

    <div class="title">

        <div
            class="stationId"
            style="
                font-size: clamp(12px, 15px, 18px);
            "
        >
            Station {{ $stationMessage['stationId'] }}
        </div>

        <div
            class="createdAt"
            style="
                font-size: clamp(12px, 15px, 18px);
                font-weight: bold;
            "
        >
            - {{ $stationMessage['created_at'] }}
        </div>

    </div>

    <div
        class="content"
        style="
            font-size: clamp(12px, 15px, 18px);
        "
    >
        {{ $stationMessage['message'] }}
    </div>
    <?php
    $stationId = $stationMessage['stationId'];
    ?>
    <div class="graphs">
        <img
            src="https://gracian.ca/laravel/images/future/{{$stationId}}_temperature.png"
            alt="Temperature Graph"
            style="
                width: 100%;
                height: auto;
            "
        >

        <img
            src="https://gracian.ca/laravel/images/future/{{$stationId}}_wind_speed.png"
            alt="Wind Speed Graph"
            style="
                width: 100%;
                height: auto;
            "
        >

        <img
            src="https://gracian.ca/laravel/images/future/{{$stationId}}_precipitation.png"
            alt="Precipitation Graph"
            style="
                width: 100%;
                height: auto;
            "
        >

    </div>

</div>