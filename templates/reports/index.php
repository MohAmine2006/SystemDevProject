<?php include __DIR__ . '/../layouts/header.php'; use App\Config\Helpers; ?>
<div class="app-shell">
    <aside class="sidebar">
        <div class="side-logo"><span>🥬</span><div><b>La Fruiterie</b><small>Global</small></div></div>
        <a class="nav-link" href="<?= Helpers::url('/inventory') ?>">Inventory Items</a>
        <a class="nav-link active" href="<?= Helpers::url('/reports') ?>">Report</a>
        <form method="post" action="<?= Helpers::url('/logout') ?>"><button class="logout-btn">Logout</button></form>
    </aside>
    <main class="dashboard">
        <header class="topbar">
            <div><h1>Inventory Report</h1><p>Select a date and generate a downloadable PDF report.</p></div>
        </header>
        <section class="report-panel">
            <form method="get" action="<?= Helpers::url('/reports') ?>" class="report-date-form">
                <label>Report Date</label>
                <input type="date" name="date" value="<?= htmlspecialchars($summary['date']) ?>">
                <button class="secondary-btn">Preview</button>
            </form>
            <div class="report-cards">
                <div><small>Total Items</small><b><?= (int)$summary['total_items'] ?></b></div>
                <div><small>Products</small><b><?= (int)$summary['total_products'] ?></b></div>
                <div><small>Total Value</small><b><?= Helpers::money($summary['total_inventory_value']) ?></b></div>
            </div>
            <form method="post" action="<?= Helpers::url('/reports/pdf') ?>">
                <input type="hidden" name="report_date" value="<?= htmlspecialchars($summary['date']) ?>">
                <button class="primary-btn">Generate PDF</button>
            </form>
        </section>
        <section class="table-card">
            <table>
                <thead><tr><th>Product</th><th>Category</th><th>Quantity</th><th>Price</th><th>Total Value</th></tr></thead>
                <tbody>
                <?php foreach ($summary['products'] as $p): ?>
                    <tr><td><?= htmlspecialchars($p['name_en']) ?></td><td><?= htmlspecialchars($p['category']) ?></td><td><?= (int)$p['quantity'] ?></td><td><?= Helpers::money($p['price']) ?></td><td><?= Helpers::money((float)$p['price']*(int)$p['quantity']) ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
