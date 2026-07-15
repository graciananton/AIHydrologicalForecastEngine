import React from "react";
import '../css/UserStation.css';
import { useState, useEffect } from "react";

export default function Header(){
    return (
    <div id='navBar'>
        <ul>
            <li><a href='?userDashboard'>User Dashboard</a></li>
            <li><a href='?stationMessages'>Station Messages</a></li>
        </ul>
    </div>
    )
}