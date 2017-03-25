<?php
include "verificar_sesion.php";
$usuarios=Usuario::TraerTodosLosUsuarios();  
?>
<div class="animated bounceInRight" style="height:460px;overflow:auto;border-style:solid" >
    <table class="table">
        <thead style="background:rgb(14, 26, 112);color:#fff;">
            <tr>
                <th> NOMBRE </th>
                <th> MAIL </th>
                <th> PERFIL </th>
                <?php if($objUser->perfil != "invitado"){echo '<th> ACCION </th>';}?>
            </tr> 
        </thead>    
        <?php
            foreach ($usuarios as $usuario) {
                    echo '<tr>';
                    
                    echo  '<td>' .$usuario->nombre. '</td>';
                    echo  '<td>' .$usuario->email. '</td>';
                    echo  '<td>' .$usuario->perfil. '</td>';                    
                    echo  '<td>';
                    if($objUser->perfil != "invitado"){echo '<a href="#" onclick="CargarFormUsuario('.$usuario->id.',1)" id="Moboton" class="btn bounceInLeft" >Modificar</a>';}
                    if($objUser->perfil == "administrador"){echo'<a id="Moboton" onclick="CargarFormUsuario('.$usuario->id.',2)"href="#" class="btn animated bounceInLeft">Eliminar</a>';}        
                    echo  '</td>' ;
                    
                    echo '</tr>';
                }        
        ?>

    </table>
</div>  