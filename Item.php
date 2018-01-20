<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Item extends CI_Controller{
	function__construct()
	{
		parent::__conscruct();
		$this->load->library(array('template','form_validation'));
		$this->load->model('app_admin')
	}
	public function index() 
	{

	}	
	public function add_item()
	{
		if ($this->input->post('submit', TRUE)=='submit') {
			//validation
			$this->form_validation->set_rules('nama','Nama Item','required|min_length[4]')
			$this->form_validation->set_rules('harga','Harga Item','required|numeric')
			$this->form_validation->set_rules('berat','Berat Item','required|numeric')
			$this->form_validation->set_rules('status','Status Item','required|numeric')
			$this->form_validation->set_rules('desk','Deskripsi Item','required}min_length[4]')

			if ($this->form_validation->run() == TRUE) {
				$config['upload_path']='./img/upload/';
				$config['allowed_types'] = 'jpg}png|jpeg';
				$config['max_size']='2048';
				$config['file_name'] ='gambar'.time();

				$this->load->libary('upload',$config);
				if ($this->upload->db_upload('foto'))
				{
					$gbr = $this->load->data();
						//proses Insert
				$items = array(
					'nama_item' => $this->input->post('nama', TRUE),
					'harga' => $this->input->post('harga', TRUE),
					'berat' => $this->input->post('berat', TRUE),
					'status' => $this->input->post('status', TRUE),
					'gambar' => $gbr['file_name'],
					'deskripsi' => $this->input->post('desk', TRUE),
				);
				$this->admin->insert('t_items', $items);
				} else{
					$this->session->set_flashdata('alert','anda belum memilih foto')
				}
			
			}
		}

		$data['nama'] = $this->input->post('nama', TRUE);
		$data['berat'] = $this->input->post('berat', TRUE);
		$data['harga'] = $this->input->post('harga', TRUE);
		$data['status'] = $this->input->post('status', TRUE);
		$data['desk'] = $this->input->post('desk', TRUE);
		$data['header']= "Add New Item";
		$this->template->admin('admin/item_form', $data);
	}
}