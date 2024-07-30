<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Entrada</title>
</head>
<body>
    <h1>Agregar Entrada</h1>
    <form action="index.php?controller=Entry&action=add_entry" method="post">
        <label for="num_placa">Número de Placa:</label>
        <input type="text" id="num_placa" name="num_placa" required>
        <br>
        <label for="fecha_hora_entrada">Fecha y Hora de Entrada:</label>
        <input type="datetime-local" id="fecha_hora_entrada" name="fecha_hora_entrada" required>
        <br>
        <input type="submit" value="Agregar">
    </form>
    <a href="index.php?controller=Entry&action=list_entries">Volver a la lista</a>
</body>
</html>


