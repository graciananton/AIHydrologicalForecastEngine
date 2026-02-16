import React from "react";
import { createRoot } from "react-dom/client";
import Status from "./Status";
import Login  from "./Login";
import Workflow from "./Workflow";

import "../css/app.css";

export default function App() {
  const data = window.__REACT_DATA__ || {};
  const values = Object.values(data);
  var req = getReq(values);
  return (
    <>
    {req === 'workflow' && <Workflow /> }
    {req == "status" && <Status data={data} />}
    {req == "login" && <Login data={data} />}
    </>
  );
}
function getReq(values){
  for(var i=0;i<values.length;i++){
      const value = values[i];
      if('req' in value){
          var req = value.req;
      }
  }
  console.log(req);
  return req;
}
createRoot(document.getElementById("react-root")).render(
    <App />
);