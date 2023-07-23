
<?php

session_start();  // Asegúrate de iniciar la sesión en la página "iniciada.php"
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];  // Obtener el ID de la variable de sesión
    // Utilizar el ID como sea necesario
    //echo "ID de usuario: " . $id;
} else {
    // El ID no está disponible en la variable de sesión, puede que el usuario no haya iniciado sesión correctamente
    //echo "No se encontró el ID de usuario";
}


	require 'database.php';

		$dispError = null;
		$modError = null;
		$dmError = null;

	if ( !empty($_POST)) {

		$disp = $_POST['disp'];
		$mod = $_POST['mod'];
		$nom = $_POST['nombre'];
        $time = $_POST['tiempo'];

		// validate input
		$valid = true;

		if (empty($disp)) {
			$dispError = 'Seleccione un dispositivo';
			$valid = false;
		}
		
		if (empty($mod)) {
			$modError = 'Seleccione un modelo';
			$valid = false;
		}
		

		// insert data
		if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO aparato (id_aparato, id_dispositivo, id_modelo, nombre, tiempo_uso, id_usuario) VALUES (null, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($disp, $mod, $nom, $time, $id));
            $id_aparato = $pdo->lastInsertId(); // Obtener el ID del aparato recién insertado
            Database::disconnect();
            header("Location: analisis.php?id=" . $id_aparato);
        }        
	}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Calculadora</title>
  <link rel="shortcut icon" href="huella.png" type="image/x-icon">
  <link rel="stylesheet" type"text/css" href="Hack/estilos2.css">
</head>

<body>
    
    <ul> 
        <li><input type="button" value="Cerrar Sesión" class="boton" align="center" onclick="alerta()"/></li>
        <li><a href="historial.php?id=<?php echo $id; ?>">Historial</a></li>
        <li class="actual"><a href="#">Mi huella de Carbono</a></li>
      </ul>

      <h1>Calcula tu Huella de Carbono</h1>
      <p>Selecciona las características que más se adecúen a tu dispositivo</p>


<table align="center">

<form method="POST" action="">

	<tr>
        
		<div class="control-group <?php echo !empty($dispError)?'error':'';?>">
			<td><label class="control-label">Dispositivo</label></td>
			<div class="controls">
			<td><select name ="disp">
			<option value="">Selecciona un dispositivo</option>
			 <?php
				$pdo = Database::connect();
				$query = 'SELECT * FROM dispositivo';
				foreach ($pdo->query($query) as $row) {
				if ($row['id_dispositivo']==$disp)
				echo "<option selected value='" . $row['id_dispositivo'] . "'>" . $row['nombre'] . "</option>";
				else
				echo "<option value='" . $row['id_dispositivo'] . "'>" . $row['nombre'] . "</option>";
				}
				 Database::disconnect();
				?>
		         </select></td>
			<?php if (($dispError) != null) ?>
				<span class="help-inline"><?php echo $dispError;?></span>
			</div>
		</div>
	</tr>
	
	<tr>
		<div class="control-group <?php echo !empty($modError)?'error':'';?>">
			<td><label class="control-label">Modelo</label> </td>
			<div class="controls">
			<td><select name ="mod">
			<option value="">Selecciona un modelo</option>
			 <?php
				$pdo = Database::connect();
				$query = 'SELECT * FROM modelo';
				foreach ($pdo->query($query) as $row) {
				if ($row['id_modelo']==$disp)
				echo "<option selected value='" . $row['id_modelo'] . "'>" . $row['nombre'] . "</option>";
				else
				echo "<option value='" . $row['id_modelo'] . "'>" . $row['nombre'] . "</option>";
				}
				 Database::disconnect();
				?>
		         </select> </td>
			<?php if (($modError) != null) ?>
				<span class="help-inline"><?php echo $modError;?></span>
			</div>
		</div>
	</tr>
	
	<tr>
		<td>Tiempo</td>
		<td><input type="text" name = "tiempo" align="center"/></td>
	</tr>
    <tr>
		<td>Nombre: </td>
		<td><input type="text" name = "nombre" align="center"/></td>
	</tr>
	
	<tr>
    <td colspan=2>
        <button    type="submit" name="submit" class="boton2" align="center"> Registrar Dispositivo</button>
    </td>
	</tr>
</table>
            </form>

	<script>
		function alerta() {
		var opcion = confirm("¿Cerrar sesión?");

		if (opcion == true) {
		window.location.href = "CerrarSesion.php";
		} else {
		// Si el usuario cancela, redirigimos a la página principal
		window.location.href = "iniciada.php";}
		}
	</script>
				
  <footer>
  </footer>
</body>
</html>
