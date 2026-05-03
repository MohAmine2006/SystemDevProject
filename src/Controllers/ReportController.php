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
        $date        = $request->getQueryParams()['date'] ?? date('Y-m-d');
        $summary     = $this->products->reportSummary($date);
        $sales       = $this->reports->getSalesForDate($date);
        $salesTotals = $this->reports->getSalesSummary($date);

        return $this->view->render($response, 'reports/index.php', [
            'summary'     => $summary,
            'sales'       => $sales,
            'salesTotals' => $salesTotals,
        ]);
    }

    public function generatePdf(Request $request, Response $response): Response
    {
        $data     = (array)$request->getParsedBody();
        $date     = $data['report_date'] ?? date('Y-m-d');
        $userId   = (int)($_SESSION['user']['id'] ?? 0);
        $userName = $_SESSION['user']['username'] ?? 'Unknown';

        $summary     = $this->products->reportSummary($date);
        $sales       = $this->reports->getSalesForDate($date);
        $salesTotals = $this->reports->getSalesSummary($date);

        $filename = 'inventory-report-' . $date . '-' . date('His') . '.pdf';
        $dir      = dirname(__DIR__, 2) . '/downloads/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $content = $this->renderPdf($date, $userName, $summary, $sales, $salesTotals);

        file_put_contents($dir . $filename, $content);
        $this->reports->saveReport($date, $userId, $filename);

        $response->getBody()->write($content);
        return $response
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // -----------------------------------------------------------------------

    private function renderPdf(
        string $date,
        string $generatedBy,
        array  $summary,
        array  $sales,
        array  $salesTotals
    ): string {
        $reportDate = $date;

        $pdf = new class($reportDate) extends \FPDF {
            private string $rDate;

            public function __construct(string $rDate)
            {
                parent::__construct('P', 'mm', 'A4');
                $this->rDate = $rDate;
                $this->SetMargins(15, 5, 15);
                $this->SetAutoPageBreak(true, 18);
            }

            public function Header(): void
            {
                $this->SetXY(15, 5);
                // Dark green title bar
                $this->SetFillColor(26, 74, 16);
                $this->SetTextColor(255, 255, 255);
                $this->SetFont('Helvetica', 'B', 16);
                $this->Cell(180, 13, 'La Fruiterie Global', 0, 1, 'L', true);
                // Subtitle bar
                $this->SetX(15);
                $this->SetFillColor(45, 139, 69);
                $this->SetFont('Helvetica', '', 9);
                $this->Cell(
                    180, 7,
                    '  Inventory & Sales Report  -  ' . date('F j, Y', strtotime($this->rDate)),
                    0, 1, 'L', true
                );
                $this->SetTextColor(0, 0, 0);
                $this->Ln(5);
            }

            public function Footer(): void
            {
                $this->SetY(-14);
                $this->SetDrawColor(210, 210, 210);
                $this->Line(15, $this->GetY(), 195, $this->GetY());
                $this->SetFont('Helvetica', 'I', 8);
                $this->SetTextColor(160, 160, 160);
                $this->Cell(90, 6, 'La Fruiterie Global  |  Confidential', 0, 0, 'L');
                $this->Cell(90, 6, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'R');
            }
        };

        $pdf->AliasNbPages();
        $pdf->AddPage();

        // --- Meta row ---
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetTextColor(130, 130, 130);
        $pdf->Cell(30, 5, 'Generated:', 0, 0);
        $pdf->SetTextColor(50, 50, 50);
        $pdf->Cell(60, 5, date('Y-m-d H:i:s'), 0, 0);
        $pdf->SetTextColor(130, 130, 130);
        $pdf->Cell(15, 5, 'By:', 0, 0);
        $pdf->SetTextColor(50, 50, 50);
        $pdf->Cell(0, 5, $this->pdfStr($generatedBy), 0, 1);
        $pdf->Ln(4);

        // =====================================================================
        // INVENTORY SUMMARY
        // =====================================================================
        $this->sectionHeader($pdf, 'INVENTORY SUMMARY');

        $stats = [
            ['Total Products',   (string)$summary['total_products']],
            ['Total Stock Items', number_format((int)$summary['total_items'])],
            ['Inventory Value',  '$' . number_format((float)$summary['total_inventory_value'], 2)],
            ['Report Date',      date('M j, Y', strtotime($date))],
        ];

        foreach (array_chunk($stats, 2) as $pair) {
            $y = $pdf->GetY();
            foreach ($pair as $col => [$label, $value]) {
                $x = 15 + $col * 91;
                $pdf->SetXY($x, $y);
                $pdf->SetFillColor(247, 251, 247);
                $pdf->SetDrawColor(210, 230, 210);
                $pdf->Rect($x, $y, 88, 15, 'DF');
                $pdf->SetXY($x + 4, $y + 2.5);
                $pdf->SetFont('Helvetica', '', 8);
                $pdf->SetTextColor(110, 110, 110);
                $pdf->Cell(80, 4, $label, 0, 0, 'L');
                $pdf->SetXY($x + 4, $y + 7);
                $pdf->SetFont('Helvetica', 'B', 13);
                $pdf->SetTextColor(26, 74, 16);
                $pdf->Cell(80, 7, $value, 0, 0, 'L');
            }
            $pdf->SetXY(15, $y + 17);
        }
        $pdf->Ln(5);

        // =====================================================================
        // DAILY SALES
        // =====================================================================
        $this->sectionHeader($pdf, 'DAILY SALES  -  ' . date('F j, Y', strtotime($date)));

        // Totals line
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetTextColor(90, 90, 90);
        $pdf->Cell(32, 5, 'Total Revenue:', 0, 0);
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetTextColor(45, 139, 69);
        $pdf->Cell(44, 5, '$' . number_format((float)$salesTotals['total_revenue'], 2), 0, 0);
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetTextColor(90, 90, 90);
        $pdf->Cell(22, 5, 'Units Sold:', 0, 0);
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetTextColor(50, 50, 50);
        $pdf->Cell(0, 5, (string)(int)$salesTotals['total_units'], 0, 1);
        $pdf->Ln(3);

        if (empty($sales)) {
            $pdf->SetFont('Helvetica', 'I', 10);
            $pdf->SetTextColor(180, 180, 180);
            $pdf->Cell(0, 10, 'No sales recorded for this date.', 0, 1, 'C');
        } else {
            // col: [header, width, align]
            $salesCols = [
                ['Product Name', 50, 'L'],
                ['Category',     28, 'L'],
                ['Qty Sold',     17, 'C'],
                ['Sale Price',   21, 'R'],
                ['Line Total',   21, 'R'],
                ['Qty Left',     17, 'C'],
                ['Staff',        26, 'L'],
            ];
            $this->tableHeader($pdf, $salesCols);
            foreach ($sales as $i => $s) {
                $lineTotal = (float)$s['quantity_sold'] * (float)$s['price_at_sale'];
                $this->tableRow($pdf, $salesCols, [
                    $this->pdfStr($s['name_en']),
                    $this->pdfStr($s['category']),
                    (string)(int)$s['quantity_sold'],
                    '$' . number_format((float)$s['price_at_sale'], 2),
                    '$' . number_format($lineTotal, 2),
                    (string)(int)$s['qty_remaining'],
                    $this->pdfStr($s['sold_by_name']),
                ], $i % 2 !== 0);
            }
        }
        $pdf->Ln(6);

        // =====================================================================
        // END-OF-DAY STOCK LEVELS
        // =====================================================================
        $this->sectionHeader($pdf, 'END-OF-DAY STOCK LEVELS');

        $stockCols = [
            ['Product Name',  64, 'L'],
            ['Category',      34, 'L'],
            ['Qty Remaining', 27, 'C'],
            ['Unit Price',    27, 'R'],
            ['Stock Value',   28, 'R'],
        ];
        $this->tableHeader($pdf, $stockCols);
        foreach ($summary['products'] as $i => $p) {
            $value = (float)$p['price'] * (int)$p['quantity'];
            $this->tableRow($pdf, $stockCols, [
                $this->pdfStr($p['name_en']),
                $this->pdfStr($p['category']),
                (string)(int)$p['quantity'],
                '$' . number_format((float)$p['price'], 2),
                '$' . number_format($value, 2),
            ], $i % 2 !== 0);
        }

        return $pdf->Output('S');
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    private function sectionHeader(\FPDF $pdf, string $title): void
    {
        $pdf->SetFillColor(26, 74, 16);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(180, 8, '   ' . $title, 0, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(220, 220, 220);
        $pdf->Ln(3);
    }

    private function tableHeader(\FPDF $pdf, array $cols): void
    {
        $pdf->SetFillColor(45, 139, 69);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', 'B', 9);
        foreach ($cols as [$label, $width, $align]) {
            $pdf->Cell($width, 7, $label, 0, 0, $align === 'C' ? 'C' : ($align === 'R' ? 'R' : 'L'), true);
        }
        $pdf->Ln();
        $pdf->SetTextColor(50, 50, 50);
    }

    private function tableRow(\FPDF $pdf, array $cols, array $values, bool $stripe): void
    {
        $pdf->SetFillColor($stripe ? 248 : 255, $stripe ? 252 : 255, $stripe ? 248 : 255);
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetTextColor(50, 50, 50);
        foreach ($cols as $i => [$label, $width, $align]) {
            $pdf->Cell($width, 7, $values[$i] ?? '', 0, 0, $align, true);
        }
        $pdf->Ln();
    }

    /** Convert UTF-8 string to ISO-8859-1 for FPDF Type1 fonts. */
    private function pdfStr(string $s): string
    {
        return mb_convert_encoding($s, 'ISO-8859-1', 'UTF-8');
    }
}
