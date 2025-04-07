<?php

namespace App\Http\Controllers\Backend\Reportes;

use App\Http\Controllers\Controller;
use App\Models\MascotaModel;
use TCPDF;
use Exception;

class CredencialMascotaReporte extends Controller
{
    public function generarCredencial($id)
    {
        $mascota = MascotaModel::getFullInformation($id);
        $vacunas = json_decode("[" . $mascota->vacunas . "]");

        // Verificar si el ID de la mascota es válido
        if (!$mascota) {
            abort(404, 'No se encontró la mascota con el ID especificado');
        }

        $datos = [
            'nombre' => $mascota->nombre_mascota,
            'especie' => $mascota->animal,
            'raza' => $mascota->raza,
            'color' => $mascota->color,
            'edad' => $this->formatEdad($mascota->years, $mascota->meses),
            'genero' => $mascota->genero ? ($mascota->genero == 'M' ? 'Macho' : 'Hembra') : 'No especificado',
            'propietario' => $mascota->nombre_completo,
            'registro' => $mascota->registro,
            'fecha_emision' => date('d/m/Y'),
            'qr_code' => $this->generateQRContent($mascota),
            'imagePath' => $mascota->ruta_archivo,
            'vacunas' => $vacunas,
            'alergias' => 'Ninguna conocida',
            'condiciones_medicas' => 'Salud óptima',
            'veterinario' => 'Dra. María Fernanda Torres'
        ];

        ob_clean();

        $pdf = new CredencialPDF('L', 'mm', [86, 54], true, 'UTF-8', false);
        $this->configurarPDF($pdf);

        // ANVERSO
        $pdf->AddPage();
        $this->generarAnverso($pdf, $datos);

        // REVERSO
        $pdf->AddPage();
        $this->generarReverso($pdf, $datos);

        $pdf->Output('credencial_completa.pdf', 'I');
        exit;
    }

    private function configurarPDF($pdf)
    {
        $pdf->SetCreator('Sistema Veterinario');
        $pdf->SetAuthor('Clínica Veterinaria San Martin');
        $pdf->SetTitle('Credencial Completa de Mascota');
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(false);
    }

    private function generarAnverso($pdf, $mascota)
    {
        // Aquí puedes copiar el código de tu "anverso" como en tu clase CredencialMascotaReporte
        // Encabezado
        $this->agregarEncabezado($pdf);

        // Foto
        $this->agregarFotoMascota($pdf, $mascota['imagePath']);

        // Línea divisoria
        $pdf->SetDrawColor(0, 0, 139);
        $pdf->Line(5, 13, 81, 13);

        $this->agregarDetallesMascota($pdf, $mascota);

        $this->agregarCodigoQR($pdf, $mascota['qr_code']);

        $this->agregarPiePagina($pdf, $mascota);
    }

    private function generarReverso($pdf, $mascota)
    {
        $background = public_path('assets/images/fondo-reverso.png');
        if (file_exists($background)) {
            $pdf->Image($background, 0, 0, 86, 54);
        }
        $pdf->SetTextColor(0, 0, 0); // Negro
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetXY(5, 5);
        $pdf->Cell(0, 5, 'DETALLES MÉDICOS DE ' . strtoupper($mascota['nombre']), 0, 1, 'C');

        // $pdf->SetFont('helvetica', 'B', 7);
        // $pdf->Cell(15, 4, 'Alergias:', 0, 0);
        // $pdf->SetFont('helvetica', '', 7);
        // $pdf->Cell(50, 4, $mascota['alergias'], 0, 1);

        // $pdf->SetFont('helvetica', 'B', 7);
        // $pdf->Cell(30, 4, 'Condiciones Médicas:', 0, 0);
        // $pdf->SetFont('helvetica', '', 7);
        // $pdf->Cell(40, 4, $mascota['condiciones_medicas'], 0, 1);

        // $pdf->SetFont('helvetica', 'B', 7);
        // $pdf->Cell(15, 4, 'Veterinario:', 0, 0);
        // $pdf->SetFont('helvetica', '', 7);
        // $pdf->Cell(40, 4, $mascota['veterinario'], 0, 1);

        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(0, 4, 'Historial de Vacunas:', 0, 1);

        $pdf->SetFont('helvetica', '', 6);
        if($mascota['vacunas']){
            foreach ($mascota['vacunas'] as $vacuna) {
                $pdf->Cell(30, 4, $vacuna->nombre_vacuna, 1, 0);
                $pdf->Cell(40, 4, $vacuna->fecha_aplicacion, 1, 1);
            }
        }else{
            $pdf->SetTextColor(225, 225, 225); // Negro
            $pdf->Cell(0, 4, '---------------Sin vacunas----------------', 0, 0, 'C');
        }

        $pdf->SetTextColor(0, 0, 0); // Negro
        $pdf->SetFont('helvetica', 'I', 5);
        $pdf->SetXY(5, 50);
        $pdf->Cell(0, 3, 'Para más información, contacte a la clínica.', 0, 0, 'C');
    }

    private function agregarEncabezado($pdf)
    {
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetTextColor(0, 0, 128); // Azul corporativo
        $pdf->Cell(0, 5, 'CLÍNICA VETERINARIA SAN MARTÍN', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 6);
        $pdf->Cell(0, 3, 'Tel: 2222-5555 | Emergencias: 7777-8888', 0, 0, 'C');
    }

    private function agregarFotoMascota($pdf, $imagePath)
    {
        if ($imagePath) {
            $pdf->Image('storage/' . $imagePath, 58, 15, 22.3, 22.3, '', '', '', false, 300, '', false, false, 0, false, false, false);
        } else {
            // $pdf->SetAlpha(0.32); // Opacidad de 32%
            $pdf->SetFillColor(225, 225, 225); // Color de relleno
            $pdf->Rect(58, 15, 25, 25, 'F');
            $pdf->SetFont('helvetica', 'I', 6);
            $pdf->SetTextColor(150, 150, 150); // Gris claro
            $pdf->SetXY(60, 25);
            $pdf->Cell(20, 5, 'FOTO MASCOTA', 0, 0, 'C');
        }
    }

    private function agregarDetallesMascota($pdf, $mascota)
    {
        $detalles = [
            'Nombre' => $mascota['nombre'],
            'Especie' => $mascota['especie'],
            'Raza' => $mascota['raza'],
            'Color' => $mascota['color'],
            'Edad' => $mascota['edad'],
            'Género' => $mascota['genero'],
            'Propietario' => $mascota['propietario']
        ];

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->SetTextColor(0, 0, 0); // Negro
        $pdf->SetXY(5, 15);

        foreach ($detalles as $label => $value) {
            $pdf->Cell(15, 4, $label . ':', 0, 0);
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(40, 4, $value, 0, 1);
            $pdf->SetFont('helvetica', 'B', 7);
        }
    }

    private function agregarCodigoQR($pdf, $qrCode)
    {
        $style = [
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => [0, 0, 0],
            'bgcolor' => false,
            'module_width' => 1,
            'module_height' => 1
        ];

        $pdf->write2DBarcode($qrCode, 'QRCODE,L', 70, 42, 15, 15, $style, 'N');
    }

    private function agregarPiePagina($pdf, $mascota)
    {
        $pdf->SetFont('helvetica', 'I', 5);
        $pdf->SetTextColor(100, 100, 100); // Gris claro
        $pdf->SetXY(5, 51);
        $pdf->Cell(0, -2, 'Emitido: ' . $mascota['fecha_emision'] . ' | ID: ' . $mascota['registro'], 0, 0, 'C');
    }

    private function formatEdad($years, $months)
    {
        $edad = '';
        if ($years > 0) {
            $edad .= $years . ' año' . ($years > 1 ? 's' : '');
        }
        if ($months > 0) {
            if ($edad != '') {
                $edad .= ' y ';
            }
            $edad .= $months . ' mes' . ($months > 1 ? 'es' : '');
        }
        return $edad;
    }

    protected function generateQRContent($mascota)
    {
        $qrData = [
            'id' => $mascota->registro, // "VET-2023-001234"
            'n' => $mascota->nombre_mascota,
            'e' => $mascota->animal,
            'p' => $mascota->nombre_completo,
            'c' => date('Y-m-d') // Fecha de emisión
        ];

        // Convertir a JSON para estructuración clara
        return json_encode($qrData);

        // O alternativa: Formato de texto plano estructurado
        // return "ID: {$mascota->registro}\nNombre: {$mascota->nombre_mascota}\nEspecie: {$mascota->animal}\nPropietario: {$mascota->nombre_completo}";
    }
}
class CredencialPDF extends TCPDF
{
    public function Header() {}
    public function Footer() {}
}
