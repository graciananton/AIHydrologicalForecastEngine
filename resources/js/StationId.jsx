import React from "react";
import '../css/Login.css';
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
                <form method="POST" action={`/laravel/public/verificationCode`}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                    <div className='form-group'>
                         <label for="cars">What station do you want to choose:</label>
                        <select name="cars" id="cars">
                            {
                                useEffect(() => {
                                    function getStations(){
                                        data = await fetch("http://gracian.ca/laravel/public/api/stations");
                                        stations = data.json();
                                        stations.map((station) => {
                                            <option value = {station.stationId} >{station.name}</option>
                                        })
                                    }
                                    getStations();
                                }, [])
                            }
                        </select> 
                    </div>
                    <button type='submit'>Submit</button>
                </form>
            </div>
        </div>
    );
}