import React from "react";
import '../css/UserStation.css';
import { useState, useEffect } from "react";

export default function UserStation(){
    const station = window.__REACT_DATA__;
    return (<Main station = {station}/>);
}
function Main(station){
    return (
        <div id='main'>
            <Station stationId = {station.stationId}/>
        </div>
    )
}
function Station(stationId){

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