
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

export default class Map{
    static init(){
        let map = document.querySelector('#map')
        if(map === null){
            return
        }
        let icon = L.icon({
            iconUrl: '/default_images/marker-icon.png',
        });

        let center = [map.dataset.lat, map.dataset.lng]
        map = L.map('map').setView(center, 13)
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            maxZoom: 18,
            minZoom: 12,
            attribution: 'test',
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1Ijoic3RhcmJ1Z3N0b25lIiwiYSI6ImNqcWtxcnR0NTBpYXk0OGxmMGNzaGN5emsifQ.WxW4Nw-e45sUI6blt1wzFA'
        }).addTo(map)
        L.marker(center, {icon: icon}).addTo(map)
    }
}