import React from "react";
import { createRoot } from "react-dom/client";
import Login  from "./Login";
import Workflow from "./Workflow";
import Home from "./Home";
import Header from "./Header";
import Dashboard from "./Dashboard";
import VerificationCode from "./VerificationCode";
import UserStation from "./UserStation";
import Signup from "./Signup";

import "../css/app.css";

export default function App() {
  const data = window.__REACT_DATA__ || {};
  var req = getReq(data);
  return (
    <>
    {req === 'workflow' && <Workflow /> }
    {req == "login" && <Login data={data} />}
    {req == "home" && <Home />}
    {req == "dashboard" && <Dashboard />}
    {req == "verificationCode" && <VerificationCode data={data}/>}
    {req == "userStation" && <UserStation data={data}/>}
    {req == "signup" && <Signup data={data} />}
    </>
  );
}
function getReq(data){
  const result = Object.entries(data).find(([key, value]) => {
    return key == "request";
  });
  return result[1];
}
createRoot(document.getElementById("react-root")).render(
    <App />
);