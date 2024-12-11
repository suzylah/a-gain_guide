/*
* Leaflet Feature List version 1.0.0
* 
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
*/

L.Control.FeatureList = L.Control.extend({

    options: {
        position: 'topleft',
        layer: false,
        title: false,
        featureName: 'name',
        classname: 'leaflet-control-feature-list',
        listItemFunction: listItemFunctionDefault
    },

    initialize: function(options) {
		L.Util.setOptions(this, options);
		this._container = null;
		this._list = null;
		this._layer = this.options.layer || new L.LayerGroup();
	},

    onAdd: function(map) {

        this._map = map;
        
        const container = L.DomUtil.create('div', this.options.classname);
    
        this._container = container;

        const numResults = this._layer.getLayers().length

        if (this.options.title) {
            const header = L.DomUtil.create('div', 'result-group-headline', container);
            header.innerHTML = `${this.options.title} (${numResults})`

            if (numResults > 4) {
                header.classList.add('collapsible','collapsed')
                header.addEventListener('click',(e)=>{e.target.classList.toggle('hidden')})
            }
        }
        
        this._list = L.DomUtil.create('div', 'result-inner', container);

        L.DomEvent.on(container, 'mousewheel', L.DomEvent.stopPropagation);
        L.DomEvent.disableScrollPropagation(container)

        if (numResults == 0) {
            const empty = L.DomUtil.create('p','no-result-message',this._list)
            empty.innerHTML = `Unfortunately there are no services we can show you for the selected options :(`
        } else {
            this.updateList();
        }

        if (numResults > 4) {
            const showAll = L.DomUtil.create('div', 'btn btn-outline-primary show-all', container);
            showAll.textContent = `Show all`;
            L.DomEvent.on(showAll,'click',(e)=>{
                e.target.parentNode.querySelector('.result-group-headline').classList.toggle('collapsed')
            })
        }

        return container;

    },

    _getItem: function(layer) {
        return layer
    },

    _createItem: function(layer) {

        if ( layer.feature.properties.hasOwnProperty(this.options.featureName) ) {

		    const item = layer.item = L.DomUtil.create('div', 'listItem'),
			that = this;

            if (layer.feature.properties.hasOwnProperty("serviceArt") && layer.feature.properties["serviceArt"] == "Online") {
                item.classList.add("online-service")
            }

		    L.DomEvent
			.on(item, 'click', function(e) {     
                this.goToItem(item, layer)
                featureLayer.resetStyle();

                if (typeof geojsonLayers !== 'undefined') {
                    geojsonLayers.forEach(el => el.resetStyle())
                }

                if (!(layer.feature.properties.hasOwnProperty('serviceArt') && layer.feature.properties.serviceArt == 'Online')) { 
                // Only pan to item if not online
                    
                    layer.setStyle(activeStyle).bringToFront();
                    if (typeof paddingLeft !== 'undefined') {
                        this._map.flyTo( layer.getLatLng(), 15, { paddingTopLeft: [paddingLeft, 0] } );
                    } else {
                        let pLeft = window.innerWidth < 768 ? 0 : document.querySelector('.leaflet-top.leaflet-left').width
                        this._map.flyTo( layer.getLatLng(), 15, { paddingTopLeft: [pLeft, 0] } );
                        //this._moveTo( layer.getLatLng() );
                    }
                }
                
			}, this)
            .on(layer, 'click', () => {
                this.goToItem(item, layer)
            })

            this.options.listItemFunction(item,layer.feature)
        
            return item;

		}
		
	},

    goToItem: function(item,layer) {
        const others = this._list.querySelectorAll('.active')
        others.forEach( el => {
            if (el !== item) 
                el.classList.toggle('active')
        })

        if (!item.classList.contains('active'))
            item.classList.toggle('active');
        
        //if more feature list, reset them all
        if (typeof geojsonLayers !== 'undefined') {
            this._container.parentNode.querySelectorAll('.active').forEach(el => {
                if (el !== item) 
                    el.classList.toggle('active')
            })
        }
        
        const dest = item.offsetTop + 1
        
        this._container.scrollTo({
            top: dest,
            left: 0,
            behavior: 'smooth'
        });

    },

	updateList: function() {
	
		const that = this;

		L.DomUtil.empty(this._list)

        if(this.options.randomOrder){
            
            let items = []
		    this._layer.eachLayer(function(layer) {
                const item = that._createItem(layer)
                items.push(item)
		    })

            items = items.sort((a, b) => 0.5 - Math.random());
            items.forEach((item => that._list.appendChild( item )))
        } else {
            this._layer.eachLayer((layer) => {
                const item = that._createItem(layer)
                that._list.appendChild( item )
            })
        }
        
	},

    _moveTo: function(latlng) {
        //Ensure min zoom level is without clusters
        this._map.setView(latlng, Math.max(this._map.getZoom(), 15) );
    },

});

L.control.featurelist = function(options) {
    return new L.Control.FeatureList(options);
}

function listItemFunctionDefault(item,props) {
    let heading = L.DomUtil.create('h3', '', item)
    heading.innerHTML = props.name
    return item;
}