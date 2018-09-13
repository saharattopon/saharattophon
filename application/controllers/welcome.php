<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('add_model');
		$this->load->helper('form');
		$this->load->helper('url');
	}


	public function index()
	{
		$this->load->view('home');
		//$this->load->view('welcome_message');
	}
	public function addform()
	{
		$this->load->view('add_w');
	}
	public function add(){
		$data['title']="เพิ่ม";
		//$data['level']="E1-5";
		$data['nums']=$this->add_model->get_row("collect");
		$this->load->view('add_w',$data);
		//echo "OK";
		if($this->input->post('btnsave')!=null){
			$data = array(
				'id' => '',
				'name' => $this->input->post("name"),
				'date' => $this->input->post("date"),
				'time' => $this->input->post("time"),
				'tel' => $this->input->post("tel"),
				'status' => $this->input->post("status"));
			$this->db->insert('collect',$data);
			//echo $user ;
			redirect("welcome/showusers","refresh");
			exit();
		}
	}
	public function editt($id){
		//echo "id".$id;
		$sql="select * from collect where id='$id'";
		$rs=$this->db->query($sql);
		if ($rs->num_rows()==0){
			$data['rs']=array();
		}else{
			$data['rs']=$rs->row_array();
		}
			$this->load->view("editview",$data);
	}
	public function editt2(){
		if($this->input->post('btnsave')!=null){
			$id = $this->input->post("id");
			$data = array(
				'name' => $this->input->post("name"),
				'date' => $this->input->post("date"),
				'time' => $this->input->post("time"),
				'tel' => $this->input->post("tel"),
				'status' => $this->input->post("status"));
			$this->db->update('collect',$data, array('id' => $id));
			redirect("welcome/show","refresh");
			exit();
		}


	}
	public function show(){
		$sql="select * from collect";
		$rs=$this->db->query($sql);
		$data['rs']=$rs->result_array();
		$this->load->view('showview',$data);
	}
	public function del($id){
		$this->db->delete('collect',array('id' => $id));
		redirect("welcome/show","refresh");
		exit();
	}
	public function showusers(){
		$sql="select * from collect";
		$rs=$this->db->query($sql);
		$data['rs']=$rs->result_array();
		$this->load->view('showuser',$data);
	}
	

	
public function login(){
	$this->load->view('login');
}
	
public function chk_login()

	{	
		$username  = $this->input->post('username');
		$password  = $this->input->post('password');

	$numr = $this->db->query("SELECT * from admin where name='$username' && password='$password'");
		$chknum = $numr->num_rows();
		if($chknum==1){ 

			foreach ($numr->result() as $row)
			{
			   
			    $name =$row->name;
				$id =$row->id;

			$data = array(
				'id'=>$id,
				'name'=>$name
						);
			//$this->session->set_userdata($data);

			//if($status=="admin"){
			redirect("welcome/show","refresh");
		///admin
			//if($status=="user"){
			//redirect("welcome/user_index","refresh");
		///user
		
		}
	}
	////user&pass OK
		else{
			echo "no";
			echo "SELECT * from admin where name='$username' && password='$password'";
		}
	

	
}



}