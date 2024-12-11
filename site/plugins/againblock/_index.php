<?php

Kirby::plugin('again/againblock', [
  'blueprints' => [
    'blocks/againblock' => __DIR__ . '/blueprints/blocks/againblock.yml',
    'files/poster' => __DIR__ . '/blueprints/files/poster.yml',
  ],
  'snippets' => [
    'blocks/again-block' => __DIR__ . '/snippets/blocks/againblock.php',
  ],
]);