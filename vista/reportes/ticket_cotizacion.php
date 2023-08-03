<?php
    session_start();
    include_once("conexionBD.php");
    include_once("utiles.php");
    include_once("funcionesSistemaGeneral.php");
    include_once('tcpdf/tcpdf.inc.php');
    require_once('tcpdf/tcpdf_include.php');
    include_once('numeroToLetra.php');
    
    $cod_unidad=$_SESSION['cod_unidad'];

    $fechaI=date("Y-m-d");
    $folio=-1;
    $tituloDocumento="Ticket de Venta";

    $sumaSubtotal=0;
    $sumaIVA=0;
    $sumaTotal=0;

    $nombreEmpresa="Nombre de la empresa";

    if(isset($_POST['folio']))
	{
		$folio=$_POST['folio'];
    }else{
        $folio=$_GET['folio'];
    }

    $consultarDatosEmpresa="SELECT * FROM 4000_config_empresa WHERE cod_unidad='".$cod_unidad."'";
    $res=$con->obtenerPrimeraFila($consultarDatosEmpresa);
    
    if($res)
    {
        $nombreEmpresa=$res[5];
        $rfc=$res[8];
        $logo='../vista/'.$res[18];
    }

    $consultaCotizacion="SELECT * FROM 5001_cotizacion_cabecera WHERE idCotizacion='".$folio."'";
    $resCotizacion=$con->obtenerPrimeraFila($consultaCotizacion);

    $fechaCotizacion=cambiarFormatoFecha($resCotizacion[2]);
    $idCotizacion=$resCotizacion[0];
    $subTotal=$resCotizacion[5];
    $totalIVAV=$resCotizacion[6];
    $totalV=$resCotizacion[7];
    

    $numeroLetra=convertirNumeroLetra($totalV,$formatoMoneda=true,$mostrarDecimales=false);

    $consultarDetalle="SELECT * FROM 5002_cotizacion_detalle WHERE idCotizacion='".$idCotizacion."' ORDER BY idDetalleCotizacion";
    $resDetalle=$con->obtenerFilas($consultarDetalle);

    class myPdf extends TCPDF
    {
        
    }

    $pdf = new myPdf('P','mm','Letter', true, 'UTF-8', false); //array(ancho,largo)
    //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


    //Establecer los datos de Cabecera
    //$pdf->SetHeaderData('','', PDF_HEADER_TITLE, PDF_HEADER_STRING);

    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  // se define margen del texto centra
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);  //distancia de donde empieza la hoja a la cabecera
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  


    $pdf->SetFont('times', '', 10);
    $pdf->AddPage();

    //$pdf->Image('vista/fotos/empresa/no_imagen.png');

    $text=' 
            <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Ticket - Venta</title>
                    <style>
                        .logo-img {
                            width: 30%;
                        }
                        .tituloEmpresa{
                            font-size: 10pt;
                        }

                        .tituloEmpresa span{
                            font-size: 12pt;
                            font-weight: bold;
                            margin: 5px;
                        }

                        .datosFecha{
                            text-align:right;
                            font-size: 6pt;
                            font-weight: bold;
                        }
                        .datosResul{
                            font-size: 6pt;
                            margin: 5pt;
                        }

                        .cabecera{
                            font-family: helvetica;
                            font-size: 6pt;
                            font-weight: bold;
                            background-color: gray;
                        }

                        .datos{
                            font-size: 6pt;
                        }

                        .importeLetra{
                            font-family: helvetica;
                            font-size: 7pt;
                            text-align: center;
                        }

                        .montos{
                            text-align:right;
                            font-size: 6pt;
                        }

                        .formaPago{
                            text-align:center;
                            font-size: 8pt;
                        }

                    </style>
                </head>
                <body>
                    <table width="90%" border="0" align="center">
                        <tr>
                            <td width="20%" align="center">&nbsp;</td>
                            <td width="80%" align="center" colspan="4" class="tituloEmpresa p-0"><span>'.$nombreEmpresa.'</span> <br> '.$rfc.'</td>
                        </tr>
                        <tr>
                            <td width="20%" align="center">&nbsp;</td>
                            <td td width="80%" align="center" colspan="4"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td width="15%" class="datosFecha">Folio Cotizacion:</td>
                            <td width="25%" class="datosResul"><span>'.$folio.'</span> </td>
                            <td width="15%" class="datosFecha">Fecha Cotización:</td>
                            <td width="25%" class="datosResul"><span>'.$fechaCotizacion.'</span></td>
                        </tr>
                        <tr>
                            <td width="20%" align="center">&nbsp;</td>
                            <td width="80%" align="center" colspan="4">&nbsp;</td>
                        </tr>
                            
                    </table>
                    <table width="90%" border="0" align="center">
                        <tr>
                            <th width="10%" class="cabecera">CANTIDAD</th>
                            <th width="70%" class="cabecera">DESCRIPCION</th>
                            <th width="10%" class="cabecera">COSTO U.</th>
                            <th width="10%" class="cabecera">IMPORTE</th>
                        </tr>
    ';
    
    while($fila=mysql_fetch_row($resDetalle))
    {
        $idProducto=$fila[7];
        $cantidad=$fila[3];
        $precioVenta=$fila[4];
        $iva=$fila[5];
        $total=$fila[6];
        $producto=obtenerNombreProducto($idProducto);

        

    $text.='
                        <tr>
                            <td align="center" class="datos">'.$cantidad.'</td>
                            <td class="datos" align="left">'.$producto.'</td>
                            <td align="right" class="datos">'.formatearMoneda($precioVenta).'</td>
                            <td align="right" class="datos">'.formatearMoneda($total).'</td>
                        </tr>
    ';
    }
    $text.='
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <table width="90%" border="0" align="center">
                        <tr>
                            <td width="80%">&nbsp;</td>
                            <td width="10%" class="datosFecha">Subtotal</td>
                            <td width="10%" align="right" class="montos">'.formatearMoneda($subTotal).'</td>
                        </tr>
                        <tr>
                            <td width="80%">&nbsp;</td>
                            <td width="10%" class="datosFecha">IVA</td>
                            <td width="10%" align="right" class="montos">'.formatearMoneda($totalIVAV).'</td>
                        </tr>
                        <tr>
                            <td width="80%" class="importeLetra">COTIZACION SUJETA A CAMBIOS DE PRECIOS</td>
                            <td width="10%" class="datosFecha">Total</td>
                            <td width="10%" align="right" class="montos">'.formatearMoneda($totalV).'</td>
                        </tr>
                        <tr>
                            <td width="80%">&nbsp;</td>
                            <td width="10%" class="datosFecha">&nbsp;</td>
                            <td width="10%" align="right">&nbsp;</td>
                        </tr>
                        
                    </table>
                
                
                </body>
            </html>
        ';

    $js="";
    $pdf->writeHTML($text,false,0,false,0);
    $js .= 'print(true);';

    // set javascript
    $pdf->IncludeJS($js);

    //Close and output PDF document
    $pdf->Output('Cotizacion_'.$folio.'.pdf','I');


function formatearMoneda($monto)
{
	return '$ '.number_format($monto,2);
}


?>