var table;
function listarServicios() {
    table = $("#tbl_servicios").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Servicio',
                className: 'addNewRecord',
                action: function ( e, dt, node, config ){
                    abrirModuloRegistro();
                }
            },
            'excel','pdf','print','pageLength'
        ],
        ordering: false,
        bLengthChange: true,
        searching: { regex: true },
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        pageLength: 10,
        destroy: true,
        async: false,
        processing: true,
        ajax: {
          url: "funciones/paginaFunciones_cat_servicios.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: ""},
            { data: "id" },
            { data: "clave" },
            { data: "nomServicio" },
            { data: "precio" },
            { data: "situacion", 
                render: function (data, type, row) {
                    if (data == "1") {
                    return "<span class='badge bg-success'>ACTIVO</span>";
                    } else {
                    return "<span class='badge bg-danger'>INACTIVO</span>";
                    }
                },
            },
            { data: "" }
        ],
        responsive: {
                detalls:{
                    type: 'column'
                }
        },
        columnDefs:[
                {
                    width: "5%",
                    targets:0,
                    orderable: false,
                    className:'control'
                },
                {
                    width: "5%",
                    className: "text-center",
                    targets:1
                },
                {
                    width: "5%",
                    targets:2
                },
                {
                    width: "35%",
                    targets:3
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:4
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:5
                },
                {
                    width: "10%",
                    targets:6,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span class='btEditar text-primary px-1' style='cursor:pointer;'>" +
                                    "<i class='fas fa-pencil-alt fs-5'></i>"+
                                "</span>"+
                                "</center>"
                    }
                }
        ],
    
        language: idioma_espanol,
        select: true,
        
    });

}

$("#tbl_servicios").on("click", ".btEditar", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificacion_servicio").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificacion_servicio").modal("show");
    
     $("#txtIdServicio").val(data.id);
     $("#txt_clave_modificar").val(data.clave);
     $("#txt_servicio_modificar").val(data.nomServicio);
     $("#txt_precio_modificar").val(data.precioVenta);
     $("#txt_Situacion").val(data.situacion);
    
});

function abrirModuloRegistro()
{
    $("#modal_registro_servicio").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro_servicio").modal("show");
}

function registrar_servicios()
{
    var clave=$("#txt_clave").val();
    var precio=$("#txt_precio").val();
    var nomServicio=$("#txt_servicio").val();

    if(clave.length==0 || precio.length==0 || precio<=0 || nomServicio.length==0)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"clave":"'+clave+'","precio":"'+precio+'","nomServicio":"'+nomServicio+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro_servicio").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Servicio registrado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  

            listarServicios();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_cat_servicios.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

function modificar_servicios()
{
    var idServicio=$("#txtIdServicio").val();
    var clave=$("#txt_clave_modificar").val();
    var precio=$("#txt_precio_modificar").val();
    var nomServicio=$("#txt_servicio_modificar").val();
    var situacion=$("#txt_Situacion").val();

    if(clave.length==0 || precio.length==0 || precio<=0 || nomServicio.length==0 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idServicio":"'+idServicio+'","clave":"'+clave+'","precio":"'+precio+'","nomServicio":"'+nomServicio+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificacion_servicio").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Servicio Modificado correctamente',
                showConfirmButton: false,
                timer: 1500
              }); 

              listarServicios();  
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_cat_servicios.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true)
}

$('#btnCancelarRegistro, #btnCerrarModal').on('click', function() {
    limpiarCamposModalRegistro();
})


function limpiarCamposModalRegistro()
{
    $("#txt_clave").val('');
    $("#txt_precio").val('');
    $("#txt_servicio").val('');
}