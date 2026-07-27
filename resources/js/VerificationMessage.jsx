import React from "react";
import { useState, useEffect } from "react";
import '../css/Register.css';

export default function VerificationMessage( {data} ){
    return (
        <div className='page'>
            <div className='card'>
                <div className='logo'>
                    <img src='../images/logo.png'/>
                    <div className='text'>
                        <h2>OTTAWA RIVER</h2>
                        <span><a href='/laravel/public'>HYDROMETRIC STATION MAPS</a></span>
                    </div>
                </div>
                <div className='title'>Verification Message</div>
                <div className='content'>
                    Thank you for verifying your acccount. You are now in our system and are scheduled to receive daily updates 
                    on water level projections as well as tailored warning/alert messages. To view your selected stations 
                    information, visit https://gracian.ca/laravel/public/userStation for more details.
                </div>
            </div>
        </div>
    )
}
