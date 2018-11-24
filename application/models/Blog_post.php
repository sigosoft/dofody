<?php
class Blog_post extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    private $postLimit = 2;
    private $imagesPerPost = 1;

    public function getPosts() {
        $db1 = $this->load->database('other_db',TRUE);

        $db1->where('wp_posts.post_parent', 0);
        $db1->where('wp_posts.post_status', 'publish');
        $db1->limit($this->postLimit);
        $db1->order_by('post_date', 'DESC');

        $query = $db1->get('wp_posts');

        $data = $query->result();

        $post = array();

        for ($i = 0; $i < count($data); $i++) {
            array_push($post,
                array(
                    'post' => $data[$i],
                    'image' => $this->getPostImages($data[$i]->ID)
                )
            );
        }
        return $post;
    }

    private function getPostImages($idPost) {
        $db1 = $this->load->database('other_db',TRUE);

        $db1->where('post_type', 'attachment');
        $db1->where('post_parent', $idPost );
        $db1->limit($this->imagesPerPost);
        $db1->order_by('post_date', 'DESC');
        $image = $db1->get('wp_posts');

        if ($this->imagesPerPost > 1) {
            return $image->result();
      	} else {
      	    return $image->row();
      	}
    }
}
