
       <!-- <?php if(is_array($result)): ?>
		<?php foreach($result as $row):?>
		<h3><?= $row->nombre ?></h3>
		<p><?= $row->apellidos ?></p>
		<br />
		<?php endforeach;?>
        <?php endif;?> -->

        <div id='jugadores'>
        	<?php echo $this->table->generate($result); ?>
        </div>
