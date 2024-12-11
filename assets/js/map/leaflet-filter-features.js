/*
* Leaflet Filter Features version 1.0.0
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
*
*/

let filters = {
    service: {
        de: [],
        en: []
    },
    district: {
        de:[],
        en:[],
    },
}

let filterStates =  { district: 0, service: 0 };

function filterByValue(feature,property) {
    return feature.properties.hasOwnProperty(property) && filterStates.service.includes(feature.properties[property])
}

const highlight = {fillColor:'#ff007f',zIndexOffset:999}

L.Control.FilterFeatures = L.Control.extend({

    includes: L.Evented.prototype,

    options: {
        position: 'topleft',
        layer: false,
        lang: "en",
        collapsed: true,
        filterData: filters,
        clusterLayer: false,
    },

    initialize: function(options) {
        L.Util.setOptions(this, options);
        this._container = null;
        this._list = null;
        this._reset = null;
        this._layer = this.options.layer || new L.LayerGroup();
    },

    onAdd: function(map) {

        this._map = map;

        this._layer.options.filter = this.filterFunction

        filterStates.district = filters.district.en

        if (this.options.lang == "de") {
            filterStates.service = filters.service.de
        } else {
            filterStates.service = filters.service.en
        }

        this._filterStates = filterStates
        
        const container = this._container = L.DomUtil.create('div', 'leaflet-control-filter-feature');

        L.DomEvent.on(container, 'mousewheel', L.DomEvent.stopPropagation);

        const toggleCont = L.DomUtil.create('div','filter__toggler',container)

        const activeFilters = L.DomUtil.create('div','activeFilters', container)
        this._active = activeFilters

        
        const cbCont = this._list = this._container = L.DomUtil.create('div','filter__list',container)

        

        for (category in this.options.filterData) {
            const toggle = L.DomUtil.create('div',`toggle toggle-${category}`,toggleCont)
            toggle.innerHTML = labels[category][this.options.lang]
            L.DomUtil.create('span','count',toggle)
            
            const cbGroup = L.DomUtil.create('div',`checkbox-group ${category}-group`,cbCont)

            this.options.filterData[category][this.options.lang].forEach((filter) => {
                cbGroup.appendChild(this._createCheckbox(filter, category))
            })

            L.DomEvent.on(toggle, 'click', (e) => {
                /** Click triggered twice in Safari Browser */
                if (e._simulated !== true) {
                    if (this._container.classList.contains('active')) {
                        if (toggle.classList.contains('open')) {
                            toggle.classList.toggle('open')
                            cbGroup.classList.toggle('open')
                            this._container.classList.toggle('active')
                        } else {
                            document.querySelector('.checkbox-group.open').classList.toggle('open')
                            document.querySelector('.toggle.open').classList.toggle('open')
                            toggle.classList.toggle('open')
                            cbGroup.classList.toggle('open')
                        }
                    } else {
                        toggle.classList.toggle('open')
                        cbGroup.classList.toggle('open')
                        this._container.classList.toggle('active')
                    }
                }
            })

        }

        

        const div = L.DomUtil.create('div','filter__buttons',cbCont)

        const reset = this._reset = L.DomUtil.create('button','reset__filters filter__btn disabled',div)
        reset.innerHTML = labels.reset[this.options.lang]

        const submit = L.DomUtil.create('button','apply__filters filter__btn',div) 
        submit.innerHTML = labels.submit[this.options.lang]

        L.DomEvent.on(submit, 'click', this._updateFilters, this);
        L.DomEvent.on(reset, 'click', this.resetFilters, this);

        return container;

    },

    _initToggle() { },

    expand: function(toggle) {
		toggle = typeof toggle === 'boolean' ? toggle : true;
		L.DomUtil.addClass(this._container, 'filter-open');
		if ( toggle !== false ) {
			this._map.on('dragstart click', this.collapse, this);
		}
		this.fire('filter:expanded');
		return this;	
	},

	collapse: function() {
		//this.cancel();
		this._alert.style.display = 'none';
		
		if(this.options.collapsed)
		{
			L.DomUtil.removeClass(this._container, 'filter-open');		
			
			this._map.off('dragstart click', this.collapse, this);
		}
		this.fire('filter:collapsed');
		return this;
	},

    onRemove: function(map) {
        // Nothing to do here
    },

    _createCheckbox: function(filter, category) {

        const field = L.DomUtil.create('div', 'form-field checkbox-field')
        const cb = L.DomUtil.create('input','filter',field)
        
        cb.classList.add(category)
        cb.id = filter
        cb.setAttribute('type','checkbox')
        cb.setAttribute('name',filter)
        cb.setAttribute('value',filter)
        L.DomUtil.create('span', 'cb', field)
        const cbl = L.DomUtil.create('label', 'field-label', field)
        cbl.htmlFor = filter
        cbl.innerHTML = filter

        return field
        
    },

    _updateFilters: function() {
        
        this._layer.clearLayers()
        this.options.clusterLayer.clearLayers()
        
        filterStates.service = [];
        filterStates.district = [];
    
        for (let input of document.querySelectorAll('input.filter')) {
            
            if(input.checked) {
                switch (input.className) {
                    case 'filter service': 
                        filterStates.service.push(input.value); 
                    break
                    case 'filter district': 
                        filterStates.district.push(input.value); 
                    break
                }
            }
        }
        
        this._layer.addData(this._layer._data)
        this.options.clusterLayer.addLayer(this._layer)

        document.querySelectorAll('.checkbox-group.open,.toggle.open').forEach(el => {
            el.classList.toggle('open')
        })
        this._container.classList.toggle('active')

        //map.fitBounds(featureLayer.getBounds(), { paddingTopLeft: [sidebarWidth, 0] } );
        
        if( Object.keys(this._layer._layers).length !== 0 )
            this._map.fitBounds(this._layer.getBounds() )
        
        this.listFilters()
        this.fire('filter:apply')
    },

    filterFunction: (feature) => {
        const hasGeo = feature.properties.hasOwnProperty("latitude")
        const serviceFilter =  filterByValue(feature,service1) || filterByValue(feature,service2) || filterByValue(feature,service3) || filterStates.service.length == 0
       
        const districtFilter = filterStates.district.includes(feature.properties.bezirk) || filterStates.district.length == 0;

        return serviceFilter && districtFilter && hasGeo;
    },

    listFilters: function(i) {

        this._active.innerHTML = ''
        
        if (this._container.classList.contains('filter-active'))
            this._container.classList.remove('filter-active')

        if (i == 0) {
            document.querySelector('.toggle-service .count').innerHTML = ''
            document.querySelector('.toggle-district .count').innerHTML = ''
            for (let input of document.querySelectorAll('input.filter')) {
                input.checked = false
            }
       
        } else {
            const a = filterStates.service.concat(filterStates.district)
    
            a.forEach(x => {
                const ax = L.DomUtil.create('span','', this._active)
                ax.innerHTML = x;
            })

            document.querySelector('.toggle-service .count').innerHTML = filterStates.service.length > 0 ? ` (${filterStates.service.length})` : ''
            document.querySelector('.toggle-district .count').innerHTML = filterStates.district.length > 0 ? ` (${filterStates.district.length})` : ''

            if (! this._container.classList.contains('filter-active'))
                this._container.classList.add('filter-active')
            
        }
        
    },

    resetFilters: function() {

        this._layer.clearLayers()
        this.options.clusterLayer.clearLayers()

        filterStates.service = this._layer._filters.service[this.options.lang]
        filterStates.district = this._layer._filters.district[this.options.lang]

        this._layer.addData(this._layer._data)
        this.options.clusterLayer.addLayer(this._layer)
        
        document.querySelectorAll('.checkbox-group.open,.toggle.open').forEach(el => {
            el.classList.toggle('open')
        })
        this._container.classList.toggle('active')

    
        if( Object.keys(this._layer._layers).length !== 0 )
            this._map.fitBounds(this._layer.getBounds() )
            
        this.listFilters(0)

        this.fire('filter:reset')

    }

});

L.control.filterfeatures = (options) => new L.Control.FilterFeatures(options)

