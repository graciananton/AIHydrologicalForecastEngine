import React from "react";
import { useState } from "react";
import '../css/Dashboard.css';

export default function Dashboard(){
    const [showPopup, setShowPopup] = useState(false);
    return (
        <div id='dashboard' /*style={{overflow: "auto", height:"100vh", display: "flex", flexDirection: "column"}}*/>
            <div id='datasets' /*style={{display:"flex", flexDirection:"column",marginTop:"5%",marginLeft:"5%",marginRight:"5%"}}*/>
                <div id='stations' /*style={{display:"flex",flexDirection:"row", flex:1, position:"sticky", top:0, borderBottom:"1px solid black",borderTop:"2px solid black",borderRight:"2px solid black",borderLeft:"2px solid black"}}*/>
                    <div style={{flex:2, border:"0px solid black", textAlign:"center",minWidth:"150px"}}>Station IDs</div>
                    <div>02KF001</div>
                    <div>02KF005</div>
                    <div>02KF006</div>
                    <div>02KF012</div>
                    <div>02LA004</div>
                    <div>02LA015</div>
                    <div>02LA027</div>
                    <div>02KF011</div>
                </div>
                <div id='test' style={{display:"flex",flexDirection:"row",flex:1, borderLeft:"1px solid black", borderRight:"1px solid black"}}>
                    <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                        <div style={{display:"flex",flex:1, borderRight:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            TEST
                        </div>
                        <div style={{flex:1,borderLeft:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
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
                        <div style={{border:"0px solid black",  whiteSpace: "nowrap"}}>0.23332</div>
                        <div>0.323232</div>
                        <div>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black",  whiteSpace: "nowrap"}}>Graphs</div>
                    </div>
                    <div>
                        <div>0.23332</div>
                        <div style={{border:"0px solid black",  whiteSpace: "nowrap"}}>0.323232</div>
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
                <div id='train' style={{display:"flex",flexDirection:"row",flex:1, borderLeft:"1px solid black", borderRight:"1px solid black"}}>
                    <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                        <div style={{display:"flex",flex:1,borderRight:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            TRAIN
                        </div>
                        <div style={{flex:1,borderLeft:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
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
                <div id='future' style={{display:"flex",flexDirection:"row",flex:1, borderLeft:"1px solid black", borderRight:"1px solid black", borderBottom:"1px solid black"}}>
                    <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                        <div style={{display:"flex",flex:1,borderRight:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            FUTURE
                        </div>
                        <div style={{flex:1,borderLeft:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
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