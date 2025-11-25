<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $IdUsuario = $this->session->UID;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenios</title>

    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>includes/bootstrap/css/bootstrap.css" />
    <!-- <link type="image/x-icon" href="<?= base_url(); ?>includes/img/icon.ico" rel="shortcut icon" /><!--Falta poner icon--> -->

    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>includes/css/Site.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>includes/css/styles.css" />

    <link href="<?= base_url() ?>includes/jQuery_UI/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>includes/css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>includes/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
        
</head>
<body>
<div class="loader-gif" style="background: rgba( 255, 255, 255, .8 ) url('<?= base_url() ?>includes/img/loader.gif') 50% 50%no-repeat;">
    <p class="loader-gif" style="
    text-align: center;
    top: 50%;
">Guardando...</p>
</div>
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
        <div class="navbar-header hidden-xs" style="min-height: 35px, min-height: 20px;width:80%">
            <div class="row">
<!--                 <div class="col-md-2 col-sm-3">
                    <a href="<?=base_url(); ?>" class="navbar-brand"><img src="<?=base_url(); ?>includes/img/logo-saeta-2020.png" style="height: 80px;" class="companyLogo" title=""></a>
                </div> -->
                <?php
                    if($this->session->Logged)
                    {
                ?>
                        <div class="col-md-12 col-sm-12 text-center" style="color:#FFF;font-weight:bolder;">
                            <h4>SIMULADOR DE CONVENIOS HSBC</h4>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
<!--   Se puede usar este div para poner un 2do logo en la esquina superior derecha de la pagina      

        <div class="navbar-header navbar-right" style="min-height: 85px;">
            <a href="<?=base_url(); ?>" class="navbar-brand"><img src="<?=base_url(); ?>includes/img/logo2.png" style="height: 80px;" class="companyLogo" title=""></a>
        </div>
 -->    
</div>
<div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <?php
                    if($this->session->Logged)
                    {
                ?>
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Convenios<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">

                    <?php if(VerificarAccionesControlador($IdUsuario, "Convenios")){ ?>
                        <li class="<?= ActiveMenu("Convenios") ?>"><a href="<?= base_url(); ?>Convenios">Master de convenios</a></li>
                    <?php } ?>

                    </ul>
                </li>

             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">

                     <?php if(VerificarPermisos($IdUsuario, "Reportes", "ExportaConvenios")){ ?>
                    <li class="<?= ActiveMenuAction("Reportes", "ExportaConvenios") ?>"><a href="<?= base_url(); ?>Reportes/ExportaConvenios">Exportar convenios</a></li>
                    <?php } ?>

                </ul>
            </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Catálogos <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if(VerificarAccionesControlador($IdUsuario, "Productos")){ ?>
                            <li class="<?= ActiveMenuAction("Productos", array("Create","Edit","Details")) ?>"><a href="<?= base_url(); ?>Productos">Productos y quitas</a></li>
                        <?php } ?> 

                        <li role="separator" class="divider"></li>
                        <?php if(VerificarAccionesControlador($IdUsuario, "Users")){ ?>
                            <li class="<?= ActiveMenuAction("Users", array("Create","Edit","Details", "ChangePassword","")) ?>"><a href="<?= base_url(); ?>Users">Usuarios del sistema</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Especiales <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if(VerificarAccionesControlador($IdUsuario, "Parametros")){ ?>
                        <li class="<?= ActiveMenu("Parametros") ?>"><a href="<?= base_url(); ?>Parametros/Details">Parametros</a></li>
                        <?php } ?>

                        <?php if(VerificarPermisos($IdUsuario, "Importar", "Panes")){ ?>
                            <li class="<?= ActiveMenuAction("Importar", "Panes") ?>"><a href="<?= base_url(); ?>Importar/Panes">Importar PAN</a></li>
                        <?php } ?>

                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <?=$this->session->Name ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="<?= ActiveMenuAction("Users", "MyData") ?>"><a href="<?= base_url() ?>Users/MyData"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Mis datos</a></li>
                        <li class="<?= ActiveMenuAction("Users", "ChangeMyPassword") ?>"><a href="<?= base_url() ?>Users/ChangeMyPassword"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Cambiar mi contraseña</a></li>
                        <li><a href="<?=base_url() ?>Users/LogOut"><span class='glyphicon glyphicon-log-out' aria-hidden='true'></span> Cerrar sesi&oacute;n</a></li>
                    </ul>
                </li>
                
            </ul>
        <?php
            }else
            {
        ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="<?= ActiveMenuAction("Users", "LogIn") ?>">
                        <a href="<?= base_url() ?>Users/LogIn">Iniciar sesión</a>
                    </li>
                </ul>
        <?php
            }
        ?>
        </div>
    </div>
</nav>

<script src="<?= base_url(); ?>includes/slideImage/lightbox-plus-jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.12.1.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>includes/jQuery_UI/jquery-ui.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>includes/bootstrap/js/bootstrap.js"></script>
<script type="application/javascript" src="<?= base_url(); ?>includes/js/jquery.fancybox.pack.js"></script>
<script type="application/javascript" src="<?= base_url(); ?>includes/generalFunctions/generalFunctions.js"></script>
<script type="application/javascript" src="<?= base_url(); ?>includes/js/bootbox.js"></script>
<script type="application/javascript" src="<?= base_url(); ?>includes/bootstrap-datetimepicker/moment.js"></script>
<script type="application/javascript" src="<?= base_url(); ?>includes/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
<script>
    $(function()
    {
        bootbox.setDefaults({
          locale: "es"
        });

        $(".building").click(function(event)
        {
            event.preventDefault();
            bootbox.alert("En construcción.");
        })
    })
</script>
<div class="container-fluid">
<div class="container" style="width:100%; margin-top:120px; margin-bottom:60px">
<?= form_input(array("type" => "hidden", "id" => "hdTriedSave", "value" => "false")) ?>
<input type="hidden" id="url" value="<?php echo base_url() ?>">