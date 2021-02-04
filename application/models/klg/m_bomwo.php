<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bomwo extends CI_Model
{

    public function getData()
    {
        $this->db->join('master_divisi md', 'md.id = db.id_divisi', 'left');
        $this->db->join('data_fppp df', 'df.id = db.id_fppp', 'left');
        $this->db->select('db.*,md.divisi,df.no_fppp');

        return $this->db->get('data_bomwo db');
    }

    public function insertbomwo($value = '')
    {
        $this->db->insert('data_bomwo', $value);
    }

    public function insertbomwoDetail($value = '')
    {
        $this->db->insert('data_bomwo_detail', $value);
    }

    public function getDataDetailTabel($value = '')
    {

        $this->db->where('did.id_bomwo', $value);
        return $this->db->get('data_bomwo_detail did')->result();
    }
}

/* End of file m_bomwo.php */
/* Location: ./application/models/klg/m_bomwo.php */