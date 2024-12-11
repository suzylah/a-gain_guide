<?php snippet('header') ?>

<?= css([
    'assets/css/glide.css'
]) ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.glide');
    sliders.forEach((slider)=>{
      new Glide(slider, {
        gap: 0,
        autoplay: 5000
      }).mount()
    })
  }, false);
</script>

<div class="layout grid" style="--gutter: 0">
  <section id="home__cover" class="column h-90 bg-orange vertical__center" style="--columns: 12;">
    <span class="topline">
      <?php if($kirby->language()->code() == 'de'): ?>
        Willkommen
      <?php else: ?>
        Welcome
      <?php endif ?>
    </span>

    <?php snippet('slider') ?>
   
  </section>
</div>

<?php snippet('layouts', ['field' => $page->layout()])  ?>

<?php snippet('footer') ?>