<?php if($success): ?>
    <div class="alert success">
        <h2 style="color:white;"><?= $success ?></h2>
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
                <input type="text" id="name" name="name" value="<?= esc($data['name'] ?? '', 'attr') ?>" placeholder="<?php echo t('your-name') ?>" required>
                <?= isset($alert['name']) ? '<span class="alert error">' . esc($alert['name']) . '</span>' : '' ?>
            </div>
            <div class="field">
                <input type="email" id="email" name="email" value="<?= esc($data['email'] ?? '', 'attr') ?>" placeholder="<?php echo t('your-email') ?>" required>
                <?= isset($alert['email']) ? '<span class="alert error">' . esc($alert['email']) . '</span>' : '' ?>
            </div>
            <div class="field">
                <textarea id="text" name="text" rows="10" placeholder="<?php echo t('your-message') ?>" required><?= esc($data['text'] ?? '') ?></textarea>
                <?= isset($alert['text']) ? '<span class="alert error">' . esc($alert['text']) . '</span>' : '' ?>
            </div>
            <input class="button btn-link __dark" type="submit" name="submit" value="<?php echo t('submit') ?>" style="margin:0 auto">
        </form>         
    <?php endif ?>