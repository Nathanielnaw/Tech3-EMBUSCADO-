<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="card">
    <h1>Customer Accounts</h1>
    <p>Customer records for the POS application.</p>
    <a class="button" href="<?= esc(url_to('customers.new'), 'attr') ?>">Add customer</a>
    <table>
        <thead>
            <tr><th>Full name</th><th>Email</th><th>Phone</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone'] ?? '') ?></td>
                <td><a href="<?= esc(url_to('customers.edit', (int) $customer['id']), 'attr') ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($customers === []): ?>
            <tr><td colspan="4">No customers yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</section>
<?= $this->endSection() ?>
