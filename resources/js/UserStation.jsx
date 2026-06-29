import React from "react";
import '../css/UserStation.css';
import { useState, useEffect } from "react";

export default function UserStation({ data }){
    return (<Main {...data}/>);
}
function Main(station){
    console.log("Main:");
    console.log(station);
    return (
        <div id='main'>
            <Station stationId = {station.stationId}/>
        </div>
    )
}
function Station(stationId){    
    console.log("Station Id: " + stationId);

    const [station, setStation] = useState([]);

    useEffect(() => {
        async function getStation(stationId) {
            const response = await fetch('http://gracian.ca/laravel/public/api/stations?stationId='+str(stationId));
            const data = await response.json();
            setStation(data);
        }
    },[stationId]);

    return (
        station && <div id='station' grid-area='station'>Station: {station.name} - {station.stationId}</div>
    )
}