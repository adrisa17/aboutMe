<!DOCTYPE html>
<html>
<head>
    <title>Formulario</title>
    <?php 
        $server= "localhost";
        $user="root";
        $pass="Adri1712";
        $database="formulario_bd";
        $linkDB=mysqli_connect($server,$user,$pass,$database);

        if (!$linkDB) {
            echo "no es posible conectar con el servidor";
        }

        echo "Connected successfully";

        // Verificar si se ha enviado el formulario (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // datos del formulario
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $id= uniqid();

            // Insertar datos 
            $query = "INSERT INTO datos (id,name, email, message) VALUES ('$id','$name', '$email', '$message')";
            mysqli_query($linkDB, $query);

            // Mostrar un mensaje de éxito
            echo "¡Formulario enviado exitosamente!";
        }

        // se envió una petición GET para eliminar un registro
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];

            // Eliminar registro 
            $query = "DELETE FROM datos WHERE id = $id";
            mysqli_query($linkDB, $query);

            // Redireccionar index.php
            header('Location: index.php');
            exit;
        }

        // Obtener todos los registros de la base de datos
        $query = "SELECT * FROM datos";
        $result = mysqli_query($linkDB, $query);

        //Consultas en bases de datos
        $sql = "SELECT * FROM datos";
        $result = $linkDB->query($sql);
        
        //obtener datos sobre las consultas
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Name: " . $row["name"] . "<br>";
                echo "Email: " . $row["email"] . "<br>";
                echo "Message: " . $row["message"] . "<br><br>";
            }
        } else {
            echo "No se encontraron resultados.";
        }
        
        
        
        
        
        // Cerrar la conexión a la base de datos
        $linkDB->close();
    ?>
</head>
<body>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Ingresa tu nombre">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email">

        <label for="message">Mensaje:</label>
        <textarea id="message" name="message" placeholder="Ingresa un mensaje"></textarea>

        <input type="submit" value="Enviar">
    </form>

    <h2>Registros del formulario:</h2>
    <ul>
        <?php
        // Mostrar los registros de la base de datos
        while ($row = mysqli_fetch_array($result)) {
            echo "<li>{$row['name']} - {$row['email']} - {$row['message']} <a href=\"index.php?id={$row['id']}\">Eliminar</a></li>";
        }
        ?>
    </ul>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>



