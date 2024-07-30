<?php

class EntryModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todas las entradas
    public function getAllEntries() {
        $sql = "SELECT * FROM entradas";
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener entradas por rango de fechas
    public function getEntriesByDateRange($startDate, $endDate) {
        $sql = "SELECT * FROM entradas WHERE fecha_hora_entrada BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Agregar una nueva entrada
    public function addEntry($numPlaca, $fechaHoraEntrada) {
        $sql = "INSERT INTO entradas (num_placa, fecha_hora_entrada) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $numPlaca, $fechaHoraEntrada);
        $stmt->execute();
    }
}
?>

