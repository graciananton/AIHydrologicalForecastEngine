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
function TableSection(section, categories){
    {console.log(categories)}
    return (
        <div>
            <div>{section}</div>
            <div>
            {categories.map((category, index) => (
                <div>{category}</div>
            ))}
            </div>
        </div>
    )
}
export default function Dashboard(){
    const [showPopup, setShowPopup] = useState(false);
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
                    <TableSection section='TEST' categories={['RMSE(daily)','RMSE(weekly)','Last Updated','Graphs']} />
                    <div>
                        <div>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black", position:"relative"}} onMouseEnter={() => setShowPopup(true)} onMouseLeave={() => setShowPopup(false)}>
                            Graphs
                            {showPopup && (
                                <div
                                style={{
                                    position: "absolute",
                                    top: -220,
                                    left: 50,
                                    bottom:-50,
                                    width: "300%",
                                    height: "1228%",
                                    background: "black",
                                    border: "2px solid black",
                                    zIndex: 2
                                }}
                                >
                                <img src='..\images\train\02KF001.png' alt='Train images'/>
                                </div>
                            )}
                        </div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.23332</div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div>0.23332</div>
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