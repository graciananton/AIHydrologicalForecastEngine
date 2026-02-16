import React from "react";
import '../css/Workflow.css';

export default function Workflow(){
    return (
        <div id='workflow' className='container-fluid'>
            <Title />
            <Links />
            <Image />
        </div>  
    );
}
function Title(){
    return (
        <div id='title' className='row'>
                AI Hydrological Engine Workflow
        </div>
    );
}
function Links(){
    return (
    <div id='links' className='row'>
    This architecture illustrates an end-to-end hydrometric monitoring and prediction system. 
    The platform collects real-time and historical weather and water-level readings from open-source APIs 
    and hydrometric station databases through scheduled data ingestion jobs. The data is stored and exposed 
    via internal APIs, which feed a Linear Regression machine learning model to forecast future water levels. 
    Users interact with the system through a frontend interface, where account details and location information 
    are managed to deliver personalized monitoring, analytics, and predictive insights.<div style={{ whiteSpace: 'nowrap' }}>To login, click <a href='../public/login'>here</a>.</div>
    </div>
    );
}
function Image(){
    return (
        <div id='image' className='row'>
            <img src='../images/workflow2.png'/>
        </div>
    )
}

