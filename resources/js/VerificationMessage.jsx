import React from "react";
import { useState, useEffect } from "react";
import '../css/verificationMessage.css';

export default function VerificationMessage( {data} ){
    return (
        <div className='message'>
            <div className='message-card'>
                Thank you for verifying your acccount. You are now in our system and are scheduled to receive daily updates 
                on water level projections as well as tailored warning/alert messages. To view your selected stations 
                information, visit https://gracian.ca/laravel/public/userStation for more details.
            </div>
        </div>
    )
}
