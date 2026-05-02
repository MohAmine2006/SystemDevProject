<?php
namespace App\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\ReportRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class ReportController
{
    public function __construct(private PhpRenderer $view, private ProductRepository $products, private ReportRepository $reports) {}

    public function index(Request $request, Response $response): Response
    {
        $date = $request->getQueryParams()['date'] ?? date('Y-m-d');
        return $this->view->render($response, 'reports/index.php', [
            'summary' => $this->products->reportSummary($date)
        ]);
    }

    public function generatePdf(Request $request, Response $response): Response
    {
        $data = (array)$request->getParsedBody();
        $date = $data['report_date'] ?? date('Y-m-d');
        $summary = $this->products->reportSummary($date);
        $filename = 'inventory-report-' . $date . '-' . date('His') . '.pdf';
        $path = dirname(__DIR__, 2) . '/downloads/' . $filename;

        $lines = [
            'La Fruiterie Global - Stock Report',
            'Date: ' . $summary['date'],
            'Total Items: ' . $summary['total_items'],
            'Products: ' . $summary['total_products'],
            'Total Value: $' . number_format((float)$summary['total_inventory_value'], 2),
            '',
            'Products:'
        ];
        foreach ($summary['products'] as $p) {
            $lines[] = $p['name_en'] . ' | ' . $p['category'] . ' | Qty: ' . $p['quantity'] . ' | Price: $' . number_format((float)$p['price'], 2);
        }

        $pdf = $this->makeSimplePdf($lines);
        file_put_contents($path, $pdf);

        if (!empty($_SESSION['user'])) {
            $this->reports->saveInventoryReport($summary, (int)$_SESSION['user']['id'], $filename);
        }

        $response->getBody()->write($pdf);
        return $response
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function makeSimplePdf(array $lines): string
    {
        $text = "BT /F1 12 Tf 50 780 Td ";
        foreach ($lines as $i => $line) {
            $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], (string)$line);
            if ($i > 0) $text .= "0 -18 Td ";
            $text .= "(" . $safe . ") Tj ";
        }
        $text .= "ET";

        $objects = [];
        $objects[] = "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj";
        $objects[] = "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj";
        $objects[] = "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj";
        $objects[] = "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj";
        $objects[] = "5 0 obj << /Length " . strlen($text) . " >> stream\n" . $text . "\nendstream endobj";

        $pdf = "%PDF-1.4\n";
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
        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";
        return $pdf;
    }
}
