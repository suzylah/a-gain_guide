/*
* A–Gain Guide Map for guide page
* Copyright 2022 Cecilia Palmer 
* mail@ceciliapalmer.studio
* https://ceciliapalmer.studio
*
* This program is free software: you can redistribute it and/or modify it under the terms 
* of the GNU General Public License as published by the Free Software Foundation, version 3 or later.
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
* without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
* See the GNU General Public License for more details.

* You should have received a copy of the GNU General Public License along with this program. If not, see https://www.gnu.org/licenses/.
*
*/

const userlang = document.getElementsByTagName('html')[0].getAttribute('lang')

const labels = {
        submit: {de:"Apply",en:"Apply"},
        reset: {de:"Reset",en:"Reset"},
        address:{de:"Adresse",en:"Address"},
        phone:{de:"Fon",en:"Phone"},
        email:{de:"E-mail",en:"Email"},
        search:{de:"SUCHE",en:"SEARCH"},
        district:{de:"Bezirk",en:"District"},
        service:{de:"Service",en:"Service"}
    },
    serviceName = "firmenname",
    offers = userlang == 'de' ? "serviceAngebote" : "serviceAngeboteEN",
    service1 = userlang == 'de' ? "service1" : "service1EN",
    service2 = userlang == 'de' ? "service2" : "service2EN",
    service3 = userlang == 'de' ? "service3" : "service3EN",
    serviceType = "serviceArt",
    hours = userlang == 'de' ? "ffnungszeiten" : "ffnungszeitenEN",
    products = userlang == 'de' ? "produkte" : "produkteEN",
    extras = userlang == 'de' ? "extras" : "extrasEN",
    infos = userlang == 'de' ? "hinweise" : "hinweiseEN",
    district = "bezirk",
    address = "adresse",
    zipcode = "postleitzahl",
    phone = "telefon"
    email = "email",
    website = "website",
    facebook = "facebook",
    instagram = "instagram";


function createItemContent (container,feature) {

    const props = feature.properties

    let heading = L.DomUtil.create('h3', '', container)
    heading.innerHTML = props["firmenname"]

    let services = [service1, service2, service3]
    
    services.forEach((el)=>{
        if(props.hasOwnProperty(el)) {
            const s = L.DomUtil.create('span','itemCat',container)
            s.innerHTML = props[el]
        }
    })

    if(props.hasOwnProperty('serviceArt')) {
        if (props['serviceArt'] == 'Online') {
            const note = L.DomUtil.create('div','online-note',container)
            note.innerHTML = 'Online service'
        }   
    }

    if(props.hasOwnProperty(address) && props['serviceArt'] !== 'Online'){
        var ad = L.DomUtil.create('div','address',container)
        ad.innerHTML = `<h4>${labels.address[userlang]}</h4><p>${props[address]}<br>${props[zipcode]} Berlin-${props[district]}</p>`
    }

    let additional = [props[phone],props[email],props[hours],props[website],props[facebook],props[instagram],props[offers],props[products],props[extras],props[infos]]
    
    additional = additional.filter(n => n)

    if (additional.length !== 0) {
        container.classList.add('collapsible')
        let more = L.DomUtil.create('div','moreInfo',container)

        if(props[phone]){
            let tel = L.DomUtil.create('div','',more)
            tel.innerHTML = `<h4>${labels.phone[userlang]}</h4><p><a href="callto:${props[phone]} " target="_blank">${props[phone]}</a></p>`
        }

        if(props.hasOwnProperty(email)){
            let email = L.DomUtil.create('div', '', more)
            email.innerHTML = `<h4>${labels.email[userlang]}</h4><p><a href="mailto:${props.email}" target="_blank">${props.email}</a></p>`
        }

        if(props.hasOwnProperty(hours)) {
            let open = L.DomUtil.create('div', '', more)
            open.innerHTML = `<h4>Open</h4><p>${props[hours]}</p>`
        }

        let links = L.DomUtil.create('div','links', more)

        if(props.hasOwnProperty(website)){
            const w = L.DomUtil.create('a','',links)
            w.setAttribute('target','_blank')
            w.href = props.website.startsWith('http') ? props.website : `https://${props.website}`
            w.innerHTML = 'Website'}
        
        if(props.hasOwnProperty(facebook)){
            const f = L.DomUtil.create('a','',links)
            f.setAttribute('target','_blank')
            f.href = `https://facebook.com/${props.facebook}`
            f.innerHTML = 'FB'}
        
        if(props.hasOwnProperty(instagram)){
            const i = L.DomUtil.create('a','',links)
            i.setAttribute('target','_blank')
            i.setAttribute('href', `https://instagram.com/${props.instagram}`)
            i.innerHTML = 'IG'}
        
        let fields = [props[offers],props[products],props[extras],props[infos]]

        let moreinfo = fields.filter(n => n)

        if(moreinfo.length !== 0){
            var h = L.DomUtil.create('h4','',more)
            h.innerHTML = 'Info'
            let list = L.DomUtil.create('ul','',more)

            moreinfo.forEach((el) => {
                if (el !== "") {
                    let li = L.DomUtil.create('li','',list)
                    li.innerHTML = el
                }
            })
        }
    }

    return container;
}
const activeStyle = {fillColor:'#C7A9E0',zIndexOffset:999}

let map, markers, featureLayer, geojsonLayers = [], paddingLeft, markerSize = 20, clusterRadius = 1000;

let dotMarker = {
    radius: markerSize / 2,
    color: "#2b2e34",
    fillColor:"#2b2e34",
    weight: 1,
    opacity: 1,
    fillOpacity: 1,
    zIndexOffset: 0,
};

const invisibleStyle = {opacity:0,fillOpacity:0}

const markerClusterOptions = {
    maxClusterRadius: function(zoom) { return zoom < 13 ? 80 : 80 },
    disableClusteringAtZoom: 15,
    showCoverageOnHover:true,
    spiderfyOnMaxZoom: false,
    iconCreateFunction: function(cluster) {
        return L.divIcon({ 
            html: '<span>' + cluster.getChildCount() + '</span>',
            iconSize: cluster.getChildCount() > 100 ? 2 * markerSize + 100 : 2 * markerSize + cluster.getChildCount(),
            className: 'marker-cluster'
        } );
    },
    polygonOptions: {
        fillColor: '#000',
        color: 'transparent',
        weight: 0.5,
        opacity: 1,
        fillOpacity: 0.15
    }
}

const featureLayerOptions = {
    pointToLayer: (feature, latlng) => {return L.circleMarker(latlng, dotMarker)},
    onEachFeature: onEachFeature,
    filter: (feature => {return feature.properties.hasOwnProperty('latitude')})
}

function onEachFeature(feature, layer) {
    layer.on({ click: () => { 
        geojsonLayers.forEach(el => el.resetStyle())
        layer.setStyle(activeStyle).bringToFront();
    }});
    if (layer.feature.properties.hasOwnProperty("serviceArt")) {
        if (layer.feature.properties["serviceArt"] == "Online") {
            layer.setStyle(invisibleStyle);
        }
    }
    if (screen.width > 800) { layer.bindTooltip(feature.properties.firmenname) } 
    if (screen.width < 800) {
        const popup = L.DomUtil.create('div', 'listItem')
        const popupContent = createItemContent(popup,feature)
        L.DomEvent.on(popup, 'click', (e) => {e.target.classList.toggle('active')})
        const ppp = L.popup({autoPanPaddingTopLeft: [15, 165]}).setContent(popupContent)
        layer.bindPopup(ppp) 
    }
}

function addLayerToMap(featureGroup, title) {
    featureLayer = L.geoJSON(featureGroup, featureLayerOptions);
    markers.addLayer(featureLayer)
    geojsonLayers.push(featureLayer);

    const featureList = L.control.featurelist({ 
        layer: featureLayer, 
        randomOrder: false, 
        title: title,
        classname: 'result-group',
        featureName: 'firmenname',
        listItemFunction: createItemContent
    })

    featureList.addTo(map);
}

function initMap(data = null) {

    const tiles = L.tileLayer(
        'https://api.mapbox.com/styles/v1/a-gainguide/cl0jz9gbd006h14qbnhi3pi67/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiYS1nYWluZ3VpZGUiLCJhIjoiY2t3NTA1cDh6MGJ0cjJvbGpkN3l6cmRsOCJ9.uc3-GBViacpGa3BnZ0GAiQ', {
        tileSize: 512,
        zoomOffset: -1,
        detectRetina: true,
        attribution: 'Map data © OpenStreetMap contributors',
    });

    let mapOptions = {zoomControl: false,layers: [tiles],minZoom: 1,tap: false}
    map = L.map('result', mapOptions).setView([52.5208,13.3942],11);
    L.control.zoom({ position: 'bottomright' }).addTo(map);
    markers = L.markerClusterGroup(markerClusterOptions);
    map.addLayer(markers);

}

/* ===== More controls ====== */

L.Control.ResultFooter = L.Control.extend({
    onAdd: function(map) {
        const resultFooter = L.DomUtil.create('div','result-footer')

        const donate = L.DomUtil.create('div','bg-orange column vertical__center', resultFooter)
        donate.innerHTML = `<h4>If you like what we do and wanna support our work, you can also donate.</h4><button class="btn-link __dark"><a href="https://circular.berlin/support-us/" target="_blank">Donate</a></button></div>`

        const news = L.DomUtil.create('div','bg-blue column vertical__center', resultFooter)
        news.innerHTML = `<h4>And stay up-to-date about what we do next :)</h4><div id="mc_embed_signup"><form action="https://guide.us5.list-manage.com/subscribe/post?u=948d81cc6a6f81e8f7480dbd3&amp;id=413aa050e6" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate><div id="mc_embed_signup_scroll"><div class="field"><input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email" required></div><div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_948d81cc6a6f81e8f7480dbd3_413aa050e6" tabindex="-1" value=""></div><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn-link __dark" style="margin:0 auto"></div></form></div>`

        const quit = L.DomUtil.create('div','bg-purple column vertical__center', resultFooter)
        quit.innerHTML = `<h4>Go and explore all available services instead</h4><a href="#" class="btn-link __dark" id="result-footer-quit">Quit guide</a>`
        quit.addEventListener('click',showQuitWarning)

        L.DomEvent.on(resultFooter, 'mousewheel', L.DomEvent.stopPropagation);

        return resultFooter;
    },

    onRemove: function(map) {}
});

L.control.resultfooter = function(opts) {
    return new L.Control.ResultFooter(opts);
}

function addFooterToMap() {
    L.control.resultfooter({ position: 'topleft' }).addTo(map);
}

document.querySelectorAll('#viewSwitch div').forEach(el => {
    el.addEventListener('click', (e) => {
        document.querySelectorAll('#viewSwitch div').forEach(el => el.classList.toggle('activeView'))

        document.querySelector('#viewMap').classList.contains('activeView') ? document.querySelector('.leaflet-top.leaflet-left').classList.add('showMap') : document.querySelector('.leaflet-top.leaflet-left').classList.remove('showMap')
    })
})