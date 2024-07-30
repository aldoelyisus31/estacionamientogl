<?php

require_once '../src/models/EntryModel.php';

class EntryController {
    private $model;

    public function __construct($conn) {
        $this->model = new EntryModel($conn);
    }

    // Manejar solicitudes
    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list_entries';

        switch ($action) {
            case 'list_entries':
                $this->listEntries();
                break;
            case 'add_entry':
                $this->addEntry();
                break;
            default:
                $this->listEntries();
                break;
        }
    }

    // Listar todas las entradas
    private function listEntries() {
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

        if ($startDate && $endDate) {
            $entries = $this->model->getEntriesByDateRange($startDate, $endDate);
        } else {
            $entries = $this->model->getAllEntries();
        }

        include __DIR__ . '/../views/entry_list.php';
    }

    // Agregar una nueva entrada
    private function addEntry() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numPlaca = $_POST['num_placa'];
            $fechaHoraEntrada = $_POST['fecha_hora_entrada'];
            $this->model->addEntry($numPlaca, $fechaHoraEntrada);
            header('Location: index.php?controller=Entry&action=list_entries');
            exit();
        } else {
            include __DIR__ . '/../views/entry_add.php';
        }
    }
}
?>

