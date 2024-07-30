<?php

require_once '../src/models/ExitModel.php';

class ExitController {
    private $model;

    public function __construct($conn) {
        $this->model = new ExitModel($conn);
    }

    // Manejar solicitudes
    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list_exits';

        switch ($action) {
            case 'list_exits':
                $this->listExits();
                break;
            case 'add_exit':
                $this->addExit();
                break;
            default:
                $this->listExits();
                break;
        }
    }

    // Listar todas las salidas
    private function listExits() {
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

        if ($startDate && $endDate) {
            $exits = $this->model->getExitsByDateRange($startDate, $endDate);
        } else {
            $exits = $this->model->getAllExits();
        }

        include __DIR__ . '/../views/exit_list.php';
    }

    // Agregar una nueva salida
    private function addExit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numPlaca = $_POST['num_placa'];
            $fechaHoraSalida = $_POST['fecha_hora_salida'];
            $this->model->addExit($numPlaca, $fechaHoraSalida);
            header('Location: index.php?controller=Exit&action=list_exits');
            exit();
        } else {
            include __DIR__ . '/../views/exit_add.php';
        }
    }
}
?>

