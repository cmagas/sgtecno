var table;
function listarMovimientoCaja() {
    table = $("#tbl_tipoMovimientoCaja").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Agregar Movimiento',
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
          url: "funciones/paginaFunciones_cajaChica.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: ""},
            { data: "id" },
            { data: "nombreMovimiento" },
            { data: "fechaMovVista" },
            { data: "importeVista" },
            { data: "tipo" },
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
                    width: "40%",
                    targets:2
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:3
                },
                {
                    width: "10%",
                    targets:4
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:5
                },
                {
                    width: "10%",
                    className: "text-center",
                    targets:6
                },
                {
                    width: "10%",
                    targets:7,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                "<span class='btEditarReg text-primary px-1' style='cursor:pointer;' title='Modificar registro'>" +
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

$("#tbl_tipoMovimientoCaja").on("click", ".btEditarReg", function () {
    var data = table.row($(this).parents("tr")).data();
  
    if (table.row(this).child.isShown()) {
      var data = table.row(this).data();
    }

    $("#modal_modificar_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_modificar_registro").modal("show");
    
    
    $("#txtIdMovimiento").val(data.id);
    $("#txt_fechaMov_modificar").val(data.fechaMov);
    $("#txt_importe_modificar").val(data.importe);
    $("#cmb_tipoMovimiento_modificar").val(data.idMovimiento);
    $("#txt_Situacion").val(data.situacion);

   
});

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}

function registrar_movimiento()
{
    var fechaMovimiento=$("#txt_fechaMov").val();
    var importe=$("#txt_importe").val();
    var idTipoMov=$("#cmb_tipoMovimiento").val();

    if(fechaMovimiento.length==0 || importe.length==0 || importe<0 || idTipoMov==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    if(idTipoMov==1)
    {
        var valor=1;
    }else{
        var valor=-1;
    }

    var cadObj='{"fechaMovimiento":"'+fechaMovimiento+'","importe":"'+importe+'","idTipoMov":"'+idTipoMov+'","valor":"'+valor+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_registro").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Movimiento registrado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
              listarMovimientoCaja(); 
              recalcularSaldo(); 
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_cajaChica.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true) 
}

function modificar_movimiento()
{
    var idMovimiento = $("#txtIdMovimiento").val();
    var fechaMovimiento = $("#txt_fechaMov_modificar").val();
    var importe = $("#txt_importe_modificar").val();
    var idTipoMov = $("#cmb_tipoMovimiento_modificar").val();
    var situacion = $("#txt_Situacion").val();

    if(fechaMovimiento.length==0 || importe.length==0 || importe<0 || idTipoMov==-1 || situacion==-1)
    {
        return Swal.fire("Mensaje De Advertencia","Los campos marcados con * son obligatorios","warning");
    }

    var cadObj='{"idMovimiento":"'+idMovimiento+'","fechaMovimiento":"'+fechaMovimiento+'","importe":"'+importe+'","idTipoMov":"'+idTipoMov+'","situacion":"'+situacion+'"}';

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            $("#modal_modificar_registro").modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Movimiento modificado correctamente',
                showConfirmButton: false,
                timer: 1500
              });  
              listarMovimientoCaja();
              recalcularSaldo();  
            limpiarCamposModalRegistro();         
        }
        else
        {
            Swal.fire("Mensaje De Error","Lo sentimos, no se pudo completar el registro","error");
        }
    }
    obtenerDatosWeb('funciones/paginaFunciones_cajaChica.php',funcAjax, 'POST','funcion=3&cadObj='+cadObj,true) 
}


function recalcularSaldo()
{
    $.ajax({
        async: false,
        url: "funciones/paginaFunciones_cajaChica.php",
        method: "POST",
        data: {
            'funcion': 4
        },
        dataType: 'json',
        success: function(respuesta) {
        
            //console.log("respuesta "+respuesta['valor']);
            if(respuesta['valor']>0)
            {
                $("#saldoCaja").html('$ '+(parseFloat(respuesta['valor']).toFixed(2)));
            }else{
                $("#saldoCaja").html('$ 0.00');
            }
        }
    });
}

function limpiarCamposModalRegistro()
{
    $("#txt_fechaMov").val('');
    $("#txt_importe").val('');
    $("#cmb_tipoMovimiento").val(-1);
}