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
                obtenerListadoCajaChica();
        break;
        case 2:
                registrarNuevoMovimientoCaja();
        break;
        case 3:
                guardarModificacionCajaChica();
        break;
        case 4:
                calcularSaldoCaja();
        break;
        
    }

    function obtenerListadoCajaChica()
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

        $consulta="SELECT * FROM 5004_cajaChica$sql ORDER BY fechaMov,idMovCaja";
        $res=$con->obtenerFilas($consulta);

        while($fila=mysql_fetch_row($res))
		{
            $fechaMovVista=cambiarFormatoFecha($fila[4]);
            $nombreMovimiento=obtenerNombreMovimiento($fila[5]);
            $importeVista=formatearMoneda($fila[6]);

            if($fila[7]==1)
            {
                $tipo="INGRESO";
            }else{
                $tipo="EGRESO";
            }

            $o='{"":"","id":"'.$fila[0].'","cod_unidad":"'.$fila[3].'","fechaMovVista":"'.$fechaMovVista.'","fechaMov":"'.$fila[4].'","idMovimiento":"'.$fila[5].'","nombreMovimiento":"'.$nombreMovimiento.'","tipo":"'.$tipo.'","importe":"'.$fila[6].'","importeVista":"'.$importeVista.'","situacion":"'.$fila[8].'"}';
			
			if($arrRegistro=="")
				$arrRegistro=$o;
			else
				$arrRegistro.=",".$o;
        }

		echo '{"data":['.$arrRegistro.']}';
    }

    function registrarNuevoMovimientoCaja()
    {
        global $con;
        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $fechaMovimiento=$obj->fechaMovimiento;
        $importe=$obj->importe;
        $idTipoMov=$obj->idTipoMov;
        $valor=$obj->valor;
 
         $tipoOperacion="Registrar nuevo Movimiento";

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="INSERT INTO 5004_cajaChica(idResponsable,fechaCreacion,codigo_unidad,fechaMov,idMovimiento,importe,clave,situacion)VALUES('".$idUsuarioSesion."',
                    '".$fechaActual."','".$cod_unidad."','".$fechaMovimiento."','".$idTipoMov."','".$importe."','".$valor."','1')";
        $x++;

        $consulta[$x]="commit";
        $x++;
        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(2,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function  guardarModificacionCajaChica()
    {
        global $con; 
        $fechaActual=date("Y-m-d");

        $cadObj=$_POST["cadObj"];

        $obj="";

        $obj=json_decode($cadObj);
    
        $idMovimiento=$obj->idMovimiento;
        $fechaMovimiento=$obj->fechaMovimiento;
        $importe=$obj->importe;
        $idTipoMov=$obj->idTipoMov;
        $situacion=$obj->situacion;

        if($idTipoMov==1)
        {
            $valor=1;
        }else{
            $valor=-1;
        }

        $tipoOperacion="Modifica Movimiento Caja: ".$idMovimiento;

        $x=0;
        $consulta[$x]="begin";
        $x++;

        $consulta[$x]="UPDATE 5004_cajaChica SET fechaMov='".$fechaMovimiento."',idMovimiento='".$idTipoMov."',
                importe='".$importe."',clave='".$valor."',situacion='".$situacion."' WHERE idMovCaja='".$idMovimiento."'";
        $x++;

        $consulta[$x]="commit";
        $x++;

        
        if($con->ejecutarBloque($consulta))
        {
            guardarBitacoraAdmon(3,"$tipoOperacion",$_SESSION['idUsr'],'');
            echo "1|";
        } 
    }

    function calcularSaldoCaja()
    {
        global $con;

        $valor=0;

        $idUsuarioSesion=$_SESSION['idUsr'];
        $cod_unidad=$_SESSION['cod_unidad'];

        $consulta="SELECT SUM(importe * clave) AS total FROM 5004_cajaChica WHERE situacion='1' AND codigo_unidad='".$cod_unidad."'";
        $res=$con->obtenerValor($consulta);

        if($res)
        {
            $valor=$res;
        }

        $o='{"valor":"'.$valor.'"}';

        echo $o;

    }

?>    