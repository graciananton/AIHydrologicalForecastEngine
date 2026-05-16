import React from "react";
import { useState, useEffect } from "react";
import '../css/VerificationCode.css';

export default function VerificationCode({ data }){
    console.log("Verification Code")
    console.log(data);
    return (
        <form id='form' action='/request_verify_otp' method='POST'>
            <div id='verification_page'>
                <div id='verification_form'>
                        <div id='title'>Enter verification code</div>
                        <div id='explanation'>
                            A verification code has been sent to:
                            <br/>
                                {data[0].email}
                        </div>
                        <div id='boxes'>
                            <div id="box">
                                <input type='text' name='box1' value=''/>
                            </div>
                            <div id="box">
                                <input type='text' name='box2' value=''/>
                            </div>
                            <div id="box">
                                <input type='text' name='box3' value=''/>
                            </div>
                            <div id="box">
                                <input type='text' name='box4' value=''/>
                            </div>
                            <div id="box">
                                <input type='text' name='box5' value=''/>
                            </div>
                            <div id="box">
                                <input type='text' name='box6' value=''/>
                            </div>
                        </div>
                        <div id='submit'>
                            <input type='submit' value='Submit' name='submit'/>
                        </div>
                </div>
            </div>
        </form>
    )
}
