import React from "react";
import { createRoot } from "react-dom/client";
import Status from "./Status";
import Login  from "./Login";
import Workflow from "./Workflow";

import "../css/app.css";

export default function App() {
  console.log("Inside App");
  const data = window.__REACT_DATA__ || {};
  console.log(data);
  const values = Object.values(data);
  console.log(values);
  var req = getRequest(values);
  console.log(req);
  return (
    <>
    {req === 'workflow' && <Workflow /> }
    {req == "status" && <Status data={data} />}
    {req == "login" && <Login data={data} />}
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