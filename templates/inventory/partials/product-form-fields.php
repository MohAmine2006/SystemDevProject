<?php
$categories = ['Snacks', 'Vegetables', 'Fruits', 'Dairy', 'Meat'];
$currentCat = $p['category'] ?? '';
?>
<div class="two-col">
    <div>
        <label>English Name</label>
        <input name="name_en" value="<?= htmlspecialchars($p['name_en'] ?? '') ?>" required placeholder="e.g. Organic Apples">
    </div>
    <div>
        <label>French Name</label>
        <input name="name_fr" value="<?= htmlspecialchars($p['name_fr'] ?? '') ?>" required placeholder="e.g. Pommes bio">
    </div>
</div>
<div>
    <label>Category</label>
    <select name="category" required>
        <option value="" disabled <?= $currentCat === '' ? 'selected' : '' ?>>Select a category</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat ?>" <?= $currentCat === $cat ? 'selected' : '' ?>><?= $cat ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div>
    <label>Description</label>
    <textarea name="description" rows="2" placeholder="Short product description..."><?= htmlspecialchars($p['description'] ?? '') ?></textarea>
</div>
<div class="two-col">
    <div>
        <label>Quantity</label>
        <input type="number" name="quantity" value="<?= (int)($p['quantity'] ?? 0) ?>" min="0" required>
    </div>
    <div>
        <label>Price ($)</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($p['price'] ?? '') ?>" min="0.01" required placeholder="0.00">
    </div>
</div>
<div class="two-col">
    <div>
        <label>Reorder Level</label>
        <input type="number" name="low_stock_threshold" value="<?= (int)($p['low_stock_threshold'] ?? 10) ?>" min="0">
    </div>
    <div>
        <label>Max Stock</label>
        <input type="number" name="max_stock_threshold" value="<?= (int)($p['max_stock_threshold'] ?? 100) ?>" min="1">
    </div>
</div>
