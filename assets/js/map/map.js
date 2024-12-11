/*
* A–Gain Guide Map
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


function onEachFeature(feature, layer) {

    layer.on({ click: () => { 
        featureLayer.resetStyle()
        layer.setStyle(activeStyle).bringToFront();
    }});

    if (window.innerWidth > 800) { 
        layer.bindTooltip(feature.properties[serviceName]) 
    } else {
        createPopup(feature,layer)
    }

}

function createPopup(feature,layer) {
    const popup = L.DomUtil.create('div', 'listItem')
    const popupContent = createItemContent(popup,feature)
    L.DomEvent.on(popup, 'click', (e) => {e.target.classList.toggle('active')})
    const ppp = L.popup({autoPanPaddingTopLeft: [15, 165]}).setContent(popupContent)
    layer.bindPopup(ppp) 
}

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

const activeStyle = {fillColor:'#F7ED74',zIndexOffset:999}

let featureLayer,featureList, paddingLeft = 10, markerSize = 20, clusterRadius = 1000;

let dotMarker = {
    radius: markerSize / 2,
    color: "#2b2e34",
    fillColor:"#2b2e34",
    weight: 1,
    opacity: 1,
    fillOpacity: 1,
    zIndexOffset: 0,
};

const markerClusterOptions = {
    maxClusterRadius: function(zoom) { return zoom < 13 ? 80 : 80 },
    disableClusteringAtZoom: 15,
    showCoverageOnHover:false,
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

function howFar(feature,myPos) {
    const x1 = L.latLng(feature.geometry.coordinates)
    const x2 = L.latLng(myPos)
    const dist = x1.distanceTo(x2)
    return Math.floor(dist / 1000)
}



function setSidebarHeight() {
    const availableHeight = window.innerHeight - document.querySelector('.leaflet-top.leaflet-left').offsetTop
    document.documentElement.style.setProperty('--sidebar-height', `${availableHeight}px`)
}

window.addEventListener('resize', () => {
    clearTimeout(timeout);
    timeout = setTimeout(setSidebarHeight(), delay);
});

L.Control.FilterToggle = L.Control.extend({
    onAdd: function(map) {
        const content = L.DomUtil.create('div','mobile-only show-filter')
        content.addEventListener('click', e => {
            e.target.parentNode.classList.toggle('show-filters')
        })
        return content;
    },

    onRemove: function(map) {}
});

function initMap(data) {

    filters.service.de = getServiceValues(data, "de")
    filters.service.en = getServiceValues(data, "en")
    filters.district.de = filters.district.en = getDistrictValues(data)

    const tiles = L.tileLayer(
        '###INSERTMAPBOXOROTHERTILEURL###', { 
            tileSize: 512,
            zoomOffset: -1,
            detectRetina: true,
            attribution: 'Mapdata <a href="https://www.mapbox.com/about/maps/">© Mapbox</a> | <a href="http://www.openstreetmap.org/about/">© OpenStreetMap</a>',
    });

    let mapOptions = {zoomControl: false,layers: [tiles],minZoom: 10,tap: false}
    let map = L.map('map', mapOptions).setView([52.5208,13.3942],11); 

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    let sidebarWidth = window.innerWidth * 0.25
    paddingLeft = window.innerWidth < 768 ? 0 : sidebarWidth
   
    featureLayer = L.geoJSON(data, {
        pointToLayer: (feature, latlng) => {return L.circleMarker(latlng, dotMarker)},
        onEachFeature: onEachFeature
    });

    //Save full set of data to our layer to use for resets
    featureLayer._data = data
    featureLayer._filters = filters

    let markers = L.markerClusterGroup(markerClusterOptions);

    let searchControl = new L.Control.Search({
        position: 'topleft',
		layer: markers,
		propertyName: 'firmenname',
        initial: false,
		marker: false,
        collapsed: false,
        textPlaceholder: labels.search[userlang],
		moveToLocation: function(latlng, title, map) {
            map.setView(latlng, 16);
		}
	});

    const mobileFilterToggle = new L.Control.FilterToggle({position:'topleft'});

    markers.addLayer(featureLayer);
    map.addControl(searchControl);

    mobileFilterToggle.addTo(map)

    let filterFeatures = L.control.filterfeatures({lang:userlang, layer: featureLayer, clusterLayer: markers})
    filterFeatures.addTo(map)

    featureList = L.control.featurelist({
        layer: featureLayer,
        randomOrder: true,
        featureName: 'firmenname',
        listItemFunction: createItemContent
    })
    featureList.addTo(map);

    filterFeatures.on('filter:apply', ()=> {
        featureList.updateList()
    }).on('filter:reset', ()=> {
        featureList.updateList()
    })

    searchControl.on('search:locationfound', (e)=> {
		e.layer.setStyle(activeStyle);
        featureList.goToItem(e.layer.item, e.layer)
        e.layer.fire("mouseover")
	}).on('search:cancel', ()=> {
        featureLayer.eachLayer(function(layer) {
			featureLayer.resetStyle(layer)
            layer.fire("mouseout")
        })
    })
    
    map.addLayer(markers);

    const sbh = document.querySelector('.leaflet-control-container .leaflet-top.leaflet-left').clientHeight

    document.documentElement.style.setProperty('--search-container-height', `${sbh}px`)

    document.querySelectorAll('.filter__list input[type="checkbox"]').forEach((el) => {
        el.addEventListener('change', function() {
            document.querySelector('.reset__filters').classList.remove('disabled')
        })
    })

    const sidebarEl = document.querySelector('.leaflet-top.leaflet-left')

    if (screen.width < 800) { 
        sidebarEl.classList.add('show-map')
    }

    document.querySelectorAll('#viewSwitch div').forEach(el => {
        el.addEventListener('click', (e) => {

            document.querySelectorAll('#viewSwitch div').forEach(el => {
                el.classList.toggle('activeView')
            })

            document.querySelector('#viewMap').classList.contains('activeView') ? sidebarEl.classList.add('show-map') : sidebarEl.classList.remove('show-map')
            
        })
    })

    if (document.querySelectorAll('.leaflet-top.leaflet-left').length > 0){
        setSidebarHeight()
    }

}

function getServiceValues(data, lang) {
    
    let lookup = {}, result = [];
    const items = data.features;

    for (let item, i = 0; item = items[i++];) {

        const services = [item.properties[service1],item.properties[service2],item.properties[service3]]

        services.forEach(el => {
            if ( !(el in lookup) && el !== "" && el !== undefined ) {
                lookup[el] = 1;
                result.push(el);
            }
        })

    }
    
    result.sort()

    //dirty trick to get Ä at start:
    if (lang == "de") {
        result.unshift(result.pop());
    }
    
    return result
}

function getDistrictValues(data) {
    
    let lookup = {}, result = [];
    const items = data.features;

    for (let item, i = 0; item = items[i++];) {
        let name = item.properties.bezirk;
        if ( !(name in lookup) && name !== "" ) {
            lookup[name] = 1;
            result.push(name);
        }
    }

    result.sort()
    
    return result
}

function fetchResults(url) {
    fetch(url).then(response => {
        return response.json();
    }).then(data => {
        initMap(data)
    }).catch(err => {
        console.log(err)
    });
}