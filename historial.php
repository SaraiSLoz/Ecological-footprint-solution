<?php
require 'database.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if ($id == null) {
    header("Location: index.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT a.id_aparato, d.nombre AS dispositivo, m.nombre AS modelo, dm.rango 
              FROM aparato a
              INNER JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
              INNER JOIN modelo m ON a.id_modelo = m.id_modelo
              INNER JOIN dispositivo_modelo dm ON m.id_modelo = dm.id_modelo
              WHERE a.id_aparato = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]); // Pasar $id como un array
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    
}      
?>

<!DOCTYPE html>
<html>
<head>
    <title>Huella de Carbono en Tiempo Real</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart" width="400" height="200"></canvas>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Huella de Carbono',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true
                    },
                    y: {
                        display: true
                    }
                }
            }
        });

        let intervalId = null;
        let daysCounter = 1;

        function agregarPunto(tiempo, huella) {
            chart.data.labels.push(tiempo);
            chart.data.datasets[0].data.push(huella);
            chart.update();
        }

        function detenerActualizacion() {
            clearInterval(intervalId);
        }

       let monthCounter = 0;

function obtenerDatosHuellaCarbono() {
  const currentDate = new Date();
  const currentYear = currentDate.getFullYear();
  const currentTime = new Date(currentYear, monthCounter, 1);
  const tiempo = currentTime.toLocaleTimeString([], { month: 'long' });
  monthCounter++;
  
  if (monthCounter > 12) {
    // Se ha completado el último mes del año
    // Detener la actualización del gráfico
    detenerActualizacion();
    return;
  }

  <?php if ($data['rango'] < 10): ?>
      const min = <?php echo $data['rango'] - 1; ?>;
      const max = <?php echo $data['rango'] + 1; ?>;
  <?php else: ?>
      const min = <?php echo $data['rango'] - 10; ?>;
      const max = <?php echo $data['rango'] + 10; ?>;
  <?php endif; ?>

  const potenciaPc = Math.floor(Math.random() * (max - min + 1)) + min;
  console.log(potenciaPc);

  const factorEmision = 0.41;
  const huellaCarbono = potenciaPc * factorEmision;

  agregarPunto(tiempo, huellaCarbono);
}

        function iniciarActualizacion() {
            startTime = performance.now();
            previousTime = startTime;
            intervalId = setInterval(obtenerDatosHuellaCarbono, 1000);
        }

        iniciarActualizacion();
    </script>
</body>
</html>
