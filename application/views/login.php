<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Registro Gades Administración</title>
	<!--<style> label {display: block;} .errors { color: red;} </style>-->
	<link rel="stylesheet" type="text/css" href='<?php echo base_url("assets/css/gades_login.css"); ?>'>
	<?php echo base_url("assets/css/gades.css"); ?>
	<!--<script type="text/javascript">
    alert("<?php echo validation_errors(); ?>");
    history.back();-->
  </script>
</head>
<body>
<div id="container">
	<div id="banner">
		<?php 
				$image_properties = array(
					'src' => 'assets/images/logo.png',
					'alt' => 'Logo club',
					'width' => '200',
					'heigth' => '200');
			  echo img($image_properties);
			  echo heading('Gades Administración', 1); 
		?>
	</div>

	<div id="autenticacion">
		<?php echo form_open('admin'); ?>
		<table border="0">
			<tr>
				<td><?php echo form_label('Usuario', 'usuario'); ?> </td>
				<td><?php echo form_input('usuario', set_value('usuario'), 'id="usuario"');	?></td>
			</tr>
			<tr>
				<td><?php echo form_label('Password', 'password'); ?></td>
				<td><?php echo form_password('password', '', 'id="password"'); ?></td>
			</tr>
			<tr>
				<td><?php echo form_submit('submit', 'Login'); ?></td>
				<td></td>
			</tr>
		</table>
		
		<?php echo form_close(); ?>

	</div>
	<div id="errors">
			<?php echo validation_errors(); ?>
	</div>
	
	<!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>
</body>
</html>