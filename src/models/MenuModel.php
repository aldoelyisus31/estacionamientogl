<?php
class MenuModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getMenuItems() {
        // Aquí puedes hacer una consulta a la base de datos si los elementos están en una tabla.
        // Por ahora, vamos a usar un menú estático para simplificar.
        return [
            ['label' => 'Entradas', 'controller' => 'Entry', 'action' => 'index'],
            ['label' => 'Salidas', 'controller' => 'Exit', 'action' => 'index'],
            ['label' => 'Tipos de Vehículos', 'controller' => 'VehicleType', 'action' => 'index'],
            ['label' => 'Vehículos', 'controller' => 'Vehicle', 'action' => 'index'],
            ['label' => 'Reportes', 'controller' => 'Report', 'action' => 'index'],
        ];
    }
}
