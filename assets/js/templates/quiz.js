/*
* A–Gain Guide - Guide
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

Element.prototype.hide = function() { this.style.display = "none" }
Element.prototype.show = function() { this.style.display = "block" }

Array.prototype.filterByValue = function(feature,property) {
    return feature.properties.hasOwnProperty(property) ? this.includes(feature.properties[property]) : false
}

function filterByValue(feature,property,arr) {
    return feature.properties.hasOwnProperty(property) ? arr.includes(feature.properties[property]) : false
}

function toggleView(el) {
    el.classList.toggle('show')
}

function getValues(arr,val,key) {
    const match = arr.filter(item => { return item.name === val })
    return match.length !== 0 && match[1].hasOwnProperty(key) ? match[1][key] : null
}

function toMachine(str) { return str.replace(/[ -]/g,'_').toLowerCase() }
function findCommonElement(arr1, arr2) { return arr1.some(item => arr2.includes(item)) }

function howFar(feature,myPos) {
    const x1 = L.latLng(feature.geometry.coordinates)
    const x2 = L.latLng(myPos)
    const dist = x1.distanceTo(x2)
    return Math.floor(dist / 1000)
}

function updateRange(e) {

    const range = e.target
    const thumbHalfWidth = 40 / 2
    
    //const left = (((range.value - range.min) / (range.max - range.min)) * (range.offsetWidth - thumbHalfWidth)) + thumbHalfWidth
    const left = (((range.value - range.min) / (range.max - range.min)) * (range.offsetWidth - thumbHalfWidth) - thumbHalfWidth) + thumbHalfWidth
    
    const list = document.getElementById(e.target.getAttribute('list'))
    const options = list.querySelectorAll('.datalist-opt') !== null ? list.querySelectorAll('.datalist-opt') : ['foo']
    const currentValue = Math.round(range.value)
    options.forEach(item => item.style.color = "transparent")
    options[currentValue - 1].style.color = "#2b2e34"
    //options[currentValue - 1].querySelector('.name').style.left = left + "px"

}

const fService1 = userlang == "de" ? "service1" : "service1EN",
    fService2 = userlang == "de" ? "service2" : "service2EN",
    fService3 = userlang == "de" ? "service3" : "service3EN",
    fOptions = userlang == "de" ? "serviceAngebote" : "serviceAngeboteEN",
    fProducts = userlang == "de" ? "produkte" : "produkteEN";

let slides, currentSlide = 0, results = { citywide: {} }

const serviceLookup = {
    "Kleiderschrank neu stylen":"Re-style my wardrobe",
    "Reparieren":"Repair",
    "Upcyceln":"Upcycle",
    "Verkaufen":"Sell",
    "Tauschen":"Swap",
    "Spenden":"Donate",
    "Waschen":"Clean",
}

function countSlides() {
    slides = document.querySelectorAll('.carousel-item:not(.question-hidden)');
    return slides.length
}

function showAdvice() {
    const issue = document.querySelector('#q6_problem')
    const boxes = issue.querySelectorAll('#o6_schimmelig:checked,#o6_motten:checked,#o6_schmutzig:checked,#o6_clothes_with_moths:checked,#o6_dirty_or_mouldy_clothes_textiles:checked,#o6_dirty_shoes_accessories:checked,#o6_there_are_holes_on_the_fabric:checked')

    if(boxes.length > 0) { toggleView(document.querySelector('.guide-advice-screen')) }
}

function formControls() {

    const myCarousel = document.getElementById('guideForm')

    const prev = document.querySelector('.carousel-control-prev');
    const next = document.querySelector('.carousel-control-next');
    const progbar = document.querySelector('#progressbar');
    myCarousel.addEventListener('slide.bs.carousel', () => {
        progbar.style.backgroundColor = "transparent"
    })

    myCarousel.addEventListener('slid.bs.carousel', function () {
        
        const carousel = bootstrap.Carousel.getInstance(myCarousel)
        const curr = carousel["_activeElement"]
        const lastIndex = carousel["_items"].length - 1
        
        currentSlide = carousel["_items"].indexOf(curr)
        updateProgress(currentSlide)
        
        if (curr.classList.contains("required") && ! hasValue(curr)) {
            next.classList.add('disabled')
        } else {
            next.classList.remove('disabled')
        }

        if (curr.querySelectorAll('.part-intro').length > 0) {
            progbar.classList.add('hidden')
        } else {
            progbar.classList.remove('hidden')
        }

        if (curr.hasAttribute('data-guide-section')) {
            myCarousel.setAttribute('data-guide-part',curr.getAttribute('data-guide-section'))
        } 

        progbar.style.backgroundColor = "inherit"

        if (!carousel["_items"][0].classList.contains("active")) {
            prev.classList.remove("hidden")
        } else {
            prev.classList.add("hidden")
        }

        if (carousel["_items"][lastIndex].classList.contains("active")) {
            next.classList.add("hidden")
        } else {
            next.classList.remove("hidden")
        }

        //If we are looking for problems
        
        if ( !!document.querySelector('.carousel-item.active').querySelector('#q6_problem') ) {
            next.addEventListener('click', showAdvice)
        } else {
            next.removeEventListener('click', showAdvice)
        }

    })

    countSlides();

    document.querySelectorAll('.required input').forEach(el=> {
        el.addEventListener('change',() => {
            const activeSlide = document.querySelector('.carousel-item.active')
            if ((next.classList.contains('disabled') && hasValue(activeSlide)) || (!next.classList.contains('disabled') && !hasValue(activeSlide)))
                next.classList.toggle('disabled')   
        })
    })
    
    function hasValue(el) {
        const cb = el.querySelectorAll('input:checked')
        return cb.length ? true : false
    }

    function toggleInputValues(id, name) {
        
        if ( document.querySelector(`#${id}`) !== null) {
            document.querySelectorAll(`input[name="${name}"]`).forEach(el => {
                el.addEventListener('change', (e) => {
                    if (e.target.id == id && e.target.checked) {
                        document.querySelectorAll(`input[name="${name}"]`).forEach(el=>{
                            el.checked = el == e.target ? true : false
                        })
                    } else if (e.target.id !== id && e.target.checked) {
                        document.querySelector(`#${id}`).checked = false
                    }
                })
            })
        }
    }

    toggleInputValues("o4_all_sizes","size[]")
    toggleInputValues("o0_all_kinds","product[]")
    toggleInputValues("o4_alle_groessen","size[]")
    toggleInputValues("o0_alle","product[]")
    toggleInputValues("o3_aller_art_marken","origin[]")
    toggleInputValues("o3_ich_weiss_es_nicht","origin[]")
    toggleInputValues("o3_i_don_t_know","origin[]")
    toggleInputValues("o7_i_don_t_know","serviceType[]")

}

function updateProgress(current) {
    const total = countSlides() - 1;
    const progressBar = document.querySelector('#progressbar')
    let progress = Math.floor(current / total * 100)
    progressBar.setAttribute("value", progress);
}

function conditionalQuestions() {

    const followUpPairs = userlang == "de" ? [["#o7_kleiderschrank_neu_stylen","#q8_re_style_my_wardrobe"],["#o7_reparieren","#q9_repair"],["#o7_upcyceln","#q10_upcycle"],["#o7_verkaufen","#q11_sell"],["#o7_tauschen","#q12_swap"],["#o7_spenden","#q13_donate"]] : [["#o7_re_style_my_wardrobe","#q8_re_style_my_wardrobe"],["#o7_repair","#q9_repair"],["#o7_upcycle","#q10_upcycle"],["#o7_sell","#q11_sell"],["#o7_swap","#q12_swap"],["#o7_donate","#q13_donate"]]

    followUpPairs.forEach((el) => {
        document.querySelector(el[0]).addEventListener('change', (e)=>{
            document.querySelector(el[1]).parentElement.classList.toggle('carousel-item')
            document.querySelector(el[1]).parentElement.classList.toggle('question-hidden')
        })
    })
}

function saveQuery(formdata){
    
    fetch('process-query', {
        method:"POST",
        body:formdata
    })
    .then(response =>{
        response.text()
            .then(txt => {
                console.log(txt);
            })
    })
}

function onFormSubmit(e) {

    e.preventDefault()

    let response = {}
    const formData = new FormData(document.querySelector('#guideForm'))

    formData.append('lang',userlang)
    saveQuery(formData)

    formData.forEach(function(value, key){
        if (key.substring('[]')) { key = key.replace('[]','') }
        response[key] == undefined ? response[key] = [value] : response[key].push(value)
    });

    fetchResults(response)

    document.body.classList.add('guide-results')
    document.querySelector('#guideForm').remove()
    document.querySelector('#result').show()
    document.querySelectorAll('.actions .button-group').forEach( el=> el.style.display = "block" )

}

function fetchResults(query) {

    const fetchStakeholders = fetch(stakeholders).then((res) => res.json())
    const reuseDataSource = `/${userlang}/reusematrix.json`
    const fetchReuse = fetch(reuseDataSource).then((res) => res.json())
    const allData = Promise.all([fetchStakeholders,fetchReuse])

    allData.then((res) => {

        const data = res[0]
        const reuseMatrix = res[1]

        initMap(data)

        function evalService(selectionArr) {
            const servicesByCategory = {}
            selectionArr.forEach( el => {
                const arr = reuseMatrix.filter(i => {return i.name === "Service Category"})
                const matches = arr[0].options.filter(i => {return i.name === el})
                servicesByCategory[el] = matches[0].services
            })
            return servicesByCategory
        }
        
        query.services = query.hasOwnProperty('serviceType') ? evalService(query.serviceType) : null
        const places = query.hasOwnProperty('location') && query.location[0] !== '' ? query.location[0].split(/,|\s/) : []

        query.serviceType.forEach(serviceCategory => {

            const serviceArray = query.services[serviceCategory]
            const serviceCategoryKey = userlang == "de" ? serviceLookup[serviceCategory] : serviceCategory
            const serviceArrSpec = []
            const offersArrSpec = []
            const _serviceCategory = userlang == "de" ? toMachine(serviceCategoryKey) : toMachine(serviceCategory)

            if (query.hasOwnProperty(_serviceCategory)) {
                
                const choices = query[_serviceCategory]
                
                const ref = reuseMatrix.filter(i => {return i.name === serviceCategoryKey})
                
                choices.forEach(choice => {
                    
                    const opts = ref[0].options.filter(i => {return i.name === choice})
                    
                    if (opts.length !== 0) {
                        const o = opts[0]
                        if(o.hasOwnProperty('services')) {
                            const xs = opts[0].services.length > 0 ? opts[0].services : serviceArray
                            serviceArrSpec.push(...xs)
                        }
    
                        if(o.hasOwnProperty('offers')) {
                            const xo = opts[0].offers.length !== 0 ? opts[0].offers : ["pass"]
                            offersArrSpec.push(...xo)
                        }
                    } else {
                        serviceArrSpec.push(...serviceArray)
                    }
                })
            } else {
                serviceArrSpec.push(...serviceArray)
            }

            let optionsArray = offersArrSpec

            const myLoc = query.hasOwnProperty('location_loc') && query.location_loc[0] !== ''  ? query.location_loc[0].split(',') : false

            const results_city = data['features'].filter( feature => { 
                
                const featureOptions = feature.properties.hasOwnProperty(fOptions) ? feature.properties[fOptions].split(', ') : [];
                const featureProducts = feature.properties.hasOwnProperty(fProducts) ? feature.properties[fProducts].split(', ') : ["Undefined"];
                
                const hasServices = serviceArrSpec.filterByValue(feature,fService1) || serviceArrSpec.filterByValue(feature,fService2) || serviceArrSpec.filterByValue(feature,fService3)

                const hasOptions = featureOptions.find(el => optionsArray.includes(el)) || optionsArray.length == 0 || optionsArray.includes["pass"] || true

                const hasProducts = query.product.filterByValue(feature,fProducts) || query.product.includes("All kinds") || query.product.includes("Alle") || featureProducts.includes("All categories of clothes & textiles") || featureProducts.includes("Alle Arten von Bekleidung und Textilien") || featureProducts.includes("Undefined")

                return hasServices && hasProducts && hasOptions

            })
            
            const results_locations = results_city.filter( feature => {

                const distToUser = myLoc ? howFar(feature,myLoc) : null

                const matchPlaces =  places.filterByValue(feature, "bezirk") || places.filterByValue(feature, "postleitzahl") || (myLoc && distToUser < 3) || (!myLoc && places.length == 0)
                return matchPlaces
            })

            results[serviceCategory] = results_locations
            results['citywide'][serviceCategory] = results_city

            if (results_locations.length == 0) {
                addLayerToMap(results_city, serviceCategory)
            } else {
                addLayerToMap(results_locations, serviceCategory)
            }

        })

        const bounds = markers.getBounds()
        const pLeft = window.innerWidth < 768 ? 0 : window.innerWidth / 2;

        if (bounds.isValid()) {
            map.fitBounds(bounds, { paddingTopLeft:[pLeft,0]})
        }
        
        addFooterToMap()

    }).catch(err => {
        console.log(err)
    });
    
}

function init() {
    conditionalQuestions();
    formControls();
    document.querySelector('#startguide').style.display = "flex";
    document.querySelector('#submitQuery').addEventListener('click', onFormSubmit);
}

document.addEventListener("DOMContentLoaded", init)

function showGlossary(e) {
    const x = e.target.getAttribute('aria-controls')
    const t = document.querySelector(x)
    toggleView(t)
}

function closeGlossary(e) {
    toggleView(e.target.closest('.show'))
}

function showQuitWarning() {
    const t = document.querySelector('.quit-warning-screen')
    toggleView(t)
}

document.querySelectorAll('.button-group > .btn').forEach(el=>{
    el.addEventListener('click',(e)=>{
        toggleView(el.parentNode)
    })
})

function cancelGuide() {
    location.reload()
}

function startGuide() {
    document.body.classList.add('guide-active');
    document.querySelector('.header').hide();
    document.querySelector('.lang-switch-s').hide();
    document.querySelector('#content').hide();
    document.querySelector('.footer').hide();
    document.querySelector('.colophon').hide();
    document.querySelector('#guide').show()
    document.querySelector('.share-guide').hide();
}