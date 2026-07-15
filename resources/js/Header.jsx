import React from "react";
import '../css/Header.css';
import { useState, useEffect } from "react";

export default function Header(){
    return (
    <div id='header'>
        <ul>
            <li><a href='?userDashboard'>User Dashboard</a></li>
            <li><a href='?stationMessages'>Station Messages</a></li>
        </ul>
    </div>
    )
}