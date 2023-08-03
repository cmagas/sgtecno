<link href="css/tablas.css" rel="stylesheet">
<link href="css/modales.css" rel="stylesheet">

<script type="text/javascript" src="js/cat_servicios.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-4">CATALOGO DE SERVICIOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Servicios</li>
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
                <table id="tbl_servicios" class="table table-striped w-100 shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>Clave</th>
                            <th>Servicio</th>
                            <th>Precio</th>
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
<div class="modal" id="modal_registro_servicio" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">REGISTRAR SERVICIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_clave">
                        <span class="small">Clave</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_clave" placeholder="Nombre">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_precio">
                        <span class="small">Precio</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control valor" id="txt_precio">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_servicio">
                        <span class="small">Nombre del Servicio</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_servicio">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="registrar_servicios()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL MODIFICACION REGISTRO-->
<div class="modal" id="modal_modificacion_servicio" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gray py-1">
                <h5 class="modal-title">MODIFICAR DATOS DE SERVICIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCerrarModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_clave_modificar">
                        <span class="small">Clave</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_clave_modificar" placeholder="Nombre">
                </div>

                <div class="col-lg-6 div_etiqueta">
                    <label for="txt_precio_modificar">
                        <span class="small">Precio</span><span class="text-danger"> *</span>
                    </label>
                    <input type="number" class="form-control valor" id="txt_precio_modificar">
                </div>

                <div class="col-lg-12 div_etiqueta">
                    <label for="txt_servicio_modificar">
                        <span class="small">Nombre del Servicio</span><span class="text-danger"> *</span>
                    </label>
                    <input type="text" class="form-control" id="txt_servicio_modificar">
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
                    <input type="text" id="txtIdServicio" hidden>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modificar_servicios()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="btnCancelarRegistro">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    listarServicios();
});
</script>