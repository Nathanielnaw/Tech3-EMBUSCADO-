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
    <form action="<?= esc($action, 'attr') ?>" method="post">
        <?= csrf_field() ?>
        <div class="field">
            <label for="full_name">Full name *</label>
            <input id="full_name" name="full_name" type="text" maxlength="100" required value="<?= esc($values['full_name'], 'attr') ?>">
        </div>
        <div class="field">
            <label for="email">Email *</label>
            <input id="email" name="email" type="email" maxlength="100" required value="<?= esc($values['email'], 'attr') ?>">
        </div>
        <div class="field">
            <label for="phone">Phone</label>
            <input id="phone" name="phone" type="tel" maxlength="20" value="<?= esc($values['phone'] ?? '', 'attr') ?>">
        </div>
        <div class="actions">
            <button class="button" type="submit">Save customer</button>
            <a class="button secondary" href="<?= esc(url_to('customers'), 'attr') ?>">Cancel</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
