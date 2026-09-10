<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Station Message</title>

<div class="stationMessage">
    <div class="intro" style="margin-bottom:6px;">
        Hello {{$user}},
    </div>
    <div class="title" style="margin-bottom:10px;">

        <div class="stationId">
             {{ $station }}
            <?php
                
            ?>
        </div>

        <div class="createdAt">
            Generated At: {{ $date }}
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