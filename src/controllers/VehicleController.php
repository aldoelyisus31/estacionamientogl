<?php

require_once '../src/models/VehicleModel.php';
require_once '../src/models/VehicleTypeModel.php';

class VehicleController {
    private $model;
    private $typeModel;

    public function __construct($conn) {
        $this->model = new VehicleModel($conn);
        $this->typeModel = new VehicleTypeModel($conn);
    }

    // Manejar solicitudes
    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';

        switch ($action) {
            case 'list':
                $this->listVehicles();
                break;
            case 'add':
                $this->addVehicle();
                break;
            case 'edit':
                $this->editVehicle();
                break;
            case 'delete':
                $this->deleteVehicle();
                break;
            default:
                $this->listVehicles();
                break;
        }
    }

    // Listar todos los vehículos
    private function listVehicles() {
        $vehicles = $this->model->getAllVehiclesWithType();
        include __DIR__ . '/../views/vehicle_list.php';
    }

    // Agregar un nuevo vehículo
    private function addVehicle() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $num_placa = $_POST['num_placa'];
            $tipo_vehiculo_id = $_POST['tipo_vehiculo_id'];
            $this->model->addVehicle($num_placa, $tipo_vehiculo_id);
            header('Location: index.php?controller=Vehicle&action=list');
            exit();
        } else {
            $types = $this->typeModel->getAllVehicleTypes();
            include __DIR__ . '/../views/vehicle_add.php';
        }
    }

    // Editar un vehículo existente
    private function editVehicle() {
        $id = $_GET['id'] ?? null;

        // Verifica que el ID esté presente en la URL
        if ($id === null) {
            die('ID no proporcionado.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $num_placa = $_POST['num_placa'] ?? '';
            $tipo_vehiculo_id = $_POST['tipo_vehiculo_id'] ?? '';

            if (!empty($num_placa) && is_numeric($tipo_vehiculo_id)) {
                $this->model->updateVehicle($id, $num_placa, $tipo_vehiculo_id);
                header('Location: index.php?controller=Vehicle&action=list');
                exit();
            } else {
                echo 'Por favor, complete todos los campos correctamente.';
            }
        } else {
            $vehicle = $this->model->getVehicleById($id);
            if ($vehicle === null) {
                die('Vehículo no encontrado.');
            }
            $types = $this->typeModel->getAllVehicleTypes();
            include __DIR__ . '/../views/vehicle_edit.php';
        }
    }

    // Eliminar un vehículo
    private function deleteVehicle() {
        $id = $_GET['id'];
        $this->model->deleteVehicle($id);
        header('Location: index.php?controller=Vehicle&action=list');
        exit();
    }
}
?>

