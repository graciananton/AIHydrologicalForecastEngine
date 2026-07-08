import React from "react";
import '../css/UserStation.css';
import { useState, useEffect } from "react";

export default function UserStation({ data }){
    return (<Main {...data}/>); //sends data to Main component as object, not as property of object
}
function Main(station){
    const stationId = station.stationId;
    return (
        <div id='main'>
            <Station stationId = {stationId}/>
            <UpdatedAt stationId = {stationId} />
            <Graph stationId = {stationId} />
            <Stats stationId = {stationId} />
            <Predictions stationId = {stationId} />
            <Weather stationId = {stationId} />
            <Readings stationId = {stationId} />
            <CurrentWeather stationId = {stationId} />
            <Footer />
        </div>
    )
}
function Footer(){
    return (
        <div id='footer'>&copy;{new Date().getFullYear()} AI Hydrological Forecasting Engine. All rights reserved.</div>
    )
}
function CurrentWeather({stationId}){
    const [currentWeather, setCurrentWeather] = useState();

    useEffect(() => {
        async function getCurrentWeather(stationId){
            try{
                let from = new Date().toISOString();
                
                let to = new Date(from);

                to.setUTCMinutes(to.getUTCMinutes() + 59);

                to = to.toISOString();

                const response = await fetch('http://gracian.ca/laravel/public/api/weather?stationId='+ stationId+'&from='+from+'&to='+to);
                
                if(!response.ok){
                    throw new Error("Failed to fetch");
                }

                const data = await response.json();
                if(data.length < 1){
                    throw new Error("Data length < 1");
                }

                setCurrentWeather(data[0]);
            }
            catch(error){
                console.log(error);
            }
        }
        getCurrentWeather(stationId);
    },[stationId]);

    console.log("Current Weather");
    console.log(currentWeather);
    if(currentWeather){
        const rain = currentWeather.weather.rain
        let message;
        let image;
        if(rain == 0){
            message = "No Rain";
            image = 'sunny'
        }
        else if(rain < 5){
            message = "Light Rain";
            image = 'drizzle'
        }
        else{
            message = "Rain"
            image = 'rain'
        }
        return (
            <div id='currentWeather'>
                <div id='image'>
                    <img src={'../images/user/weather/'+image+'.png'} alt=''/>
                </div>
                <div id='title'>Current Weather:</div>
                <div id='temperature'>{currentWeather.weather.temperature_2m} &deg;C</div>
                <div id='message'>
                    {message}
                </div>
            </div>
        )
    }
}
function Weather({stationId}){
    const [weather, setWeather] = useState();

    useEffect(() => {
        async function getWeather(stationId){
            try{
                let from = new Date().toISOString();
                
                let to = new Date(from);

                to.setUTCMinutes(to.getUTCMinutes() + 59);

                to = to.toISOString();

                const response = await fetch('http://gracian.ca/laravel/public/api/weather?stationId='+ stationId+'&from='+from+'&to='+to);
                if(!response.ok){
                    throw new Error("Failed to fetch");
                }

                const data = await response.json();
                if(data.length < 1){
                    throw new Error("Data length < 1");
                }

                setWeather(data[0]);
            }
            catch(error){
                console.log(error);
            }
        }
        getWeather(stationId);
    }, [stationId])

    return (weather && 
        <div id='weather'>
            <div id='title'>
                <div>
                    <img src='../images/user/weather.png' alt=''/>
                </div>
                <div>
                    Current Weather Details:
                </div>
            </div>
            <div id='details'>
                <div><span>Temperature:</span><span>{weather.weather.temperature_2m}°C</span></div>
                <div><span>Precipitation:</span><span>{weather.weather.precipitation} mm</span></div>
                <div><span>Snowfall:</span><span>{weather.weather.snowfall} cm</span></div>
                <div><span>Relative Humidity:</span><span>{weather.weather.relative_humidity_2m}%</span></div>
                <div><span>Pressure:</span><span>{weather.weather.pressure_msl} hPa</span></div>
                <div><span>Rain:</span><span>{weather.weather.rain} mm</span></div>
                <div><span>Wind Speed:</span><span>{weather.weather.wind_speed_10m} km/h</span></div>
            </div>
        </div>
    );
}
function Readings({stationId}){
    const [readings, setReadings] = useState();

    useEffect(() => {
        async function getReadings(){
            try{
                const response = await fetch("http://gracian.ca/laravel/public/api/readings?stationId="+stationId+"&order=desc&limit=5");
                if(!response.ok){
                    throw new Error("Failed to fetch");
                }
                const data = await response.json();
                if(data.length < 3){
                    throw new Error("Data length < 3")
                }
                setReadings(data);
            }
            catch(error){
                console.log(error)
            }
        }
        getReadings();
    },[stationId]);
    
    return (
        readings && 
        <div id='readings'>
            <div id='title'>
                <div>
                    <img src='../images/user/weather.png' alt=''/>
                </div>
                <div>
                    Latest Readings:
                </div>
            </div>
            <div id='details'>
                <ul>
                    {
                        readings.map((reading,index) => {
                            if(index + 1 < readings.length){
                                console.log("Reading:");
                                console.log(reading);
                                console.log(index);
                                let prev = readings[index+1];
                                console.log("Prev:");
                                console.log(prev);
                                return (
                                    <li key={index}>
                                        <span>{ convertUTCToFormattedTime(reading.measuredAt, ['month', 'date', 'hour', 'minute', 'timePeriod']) }</span>
                                        <span>{ reading.level } m</span>
                                        <span>{ (String(Math.round((reading.level - prev.level)*1000)/1000)).padStart(4,"0") + " m"}</span>
                                    </li>
                                );
                            }
                        })
                    }
                </ul>
            </div>
        </div>
    )
}
function Station({stationId}){    

    const [station, setStation] = useState();

    useEffect(() => {
        async function getStation(stationId) {
            try{
                const response = await fetch('http://gracian.ca/laravel/public/api/stations?stationId='+String(stationId));
                
                if (!response.ok) {
                    throw new Error("Failed to fetch");
                }

                const data = await response.json();

                if(data.length < 1){
                    throw new Error("Data is empty");
                }
                setStation(data[0]);
            }
            catch(error){
                console.log(error);
            }
        }
        getStation(stationId);
    },[stationId]);
    
    return (
        station && 
        <div id='station'>
            <div id='image'>
                <img src='../images/user/station.png' alt='' />
            </div>
            <div id='title'>Station:</div> 
            <div id='name'>{capitalizeFirstLetter(station.name)}</div>
            <div id='id'>ID: {station.stationId}</div>
        </div>
    )
}

function convertUTCToFormattedDate(UTCDate){
    let updatedAtUTC = new Date(UTCDate); // convert to ISO format

    let month = updatedAtUTC.toLocaleString('en-US',{
        month: "long",
        timeZone: "UTC"
    });
    let dayOfMonth = updatedAtUTC.getUTCDate();
    let year = updatedAtUTC.getUTCFullYear();
    let hour = updatedAtUTC.getUTCHours();

    let timePeriod;
    if(hour > 12){
        hour = hour % 12;
        timePeriod = "PM"
    }
    else{
        timePeriod = "AM"
    }
    let minute = updatedAtUTC.getUTCMinutes();

    return (
        <>
        {month} {dayOfMonth}, {year} {hour}:{minute} {timePeriod}
        </>
    );
}
function convertUTCToFormattedTime(UTCDate, options){
    let dateObject = new Date(UTCDate); // convert to ISO format
    let timeZoneOffset = dateObject.getTimezoneOffset();
    dateObject.setMinutes(dateObject.getMinutes() - (timeZoneOffset));

    const getAMPM = (hour) => hour >= 12 ? "PM" : "AM";
    
    const getTimeOffset = (hour) => hour > 12 ? hour - 12 : hour;

    const monthName = dateObject.toLocaleString("en-US", {
        month: "long"
    });
    
    console.log("Options");
    console.log(options);
    return (
        <>
        {options.includes("month") ? String(monthName) + " ": ""}{options.includes("date") ? String(dateObject.getUTCDate()) + ", ": ""}{options.includes("hour") ? String(getTimeOffset(dateObject.getUTCHours())): ""}:{options.includes("minute") ? String(String(dateObject.getMinutes()).padStart(2,"0")) + " ":""}{options.includes("timePeriod") ? getAMPM(dateObject.getUTCHours()): ""}
        </>
    )
}


function UpdatedAt({ stationId }){
    const [updatedAt, setUpdatedAt] = useState() // gets the ISO864 format of 1970-01-01

    useEffect(() => {
        async function getUpdatedAt(stationId){
            try{
                const response = await fetch('http://gracian.ca/laravel/public/api/future?stationId='+String(stationId)+'&order=desc&limit=1');
                if(!response.ok){
                    throw new Error('Failed to fetch')
                }

                const data = await response.json();
                
                if(data.length < 1){
                    throw new Error("Data is empty");
                }

                setUpdatedAt(data[0].updated_at);
            }
            catch(error){
                console.log(error);
            }
        }
        getUpdatedAt(stationId);
    }, [stationId]);

    /*
    let updatedAtUTC = new Date(updatedAt);
    let month = updatedAtUTC.toLocaleString('en-US',{
        month: "long",
        timeZone: "UTC"
    });
    let dayOfMonth = updatedAtUTC.getUTCDate();
    let year = updatedAtUTC.getUTCFullYear();
    let hour = updatedAtUTC.getUTCHours();

    let timePeriod;
    if(hour > 12){
        hour = hour % 12;
        timePeriod = "PM"
    }
    else{
        timePeriod = "AM"
    }
    let minute = updatedAtUTC.getUTCMinutes();
    */
    const formattedDate = convertUTCToFormattedTime(updatedAt, ['month', 'date', 'hour', 'minute', 'timePeriod']);
    return (
        updatedAt && 
        <div id = 'updatedAt'>
            <div id='image'>
                <img src='../images/user/updatedAt.png' alt='' />
            </div>
            <div id='title'>Last Updated:</div> 
            <div id='ago'>{(Math.round((new Date() - new Date(updatedAt)) / (1000 * 60 * 60))*100)/100} hrs. ago</div>
            <div id='time'>{formattedDate}</div>
        </div>
    )
}

function Graph({ stationId }){
    return (
        <div id='graph'>
            <div id='title'>
                <div>
                    <img src='../images/user/forecast.png' alt=''/>
                </div>
                <div>
                    Water Level Forecast
                </div>
            </div>
            <div id='image'>
                <img src={'../images/future/' + stationId + '.png'} />
            </div>
        </div>
    )
}

// this function checks is a given value is numeric (including strings which contain only numerical characters) and returns true or false
function isNumeric(value) {
    return typeof value === "number"
        ? !Number.isNaN(value)
        : typeof value === "string" &&
          value.trim() !== "" &&
          !Number.isNaN(Number(value));
}

function capitalizeFirstLetter(name){
    let nameCharList = name.split(" ");

    for(let i = 0; i < nameCharList.length; i++){
        nameCharList[i] = (nameCharList[i]).toLowerCase();
        nameCharList[i] = [...nameCharList[i]];
        nameCharList[i][0] = nameCharList[i][0].toUpperCase();
        nameCharList[i] = nameCharList[i].join("");
    }

    return nameCharList.join(" ");
}
//prediction => Prediction
//predictedFor => Predicted For:
//predictedAtFor => Predicted At For
//updated_at => Updated At
function correctlyCapitalize(label){
    const labelChars = [...label];
    let correctLabelChars = [];
    let space = false;

    let char;
    for(let i = 0; i < labelChars.length; i++){
        char = labelChars[i]

        if(i == 0){
            correctLabelChars.push(char.toUpperCase());
        }
        else if(char >= "A" && char <= "Z"){
            correctLabelChars.push(" ");
            correctLabelChars.push(char);
        }
        else if(char == "_"){
            correctLabelChars.push(" ")
            space = true
        }
        else{
            if(space == true){
                correctLabelChars.push(char.toUpperCase());
                space = false
            }
            else{
                correctLabelChars.push(char);
            }
        }
    }

    return correctLabelChars.join("");
}
function Predictions({ stationId }){
    const current = new Date().toISOString();
    const [predictions, setPredictions] = useState();
    useEffect(() => {
        async function getPredictions(stationId){
            const response = await fetch('http://gracian.ca/laravel/public/api/future?stationId='+stationId+'&order=asc&limit=8&from='+current);
            const data = await response.json();
            setPredictions(data);
        }
        getPredictions(stationId);
    }, [stationId]);
    
    //generate html
    return (
        predictions && 
        <div id='predictions'> 
            <div id='title'>
                <div>
                    <img src='../images/user/predictions.png' alt=''/>
                </div>
                <div>
                    Predictions:
                </div>
            </div>
            <div id='predict'>
                <ul>
                            <li>
                                <span>Time</span>
                                <span>Prediction</span>
                                <span>Relative To <br/>Previous Water Levels</span>
                            </li>
                            {
                            predictions.map((prediction, index) => {
                                    return (
                                        <li key={index}>
                                            <span>{convertUTCToFormattedTime(prediction.predictedFor, ['hour', 'minute', 'timePeriod'])}</span>
                                            <span>{Math.round(prediction.prediction*10000)/10000} m</span>
                                            <span>
                                                <span>{Math.round(parseFloat(prediction.percentile) * 10000)/10000} <sup>th</sup></span><br/>
                                                <progress 
                                                    value= {prediction.percentile} 
                                                    max='100'
                                                > 
                                                {Math.round(parseFloat(prediction.percentile) * 10000)/10000} 
                                                </progress>
                                            </span>
                                        </li>
                                    );
                            })
                            }
                </ul>
            </div>
        </div>
    );
}


function Stats({ stationId }){

    const [stats, setStats] = useState();

    // react re-renders useEffect after updating the state stats
    useEffect(() => {
        async function getStats(stationId){
            try{
                const response = await fetch('http://gracian.ca/laravel/public/api/stats?stationId='+stationId);
                if(!response.ok){
                    throw new Error('Failed to fetch');
                }
                const data = await response.json();
                if(data.length < 1){
                    throw new Error('Data is empty');
                }

                setStats(data);
            }
            catch(error){
                console.log(error);
            }
        }
        getStats(stationId);

    }, [stationId]);
    let counter = 0;
    return (
        stats && 
        <div id='stats'>
            <div id='title'>
                <div>
                    <img src='../images/user/stats.png' alt=''/>
                </div>
                <div>
                    Stastics:
                </div>
            </div>
            <div id='stastics'>
                <ul>
                    {
                        Object.keys(stats).map(key => (
                            <li key={key}>
                                <span>{correctlyCapitalize(key)}: </span>
                                <span>
                                {
                                    (isNumeric(stats[key]) && !Number.isNaN(stats[key])) 
                                    ? 
                                    (Math.round(stats[key]*10000)/10000 + " m.")
                                    : 
                                    stats[key]
                                }
                                </span>
                            </li>
                        ))
                    }
                </ul>
            </div>
        </div>
    )
}
function isISO8601(str) {
    const date = new Date(str);
    return !isNaN(date.getTime()) && str === date.toISOString();
}