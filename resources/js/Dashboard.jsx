import React from "react";
import { useState, useEffect } from "react";
import '../css/Dashboard.css';
import dayjs from 'dayjs';

function Stations({stations, setStations}){
    const url = "https://gracian.ca/laravel/public/api/stations";

    useEffect(() => {
        const fetchStations = async () => {
            const list_stations = await fetch(url);
            const json_stations = await list_stations.json();
            setStations(json_stations);
        }
        fetchStations();
    },[])

    return (
        <div id='stations'>
            <div>Station IDs</div>
            {stations.map(station => (
                <div>{station.stationId}</div>
            ))}
        </div>
    )
}

function TableSection({ section, categories }){
    return (
        <div>
            <div key='title'>{section.toUpperCase()}</div>
            <div key='categories'>
                {categories.map((category, index) => (
                    <div key={category}>{category}</div>
                ))}
            </div>
        </div>
    )
}

function MetricCells({section, stations}){    
    let createEndpoint;
    let type;
    let param;
    if(section == 'test'){
        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/test?stationId=${stationId}`
        param = 'error';
    }
    else if(section == 'train'){
        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/train?stationId=${stationId}&order=desc`
        param = 'error';
    }
    else if(section == 'future'){
        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/future?stationId=${stationId}`
        param = 'prediction';
    }

    const [metrics, setMetrics] = useState([]);

    useEffect(() => {
        const fetchResults = async () => {
            const promises = stations.map(async (station) => {
                const url = createEndpoint(station.stationId);
                const response = await fetch(url);
                const json = await response.json();
                return json;
            });
            const results = await Promise.all(promises);
            setMetrics(results);
        };
        fetchResults();
    }, [stations]);

   return (
        <>
        {
            metrics.map((metric,index) => {
                return <MetricCell metric = {metric} section = {section} param = {param} />
            })
        }
        </>
   )
}

function MetricCell({ metric, section, param }){
    const [showPopup, setShowPopup] = useState(false);
    let sum = 0;
    metric.map((individual_metric, index) => {
        sum = sum + individual_metric[param];
    })
    let average = sum/metric.length;
    console.log(metric);
    console.log(`../images/${section}/${metric[0].stationId}.png`);
    
    stationId = metric[0].stationId; 

    return (
        <div>
            {(section == 'test' || section == 'future') && 
                (
                    <>
                    <div>{Math.round(metric.at(-1)[param]*100000)/100000}</div>
                    <div>{Math.round(average*100000)/100000}</div>
                    </>
                )
            }
            <div>{dayjs(metric.at(-1).updated_at).format("YYYY-MM-DD HH")}</div>
            <div onMouseEnter={() => setShowPopup(true)} onMouseLeave={() => setShowPopup(false)}>
                Graphs
                {showPopup && (
                    <div>
                        <img src={`../images/${section}/${stationId}.png`} alt='Plotted Graph'/>
                    </div>
                )}

            </div>
        </div>
    )
}

export default function Dashboard(){
    const [stations, setStations] = useState([]);
    return (
        <div id='dashboard'>
            <div id='datasets'>
                <Stations 
                    stations = {stations}
                    setStations = {setStations}
                />
                <div id='test'>
                    <TableSection section='test' categories={['RMSE(daily)','RMSE(weekly)','Last Updated','Graphs']} />
                    <MetricCells section='test' stations={stations}/>
                </div>

                <div id='train'>
                    <TableSection section='TRAIN' categories={['Last Updated','Graphs']} />
                    <MetricCells section='train' stations={stations}/>

                </div>
                <div id='future'>
                    <TableSection section='FUTURE' categories={['Predictions(daily)','Predictions (weekly)','Last Updated','Graphs']} />
                    <MetricCells section='future' stations={stations}/>
                </div>
            </div>
        </div>
    )
}