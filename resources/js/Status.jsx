import React from "react";
import '../css/Status.css';

export default function Status({ data }) {
  console.log(data)
  const weather = data[1];
  const readings = data[0];
  const status = data[2];
  return (
    <div id='status' className="container-fluid">
      <div className='row' style={{border:"1px solid red"}}>
        <div className='col-md-10 col-sm-10 col-lg-10' id='welcome'>
          <span style={{ fontSize: "2rem",marginBottom:"0.3rem" }}>Welcome Admin</span>
        </div>
        <div className='col-md-10 col-sm-10 col-lg-10'>
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
        <div className="col-md-10 col-sm-10 col-lg-10" style={{border:"1px solid red"}}>
            <div className="col-md-6 col-sm-6 col-lg-6" style={{border:"1px solid blue"}}>
              kk<br/>
              ,kk<br/>
            </div>
        </div>
      </div>
    </div>
  );
}
