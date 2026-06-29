import React from "react";
import '../css/UserStation.css';

export default function UserStation(){
    const data = window.__REACT_DATA__;
    console.log(data);
    return (<Main />);
}
function Main(){
    return (
        <div id='main'>
            
        </div>
    )
}
function station(){
    const [station, setStation] = useState([]);

    useEffect(() => {
        async function getStation(stationId) {
            const response = await fetch('/')
            const data = await response.json();
            setStation([data.station, data.stationId])
        }
    });

    return (
        <div>Station: {{station}} - {{stationId}}</div>
    )
}