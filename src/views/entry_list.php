<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Entradas</title>
</head>
<body>
    <h1>Lista de Entradas</h1>
    <form action="index.php" method="get">
        <input type="hidden" name="controller" value="Entry">
        <input type="hidden" name="action" value="list">
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
                <th>Fecha y Hora de Entrada</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $entry): ?>
                <tr>
                    <td><?= htmlspecialchars($entry['id']) ?></td>
                    <td><?= htmlspecialchars($entry['num_placa']) ?></td>
                    <td><?= htmlspecialchars($entry['fecha_hora_entrada']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php?controller=Entry&action=add_entry">Agregar Entrada</a>
</body>
</html>

