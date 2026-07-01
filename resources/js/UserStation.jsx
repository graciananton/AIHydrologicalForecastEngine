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
        <div>@{new Date().getFullYear()} AI Hydrological Forecasting Engine. All rights reserved.</div>
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
            <div>Temperature - {weather.weather.temperature_2m}</div>
            <div>Precipitation - {weather.weather.precipitation}</div>
            <div>Snowfall - {weather.weather.snowfall}</div>
            <div>Relative Humidity - {weather.weather.relative_humidity_2m}</div>
            <div>Presure - {weather.weather.presure_msl}</div>
            <div>Rain - {weather.weather.rain}</div>
            <div>Wind Speed - {weather.weather.wind_speed_10m}</div>
        </div>
    );
}
function Readings({stationId}){
    const [readings, setReadings] = useState();

    useEffect(() => {
        async function getReadings(){
            try{
                const response = await fetch("http://gracian.ca/laravel/public/api/readings?stationId="+stationId+"&order=desc&limit=3");
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
            {
                readings.map((reading,index) => {
                    return (
                        <div key={index}>
                            { index + 1 } { reading.level }
                        </div>
                    );
                })
            }
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
    return (
        updatedAt && 
        <div id = 'updatedAt'>
            <div id='image'>
                <img src='../images/user/updatedAt.png' alt='' />
            </div>
            <div id='title'>Last Updated:</div> 
            <div id='ago'>{(Math.round((new Date() - new Date(updatedAt)) / (1000 * 60 * 60))*100)/100} hrs. ago</div>
            <div id='time'>{month} {dayOfMonth}, {year} {hour}:{minute} {timePeriod}</div>
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

    return (
        stats && 
        <div id='stats'>
            <ul>
                {
                    Object.keys(stats).map(key => (
                        <li key={key}>
                            <span>{correctlyCapitalize(key)}: </span>
                            <span>{stats[key]}</span>
                        </li>
                    ))
                }
            </ul>
        </div>
    )
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
            const response = await fetch('http://gracian.ca/laravel/public/api/future?stationId='+stationId+'&order=desc&limit=24&from='+current);
            const data = await response.json();
            setPredictions(data);
        }
        getPredictions(stationId);
    }, [stationId]);

    let counter = 0;
    //generate html
    return (
        predictions && 
        <div id='predictions'> 
            <table>
                <tbody>
                    {
                    
                        predictions.map((prediction, index) => {
                            counter ++;
                            if(counter < 10){
                                return (
                                    <tr key={index}>
                                        <td>{prediction.prediction}</td>
                                        <td>{prediction.predictedFor}</td>
                                    </tr>
                                );
                            }
                        })
                    }
                </tbody>
            </table>
        </div>
    );
}