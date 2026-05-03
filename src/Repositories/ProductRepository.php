<?php
namespace App\Repositories;

use App\Config\Database;

class ProductRepository
{
    public function all(?string $category = null, ?string $search = null): array
    {
        $sql = 'SELECT * FROM products WHERE is_active = 1';
        $params = [];
        if ($category && $category !== 'All') {
            $sql .= ' AND category = :category';
            $params['category'] = $category;
        }
        if ($search) {
            $sql .= ' AND (name_en LIKE :search OR name_fr LIKE :search OR category LIKE :search)';
            $params['search'] = '%' . $search . '%';
        }
        $sql .= ' ORDER BY category, name_en';
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function categories(): array
    {
        return Database::getConnection()->query('SELECT DISTINCT category FROM products WHERE is_active = 1 ORDER BY category')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO products (name_en, name_fr, category, description, quantity, price, low_stock_threshold, max_stock_threshold) VALUES (:name_en, :name_fr, :category, :description, :quantity, :price, :low_stock_threshold, :max_stock_threshold)');
        $stmt->execute($this->clean($data));
    }

    public function update(int $id, array $data, int $userId = 0): void
    {
        $old   = $this->find($id);
        $clean = $this->clean($data);
        $clean['id'] = $id;

        $stmt = Database::getConnection()->prepare('UPDATE products SET name_en=:name_en, name_fr=:name_fr, category=:category, description=:description, quantity=:quantity, price=:price, low_stock_threshold=:low_stock_threshold, max_stock_threshold=:max_stock_threshold WHERE id=:id');
        $stmt->execute($clean);

        // Auto-record a sale when quantity is reduced
        if ($old && $userId > 0 && (int)$clean['quantity'] < (int)$old['quantity']) {
            $qtySold = (int)$old['quantity'] - (int)$clean['quantity'];
            $sale = Database::getConnection()->prepare(
                'INSERT INTO sales (product_id, sold_by, quantity_sold, price_at_sale) VALUES (:pid, :uid, :qty, :price)'
            );
            $sale->execute([
                'pid'   => $id,
                'uid'   => $userId,
                'qty'   => $qtySold,
                'price' => (float)$old['price'],
            ]);
        }
    }

    public function softDelete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE products SET is_active = 0 WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function reportSummary(?string $date = null): array
    {
        $products = $this->all();
        $totalItems = 0;
        $totalValue = 0;
        foreach ($products as $p) {
            $totalItems += (int)$p['quantity'];
            $totalValue += (int)$p['quantity'] * (float)$p['price'];
        }
        return [
            'date' => $date ?: date('Y-m-d'),
            'total_items' => $totalItems,
            'total_products' => count($products),
            'total_inventory_value' => $totalValue,
            'products' => $products,
        ];
    }

    private function clean(array $data): array
    {
        $nameEn = trim($data['name_en'] ?? '');
        return [
            'name_en'             => $nameEn,
            'name_fr'             => trim($data['name_fr'] ?? '') ?: $nameEn,
            'category'            => trim($data['category'] ?? 'Snacks'),
            'description'         => trim($data['description'] ?? ''),
            'quantity'            => max(0, (int)($data['quantity'] ?? 0)),
            'price'               => max(0.01, (float)($data['price'] ?? 0)),
            'low_stock_threshold' => max(0, (int)($data['low_stock_threshold'] ?? 10)),
            'max_stock_threshold' => max(1, (int)($data['max_stock_threshold'] ?? 100)),
        ];
    }
}
