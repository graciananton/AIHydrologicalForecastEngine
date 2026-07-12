import React from "react";
import '../css/Login.css';
import { useState, useEffect } from "react";

export default function Login({ data }){
    console.log(data);
    return (
        <div class='login-page'>
            <div class='login-card'>
                <div class='login-title'>Login</div>
                <form method="POST" class='login-form' action={`/laravel/public/loginSubmit`}>
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

