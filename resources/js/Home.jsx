import React from "react";
import "../css/home.css";
import { useRef, useEffect, useState} from 'react'

export default function Home(){
    return (
        <div className='home'>
            <Menu />
            <Banner />
            <Map />
            <Footer />
        </div>
    )
}

function Menu(){
    return (
        <header>
            <nav className="navbar">

                <div className="logo">
                    <img src='../images/logo.png'/>
                    <div className='text'>
                        <h2>OTTAWA RIVER</h2>
                        <span><a href='https://gracian.ca/laravel/public'>HYDROMETRIC STATION MAPS</a></span>
                    </div>
                </div>

                <ul className="nav-links">

                    <li><a className="active" href="#">Home</a></li>

                    <li><a href="#">Methodology</a></li>
                    <li>              
                        <i class="fa-regular fa-user"></i>
  
                        <a href="#" class="login-button">
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
            <div class="footer-left">
                <div class="footer-logo">
                    <div>
                        <h3>
                            Ottawa River Hydrometric Station Maps
                        </h3>
                        <p>
                            Reliable data.
                            Informed decisions.
                            Safer communities.
                        </p>
                        <br/>
                        <p>©2026 Ottawa River Hydrometric Station Maps. All rights reserved</p>
                    </div>
                </div>
            </div>
            <div class="footer-right">
                <a href="#">
                    <i class="fa-regular fa-book-open"></i>Privacy Policy
                </a>
                <a href="#">
                    <i class="fa-solid fa-shield-halved"></i>
                    Terms of Use
                </a>
                <a href="#">
                   <i class="fa-regular fa-envelope"></i>
                    Contact Us
                </a>
            </div>
        </footer>
    )
}

function Map(){
    const map = useRef(null);
    const [station, setStation] = useState({});
    
    useEffect(() => {
        async function processStations(){
            const data = await fetch('https://gracian.ca/laravel/public/api/stations');
            const stations = await data.json();
            
            const stationCoordinates = []

            stations.forEach((station) => {
                stationCoordinates.push([station.latitude, station.longitude])
            }, []);

            const bounds = L.latLngBounds(stationCoordinates);

            console.log("Bounds:");
            console.log(bounds);

            const mapCenter = bounds.getCenter(); 
            
            var map = L.map('map').setView(mapCenter, 19);
            
            map.current = map

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            map.fitBounds(stationCoordinates, {
                padding: [35,35] 
            });


            stations.forEach((station) => {
                var marker = L.marker([station.latitude,station.longitude]).addTo(map);
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
                        "<strong>" + format(station.name) + "</strong><br/><br/> " + "<img src='../images/stations/rideau.png'/>",{
                            autoPanPaddingTopLeft:[15,15],
                            autoPanPaddingBottomRight:[80,80],
                        }
                    ).openPopup();

                });
            })
            
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
                    <div className='description'>{station.description}</div>
                    <div className='view'>
                        <i class="fa-solid fa-chart-column"></i>
                        <a href='../public/userDashboard' target='_blank'>View Station Dashboard</a>
                    </div>
                    <div className='signup' style={{backgroundColor:"white"}}>
                        <i class="fa-regular fa-user"></i>
                        <a href='../public/login' target="_blank">Login/Signup</a>
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
                            <li>3. Access real-time data, forecasts, and messages by using the supported links</li>
                        </ol>
                    </div>
                    <div className='view'>                     
                        <i class="fa-solid fa-chart-column"></i>
                        <a href='../public/methodology' target="_blank">View Methodology</a></div>
                    <div className='signup'>         
                        <i class="fa-regular fa-user"></i>
                        <a href='../public/login' target="_blank">Login/Signup </a>
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