<?php


class MYPDF extends TCPDF
{
    public function Header()
    {

        $image = base_url('assets/img/logo.png');
        $this->Image($image, 90, 5, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // $this->Cell(0, 0, 'FPPP', 0, true, 'C', 0, '', 0, false, 'T', 'M');
        $this->Line(15, 15, 190, 15);
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

$pdf->SetFont('Helvetica', '', 9, '', 'false');
$html = '
<style>

table.first {
        font-weight:bold;
        width:100%;
    }
</style>
<h2 align="center">FPPP</h2>
<table border="0.5" class="first" cellpadding="2">
        <tr>
            <td width="30%">Application Date</td>
            <td width="3%">:</td>
            <td width="67%">' . $header->tgl_pembuatan . '</td>
        </tr>
        <tr>
            <td>Applicant</td>
            <td>:</td>
            <td>' . $header->applicant . '</td>
        </tr>
        <tr>
            <td>Applicant Sector</td>
            <td>:</td>
            <td>' . $header->applicant_sector . '</td>
        </tr>
        <tr>
            <td>Authorized Distributor</td>
            <td>:</td>
            <td>' . $header->authorized_distributor . '</td>
        </tr>
        <tr>
            <td>No FPPP</td>
            <td>:</td>
            <td>' . $header->no_fppp . '</td>
        </tr>
        <tr>
            <td>Nama Project</td>
            <td>:</td>
            <td>' . $header->nama_proyek . '</td>
        </tr>
        <tr>
            <td>Tahap</td>
            <td>:</td>
            <td>' . $header->tahap . '</td>
        </tr>
        <tr>
            <td>Alamat Project</td>
            <td>:</td>
            <td>' . $header->alamat_proyek . '</td>
        </tr>
        <tr>
            <td>Status Order</td>
            <td>:</td>
            <td>' . $header->status_order . '</td>
        </tr>
        <tr>
            <td>Note NCR/FPPP</td>
            <td>:</td>
            <td>' . $header->note_ncr . '</td>
        </tr>
        <tr>
            <td>Pengiriman</td>
            <td>:</td>
            <td>' . $header->pengiriman . '</td>
        </tr>
        <tr>
            <td>Deadline Pengiriman</td>
            <td>:</td>
            <td>' . $header->deadline_pengiriman . '</td>
        </tr>
        <tr>
            <td>Metode Pengiriman</td>
            <td>:</td>
            <td>' . $header->metode_pengiriman . '</td>
        </tr>
        <tr>
            <td>Penggunaan Peti </td>
            <td>:</td>
            <td>' . $header->penggunaan_peti . '</td>
        </tr>
        <tr>
            <td>Penggunaan Sealant</td>
            <td>:</td>
            <td>' . $header->penggunaan_sealant . '</td>
        </tr>
        <tr>
            <td>Warna Aluminium</td>
            <td>:</td>
            <td>' . $header->warna_aluminium . '</td>
        </tr>
        <tr>
            <td>Warna Lainya</td>
            <td>:</td>
            <td>' . $header->warna_lainya . '</td>
        </tr>
        <tr>
            <td>Warna Sealant</td>
            <td>:</td>
            <td>' . $header->warna_sealant . '</td>
        </tr>
        <tr>
            <td>Ditujukan Kepada</td>
            <td>:</td>
            <td>' . $header->ditujukan_kepada . '</td>
        </tr>
        <tr>
            <td>No Telp Tujuan</td>
            <td>:</td>
            <td>' . $header->no_telp_tujuan . '</td>
        </tr>
        <tr>
            <td>Nama Ekspedisi</td>
            <td>:</td>
            <td>' . $header->pengiriman_ekspedisi . '</td>
        </tr>
        <tr>
            <td>Alamat Ekspedisi</td>
            <td>:</td>
            <td>' . $header->alamat_ekspedisi . '</td>
        </tr>
        <tr>
            <td>Nama Sales Marketing</td>
            <td>:</td>
            <td>' . $header->sales . '</td>
        </tr>
        <tr>
            <td>Nama PIC Project</td>
            <td>:</td>
            <td>' . $header->pic_project . '</td>
        </tr>
        <tr>
            <td>Admin Koordinator</td>
            <td>:</td>
            <td>' . $header->admin_koordinator . '</td>
        </tr>
        <tr>
            <td>Kaca</td>
            <td>:</td>
            <td>' . $header->kaca . '</td>
        </tr>
        <tr>
            <td>Jenis Kaca</td>
            <td>:</td>
            <td>' . $header->jenis_kaca . '</td>
        </tr>
        <tr>
            <td>Logo Kaca</td>
            <td>:</td>
            <td>' . $header->logo_kaca . '</td>
        </tr>
        <tr>
            <td>Jumlah Opening</td>
            <td>:</td>
            <td>' . $header->jumlah_gambar . '</td>
        </tr>
        <tr>
            <td>Jumlah Unit</td>
            <td>:</td>
            <td>' . $header->jumlah_unit . '</td>
        </tr>
        <tr>
            <td>Note</td>
            <td>:</td>
            <td>' . $header->note . '</td>
        </tr>
</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ob_end_clean();
//Close and output PDF document

$pdf->Output($header->nama_proyek . '_fppp.pdf', 'I');
// ob_end_clean();

//============================================================+
// END OF FILE
//============================================================+