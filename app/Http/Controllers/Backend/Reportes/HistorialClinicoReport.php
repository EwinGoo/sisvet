<?php

namespace App\Http\Controllers\Backend\Reportes;

use App\Http\Controllers\Controller;
use TCPDF;

class HistorialClinicoReport extends Controller
{
    public function index()
    {
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Configuración básica

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.


        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetFont('dejavusans', '', 14, '', true);
        $pdf->Ln(10);

        $pdf->Cell(0, 25, 'HISTORIA CLINICA', 0, 1, 'C');

        $header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
        $data = [[1, 2, 3, 4]];

        $x = $pdf->GetX();
        $pdf->ColoredTable($header, $data);
        $pdf->SetX($x);

        // Definir las coordenadas, el ancho y la altura de la celda
        $x = 10;  // Posición X
        $y = 50;  // Posición Y
        $width = 50;  // Ancho de la celda
        $height = 50;  // Altura de la celda
        $radius = 25;  // Radio de los bordes redondeados

        // Dibujar un rectángulo redondeado
        $pdf->SetFillColor(255, 255, 255);  // Color de relleno (blanco en este caso)
        $pdf->RoundedRect($x, $y, $width, $height, $radius, '1234', 'DF');  // 'DF' significa bordes sólidos con relleno

        // Escribir el texto en la celda
        $pdf->SetXY($x, $y);  // Establecer la posición para el texto
        $pdf->Cell($width, $height, 'HISTORIA CLINICA', 0, 1, 'C');  // La celda sin borde



        $html = '
        <table border="1" cellspacing="0" cellpadding="4" >
            <thead>
                <tr>
                    <th style="font-weight: bold; text-align: center; border-radius: 10px;">#</th>
                    <th style="font-weight: bold; text-align: center;">Nombre</th>
                    <th style="font-weight: bold; text-align: center;">Edad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>Juan Pérez</td>
                    <td style="text-align: center;">25</td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td>María López</td>
                    <td style="text-align: center;">30</td>
                </tr>
            </tbody>
        </table>
        ';
        $pdf->writeHTML($html, true, false, true, false, '');

        // set text shadow effect
        // $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        // Set some content to print
        $html = <<<EOD
        <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
        <i>This is the first example of TCPDF library.</i>
        <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
        <p>Please check the source code documentation and other examples for further information.</p>
        <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
        EOD;

        // Print text using writeHTMLCell()
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------
        ob_end_clean();
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');
    }
}

class PDF extends TCPDF
{
    public function Header()
    {
        // Fuente para el encabezado
        $this->SetFont('helvetica', 'B', 16);

        // Texto personalizado
        $this->Cell(0, 25, 'HISTORIA CLINICA', 0, 1, 'C');
        $this->Image('assets/images/logo_2.png', 15, 8, 38, 23, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        // $this->Image(,);

        // Línea para separar el encabezado
        // $this->Line(10, 20, $this->getPageWidth() - 10, 20);
    }
    public function Footer()
    {
        $cur_y = $this->y;
        // Establecer la fuente para el pie de página
        $this->SetFont('helvetica', 'I', 8);

        // Mover el cursor a la posición correcta
        $this->SetY(-15);  // Posición Y desde el fondo de la página

        // Agregar el texto del pie de página (centrado)
        // $this->Cell(0, 10, 'Página ' . $this->getPageNumGroupAlias() . ' de ' . $this->getNumPages(), 0, 0, 'C');

        $w_page = isset($this->l['w_page']) ? $this->l['w_page'] . ' ' : '';

        if (empty($this->pagegroups)) {
            $pagenumtxt = 'Página ' . $w_page . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages();
        } else {
            $pagenumtxt = $w_page . $this->getPageNumGroupAlias() . ' / ' . $this->getPageGroupAlias();
        }
        $this->setY($cur_y);
        //Print page number
        if ($this->getRTL()) {
            $this->setX($this->original_rMargin);
            $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
        } else {
            $this->setX($this->original_lMargin);
            $this->Cell(0, 0, $this->getAliasRightShift() . $pagenumtxt, 'T', 0, 'R');
        }

        // Agregar una línea en el pie de página (si deseas)
        // $this->Line(10, $this->GetY() + 5, $this->getPageWidth() - 10, $this->GetY() + 5);
    }
    public function ColoredTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
