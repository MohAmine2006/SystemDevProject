<?php
include __DIR__ . '/../layouts/header.php';
use App\Config\Helpers;
$user = $_SESSION['user'];
$isOwner = $user['role'] === 'owner';
?>
<div class="app-shell">
    <aside class="sidebar">
        <div class="side-logo"><span>🥬</span><div><b>La Fruiterie</b><small>Global</small></div></div>
        <a class="nav-link active" href="<?= Helpers::url('/inventory') ?>">Inventory Items</a>
        <?php if ($isOwner): ?><a class="nav-link" href="<?= Helpers::url('/reports') ?>">Report</a><?php endif; ?>
        <form method="post" action="<?= Helpers::url('/logout') ?>"><button class="logout-btn">Logout</button></form>
    </aside>

    <main class="dashboard">
        <header class="topbar">
            <div>
                <h1>Inventory Items</h1>
                <p>Welcome back, <?= htmlspecialchars($user['full_name']) ?> · <?= $isOwner ? 'Admin' : 'Employee' ?></p>
            </div>
            <?php if ($isOwner): ?><button class="add-btn" data-open="addModal">+ Add Product</button><?php endif; ?>
        </header>

        <section class="toolbar">
            <form method="get" class="search-form">
                <input name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search products...">
                <select name="category" onchange="this.form.submit()">
                    <option <?= $selectedCategory === 'All' ? 'selected' : '' ?>>All</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['category']) ?>" <?= $selectedCategory === $cat['category'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['category']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button>Filter</button>
            </form>
        </section>

        <section class="product-grid">
            <?php foreach ($products as $p): $status = Helpers::stockStatus($p); ?>
                <article class="product-card" data-open="details-<?= $p['id'] ?>">
                    <img src="<?= Helpers::url('/' . htmlspecialchars($p['image_url'])) ?>" alt="<?= htmlspecialchars($p['name_en']) ?>">
                    <div class="card-body">
                        <div class="card-title-row"><h3><?= htmlspecialchars($p['name_en']) ?></h3><span class="status <?= strtolower(str_replace(' ', '-', $status)) ?>"><?= $status ?></span></div>
                        <p><?= htmlspecialchars($p['name_fr']) ?></p>
                        <p class="category-pill"><?= htmlspecialchars($p['category']) ?></p>
                        <div class="product-meta"><span>Qty: <b><?= (int)$p['quantity'] ?></b></span><span><?= Helpers::money($p['price']) ?></span></div>
                    </div>
                </article>

                <div class="modal" id="details-<?= $p['id'] ?>">
                    <div class="modal-content details-modal">
                        <button class="close" data-close>&times;</button>
                        <img class="details-img" src="<?= Helpers::url('/' . htmlspecialchars($p['image_url'])) ?>" alt="">
                        <div class="details-info">
                            <h2><?= htmlspecialchars($p['name_en']) ?></h2>
                            <p class="muted"><?= htmlspecialchars($p['name_fr']) ?></p>
                            <span class="category-pill"><?= htmlspecialchars($p['category']) ?></span>
                            <p><?= htmlspecialchars($p['description']) ?></p>
                            <div class="info-grid">
                                <div><small>Status</small><b><?= $status ?></b></div>
                                <div><small>Quantity</small><b><?= (int)$p['quantity'] ?></b></div>
                                <div><small>Price</small><b><?= Helpers::money($p['price']) ?></b></div>
                                <?php if ($isOwner): ?>
                                    <div><small>Reorder Level</small><b><?= (int)$p['low_stock_threshold'] ?></b></div>
                                    <div><small>Total Value</small><b><?= Helpers::money((float)$p['price'] * (int)$p['quantity']) ?></b></div>
                                <?php endif; ?>
                            </div>
                            <div class="modal-actions">
                                <button class="edit-btn" data-open="edit-<?= $p['id'] ?>">Edit</button>
                                <?php if ($isOwner): ?><button class="danger-btn" data-open="delete-<?= $p['id'] ?>">Delete</button><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include __DIR__ . '/partials/edit-modal.php'; ?>
                <?php if ($isOwner) include __DIR__ . '/partials/delete-modal.php'; ?>
            <?php endforeach; ?>
        </section>
    </main>
</div>
<?php if ($isOwner) include __DIR__ . '/partials/add-modal.php'; ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
