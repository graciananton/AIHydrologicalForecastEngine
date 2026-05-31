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
        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/test?stationId=${stationId}&order=desc`
        param = 'error';
    }
    else if(section == 'train'){
        // this is for re-training the model
        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/train?stationId=${stationId}&order=desc`
        param = 'error';
    }
    else if(section == 'future'){
        createEndpoint = (stationId) => `https://gracian.ca/laravel/public/api/future?stationId=${stationId}&order=desc`
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
    let stationId = "";
    let sum = 0;
    metric.map((individual_metric, index) => {
        sum = sum + individual_metric[param];
    })
    let average = sum/metric.length;
    
    if(section == 'test' || section == 'future'){
        stationId = metric[0].stationId; 
    }
    else if(section=='train'){
        stationId = (metric[0]).input.stationId;
    }

    return (
        <div>
            {(section == 'test' || section == 'future') && 
                (
                    <>
                    <div>{Math.round(metric[0][param]*100000)/100000}</div>
                    <div>{Math.round(average*100000)/100000}</div>
                    </>
                )
            }
            <div>{(metric[0].updated_at).substring(0,13)}</div>
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

function Datasets({stations, setStations}){
    return (
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
    )
}

function Header({ categories }) {
    return (
        <div>
            {
                categories.map((category, index) => (
                    <div key={index}>
                        {category}
                    </div>
                ))
            }
        </div>
    );
}

function ServiceRow({ category }){
    const createEndpoint = (category) => `http://gracian.ca/laravel/public/api/${category}?order=desc&limit=1`;
    const [updated, setUpdated] = useState([]);

    useEffect(() => {
        const fetchResults = async () => {
            let updated = await fetch(createEndpoint(category));
            let json = await updated.json();
            setUpdated(json[0].updated_at);
        };
        fetchResults();
    }, []);
    return (
    <div>
        <div>{category.charAt(0).toUpperCase() + category.slice(1)}</div>
        <div>{"hourly"}</div>
        <div>{dayjs(updated).format("YYYY-MM-DD HH")}</div>
        
    </div>
    );
}

function Status(){
    return (
        <div id='status'>
            <Header categories={['Services','Schedule','Updated']} />
            <ServiceRow category="weather" />
            <ServiceRow category="readings" />
            <ServiceRow category="statuses" />
        </div>
    )
}
export default function Dashboard(){
    const [stations, setStations] = useState([]);
    return (
        <div id='dashboard'>
            <Datasets stations = {stations} setStations = {setStations}/>
            <Status />
        </div>
    )
}