import React from "react";
import "../css/home.css";
import { useRef, useEffect, useState, createContext} from 'react'

const BaseUrl = createContext();

export default function Home({ data }){
    
    return (
        <BaseUrl value= {env('APP_BASE_URL')}>
            <div className='home'>
                <Menu request = {data.request}/>
                <Banner />
                {
                    (data.request == "home" && <Map />) ||
                    (data.request == "methodology" && <Methodology />) ||
                    (data.request == "privacyPolicy" && <PrivacyPolicy />) || 
                    (data.request == "termsOfUse" && <TermsOfUse />) 
                }
                <Footer />
            </div>
        </BaseUrl>
    )
}
function Menu({ request }){
    return (
        <header>
            <nav className="navbar">

                <div className="logo">
                    <img src='../images/logo.png'/>
                    <div className='text'>
                        <h2>OTTAWA RIVER</h2>
                        <span><a href='/laravel/public/home'>HYDROMETRIC STATION MAPS</a></span>
                    </div>
                </div>

                <ul className="nav-links">

                    <li><a className = {(request != "methodology")? 'active' : 'inactive'} href="/laravel/public/home">Home</a></li>

                    <li><a className = {(request == "methodology")? 'active' : 'inactive'} href="../public/methodology">Methodology</a></li>
                    <li>              
                        <i class="fa-regular fa-user"></i>
  
                        <a target="_blank" href="../public/register" className="login-button">
                            Login / Signup
                        </a>
                    </li>
                </ul>

            </nav>

        </header>

    )
}
function Banner(){
    let dir = '../images/banner/';
    let images = [dir + 'slides1.png', dir + 'slides2.png'];

    const [index, setIndex] = useState(0)

    useEffect(() => {
        console.log("calling useEffect");
        setTimeout(function(){
            console.log("setting index"+String(index));
            setIndex((index + 1) % images.length);
        }, 3000);
    }, [index]);
    
    return (
        <section className='banner'>
                {<img src={images[index]} alt={index}/>}
        </section>
    )
}
function Footer(){
    return (
        <footer className='footer'>
            <div className="footer-left">
                <div className="footer-logo">
                    <div>
                        <h3>
                            Ottawa River Hydrometric Station Maps
                        </h3>
                        <p>
                            Reliable data.
                            Informed decisions.
                            Safer communities.
                        </p>
                    </div>
                </div>
            </div>
            <div className="footer-right">
                <a href="/laravel/public/privacyPolicy">
                    <i class="fa-regular fa-book-open"></i>
                    Privacy Policy
                </a>
                <a href="/laravel/public/termsOfUse">
                    <i class="fa-solid fa-shield-halved"></i>
                    Terms of Use
                </a>
                <a href="gracian.anton@gmail.com">
                   <i class="fa-regular fa-envelope"></i>
                    Contact Us
                </a>
            </div>
        </footer>
    )
}

function findMessageInStationMessages(stationMessages, stationId){
    for(let i = 0;i < stationMessages.length;i++){
        let stationMessage = stationMessages[i]
        if(stationId == stationMessage.stationId){
            return stationMessage.message
        }
    }

    return "Station Message not found";
}
function Map(){
    const map = useRef(null);
    const [station, setStation] = useState({});
    const [stationMessages, setStationMessages] = useState([]);

    useEffect(() => {
        async function processStations(){
            const data = await fetch('https://gracian.ca/laravel/public/api/stations');
            const stations = await data.json();
            
            const stationIds = [];
            const stationCoordinates = []

            stations.forEach((station) => {
                stationIds.push(station.stationId);
                stationCoordinates.push([station.latitude, station.longitude])
            }, []);

            const result = await fetch("https://gracian.ca/laravel/public/api/stationMessage?order=desc&limit=10000");

            const messages = await result.json();

            const stationMessages = [];

            let stationIdsCopy = await [...stationIds]
            
            let index = 0;
            console.log(stationIdsCopy);

            while(stationIdsCopy.length > 0 && index < messages.length){
                if(stationIdsCopy.includes(messages[index].stationId)){
                    stationMessages.push({
                        'stationId': messages[index].stationId,
                        'message': messages[index].message
                    });
                    
                    let indexOfStation = stationIdsCopy.indexOf(messages[index].stationId);

                    let firstHalf = stationIdsCopy.slice(0,indexOfStation);
                    let secondHalf = stationIdsCopy.slice(indexOfStation+1, stationIdsCopy.length);

                    stationIdsCopy = firstHalf.concat(secondHalf);

                }
                index ++
            }
            console.log("STation Messages --");
            console.log(stationMessages);
            setStationMessages(stationMessages);

            const bounds = L.latLngBounds(stationCoordinates);

            console.log("Bounds:");
            console.log(bounds);

            const mapCenter = bounds.getCenter(); 
            console.log("Map center: ");
            console.log(mapCenter);

            var map = L.map('map').setView(mapCenter, 19);
            
            map.current = map

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            map.fitBounds(stationCoordinates, {
                padding: [35,35] 
            });

            const markerGroup = L.layerGroup().addTo(map);

            stations.forEach((station) => {
                var marker = L.marker([station.latitude,station.longitude]).addTo(markerGroup);
                marker.bindPopup("");
                
                marker.on("click", function(e){
                    map.invalidateSize();

                    setStation(station);
                    console.log('Click action performed');
                    const targetLocation = L.latLng(station.latitude, station.longitude);
                    console.log(targetLocation);

                    const bounds = targetLocation.toBounds(500);
                    console.log(bounds);

                    const boundOptions = {
                        duration: 0.35,
                        easeLinearity: 0.1,
                        paddingTopLeft: [50, 475],
                        paddingBottomRight: [50, 275]
                    };
                    console.log("updated map");
                    const updatedMap = map.flyToBounds(bounds, boundOptions);
                    console.log(updatedMap);
                    

                    marker.bindPopup(
                        "<strong>" + format(station.name) + "</strong><br/>",{
                            autoPanPaddingTopLeft:[15,15],
                            autoPanPaddingBottomRight:[80,80],
                        }
                    ).openPopup();

                });
            })

            const Reset = L.Control.extend({
                options: {
                    position: 'topleft'
                },

                onAdd: function (map) {
                    const reset = L.DomUtil.create('div', 'reset');
                    reset.innerHTML = '<button>Reset</button>';

                    L.DomEvent.on(reset, 'click', function (event) {
                        console.log("Button clicked");

                        L.DomEvent.stopPropagation(event);
                        
                        console.log("Map center: ");

                        console.log(mapCenter);

                        markerGroup.eachLayer(function (layer) {
                            if (layer instanceof L.Marker) {
                                layer.closePopup();             
                            }
                        });

                        map.setView(mapCenter, 19);
                        map.fitBounds(stationCoordinates, {
                            padding: [35,35] 
                        });
                        

                    });
                
                    return reset;
                }

            });

            map.addControl(new Reset());
        }

        
        processStations();
    },[])

    return (
        <div className='map-stations'>
            <div id='map' ref={map}>

            </div>
            {
            Object.keys(station).length > 0  ?
            (   <div className='station'>
                    <div className='name'>{station.name}</div>
                    <div className='description'><span>Prediction Summary:</span> <br/>{findMessageInStationMessages(stationMessages, station.stationId)}</div>
                    <div className='view'>
                        <i class="fa-solid fa-chart-column"></i>
                        <a href={'../public/userStation/'+ station.stationId} target='_blank'>View Station Dashboard</a>
                    </div>
                    <div className='signup' style={{backgroundColor:"white"}}>
                        <i class="fa-regular fa-user"></i>
                        <a href='../public/register' target="_blank">Login/Signup</a>
                    </div>
                </div>
            ) :
            (
                <div className='station'>
                    <div className='name'>Ottawa River Station Maps</div>
                    <div className='description'>
                        <ol>
                            <li>1. The map to the left displays the geographical location of hydrometric stations along the Ottawa River</li>
                            <li>2. By clicking on the station, you can view the station name, description, and related links</li>
                            <li>3. Access real-time data, forecasts, and messages by using the supported links below.</li>
                        </ol>
                    </div>
                    <div className='view'>                     
                        <i class="fa-solid fa-chart-column"></i>
                        <a href='../public/methodology' target="_blank">View Methodology</a></div>
                    <div className='signup'>         
                        <i class="fa-regular fa-user"></i>
                        <a href='../public/register' target="_blank">Login/Signup </a>
                    </div>
                </div>
            )
            }
        </div>
    )
}
function format(string){
    let stringList = string.split(" ");
    for(let i = 0; i < stringList.length; i++){
        let wordList = stringList[i].split("");
        let word = "";
        for(let j = 0; j<wordList.length; j++){
            if(j > 0){
                word += wordList[j].toLowerCase();
            }
            else{
                word += wordList[j]
            }
        }
        stringList[i] = word;
    }
    console.log(stringList.join(" "));
    return stringList.join(" ");
}

function PrivacyPolicy(){
    return (
        <div className='map-stations'>
            <h3>
                <div className='title'>Privacy Notice</div>
                <p>
                    <strong>Owner:</strong> Gracian Anton<br/>
                    <strong>Website:</strong> AI Forecast Engine
                </p>
            </h3>
            This website may collect information including the following: 
            <ul>
                <li>IP address</li>
                <li>Email address</li>
                <li>Device Cookies</li>
                <li>Other Device Fingerprints</li>
            </ul>
            This website will not collect the following information:
            <ul>
                <li>Passwords</li>
                <li>One-time verification codes</li>
                <li>Confidential legal information</li>
            </ul>
            <p>
                <b>Email:</b> <a href="mailto:gracian.anton@gmail.com">gracian.anton@gmail.com</a>
            </p>
        </div>
    );
}
function TermsOfUse(){
    return (
        <div className='map-stations'>
            <h3>
                <div className='title'>Terms Of Use</div>
                <p>
                    <strong>Owner:</strong> Gracian Anton<br/>
                    <strong>Website:</strong> AI Forecast Engine
                </p>
            </h3>
            The website enhances user experience via a system assistant chatbot. The chatbot can also signup/login users to
            individual accounts using agentic tool calling. The following include data that the website owner and/or external applications may
            collect.
            <ul>
                <li>Collection of user chats/responses to train, test, and fine-tune algorithms</li>
                <li>Agentic tool use</li>
            </ul>
            Users have the right to the following:
            <ul>
                <li>Delete information on their accounts</li>
                <li>Logout of existing accounts</li>
                <li>Contact system support for any technical challenges and/or errors in website</li>
            </ul>
            <p>
                <b>Email:</b> <a href="mailto:gracian.anton@gmail.com">gracian.anton@gmail.com</a>
            </p>

        </div>
    )
}
function Methodology(){
    return (
        <div className='methodology'>
            <div className = 'title'>Hydrological Forecasting Engine Methodology (Machine Learning):</div>
            <div className = 'goal'>
                <div className='title'>Goal:</div>
                The goal of the hydrological forecasting engine is <b>to predict water levels along the Ottawa and Mississippi Rivers 
                at hydrometric stations</b>. The project was created due to a need by residentials in flooding-prone regions to access
                accurate water level predictions during peak time periods. (i.e. early summary). 
                <img src='../images/methodology/process.png' alt='Process' style={{margin:"auto"}}/>
            </div>
            <div className = 'training'>
                <div className='title'>Training:</div>
                This project utilizes multiple regression to predict water levels; that is, many predictors were used to predict a 
                single target variable.
                <ul>
                    <li><b>Dependent Variable: </b> - water level (m)</li>
                    <li>
                        <b>Independent Variables: </b> -  Temperature, Precipitation (Rain, Snow, etc), Wind Speed, Presure
                    </li>
                </ul>

                The model is trained using past weather data (independent variables) and past water levels (dependent variable). 
                It then predicts future water levels (up to 48 hours) using predicted weather data.
            </div>
            <div className = 'apis'>
                <div className='title'>Data Collection:</div>
                Due to the project's reliance on time-series processing, we utilized two real-time APIs, the <a href='https://open-meteo.com/' target="_blank">Open Meteo API</a> from OpenMeteo GmbH
                and the <a href='https://api.weather.gc.ca/' target="_blank">GeoMet-OGC-API</a> from Environment and Climate Change Canada. The Open-Meteo API
                provides weather predictions up to 167 hours into the future at 1 hour intervals. The GeoMet-OGC-API provides
                past water levels at hydrometric stations at 5 minute intervals. Because of these varying time frames, the data had to 
                be sychronized to appear in the same time intervals. This was accomplished by taking an average of the water levels over 
                the course of an hour to ensure accurate model training and prediction.
            </div>
            <div className = 'methodsEmployed'>
                <div className='title'>Methods Employed:</div>
                Python modules leveraged include <b>Scikit-learn, Numpy, and Pandas</b>. These modules provide base models, graphing tools,
                and mathemtical functions. For <b>model training and prediction, we used the Random Forest Regressor modules</b> with customized hyperparameters. 
                These hyperparameters were selected using GridSearchCV. The following are the selected hyperparemters and their values.
                <table>
                    <thead>
                        <tr>
                            <th style={{border:"1px solid black", padding: "2px 10px 2px 10px"}}>bootstrap</th>
                            <th style={{border:"1px solid black", padding: "2px 10px 2px 10px"}}>criterion</th>
                            <th style={{border:"1px solid black", padding: "2px 10px 2px 10px"}}>max_depth</th>
                            <th style={{border:"1px solid black", padding: "2px 10px 2px 10px"}}>max_features</th>
                            <th style={{border:"1px solid black", padding: "2px 10px 2px 10px"}}>min_samples_split</th>
                            <th style={{border:"1px solid black", padding: "2px 10px 2px 10px"}}>n_estimators</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>True</td>
                            <td>absolute_error</td>
                            <td>12</td>
                            <td>3</td>
                            <td>6</td>
                            <td>109</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div className = 'testTrainSet'>
                <div className='title'>Test/Train Set Selection:</div>
                In order to evaluate the model, a test set had to be set aside with which the model was not trained on. To ensure
                no data leakage occurred while still providing a representative test sample, the <b>first 20% of the past weather/water levels</b> were designated
                as a test set while the <b>latter 80% of past weather/water levels</b> were designated as apart of the training set. The model is re-trained
                and re-tested once every day. This ensures that the model is trained and test on different set. Every time the model is re-trained, 
                any part of the past data which was used for training (and now is being tested) will not be used for training purposes. That is, the model will not be trained on that previous 
                data (which is now used for testing) and the new updated model will not have seen that data before. The training and testing occur once every day and a <b>RMSE (Root Mean Squared Error) and Percent Error</b> is approximated
                every day for each test instance to ensure outliers and noise are not being overused by the model and to provides a quick reference for the model's error rate.
            </div>
            <div className = 'graphGeneration'>
                <div className='title'>Graph Generation</div>
                Graph generation was <b>divided into three sections: test, train, and future</b>. The plots for testing and training are generated once every day while the future
                plots are re-generated on an hourly basis. 
                The plots utilize a secondary y-axis to illustrate the correlation, or lack of thereof, between an individual predictor and the target variable (water level).
                Both axes are clearly labeled and pigmented to identify which line is represented by the axe. Below are sample images collected during training, testing, and prediction.
               <div className='images'>
                <img src='../images/methodology/graph.png' alt='graph' width='353' height='250'/>
                <img src='../images/methodology/graph2.png' alt='graph' width='353' height='250'/>
               </div>
            </div>
            <div className = "conclusion">
                <div className='title'>Conclusion</div>
                The Hydrological Forecasting Engine is designed to predict water levels in flooding-prone regions using machine learning technologies. The project outlines the four main parts
                of any data science project: data collection, model training, model prediction, and evaluation. The source code for this project available in the affiliated Github
                links below. Any individual may propose updates to this project by emailing <a href='gracian.anton@gmail.com'>gracian.anton@gmail.com</a>.
                <br/>
                Github Repositories:
                <ul>
                    <li><a href='https://github.com/graciananton/fast-api' target="_blank">Forecasting Engine (ML)</a></li>
                    <li><a href='https://github.com/graciananton/AIHydrologicalForecastEngine' target="_blank">Webpage & Synchronization</a></li>
                </ul>
            </div>
        </div>
    );
}