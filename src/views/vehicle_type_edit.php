<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tipo de Vehículo</title>
</head>
<body>
    <h1>Editar Tipo de Vehículo</h1>
    <form action="index.php?controller=VehicleType&action=edit&id=<?php echo htmlspecialchars($type['id']); ?>" method="post">
        <label for="type">Tipo:</label>
        <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($type['tipo']); ?>" required>
        <br>
        <label for="rate">Tarifa:</label>
        <input type="number" id="rate" name="rate" step="0.01" value="<?php echo htmlspecialchars($type['tarifa_minuto']); ?>" required>
        <br>
        <input type="submit" value="Actualizar">
    </form>
    <a href="index.php?controller=VehicleType&action=list">Volver a la lista</a>
</body>
</html>


