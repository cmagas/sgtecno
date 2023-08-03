<?php
    session_start();
    include_once("conexionBD.php");
    include_once("funcionesSistemaGeneral.php");

    $idUsuario=$_SESSION['idUsr'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoContratos();
        break;
       
    }

    function obtenerListadoContratos()
    {
        global $con;
        $arrRegistro="";

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $hoy=date("Y-m-d");

        $consulta="SELECT * FROM 5003_contratoServicios_cabecera WHERE cod_unidad='".$cod_unidad."' ORDER BY idContrato";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $idCliente=$fila[4];
            $idServicio=$fila[5];

            $nomCliente=obtenerNombreClienteProveedor($idCliente,'1');
            $nomServicio=obtenerNombreServicio($idServicio);

            $o='{"":"","id":"'.$fila[0].'","idCliente":"'.$fila[4].'","nomCliente":"'.$nomCliente.'","idServicio":"'.$fila[5].'","nomServicio":"'.$nomServicio.'","fechaInicioPago":"'.$fila[6].'","periodo":"'.$fila[7].'","importe":"'.$fila[8].'","situacion":"'.$fila[9].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
			
        }

		echo '{"data":['.$arrRegistro.']}';
    }

?>    
