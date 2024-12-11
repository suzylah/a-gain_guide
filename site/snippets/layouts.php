<?php foreach ($field->toLayouts() as $layout): ?>

<?php //foreach ($field->layout()->toLayouts() as $layout): ?>
<section class="layout grid margin-0 <?= $layout->class() ?>" id="<?= $layout->id() ?>" >

  <?php foreach ($layout->columns() as $column): ?>
  
  <div class="column" style="--columns:<?= $column->span() ?>">
  
    <?php foreach ($column->blocks() as $block): ?>
      <?php $bgImg = $block->poster()->toFile()  ?>
      
      <div class="block block-type-<?= $block->type() ?> bg-<?= $block->background() ?> <?= $block->class() ?>" style="<?php if ($bgImg) { ?>background-image:url(<?= $bgImg->url(); ?>)<?php } ?>">
        <?= $block ?>
      </div>
    <?php endforeach ?>
  </div>
  <?php endforeach ?>

</section>
<?php endforeach ?>
