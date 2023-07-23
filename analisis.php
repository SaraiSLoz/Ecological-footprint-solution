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
    <button id="startButton">Iniciar</button>
    <button id="stopButton">Detener</button>
    <button id="resetButton">Reiniciar</button>

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
        let startTime = null;
        let previousTime = null;
        let accumulatedHuellaCarbono = 0;

        function agregarPunto(tiempo, huella) {
            chart.data.labels.push(tiempo);
            chart.data.datasets[0].data.push(huella);
            chart.update();
        }

        function obtenerDatosHuellaCarbono() {
            
            // Obtener la potencia de la PC
            var min = <?php echo $data['rango'] - 10; ?>;
            var max = <?php echo $data['rango'] + 10; ?>;
            var potenciaPc = Math.floor(Math.random() * (max - min + 1)) + min;
            console.log(potenciaPc); // Imprime el valor en la consola del navegador

            var factorEmision = 0.41;
            var huellaCarbono = potenciaPc *factorEmision;

            // Mostrar el resultado en el HTML
            const tiempo = new Date().toLocaleTimeString();
            agregarPunto(tiempo, huellaCarbono);
        }

        function iniciarActualizacion() {
            startTime = performance.now();
            previousTime = startTime;
            intervalId = setInterval(obtenerDatosHuellaCarbono, 1000);
        }

        function detenerActualizacion() {
            clearInterval(intervalId);
        }

        function reiniciarGrafica() {
            chart.data.labels = [];
            chart.data.datasets[0].data = [];
            chart.update();
            accumulatedHuellaCarbono = 0;
        }

        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        const resetButton = document.getElementById('resetButton');

        startButton.addEventListener('click', iniciarActualizacion);
        stopButton.addEventListener('click', detenerActualizacion);
        resetButton.addEventListener('click', reiniciarGrafica);
    </script>
    