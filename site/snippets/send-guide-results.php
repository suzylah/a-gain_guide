<?php if($success): ?>
    <div class="alert success">
        <?= $success ?>
    </div>
<?php else: ?>
    <?php if (isset($alert['error'])): ?>
        <div><?= $alert['error'] ?></div>
    <?php endif ?>
    <form method="post" action="<?= $page->url() ?>">
        <div class="honeypot">
            <label for="website">Website <abbr title="required">*</abbr></label>
            <input type="url" id="website" name="website" tabindex="-1">
        </div>

        <div class="field">
            <input type="email" id="email" name="email" value="<?= esc($data['email'] ?? '', 'attr') ?>" placeholder="<?php echo t('your-email') ?>" required>
                <?= isset($alert['email']) ? '<span class="alert error">' . esc($alert['email']) . '</span>' : '' ?>
            </div>
        <input class="button btn-link __dark" type="submit" name="submit" value="<?php echo t('submit') ?>" style="margin:0 auto">
    </form>
    <?php endif ?>


