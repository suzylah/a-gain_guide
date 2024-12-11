

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
        background-color: #88d6a3;
    }

    .popup h2 {
        font-size:42px;
        font-size:2.8vw;
        margin-bottom:var(--spacing-unit);
    }

    .popup p {
        font-size:25px;
        font-size:1.65vw;
    }

    .popup-header {
        background:#fff;
        height:var(--element-height);
        border-bottom: var(--border-solid);
    }

    .popup-content {
        padding:var(--element-height) var(--spacing-unit) var(--spacing-unit);
        background:#88d6a3;
        text-align:center;
    }

    .popup-header .topline {
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

        .popup h2 {
            font-size:4.5vw;
        }
        
        .popup p {
            font-size:2.4vw;
        }
    }

</style>

<?php if (! a::get($_COOKIE, 'agg_partner') ) { ?>
  <div id="partnerpopup" class="popup">
    <div class="popup-header">
      <span class="topline closer">
        News
      </span>
    </div>
    <div class="popup-content">
        <h2>
          <?php if($kirby->language()->code() == 'de'): ?>
            Stärke dein Wissen über Zirkularität!
          <?php else: ?>
            Boost your knowledge on circularity!
          <?php endif ?>
        </h2>

        <p>
        <?php if($kirby->language()->code() == 'de'): ?>
          Buche unsere Textile Journey Tour durch die Straßen Berlins oder erfahre mehr auf unserer KNOWLEDGE-Seite über zirkuläre Lösungen für deine Garderobe.
        <?php else: ?>
          Book a Textile Journeys through the streets of Berlin or read on our KNOWLEDGE page about solutions for a circular wardrobe.
        <?php endif ?>
        </p>

      <div class="popup-actions">
        
        <button class="btn-link btn-external"><a href="#" target="_blank">
          <?php if($kirby->language()->code() == 'de'): ?>
            Textile Journeys
          <?php else: ?>
            Textile Journeys
          <?php endif ?>
        </a></button>
        <button class="btn-link"><a href="/knowledge">
          <?php if($kirby->language()->code() == 'de'): ?>
            KNOWLEDGE PAGE
          <?php else: ?>
            KNOWLEDGE PAGE
          <?php endif ?>
        </a></button>
      </div>
    
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      document.querySelector('.popup-header .closer').onclick = (e) => {
          document.querySelector('#partnerpopup').style.display = "none";
          setCookie('agg_partner','hide',7);
      }

      window.addEventListener('click', function(e) {
          const popup = document.querySelector('#partnerpopup')

          if (outsideClick(e, popup) && ! getCookie('agg_partner')) {
              document.querySelector('#partnerpopup').style.display = "none";
              setCookie('agg_partner','hide',7);
          }
      });

    });

  </script>

<?php } ?>

