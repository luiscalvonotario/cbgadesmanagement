<h2>Nuevo jugador</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('jugadores/create') ?>

	<label for="nombre">Nombre</label> 
	<input type="input" name="nombre" /><br />

	<label for="apellidos">Apellidos</label>
	<input type="input" name="apellidos" /><br />
	
	<label for="fecha_nacimiento">Fecha nacimiento</label>
	<input type="input" name="fecha_nacimiento" /><br />

	<label for="fecha_entrada">Fecha de entrada al club</label>
	<input type="input" name="fecha_entrada" /><br />

	<input type="submit" name="submit" value="Create jugador" /> 

</form>