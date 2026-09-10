<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Station Message</title>

<div class="stationMessage">
    <div class='visualization' style='margin-bottom:6px;'>
        <img src='https://gracian.ca/forecasting/images/banner/slides1.png' alt='' width='100%'/>
    </div>
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
            Generated at: {{ $date }}<br/>
            Graphical Visualization: Included as attachments below
        </div>

    </div>

    <div class="content" style="margin-bottom:10px;">
        {{ $stationMessage['message'] }}
    </div>
    <?php
    $stationId = $stationMessage['stationId'];
    ?>

</div>