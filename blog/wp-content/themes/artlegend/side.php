
<style>
	.archive_list li{
		list-style:none;
		padding: 10px 0px 10px 0px;
    border-bottom: 1px solid #ccc;
	}
	.archive_list li a{
		    text-decoration: none;
    color: #555;
	}
	.calendar-archives.calendrier {
    margin-top: 20px;
    border-radius: 0;
	
}
#custom-search-input input {

    max-width: 84%;
}
.calendar-navigation {
    background: #ccc !important;
    border-radius: 0 !important;
}
.calendar-archives.calendrier .calendar-navigation>.menu-container li>a:hover,.calendar-archives.calendrier .calendar-navigation>.menu-container li>a.selected,.calendar-archives.calendrier .month.has-posts, .calendar-archives.calendrier .day.has-posts, .calendar-archives.calendrier .month.has-posts a, .calendar-archives.calendrier .day.has-posts a {
    background: #28418d !important;
}


	</style>

    
      <div class="row">
        <div class="col-md-12">
    		<h4 class="blog_search_title">SEARCH</h4>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
				<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
                    <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="form-control input-lg" placeholder="search" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                          
							<input type="submit" id="searchsubmit" value="Search" style="margin-top:2px;background:url(<?php bloginfo('template_directory')?>/images/search.png) no-repeat;font-size:0;width:25px;" />
                        </button>
                    </span>
				</form>	
                </div>
            </div>
        </div>
      </div>
      <section>
      <h5 class="blog_right_title"><span>Latest Posts</span></h5>
      
	  
	  <div class="qa-message-list" id="">

	  
	  	<?php 	query_posts(array('post_type' => 'post',
								//'category_name'=>'slider',
								'showposts' => 3,
								) );  
								?>
								
								<?php while (have_posts()) : the_post(); ?>
								 <?php $sldimg = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
        <div class="message-item" id="">
          <div class="message-inner">
            <div class="post-container">
              <h6 class="post-date"><?php the_date('M j, Y'); ?></h6>
              <div class="post-thumb">
			  <?php
				// Must be inside a loop.
									
			if ( has_post_thumbnail() ) {?> 
			  <img src="<?php echo $sldimg; ?>" alt="<?php the_title();?>" />
			  <?php }
	else {?>
	 <img src="<?php bloginfo('template_directory')?>/images/blog.jpg" alt="<?php the_title();?>">
	<?php }
	?>
			  </div>
              <div class="post-content">
                <h4 class="post-title"><?php the_title();?></h4>
                <p><a href="<?php the_permalink();?>">Read more</a></p>
              </div>
            </div>
          </div>
        </div>

         <?php endwhile;wp_reset_query();?>  
        
      </div>
    </section>
    <?php /*<section>
    <h5 class="blog_right_title"><span>Follow us</span></h5>
    <div class="blog_follow">
    <div class="blog_social">
    	<a href="#" title="Facebook"><i class="fa fa-facebook"></i></a>
        <div class="bolg_social_status">
        <strong>4959</strong><br />
        <span>Likes</span>
        </div>
    </div>
    <div class="blog_social">
    	<a href="#" title="twitter"><i class="fa fa-twitter"></i></a>
        <div class="bolg_social_status">
        <strong>00000</strong><br />
        <span>Followers</span>
        </div>
    </div>
       
    <div class="blog_social">
    	<a href="#" title="instagram"><i class="fa fa-instagram"></i></a>
        <div class="bolg_social_status">
        <strong>1045</strong><br />
        <span>Followers</span>
        </div>
    </div>
    <div class="blog_social">
    	<a href="#" title="youtube"><i class="fa fa-youtube"></i></a>
        <div class="bolg_social_status">
        <strong>00000</strong><br />
        <span>Followers</span>
        </div>
    </div>
    
    </div>
    </section> */?>
   
    <section>
      <h5 class="blog_right_title"><span>Most commented</span></h5>
      <div class="qa-message-list" id="">
<?php $pc = new WP_Query('orderby=comment_count&posts_per_page=1'); 
		
		while ($pc->have_posts()) : $pc->the_post(); ?>
			


		
				
        <div class="message-item comment_item" id="">
          <div class="message-inner">
            <div class="post-container">
             
              <h6 class="post-date"><?php the_date('M j, Y'); ?></h6>
             
              <div class="post-thumb">  <?php
				// Must be inside a loop.
									
			if ( has_post_thumbnail() ) {?> 
			  <img src="<?php echo $sldimg; ?>" alt="<?php the_title();?>" />
			  <?php }
	else {?>
	 <img src="<?php bloginfo('template_directory')?>/images/blog.jpg" alt="<?php the_title();?>">
	<?php }
	?></div>
              <div class="post-content">
                <h4 class="post-title"><?php the_title(); ?></h4>
				<p>Posted by <strong>
<?php the_author() ?>
</strong> with <?php comments_popup_link('No Comments;', '1 Comment', '% Comments'); ?>
</p>
                <p><a href="<?php the_permalink(); ?>">Read more</a></p>
              </div>
            </div>
          </div>
        </div>
		<?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
    
      </div>
    </section>
   
   <section class="blog_archive">
   <h5 class="blog_right_title"><span>Calendar</span></h5>
     <?php archive_calendar();?>
	 </section>
      <section class="blog_archive">
      <h5 class="blog_right_title"><span>Archives</span></h5>
    
      <div class="archive_list">
	  <?php wp_get_archives( $args ); ?> 
      
       
       </div>
      </section>
	
      <section>
      <img src="<?php bloginfo('template_directory')?>/images/blog.png" width="100%" height="auto"></section>

