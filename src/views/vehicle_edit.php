<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>
</head>
<body>
    <h1>Editar Vehículo</h1>
    <form action="index.php?controller=Vehicle&action=edit&id=<?php echo htmlspecialchars($vehicle['id']); ?>" method="post">
        <label for="num_placa">Número de Placa:</label>
        <input type="text" id="num_placa" name="num_placa" value="<?php echo htmlspecialchars($vehicle['num_placa']); ?>" required>
        <br>
        <label for="tipo_vehiculo_id">Tipo de Vehículo:</label>
        <select id="tipo_vehiculo_id" name="tipo_vehiculo_id" required>
            <?php foreach ($types as $type): ?>
                <option value="<?php echo htmlspecialchars($type['id']); ?>" <?php echo ($type['id'] == $vehicle['tipo_vehiculo_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($type['tipo']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="Actualizar">
    </form>
    <a href="index.php?controller=Vehicle&action=list">Volver a la lista</a>
</body>
</html>

