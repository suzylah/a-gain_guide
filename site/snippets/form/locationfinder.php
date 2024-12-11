<div class="form-group location">
<div class="getloc" onClick="getLocation()">Use current location<span class="spinner"></span></div>
<div style="position:relative">
<input type="text" id="q" onKeyUp="showResults(this.value)" width="360" placeholder="Type PLZ or district" />
<input type="text" name="<?= $question->shortname() ?>" id="x" style="display:none"/>
<input type="text" name="<?= $question->shortname() ?>_loc" id="mypos" style="display:none"/>
<div id="places"></div>
<div id="selected"></div>
</div>



</div>

<?= js('assets/data/plz.js') ?>

<script>

let selected=[]

function autocompleteMatch(input) {
  if (input == '') {
    return [];
  }

  //data.filter(x => new RegExp(term, 'i').test(x.title));
  var reg = new RegExp(input, 'i')
  return places.filter((term) => {
	  if (term.match(reg)) {
  	    return term;
	  }
  });
}
 
function showResults(val) {
  res = document.getElementById("places");
  res.innerHTML = '';
  let list = document.createElement('ul');
  res.append(list)
  let terms = autocompleteMatch(val);
  for (i=0; i<terms.length; i++) {
    let item = document.createElement('li')
    item.innerHTML = terms[i]
    item.addEventListener('click',(e)=>{
        selected.push(e.target.innerHTML)
        document.getElementById("x").value += `${e.target.innerHTML},`
        res.innerHTML = ''
        let place = document.createElement('span')
        place.innerHTML = e.target.innerHTML
        place.addEventListener('click',(e)=>{e.target.remove()})
        document.getElementById("selected").append(place)
        document.getElementById("q").value = ""
    })
    list.append(item)
  }
}


function getLocation() {

  const spin = document.querySelector(".spinner");
  spin.style.visibility = "visible"

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    let place = document.createElement('span')
    place.innerHTML = `Geolocation is not supported by this browser.`
    document.getElementById("selected").append(place)
    spin.style.visibility = "hidden"
  }
}

function showPosition(position) {
    const spin = document.querySelector(".spinner");
    let place = document.createElement('span')
    place.innerHTML = `My location`
    document.getElementById("mypos").value = `${[position.coords.longitude,position.coords.latitude]}`
    place.addEventListener('click',(e)=>{e.target.remove()})
    document.getElementById("selected").append(place)
    spin.style.visibility = "hidden"
}

</script>