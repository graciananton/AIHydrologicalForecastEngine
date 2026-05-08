import React from "react";
export default function Dashboard(){
    return (
        <div id='dashboard' style={{position:"relative", border:"1px solid red", overflow:"auto", display:"flex", flexDirection:"column",width:"90%"}}>
            <div style={{display:"flex",flexDirection:"row",flex:1}}>
                <div style={{flex:2, border:"1px solid black", textAlign:"center",minWidth:"150px"}}>Station IDs</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02KF001</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02KF005</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02KF006</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02KF012</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02LA004</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02LA015</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02LA027</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center",minWidth:"75px"}}>02KF011</div>
            </div>
            <div style={{display:"flex",flexDirection:"row",flex:1}}>
                <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                    <div style={{display:"flex",flex:1,border:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                        TEST
                    </div>
                    <div style={{flex:1,border:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                        <div style={{border:"1px solid black"}}>RMSE (daily)</div>
                        <div style={{border:"1px solid black"}}>RMSE (weekly)</div>
                        <div style={{border:"1px solid black"}}>Last Updated</div>
                        <div style={{border:"1px solid black"}}>Graphs</div>
                    </div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black",  whiteSpace: "nowrap"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black",  whiteSpace: "nowrap"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black",  whiteSpace: "nowrap"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
            </div>
            <div style={{display:"flex",flexDirection:"row",flex:1}}>
                <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                    <div style={{display:"flex",flex:1,border:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                        TRAIN
                    </div>
                    <div style={{flex:1,border:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                        <div style={{border:"1px solid black"}}>Last Updated</div>
                        <div style={{border:"1px solid black"}}>Graphs</div>
                    </div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
            </div>
            <div style={{display:"flex",flexDirection:"row",flex:1}}>
                <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch",minWidth:"150px"}}>
                    <div style={{display:"flex",flex:1,border:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                        FUTURE
                    </div>
                    <div style={{flex:1,border:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-around"}}>
                        <div style={{border:"1px solid black"}}>Predictions (daily)</div>
                        <div style={{border:"1px solid black"}}>Predictions (weekly)</div>
                        <div style={{border:"1px solid black"}}>Last Updated</div>
                        <div style={{border:"1px solid black"}}>Graphs</div>
                    </div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>
                <div style={{display:"flex", flexDirection:"column", justifyContent:"space-around", textAlign:"center", flex:1,border:"1px solid black",minWidth:"75px"}}>
                    <div style={{border:"1px solid black"}}>0.23332</div>
                    <div style={{border:"1px solid black"}}>0.323232</div>
                    <div style={{border:"1px solid black"}}>2026-05-08 14:32</div>
                    <div style={{border:"1px solid black"}}>Graphs</div>
                </div>

            </div>

        </div>
    )
}