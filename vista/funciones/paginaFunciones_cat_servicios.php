<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("funcionesSistemaGeneral.php");


    //$idUsuarioSesion=$_SESSION['idUsr'];
    //$cod_unidad=$_SESSION['cod_unidad'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoServicios();
        break;
        case 2:
                guardarServicios();
        break;
        case 3:
                guardarModificacionServicio();
        break;
        
    }

    function obtenerListadoServicios()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $arrRegistro="";

        $hoy=date("Y-m-d");

        $sql="";

        if($cod_unidad!='00001')
        {
            $sql=" WHERE  cod_unidad='".$cod_unidad."'";
        }

        $consulta="SELECT * FROM 4019_cat_servicios WHERE cod_unidad='".$cod_unidad."' ORDER BY idServicios";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $precio=formatearMoneda($fila[6]);

            $o='{"":"","id":"'.$fila[0].'","cod_unidad":"'.$fila[3].'","clave":"'.$fila[4].'","nomServicio":"'.$fila[5].'","precio":"'.$precio.'","precioVenta":"'.$fila[6].'","situacion":"'.$fila[7].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function guardarServicios()
    {
        global $con;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $clave=$obj->clave;
        $precio=$obj->precio;
        $nomServicio=$obj->nomServicio;
 
         $tipoOperacion="Registrar nuevo Servicio: ".$nomServicio;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 4019_cat_servicios(idResponsable,fechaCreacion,cod_unidad,clave,nom_servicio,precio,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$cod_unidad."','".$clave."','".$nomServicio."','".$precio."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionServicio()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);

    
        $idServicio=$obj->idServicio;
        $clave=$obj->clave;
        $precio=$obj->precio;
        $nomServicio=$obj->nomServicio;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Servicio: ".$idServicio." situacion: ".$situacion;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 4019_cat_servicios SET clave='".$clave."',nom_servicio='".$nomServicio."',precio='".$precio."',situacion='".$situacion."' WHERE idServicios='".$idServicio."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

?>    