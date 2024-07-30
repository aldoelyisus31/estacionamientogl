<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Salida</title>
</head>
<body>
    <h1>Agregar Salida</h1>
    <form action="index.php?controller=Exit&action=add_exit" method="post">
        <label for="num_placa">Número de Placa:</label>
        <input type="text" id="num_placa" name="num_placa" required>
        <br>
        <label for="fecha_hora_salida">Fecha y Hora de Salida:</label>
        <input type="datetime-local" id="fecha_hora_salida" name="fecha_hora_salida" required>
        <br>
        <input type="submit" value="Agregar">
    </form>
    <a href="index.php?controller=Exit&action=list_exits">Volver a la lista</a>
</body>
</html>

