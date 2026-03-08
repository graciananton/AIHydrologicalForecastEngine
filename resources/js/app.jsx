import React from "react";
import { createRoot } from "react-dom/client";
import Status from "./Status";
import Login  from "./Login";
import Workflow from "./Workflow";
import Home from "./Home";

import "../css/app.css";

export default function App() {
  const data = window.__REACT_DATA__ || {};
  const values = Object.values(data);
  var req = getRequest(values);
  console.log(data);
  return (
    <>
    {req === 'workflow' && <Workflow /> }
    {req == "status" && <Status data={data} />}
    {req == "login" && <Login data={data} />}
    {req == "home" && <Home />}
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