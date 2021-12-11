<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_finance extends CI_Model
{

    public function getData()
    {
        $this->db->join('data_fppp df', 'df.kode_proyek = dff.kode_proyek', 'left');
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');

        $this->db->select('dff.*,df.nama_proyek,df.applicant,df.alamat_proyek,df.sales,md.divisi');
        $this->db->group_by('dff.kode_proyek');
        $this->db->order_by('dff.id', 'desc');

        return $this->db->get('data_fppp_finance dff');
    }

    public function editRow($field = '', $value = '', $editid = '')
    {
        $this->db->query("UPDATE data_fppp_finance SET " . $field . "='" . $value . "' WHERE id=" . $editid);
    }
}

/* End of file m_finance.php */
/* Location: ./application/models/klg/m_finance.php */