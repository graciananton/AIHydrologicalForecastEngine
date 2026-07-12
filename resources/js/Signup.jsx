import React from "react";
import '../css/Login.css';
import { useState, useEffect } from "react";

export default function Signup({ data }){
    return (
        <div class='page'>
            <div class='card'>
                <div class='title'>Signup:</div>
                {data.error && (
                    <div class='error'>{data.error}</div>
                )
                }
                <form class='form' method="POST" action={`/laravel/public/signupSubmit`}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                        <input type='hidden' name='email' value={data.email} />
                        <div class='form-group'>
                            <label for='Email'>Email:</label><br/>
                            <input type='email' id='email' name='email' required/>
                        </div>
                        <div class='form-group'>
                            <label for="stationId">What station do you want to choose:</label>
                            <select name="stationId" id="stationId">
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
                    <option value={station.stationId} >{station.name} ({station.stationId})</option>
                )
            })

            setStations(stationElts);
        }
        getStations();
    }, [])

    console.log(stations);

    return stations;
}

