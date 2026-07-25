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
        <div class='page' id='verificationCode'>
            
            <form class='card' action='/laravel/public/verificationCodeSubmit' method='POST'>
                <div className="logo">
                        <img src='../images/logo.png'/>
                        <div className='text'>
                            <h2>OTTAWA RIVER</h2>
                            <span><a href='https://gracian.ca/laravel/public'>HYDROMETRIC STATION MAPS</a></span>
                        </div>
                </div>
                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                <div class='title'>Enter verification code</div>
                {
                (data.error) && 
                (<div class='error'>{ data.error }</div>)
                }
                <div class='explanation'>
                    A verification code has been sent to:
                    <br/>
                    {data.email}
                </div>
                <div class='boxes'>
                    <input type='hidden' name='email' value={data.email}/>
                    {
                        boxes.map((value,index) => {
                            return (
                            <div class="box" key={`box${index+1}`}>
                                <input type='text' name={`box${index+1}`} class={`box${index+1}`} value={value} maxLength={6} onChange={(e) => distributeCode(e, index, boxes, setBoxes)}/>
                            </div>
                            )
                        })
                    }
                </div>
                <button type='submit' value='Submit' name='submit'>Submit</button>
            </form>
        </div>  
    )
}

