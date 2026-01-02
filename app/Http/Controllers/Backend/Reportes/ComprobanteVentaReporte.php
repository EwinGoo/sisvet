<?php

namespace App\Http\Controllers\Backend\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Tienda\DetalleVentaModel;
use App\Models\Tienda\VentaModel;
use TCPDF;

class ComprobanteVentaReporte extends Controller
{
    public function generarComprobante($id = null)
    {
        // Obtener datos de la venta (simulados según tu estructura)
        $venta = VentaModel::select('ventas.*')
            ->selectRaw("CONCAT_WS(' ', c.nombre, c.paterno, IFNULL(c.materno, '')) as cliente")
            ->selectRaw("CONCAT_WS(' ', u.nombre, u.paterno, IFNULL(u.materno, '')) as vendedor")
            ->selectRaw("DATE_FORMAT(fecha_venta, '%d de %M del %Y') as fecha")
            ->selectRaw("DATE_FORMAT(fecha_venta, '%h:%i %p') as hora")
            ->leftJoin('clientes as c', 'c.id_cliente', '=', 'ventas.id_cliente')
            ->leftJoin('usuarios as u', 'u.id_usuario', '=', 'ventas.id_usuario')
            ->find($id);

        $detalles = DetalleVentaModel::select(
            'detalles_venta.*',
            'p.nombre_producto',
            'p.id_producto'
        )
            ->leftJoin('productos as p', 'p.id_producto', '=', 'detalles_venta.id_producto')
            ->where('id_venta', $id)
            ->get();

        $data = [
            'venta' => $venta,
            'detalles' => $detalles,
        ];

        ob_clean();
        ob_start();

        // Crear instancia de PDF
        $pdf = new ComprobantePDF(PDF_PAGE_ORIENTATION, PDF_UNIT, [80, 200], true, 'UTF-8', false);

        // Configuración del documento
        $pdf->SetCreator('Sistema Veterinario');
        $pdf->SetAuthor('Tienda de Mascotas');
        $pdf->SetTitle('Comprobante de Venta');
        $pdf->SetMargins(5, 5, 5);
        // $pdf->setMargins()
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(5);
        $pdf->SetAutoPageBreak(TRUE, 15);

        $pdf->AddPage();

        // Encabezado
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 6, 'TIENDA S-MART', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 8);
        // $pdf->Cell(0, 4, 'Av. Principal #123 - Tel: 2222-5555', 0, 1, 'C');
        // $pdf->Cell(0, 4, 'RUC: 12345678901', 0, 1, 'C');

        // Línea separadora
        $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
        $pdf->Ln(4);

        // Información de la venta
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(28, 4, 'COMPROBANTE:', 0, 0);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(0, 4, 'Venta #' . str_pad($data['venta']['id_venta'], 4, '0', STR_PAD_LEFT), 0, 1);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(14, 4, 'FECHA:', 0, 0);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(0, 4, $data['venta']['fecha'] . ' ' . $data['venta']['hora'], 0, 1);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(24, 4, 'VENDEDOR:', 0, 0);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(0, 4, $data['venta']['vendedor'], 0, 1);
        $pdf->Ln(1);

        $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
        $pdf->Ln(3);

        // Detalles de la venta
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(10, 5, 'Cant.', 0, 0, 'C');
        $pdf->Cell(30, 5, 'Producto', 0, 0);
        $pdf->Cell(15, 5, 'P.Unit.', 0, 0, 'R');
        $pdf->Cell(0, 5, 'Total', 0, 1, 'R');

        $pdf->SetFont('helvetica', '', 8);
        foreach ($data['detalles'] as $item) {
            $pdf->Cell(10, 5, $item['cantidad'], 0, 0, 'C');

            // Ajustar nombre del producto si es muy largo
            $nombre = strlen($item['nombre_producto']) > 20 ?
                substr($item['nombre_producto'], 0, 17) . '...' :
                $item['nombre_producto'];
            $pdf->Cell(30, 5, $nombre, 0, 0);

            $pdf->Cell(15, 5, number_format($item['precio_unitario'], 2), 0, 0, 'R');
            $pdf->Cell(0, 5, number_format($item['subtotal'], 2), 0, 1, 'R');
        }

        $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
        $pdf->Ln(3);

        // Totales
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 6, 'TOTAL: Bs/ ' . number_format($data['venta']['total_venta'], 2, ',', '.'), 0, 1, 'R');

        // $pdf->Cell(45, 6, 'TOTAL:', 0, 0, 'R');
        // $pdf->Cell(25, 6, 'Bs/ ' . number_format($data['venta']['total_venta'], 0, 1, 'R'));

        $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
        $pdf->Ln(5);

        // Pie de página
        $pdf->SetFont('helvetica', 'I', 7);
        $pdf->MultiCell(0, 4, 'Gracias por su compra!', 0, 'C');
        $pdf->MultiCell(0, 4, 'Productos adquiridos no tienen cambio', 0, 'C');
        $pdf->MultiCell(0, 4, 'Atendido por: ' . $data['venta']['vendedor'], 0, 'C');

        // Código QR (opcional)
        // $pdf->SetY($pdf->GetY()+5);
        // $pdf->write2DBarcode('https://tutienda.com/comprobante/'.$data['venta']['id_venta'], 'QRCODE,M', 25, $pdf->GetY(), 30, 30);

        $pdf->Output('comprobante_venta_' . $data['venta']['id_venta'] . '.pdf', 'I');
        exit;
    }
}

class ComprobantePDF extends TCPDF
{
    public function Header()
    {
        // Logo opcional
        // $image_file = public_path('assets/images/logo-small.png');
        // $this->Image($image_file, 20, 5, 15);
    }

    public function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('helvetica', 'I', 6);
        $this->Cell(0, 4, 'Sistema de ventas - ' . date('d/m/Y H:i'), 0, 0, 'C');
    }
}
