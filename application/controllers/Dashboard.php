<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function index() {
    $data['_view'] = 'dashboard/0_dash';
    $this->load->view('_layout', $data);
  }

}
