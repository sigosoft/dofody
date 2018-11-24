<?php

class Blog_model extends CI_Model
{
  
  private $postLimit = 2;
  private $imagesPerPost = 1;
    
  function __construct()
  {
    $this->load->database('other_db',TRUE);
  }

  function getBlogDetails()
  {
      $db1 = $this->load->database('other_db',TRUE);

      $db1->select('wp_posts.post_title,wp_posts.post_name,wp_posts.ID,wp_posts.post_date,wp_users.user_login');
      $db1->from('wp_posts');
      $db1->join('wp_users','wp_posts.post_author=wp_users.ID');
      $db1->where('wp_posts.post_status','publish');
      $db1->where('wp_posts.post_type','post');
      $db1->limit(5);
      return $db1->get()->result();
  }
  function getAttachedFiles($id)
  {
      $db1 = $this->load->database('other_db',TRUE);
      
      $db1->select('meta_value');
      $db1->from('wp_postmeta');
      $db1->where('meta_key','_wp_attached_file');
      $db1->where('post_id',$id);
      return $db1->get()->row();
  }
  public function getPostImages($idPost) {
        $db1 = $this->load->database('other_db',TRUE);

        $db1->where('post_type', 'attachment');
        $db1->where('post_parent', $idPost );
        $db1->limit(2);
        $db1->order_by('post_date', 'DESC');
        $image = $db1->get('wp_posts');

        /*if ($this->imagesPerPost > 1) {
            return $image->result();
      	} else {
      	    return $image->row();
      	}*/
      	return $image;
    }
}

?>
