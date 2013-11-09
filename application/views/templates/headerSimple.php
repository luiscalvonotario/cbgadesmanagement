<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title><?php echo $page_title ?> - Gades Administración</title>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url("assets/css/gades.css"); ?>'>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url("assets/css/menu.css"); ?>'>
    <style type='text/css'>
      body
      {
        font-family: Arial;
        font-size: 14px;
      }
      a 
      {
        color: blue;
        text-decoration: none;
        font-size: 14px;
      }
      a:hover
      {
        text-decoration: underline;
      }
    </style>
  </head>

  <body>
   <div id="header">
      <div id="banner">
            <?php 
              $image_properties = array(
                'src' => 'assets/images/logo.png',
                'alt' => 'Logo club',
                'width' => '50',
                'heigth' => '50');
              echo img($image_properties);
              echo heading('Gades Administración', 1);?>
          </div>
        <div id="salir">
            <a href='<?php echo site_url("admin/logout"); ?>'>
              <?php 
                $image_properties = array(
                  'src' => 'assets/images/exit.png',
                  'alt' => 'Salir',
                  'width' => '30',
                  'heigth' => '30');
                echo img($image_properties);
              ?>
            </a>
          </div>
    </div>
    <div class="clear-both"></div>
    <div id="cssmenu">
      <ul>
         <li><a <?php if($page_title=='home'){echo 'class="current"';} ?> href='#'><span>Inicio</span></a></li>
         <li><a <?php if($page_title=='Jugadores'){echo 'class="current"';} ?> href='<?php echo site_url("jugadores"); ?>'><span>Jugadores</span></a></li>
         <li><a href='<?php echo site_url("entrenadores"); ?>'><span>Entrenadores</span></a></li>
         <li><a href='<?php echo site_url("socios"); ?>'><span>Socios</span></a></li>
         <li><a href='<?php echo site_url("inventario"); ?>'><span>Inventario</span></a></li>
         <li class='has-sub last'><a href='#'><span>Equipos</span></a>
            <ul>
              <li><a href='#'><span>Infantil Masculino A</span></a></li>
              <li class='last'><a href='#'><span>Infantil Masculino B</span></a></li>
          </ul>
        </li>
     </ul>
    </div>
    
    <div id="container">
    
