<?php
    session_start();
    require 'database.php';
        
    $correoError = $passwordError = $loginError = '';
    $correo = $password = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // validate input
        $valid = true;
        if (empty($_POST['correo'])) {
            $correoError = 'Por favor ingrese su correo electrónico';
            $valid = false;
        } else {
            $correo = $_POST['correo'];
        }

        if (empty($_POST['password'])) {
            $passwordError = 'Por favor ingrese su contraseña';
            $valid = false;
        } else {
            $password = $_POST['password'];
        }
	
        // check login credentials in MDP_alumno
       if ($valid) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM usuario WHERE correo = ? AND password = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($correo, $password));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        $id = $data['id'];
        $_SESSION['id'] = $id;  // Almacenar el ID en la variable de sesión
        Database::disconnect();
        header("Location: iniciada.php?id=" . $id);
        exit;  // Terminar la ejecución después de redirigir
    } else {
        $loginError = 'Correo o contraseña incorrectos';
    }
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
  <link rel="stylesheet" type"text/css" href="Hack/estilos.css">
</head>

<body>



  <header>
    <section class="textos-header">
        <h1>Huella de Carbono</h1>
    </section>
    <div class="wave" style="height: 200px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 130%; width: 100%;"><path d="M0.00,49.98 C282.44,51.81 294.86,50.83 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>

  </header>

  <div align="center">
    <h1>Bienvenid@</h1>

          <h2>Inicia Sesión</h2>
          
	<form method="post" action="index.php">
          <table>
             <tr>
                  <td>Correo Electrónico</td>
                  <td><input type="text" name="correo" id="correo" value="<?php echo !empty($correo) ? $correo : ''; ?>">
                                <?php if (!empty($correoError)): ?>
                                <span><?php echo $correoError; ?></span>
                                <?php endif; ?></td>
              </tr>
              <tr>
                <td>Contraseña</td>
                <td><input type="password" name="password" id="password">
                                <?php if (!empty($passwordError)): ?>
                                    <span><?php echo $passwordError; ?></span>
                                <?php endif; ?></td>
            	</tr>
            	</tr>
            <tr>
            	<td colspan=2 align="center">
            		<button type="submit" class="boton">Iniciar sesión</button>
			<?php if (!empty($loginError)): ?>
			<span><?php echo $loginError; ?></span>
			<?php endif; ?>
            	</td> 
            </tr>
            </form>
          </table>
          
  </div>
  
  <p>¿No tienes una cuenta?</p>
  <h3><a href="registro.php">Regístrate</a></h3>

</body>
</html>
