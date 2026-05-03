<?php
use App\Config\Helpers;
use App\Config\Lang;
$user    = $_SESSION['user'];
$isOwner = $user['role'] === 'owner';
$page    = $activePage ?? 'inventory';
$nextLang = Lang::current() === 'en' ? 'fr' : 'en';
?>
<header class="app-header">
    <div class="header-left">
        <div class="header-logo">🥬</div>
        <div class="header-title-block">
            <h2><?= t('inventory_system') ?></h2>
            <div class="welcome-line">
                <?= t('welcome') ?> <?= htmlspecialchars($user['username'] ?? $user['full_name']) ?>
                <span class="role-badge"><?= t('role_' . $user['role']) ?></span>
            </div>
        </div>
    </div>
    <div class="header-right">
        <a href="<?= Helpers::url('/lang/' . $nextLang) ?>" class="lang-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            <?= t('lang_switch') ?>
        </a>
        <form class="logout-form" method="post" action="<?= Helpers::url('/logout') ?>">
            <button class="logout-btn" type="submit">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <?= t('logout') ?>
            </button>
        </form>
    </div>
</header>
<nav class="nav-tabs-bar">
    <a href="<?= Helpers::url('/inventory') ?>" class="nav-tab <?= $page === 'inventory' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        <?= t('nav_inventory') ?>
    </a>
    <?php if ($isOwner): ?>
    <a href="<?= Helpers::url('/reports') ?>" class="nav-tab <?= $page === 'reports' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        <?= t('nav_reports') ?>
    </a>
    <?php endif; ?>
</nav>
