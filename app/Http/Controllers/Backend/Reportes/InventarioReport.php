<?php

namespace App\Http\Controllers\Backend\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Tienda\ProductoModel;
use TCPDF;

class InventarioReport extends Controller
{
    public function generarPdf()
    {
        // Obtener datos del inventario
        $productos = ProductoModel::select(['id_producto', 'nombre_producto'])
            ->with(['ultimaCompra:id_producto,precio_venta,fecha_caducidad'])
            ->withSum('compras', 'cantidad_compra')
            ->withSum('ventas', 'cantidad')
            ->get()
            ->map(function ($producto) {
                return [
                    'id' => $producto->id_producto,
                    'nombre' => $producto->nombre_producto,
                    'precio' => $producto->ultimaCompra->precio_venta ?? 0,
                    'caducidad' => $producto->ultimaCompra->fecha_caducidad ? date('d/m/Y', strtotime($producto->ultimaCompra->fecha_caducidad)) : 'N/A',
                    'stock' => max(0, $producto->compras_sum_cantidad_compra - $producto->ventas_sum_cantidad),
                ];
            })->toArray();

        if (empty($productos)) {
            // abort(404, 'No se encontraron productos en el inventario');
            return redirect('/404');
        }

        ob_clean();

        // Crear instancia de PDF personalizado
        $pdf = new InventarioPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Configuración del documento
        $pdf->SetCreator('Sistema de Inventario');
        $pdf->SetAuthor('Clínica Veterinaria San Martin');
        $pdf->SetTitle('Reporte de Inventario');
        $pdf->SetMargins(15, 40, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);

        // ===== GENERACIÓN DEL PDF =====
        $pdf->AddPage();

        $pdf->SetFont('ptserifb', 'B', 20);
        $pdf->SetY(27);
        $pdf->Cell(0, 6, 'REPORTE DE INVENTARIO', 0, 1, 'C');

        // Información del reporte
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Fecha del reporte: ' . date('d/m/Y H:i'), 0, 1);
        $pdf->Cell(0, 5, 'Total de productos: ' . count($productos), 0, 1);
        $pdf->Ln(10);

        // Tabla de productos
        $pdf->sectionTitle('DETALLE DE PRODUCTOS');
        $pdf->Ln(2);

        // Encabezados de la tabla
        $headers = ['ID', 'Nombre del Producto', 'Precio (Bs)', 'Stock', 'Fecha Caducidad'];
        $columnWidths = [15, 80, 30, 25, 30];

        $pdf->createTable($headers, $productos, $columnWidths);

        // Total de stock y valor
        $totalStock = array_sum(array_column($productos, 'stock'));
        $totalValor = array_reduce($productos, function($carry, $item) {
            return $carry + ($item['precio'] * $item['stock']);
        }, 0);

        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 5, 'Resumen:', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Total de productos en stock: ' . $totalStock, 0, 1);
        $pdf->Cell(0, 5, 'Valor total del inventario: Bs ' . number_format($totalValor, 2), 0, 1);

        // Firma del responsable
        $pdf->Ln(20);
        $pdf->Cell(0, 5, str_repeat('.', 80), 0, 1, 'C');
        $pdf->Cell(0, 5, 'Firma del responsable', 0, 1, 'C');

        $pdf->Output('reporte_inventario.pdf', 'I');
        exit;
    }
}

class InventarioPDF extends TCPDF
{
    public function Header()
    {
        // Logo
        $image_file = public_path('assets/images/logo-report1.png');
        $this->Image($image_file, 10, 10, 55);

        // Título
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'CLÍNICA VETERINARIA SAN MARTIN', 0, 1, 'R');

        // Información de contacto
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Cel: 67059010 | Emergencias: 63216170 | Av. Ladislao Cabrera #2702', 0, 1, 'R');

        // Línea separadora
        $this->Line(10, 25, $this->getPageWidth() - 10, 25);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }

    // ===== MÉTODOS PERSONALIZADOS =====

    public function sectionTitle($title)
    {
        $this->Ln(5);
        $this->SetFont('helvetica', 'B', 11);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 6, $title, 0, 1, 'L', true);
        $this->SetFont('helvetica', '', 9);
    }

    public function createTable($headers, $data, $columnWidths = null)
    {
        // Configurar encabezado
        $this->SetFillColor(58, 115, 111);
        $this->SetTextColor(255);
        $this->SetFont('helvetica', 'B', 9);

        // Dibujar encabezados
        foreach ($headers as $i => $header) {
            $this->Cell($columnWidths[$i], 6, $header, 1, 0, 'C', true);
        }
        $this->Ln();

        // Dibujar datos
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 9);
        $fill = false;

        foreach ($data as $row) {
            $this->SetFillColor($fill ? 240 : 255);

            // ID
            $this->Cell($columnWidths[0], 6, $row['id'], 'LR', 0, 'C', $fill);

            // Nombre
            $this->Cell($columnWidths[1], 6, $row['nombre'], 'LR', 0, 'L', $fill);

            // Precio (formateado)
            $this->Cell($columnWidths[2], 6, number_format($row['precio'], 2), 'LR', 0, 'R', $fill);

            // Stock
            $this->Cell($columnWidths[3], 6, $row['stock'], 'LR', 0, 'C', $fill);

            // Fecha Caducidad
            $this->Cell($columnWidths[4], 6, $row['caducidad'], 'LR', 0, 'C', $fill);

            $this->Ln();
            $fill = !$fill;
        }

        // Línea de cierre
        $this->Cell(array_sum($columnWidths), 0, '', 'T');
    }
}
