<?php
namespace App\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\ReportRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class ReportController
{
    public function __construct(
        private PhpRenderer $view,
        private ProductRepository $products,
        private ReportRepository $reports
    ) {}

    public function index(Request $request, Response $response): Response
    {
        $date     = $request->getQueryParams()['date'] ?? date('Y-m-d');
        $summary  = $this->products->reportSummary($date);
        $sales    = $this->reports->getSalesForDate($date);
        $salesTotals = $this->reports->getSalesSummary($date);

        return $this->view->render($response, 'reports/index.php', [
            'summary'      => $summary,
            'sales'        => $sales,
            'salesTotals'  => $salesTotals,
        ]);
    }

    public function generatePdf(Request $request, Response $response): Response
    {
        $data     = (array)$request->getParsedBody();
        $date     = $data['report_date'] ?? date('Y-m-d');
        $userId   = (int)($_SESSION['user']['id'] ?? 0);

        $summary     = $this->products->reportSummary($date);
        $sales       = $this->reports->getSalesForDate($date);
        $salesTotals = $this->reports->getSalesSummary($date);

        $filename = 'inventory-report-' . $date . '-' . date('His') . '.pdf';
        $path     = dirname(__DIR__, 2) . '/downloads/' . $filename;

        $lines = [
            'La Fruiterie Global — Stock Report',
            'Date: ' . $date,
            'Generated: ' . date('Y-m-d H:i:s'),
            '',
            '--- INVENTORY SUMMARY ---',
            'Products: '       . $summary['total_products'],
            'Total Items: '    . $summary['total_items'],
            'Inventory Value: $' . number_format((float)$summary['total_inventory_value'], 2),
            '',
            '--- DAILY SALES (' . $date . ') ---',
            'Total Revenue: $' . number_format((float)$salesTotals['total_revenue'], 2),
            'Units Sold: '     . (int)$salesTotals['total_units'],
        ];

        if (!empty($sales)) {
            $lines[] = '';
            $lines[] = 'Product | Qty Sold | Sale Price | Line Total | Qty Remaining | Staff';
            foreach ($sales as $s) {
                $lineTotal = (float)$s['quantity_sold'] * (float)$s['price_at_sale'];
                $lines[] = sprintf(
                    '%s | %d | $%.2f | $%.2f | %d | %s',
                    $s['name_en'],
                    (int)$s['quantity_sold'],
                    (float)$s['price_at_sale'],
                    $lineTotal,
                    (int)$s['qty_remaining'],
                    $s['sold_by_name']
                );
            }
        } else {
            $lines[] = '(No sales recorded for this date)';
        }

        $lines[] = '';
        $lines[] = '--- PRODUCT STOCK LEVELS (End of Day) ---';
        $lines[] = 'Product | Category | Qty Remaining | Price';
        foreach ($summary['products'] as $p) {
            $lines[] = sprintf(
                '%s | %s | %d | $%.2f',
                $p['name_en'],
                $p['category'],
                (int)$p['quantity'],
                (float)$p['price']
            );
        }

        $pdf = $this->buildPdf($lines);
        file_put_contents($path, $pdf);

        $this->reports->saveReport($date, $userId, $filename);

        $response->getBody()->write($pdf);
        return $response
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function buildPdf(array $lines): string
    {
        $text = "BT /F1 11 Tf 50 780 Td ";
        foreach ($lines as $i => $line) {
            $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], (string)$line);
            if ($i > 0) $text .= "0 -16 Td ";
            $text .= "(" . $safe . ") Tj ";
        }
        $text .= "ET";

        $objects   = [];
        $objects[] = "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj";
        $objects[] = "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj";
        $objects[] = "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj";
        $objects[] = "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj";
        $objects[] = "5 0 obj << /Length " . strlen($text) . " >> stream\n" . $text . "\nendstream endobj";

        $pdf     = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $obj) {
            $offsets[] = strlen($pdf);
            $pdf .= $obj . "\n";
        }
        $xref = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n$xref\n%%EOF";
        return $pdf;
    }
}
