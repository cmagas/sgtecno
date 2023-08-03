<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/contrato_servicios.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CONTRATO DE SERVICIOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Contrato Servicios</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!--DATOS-->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_contratos" class="table table-striped w-100 shadow" border="1">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Servicio</th>
                            <th>Cliente</th>
                            <th>Importe</th>
                            <th>T. Abonos</th>
                            <th>Estatus</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<!--MODAL NUEVO COMPRA-->
<div class="modal" id="modal_registro" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR CONTRATACION SERVICIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <!--NOMBRE CLIENTE-->
                    <div class="col-lg-12 div_etiqueta">
                        <label for="txt_cliente">
                            <span class="small">Cliente</span><span class="text-danger"> *</span>
                        </label>
                        <input type="text" class="form-control" id="txt_cliente">
                    </div>

                    <!--SERVICIO-->
                    <div class="col-lg-12 div_etiqueta">
                        <label for="txt_servicio">
                            <span class="small">Servicio</span><span class="text-danger"> *</span>
                        </label>
                        <input type="text" class="form-control" id="txt_servicio">
                    </div>

                    <!--FECHA PAGO-->
                    <div class="col-lg-4 div_etiqueta">
                        <label for="txt_fechaPago">
                            <span class="small">Fecha Inicio Pago</span><span class="text-danger"> *</span>
                        </label>
                        <input type="date" class="form-control" id="txt_fechaPago">
                    </div>

                    <!--CAMPO PERIODO PAGO-->
                    <div class="col-lg-4 div_etiqueta">
                        <label for="cmb_periodo">
                            <span class="small">Periodo de pago</span><span class="text-danger"> *</span>
                        </label>
                        <select class="js-example-basic-single form-control" id="cmb_periodo" style="width: 100%;">
                            <option value="-1">Seleccione el Periodo</option>
                            <option value="1">Único</option>
                            <option value="2">Mensual</option>
                        </select>
                    </div>

                    <!--IMPORTE-->
                    <div class="col-lg-4 div_etiqueta">
                        <label for="txt_importe">
                            <span class="small">Importe</span><span class="text-danger"> *</span>
                        </label>
                        <input type="number" class="form-control" id="txt_importe">
                    </div>

                </div>
                <!--FIN ROW-->

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_compra()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>

        </div>
    </div>
</div>





<script>
$(document).ready(function() {
    listarServiciosContratados();
});
</script>