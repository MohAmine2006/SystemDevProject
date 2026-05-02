<?php
namespace App\Repositories;

use App\Config\Database;

class ReportRepository
{
    public function saveInventoryReport(array $summary, int $generatedBy, string $filename): void
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO reports (report_date, total_items, total_products, total_inventory_value, pdf_filename, generated_by) VALUES (:report_date, :total_items, :total_products, :total_inventory_value, :pdf_filename, :generated_by)');
        $stmt->execute([
            'report_date' => $summary['date'],
            'total_items' => $summary['total_items'],
            'total_products' => $summary['total_products'],
            'total_inventory_value' => $summary['total_inventory_value'],
            'pdf_filename' => $filename,
            'generated_by' => $generatedBy,
        ]);
    }
}
