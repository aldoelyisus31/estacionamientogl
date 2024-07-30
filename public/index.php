<?php
require_once '../config/database.php';
require_once '../src/controllers/VehicleTypeController.php';
require_once '../src/controllers/VehicleController.php';
require_once '../src/controllers/EntryController.php';
require_once '../src/controllers/ExitController.php';
require_once '../src/controllers/ReportController.php';
require_once '../src/models/MenuModel.php';
require_once __DIR__ . '/../vendor/autoload.php';



// Crear la conexión MySQLi
$servername = "localhost";
$database = "estacionamientogl";
$username = "root";
$password = "";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la acción solicitada
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Report';

// Determinar el controlador y la acción
switch ($controller) {
    case 'VehicleType':
        $controllerInstance = new VehicleTypeController($conn);
        break;
    case 'Vehicle':
        $controllerInstance = new VehicleController($conn);
        break;
    case 'Entry':
        $controllerInstance = new EntryController($conn);
        break;
    case 'Exit':
        $controllerInstance = new ExitController($conn);
        break;
    case 'Report':
        $controllerInstance = new ReportController($conn);
        break;
    default:
        $controllerInstance = new EntryController($conn);
        break;
}

// Ejecutar la acción correspondiente
ob_start();
$controllerInstance->handleRequest();
$content = ob_get_clean();

// Obtener los elementos del menú
$menuModel = new MenuModel($conn);
$menuItems = $menuModel->getMenuItems();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Navegación</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .nav-bar {
            background-color: #f4f4f4;
            border-bottom: 2px solid #ddd;
            padding: 10px;
            position: fixed;
            top: 60px; /* Ajusta para que esté justo debajo del encabezado */
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .nav-bar a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            margin-right: 10px;
            font-weight: bold;
            border-radius: 4px;
        }
        .nav-bar a:hover {
            background-color: #e0e0e0;
        }
        .container {
            margin-top: 120px; /* Espacio para el encabezado y la barra de navegación */
            display: flex;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">Sistema de Gestión de Estacionamiento</div>
    <div class="nav-bar">
        <?php foreach ($menuItems as $item): ?>
            <a href="?controller=<?php echo htmlspecialchars($item['controller']); ?>&action=<?php echo htmlspecialchars($item['action']); ?>">
                <?php echo htmlspecialchars($item['label']); ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="container">
        <div class="content">
            <?php echo $content; ?>
        </div>
    </div>
</body>
</html>




