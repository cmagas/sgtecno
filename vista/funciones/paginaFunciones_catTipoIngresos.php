<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");


    //$idUsuarioSesion=$_SESSION['idUsr'];
    //$cod_unidad=$_SESSION['cod_unidad'];

    if(isset($_POST["parametros"]))
        $parametros=$_POST["parametros"];
    if(isset($_POST["funcion"]))
        $funcion=$_POST["funcion"];


    switch($funcion)
    {
        case 1:
                obtenerListadoTipo();
        break;
        case 2:
                registrarNuevaTipoMovimiento();
        break;
        case 3:
                guardarModificacionTipoMov();
        break;
        
    }

    function obtenerListadoTipo()
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

        $consulta="SELECT * FROM 3002_catTipoIngresosEgresos$sql ORDER BY idTipo";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $o='{"":"","id":"'.$fila[0].'","cod_unidad":"'.$fila[3].'","nomTipo":"'.$fila[4].'","tipoMov":"'.$fila[5].'","descripcion":"'.$fila[6].'","situacion":"'.$fila[7].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevaTipoMovimiento()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $nombreMovimiento=$obj->nombreMovimiento;
        $tipoMovimiento=$obj->tipoMovimiento;
        $descripcion=$obj->descripcion;
 
         $tipoOperacion="Registrar nuevo Tipo de Movimiento: ".$nombreMovimiento;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 3002_catTipoIngresosEgresos(idResponsable,fechaCreacion,cod_unidad,nombre,tipo,descripcion,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$cod_unidad."','".$nombreMovimiento."','".$tipoMovimiento."','".$descripcion."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function guardarModificacionTipoMov()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idTipoMov=$obj->idTipoMov;
        $nombreMovimiento=$obj->nombreMovimiento;
        $tipoMovimiento=$obj->tipoMovimiento;
        $descripcion=$obj->descripcion;
        $situacion=$obj->situacion;

        $tipoOperacion="Modifica Tipo de Movimiento: ".$idTipoMov;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 3002_catTipoIngresosEgresos SET nombre='".$nombreMovimiento."',tipo='".$tipoMovimiento."',
                    descripcion='".$descripcion."',situacion='".$situacion."' WHERE idTipo='".$idTipoMov."'";
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