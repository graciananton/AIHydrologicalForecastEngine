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
    console.log("getMessages");
    console.log(data);
    console.log(data.createdAt);
    console.log(data.createdAt);
    const url = "https://gracian.ca/laravel/public/api/stationMessage?order=desc&stationId="
                +data.stationId
                +"&from="+data.createdAt;
    
    console.log(url);

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

    let id = 1;
    return (
        messages.length > 0 ? (
        <>
        <div>These are emails sent to your inbox so far.</div>
        <table>
            <thead>
                <th>ID:</th>
                <th>Message:</th>
                <th>Created At:</th>
            </thead>
            <tbody>
            {
            messages.map((message) => (
                <tr>
                    <td>{id++}</td>
                    <td>{message.message}</td>
                    <td>{convertUTCToFormattedTime(message.created_at, ['month', 'date', 'hour', 'minute', 'timePeriod'])}</td>
                </tr>
            ))
            }
            </tbody>
        </table>
        </>
        ) : (<div>No emails sent to your inbox so far</div>)
    );
}

function convertUTCToFormattedTime(UTCDate, options){
    let dateObject = new Date(UTCDate); // convert to ISO format
    let timeZoneOffset = dateObject.getTimezoneOffset();
    dateObject.setMinutes(dateObject.getMinutes() - (timeZoneOffset));

    const getAMPM = (hour) => hour >= 12 ? "PM" : "AM";
    
    const getTimeOffset = (hour) => hour > 12 ? hour - 12 : hour;

    const monthName = dateObject.toLocaleString("en-US", {
        month: "long"
    });
    
    console.log("Options");
    console.log(options);
    return (
        <>
        {options.includes("month") ? String(monthName) + " ": ""}{options.includes("date") ? String(dateObject.getUTCDate()) + ", ": ""}{options.includes("hour") ? String(getTimeOffset(dateObject.getUTCHours())): ""}:{options.includes("minute") ? String(String(dateObject.getMinutes()).padStart(2,"0")) + " ":""}{options.includes("timePeriod") ? getAMPM(dateObject.getUTCHours()): ""}
        </>
    )
}
