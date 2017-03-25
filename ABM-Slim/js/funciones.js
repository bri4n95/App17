function Login() {

   var emailAux=$("#email").val();
    var passAux=$("#password").val();

    $.ajax({
        type: 'POST',
        url: "./slim.php/login",
        dataType: "json",
        data: {correo:emailAux,pass:passAux},
        async: true
        })
        .done(function (respuesta) {

             if (respuesta.logU) {

              window.location.href="principal.php?ulog="+respuesta.idUs;
             
           }
           else
           {
              alert("Error! Email y/o Contraseña incorrectos");
           }
           
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });

}



function Logout() {//#2

		$.ajax({
        type: 'GET',
        url: "./slim.php/salir",
        dataType: "json",
        async: true
        })
        .done(function (respuesta) {

          if (respuesta.salio) {

           		window.location.href=respuesta.redir;
           }
           else
           {
           		alert("Error! Al desloguearse");
           }           

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });
}

function MostrarGrilla() {//#3

		$.ajax({
        type: 'GET',
        url: "./slim.php/traerGrilla",
        dataType: "html",
        async: true
        })
        .done(function (estructura) {

          $("#divGrilla").html(estructura);         

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });
		
}

function Home() {
	$("#divGrilla").html(" ");
	$("#divAbm").html(" ");
}

function CargarFormUsuario(id,quehago) {//#

    var objDatos;

    switch(quehago)
    {
      case 1:
              objDatos={"userid":id,"funcionJ":"ModificarUsuario()","quehago":"Modificar"};
              break;
      case 2:              
              objDatos={"userid":id,"funcionJ":"EliminarUsuario()","quehago":"Eliminar"};
              break;        
    }

    $.ajax({
        type: 'POST',
        url: "./slim.php/cargarForm",
        dataType: "html",
        data: {"queMuestro":4,"datos":objDatos},
        async: true
        })
        .done(function (estructura) {

          $("#divAbm").html(estructura);         

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });
}

function EliminarUsuario() {//#7

    var idUserEliminar=$("#hdnIdUsuario").val();

    $.ajax({
        method: 'DELETE',
        url: "./slim.php/eliminar",
        dataType: "json",
        data: {idEliminar:idUserEliminar},
        async: true
      })
    .done(function (respuesta) {

      alert(respuesta.mensaje);
      MostrarGrilla();

        $("#hdnIdUsuario").val(" ");
        $("#txtNombre").val(" ");
        $("#txtEmail").val(" ");
        $("#cboPerfiles").val(" ");
        $("#fotoTmp").attr("src","");
        $("#hdnFotoSubir").val(" ");
        $("#archivo").val("");

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
      });  
}

function ModificarUsuario() {//#8

    var iduser=$("#hdnIdUsuario").val();
    var name=$("#txtNombre").val();
    var pass=$("#txtEmail").val();
    var perfilUser=$("#cboPerfiles").val();
    var nombreArch = $("#hdnFotoSubir").val();

    $.ajax({
        method: 'PUT',
        url: "./slim.php/modificarusuario",
        dataType: "json",
        data: {id:iduser,nombre:name,email:pass,perfil:perfilUser,foto: nombreArch},
        async: true
      })
    .done(function (respuesta) {

      if (!respuesta.realizada) {
        alert("no se pudo modificar");
        return;
      }

      alert("modificacion exitosa");

        MostrarGrilla();

        $("#hdnIdUsuario").val(" ");
        $("#txtNombre").val(" ");
        $("#txtEmail").val(" ");
        $("#cboPerfiles").val(" ");
        $("#fotoTmp").attr("src","");
        $("#hdnFotoSubir").val(" ");
        $("#archivo").val("");
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
      }); 
}