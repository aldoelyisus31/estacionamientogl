<?php

class ExitModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todas las salidas
    public function getAllExits($startDate = null, $endDate = null) {
        $query = "SELECT * FROM salidas";
        if ($startDate && $endDate) {
            $query .= " WHERE fecha_hora_salida BETWEEN ? AND ?";
        }
        $stmt = $this->conn->prepare($query);
        if ($startDate && $endDate) {
            $stmt->bind_param("ss", $startDate, $endDate);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener salidas por rango de fechas
    public function getExitsByDateRange($startDate, $endDate) {
        $endDate = date('Y-m-d 23:59:59', strtotime($endDate)); 
        $stmt = $this->conn->prepare("SELECT * FROM salidas WHERE fecha_hora_salida BETWEEN ? AND ?");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Agregar una nueva salida
    public function addExit($numPlaca, $fechaHoraSalida) {
        $stmt = $this->conn->prepare("INSERT INTO salidas (num_placa, fecha_hora_salida) VALUES (?, ?)");
        $stmt->bind_param("ss", $numPlaca, $fechaHoraSalida);
        $stmt->execute();
    }
}


