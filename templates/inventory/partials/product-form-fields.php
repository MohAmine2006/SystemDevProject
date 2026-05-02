<?php use App\Config\Helpers; ?>
<label>English Name</label><input name="name_en" value="<?= htmlspecialchars($p['name_en'] ?? '') ?>" required>
<label>French Name</label><input name="name_fr" value="<?= htmlspecialchars($p['name_fr'] ?? '') ?>" required>
<label>Category</label><input name="category" value="<?= htmlspecialchars($p['category'] ?? '') ?>" required>
<label>Description</label><textarea name="description" rows="3"><?= htmlspecialchars($p['description'] ?? '') ?></textarea>
<label>Image Path</label><input name="image_url" value="<?= htmlspecialchars($p['image_url'] ?? 'assets/images/products/placeholder.svg') ?>">
<div class="two-col"><div><label>Quantity</label><input type="number" name="quantity" value="<?= htmlspecialchars($p['quantity'] ?? 0) ?>" min="0" required></div><div><label>Price</label><input type="number" step="0.01" name="price" value="<?= htmlspecialchars($p['price'] ?? 0) ?>" min="0.01" required></div></div>
<div class="two-col"><div><label>Reorder Level</label><input type="number" name="low_stock_threshold" value="<?= htmlspecialchars($p['low_stock_threshold'] ?? 10) ?>" min="0"></div><div><label>Max Stock</label><input type="number" name="max_stock_threshold" value="<?= htmlspecialchars($p['max_stock_threshold'] ?? 100) ?>" min="1"></div></div>
