<?php
include __DIR__ . '/../layouts/header.php';
use App\Config\Helpers;
use App\Config\Lang;
$activePage = 'reports';
include __DIR__ . '/../layouts/app-nav.php';
?>
<div class="page-content">

    <div class="report-card">
        <div class="report-card-heading">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <h2><?= t('report_title') ?></h2>
        </div>
        <p class="report-card-sub"><?= t('report_subtitle') ?></p>

        <form method="get" action="<?= Helpers::url('/reports') ?>">
            <div class="date-field-label"><?= t('select_date') ?></div>
            <div class="date-input-row">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <input type="date" name="date" value="<?= htmlspecialchars($summary['date']) ?>" onchange="this.form.submit()">
            </div>
        </form>

        <div class="preview-box">
            <p class="preview-box-title"><?= t('preview_title') ?></p>
            <div class="preview-grid">
                <div class="preview-item">
                    <small><?= t('preview_date') ?></small>
                    <strong><?= date('M d, Y', strtotime($summary['date'])) ?></strong>
                </div>
                <div class="preview-item">
                    <small><?= t('preview_products') ?></small>
                    <strong><?= (int)$summary['total_products'] ?></strong>
                </div>
                <div class="preview-item">
                    <small><?= t('preview_total_items') ?></small>
                    <strong><?= number_format((int)$summary['total_items']) ?></strong>
                </div>
                <div class="preview-item">
                    <small><?= t('preview_total_value') ?></small>
                    <strong class="green"><?= Helpers::money($summary['total_inventory_value']) ?></strong>
                </div>
            </div>
        </div>

        <form method="post" action="<?= Helpers::url('/reports/pdf') ?>">
            <input type="hidden" name="report_date" value="<?= htmlspecialchars($summary['date']) ?>">
            <button class="generate-btn" type="submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <?= t('btn_generate_pdf') ?>
            </button>
        </form>
    </div>

    <!-- Daily Sales Section -->
    <div class="sales-card">
        <div class="sales-card-heading">
            <div>
                <h3><?= t('sales_section') ?></h3>
                <p class="sales-date-label"><?= date('M d, Y', strtotime($summary['date'])) ?></p>
            </div>
            <div class="sales-totals">
                <div class="sales-total-item">
                    <small><?= t('daily_revenue') ?></small>
                    <strong class="green"><?= Helpers::money($salesTotals['total_revenue']) ?></strong>
                </div>
                <div class="sales-total-item">
                    <small><?= t('daily_units') ?></small>
                    <strong><?= (int)$salesTotals['total_units'] ?></strong>
                </div>
            </div>
        </div>

        <?php if (empty($sales)): ?>
            <p class="no-sales"><?= t('no_sales') ?></p>
        <?php else: ?>
            <div class="sales-table-wrap">
                <table class="inv-table">
                    <thead>
                        <tr>
                            <th><?= t('col_product') ?></th>
                            <th><?= t('col_category') ?></th>
                            <th><?= t('col_qty_sold') ?></th>
                            <th><?= t('col_sale_price') ?></th>
                            <th><?= t('col_line_total') ?></th>
                            <th><?= t('col_qty_remaining') ?></th>
                            <th><?= t('col_staff') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $s):
                            $lineTotal   = (float)$s['quantity_sold'] * (float)$s['price_at_sale'];
                            $productName = Lang::current() === 'fr' ? $s['name_fr'] : $s['name_en'];
                        ?>
                        <tr>
                            <td class="td-name"><?= htmlspecialchars($productName) ?></td>
                            <td><?= Lang::cat($s['category']) ?></td>
                            <td><?= (int)$s['quantity_sold'] ?></td>
                            <td><?= Helpers::money($s['price_at_sale']) ?></td>
                            <td class="td-profit"><?= Helpers::money($lineTotal) ?></td>
                            <td><?= (int)$s['qty_remaining'] ?></td>
                            <td><?= htmlspecialchars($s['sold_by_name']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="howto-card">
        <h3><?= t('howto_title') ?></h3>
        <ol>
            <li><?= t('howto_1') ?></li>
            <li><?= t('howto_2') ?></li>
            <li><?= t('howto_3') ?></li>
            <li><?= t('howto_4') ?></li>
        </ol>
    </div>

</div>

<?php include __DIR__ . '/../layouts/user-manual-modal.php'; ?>
<button class="help-fab" data-open="userManualModal" type="button" title="Help">?</button>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
