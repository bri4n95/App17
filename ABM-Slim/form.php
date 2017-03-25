<?php
include "verificar_sesion.php";

$datos=isset($_POST["datos"])? json_decode(json_encode($_POST["datos"])) :  NULL;
$usuario=Usuario::TraerUnUsuarioPorId($datos->userid);  
$perfiles=Usuario::TraerTodosLosPerfiles();
 
?>
<div id="divFrm" class="animated bounceInLeft" style="height:330px;overflow:auto;margin-top:0px;border-style:solid">
    <input type="hidden" id="hdnIdUsuario" readonly value="<?php if($datos->quehago!="alta"){echo $usuario->id;}else{echo "0";}?>"/>
    <input type="text" placeholder="Nombre" <?php if ($datos->quehago=="Eliminar"){echo "readonly";}?> id="txtNombre" value="<?php echo $usuario->nombre; ?>" />
    <input type="text" placeholder="E-mail"<?php if ($datos->quehago=="Eliminar"){echo "readonly";}?> id="txtEmail" value="<?php echo $usuario->email; ?>" />
    <input type="password" <?php if ($datos->quehago!="alta"){echo "readonly";}?> placeholder="Password" id="txtPassword" value="" />

 
    <span>Perfil</span>    
        <select id="cboPerfiles" <?php if($objUser->perfil!="administrador" || $datos->quehago=="Eliminar"){echo "disabled='disabled'";} ?> >
            <?php 
                 foreach ($perfiles as $fila) {

                    foreach ($fila as $perfil) {

                          echo '<option value="'. $perfil.'"'.($usuario->perfil == $perfil ? 'selected="'.$perfil.'"' : '').'>'.$perfil.'</option>';
                        }
                    }   
            ?>  
        </select>
    <br/><br/>
    <input type="button" class="MiBotonUTN" onclick="<?php echo $datos->funcionJ; ?>" value="<?php echo $datos->quehago; ?>"  />
    <input type="hidden" id="hdnQueHago" value="agregar" />
</div>
<div id="divFoto"  class="animated bounceInLeft" style="border-style:none" >
    <div style="width:25%;float:left"></div>
</div>