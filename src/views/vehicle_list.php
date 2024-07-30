<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Vehículos</title>
</head>
<body>
    <h1>Lista de Vehículos</h1>
    <a href="index.php?controller=Vehicle&action=add">Agregar Nuevo Vehículo</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vehicles)): ?>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vehicle['id']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['num_placa']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['tipo_vehiculo']); ?></td> <!-- Usar alias correcto -->
                        <td>
                            <a href="index.php?controller=Vehicle&action=edit&id=<?php echo $vehicle['id']; ?>">Editar</a>
                            <a href="index.php?controller=Vehicle&action=delete&id=<?php echo $vehicle['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este vehículo?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay vehículos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="index.php">Volver al menú principal</a>
</body>
</html>




