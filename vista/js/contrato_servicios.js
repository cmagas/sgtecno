var table;

function listarServiciosContratados()
{
    table = $("#tbl_contratos").DataTable({
        dom: 'Bfrtip', //Muestra los botones para imprimir en Buttons
        buttons: [
            {
                text: 'Registrar Contrato',
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
          url: "funciones/paginaFunciones_contratoServicios.php",
          type: "POST",
          data:{
              funcion: "1"
          }
        },
        columns: [
            { data: "" },
            { data: "id" },
            { data: "nomServicio" },
            { data: "nomCliente" },
            { data: "importe" },  
            { data: "totalabonos" },   
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
                    width: "30%",
                    targets:2
                },
                {
                    width: "30%",
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
                    width: "5%",
                    className: "text-center",
                    targets:6
                },
                {
                    width: "5%",
                    targets:7,
                    orderable: false,
                    render: function(data,type,meta){
                        return "<center>"+
                                    "<span class='btnImprimir text-primary px-1' style='cursor:pointer;' title='Imprimir'>" +
                                        "<i class='fas fa-book fs-5'></i>"+
                                    "</span>"+
                                "</center>"
                    }
                }
        ],
        language: idioma_espanol,
        select: true,
        
    });

}

function abrirModuloRegistro()
{
    $("#modal_registro").modal({ backdrop: "static", keyboard: false });
    $("#modal_registro").modal("show");
}