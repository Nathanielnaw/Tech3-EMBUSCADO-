<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'POS Foundations') ?></title>
    <style>
        :root { color-scheme: light; font-family: system-ui, -apple-system, sans-serif; }
        * { box-sizing: border-box; }
        body { background: #f4f7fb; color: #1f2937; margin: 0; }
        header { background: #17324d; color: #fff; }
        .container { margin: 0 auto; max-width: 1080px; padding: 0 1.25rem; }
        .nav { align-items: center; display: flex; justify-content: space-between; min-height: 4.5rem; gap: 1rem; }
        .brand { color: #fff; font-size: 1.2rem; font-weight: 700; text-decoration: none; }
        nav { display: flex; flex-wrap: wrap; gap: .35rem; }
        nav a { border-radius: .4rem; color: #dbeafe; padding: .55rem .7rem; text-decoration: none; }
        nav a:hover, nav a:focus { background: #2d5274; color: #fff; }
        main { padding: 3rem 0; }
        .hero, .card { background: #fff; border: 1px solid #dbe3ed; border-radius: .8rem; box-shadow: 0 5px 18px rgba(23, 50, 77, .06); padding: 2rem; }
        h1 { color: #17324d; margin-top: 0; }
        h2 { color: #244a6b; }
        .hero p { font-size: 1.1rem; line-height: 1.6; }
        .actions { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.5rem; }
        .button { background: #1d70a2; border-radius: .45rem; color: #fff; display: inline-block; padding: .7rem 1rem; text-decoration: none; }
        .button:hover, .button:focus { background: #15567d; }
        .button.secondary { background: #e4ebf2; color: #17324d; }
        .button.secondary:hover, .button.secondary:focus { background: #cfdeeb; }
        button.button { border: 0; cursor: pointer; font: inherit; }
        .field { margin: 1.2rem 0; }
        .field label { display: block; font-weight: 600; margin-bottom: .4rem; }
        .field input { border: 1px solid #aab9c9; border-radius: .4rem; font: inherit; max-width: 34rem; padding: .7rem; width: 100%; }
        .field input:focus { outline: 2px solid #1d70a2; outline-offset: 1px; }
        .hint { color: #5b6b7c; font-size: .9rem; }
        .alert { background: #fff1f1; border: 1px solid #c65757; border-radius: .4rem; color: #762929; padding: .75rem 1rem; }
        .alert p { margin: .2rem 0; }
        .alert ul { margin: .35rem 0; }
        .avatar { background: #dbe7f2; border-radius: 50%; display: block; height: 44px; object-fit: cover; width: 44px; }
        table { border-collapse: collapse; margin-top: 1.25rem; width: 100%; }
        th, td { border-bottom: 1px solid #dbe3ed; padding: .85rem .65rem; text-align: left; }
        th { background: #eef4fa; color: #244a6b; }
        footer { color: #5b6b7c; font-size: .9rem; padding: 1.5rem 0 2.5rem; }
        @media (max-width: 640px) { .nav { align-items: flex-start; flex-direction: column; padding-bottom: 1rem; padding-top: 1rem; } }
    </style>
</head>
<body>
    <header>
        <div class="container nav">
            <a class="brand" href="<?= url_to('home') ?>">POS Foundations</a>
            <nav aria-label="Main navigation">
                <a href="<?= url_to('home') ?>">Home</a>
                <a href="<?= url_to('about') ?>">About</a>
                <a href="<?= url_to('customers') ?>">Customers</a>
                <a href="<?= url_to('users') ?>">Users</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <?= $this->renderSection('content') ?>
    </main>
    <footer class="container">CodeIgniter 4 POS Foundations &mdash; sample activity application</footer>
</body>
</html>
