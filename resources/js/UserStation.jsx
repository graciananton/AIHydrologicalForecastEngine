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

    return (currentWeather && 
        <div id='currentWeather'>
            Temperature: {currentWeather.weather.temperature_2m}
            Rain: {currentWeather.weather.rain}
        </div>
    )
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
            <div id='title'>Station</div> 
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

    return (
        updatedAt && 
        <div id = 'updatedAt'>
            Updated At: {updatedAt}
        </div>
    )
}
function Graph({ stationId }){
    return (
        <div id='graph'>
            <img src={'../images/future/' + stationId + '.png'} />
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
                            {correctlyCapitalize(key)} - {stats[key]}
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

    //generate html
    return (
        predictions && 
        <div id='predictions'> 
            <table>
                <tbody>
                    {
                        predictions.map((prediction, index) => {
                            return (
                                <tr key={index}>
                                    <td>{prediction.prediction}</td>
                                    <td>{prediction.predictedFor}</td>
                                </tr>
                            );
                        })
                    }
                </tbody>
            </table>
        </div>
    );
}