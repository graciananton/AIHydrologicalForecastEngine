import React from "react";
import '../css/Login.css';
import { useState, useEffect } from "react";

export default function StationId({ data }){
    console.log(data);

    return (
        <div id='station_page'>
            <div id='login' className='container-fluid'>
                {data.error && (
                <div id='error'>{data.error}</div>
                )
                }
                <div id='title'>Station Id Selection:</div>
                <form method="GET" action={`/laravel/public/verificationCode`}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                    <div className='form-group'>
                        <label htmlFor="cars">What station do you want to choose:</label>
                        <select name="cars" id="cars">
                            {getStations()}
                        </select> 
                    </div>
                    <button type='submit'>Submit</button>
                </form>
            </div>
        </div>
    );
}

function getStations(){
    console.log("getting stations");
    const [stations, setStations] = useState(<></>)

    useEffect(() => {
        console.log("inside useEffect");
        async function getStations(){
            const url = "http://gracian.ca/laravel/public/api/stations";
            const data = await fetch(url);
            console.log(data);
            const stations = await data.json();


            console.log(stations)
            
            const stationElts = stations.map((station) => {
                console.log(station);
                return (
                    <option value={station.stationId} >{station.name}</option>
                )
            })

            setStations(stationElts);
        }
        getStations();
    }, [])

    console.log(stations);

    return stations;
}