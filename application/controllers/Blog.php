<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Blog_model');

	}
	public function getBlogPosts()
	{
		$posts = $this->Blog_model->getBlogDetails();
		$base_url = "https://dofody.com/blog/";
		foreach($posts as $post)
		{
		    $post->post_link = $base_url . $post->post_name;
		    //$post->image = $this->Blog_model->getAttachedFiles($post->ID);
		    $post->image = base_url() . "assets/images/logo_sm.png";
		}
		print_r(json_encode($posts));
	}
    public function test()
    {
        $this->load->model('Blog_post');
        $data = $this->Blog_post->getPosts();
        print_r($data);
    }
}

?>
