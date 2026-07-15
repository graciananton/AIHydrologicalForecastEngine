import React from "react";
import '../css/Login.css';
import { useState, useEffect } from "react";

export default function Signup({ data }){
    console.log(data);
    return (
        <div className='page' style={{border:"1px solid black", display:"flex", justifyContent:"center", alignItems:"center"}}>
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
                            <input type='email' id='email' name='email'  defaultValue = {data.email ?? ""} required/>
                        </div>
                        <div className='form-group'>
                            <label htmlFor="stationId">What station do you want to choose:</label>
                            <select name="stationId" id="stationId" value = '02KF012'>
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
            const url = "https://gracian.ca/laravel/public/api/stations";
            const data = await fetch(url);
            console.log(data);
            const stations = await data.json();            
            const stationElts = stations.map((station) => {
                return (
                    <option value={station.stationId}>{station.name} ({station.stationId})</option>
                )
            })

            setStations(stationElts);
        }
        getStations();
    }, [])

    console.log(stations);

    return stations;
}

