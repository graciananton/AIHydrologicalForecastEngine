import React from "react";
import { useState } from "react";

export default function Dashboard(){
    const [showPopup, setShowPopup] = useState(false);
    return (
        <div id='dashboardPage' style={{overflow: "auto", display: "flex", flexDirection: "column"}}>
            <div id='dashboard' style={{height:"600px", position:"relative",overflow:"auto", display:"flex", flexDirection:"column",marginTop:"5%",marginLeft:"5%",marginRight:"5%"}}>
                <div style={{display:"flex",flexDirection:"row", flex:1, position:"sticky", borderBottom:"1px solid black",borderTop:"2px solid black",borderRight:"2px solid black",borderLeft:"2px solid black", top:0}}>
                    <div style={{flex:2, border:"0px solid black", textAlign:"center",minWidth:"150px"}}>Station IDs</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02KF001</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02KF005</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02KF006</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02KF012</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02LA004</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02LA015</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02LA027</div>
                    <div style={{flex:1,border:"0px solid black", textAlign:"center",minWidth:"75px"}}>02KF011</div>
                </div>
                <div style={{display:"flex",flexDirection:"row",flex:1, borderLeft:"1px solid black", borderRight:"1px solid black"}}>
                    <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                        <div style={{display:"flex",flex:1, borderRight:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            TEST
                        </div>
                        <div style={{flex:1,borderLeft:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            <div style={{border:"0px solid black"}}>RMSE (daily)</div>
                            <div style={{border:"0px solid black"}}>RMSE (weekly)</div>
                            <div style={{border:"0px solid black"}}>Last Updated</div>
                            <div style={{border:"0px solid black"}}>Graphs</div>
                        </div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
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
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black",  whiteSpace: "nowrap"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black",  whiteSpace: "nowrap"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black",  whiteSpace: "nowrap"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                </div>
                <div style={{display:"flex",flexDirection:"row",flex:1, borderLeft:"1px solid black", borderRight:"1px solid black"}}>
                    <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                        <div style={{display:"flex",flex:1,borderRight:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            TRAIN
                        </div>
                        <div style={{flex:1,borderLeft:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            <div style={{border:"0px solid black"}}>Last Updated</div>
                            <div style={{border:"0px solid black"}}>Graphs</div>
                        </div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                </div>
                <div style={{display:"flex",flexDirection:"row",flex:1, borderLeft:"1px solid black", borderRight:"1px solid black", borderBottom:"1px solid black"}}>
                    <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                        <div style={{display:"flex",flex:1,borderRight:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            FUTURE
                        </div>
                        <div style={{flex:1,borderLeft:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                            <div style={{border:"0px solid black"}}>Predictions (daily)</div>
                            <div style={{border:"0px solid black"}}>Predictions (weekly)</div>
                            <div style={{border:"0px solid black"}}>Last Updated</div>
                            <div style={{border:"0px solid black"}}>Graphs</div>
                        </div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>
                    <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                        <div style={{border:"0px solid black"}}>0.23332</div>
                        <div style={{border:"0px solid black"}}>0.323232</div>
                        <div style={{border:"0px solid black"}}>2026-05-08 14:32</div>
                        <div style={{border:"0px solid black"}}>Graphs</div>
                    </div>

                </div>
            </div>
        </div>
    )
}