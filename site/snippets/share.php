
<div id="share-block">
    <a href="https://twitter.com/intent/tweet?source=webclient&text=<?= rawurlencode($site->title()); ?>%20<?= rawurlencode($page->url()); ?>%20<?= ('...')?>" target="_blank" title="Tweet this">
    <?= svg('assets/icons/twitter-round.svg') ?>
    </a>

    <a href="http://www.facebook.com/sharer.php?u=https://a-gain.guide" target="_blank" title="Share on Facebook">
    <?= svg('assets/icons/facebook.svg') ?>
    </a>

    <a href="http://www.linkedin.com/shareArticle?mini=true&url=https://a-gain.guide&title=<?= rawurlencode($page->title()); ?>&source=<?= rawurlencode($site->url()); ?>" target="_blank" title="Share on Facebook">
    <?= svg('assets/icons/linkedin.svg') ?>
    </a>

    <a href="#" title="Copy link" onclick="navigator.clipboard.writeText(location.href)">
    <?= svg('assets/icons/copy.svg') ?>
    </a>
</div>

