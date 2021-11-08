<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_finance extends CI_Model
{

    public function getData()
    {
        $this->db->join('data_fppp df', 'df.kode_proyek = dff.kode_proyek', 'left');
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');

        $this->db->select('dff.*,df.nama_proyek,df.applicant,df.alamat_proyek,df.sales,md.divisi');

        return $this->db->get('data_fppp_finance dff');
    }
}

/* End of file m_finance.php */
/* Location: ./application/models/klg/m_finance.php */