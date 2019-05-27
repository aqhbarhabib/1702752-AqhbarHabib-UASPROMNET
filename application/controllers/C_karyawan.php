<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_karyawan extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		$this->API="https://api.akhmad.id/uaspromnet/";
		$this->curl->http_header("X-Nim","1702752");
	}

	// proses yang akan di buka saat pertama masuk ke controller
	public function index()
	{
		$data['user'] = json_decode($this->curl->simple_get($this->API.'/user'));


		$this->load->view('V_User', $data);
	}

	public function get_motor(){
		$data['motor'] = json_decode($this->curl->simple_get($this->API.'/motor'))->data;


		$this->load->view('V_Motor', $data);
	}

	public function get_cicil(){
		$data['cicil'] = json_decode($this->curl->simple_get($this->API.'/cicil'))->data;


		$this->load->view('V_Cicil', $data);
	}

	public function get_uangmuka(){
		$data['uangmuka'] = json_decode($this->curl->simple_get($this->API.'/uangmuka'))->data;


		$this->load->view('V_Uangmuka', $data);
	}

	public function get_penjualan(){
		$data['penjualan'] = json_decode($this->curl->simple_get($this->API.'/penjualan'))->data->terjual;


		$this->load->view('V_Penjualan', $data);
	}

	// proses untuk menambah data
	// insert data kontak
	function add(){

		$data = array(
			'id_motor'      =>  $this->input->post('id_motor'),
			'id_cicil'    =>  $this->input->post('id_cicil'),
			'id_uang_muka'	  =>  $this->input->post('id_uang_muka'),
			'cicilan_pokok' =>  $this->input->post('cicilan_pokok'),
			'cicilan_bunga'	  =>  $this->input->post('cicilan_bunga'),
			'cicilan_total'	  =>  $this->input->post('cicilan_total'));
		$insert =  $this->curl->simple_post($this->API.'/penjualan', $data, array(CURLOPT_BUFFERSIZE => 0));

		if($insert)
		{
			$this->session->set_flashdata('hasil','Insert Data Berhasil');
		}else
		{
			$this->session->set_flashdata('hasil','Insert Data Gagal');
		}

		redirect('C_karyawan/get_penjualan');

	}


	//proses untuk menghapus data pada database
	function delete($id_penjualan){


		if(empty($id_penjualan)){
			redirect('C_karyawan/get_penjualan');
		}else{
			$delete =  $this->curl->simple_delete($this->API.'/penjualan/'.$id_penjualan, array('id_penjualan'=>$id_penjualan), array(CURLOPT_BUFFERSIZE => 10));
			if($delete)
			{
				$this->session->set_flashdata('hasil','Delete Data Berhasil');
			}else
			{
				$this->session->set_flashdata('hasil','Delete Data Gagal');
			}

			redirect('C_karyawan/get_penjualan');
		}
	}
//
// 	function edit($id){
// 		$data = array(
// 			'id'      =>  $id,
// 			'name'    =>  $this->input->post('name'),
// 			'email'	  =>  $this->input->post('email'),
// 			'address' =>  $this->input->post('address'),
// 			'phone'	  =>  $this->input->post('phone'));
// 		$edit =  $this->curl->simple_put($this->API.'/Karyawan', $data, array(CURLOPT_BUFFERSIZE => 0));
// 		if($edit)
// 		{
// 			$this->session->set_flashdata('hasil','Edit Data Berhasil');
// 		}else
// 		{
// 			$this->session->set_flashdata('hasil','Edit Data Gagal');
// 		}
//
// 		redirect('C_karyawan');
//
// }

	//TUGAS : bikin fungsi update di client menggunakan service
	//
	//
}
