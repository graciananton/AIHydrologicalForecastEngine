import React from "react";
import '../css/Header.css';
import { useState, useEffect } from "react";

export default function Header(){
    ///const [backgroundColor, setBackgroundColor] = useState(["#3F76B8","#9FC2FB","#9FC2FB"]);
    return (
    <div id='header'>
        <ul>
            <li><a href='/laravel/public/userStation'>User Dashboard</a></li>
            <li><a href='/laravel/public/stationMessages'>Station Messages</a></li>
        </ul>
    </div>
    )
}