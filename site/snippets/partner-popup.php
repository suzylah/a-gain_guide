<style>

    /* Partner Popup Ad */
    .popup {
        position: fixed;
        top: 24vh;
        left: 26vw;
        width: 48vw;
        height: calc(24vw + var(--element-height));
        box-shadow: 0 0 100px 20px rgba(0,0,0,0.25);
        z-index:9999;
        border-radius: calc(var(--element-height) / 2);
        overflow:hidden;
        border:var(--border-solid);
        max-width:1240px;
        max-height: calc(620px + var(--element-height));
        background-color: #c4d9ef;
    }

    .popup-content {
        padding:var(--element-height) 0 0;
        background:#c4d9ef;
        background:#fff;
    }

    .popup-content .topline {
        line-height: var(--element-height);
        top:0;
    }

    .popup-content img {display:block;}

    .popup-actions {display:flex;
    position:absolute;bottom:1em;

    justify-content: center;
        gap: 1em;
        width: 100%;}

    .popup-actions .btn-link {
        margin:0;
        cursor:pointer;
    }

    .popup-actions .btn-link:hover {color:inherit;}

    .popup-actions .btn-link.btn-close::after,
    .topline.closer::after {
    content: "";
    display: block;
    width: 0.8em;
    height: 0.8em;
    background: url(/assets/icons/plus.svg) no-repeat;
    background-size: contain;
    position: absolute;
    right: var(--spacing-unit);
    top: calc(50% - 0.4em);
    transition: .25s ease-in-out transform;
    transform: rotate(45deg);
    cursor:pointer;
    }

    @media screen and (max-width:767px) {
        .popup {display:none;}
    }

    @media screen and (max-width:1023px) {
        .popup {
            left: 14vw;
            width: 72vw;
            height: calc(36vw + var(--element-height));
        }
    }

</style>

<?php if (! a::get($_COOKIE, 'agg_partner') ) { ?>
  <div id="partnerpopup" class="popup">
    <div class="popup-content">
      <span class="topline closer">
        <?php if($kirby->language()->code() == 'de'): ?>
          Partneranzeige
        <?php else: ?>
          Partner Ad
        <?php endif ?>
      </span>
      <img src="#" />
      <div class="popup-actions">
      <button class="btn-link btn-external"><a href="#" target="_blank">
        Link text
      </a></button>
      <button id="popup-close" class="btn-link btn-close">
        <?php if($kirby->language()->code() == 'de'): ?>
          Schliessen
        <?php else: ?>
          Close
        <?php endif ?>
      </button>
        </div>
    </div>
  </div>

  <script>

    document.querySelector('#popup-close').onclick = (e) => {
        document.querySelector('#partnerpopup').style.display = "none";
        setCookie('agg_partner','hide',7);
    }

    document.querySelector('.popup-content .closer').onclick = (e) => {
        document.querySelector('#partnerpopup').style.display = "none";
        setCookie('agg_partner','hide',7);
    }

    window.addEventListener('click', function(e) {
        const popup = document.querySelector('#partnerpopup')

        if (outsideClick(e, popup) && ! getCookie('agg_partner')) {
            document.querySelector('#partnerpopup').style.display = "none";
        }
    });

  </script>

<?php } ?>

