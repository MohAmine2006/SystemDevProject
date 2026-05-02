<?php use App\Config\Helpers; ?>
<!doctype html><html><head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#111}h1{color:#1f7a3a}.summary{display:flex;gap:16px}.box{border:1px solid #ccc;padding:10px;margin:8px 0}table{width:100%;border-collapse:collapse;margin-top:18px}th,td{border:1px solid #ccc;padding:8px;text-align:left}th{background:#edf7ef}</style></head><body>
<h1>La Fruiterie Global - Inventory Report</h1>
<p>Report date: <?= htmlspecialchars($summary['date']) ?></p>
<div class="box">Total Items: <b><?= (int)$summary['total_items'] ?></b></div>
<div class="box">Products: <b><?= (int)$summary['total_products'] ?></b></div>
<div class="box">Total Inventory Value: <b><?= Helpers::money($summary['total_inventory_value']) ?></b></div>
<table><thead><tr><th>Product</th><th>Category</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>
<?php foreach($summary['products'] as $p): ?><tr><td><?= htmlspecialchars($p['name_en']) ?></td><td><?= htmlspecialchars($p['category']) ?></td><td><?= (int)$p['quantity'] ?></td><td><?= Helpers::money($p['price']) ?></td><td><?= Helpers::money((float)$p['price']*(int)$p['quantity']) ?></td></tr><?php endforeach; ?>
</tbody></table></body></html>
