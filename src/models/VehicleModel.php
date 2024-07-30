<?php
// src/models/VehicleModel.php

class VehicleModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todos los vehículos
    public function getAllVehicles() {
        $query = "SELECT * FROM vehiculos";
        $result = $this->conn->query($query);

        if ($result === false) {
            die('Error en la consulta: ' . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener todos los vehículos con el nombre del tipo de vehículo
    public function getAllVehiclesWithType() {
        $query = "
            SELECT v.id, v.num_placa, t.tipo AS tipo_vehiculo
            FROM vehiculos v
            INNER JOIN tipos_vehiculos t ON v.tipo_vehiculo_id = t.id
        ";
        $result = $this->conn->query($query);

        if (!$result) {
            die('Error en la consulta: ' . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener un vehículo por su ID
    public function getVehicleById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM vehiculos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Agregar un nuevo vehículo
    public function addVehicle($num_placa, $tipo_vehiculo_id) {
        $stmt = $this->conn->prepare("INSERT INTO vehiculos (num_placa, tipo_vehiculo_id) VALUES (?, ?)");
        $stmt->bind_param("si", $num_placa, $tipo_vehiculo_id);
        $stmt->execute();
    }

    // Actualizar un vehículo existente
    public function updateVehicle($id, $num_placa, $tipo_vehiculo_id) {
        $stmt = $this->conn->prepare("UPDATE vehiculos SET num_placa = ?, tipo_vehiculo_id = ? WHERE id = ?");
        $stmt->bind_param("sii", $num_placa, $tipo_vehiculo_id, $id);
        $stmt->execute();
    }

    // Eliminar un vehículo
    public function deleteVehicle($id) {
        $stmt = $this->conn->prepare("DELETE FROM vehiculos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>
