import React from "react";
import { useState, useEffect, useContext } from "react";
import '../css/Register.css';
import { BaseUrlContext } from "./BaseUrlContext";

export default function VerificationMessage( {data} ){
    const base_url = useContext(BaseUrlContext);

    return (
        <div className='page'>
            <div className='card'>
                <div className='logo'>
                    <img src={base_url + '/images/logo.png'}/>
                    <div className='text'>
                        <h2>OTTAWA RIVER</h2>
                        <span><a href='/forecasting/public'>HYDROMETRIC STATION MAPS</a></span>
                    </div>
                </div>
                <div className='title'>Verification Message</div>
                <div className='content'>
                    Thank you for verifying your acccount. You are now in our system and are scheduled to receive daily updates 
                    on water level projections as well as tailored warning/alert messages. To view your selected stations 
                    information, visit https://gracian.ca/forecasting/public/userStation for more details.
                </div>
            </div>
        </div>
    )
}
