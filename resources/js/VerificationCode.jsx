import React from "react";
import { useState, useEffect } from "react";
import '../css/VerificationCode.css';


function distributeCode(event, index){
    console.log(event);
    code = (event.target.value).split();
    console.log(code);
}
export default function VerificationCode({ data }){
    const [boxes, setBoxes] = useState(['','','','','','']);
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
                            {
                                boxes.map((index,value) => {
                                    <div id="box">
                                        <input type='text' name={`box${index+1}`} id={`box${index+1}`} maxLength={1} onChange={distributeCode(index)}/>
                                    </div>
                                })
                            }
                        </div>
                        <div id='submit'>
                            <input type='submit' value='Submit' name='submit'/>
                        </div>
                </div>
            </div>
        </form>
    )
}
