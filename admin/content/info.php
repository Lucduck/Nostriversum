<?php 
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
try {
  $DataBase = new DB();
}catch (PDOException $e) {
  $error = $e->getCode();
  $missatge = $e->getMessage();
}
if (isset($error)) {
  die("Error: connection failed");
}
if (!$DataBase->activatedUser($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
$page = basename($_SERVER['PHP_SELF']);
$_SESSION['page'] = $page;
?>
<div class="contentArticles">
	<table>
		<tr>
			<th>Menu</th>
			<th>información</th>
		</tr>
		<?php
      $group = $_SESSION['usuari']->getGroup();
        if($group->getArticles()){
          echo "
                <tr>
                  <td style='max-width: 98px;padding-left: 11px'>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-square fa-stack-2x' style='color: #ffa000'></i>
                      <i class='fa fa-file-text-o fa-stack-1x fa-inverse'></i>
                    </span> Artículos
                  </td>
                  <td style='text-align: justify;padding: 16px 11px'>
                    <p>Aquí se pueden gestionar los artículos que estarán en el frontend.</p>
                    <p>El mas  de arriba a la izquierda es para añadir uno nuevo, la flecha de arriba a la derecha es para recargar los artículos.</p>
                    <p>Al editar o añadir, el texto que se tiene de escribir, iría bien que estuviera en html.</p>
                  </td>
                </tr>";
        }
        if($group->getInfo()){
          echo "
                <tr>
                  <td style='max-width: 98px;padding-left: 11px'>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-square fa-stack-2x' style='color: #1976d2'></i>
                      <i class='fa fa-info fa-stack-1x fa-inverse'></i>
                    </span> Información
                  </td>
                  <td style='text-align: justify;padding: 16px 11px'>
                    <p>Este es el apartado donde se explica cada punto del menú.</p>
                    <p>Solo saldrán los puntos del menú a los que el usuario tenga permisos. Para muchas mas dudas, siempre hay el chat (abajo a la derecha) para poder hablar con alguien que lo sepa y pueda ayudar.</p>
                  </td>
                </tr>";
        }
        if($group->getPlanets()){
          echo "
                <tr>
                  <td style='max-width: 98px;padding-left: 11px'>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-square fa-stack-2x' style='color: #512da8'></i>
                      <i class='fa fa-globe fa-stack-1x fa-inverse'></i>
                    </span> Planetas
                  </td>
                  <td style='text-align: justify;padding: 16px 11px'>
                    <p>Añade cada planeta del sistema solar, modifica la información o eliminalo si te has equivocado. Aquí puedes gestionar los planetas.</p>
                    <p>El periodo orbital tiene de ser el real y correcto en días. Después cuando se muestren los planetas, el tiempo que tardar en dar una vuelta, es el especificado en días, pasado a segundos (1dia = 1segundo), y luego dividido por 50.</p>
                  </td>
                </tr>";
        }
        if($group->getSatellites()){
          echo "
                <tr>
                  <td style='max-width: 98px;padding-left: 11px'>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-square fa-stack-2x' style='color: #7b1fa2'></i>
                      <i class='fa fa-circle fa-stack-1x fa-inverse' style='font-size: 11px'></i>
                    </span> Satélites
                  </td>
                  <td style='text-align: justify;padding: 16px 11px'>
                    <p>Añade todos los satélites que se descubran al planeta correspondiente, modifica la información o eliminalo si te has equivocado. Aquí puedes gestionar los satélites de cada planeta.</p>
                    <p>El periodo orbital tiene de ser el real y correcto en días. Después cuando se muestren los satélites del planeta, el tiempo que tardar en dar una vuelta, es el especificado en días, pasado a segundos (1dia = 1segundo), y luego dividido por 20.</p>
                  </td>
                </tr>";
        }
        if($group->getLog()){
          echo "
                <tr>
                  <td style='max-width: 98px;padding-left: 11px'>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-square fa-stack-2x' style='color: #c2185b'></i>
                      <i class='fa fa-list-alt fa-stack-1x fa-inverse'></i>
                    </span> Registro
                  </td>
                  <td style='text-align: justify;padding: 16px 11px'>
                    <p>En el registro hay todo lo que se ha echo en el back-end. Cualquier cambio, creación o eliminación de algo, quedara reflejada en este apartado. Se podrá gestionar, ver y controlar que ha echo quien. </p>
                    <p>La información que sale es:</p>
                    <ul>
                      <li><strong>Fecha:</strong> El momento que paso.</li>
                      <li><strong>Usuario:</strong> Muestra el usuario el  izo la acción.</li>
                      <li><strong>Acción:</strong> Insert (insertar), Update (actualizar), Delete (eliminar). La acción que se a ejecutado.</li>
                      <li><strong>Database table:</strong> La tabla de la base de datos que ha sido modificada.</li>
                      <li><strong>Descripción:</strong> En caso de cambio o eliminación, este punto servirá para ver que había y corregir si se ha echo algo mal.</li>
                    </ul>
                  </td>
                </tr>";
        }
        if($group->getUsers()){
          echo "
                <tr>
                  <td style='max-width: 98px;padding-left: 11px'>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-square fa-stack-2x' style='color: #0288d1'></i>
                      <i class='fa fa-user fa-stack-1x fa-inverse'></i>
                    </span> Usuarios backend
                  </td>
                  <td style='text-align: justify;padding: 16px 11px'>
                    <p>Aquí se podrán gestionar los usuarios.</p>
                    <p>Pero el usuario de administrador (admin), no podrá ser eliminado ni desactivado.</p>
                  </td>
                </tr>";
        }
        if($group->getGroups()){
          echo "
                <tr>
                  <td style='max-width: 98px;padding-left: 11px'>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-square fa-stack-2x' style='color: #00796b'></i>
                      <i class='fa fa-users fa-stack-1x fa-inverse'></i>
                    </span> Grupos backend
                  </td>
                  <td style='text-align: justify;padding: 16px 11px'>
                    <p>Aquí se podrán gestionar los grupos.</p>
                    <p>Pero el grupo de administradores (admin), no podrá ser eliminado.</p>
                    <p>Hay que tener en cuenta, que cuando cambies el nombre de un grupo, se cambiara el nombre del grupo del usuario automáticamente, no se tendera de cambiar el grupo del usuario también.</p>
                  </td>
                </tr>";
        }
		?>
	</table>
</div>