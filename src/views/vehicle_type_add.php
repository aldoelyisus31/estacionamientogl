<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Tipo de Vehículo</title>
</head>
<body>
    <h1>Agregar Tipo de Vehículo</h1>
    <form action="index.php?controller=VehicleType&action=add" method="post">
        <label for="type">Tipo:</label>
        <input type="text" id="type" name="type" required>
        <br>
        <label for="rate">Tarifa:</label>
        <input type="number" id="rate" name="rate" step="0.01" required>
        <br>
        <input type="submit" value="Agregar">
    </form>
    <a href="index.php?controller=VehicleType&action=list">Volver a la lista</a>
</body>
</html>


