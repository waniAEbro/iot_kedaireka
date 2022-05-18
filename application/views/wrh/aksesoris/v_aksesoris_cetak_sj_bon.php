<?php


class MYPDF extends TCPDF
{
    //    public function Header() {

    //    // $image = base_url('assets/img/logo.png');
    //    //  $this->Image($image, 13, 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    //    //  $this->Cell(0, 2, 'SURAT JALAN', 0, true, 'C', 0, '', 0, false, 'T', 'M');


    // }


    public function Footer()
    {

        $this->SetY(-27);

        $this->SetFont('helvetica', 'B', 8);

        $this->Cell(175, 3, 'FR-AA-MKT-03-R00 ', 0, true, 'R', 0, '', 0, false, 'T', 'M');
        $this->Line(15, 274, 190, 274);
        $this->Cell(180, 3, '', 0, true, 'R', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, true, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'PT. ALLURE ALLUMINIO ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'Rukan Artha Gading Niaga Blok B No.17, Kelapa Gading Jakarta Utara-14240, Jakarta, Indonesia ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 2, 'P. +62 21 45850530 mail@allureindustries.com ', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $imageiso = base_url('assets/img/iso9001.png');
        $this->Image($imageiso, 170, 276, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetFont('times', '', 10);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));


$pdf->SetMargins(PDF_MARGIN_LEFT, 2, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



$pdf->SetAutoPageBreak(TRUE, 36);
$pdf->SetPrintHeader(false);
$pdf->AddPage("P", "A4");

$tgl_skrg = date('d') . ' ' . $this->fungsi->bulan(date('m')) . ' ' . date('Y');
$hed = '
<table>
        <tr>
            <td width="35%"><img src="' . base_url('assets/img/logo.png') . '" width="70"></td>
            <td  width="50%"><h1>SURAT JALAN</h1></td>
        </tr>
        ';
$hed .= '</table><hr>';
// output the HTML content
$pdf->writeHTML($hed, true, false, true, false, '');
// $this->Line(15, 20, 190, 20);
$pdf->SetFont('Helvetica', '', 8, '', 'false');
$html = '
<style>

table.first {
        font-weight:bold;
		width:100%;
    }
</style>
<table border="0" class="first" cellpadding="1">
        <tr>
            <td width="15%">Penerima</td>
            <td width="1%">:</td>
            <td width="38%">' . $header->penerima . '</td>
            <td width="25%">No Surat Jalan</td>
            <td width="1%">:</td>
            <td width="20%">' . $header->no_surat_jalan . '</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>' . $header->alamat_pengiriman . '</td>
            <td>Tanggal</td>
            <td>:</td>
            <td>' . date('Y-m-d', strtotime($header->created)) . '</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>' . $header->keterangan_sj . '</td>
            <td>Sopir / No Kendaraan</td>
            <td>:</td>
            <td>' . $header->sopir . ' / ' . $header->no_kendaraan . '</td>
        </tr>
</table><br>
';
$html .= '
<table border="0.2" cellpadding="0.5">
        <tr>
            <td width="5%" align="center"><b>No</b></td>
            <td width="20%" align="center"><b>Nama Proyek - No FPPP</b></td>
            <td width="26%" align="center"><b>Nama Barang</b></td>
            <td width="7%" align="center"><b>Jumlah</b></td>
            <td width="7%" align="center"><b>Jumlah Packing</b></td>
            <td width="7%" align="center"><b>Satuan</b></td>
            <td width="15%" align="center"><b>Warna Awal</b></td>
            <td width="15%" align="center"><b>Warna Akhir</b></td>
        </tr>';
$i = 1;
$total = 0;
$pack = 0;
foreach ($detail as $key) {




    $total = $total + $key->qty_out;
    $pack = $pack + 1;
    $html .= '<tr>
                    <td align="center">' . $i++ . '</td>
                    <td align="center"> ' . $key->nama_proyek . '<br>' . $key->no_fppp . '</td>
                    <td align="center"> ' . $key->item_code . ' - ' . $key->deskripsi . '</td>
                    <td align="center">' . $key->qty_out . '</td>
                    <td align="center">1</td>
                    <td align="center">' . $key->satuan . '</td>
                    <td align="center">' . $key->warna_awal . '</td>
                    <td align="center">' . $key->warna_akhir . '</td>
                </tr>';
}
$html .= '<tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">' . $total . '</td>
            <td align="center">' . $pack . '</td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            </tr>
            </table><br><br>';
$html .= '
<style>
table.ttd {
        font-size: 7pt;
        width:100%;
    }
</style>
<table border="0.2" class="ttd"cellpadding="1">
        <tr>
            <td width="15%" align="center">Tanda Terima</td>
            <td width="15%" align="center">Sopir</td>
            <td width="25%" align="center">Dibuat Oleh / Logistik</td>
            <td width="30%" align="center">Diketahui Oleh / SPV Logistik</td>
            <td width="15%" align="center">Security</td>
        </tr>
        <tr>
            <td style="height:30px;" width="15%" align="center"></td>
            <td width="15%" align="center"></td>
            <td width="25%" align="center"></td>
            <td width="30%" align="center"></td>
            <td width="15%" align="center"></td>
        </tr>
        <tr>
            <td width="15%">Nama :<br>Tanggal :</td>
            <td width="15%">Nama :<br>Tanggal :</td>
            <td width="25%">Nama :<br>Tanggal :</td>
            <td width="30%">Nama :<br>Tanggal :</td>
            <td width="15%">Nama :<br>Tanggal :</td>
        </tr>
        ';
$html .= '</table><br><br>';

$html .= '
<table class="ttd"cellpadding="1">
        <tr>
            <td>*Putih:Finance   Merah:Eksternal   Kuning:Logistik   Hijau:SCM</td>
        </tr>
        <tr>
            <td>*Barang diatas merupakan barang titipan PT. Allure Alluminio</td>
        </tr>
        <tr>
            <td>*Info User : ' . $header->nama . '</td>
        </tr>
        ';
$html .= '</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document
// $pdf->Output(base_url('filepdf') . '/' . $header->nama_proyek . '_SJ_BOM.pdf', 'F');

// $filename = $header->nama_proyek . '_SJ_BOM.pdf';
// $filelocation = "C:\\xampp\\htdocs\\warehouse\\filepdf"; //windows C:\xampp\htdocs\warehouse\filepdf
// $filelocation = $_SERVER['DOCUMENT_ROOT'] . "\\warehouse\\filepdf"; //windows C:\xampp\htdocs\warehouse\filepdf
// $filelocation = "/var/www/project/custom"; //Linux

// $fileNL = $filelocation . "\\" . $filename; //Windows
// $fileNL = $filelocation."/".$filename; //Linux

// $pdf->Output($fileNL, 'F');
$pdf->Output($header->nama_proyek . '_SJ_BOM.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+