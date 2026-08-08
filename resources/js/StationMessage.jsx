import React from "react";
import '../css/StationMessage.css';
import { useState, useEffect , useContext} from "react";
import { BaseUrlContext } from "./BaseUrlContext";

export default function StationMessage({ data }){
    const [stationMessage, setStationMessage] = useState({});
    const base_url = useContext(BaseUrlContext);

    useEffect(() => {
        async function getStationMessage(){
            const url = "https://gracian.ca/forecasting/public/api/stationMessage?stationId=" + data.stationId + "&order=desc&limit=1";
            const response = await fetch(url);
            let data = await response.json();
            data = data[0];
            setStationMessage(data);
        }
        getStationMessage();
    },[])

    return (
        (Object.keys(stationMessage).length > 0) &&
            (
            <div className='stationMessage'>
                <div className='title'>
                    <div className='stationId'>Station {stationMessage.stationId}</div>
                    <div className='createdAt'>- {stationMessage.created_at}</div>
                </div>
                <div className='content'>
                    {stationMessage.message}
                </div>
                <div className='graphs'>
                    <img src={base_url + "/images/"+stationMessage.stationId+"_temperature.png"} alt = ''/>
                    <img src={base_url + "/images/"+stationMessage.stationId+"_wind_speed.png"} alt = ''/>
                    <img src={base_url + "/images/"+stationMessage.stationId+"_precipitation.png"} alt = ''/>
                </div>
            </div>
            )
    )
}
