<?php
    include("conexionBD.php");

?>

<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">
<link href="css/cajaChica.css" rel="stylesheet">

<script type="text/javascript" src="js/cajaChica.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-3">
                <h1 class="mt-4">CAJA CHICA</h1>
            </div>
            <div class="col-sm-3 saldo_caja">
                <h5 class="mt-4 ">SALDO CAJA : <span id="saldoCaja">$ 0.00</span></h5>
            </div> 
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Caja Chica</li>
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
                <table id="tbl_tipoMovimientoCaja" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Folio</th>
                            <th>Movimiento</th>
                            <th>Fecha</th>
                            <th>Importe</th>
                            <th>Tipo</th>
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

<!--MODAL NUEVO REGISTRO-->
<div class="modal" id="modal_registro" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR MOVIMIENTO CAJA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaMov">
                        <span class="small">Fecha Movimiento</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaMov">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_importe">
                        <span class="small">Importe</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_importe">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="cmb_tipoMovimiento">
                        <span class="small">Tipo de Movimiento</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipoMovimiento" style="width: 100%;">
                        <option value="-1">Seleccione el Tipo</option>
                        <?php
                                $Consulta="SELECT idTipo,nombre FROM 3002_catTipoIngresosEgresos WHERE situacion='1' ORDER BY nombre";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_movimiento()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICAR REGISTRO-->
<div class="modal" id="modal_modificar_registro" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">MODIFICAR MOVIMIENTO CAJA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_fechaMov_modificar">
                        <span class="small">Fecha Movimiento</span><span class="text-danger"> *</span>
                    </label>
                    <input type="date" class="form-control" id="txt_fechaMov_modificar">
                </div>
                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_importe_modificar">
                        <span class="small">Importe</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control" id="txt_importe_modificar">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="cmb_tipoMovimiento_modificar">
                        <span class="small">Tipo de Movimiento</span><span class="text-danger"> *</span>
                    </label>
                    <select class="js-example-basic-single form-control" id="cmb_tipoMovimiento_modificar" style="width: 100%;">
                        <option value="-1">Seleccione el Tipo</option>
                        <?php
                                $Consulta="SELECT idTipo,nombre FROM 3002_catTipoIngresosEgresos WHERE situacion='1' ORDER BY nombre";
                                $con->generarOpcionesSelect($Consulta);
                            ?>
                    </select>
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_Situacion">
                        <span class="small">Estatus</span><span class="text-danger"> *</span>
                    </label>
                    <select id="txt_Situacion" style="width: 100%;" class="form-control">
                        <option value="-1">Seleccione Estatus</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <input type="text" id="txtIdMovimiento" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_movimiento()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        listarMovimientoCaja();
        recalcularSaldo();
    });
</script>