import React from "react";
import '../css/Register.css';
import { useState, useEffect } from "react";
import { BaseUrlContext } from "./BaseUrlContext";

export default function Login({ data }){
    const base_url = useContext(BaseUrlContext);
    return (
        <div className='page'>
            <div className='card'>
                <div className='logo'>
                    <img src={base_url + '/images/logo.png'}/>
                    <div className='text'>
                        <h2>OTTAWA RIVER</h2>
                        <span><a href={base_url + '/public'}>HYDROMETRIC STATION MAPS</a></span>
                    </div>
                </div>
                <div className='title'>Login</div>
                {data.error && (
                    <div className='error'>{data.error}</div>
                )
                }
                <form method="POST" className='form' action={base_url + '/public/loginSubmit'}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                    <div className='form-group'>
                        <label htmlFor='Email'>Email:</label><br/>
                        <input type='email' id='email' name='email' defaultValue = {data.email ?? ""} required/>
                    </div>
                    <button type='submit'>Submit</button>
                </form>
            </div>
        </div>
    );
}

