// Lightbox
Array.from(document.querySelectorAll("[data-lightbox]")).forEach(element => {
  element.onclick = (e) => {
    e.preventDefault();
    basicLightbox.create(`<img src="${element.href}">`).show();
  };
});

const menuContainer = document.querySelectorAll('.menu-toggle,.menu-container')

document.querySelector('.menu-toggle').onclick = (e) => {
  menuContainer.forEach(el => el.classList.toggle('open'))
}

window.addEventListener('click', function(e) {
  if (outsideClick(e, menuContainer) && document.querySelector('.menu-toggle').classList.contains('open')) {
    menuContainer.forEach(el => el.classList.toggle('open'))
  }
});

let timeout = false, delay = 250;

function setInnerHeight() {
  const availableHeight = window.innerHeight
  document.documentElement.style.setProperty('--window-inner-height', `${availableHeight}px`)
}

window.addEventListener('resize', () => {
  clearTimeout(timeout);
  timeout = setTimeout(setInnerHeight, delay);
});

document.addEventListener("DOMContentLoaded", setInnerHeight)

/* outside click function by https://supunkavinda.blog/js-detect-outside-click */
function outsideClick(event, notelem)	{
  var clickedOut = true, i, len = notelem.length;
  for (i = 0;i < len;i++)  {
      if (event.target == notelem[i] || notelem[i].contains(event.target)) {
        clickedOut = false;
      }
  }
  if (clickedOut) return true;
  else return false;
}

function setCookie(name, value, days) {
  const d = new Date
  d.setTime(d.getTime() + 24*60*60*1000 * days)
  expDate = d.toGMTString()
  document.cookie = `${name} =  ${value};path=/;expires=${expDate}`
}

function getCookie(name) {
  var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
  return v ? v[2] : null;
}

function hideByScroll(element,distance) {
  /* hide element after scrolling x distance */
}