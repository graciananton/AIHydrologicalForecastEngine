<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Station Message</title>

<div class="stationMessage">
    <div class="intro" style="margin-bottom:6px;">
        Hello User, the following is the prediction for your selected station.
    </div>
    <div class="title" style="margin-bottom:10px;">

        <div class="stationId">
            Station {{ $stationMessage['stationId'] }}
        </div>

        <div class="createdAt">
            - {{ substr($stationMessage['created_at'],0, 10) }}
        </div>

    </div>

    <div class="content" style="margin-bottom:10px;">
        {{ $stationMessage['message'] }}
    </div>
    <?php
    $stationId = $stationMessage['stationId'];
    ?>
    <div class="graphs">
        <img
            src="https://gracian.ca/forecasting/images/future/{{$stationId}}_temperature.png"
            alt=""
        >

        <img
            src="https://gracian.ca/forecasting/images/future/{{$stationId}}_wind_speed.png"
            alt=""
        >

        <img
            src="https://gracian.ca/forecasting/images/future/{{$stationId}}_precipitation.png"
            alt=""
        >

    </div>

</div>