<?php
$dbCategories = ['Snacks', 'Vegetables', 'Fruits', 'Dairy', 'Meat'];
$currentCat   = $p['category'] ?? '';
?>
<div class="two-col">
    <div>
        <label><?= t('field_name_en') ?></label>
        <input name="name_en" value="<?= htmlspecialchars($p['name_en'] ?? '') ?>" required placeholder="<?= t('ph_name_en') ?>">
    </div>
    <div>
        <label><?= t('field_name_fr') ?></label>
        <input name="name_fr" value="<?= htmlspecialchars($p['name_fr'] ?? '') ?>" placeholder="<?= t('ph_name_fr') ?>">
    </div>
</div>
<div>
    <label><?= t('field_category') ?></label>
    <select name="category" required>
        <option value="" disabled <?= $currentCat === '' ? 'selected' : '' ?>><?= t('select_category') ?></option>
        <?php foreach ($dbCategories as $cat): ?>
            <option value="<?= $cat ?>" <?= $currentCat === $cat ? 'selected' : '' ?>>
                <?= \App\Config\Lang::cat($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div>
    <label><?= t('field_description') ?></label>
    <textarea name="description" rows="2" placeholder="<?= t('ph_description') ?>"><?= htmlspecialchars($p['description'] ?? '') ?></textarea>
</div>
<div class="two-col">
    <div>
        <label><?= t('field_quantity') ?></label>
        <input type="number" name="quantity" value="<?= (int)($p['quantity'] ?? 0) ?>" min="0" required>
    </div>
    <div>
        <label><?= t('field_price') ?></label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($p['price'] ?? '') ?>" min="0.01" required placeholder="0.00">
    </div>
</div>
<div class="two-col">
    <div>
        <label><?= t('field_reorder') ?></label>
        <input type="number" name="low_stock_threshold" value="<?= (int)($p['low_stock_threshold'] ?? 10) ?>" min="0">
    </div>
    <div>
        <label><?= t('field_max_stock') ?></label>
        <input type="number" name="max_stock_threshold" value="<?= (int)($p['max_stock_threshold'] ?? 100) ?>" min="1">
    </div>
</div>
