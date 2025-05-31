<?php

namespace App\Http\Controllers\Backend\Reportes;

use App\Http\Controllers\Controller;
use App\Models\HistorialClinicoModel;
use App\Models\MascotaModel;
use TCPDF;

class HistorialClinicoReport extends Controller
{
    public function generarPdf($id = null)
    {

        // $historial = HistorialClinicoModel::find($id);
        $data = HistorialClinicoModel::getDataHistorial($id, null, true);
        // $dctor =
        $data = json_decode(json_encode($data), true);

        // echo '<pre>';
        // echo json_encode((array)$data, JSON_PRETTY_PRINT); // Formato JSON ordenado
        // echo '</pre>';
        // exit;

        if (!$data) {
            abort(404, 'No se encontró la mascota con el ID especificado');
        }

        ob_clean();

        // Crear instancia de PDF personalizado
        $pdf = new VeterinariaPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Configuración del documento
        $pdf->SetCreator('Sistema Veterinario');
        $pdf->SetAuthor('Clínica Veterinaria San Martin');
        $pdf->SetTitle('Historia Clínica');
        $pdf->SetMargins(15, 40, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);

        // ===== DATOS ESTÁTICOS =====
        $propietario = [
            'fecha' => date('d/m/Y'),
            'nombre' => $data['anamnesis']['nombre_completo'],
            'celular' => $data['anamnesis']['celular'],
            'direccion' => $data['anamnesis']['direccion'],
            'registro' => $data['anamnesis']['registro']
        ];

        $mascota = [
            'nombre' => $data['anamnesis']['nombre_mascota'],
            'especie' => $data['anamnesis']['animal'],
            'edad' => $this->formatEdad($data['anamnesis']['years'], $data['anamnesis']['meses']),
            'peso' => $data['anamnesis']['peso'],
            'color' => $data['anamnesis']['color'],
            'raza' => $data['anamnesis']['raza'],
            'genero' => $data['anamnesis']['genero'] ? ($data['anamnesis']['genero'] == 'M' ? 'Macho' : 'Hembra') : 'No especificado',
        ];

        $vacunas = $data['vacunas'];

        $anamnesis = $data['anamnesis'];

        $examen_general = $data['examen'];

        $sintomas = $data['sintomas'];

        $metodos_complementarios = array_map(function ($metodo) {
            return [
                'fecha_hora' => date('d/m/Y', strtotime($metodo['fecha_hora'])),
                // 'examen' => $metodo['examen'],
                'nombre_examen' => $metodo['nombre_examen'],
                'resultados' => $metodo['resultados']
            ];
        }, $data['metodos_complementarios']);

        $diagnostico_presuntivo = $data['diagnosticos_presuntivos'];
        $diagnostico_definitivo = $data['diagnosticos_definitivos'];

        $tratamientos = $data['tratamiento'];

        $evolucion = array_map(function ($evolucion) {
            return [
                'fecha_hora' => date('d/m/Y H:m', strtotime($evolucion['fecha_hora'])),
                'descripcion' => $evolucion['descripcion'],
            ];
        }, $data['evolucion']);

        // ===== GENERACIÓN DEL PDF =====
        $pdf->AddPage();

        $pdf->SetFont('ptserifb', 'B', 20);
        $pdf->SetY(27);
        $pdf->Cell(0, 6, 'HISTORIA CLÍNICA ', 0, 1, 'C');
        //$pdf->Ln(1);

        // 1. RESEÑA DEL PROPIETARIO
        $pdf->sectionTitle('1. RESEÑA DEL PROPIETARIO');

        $pdf->twoColumnRow('Fecha:', $propietario['fecha'], 'N° Registro:', $propietario['registro']);
        $pdf->twoColumnRow('Nombre:', $propietario['nombre'], 'Celular:', $propietario['celular']);
        $pdf->singleRow('Dirección:', $propietario['direccion']);
        $pdf->Ln(4);

        // 2. RESEÑA DE LA MASCOTA
        $pdf->sectionTitle('2. RESEÑA DE LA MASCOTA');

        $pdf->twoColumnRow('Nombre:', $mascota['nombre'], 'Especie:', $mascota['especie']);
        $pdf->twoColumnRow('Edad:', $mascota['edad'], 'Peso:', $mascota['peso']);
        $pdf->twoColumnRow('Color:', $mascota['color'], 'Raza:', $mascota['raza']);
        $pdf->singleRow('Género:', $mascota['genero']);
        $pdf->Ln(4);

        // 3. ANAMNESIS
        $pdf->sectionTitle('3. ANAMNESIS');
        $pdf->Ln(2);

        $pdf->labeledRow('Enfermedades Anteriores:', $anamnesis['enfermedades_anteriores']);
        $pdf->labeledRow('Tratamientos Recientes:', $anamnesis['tratamientos_recientes']);
        $pdf->labeledRow('Ultima Desparasitación:', $anamnesis['ultima_desparasitacion']);
        $pdf->labeledRow('Vacunas Anteriores:', $anamnesis['vacunas']);

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(0, 5, 'Control de Vacunas:', 0, 1, 'L');
        $pdf->Ln(1);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(42, 5, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(0, 5, 'Vacuna', 1, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 8);

        foreach ($vacunas as $key => $v) {
            $pdf->Cell(42, 5, date('d/m/Y', strtotime($v['fecha'])), 1);
            $pdf->Cell(0, 5, $v['nombre_vacuna'], 1, 1);
        }

        $pdf->Ln(4);

        // 4. EXAMEN GENERAL

        $pdf->sectionTitle('4. EXAMEN GENERAL');
        $pdf->Ln(2);


        // Tabla de examen general
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(30, 5, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(30, 5, 'Temperatura', 1, 0, 'C', true);
        $pdf->Cell(38, 5, "Frecuencia Cardiaca", 1, 0, 'C', true);
        $pdf->Cell(42, 5, "Frecuencia Respiratoria", 1, 0, 'C', true);
        $pdf->Cell(20, 5, 'R.C. x seg', 1, 0, 'C', true);
        $pdf->Cell(20, 5, 'Mucosa', 1, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 8);

        foreach ($examen_general as $key => $examen) {
            $pdf->Cell(30, 5, date('d/m/Y', strtotime($examen['fecha'])), 1);
            $pdf->Cell(30, 5, $examen['temperatura'] . ' °C', 1);
            $pdf->Cell(38, 5, $examen['frecuencia_cardiaca'], 1);
            $pdf->Cell(42, 5, $examen['frecuencia_respiratoria'], 1);
            $pdf->Cell(20, 5, $examen['rc'], 1);
            $pdf->Cell(20, 5, $examen['mucosa'], 1, 1);
        }
        $pdf->labeledRow('Inspección:', $anamnesis['inspeccion']);
        $pdf->labeledRow('Palpación:', $anamnesis['palpacion']);
        // $pdf->labeledRow('Observaciones:', $examen['observaciones']);
        $pdf->Ln(4);

        // 5. SÍNTOMAS
        $pdf->sectionTitle('5. SÍNTOMAS');
        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(30, 5, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(150, 5, 'Descripción', 1, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 8);

        foreach ($sintomas as $key => $s) {
            $pdf->Cell(30, 5, date('d/m/Y', strtotime($examen['fecha'])), 1);
            $pdf->MultiCell(150, 5, $s['descripcion'], 1, 1);
        }

        $pdf->Ln(4);

        // 6. MÉTODOS COMPLEMENTARIOS
        $pdf->sectionTitle('6. MÉTODOS COMPLEMENTARIOS');
        $pdf->Ln(2);

        $pdf->createTable(['Fecha', 'Tipo examen', 'Resultados'], $metodos_complementarios, [30, 55, 95]);
        $pdf->Ln(4);

        // 7. DIAGNÓSTICO PRESUNTIVO
        $pdf->sectionTitle('7. DIAGNÓSTICO PRESUNTIVO');
        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(30, 5, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(150, 5, 'Descripción', 1, 1, 'C', true);
        $pdf->SetFont('helvetica', '', 8);

        foreach ($diagnostico_presuntivo as $key => $d) {
            $pdf->Cell(30, 5, date('d/m/Y', strtotime($d['fecha'])), 1);
            $pdf->MultiCell(150, 5, $d['descripcion'], 1, 1);
        }

        $pdf->Ln(5);

        // 8. DIAGNÓSTICO DEFINITIVO

        $pdf->sectionTitle('8. DIAGNÓSTICO DEFINITIVO');
        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(30, 5, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(150, 5, 'Descripción', 1, 1, 'C', true);
        $pdf->SetFont('helvetica', '', 8);

        $pdf->SetTextColor(0);

        foreach ($diagnostico_definitivo as $key => $d) {
            $pdf->Cell(30, 5, date('d/m/Y', strtotime($d['fecha'])), 1);
            $pdf->MultiCell(150, 5, $d['descripcion'], 1, 1);
        }

        $pdf->Ln(5);

        // 9. TRATAMIENTO
        $pdf->sectionTitle('9. TRATAMIENTO');
        $pdf->Ln(2);

        $pdf->SetFillColor(58, 115, 111);
        $pdf->SetTextColor(255);
        $pdf->SetFont('helvetica', 'B', 8);

        $pdf->Cell(30, 6, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(150, 6, 'Descripción', 1, 1, 'C', true);
        $fill = false;

        $pdf->SetTextColor(0);
        $pdf->SetFont('helvetica', '', 8);

        foreach ($tratamientos as $t) {
            $pdf->SetFillColor($fill ? 240 : 255);
            $pdf->Cell(30, 6, date('d/m/Y', strtotime($t['fecha'])), 'LR', 0, 'L', $fill);
            $pdf->MultiCell(150, 6, $t['descripcion'], 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $fill = !$fill;
        }
        $pdf->Cell(180, 0, '', 'T');

        $pdf->Ln(5);

        // 10. EVOLUCIÓN Y PRONÓSTICO
        $pdf->sectionTitle('10. EVOLUCIÓN Y PRONÓSTICO');
        $pdf->Ln(2);

        $pdf->createTable(['Fecha y hora', 'Detalle'], $evolucion, [30, 150]);

        // Firma del veterinario
        $pdf->Ln(30);
        // $pdf->Cell(0, 5, '_________________________________________', 0, 1, 'C');
        $pdf->Cell(0, 5, str_repeat('.', 80), 0, 1, 'C');
        $pdf->Cell(0, 5, 'Firma medico veterinario', 0, 1, 'C');
        // $pdf->Cell(0, 5, 'Cédula Profesional: VET-12345', 0, 1, 'C');

        $pdf->Output('historia_clinica_veterinaria.pdf', 'I');
        exit;
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
}

class VeterinariaPDF extends TCPDF
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

    public function twoColumnRow($label1, $value1, $label2, $value2)
    {
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(25, 5, $label1, 0, 0);
        $this->SetFont('helvetica', '', 9);
        $this->Cell(60, 5, $value1, 0, 0);

        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(25, 5, $label2, 0, 0);
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, $value2, 0, 1);
    }

    public function singleRow($label, $value)
    {
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(25, 5, $label, 0, 0);
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, $value, 0, 1);
    }

    public function labeledRow($label, $value)
    {
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(45, 5, $label, 1, 0);
        $this->SetFont('helvetica', '', 9);
        $this->MultiCell(0, 5, $value, 1, 'L');
    }

    public function createTable($headers, $data, $columnWidths = null)
    {
        // Configurar encabezado
        $this->SetFillColor(58, 115, 111);
        $this->SetTextColor(255);
        $this->SetFont('helvetica', 'B', 9);

        // Calcular anchos
        $numColumns = count($headers);
        $pageWidth = $this->getPageWidth() - $this->lMargin - $this->rMargin;

        // Si no se especifican anchos, dividir equitativamente
        if ($columnWidths === null || count($columnWidths) !== $numColumns) {
            $columnWidth = $pageWidth / $numColumns;
            $columnWidths = array_fill(0, $numColumns, $columnWidth);
        }

        // dd($headers);

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
            $num = 0;
            foreach ($row as $i => $value) {
                if ($i == 'descripcion' || $i == 'resultados') { // Columna "Detalle"
                    $this->MultiCell($columnWidths[$num], 6, $value, 'LR', 'L', $fill);
                } else {
                    $this->Cell($columnWidths[$num], 6, $value, 'LR', 0, 'L', $fill);
                }
                $num++;
            }
            // $this->Ln();
            $fill = !$fill;
        }

        // Línea de cierre
        $this->Cell(array_sum($columnWidths), 0, '', 'T');
    }
}
