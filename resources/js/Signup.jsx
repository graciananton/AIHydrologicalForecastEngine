import React from "react";
import '../css/Login.css';
import { useState, useEffect } from "react";

export default function Signup({ data }){
    console.log(data);
    return (
        <div className='page'>
            <div className='card'>
                <div className='title'>Signup:</div>
                {data.error && (
                    <div className='error'>{data.error}</div>
                )
                }
                <form className='form' method="POST" action={`/laravel/public/signupSubmit`}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                        <div className='form-group'>
                            <label htmlFor='Email'>Email:</label><br/>
                            <input type='email' id='email' name='email'  value = {data.email ?? ""} required/>
                        </div>
                        <div className='form-group'>
                            <label htmlFor="stationId">What station do you want to choose:</label>
                            <select name="stationId" id="stationId">
                                {getStations(data.stationId)}
                            </select> 
                        </div>
                    <button type='submit'>Submit</button>
                </form>
            </div>
        </div>
    );
}

function getStations(stationId){
    console.log("getting stations");
    const [stations, setStations] = useState(<></>)

    useEffect(() => {
        console.log("inside useEffect");
        async function getStations(){
            const url = "https://gracian.ca/laravel/public/api/stations";
            const data = await fetch(url);
            console.log(data);
            const stations = await data.json();


            console.log(stations)
            
            const stationElts = stations.map((station) => {
                console.log(station);
                return (
                    <option value={station.stationId} selected = { station.stationId == stationId ? selected : "" } >{station.name} ({station.stationId})</option>
                )
            })

            setStations(stationElts);
        }
        getStations();
    }, [])

    console.log(stations);

    return stations;
}

