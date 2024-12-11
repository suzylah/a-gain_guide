<!DOCTYPE html>
<html lang="<?= $kirby->language()->code() ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1">
  <title><?= $site->title() ?> | <?= $page->title() ?></title>
  <meta name="description" itemprop="description" content="<?= $site->description() ?>">
  <meta itemprop="image" name="image" content="<?= kirby()->urls()->assets().'/images/a-gain-guide__social.jpg' ?>">
  <meta property="og:title" content="<?= $site->title() ?> | <?= $page->title() ?>" />
  <meta property="og:image" content="<?= kirby()->urls()->assets().'/images/a-gain-guide__social.jpg' ?>" />
  <meta property="og:description" content="<?= $site->description() ?>" />
  <meta property="og:url" content="<?= $page->url() ?>" />
  <meta property="og:site_name" content="<?= $site->title() ?> | <?= $page->title() ?>" />
  <meta property="og:type" content="website" />
  <meta itemprop="name"content="<?= $site->title() ?> | <?= $page->title() ?>">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:title" content="<?= $site->title() ?> | <?= $page->title() ?>">
  <meta name="twitter:description" content="<?= $site->description() ?>">

  <link rel="shortcut icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
  <link rel="icon" type="image/png" sizes="192x192"  href="/assets/icons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/assets/icons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <?= css([
    'assets/css/index.css',
    '@auto'
  ]) ?>

  <!-- Matomo -->
  <!-- End Matomo Code -->

</head>

<body class="page page-<?= $page->template()?>">

  <header class="header">

    <div class="menu-toggle">
      <span class="current-page">
        <?php if ( $page->isHomePage() ): ?>
          A&mdash;GAIN GUIDE
        <?php else: ?>
          <?php if( $page->parents()->count() > 0 ) { ?>
            <?= html($page->parent()->title()); ?>
            <?php echo "/"; ?>
          <?php } ?>
          <?= $page->title() ?>
        <?php endif ?>
      </span>
      <span class="close">Close</span>
    </div>

    <div class="menu-container">
      <nav class="menu">
        <ul>
          <?php foreach ($site->children()->listed() as $item): ?>
            <li><a <?php e($item->isOpen(), 'aria-current ') ?> href="<?= $item->url() ?>" class="link-<?= $item->slug() ?>""><?= $item->title()->html() ?></a></li>
          <?php endforeach ?>
        </ul>
      </nav>

      <?php snippet('social') ?>

      <div class="lang-switch">
        <?php foreach($kirby->languages() as $language): ?>
          <a href="<?= $page->url($language->code()) ?>" hreflang="<?php echo $language->code() ?>" class="link-lang <?php e($kirby->language() == $language, ' active') ?>">
            <?= html($language->code()) ?>
          </a>
        <?php endforeach ?>
      </div>

    </div>

  </header>

  <main class="main">

    <div class="lang-switch-s top-right">
      <?php if ( $page->is('map') ): ?>
        <a class="btn btn-outline-primary guide-link" href="<?= $pages->find('guide')->url() ?>">
          <?php echo t('use-the-guide') ?>
        </a>
      <?php endif ?>

      <?php foreach($kirby->languages() as $language): ?>
      <?php if ($kirby->language() !== $language) : ?>
        <a class="btn btn-outline-primary" href="<?= $page->url($language->code()) ?>" hreflang="<?php echo $language->code() ?>">
          <?= html($language->code()) ?>
        </a>
        <?php endif ?>
      <?php endforeach ?>
    </div>
