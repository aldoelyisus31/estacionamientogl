<?php

require_once '../src/models/VehicleTypeModel.php';

class VehicleTypeController {
    private $model;

    public function __construct($conn) {
        $this->model = new VehicleTypeModel($conn);
    }

    // Manejar solicitudes
    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';

        switch ($action) {
            case 'list':
                $this->listVehicleTypes();
                break;
            case 'add':
                $this->addVehicleType();
                break;
            case 'edit':
                $this->editVehicleType();
                break;
            case 'delete':
                $this->deleteVehicleType();
                break;
            default:
                $this->listVehicleTypes();
                break;
        }
    }

    // Listar todos los tipos de vehículos
    private function listVehicleTypes() {
        $types = $this->model->getAllVehicleTypes();
        include __DIR__ . '/../views/vehicle_type_list.php';
    }

    // Agregar un nuevo tipo de vehículo
    private function addVehicleType() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'];
            $rate = $_POST['rate'];
            $this->model->addVehicleType($type, $rate);
            header('Location: index.php?controller=VehicleType&action=list');
            exit();
        } else {
            include __DIR__ . '/../views/vehicle_type_add.php';
        }
    }

    private function editVehicleType() {
        $id = $_GET['id'] ?? null;

        if ($id === null) {
            die('ID no proporcionado.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? '';
            $rate = $_POST['rate'] ?? '';

            if (!empty($type) && is_numeric($rate)) {
                $this->model->updateVehicleType($id, $type, $rate);
                header('Location: index.php?controller=VehicleType&action=list');
                exit();
            } else {
                echo 'Por favor, complete todos los campos correctamente.';
            }
        } else {
            $type = $this->model->getVehicleTypeById($id);
            if ($type === null) {
                die('Tipo de vehículo no encontrado.');
            }
            include __DIR__ . '/../views/vehicle_type_edit.php';
        }
    }

    // Eliminar un tipo de vehículo
    private function deleteVehicleType() {
        $id = $_GET['id'];
        $this->model->deleteVehicleType($id);
        header('Location: index.php?controller=VehicleType&action=list');
        exit();
    }
}
?>
