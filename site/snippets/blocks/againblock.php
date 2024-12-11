
<?php if($block->subtitle()->isNotEmpty()) : ?>
    <span class="topline"><?= $block->subtitle()->html() ?></span>
<?php endif; ?>

<?php if($block->title()->isNotEmpty()) : ?>
    <h3>
        <?= $block->title()->html() ?>
    </h3>
<?php endif; ?>

<?php if($block->description()->isNotEmpty()) : ?>
    <p>
        <?= $block->description()->html() ?>
    </p>
<?php endif; ?>

<?php 
    $buttons = $block->button()->toStructure();
    foreach($buttons as $button) : ?>
        <button class="btn-link"><a href="<?= $button->url(); ?>" <?php if ($button->toggle()) { ?> target="_blank"<?php } ?>>
            <?= $button->text() ?>
        </a></button>
        
    <?php endforeach; ?>

<?= $block->customHTML() ?>

