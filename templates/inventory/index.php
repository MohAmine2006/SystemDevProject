<?php
include __DIR__ . '/../layouts/header.php';
use App\Config\Helpers;
use App\Config\Lang;
$user    = $_SESSION['user'];
$isOwner = $user['role'] === 'owner';
$activePage = 'inventory';
include __DIR__ . '/../layouts/app-nav.php';
?>
<div class="page-content">

    <?php if (!empty($flash)): ?>
        <div class="flash flash-<?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <!-- Stats Row 1 -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label"><?= t('stat_total_items') ?></span>
                <span class="stat-card-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </span>
            </div>
            <div class="stat-card-value"><?= number_format((int)$stats['total_items']) ?></div>
            <div class="stat-card-sub"><?= t('stat_in_stock') ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label"><?= t('stat_products') ?></span>
                <span class="stat-card-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </span>
            </div>
            <div class="stat-card-value"><?= (int)$stats['total_products'] ?></div>
            <div class="stat-card-sub"><?= t('stat_product_types') ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label"><?= t('stat_low_stock') ?></span>
                <span class="stat-card-icon" style="color:#df7a20;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </span>
            </div>
            <div class="stat-card-value orange"><?= (int)$stats['low_stock'] ?></div>
            <div class="stat-card-sub"><?= t('stat_need_reorder') ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label"><?= t('stat_overstock') ?></span>
                <span class="stat-card-icon" style="color:#3b6fe0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </span>
            </div>
            <div class="stat-card-value blue"><?= (int)$stats['overstock'] ?></div>
            <div class="stat-card-sub"><?= t('stat_excess') ?></div>
        </div>
    </div>

    <!-- Owner-only: Inventory Value -->
    <?php if ($isOwner): ?>
    <div class="stats-row-2">
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-card-label"><?= t('stat_inv_value') ?></span>
                <span class="stat-card-icon" style="color:#2d8b45;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </span>
            </div>
            <div class="stat-card-value green"><?= Helpers::money($stats['total_value']) ?></div>
            <div class="stat-card-sub"><?= t('stat_total_value') ?></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Inventory Table -->
    <div class="table-section">
        <div class="table-header">
            <div class="table-header-text">
                <h2><?= t('inv_title') ?></h2>
                <p><?= t('inv_subtitle') ?></p>
            </div>
            <?php if ($isOwner): ?>
                <button class="add-item-btn" data-open="addModal" type="button">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <?= t('btn_add_item') ?>
                </button>
            <?php endif; ?>
        </div>

        <form method="get" action="<?= Helpers::url('/inventory') ?>">
            <div class="table-toolbar">
                <div class="search-wrap">
                    <span class="srch-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input id="searchInput" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="<?= t('search_ph') ?>" autocomplete="off">
                    <div class="search-suggestions" id="searchSuggestions"></div>
                </div>
                <div class="cat-select-wrap">
                    <select name="category" onchange="this.form.submit()">
                        <option value="All" <?= $selectedCategory === 'All' ? 'selected' : '' ?>><?= t('all_categories') ?></option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['category']) ?>" <?= $selectedCategory === $cat['category'] ? 'selected' : '' ?>>
                                <?= Lang::cat($cat['category']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <table class="inv-table">
            <thead>
                <tr>
                    <th><?= t('col_product') ?></th>
                    <th><?= t('col_category') ?></th>
                    <th><?= t('col_qty') ?></th>
                    <th><?= t('col_price') ?></th>
                    <?php if ($isOwner): ?><th><?= t('col_value') ?></th><?php endif; ?>
                    <th><?= t('col_profit') ?></th>
                    <th><?= t('col_status') ?></th>
                    <th><?= t('col_actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p):
                    $status      = Helpers::stockStatus($p);
                    $statusClass = strtolower(str_replace(' ', '-', $status));
                    $statusKey   = 'status_' . str_replace('-', '_', $statusClass);
                    $dailyProfit = number_format((float)$p['price'] * 0.15, 2);
                    $itemValue   = number_format((float)$p['price'] * (int)$p['quantity'], 2);
                    $productName = Lang::current() === 'fr' ? $p['name_fr'] : $p['name_en'];
                ?>
                <tr>
                    <td class="td-name"><?= htmlspecialchars($productName) ?></td>
                    <td><?= Lang::cat($p['category']) ?></td>
                    <td><?= (int)$p['quantity'] ?></td>
                    <td><?= Helpers::money($p['price']) ?></td>
                    <?php if ($isOwner): ?>
                        <td class="td-value">$<?= $itemValue ?></td>
                    <?php endif; ?>
                    <td class="td-profit">$<?= $dailyProfit ?></td>
                    <td><span class="badge badge-<?= $statusClass ?>"><?= t($statusKey) ?></span></td>
                    <td>
                        <button class="act-btn" data-open="edit-<?= $p['id'] ?>" type="button" title="<?= t('modal_edit_title') ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        <?php if ($isOwner): ?>
                            <button class="act-btn del" data-open="delete-<?= $p['id'] ?>" type="button" title="<?= t('modal_delete_title') ?>">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modals -->
<?php foreach ($products as $p): ?>
    <?php include __DIR__ . '/partials/edit-modal.php'; ?>
    <?php if ($isOwner) include __DIR__ . '/partials/delete-modal.php'; ?>
<?php endforeach; ?>
<?php if ($isOwner) include __DIR__ . '/partials/add-modal.php'; ?>

<?php include __DIR__ . '/../layouts/user-manual-modal.php'; ?>
<button class="help-fab" data-open="userManualModal" type="button" title="Help">?</button>
<script>
(function () {
    var names = <?= json_encode(array_values(array_unique(array_map(
        fn($p) => \App\Config\Lang::current() === 'fr' ? $p['name_fr'] : $p['name_en'],
        $allProducts
    )))) ?>;

    var input  = document.getElementById('searchInput');
    var box    = document.getElementById('searchSuggestions');
    var form   = input ? input.closest('form') : null;
    if (!input || !box) return;

    input.addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        box.innerHTML = '';
        if (!q) { box.classList.remove('show'); return; }
        var matches = names.filter(function (n) { return n.toLowerCase().indexOf(q) !== -1; }).slice(0, 8);
        if (!matches.length) { box.classList.remove('show'); return; }
        matches.forEach(function (name) {
            var item = document.createElement('div');
            item.className = 'suggest-item';
            item.textContent = name;
            item.addEventListener('mousedown', function (e) {
                e.preventDefault();
                input.value = name;
                box.classList.remove('show');
                form.submit();
            });
            box.appendChild(item);
        });
        box.classList.add('show');
    });

    input.addEventListener('blur', function () {
        setTimeout(function () { box.classList.remove('show'); }, 150);
    });

    input.addEventListener('focus', function () {
        if (this.value.trim() && box.children.length) box.classList.add('show');
    });
})();
</script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
