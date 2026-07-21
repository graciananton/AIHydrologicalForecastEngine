import React from "react";
import "../css/home.css";
import { useRef, useEffect, useState} from 'react'

export default function Home(){
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
            
            var map = L.map('map').setView(mapCenter, 13);
            
            map.current = map

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 13,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            map.fitBounds(stationCoordinates, {
                padding: [35,35] 
            });


            stations.forEach((station) => {
                var marker = L.marker([station.latitude,station.longitude]).addTo(map);
                
                marker.on("click", function(e){
                    map.invalidateSize();

                    setStation(station);
                    console.log('Click action performed');
                    const targetLocation = L.latLng(station.latitude, station.longitude);
                    console.log(targetLocation);

                    const bounds = targetLocation.toBounds(500);
                    console.log(bounds);

                    const boundOptions = {
                        duration: 0.1,
                        easeLinearity: 0.1,
                        paddingTopLeft: [50, 50],
                        paddingBottomRight: [50, 50]
                    };
                    console.log("updated map");
                    const updatedMap = map.flyToBounds(bounds, boundOptions);
                    console.log(updatedMap);

                    marker.bindPopup(format(station.name)).openPopup();
                });

            })
            
        }

        processStations();
    },[])

    let name = "";
    let description = "";

    console.log("Station:");
    console.log(station);

    return (
        <div className='map-stations'>
            <div id='map' ref={map}>

            </div>
            {
            Object.keys(station).length > 0  ?
            (   <div className='station'>
                    <div className='name'>{station.name}</div>
                    <div className='description'>{station.description}</div>
                    <div className='view'><a href='laravel/userStation'>View Station</a></div>
                    <div className='signup'><a href='laravel/login'>Signup</a></div>
                </div>
            ) :
            (
                <></>
            )
            }
        </div>
    )
}

function format(string){
    let stringList = string.split(" ");
    for(let i = 0;i < stringList.length;i++){
        let wordList = stringList[i].split("");
        let word = "";
        for(let j = 0;j<wordList.length;j++){
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