import React from "react";
import { useState } from "react";
import '../css/Status.css';

export default function Status({ data }) {
  console.log(data)
  const weather = data[1];
  const readings = data[0];
  const status = data[2];
  return (
    <div id='status' className="container-fluid">
      <div className='row'>
        <div className='col-md-12 col-sm-12 col-lg-12' id='welcome'>
          <span>Welcome Admin</span>
        </div>
        <div className='col-md-12 col-sm-12 col-lg-12' id='scheduler'>
          <table>
            <thead>
              <tr>
                <th>Tables:</th>
                <th>Service Name:</th>
                <th>Schedule</th>
                <th>Updated</th>
                <th>Next Run At</th>
                <th>Run Now</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Weather</td>
                <td>weather:scheduler</td>
                <td>hourly</td>
                <td>{weather?.latestDateTime}</td>
                <td>{weather?.nextDateTime}</td>
                <td><a href="/laravel/public/weather_sync">Run</a></td>
              </tr>
              <tr>
                <td>Readings</td>
                <td>reading:scheduler</td>
                <td>daily</td>
                <td>{readings?.latestDateTime}</td>
                <td>{readings?.nextDateTime}</td>
                <td><a href="/laravel/public/readings_sync">Run</a></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>status:scheduler</td>
                <td>monthly</td>
                <td>{status?.latestDateTime}</td>
                <td>{status?.nextDateTime}</td>
                <td><a href="/laravel/public/delete_records">Run</a></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div className="col-md-12 col-sm-12 col-lg-12" id='logs'>
            <div className="col-md-9 col-sm-9 col-lg-9" style={{border:"1px solid red"}}>
              
            </div>
            <div className="col-md-3 col-sm-3 col-lg-3" style={{border:"1px solid orange"}} id='settings'>
                <div className='form-group' style={{border:"1px solid red",padding:"0.4rem"}}>
                  <label htmlFor='numberOfLogs'>Number of Previous Logs:</label>
                  <input id='numberOfLogs' name="numberOfLogs" type="number" min='0' defaultValue='10' style={{backgroundColor:"white",borderRadius:"5px",color:"black",paddingLeft:"0.3rem"}}/>
                </div>
                <div className='form-group' style={{padding:"0.4rem"}}>
                  <button onclick={fetchLogs()} style={{backgroundColor:"white",color:"black",padding:"0.4rem",borderRadius:"6px"}}>Get Logs</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  );
}
function fetchLogs(){
  
}
