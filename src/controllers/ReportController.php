<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/ReportModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class ReportController {
    private $model;

    public function __construct($conn) {
        $this->model = new ReportModel($conn);
    }

    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'view';
        switch ($action) {
            case 'view':
                $this->viewReport();
                break;
            case 'download':
                $this->downloadExcelReport();
                break;
            case 'download_pdf':
                $this->downloadPDFReport();
                break;
            default:
                $this->viewReport();
                break;
        }
    }

    private function viewReport() {
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');
        $entriesAndExits = $this->model->getEntriesAndExitsByDateRange($startDate, $endDate);

        $processedRecords = [];
        foreach ($entriesAndExits as $record) {
            if (!isset($processedRecords[$record['num_placa']])) {
                $processedRecords[$record['num_placa']] = $record;
                if ($record['fecha_hora_salida']) {
                    $entryTime = strtotime($record['fecha_hora_entrada']);
                    $exitTime = strtotime($record['fecha_hora_salida']);
                    $timeDiff = $exitTime - $entryTime;
                    $minutes = ceil($timeDiff / 60);
                    $processedRecords[$record['num_placa']]['amount_paid'] = $minutes * $record['tarifa_minuto'];
                } else {
                    $processedRecords[$record['num_placa']]['amount_paid'] = 0;
                }
            }
        }

        $entriesAndExits = array_values($processedRecords);
        include __DIR__ . '/../views/report_view.php';
    }

    private function downloadExcelReport() {
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');
        $entriesAndExits = $this->model->getEntriesAndExitsByDateRange($startDate, $endDate);

        foreach ($entriesAndExits as &$record) {
            if ($record['fecha_hora_salida']) {
                $entryTime = strtotime($record['fecha_hora_entrada']);
                $exitTime = strtotime($record['fecha_hora_salida']);
                $timeDiff = $exitTime - $entryTime;
                $minutes = ceil($timeDiff / 60);
                $record['amount_paid'] = $minutes * $record['tarifa_minuto'];
            } else {
                $record['amount_paid'] = 0;
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Número de Placa');
        $sheet->setCellValue('B1', 'Fecha y Hora de Entrada');
        $sheet->setCellValue('C1', 'Fecha y Hora de Salida');
        $sheet->setCellValue('D1', 'Tipo de Vehículo');
        $sheet->setCellValue('E1', 'Monto Pagado');

        $row = 2;
        foreach ($entriesAndExits as $record) {
            $sheet->setCellValue('A' . $row, $record['num_placa']);
            $sheet->setCellValue('B' . $row, $record['fecha_hora_entrada']);
            $sheet->setCellValue('C' . $row, $record['fecha_hora_salida']);
            $sheet->setCellValue('D' . $row, $record['tipo_vehiculo']);
            $sheet->setCellValue('E' . $row, $record['amount_paid']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'reporte_entradas_salidas.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    private function downloadPDFReport() {
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');
        $entriesAndExits = $this->model->getEntriesAndExitsByDateRange($startDate, $endDate);

        foreach ($entriesAndExits as &$record) {
            if ($record['fecha_hora_salida']) {
                $entryTime = strtotime($record['fecha_hora_entrada']);
                $exitTime = strtotime($record['fecha_hora_salida']);
                $timeDiff = $exitTime - $entryTime;
                $minutes = ceil($timeDiff / 60);
                $record['amount_paid'] = $minutes * $record['tarifa_minuto'];
            } else {
                $record['amount_paid'] = 0;
            }
        }

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = '<h1>Reporte de Entradas y Salidas</h1>
                 <table border="1" cellpadding="4">
                     <thead>
                         <tr>
                             <th>Placa</th>
                             <th>Fecha y Hora de Entrada</th>
                             <th>Fecha y Hora de Salida</th>
                             <th>Tipo de Vehículo</th>
                             <th>Monto Pagado</th>
                         </tr>
                     </thead>
                     <tbody>';
        foreach ($entriesAndExits as $record) {
            $html .= '<tr>
                          <td>' . htmlspecialchars($record['num_placa']) . '</td>
                          <td>' . htmlspecialchars($record['fecha_hora_entrada']) . '</td>
                          <td>' . htmlspecialchars($record['fecha_hora_salida']) . '</td>
                          <td>' . htmlspecialchars($record['tipo_vehiculo']) . '</td>
                          <td>' . number_format($record['amount_paid'], 2) . '</td>
                      </tr>';
        }
        $html .= '</tbody>
                  </table>';

        $pdf->writeHTML($html);
        $pdf->Output('reporte_entradas_salidas.pdf', 'D');
    }
}

?>



