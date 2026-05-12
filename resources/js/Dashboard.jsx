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
            <div key='title'>{section.toUpperCase()}</div>
            <div key='categories'>
                {categories.map((category, index) => (
                    <div key={category}>{category}</div>
                ))}
            </div>
        </div>
    )
}


function MetricCells({ section, stations }) {
    const [metricsData, setMetricsData] = useState({});
    const now = new Date();
    const sevenDaysBefore = new Date(now.getTime() - 7 * 24 * 60 * 1000).toISOString();

    useEffect(() => {
        const fetchAllMetrics = async () => {
            const results = {};
            await Promise.all(
                stations.map(async (station, index) => {
                    const url =
                        `https://gracian.ca/laravel/public/api/test_evaluations?from=${sevenDaysBefore}&stationId=${station.stationId}&order=asc`;
                    const response = await fetch(url);
                    const json = await response.json();
                    results[station.stationId] = json;
                })
            );
            setMetricsData(results);
        };
        fetchAllMetrics();
    }, []);

    /*console.log(metricsData);
    return (
        <>
            {stations.map(station => (
                <MetricCell
                    key={station.stationId}
                    section={section}
                    stationId={station.stationId}
                    metrics={metricsData[station.stationId] || []}
                />
            ))}
        </>
    );*/
}
function MetricCell({ section, stationId, metrics }){
    const [showPopup, setShowPopup] = useState(false);
    let sum = 0;
    for(const metric of metrics){
        sum = sum + metric['error'];
    }
    let average = sum/metrics.length;
    return (
        <div>
            <div key = 'error'>{metrics[metrics.length-1].error}</div>
            <div key = 'average'>{average}</div>
            <div key = 'updated_at'>{metrics[metrics.length-1].updated_at}</div>
            <div 
                key = 'graphs'
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