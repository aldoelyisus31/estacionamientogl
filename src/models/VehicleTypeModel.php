<?php
// src/models/VehicleTypeModel.php

class VehicleTypeModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todos los tipos de vehículos
    public function getAllVehicleTypes() {
        $query = "SELECT * FROM tipos_vehiculos";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener un tipo de vehículo por su ID
    public function getVehicleTypeById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tipos_vehiculos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Agregar un nuevo tipo de vehículo
    public function addVehicleType($type, $rate) {
        $stmt = $this->conn->prepare("INSERT INTO tipos_vehiculos (tipo, tarifa_minuto) VALUES (?, ?)");
        $stmt->bind_param("sd", $type, $rate);
        $stmt->execute();
    }

    public function updateVehicleType($id, $type, $rate) {
        $stmt = $this->conn->prepare("UPDATE tipos_vehiculos SET tipo = ?, tarifa_minuto = ? WHERE id = ?");
        
        if (!$stmt) {
            die('Error al preparar la consulta: ' . $this->conn->error);
        }
    
        $stmt->bind_param("sdi", $type, $rate, $id);
    
        if ($stmt->execute()) {
            echo "Actualización exitosa.";
        } else {
            echo 'Error al ejecutar la consulta: ' . $stmt->error;
        }
    
        $stmt->close();
    }
    

    // Eliminar un tipo de vehículo
    public function deleteVehicleType($id) {
        $stmt = $this->conn->prepare("DELETE FROM tipos_vehiculos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
