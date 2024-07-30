<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tipos de Vehículos</title>
</head>
<body>
    <h1>Lista de Tipos de Vehículos</h1>
    <a href="index.php?controller=VehicleType&action=add">Agregar Nuevo Tipo de Vehículo</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Tarifa</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types as $type): ?>
                <tr>
                    <td><?php echo htmlspecialchars($type['id']); ?></td>
                    <td><?php echo htmlspecialchars($type['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($type['tarifa_minuto']); ?></td>
                    <td>
                        <a href="index.php?controller=VehicleType&action=edit&id=<?php echo $type['id']; ?>">Editar</a>
                        <a href="index.php?controller=VehicleType&action=delete&id=<?php echo $type['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este tipo de vehículo?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php">Volver al menú principal</a>
</body>
</html>


