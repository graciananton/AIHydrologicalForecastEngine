import React from "react";
import '../css/UserStation.css';

export default function UserStation(){
    const data = window.__REACT_DATA__;
    console.log(data);
    return (<Main />);
}
function convertArrayToObject(data){
    const objectData = {};
    let counter = -1
    data.forEach(key => {
        objectData.key = data[counter++]
    });
    return objectData;
}
function Main(){
    return (
        <div id='main'>
            
        </div>
    )
}
function station(){
    return (
        <div></div>
    )
}