import React from "react";
import '../css/StationMessages.css';
import { useState, useEffect } from "react";

export default function StationMessages({ data }){
    console.log("StationMessages data:");
    console.log(data);
    return (
        <div className='page'>
            <div className='title'>
                Station Messages
            </div>
            <div className='messages'>
                {getMessages(data)}
            </div>
        </div>
    );
}

function getMessages(data){
    console.log(data);
    const url = "https://gracian.ca/laravel/public/api/stationMessage?order=desc&stationId="+data.stationId+"&from="+data.createdAt;
    
    const [messages, setMessages] = useState([]);
    useEffect(() => {
        async function getMessages(){
            const data = await fetch(url);
            const messages = await data.json();
            setMessages(messages);
        }
        getMessages();
    },[]);

    console.log(messages);

    let id = 0;
    return (
        <ul>
            {
            messages.map((message) => (
                <li>
                    <span>{id++}</span>
                    <span>{message.created_at}</span>
                    <span>{message.message}</span>
                </li>
            ))
            }
        </ul>
    );
}

