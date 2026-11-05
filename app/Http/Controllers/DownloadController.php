<?php

namespace App\Http\Controllers;

use App\Models\TicketBatch;
use App\Models\RaffleSetting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;

class DownloadController extends Controller
{
    public function index()
    {
        return view('downloads.index', [
            'batches' => TicketBatch::latest()->paginate(15)
        ]);
    }

    public function download(Request $r, TicketBatch $download, string $format)
    {
        if ($format === 'word') {
            $format = 'docx';
        }
        
        abort_unless(in_array($format, ['pdf', 'docx'], true), 404);

        $setting = RaffleSetting::firstOrCreate(['id' => 1], [
            'store_name' => 'Portátiles Perú',
            'slogan' => 'Tecnología a tu alcance',
            'minimum_purchase' => 50,
            'prize' => 'Canastas Navideñas',
            'draw_date' => now()->setDate(2026, 12, 24),
            'accent_color' => '#0b3882'
        ]);

        $maxTickets = min($download->quantity, 300);
        $end = min($download->end_number, $download->start_number + $maxTickets - 1);
        $numbers = range($download->start_number, $end);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('tickets.document', compact('download', 'setting', 'numbers'))
                ->setPaper('a4', 'landscape');
            return $pdf->download("tickets_navidenos_{$download->id}.pdf");
        }

        // GENERATE BEAUTIFULLY DESIGNED WORD DOCUMENT WITH REAL TICKET TABLES & IMAGES
        $word = new PhpWord();
        $word->setDefaultFontName($setting->font_family ?: 'Arial');
        $word->setDefaultFontSize(8);
        $word->setDefaultParagraphStyle([
            'spaceBefore' => 0,
            'spaceAfter' => 0,
            'lineSpacing' => 1.0,
        ]);

        $pCenter = ['alignment' => Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineSpacing' => 1.0];
        $pLeft = ['alignment' => Jc::LEFT, 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineSpacing' => 1.0];

        $perSheet = (int)($download->per_sheet ?? 10);
        $is10 = ($perSheet >= 10);
        $is8 = ($perSheet == 8);
        $is6 = ($perSheet == 6);

        $sheetChunks = array_chunk($numbers, $perSheet);

        $logoPath = $setting->logo_path ? public_path(ltrim($setting->logo_path, '/')) : public_path('images/laptop_logo_2x.png');
        $canastaPath = $setting->prize_image_path ? public_path(ltrim($setting->prize_image_path, '/')) : public_path('images/canasta_sorteo.png');
        $scissorsPath = public_path('images/scissors_blue.png');
        $accentColor = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $setting->accent_color)
            ? strtoupper(ltrim($setting->accent_color, '#'))
            : '0877F9';

        $marginTop = $is10 ? 250 : ($is8 ? 300 : 400);
        $marginBottom = $is10 ? 250 : ($is8 ? 300 : 400);
        $ticketHeight = $is10 ? 2080 : ($is8 ? 2620 : ($is6 ? 3550 : 5400));
        $logoW = $is10 ? 24 : ($is8 ? 26 : 30);
        $logoH = $is10 ? 16 : ($is8 ? 18 : 21);
        $canastaW = $is10 ? 24 : ($is8 ? 30 : 38);
        $titleSz = $is10 ? 10 : ($is8 ? 11 : 12);
        $sloganSz = $is10 ? 7 : ($is8 ? 8 : 9);
        $ribbonSz = $is10 ? 8 : ($is8 ? 8.5 : 10);
        $numSz = $is10 ? 9 : ($is8 ? 10 : 11.5);
        $pillSz = $is10 ? 6.2 : ($is8 ? 7 : 8);
        $formSz = $is10 ? 6.8 : ($is8 ? 7.5 : 8.5);
        $prizeSz = $is10 ? 7.8 : ($is8 ? 9 : 10.5);
        $thanksSz = $is10 ? 8.5 : ($is8 ? 9.5 : 11.5);
        $scissorsW = $is10 ? 9 : ($is8 ? 11 : 13);
        $cellPad = $is10 ? 15 : ($is8 ? 25 : 35);

        foreach ($sheetChunks as $sheetNumbers) {
            $section = $word->addSection([
                'orientation' => 'landscape',
                'marginTop' => $marginTop,
                'marginBottom' => $marginBottom,
                'marginLeft' => 350,
                'marginRight' => 350,
            ]);

            $outerTable = $section->addTable([
                'borderSize' => 0,
                'cellMargin' => $is10 ? 25 : ($is8 ? 35 : 45),
                'alignment' => JcTable::CENTER,
            ]);

            $rows = array_chunk($sheetNumbers, 2);
            foreach ($rows as $rowTickets) {
                $outerTable->addRow($ticketHeight);
                foreach ($rowTickets as $number) {
                    $numStr = str_pad($number, 6, '0', STR_PAD_LEFT);
                    
                    // Outer border for ticket
                    $ticketCell = $outerTable->addCell(7850, [
                        'borderSize' => 9,
                        'borderColor' => '0B3882',
                        'bgColor' => 'FFFFFF',
                        'cellMargin' => $cellPad,
                    ]);

                    $tTable = $ticketCell->addTable([
                        'cellMargin' => 0,
                        'alignment' => JcTable::CENTER,
                    ]);
                    $tTable->addRow();

                    // === 1. STORE STUB (COPIA DE LA TIENDA) ===
                    $stub = $tTable->addCell(3650, ['bgColor' => 'FFFFFF', 'cellMargin' => $cellPad]);

                    // Header
                    $hRun = $stub->addTextRun($pCenter);
                    if (file_exists($logoPath)) {
                        $hRun->addImage($logoPath, ['width' => $logoW, 'height' => $logoH]);
                        $hRun->addText(' ');
                    }
                    $hRun->addText(mb_strtoupper($setting->store_name ?: 'Portátiles Perú', 'UTF-8'), ['bold' => true, 'color' => '0B3882', 'size' => $titleSz]);
                    $stub->addText($setting->slogan ?: 'Tecnología a tu alcance', ['color' => '1A56DB', 'size' => $sloganSz, 'bold' => true], $pCenter);

                    // Festive Ribbon
                    $rTab = $stub->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 3 : 5]);
                    $rTab->addRow();
                    $rCell = $rTab->addCell(3550, [
                        'bgColor' => $accentColor,
                        'borderTopColor' => 'FACC15',
                        'borderTopSize' => 6,
                        'borderBottomColor' => 'FACC15',
                        'borderBottomSize' => 6,
                    ]);
                    $rCell->addText($setting->ribbon_text ?: 'GRAN SORTEO NAVIDEÑO 2026', ['bold' => true, 'color' => 'FFFFFF', 'size' => $ribbonSz], $pCenter);

                    // Number Badge
                    $nTab = $stub->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 2 : 4]);
                    $nTab->addRow();
                    $nCell = $nTab->addCell(1800, ['bgColor' => '0F3B7D']);
                    $nCell->addText("N.º {$numStr}", ['bold' => true, 'color' => 'FFFFFF', 'size' => $numSz], $pCenter);

                    // Copy Pill
                    $pTab = $stub->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 2 : 3]);
                    $pTab->addRow();
                    $pCell = $pTab->addCell(1900, ['bgColor' => '0284C7']);
                    $pCell->addText('COPIA DE LA TIENDA', ['bold' => true, 'color' => 'FFFFFF', 'size' => $pillSz], $pCenter);

                    // Form Lines
                    $lTab = $stub->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 2 : 3]);
                    $lines = ['Nombre:', 'DNI:', 'Celular:'];
                    foreach ($lines as $label) {
                        $lTab->addRow();
                        $lTab->addCell(750)->addText($label, ['bold' => true, 'color' => '0B2554', 'size' => $formSz], $pLeft);
                        $lTab->addCell(2750, ['borderBottomSize' => 6, 'borderBottomColor' => '0B2554'])->addText('', [], $pLeft);
                    }
                    $stub->addText('- Depositar este talón en el ánfora -', ['color' => '1E4B8F', 'size' => $sloganSz, 'italic' => true], $pCenter);

                    // === 2. PERFORATION ===
                    $perf = $tTable->addCell(350, [
                        'bgColor' => 'FBFDFF',
                        'borderLeftStyle' => 'dashed',
                        'borderLeftSize' => 6,
                        'borderLeftColor' => '1E4B8F',
                        'cellMargin' => 0,
                    ]);
                    if (file_exists($scissorsPath)) {
                        $perf->addImage($scissorsPath, ['width' => $scissorsW, 'height' => $scissorsW, 'alignment' => Jc::CENTER]);
                    }

                    // === 3. CUSTOMER STUB (COPIA DEL CLIENTE) ===
                    $cust = $tTable->addCell(3650, ['bgColor' => 'FFFFFF', 'cellMargin' => $cellPad]);

                    // Header
                    $hRun2 = $cust->addTextRun($pCenter);
                    if (file_exists($logoPath)) {
                        $hRun2->addImage($logoPath, ['width' => $logoW, 'height' => $logoH]);
                        $hRun2->addText(' ');
                    }
                    $hRun2->addText(mb_strtoupper($setting->store_name ?: 'Portátiles Perú', 'UTF-8'), ['bold' => true, 'color' => '0B3882', 'size' => $titleSz]);
                    $cust->addText($setting->slogan ?: 'Tecnología a tu alcance', ['color' => '1A56DB', 'size' => $sloganSz, 'bold' => true], $pCenter);

                    // Festive Ribbon
                    $rTab2 = $cust->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 3 : 5]);
                    $rTab2->addRow();
                    $rCell2 = $rTab2->addCell(3550, [
                        'bgColor' => $accentColor,
                        'borderTopColor' => 'FACC15',
                        'borderTopSize' => 6,
                        'borderBottomColor' => 'FACC15',
                        'borderBottomSize' => 6,
                    ]);
                    $rCell2->addText($setting->ribbon_text ?: 'GRAN SORTEO NAVIDEÑO 2026', ['bold' => true, 'color' => 'FFFFFF', 'size' => $ribbonSz], $pCenter);

                    // Number Badge
                    $nTab2 = $cust->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 2 : 4]);
                    $nTab2->addRow();
                    $nCell2 = $nTab2->addCell(1800, ['bgColor' => '0F3B7D']);
                    $nCell2->addText("N.º {$numStr}", ['bold' => true, 'color' => 'FFFFFF', 'size' => $numSz], $pCenter);

                    // Copy Pill
                    $pTab2 = $cust->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 2 : 3]);
                    $pTab2->addRow();
                    $pCell2 = $pTab2->addCell(1900, ['bgColor' => '0284C7']);
                    $pCell2->addText('COPIA DEL CLIENTE', ['bold' => true, 'color' => 'FFFFFF', 'size' => $pillSz], $pCenter);

                    // Prize Box with Canasta Image
                    $prTab = $cust->addTable(['alignment' => JcTable::CENTER, 'cellMargin' => $is10 ? 2 : 3]);
                    $prTab->addRow();
                    $prImg = $prTab->addCell(800, [
                        'borderSize' => 6,
                        'borderColor' => 'F59E0B',
                        'bgColor' => 'FFFFFF',
                        'cellMargin' => 2,
                    ]);
                    if (file_exists($canastaPath)) {
                        $prImg->addImage($canastaPath, ['width' => $canastaW, 'height' => $canastaW, 'alignment' => Jc::CENTER]);
                    }
                    $prTxt = $prTab->addCell(2700, [
                        'bgColor' => 'DC2626',
                        'borderSize' => 6,
                        'borderColor' => 'FACC15',
                        'cellMargin' => $is10 ? 2 : 4,
                    ]);
                    $prTxt->addText('PREMIO:', ['bold' => true, 'color' => 'FEF08A', 'size' => $sloganSz], $pCenter);
                    $prTxt->addText($setting->prize ?: 'Canasta Navideña', ['bold' => true, 'color' => 'FFFFFF', 'size' => $prizeSz], $pCenter);

                    // Promo Condition, Date & Greeting
                    $minP = number_format($setting->minimum_purchase ?: 50, 0);
                    $cust->addText("A partir de tu compra de S/ {$minP} a más ingresas al sorteo y ¡te llevas tu Canasta!", ['bold' => true, 'color' => '0B3882', 'size' => $sloganSz], $pCenter);
                    $dateText = $setting->show_draw_date
                        ? 'Sorteo: ' . ($setting->draw_date ? $setting->draw_date->format('d/m/Y') : '24/12/2026')
                        : ($setting->date_replacement ?: '');
                    if ($dateText) {
                        $cust->addText($dateText, ['bold' => true, 'color' => '0B2554', 'size' => $sloganSz], $pCenter);
                    }
                    $cust->addText($setting->thanks_text ?: '¡Gracias por tu preferencia!', ['bold' => true, 'italic' => true, 'color' => 'DC2626', 'size' => $thanksSz], $pCenter);
                }

                if (count($rowTickets) === 1) {
                    $outerTable->addCell(7850);
                }
            }
        }

        $tmp = tempnam(sys_get_temp_dir(), 'ticket-') . '.docx';
        IOFactory::createWriter($word, 'Word2007')->save($tmp);

        return response()->download($tmp, "tickets_navidenos_{$download->id}.docx")->deleteFileAfterSend(true);
    }
}
