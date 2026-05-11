import React from "react";
import { useState, useEffect } from "react";
import '../css/Dashboard.css';
function Stations(){
    const url = "https://gracian.ca/laravel/public/api/stations";

    const [stations, setStations] = useState([]);

    useEffect(() => {
        const fetchStations = async () => {
            const stations = await fetch(url);
            const json_stations = await stations.json();
            setStations(json_stations);
        }
        fetchStations();
    },[])

    console.log(stations);
    return (
        <div id='stations'>
            <div>Station IDs</div>
            <div>02KF001</div>
            <div>02KF005</div>
            <div>02KF006</div>
            <div>02KF012</div>
            <div>02LA004</div>
            <div>02LA015</div>
            <div>02LA027</div>
            <div>02KF011</div>
        </div>
    )
    
}

export default function Dashboard(){
    const [showPopup, setShowPopup] = useState(false);
    return (
        <div id='dashboard'>
            <div id='datasets'>
                <Stations />
                <div id='test'>
                    <div>
                        <div>
                            TEST
                        </div>
                        <div>
                            <div>RMSE (daily)</div>
                            <div>RMSE (weekly)</div>
                            <div>Last Updated</div>
                            <div>Graphs</div>
                        </div>
                    </div>
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
                    <div>
                        <div>
                            TRAIN
                        </div>
                        <div>
                            <div>Last Updated</div>
                            <div>Graphs</div>
                        </div>
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
                    <div>
                        <div>2026-05-08 14:32</div>
                        <div>Graphs</div>
                    </div>
                </div>
                <div id='future'>
                    <div>
                        <div>
                            FUTURE
                        </div>
                        <div>
                            <div>Predictions (daily)</div>
                            <div>Predictions (weekly)</div>
                            <div>Last Updated</div>
                            <div>Graphs</div>
                        </div>
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