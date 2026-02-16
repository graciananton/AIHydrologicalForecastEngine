import React from "react";
import { createRoot } from "react-dom/client";
import Status from "./Status";
import Login  from "./Login";
//import Workflow from "./Workflow";

import "../css/app.css";

export default function App() {
  const data = window.__REACT_DATA__ || {};
  console.log(data);
  const isLoggedIn = Object.keys(data).length > 1 ? data[2]['loggedIn'] : false;
  return (
    <>
      
      {isLoggedIn ? <Status data={data} />:<Login data={data}/>}
    </>
  );
}
createRoot(document.getElementById("react-root")).render(
    <App />
);