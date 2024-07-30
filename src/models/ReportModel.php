<?php

class ReportModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getEntriesAndExitsByDateRange($startDate, $endDate) {
        $query = "
            SELECT e.num_placa, e.fecha_hora_entrada, s.fecha_hora_salida, tv.tipo AS tipo_vehiculo, tv.tarifa_minuto
            FROM entradas e
            LEFT JOIN salidas s ON e.num_placa = s.num_placa 
                AND s.fecha_hora_salida = (
                    SELECT MIN(fecha_hora_salida)
                    FROM salidas
                    WHERE num_placa = e.num_placa 
                    AND fecha_hora_salida > e.fecha_hora_entrada
                )
            LEFT JOIN vehiculos v ON e.num_placa = v.num_placa
            LEFT JOIN tipos_vehiculos tv ON v.tipo_vehiculo_id = tv.id
            WHERE e.fecha_hora_entrada BETWEEN ? AND ?
            ORDER BY e.num_placa, e.fecha_hora_entrada
        ";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>





