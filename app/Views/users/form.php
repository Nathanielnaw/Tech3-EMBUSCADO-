<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="card">
    <h1><?= esc($heading) ?></h1>
    <p>Fields marked with * are required.</p>
    <?php if ($errors !== []): ?>
        <div class="alert" role="alert">
            <p>Please correct the following:</p>
            <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>
    <form action="<?= esc($action, 'attr') ?>" method="post"<?= $user !== null ? ' enctype="multipart/form-data"' : '' ?>>
        <?= csrf_field() ?>
        <div class="field">
            <label for="username">Username *</label>
            <input id="username" name="username" type="text" maxlength="50" required value="<?= esc($values['username'], 'attr') ?>">
        </div>
        <div class="field">
            <label for="full_name">Full name *</label>
            <input id="full_name" name="full_name" type="text" maxlength="100" required value="<?= esc($values['full_name'], 'attr') ?>">
        </div>
        <?php if ($user !== null): ?>
            <div class="field">
                <label for="avatar">Avatar (optional)</label>
                <img class="avatar" src="<?= esc(avatar_url($user['avatar'] ?? null), 'attr') ?>" alt="Current avatar">
                <p class="hint">JPG or PNG, up to 2 MB. A new image replaces the current avatar; leave blank to keep it.</p>
                <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                <?php if ($errors !== []): ?><p class="hint">If you selected an image, select it again before saving.</p><?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="actions">
            <button class="button" type="submit">Save user</button>
            <a class="button secondary" href="<?= esc(url_to('users'), 'attr') ?>">Cancel</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
