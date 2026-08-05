import React from "react";
import { createRoot } from "react-dom/client";
import VerificationMessage from "./VerificationMessage";
import Login  from "./Login";
import Workflow from "./Workflow";
import Header from "./Header";
import Dashboard from "./Dashboard";
import VerificationCode from "./VerificationCode";
import UserStation from "./UserStation";
import Home from "./Home";
import Signup from "./Signup";
import Register from "./Register";
import { useState, useEffect, createContext } from "react";
import "../css/app.css";
import { BaseUrlContext } from "./BaseUrlContext";

export default function App() {
  const data = window.__REACT_DATA__ || {};
  var req = getReq(data);
  console.log("Vite app base url");
  console.log(import.meta.env.VITE_APP_BASE_URL);
  console.log(import.meta.env);
  return (
    <BaseUrlContext value= {import.meta.env.VITE_APP_BASE_URL}>
      <div id='mainPage'>
        {(req == "home" || req == "privacyPolicy" || req == "termsOfUse" || req == "methodology") && <Home data={data}/>}
        {req === 'workflow' && <Workflow /> }
        {req == "login" && <Login data={data} />}
        {req == "dashboard" && <Dashboard />}
        {req == "verificationCode" && <VerificationCode data={data}/>}
        {req == "userStation" && <UserStation data={data}/>}
        {req == "signup" && <Signup data={data} />}
        {req == "verificationMessage" && <VerificationMessage data={data} />}
        {req == "register" && <Register data={data}/>}
      </div>
    </BaseUrlContext>
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