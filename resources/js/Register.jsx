import React from "react";
import '../css/Register.css';
import { useState, useEffect, useContext } from "react";
import { BaseUrlContext } from "./BaseUrlContext";

export default function Register({ data }){
    console.log("Data");
    console.log(data);
    const base_url = useContext(BaseUrlContext);
    return (
        <div className='page'>
            <div className='card'>
                <div className='logo'>
                    <img src={base_url + '/images/logo.png'}/>
                    <div className='text'>
                        <h2>OTTAWA RIVER</h2>
                        <span><a href={base_url+'/public'}>HYDROMETRIC STATION MAPS</a></span>
                    </div>
                </div>
                <div className='title'>Register</div>
                {data.error && (
                    <div className='error'>{data.error}</div>
                )}

                <form method="POST" className='form' action={base_url + '/public/registerSubmit'}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                    <div className='form-group'>
                        <p>Choose registeration method based on current signup status.</p>
                        <div class='options'>
                            <span>
                                <input type='radio' name='option' value='login'/>
                                <label for='login'>Login</label>
                            </span>
                            <span>
                                <input type='radio' name='option' value='signup'/>
                                <label for='signup'>Signup</label>
                            </span>
                        </div>
                    </div>
                    <button type='submit'>Continue</button>
                </form>
            </div>
        </div>
    );
}

