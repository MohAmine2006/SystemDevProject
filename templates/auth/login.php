<?php use App\Config\Helpers; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>
<main class="login-page">
    <section class="login-card">
        <div class="brand-circle">🥬</div>
        <h1>La Fruiterie Global</h1>
        <p class="muted">Inventory Management System</p>
        <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post" action="<?= Helpers::url('/login') ?>" class="form-stack">
            <label>Username</label>
            <input name="username" placeholder="Enter username" required>
            <label>Password</label>
            <input name="password" type="password" placeholder="Enter password" required>
            <button class="primary-btn" type="submit">Login</button>
        </form>
        <p class="demo-logins">Admin: <b>admin</b> / admin123<br>Employee: <b>employee</b> / employee123</p>
    </section>
</main>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
