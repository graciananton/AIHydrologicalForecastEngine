import React from "react";
import '../css/UserStation.css';
import { useState, useEffect } from "react";

export default function UserStation({ data }){
    return (<Main {...data}/>); //sends data to Main component as object, not as property of object
}
function Main(station){
    return (
        <div id='main'>
            <Station stationId = {station.stationId}/>
            <UpdatedAt stationId = {station.stationId} />
            <Graph stationId = {station.stationId} />
            <Stats stationId = {station.stationId} />
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
        station && <div id='station' grid-area='station'>Station: {station.name} - {station.stationId}</div>
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

    console.log("updated at");
    console.log(updatedAt);
    return (
        updatedAt && 
        <div id = 'updatedAt' grid-area = 'updated'>
            Updated At: {updatedAt}
        </div>
    )
}
function Graph({ stationId }){
    return (
        <div id='graph' grid-area = 'graph'>
            <img src={'../images/future/' + stationId + '.png'} />
        </div>
    )
}

function Stats({ stationId }){
    console.log("Stats funciton");

    const [stats, setStats] = useState();

    useEffect(() => {
        async function getStats(stationId){
            try{
                console.log("Station Id");
                console.log(stationId);
                response = await fetch('http://gracian.ca/laravel/public/api/stats?stationId='+stationId);
                if(!response.ok){
                    throw new Error('Failed to fetch');
                }
                data = response.json();
                if(data.length < 1){
                    throw new Error('Data is empty');
                }
                console.log(data);

                setStats(data[0]);
            }
            catch(error){
                console.log(error);
            }
        }
        getStats(stationId);

    }, [stationId]);

    console.log(stats);

    return (
        stats && <div></div>
    )
}