<?php


class MYPDF extends TCPDF
{
    public function Header()
    {

        $image = base_url('assets/img/logo.png');
        $this->Image($image, 13, 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 2, 'Cetak Tarik Retur', 0, true, 'L', 0, '', 0, false, 'T', 'M');
        $this->Line(15, 20, 190, 20);
    }


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


$pdf->SetMargins(PDF_MARGIN_LEFT, 22, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



$pdf->SetAutoPageBreak(TRUE, 36);

$pdf->AddPage("P", "A4");

$tgl_skrg = date('d') . ' ' . $this->fungsi->bulan(date('m')) . ' ' . date('Y');

$html = '
<style>

table.first {
        font-size: 9pt;
        font-weight:bold;
		width:100%;
    }
</style>
<table border="0" class="first" cellpadding="1">
    <tbody>
        <tr>
            <td width="15%"></td>
            <td width="2%"></td>
            <td width="40%"></td>
            <td width="15%">Date</td>
            <td width="2%">:</td>
            <td width="20%">' . $tgl_skrg . '</td>
        </tr>
        <tr>
            <td>No Retur</td>
            <td>:</td>
            <td>' . $header->no_retur . '</td>
            <td>Jenis Retur</td>
            <td>:</td>
            <td>' . $header->jenis_retur . '</td>
        </tr>
        <tr>
            <td>Store</td>
            <td>:</td>
            <td colspan="4">' . $header->store . '</td>
        </tr>
        <tr>
            <td>Tgl Penarikan</td>
            <td>:</td>
            <td colspan="4">' . $header->tgl_penarikan . '</td>
        </tr>
        <tr>
            <td>Tgl Retur</td>
            <td>:</td>
            <td colspan="4">' . $header->tgl . '</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td colspan="4">' . $header->keterangan . '</td>
        </tr>

    </tbody>
</table><br><br><br>
';

$pdf->SetFont('Helvetica', '', 8, '', 'false');
$html .= '
<strong>Produk Retur :</strong>
<table border="0.2" cellpadding="1">
        <tr>
            <td width="30%" align="center">Item</td>
            <td width="10%" align="center">Ukuran</td>
            <td width="20%" align="center">Warna</td>
            <td width="10%" align="center">Bukaan</td>
            <td width="10%" align="center">Qty</td>
            <td width="10%" align="center">Tipe</td>
            <td width="10%" align="center">Keterangan</td>
        </tr>';
foreach ($isi->result() as $key) {

    $html .= '<tr>
            <td> ' . $key->item . '</td>
            <td align="center">' . $key->lebar . 'x' . $key->tinggi . '</td>
            <td align="center">' . $key->warna . '</td>
            <td align="center">' . $key->bukaan . '</td>
            <td align="center">' . $key->qty . '</td>
            <td align="center">' . $key->tipe . '</td>
            <td>' . $key->keterangan . '</td>
        </tr>';
}
$html .= '</table><br><br>';
if ($header->id_jenis_retur != 2 && $header->id_jenis_retur != 4) {
    $html .= '
<strong>Produk Ganti :</strong>
<table border="0.2" cellpadding="1">
        <tr>
            <td width="30%" align="center">Item</td>
            <td width="10%" align="center">Ukuran</td>
            <td width="20%" align="center">Warna</td>
            <td width="10%" align="center">Bukaan</td>
            <td width="10%" align="center">Qty</td>
            <td width="10%" align="center">Tipe</td>
            <td width="10%" align="center">Keterangan</td>
        </tr>';
    foreach ($isi->result() as $kei) {
        $html .= '<tr>
            <td> ' . $kei->item_baru . '</td>
            <td align="center">' . $kei->lebar_baru . 'x' . $kei->tinggi_baru . '</td>
            <td align="center">' . $kei->warna_baru . '</td>
            <td align="center">' . $kei->bukaan_baru . '</td>
            <td align="center">' . $kei->qty_baru . '</td>
            <td align="center">' . $kei->tipe_baru . '</td>
            <td>' . $kei->keterangan_baru . '</td>
        </tr>';
    }
    $html .= '</table><br><br>';
}
// $pdf->SetFont('Helvetica', '', 8, '', 'false');
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
            <td width="25%" align="center">Bag. Logistik</td>
            <td width="30%" align="center">SPV Admin Logistik</td>
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
$html .= '</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document

$pdf->Output($header->id . 'retur.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+