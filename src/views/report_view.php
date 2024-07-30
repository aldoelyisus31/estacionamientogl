<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Entradas y Salidas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte de Entradas y Salidas</h1>
    <a href="index.php?controller=Report&action=download_pdf&start_date=<?php echo htmlspecialchars($startDate); ?>&end_date=<?php echo htmlspecialchars($endDate); ?>">Descargar Reporte en PDF</a>
    <br>
    <a href="index.php?controller=Report&action=download&start_date=<?php echo htmlspecialchars($startDate); ?>&end_date=<?php echo htmlspecialchars($endDate); ?>">Descargar Reporte en Excel</a>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>Placa</th>
                <th>Fecha y Hora de Entrada</th>
                <th>Fecha y Hora de Salida</th>
                <th>Tipo de Vehículo</th>
                <th>Monto Pagado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($entriesAndExits)): ?>
                <?php foreach ($entriesAndExits as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['num_placa']); ?></td>
                        <td><?php echo htmlspecialchars($record['fecha_hora_entrada']); ?></td>
                        <td><?php echo htmlspecialchars($record['fecha_hora_salida']); ?></td>
                        <td><?php echo htmlspecialchars($record['tipo_vehiculo']); ?></td>
                        <td><?php echo number_format($record['amount_paid'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay datos disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
