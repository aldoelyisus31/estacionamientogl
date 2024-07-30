<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Salidas</title>
</head>
<body>
    <h1>Lista de Salidas</h1>
    <form action="index.php" method="get">
        <input type="hidden" name="controller" value="Exit">
        <input type="hidden" name="action" value="list_exits">
        <label for="start_date">Fecha de Inicio:</label>
        <input type="date" id="start_date" name="start_date">
        <label for="end_date">Fecha de Fin:</label>
        <input type="date" id="end_date" name="end_date">
        <input type="submit" value="Filtrar">
    </form>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Placa</th>
                <th>Fecha y Hora de Salida</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($exits)): ?>
                <?php foreach ($exits as $exit): ?>
                    <tr>
                        <td><?= htmlspecialchars($exit['id']) ?></td>
                        <td><?= htmlspecialchars($exit['num_placa']) ?></td>
                        <td><?= htmlspecialchars($exit['fecha_hora_salida']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No se encontraron salidas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="index.php?controller=Exit&action=add_exit">Agregar Salida</a>
</body>
</html>


