import React from "react";
import { useState, useEffect } from "react";
import '../css/Dashboard.css';

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
            <div>{section.toUpperCase()}</div>
            <div>
            {categories.map((category, index) => (
                <div>{category}</div>
            ))}
            </div>
        </div>
    )
}
function MetricCells({ section, stations }){
    const now = new Date();
    const sevenDaysBefore = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000).toISOString();
    {useEffect(() => {
        return (
            <>
            {stations.map(station => {
                const fetchMetrics = async (station) => {
                    const url = `https://gracian.ca/laravel/public/api/test_evaluations?from=${sevenDaysBefore}&stationId=${station.stationId}&order=asc`;
                    const metrics = await fetch(url);
                    const json_metrics = await metrics.json();
                    console.log(json_metrics);
                    <MetricCell section = {section} stationId={station.stationId} metrics={json_metrics}/>
                }
                fetchMetrics(station);
            })};
            </>
        )
    }, [stations])}
}
function MetricCell({ section, stationId, metrics }){
    const [showPopup, setShowPopup] = useState(false);
    sum = 0;
    for(const metric of metrics){
        sum += metric['error'];
    }
    average = sum/metrics.length;
    return (
        <div>
            <div>{metrics[metrics.length-1]['error']}</div>
            <div>{average}</div>
            <div>{metrics[metrics.length-1]['updated_at']}</div>
            <div 
                onMouseEnter={() => setShowPopup(true)} 
                onMouseLeave={() => setShowPopup(false)}
            >
                Graphs
                {showPopup && (
                    <div>
                        <img src={`../images/${section}/${stationId}.png`} alt='Test images'/>
                    </div>
                )}
            </div>

        </div>
    );
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
                    {console.log(stations)}
                    <TableSection section='test' categories={['RMSE(daily)','RMSE(weekly)','Last Updated','Graphs']} />
                    <MetricCells section='test' stations = {stations} />

                </div>

                <div id='train'>
                    <TableSection section='TRAIN' categories={['Last Updated','Graphs']} />
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                </div>
                <div id='future'>
                    <TableSection section='FUTURE' categories={['Predictions(daily)','Predictions (weekly)','Last Updated','Graphs']} />
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                </div>
            </div>
        </div>
    )
}