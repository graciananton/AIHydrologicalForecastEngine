import React from "react";
import '../css/Login.css';
import { useState, useEffect } from "react";

export default function Login({ data }){
    console.log(data);
    return (
        <div className='page' style={{border:"1px solid black"}}>
            <div className='card'>
                <div className='logo'>
                    <img src='../images/logo.png'/>
                    <div className='text'>
                        <h2>OTTAWA RIVER</h2>
                        <span><a href='https://gracian.ca/laravel/public'>HYDROMETRIC STATION MAPS</a></span>
                    </div>
                </div>
                <div className='title'>Login</div>
                {data.error && (
                    <div className='error'>{data.error}</div>
                )
                }
                <form method="POST" className='form' action={`/laravel/public/loginSubmit`}>
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

