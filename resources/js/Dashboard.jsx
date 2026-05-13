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
    if(section == 'test'){
        console.log("Test block")

        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/test_evaluations?stationId=${stationId}`

        type = 'error';
    }
    else if(section == 'future'){
        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/predictions?stationId=${stationId}`
        type = 'prediction';
    }
    console.log(createEndpoint);

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

    console.log(metrics);

   return (
        <>
        {
            metrics.map((metric,index) => {
                return <MetricCell metric = {metric} type = {type} />
            })
        }
        </>
   )
}

function MetricCell({ metric, type }){
    const [showPopup, setShowPopup] = useState(false);
    console.log(metric);
    let sum = 0;
    metric.map((individual_metric, index) => {
        sum = sum + individual_metric[type];
    })
    let average = sum/metric.length;
    return (
        <div>
            {(type == 'error' || type == 'prediction') && 
                (
                    <>
                    <div>{Math.round(metric.at(-1)[type]*100000)/100000}</div>
                    <div>{Math.round(average*100000)/100000}</div>
                    </>
                )
            }
            <div>{dayjs(metric.at(-1).updated_at).format("YYYY-MM-DD HH:mm")}</div>
            <div onMouseEnter={() => setShowPopup(true)} onMouseLeave={() => setShowPopup(false)}>
                Graphs
                {showPopup && (
                    <div>
                        <img src={`../images/train/${metric[0].stationId}.png`} alt='Train images'/>
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
                </div>
                <div id='future'>
                    <TableSection section='FUTURE' categories={['Predictions(daily)','Predictions (weekly)','Last Updated','Graphs']} />
                    <MetricCells section='future' stations={stations}/>
                </div>
            </div>
        </div>
    )
}