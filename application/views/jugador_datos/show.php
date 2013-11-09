<!-- Vista de administración de jugadores
	 Se direcciona desde el controlador jugadores. 

-->
<div id="player">
  <div id="foto_player">
      <?php 
              $image_properties = array(
                    'src' => 'assets/uploads/fotos/'.$foto,
                    'alt' => 'Logo club',
                    'width' => '80',
                    'heigth' => '80');
                    echo img($image_properties);
              ?>
  </div>
  <div id="datos_player">
      <div id="title">
        <p>Datos jugador</p>
      </div>
      <div id="datos">
        <p>Nombre: <?php echo $nombre?></p>
        <p>Apellidos: <?php echo $apellidos?></p>
      </div>
  </div>
  <div class="clear-both"></div>

  <div id="otros_datos">
    <div id="title">
        <p>Otros datos</p>
      </div>
    <table id="tablaplayer">
      <tr>
        <td id="tdleft">Fecha de nacimiento</td>
        <td id="tdright"><?php echo $edad ?></td>
      </tr>
      <tr>
        <td id="tdleft">Club desde</td>
        <td id="tdright"><?php echo $club_desde ?></td>
      </tr>
      <tr>
        <td id="tdleft">Tutor</td>
        <td id="tdright"><?php echo $socio ?></td>
      </tr>
      <tr>
        <td id="tdleft">Telefono 1</td>
        <td id="tdright"><?php echo $telefono1 ?></td>
      </tr>
      <tr>
        <td id="tdleft">Telefono 2</td>
        <td id="tdright"><?php echo $telefono2 ?></td>
      </tr>
      <tr>
        <td id="tdleft">Tarjeta deportiva</td>
        <td id="tdright"><?php echo $tarjeta_deportiva ?></td>
      </tr>   
      <tr>
        <td id="tdleft">Código recibo</td>
        <td id="tdright"><?php echo $codigo_recibo ?></td>
      </tr> 
      <tr>
        <td id="tdleft">Certificado médico</td>
        <td id="tdright"><?php echo $certificado_medico ?></td>
      </tr>
      <tr>
        <td id="tdleft">Equipos</td>
        <td id="tdright"><?php echo $equipo ?></td>
      </tr>
    </table>
  </div>

    
</div>