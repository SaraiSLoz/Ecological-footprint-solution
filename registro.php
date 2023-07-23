<?php


	require 'database.php';

		$nomError = null;
		$apeError = null;
		$corrError= null;
		$conError = null;


	if ( !empty($_POST)) {

		$nom = $_POST['nom'];
		$ape   = $_POST['ape'];
		$corr   = $_POST['corr'];
		$con   = $_POST['con'];



		// validate input
		$valid = true;

		if (empty($nom)) {
			$nomError = 'Porfavor escriba su nombre';
			$valid = false;
		}
		if (empty($ape)) {
			$apeError = 'Porfavor escriba sus apellidos';
			$valid = false;
		}
		if (empty($corr)) {
			$corrError = 'Porfavor ingrese su correo institucional';
			$valid = false;
		}
		if (empty($con)) {
			$conError = 'Porfavor ingrese una contraseña';
			$valid = false;
		}
		
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO usuario (id,nombre,apellidos,correo,password) values(null, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($nom,$ape,$corr,$con));
			Database::disconnect();
			header("Location: exitoso.php");
			
			Database::disconnect();

		}
	}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Calculadora</title>
  <link rel="shortcut icon" href="Hack/huella.png" type="image/x-icon">
  <link rel="stylesheet" type"text/css" href="Hack/estilos4.css">
</head>

<body>



  <header>
    <section class="textos-header">
    </section>
    <div class="wave" style="height: 200px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 130%; width: 100%;"><path d="M0.00,49.98 C282.44,51.81 294.86,50.83 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>

  </header>

  <div align="center">
    <h1>Registro</h1>
	
	<form class="form-horizontal" action="registro.php" method="POST">
	<div class="contenedor">
    <table class="registros">
      <tr>
       <td>
          <table>
            <tr>
              <td>
              	<div class="control-group <?php echo !empty($nomError)?'error':'';?>">
			<label class="control-label">Nombre:</label>
			<div class="controls">
			<td>
				<input name="nom" type="text"  placeholder="Nombre" value="<?php echo !empty($nom)?$nom:'';?>">
				<?php if (($nomError != null)) ?>
				<span class="help-inline"><?php echo $nomError;?></span>
			</td>
			</div>
		</div>
	     </td>
            </tr>
            <tr>
              <td>
              	<div class="control-group <?php echo !empty($apeError)?'error':'';?>">
			<label class="control-label">Apellidos:</label>
			<div class="controls">
			<td>
				<input name="ape" type="text"  placeholder="Apellidos" value="<?php echo !empty($ape)?$ape:'';?>">
				<?php if (($apeError != null)) ?>
				<span class="help-inline"><?php echo $apeError;?></span>
			</td>
			</div>
		</div>
		</td>
            </tr>
            <tr>
              <td>
              <div class="control-group <?php echo !empty($corrError)?'error':'';?>">
			<label class="control-label">Correo Electrónico:</label>
			<div class="controls">
			<td>
				<input name="corr" type="email"  placeholder="Correo" value="<?php echo !empty($corr)?$corr:'';?>">
				<?php if (($corrError != null)) ?>
	      		<span class="help-inline"><?php echo $corrError;?></span>
		    </td>
		       </div>
		</div>
		</td>
          </tr>
          <tr>
            <td>
            	<div class="control-group <?php echo !empty($conError)?'error':'';?>">
			<label class="control-label">Contraseña:</label>
			<div class="controls">
		    <td>
		        	<input name="con" type="password"  placeholder="Contraseña" value="<?php echo !empty($con)?$con:'';?>">
				<?php if (($conError != null)) ?>
		      		<span class="help-inline"><?php echo $conError;?></span>
		    </td>
		    </div>
		</div>
		</td>
        </tr>
          </table>
          </div>
          
	<div class="input-group" align="center">
	<a href= index.php><input type="button" value="Volver" class="boton"></a>
  	  <button type="submit" class="boton">Registrarse</button>
	</div>	
	
	</form>
          
       </td>
    </tr>
    </table>
  </div>

  
  <footer>
  </footer>
</body>
</html>
