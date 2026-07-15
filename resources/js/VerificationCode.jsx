import React from "react";
import { useState, useEffect } from "react";
import '../css/VerificationCode.css';


function distributeCode(e, index, boxes, setBoxes){
    console.log(e);
    let codeList = (e.target.value).split("");

    
    const boxesCopy = [...boxes];

    for(let i=index;i<boxes.length;i++){
        boxesCopy[i] = codeList[i-index];
    }

    setBoxes(boxesCopy);
}
export default function VerificationCode({ data }){
    console.log(data);
    const [boxes, setBoxes] = useState(['','','','','','']);
    return (    
        <form id='form' action='/laravel/public/verificationCodeSubmit' method='POST'>
            <div id='verification_page'>
                <div id='verification_form'>
                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                        <div id='title'>Enter verification code</div>
                        {
                        (data.error) && 
                        (<div id='error'>{ data.error }</div>)
                        }
                        <div id='explanation'>
                            A verification code has been sent to:
                            <br/>
                            {data.email}
                        </div>
                        <div id='boxes'>
                            <input type='hidden' name='email' value={data.email}/>
                            {
                                boxes.map((value,index) => {
                                    return (
                                    <div id="box" key={`box${index+1}`}>
                                        <input type='text' name={`box${index+1}`} id={`box${index+1}`} value={value} maxLength={6} onChange={(e) => distributeCode(e, index, boxes, setBoxes)}/>
                                    </div>
                                    )
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

