import React from "react";
import '../css/Login.css';
import { useState, useEffect } from "react";

export default function Login({ data }){
    console.log(data);
    return (
        <div class='page'>
            <div class='card'>
                <div class='title'>Login</div>
                {data.error && (
                    <div class='error'>{data.error}</div>
                )
                }
                <form method="POST" class='form' action={`/laravel/public/loginSubmit`}>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                    <div class='form-group'>
                        <label htmlFor='Email'>Email:</label><br/>
                        <input type='email' id='email' name='email' required/>
                    </div>
                    <button type='submit'>Submit</button>
                </form>
            </div>
        </div>
    );
}

