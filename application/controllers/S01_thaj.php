<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class S01_thaj extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('S01_thaj_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 's01_thaj/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 's01_thaj/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 's01_thaj/index.html';
            $config['first_url'] = base_url() . 's01_thaj/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->S01_thaj_model->total_rows($q);
        $s01_thaj = $this->S01_thaj_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            's01_thaj_data' => $s01_thaj,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
          );
        $data['_view']    = 's01_thaj/s01_thaj_list';
        $data['_caption'] = 'Tahun Ajaran';
        $this->load->view('_layout', $data);
    }

    public function read($id)
    {
        $row = $this->S01_thaj_model->get_by_id($id);
        if ($row) {
            $data = array(
            		'idthaj' => $row->idthaj,
            		'TahunAjaran' => $row->TahunAjaran,
            		'SaldoAwal' => $row->SaldoAwal,
              );
            $data['button']   = 'Read';
            $data['_view']    = 's01_thaj/s01_thaj_read';
            $data['_caption'] = 'Tahun Ajaran';
            $this->load->view('_layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('s01_thaj'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('s01_thaj/create_action'),
      	    'idthaj' => set_value('idthaj'),
      	    'TahunAjaran' => set_value('TahunAjaran'),
      	    'SaldoAwal' => set_value('SaldoAwal'),
          );
        $data['_view']    = 's01_thaj/s01_thaj_form';
        $data['_caption'] = 'Tahun Ajaran';
        $this->load->view('_layout', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            		'TahunAjaran' => $this->input->post('TahunAjaran',TRUE),
            		'SaldoAwal' => $this->input->post('SaldoAwal',TRUE),
              );
            $this->S01_thaj_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('s01_thaj'));
        }
    }

    public function update($id)
    {
        $row = $this->S01_thaj_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('s01_thaj/update_action'),
                'idthaj' => set_value('idthaj', $row->idthaj),
                'TahunAjaran' => set_value('TahunAjaran', $row->TahunAjaran),
                'SaldoAwal' => set_value('SaldoAwal', $row->SaldoAwal),
              );
            $data['_view']    = 's01_thaj/s01_thaj_form';
            $data['_caption'] = 'Tahun Ajaran';
            $this->load->view('_layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('s01_thaj'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idthaj', TRUE));
        } else {
            $data = array(
            		'TahunAjaran' => $this->input->post('TahunAjaran',TRUE),
            		'SaldoAwal' => $this->input->post('SaldoAwal',TRUE),
              );
            $this->S01_thaj_model->update($this->input->post('idthaj', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('s01_thaj'));
        }
    }

    public function delete($id)
    {
        $row = $this->S01_thaj_model->get_by_id($id);

        if ($row) {
            $this->S01_thaj_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('s01_thaj'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('s01_thaj'));
        }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('TahunAjaran', 'tahunajaran', 'trim|required');
      	$this->form_validation->set_rules('SaldoAwal', 'saldoawal', 'trim|required');

      	$this->form_validation->set_rules('idthaj', 'idthaj', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "TahunAjaran.xls";
        $judul = "Tahun Ajaran";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
      	xlsWriteLabel($tablehead, $kolomhead++, "TahunAjaran");
      	xlsWriteLabel($tablehead, $kolomhead++, "SaldoAwal");

      	foreach ($this->S01_thaj_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->TahunAjaran);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->SaldoAwal);

      	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=TahunAjaran.doc");

        $data = array(
            's01_thaj_data' => $this->S01_thaj_model->get_all(),
            'start' => 0
          );

        $this->load->view('s01_thaj/s01_thaj_doc',$data);
    }

    // aktifkan tahun ajaran sesuai pilihan user
    public function set_aktif($idthaj) {
      // simpan session data tahun ajaran
      $s01_thaj = $this->S01_thaj_model->get_by_id($idthaj);
      $this->session->set_userdata('idthaj', $idthaj);
      $this->session->set_userdata('tahun_ajaran', $s01_thaj->TahunAjaran);
      $this->session->set_userdata('saldo_awal', $s01_thaj->SaldoAwal);
      redirect('/');
    }

}

/* End of file S01_thaj.php */
/* Location: ./application/controllers/S01_thaj.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-05 09:21:25 */
/* http://harviacode.com */
