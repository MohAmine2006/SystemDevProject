<?php
namespace App\Repositories;

use App\Config\Database;

class ReportRepository
{
    /** All sales for a date, joined with product and user info. */
    public function getSalesForDate(string $date): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT s.id, s.quantity_sold, s.price_at_sale, s.sold_at,
                    p.id AS product_id, p.name_en, p.name_fr, p.category, p.quantity AS qty_remaining,
                    u.username AS sold_by_name
             FROM sales s
             JOIN products p ON s.product_id = p.id
             JOIN users   u ON s.sold_by    = u.id
             WHERE DATE(s.sold_at) = :date
             ORDER BY p.category, p.name_en"
        );
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll();
    }

    /** Revenue + unit totals for a given date. */
    public function getSalesSummary(string $date): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT
                COALESCE(SUM(quantity_sold * price_at_sale), 0) AS total_revenue,
                COALESCE(SUM(quantity_sold), 0)                 AS total_units
             FROM sales
             WHERE DATE(sold_at) = :date"
        );
        $stmt->execute(['date' => $date]);
        return $stmt->fetch() ?: ['total_revenue' => 0.0, 'total_units' => 0];
    }

    /**
     * Persist a report record and link all un-linked sales for that date.
     * Returns the new report ID.
     */
    public function saveReport(string $date, int $userId, string $filename): int
    {
        $totals = $this->getSalesSummary($date);

        $stmt = Database::getConnection()->prepare(
            "INSERT INTO reports
                (report_date, total_sales, total_products_sold, pdf_filename, generated_by)
             VALUES (:date, :sales, :units, :file, :user)"
        );
        $stmt->execute([
            'date'  => $date,
            'sales' => (float)$totals['total_revenue'],
            'units' => (int)$totals['total_units'],
            'file'  => $filename,
            'user'  => $userId,
        ]);

        $reportId = (int)Database::getConnection()->lastInsertId();

        // Attach today's un-linked sales to this report
        $link = Database::getConnection()->prepare(
            "UPDATE sales SET report_id = :rid
             WHERE DATE(sold_at) = :date AND report_id IS NULL"
        );
        $link->execute(['rid' => $reportId, 'date' => $date]);

        return $reportId;
    }
}
