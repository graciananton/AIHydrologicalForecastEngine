import React from "react";
import { createRoot } from "react-dom/client";
import Login  from "./Login";
import Workflow from "./Workflow";
import Header from "./Header";
import Dashboard from "./Dashboard";
import VerificationCode from "./VerificationCode";
import UserStation from "./UserStation";
import Home from "./Home";
import Signup from "./Signup";
import VerificationMessage from "./VerificationMessage";
import { useState, useEffect } from "react";
import StationMessages from "./StationMessages";
import "../css/app.css";

export default function App() {
  const data = window.__REACT_DATA__ || {};
  var req = getReq(data);

  let showHeader = false;
  if(req == "userStation" || req == "stationMessages"){
    showHeader = false;
  }

  return (
    <div id='mainPage'>
      {showHeader && <Header />}
      {req == "home" && <Home />}
      {req === 'workflow' && <Workflow /> }
      {req == "login" && <Login data={data} />}
      {req == "dashboard" && <Dashboard />}
      {req == "verificationCode" && <VerificationCode data={data}/>}
      {req == "userStation" && <UserStation data={data}/>}
      {req == "signup" && <Signup data={data} />}
      {req == "verificationMessage" && <VerificationMessage data={data} />}
      {req == "stationMessages" && <StationMessages data={data} />}
    </div>
  );
}
function getReq(data){
  console.log(data);
  const result = Object.entries(data).find(([key, value]) => {
    return key == "request";
  });
  return result[1];
}
createRoot(document.getElementById("react-root")).render(
    <App />
);