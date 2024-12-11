  </main>

  <footer class="footer">
    <div class="grid footer-menu">
      <div class="column" style="--columns: 1">
        <ul>
          <?php foreach ($site->children()->listed() as $page): ?>
          <li><a href="<?= $page->url() ?>"><?= $page->title()->html() ?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
      <div class="column" style="--columns: 1">
        <ul>
          <li><a href="https://forms.gle/nm8PqpumhDnBeWer5" target="_blank">Register</a></li>
          <li><a href="<?= $pages->find('contact')->url() ?>#newsletter">Newsletter</a></li>
        </ul>
      </div>
      <div class="column" style="--columns: 1">
        <ul>
          <li><a href="<?= $pages->find('impressum')->url() ?>">Imprint</a></li>
          <li><a href="<?= $pages->find('datenschutz')->url() ?>">Privacy</a></li>
        </ul>
      </div>
      <div class="column" style="--columns: 1">
        <?php snippet('social') ?>
      </div>
    </div>

    <div class="grid">
      <div class="column tagline mobile-order-2" style="--columns: 6; display:flex; align-items:center;">
        <span class="btn-link __dark"><?= $site->title() ?></span>
        <p>Gebrauchte Kleidung<br> ist mehr Wert!</p>
      </div>
      <div class="column mobile-order-1" style="--columns:6;display:flex;justify-content:flex-end;">
        <ul class="partner-logos" style="display:flex;align-items: center;">
          <li><a href="#/" target="_blank"><img src="#" srcset="# 2x"/></a></li>
          <li><a href="#" target="_blank"><img src="#" /></a></li>
          <li><img src="#" /></li>
          <li><img src="#" /></li>
          <li><img src="#"/></li>
        </ul>
      </div>
    </div>
  </footer>

  <div class="colophon"><span><?= $site->copyright() ?></span><span>&nbsp</span></div>
  <?php snippet('knowledge-popup') ?>

  <?php snippet('cookie-modal',[
    'assets' => true,
    'showOnFirst' => true,
  ]) ?>

  <?= js([
    'assets/js/index.js',
    'https://cdn.jsdelivr.net/npm/@glidejs/glide',
    '@auto'
  ]) ?>

</body>
</html>
