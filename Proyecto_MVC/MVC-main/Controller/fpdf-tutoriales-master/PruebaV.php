<?php
session_start();
$total=0;
$codigo =$_GET["codigo"];
/*foreach($_SESSION["Mis_Cupones"] as $cupones => $cupon){     
   
       $total += $cupon["Cantidad"]* $cupon["Precio"];
}*/
require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      //$this->Image('../img/28f1a972e13e4281b5273891ead173eb.jpg', 185, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode('Cuponera'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(96, 10, utf8_decode("Usuario : ### "), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : ### "), 0, 0, '', 0);
      $this->Ln(5);

      /* COREEO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Correo : ####"), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Sucursal : ### "), 0, 0, '', 0);
      $this->Ln(10);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(228, 100, 0);
      $this->Cell(50); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE CUPONES "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(35, 10, utf8_decode('Codigo'), 1, 0, 'C', 1);
      $this->Cell(80, 10, utf8_decode('Titulo'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Precio ($)'), 1, 0, 'C', 1);
      $this->Cell(45, 10, utf8_decode('Cantidad'), 1, 1, 'C', 1);
      //$this->Cell(70, 10, utf8_decode('CARACTERÍSTICAS'), 1, 0, 'C', 1);
      //$this->Cell(25, 10, utf8_decode('ESTADO'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;
/* TABLA */
foreach($_SESSION["Mis_Cupones"] as $cupones => $cupon){
if($codigo == $cupon['ID_Cupon']){
$pdf->Cell(35, 10, utf8_decode( $cupon['ID_Cupon']), 1, 0, 'C', 0);
$pdf->Cell(80, 10, utf8_decode($cupon['Titulo_Oferta']), 1, 0, 'C', 0);
$pdf->Cell(30, 10, utf8_decode($cupon['Total']), 1, 0, 'C', 0);
$pdf->Cell(45, 10, utf8_decode($cupon['Cantidad']), 1, 1, 'C', 0);
break;
}
}
$pdf->SetTextColor(228, 100, 0);
$pdf->Cell(85); // mover a la derecha
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(60, 10, utf8_decode('Total: $' ), 1, 0, 'C', 0);
$pdf->Ln(0);
$pdf->SetTextColor(228, 100, 0);
$pdf->Cell(85); // mover a la derecha
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(90, 10, utf8_decode($cupon['Total']), 0, 1, 'C', 0);
$pdf->Ln(7);
//$pdf->Cell(70, 10, utf8_decode("info"), 1, 0, 'C', 0);
//$pdf->Cell(25, 10, utf8_decode("total"), 1, 1, 'C', 0);


$pdf->Output('I', /*'./../PDF/Prueba.pdf'*/'MisCupones.pdf' /*'I'*/);//nombreDescarga, Visor(I->visualizar - D->descargar)
//$pdf->Output('Prueba.pdf', 'I');
//header("Location: ../carrito.php");
