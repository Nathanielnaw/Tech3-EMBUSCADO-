<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="card">
    <h1>User Accounts</h1>
    <p>Staff records for the POS application.</p>
    <a class="button" href="<?= esc(url_to('users.new'), 'attr') ?>">Add user</a>
    <table>
        <thead>
            <tr><th>Avatar</th><th>Username</th><th>Full name</th><th>Created at</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><img class="avatar" src="<?= esc(avatar_url($user['avatar'] ?? null), 'attr') ?>" alt=""></td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['created_at']) ?></td>
                <td><a href="<?= esc(url_to('users.edit', (int) $user['id']), 'attr') ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($users === []): ?>
            <tr><td colspan="5">No users yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</section>
<?= $this->endSection() ?>
