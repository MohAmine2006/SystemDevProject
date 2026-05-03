<?php
use App\Config\Helpers;
use App\Config\Lang;
include __DIR__ . '/../layouts/header.php';
$nextLang = Lang::current() === 'en' ? 'fr' : 'en';
?>
<a href="<?= Helpers::url('/lang/' . $nextLang) ?>" class="lang-toggle-fixed">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
    <?= t('lang_switch') ?>
</a>
<main class="login-page">
    <div class="login-card">
        <div class="login-logo">🥬</div>
        <h1><?= t('app_name') ?></h1>
        <p class="login-subtitle"><?= t('login_subtitle') ?></p>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?= htmlspecialchars(t($error)) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= Helpers::url('/login') ?>">
            <div class="form-group">
                <label><?= t('username') ?></label>
                <div class="input-icon-wrap">
                    <span class="field-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <input name="username" placeholder="<?= t('username_placeholder') ?>" required autocomplete="username">
                </div>
            </div>
            <div class="form-group">
                <label><?= t('password') ?></label>
                <div class="input-icon-wrap">
                    <span class="field-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input name="password" type="password" placeholder="<?= t('password_placeholder') ?>" required autocomplete="current-password">
                </div>
            </div>

            <p class="login-as-heading"><?= t('login_as') ?></p>
            <div class="role-options">
                <label class="role-option">
                    <input type="radio" name="role_hint" value="employee" checked>
                    <div class="role-option-info">
                        <strong><?= t('role_employee') ?></strong>
                        <span><?= t('role_employee_desc') ?></span>
                    </div>
                </label>
                <label class="role-option">
                    <input type="radio" name="role_hint" value="owner">
                    <div class="role-option-info">
                        <strong><?= t('role_owner') ?></strong>
                        <span><?= t('role_owner_desc') ?></span>
                    </div>
                </label>
            </div>

            <button class="sign-in-btn" type="submit"><?= t('sign_in') ?></button>
        </form>
    </div>
</main>
<?php include __DIR__ . '/../layouts/user-manual-modal.php'; ?>
<button class="help-fab" data-open="userManualModal" type="button" title="Help">?</button>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
