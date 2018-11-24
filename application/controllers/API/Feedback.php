<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Feedback extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('Common');
	}
	public function addFeedback()
	{
		$user_id = $this->input->post('user_id');
		$user = [
			'user_id' => $user_id
		];
		$array = [
			'subject' => $this->input->post('subject'),
			'message' => $this->input->post('message'),
			'user_id' => $this->input->post('user_id')
		];
		$check = $this->Common->get_details('feedbacks',$user);
		if($check->num_rows() > 0)
		{
			$this->Common->update('user_id',$user_id,'feedbacks',$array);
		}
		else {
			$this->Common->insert('feedbacks',$array);
		}
		$return = [
			'message' => 'success'
		];
		print_r(json_encode($return));
	}
	public function getFeedback()
	{
		$user_id = $this->input->post('user_id');
		$user = [
			'user_id' => $user_id
		];
		$feedback = $this->Common->get_details('feedbacks',$user);
		if ($feedback->num_rows() > 0) {
			$return = [
				'message' => 'success',
				'feedback' => true,
				'data' => $feedback->row()
			];
		}
		else {
			$return = [
				'message' => 'success',
				'feedback' => false
			];
		}
		print_r(json_encode($return));
	}
    public function deleteFeedback()
	{
		$user_id = $this->input->post('user_id');
		$array = [
			'user_id' => $user_id
		];
		$this->Common->delete('feedbacks',$array);
		$return = [
			'message' => 'success'
		];
		print_r(json_encode($return));
	}
}

?>
