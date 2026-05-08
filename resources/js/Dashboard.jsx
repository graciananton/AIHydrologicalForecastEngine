import React from "react";
export default function Dashboard(){
    return (
        <div id='dashboard' style={{position:"relative", border:"1px solid red", overflow:"auto", display:"flex", flexDirection:"column"}}>
            <div style={{display:"flex",flexDirection:"row",flex:1}}>
                <div style={{flex:2, border:"1px solid black", textAlign:"center"}}>Station IDs</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF001</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF005</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF006</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF012</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02LA004</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02LA015</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02LA027</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF011</div>
            </div>
            <div style={{display:"flex",flexDirection:"row",flex:1}}>
                <div style={{display:"flex",flex:2, flexDirection:"row",border:"1px solid black",height:"300px",alignItems:"stretch"}}>
                    <div style={{display:"flex",flex:1,border:"1px solid black",textAlign:"center",flexDirection:"column",justifyContent:"space-evenly"}}>
                        TEST
                    </div>
                    <div style={{flex:1,border:"1px solid black",display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-evenly"}}>
                        <div style={{border:"1px solid black"}}>RMSE (daily)</div>
                        <div style={{border:"1px solid black"}}>RMSE (weekly)</div>
                        <div style={{border:"1px solid black"}}>Last Updated</div>
                        <div style={{border:"1px solid black"}}>Graphs</div>
                    </div>
                </div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>
                    <div style={{display:"flex", textAlign:"center",flexDirection:"column",justifyContent:"space-evenly"}}>
                        <div style={{border:"1px solid black"}}>RMSE (daily)</div>
                        <div style={{border:"1px solid black"}}>RMSE (weekly)</div>
                        <div style={{border:"1px solid black"}}>Last Updated</div>
                        <div style={{border:"1px solid black"}}>Graphs</div>
                    </div>
                </div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF005</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF006</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF012</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02LA004</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02LA015</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02LA027</div>
                <div style={{flex:1,border:"1px solid black", textAlign:"center"}}>02KF011</div>
            </div>
            <div>

            </div>
        </div>
    )
}