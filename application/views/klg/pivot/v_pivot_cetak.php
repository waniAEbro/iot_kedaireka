<?php


// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pageLayout = array('330', '216'); //  or array($height, $width) 
$pdf = new TCPDF('L', 'mm', $pageLayout, true, 'UTF-8', false);
// set font
$pdf->SetFont('times', '', 12);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// add a page
$pdf->SetMargins(10, 2, 10, false);
$pdf->setPageOrientation('L',$autopagebreak = 'false',$bottommargin = '2');		
$pdf->AddPage();
// create some HTML content

// $tgl_skrg = date('d').' '.$bln_sekarang.' '.date('Y');
// $barcode = base_url().'pak/dashboard/bikin_barcode/'.$nip;

// $img = file_get_contents(base_url().'pak/dashboard/bikin_barcode/'.$nip);
// $pdf->Image($img, 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// EAN 13

// define barcode style
$style = array(
    'position'     => '',
    'align'        => 'C',
    'stretch'      => false,
    'fitwidth'     => true,
    'cellfitalign' => '',
    'border'       => true,
    'hpadding'     => 'auto',
    'vpadding'     => 'auto',
    'fgcolor'      => array(0,0,0),
    'bgcolor'      => false, //array(255,255,255),
    'text'         => true,
    'font'         => 'helvetica',
    'fontsize'     => 0,
    'stretchtext'  => 4
);
// $img = base_url('assets/img/dikti.png');
$pdf->SetFont('Helvetica', '', 9, '', 'false');
$html = '
<table cellpadding="0">
  <tr>
    <td colspan="2" align="center"><h1>PIVOT TABLE SUMMARY</h1></td>
    <td align="right"><b>tgl cetak : '.date('d M Y').'</b></td>
  </tr>
</table>
<br>
<br>';
$colspan = $byk_bukaan;
$html .= '<table border="1" width="100%" cellpadding="2">
        <tr bgcolor="#ffe357">
          <th rowspan="2" width="2%" align="center">No</th>
          <th rowspan="2" align="center" width="15%">Item</th>';
          $j=0;
          foreach ($warna->result() as $wa) {
$html .= '<th colspan="'.$colspan.'" width="8%" align="center">'.$wa->warna.'</th>';
          $j++;
          }
$html .= '</tr>
        <tr bgcolor="#ffe357">';
        for ($x=1; $x <= $j; $x++) { 
foreach ($bukaan->result() as $bu) {
$html .= '<th align="center">'.$bu->bukaan.'</th>';
          }          

        }
 $html .= '</tr>';
      $i=1;
      foreach ($item->result() as $val) {
       
$html .= '<tr>
          <td align="center">'.$i++.'</td>
          <td>'.$val->item.'</td>';
        foreach ($warna->result() as $war) { 
foreach ($bukaan->result() as $bua) { 
$st = $this->m_summary->getrowJum($val->id,$war->id,$bua->bukaan);
        if ($st > 0) {
           $st_tampil = $st;
         } else {
            $st_tampil = '-';
         }
                  
$html .= '<td align="center">'.$st_tampil.'</td>';
}
        }
$html .= '</tr>';
         
      }
$html .= '
    </table>';

$pdf->writeHTML($html, true, false, true, false, '');
$date = date('d M Y H:i:s');

// $pdf->Write(0, 'dicetak pada : '.$date.' di simpakdos.unnes.ac.id', '', 0, 'R', true, 0, false, false, 0);
// $style['position'] = 'R';
// $pdf->write1DBarcode($nip, 'C128A', '', '', '', 8, 0.3, $style, '');
// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('Pivot.pdf', 'I');
// save file
// $pat = base_url().'db/';
// $pdf->Output($pat.$nomor_new.'.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+