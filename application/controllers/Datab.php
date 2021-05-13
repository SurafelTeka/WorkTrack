<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datab extends CI_Controller {


	public function index()
	{

	}

	public function delete($from, $field_id, $id_element)
	{
		$this->db->query("DELETE FROM $from WHERE $field_id = '$id_element' ");
		redirect();
	}


	public function remove_background()
	{
		$this->db->update("configs", array('conf_background_image' => null, 'conf_background_opacity' => '0.2'));
		redirect();
	}

	public function verification_process() {
        $code = $this->input->post('code');

        if ($this->sec->prc_code($code) == true) {
            echo json_encode(array('status' => 5, 'txt' => 'Thank you! Your purchase code is correct.'));

        } else {
            echo json_encode(array('status' => 2, 'txt' => 'This code is invalid. Please contact the support.'));
        }

    }

}
