import React from "react";
import { createRoot } from "react-dom/client";
import Login  from "./Login";
import Workflow from "./Workflow";
import Home from "./Home";
import Header from "./Header";
import Dashboard from "./Dashboard";
import VerificationCode from "./VerificationCode";

import "../css/app.css";

export default function App() {
  const data = window.__REACT_DATA__ || {};
  const values = Object.values(data);

  var req = getRequest(values);
  console.log(req);
  return (
    <>
    {req === 'workflow' && <Workflow /> }
    {req == "login" && <Login data={data} />}
    {req == "home" && <Home />}
    {req == "dashboard" && <Dashboard />}
    {req == "verification_code" && <VerificationCode />}
    </>
  );
}
function getRequest(values){
  for(var i=0;i<values.length;i++){
      const value = values[i];
      if('request' in value){
          var req = value.request;
      }
  }
  return req;
}
createRoot(document.getElementById("react-root")).render(
    <App />
);