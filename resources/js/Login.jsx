import React from "react";
import '../css/Login.css';
export default function Login({ data }){
    console.log(data);
    return (
        <div id='login_page'>
            <div id='login' className='container-fluid'>
                {data?.error && (
                <div id='error'>{data.error}</div>
                )}
                <div id='title'>Login</div>
                <form method="POST" action='../public/login_submit'>
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")}/>
                    <div className='form-group'>
                        <label htmlFor='Email'>Email:</label><br/>
                        <input type='email' id='email' name='email' required/>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='Password'>Password:</label><br/>
                        <input type='password' id='password' name='password' required/>
                    </div>
                    <button type='submit'>Submit</button>
                </form>
            </div>
        </div>
    );
}
