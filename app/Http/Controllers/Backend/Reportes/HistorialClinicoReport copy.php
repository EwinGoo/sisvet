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

        // dd($data,$id);

        echo '<pre>';
        echo json_encode($data, JSON_PRETTY_PRINT); // Formato JSON ordenado
        echo '</pre>';
        exit;

        // dd($historial);
        // dd($vacunas);
        // Verificar si el ID de la mascota es válido
        if (!$mascota) {
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
            'nombre' => 'Juan Carlos Pérez López',
            'celular' => '7777-8888',
            'direccion' => 'Av. Central #123',
            'registro' => 'VET-2023-001234'
        ];

        $mascota = [
            'nombre' => 'Firulais',
            'especie' => 'Canino',
            'edad' => '5 años',
            'peso' => '12.5 kg',
            'color' => 'Blanco con manchas café',
            'raza' => 'Mestizo',
            'genero' => 'Macho'
        ];

        $anamnesis = [
            'enfermedades_anteriores' => "Moquillo a los 2 años",
            'tratamientos_recientes' => "Antibióticos (Amoxicilina) hace 3 meses",
            'ultima_desparacitacion' => '15/05/2023',
            'vacunas' => "Vacuna Antirrabica",
            'fechav' => '08/06/2023'
        ];

        $examen_general = [
            'fecha' => date('d/m/Y'),
            'temperatura' => '38.5°C',
            'frecuencia_cardiaca' => '90 lpm',
            'frecuencia_respiratoria' => '25 rpm',
            'color_encias' => 'Rosado pálido',
            'mucosa' => 'Húmeda',
            'rc_segundo' => 'Normal',
            'inspeccion' => 'Pelaje opaco',
            'palpacion' => 'Abdomen blando no doloroso',
            'observaciones' => 'Leve cojera en la pata delantera derecha'
        ];

        $sintomas = [
            'vomito' => 'Ocasional (2 veces en la semana)',
            'diarrea' => 'No presenta',
            'apetito' => 'Disminuido',
            'sed' => 'Normal',
            'actividad' => 'Disminuida'
        ];

        $metodos_complementarios = [
            ['fecha' => date('d/m/Y'), 'examen' => 'Hemograma completo', 'resultados' => 'Leucocitos elevados (18,000)'],
            ['fecha' => date('d/m/Y'), 'examen' => 'Radiografía torácica', 'resultados' => 'Sin hallazgos relevantes']
        ];

        $diagnostico = [
            'fecha' => date('d/m/Y'),
            'presuntivo' => 'Gastritis aguda',
            'definitivo' => 'Gastritis crónica por Helicobacter spp.'
        ];

        $medicamentos = [
            ['fecha' => date('d/m/Y'), 'medicamento' => 'Omeprazol 10mg', 'dosis' => '1/2 tableta cada 24h por 7 días'],
            ['fecha' => date('d/m/Y'), 'medicamento' => 'Metronidazol 250mg', 'dosis' => '1 tableta cada 12h por 10 días']
        ];

        $evolucion = [
            ['fecha' => date('d/m/Y'), 'hora' => '10:00', 'detalle' => 'Paciente ingresó con vómitos y decaimiento'],
            ['fecha' => date('d/m/Y'), 'hora' => '16:00', 'detalle' => 'Mejoría parcial, toleró líquidos']
        ];

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

        $pdf->labeledRow('Enfermedades Anteriores:', $anamnesis['enfermedades_anteriores']);
        $pdf->labeledRow('Tratamientos Recientes:', $anamnesis['tratamientos_recientes']);

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(0, 5, 'Control de Vacunas:', 0, 1, 'L');
        $pdf->Ln(1);

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(20, 5, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(0, 5, 'Descripción', 1, 1, 'C', true);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(20, 5, $anamnesis['fechav'], 1);
        $pdf->Cell(0, 5, $anamnesis['vacunas'], 1, 1);
        $pdf->Ln(1);

        $pdf->labeledRow('Última Desparasitación:', $anamnesis['ultima_desparacitacion']);
        $pdf->Ln(4);

        // 4. EXAMEN GENERAL
        $pdf->sectionTitle('4. EXAMEN GENERAL');
        $pdf->Ln(2);


        // Tabla de examen general
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(25, 5, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(25, 5, 'Temperatura', 1, 0, 'C', true);
        $pdf->Cell(33, 5, "Frecuencia Cardiaca", 1, 0, 'C', true);
        $pdf->Cell(37, 5, "Frecuencia Respiratoria", 1, 0, 'C', true);
        $pdf->Cell(20, 5, 'R.C. x seg', 1, 0, 'C', true);
        $pdf->Cell(25, 5, 'Color Encías', 1, 0, 'C', true);
        $pdf->Cell(15, 5, 'Mucosa', 1, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(25, 5, $examen_general['fecha'], 1);
        $pdf->Cell(25, 5, $examen_general['temperatura'], 1);
        $pdf->Cell(33, 5, $examen_general['frecuencia_cardiaca'], 1);
        $pdf->Cell(37, 5, $examen_general['frecuencia_respiratoria'], 1);
        $pdf->Cell(20, 5, $examen_general['rc_segundo'], 1);
        $pdf->Cell(25, 5, $examen_general['color_encias'], 1);
        $pdf->Cell(15, 5, $examen_general['mucosa'], 1, 1);
        $pdf->Ln(2);

        $pdf->labeledRow('Inspección:', $examen_general['inspeccion']);
        $pdf->labeledRow('Palpación:', $examen_general['palpacion']);
        $pdf->labeledRow('Observaciones:', $examen_general['observaciones']);
        $pdf->Ln(4);

        // 5. SÍNTOMAS
        $pdf->sectionTitle('5. SÍNTOMAS');

        $pdf->labeledRow('Vómito:', $sintomas['vomito']);
        $pdf->labeledRow('Diarrea:', $sintomas['diarrea']);
        $pdf->labeledRow('Apetito:', $sintomas['apetito']);
        $pdf->labeledRow('Sed:', $sintomas['sed']);
        $pdf->labeledRow('Actividad:', $sintomas['actividad']);
        $pdf->Ln(4);

        // 6. MÉTODOS COMPLEMENTARIOS
        $pdf->sectionTitle('6. MÉTODOS COMPLEMENTARIOS');
        $pdf->Ln(2);

        $pdf->createTable(['Fecha', 'Examen', 'Resultados'], $metodos_complementarios);
        $pdf->Ln(4);

        // 7. DIAGNÓSTICO
        $pdf->sectionTitle('7. DIAGNÓSTICO PRESUNTIVO/DEFINITIVO');
        $pdf->Ln(2);

        $pdf->labeledRow('Fecha:', $diagnostico['fecha']);
        $pdf->labeledRow('Diagnóstico presuntivo:', $diagnostico['presuntivo']);
        $pdf->labeledRow('Diagnóstico definitivo:', $diagnostico['definitivo']);
        $pdf->Ln(5);

        // 8. ADMINISTRACIÓN DE MEDICAMENTOS
        $pdf->sectionTitle('8. ADMINISTRACIÓN DE MEDICAMENTOS');
        $pdf->Ln(2);

        $pdf->createTable(['Fecha', 'Medicamento', 'Dosis'], $medicamentos);
        $pdf->Ln(5);

        // 9. EVOLUCIÓN Y PRONÓSTICO
        $pdf->sectionTitle('9. EVOLUCIÓN Y PRONÓSTICO');
        $pdf->Ln(2);

        $pdf->createTable(['Fecha', 'Hora', 'Detalle'], $evolucion);

        // Firma del veterinario
        $pdf->Ln(30);
        $pdf->Cell(0, 5, '_________________________________________', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Dr. Carlos Méndez - MVZ', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Cédula Profesional: VET-12345', 0, 1, 'C');

        $pdf->Output('historia_clinica_veterinaria.pdf', 'I');
        exit;
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
        $this->Cell(280, 10, 'CLÍNICA VETERINARIA SAN MARTIN', 0, 1, 'C');

        // Información de contacto
        $this->SetFont('helvetica', '', 9);
        $this->Cell(280, 5, 'Tel: 2222-5555 | Emergencias: 7777-8888 | Av. Central #123', 0, 1, 'C');

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
        $this->Cell(40, 5, $label, 1, 0);
        $this->SetFont('helvetica', '', 9);
        $this->MultiCell(0, 5, $value, 1, 'L');
    }

    public function createTable($headers, $data)
    {
        // Configurar encabezado
        $this->SetFillColor(58, 115, 111);
        $this->SetTextColor(255);
        $this->SetFont('helvetica', 'B', 9);

        // Calcular anchos
        $numColumns = count($headers);
        $pageWidth = $this->getPageWidth() - $this->lMargin - $this->rMargin;
        $columnWidth = $pageWidth / $numColumns;

        // Dibujar encabezados
        foreach ($headers as $header) {
            $this->Cell($columnWidth, 6, $header, 1, 0, 'C', true);
        }
        $this->Ln();

        // Dibujar datos
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 9);
        $fill = false;

        foreach ($data as $row) {
            $this->SetFillColor($fill ? 240 : 255);

            foreach ($row as $value) {
                $this->Cell($columnWidth, 6, $value, 'LR', 0, 'L', $fill);
            }
            $this->Ln();
            $fill = !$fill;
        }

        // Línea de cierre
        $this->Cell($columnWidth * $numColumns, 0, '', 'T');
    }
}
