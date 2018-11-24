<?php get_header(); ?>

	

	<div class="row crop ">
    <img style="  position: absolute;
    top: 20%;
    right: 10%;" src="<?php bloginfo('template_directory')?>/images/crop.png" class="" >
    </div>
	<div class="row crop ">
    <img style="  position: absolute;
    top: 20%;
    left: 10%;" src="<?php bloginfo('template_directory')?>/images/home-stylist-top.png" class="" >
    </div>
	<div class="row crop ">
    <img style="  position: absolute;
    top: 20%;
    left: 40%;" src="<?php bloginfo('template_directory')?>/images/home-style-bg2.jpg" class="" >
    </div>
	


	         <section class="blog_header">
    	<div class="container">
          <div class="row">
            <div class="center-block col-md-12  new-row" style="float: none;">
			
            
              <div class="col-lg-11 col-lg-offset-1 col-md-12 col-md-offset-0 left_space_1">
			 
			 
            </div>
          </div>
        </div>
    </section>
    
 <section class="blog" id="blog">
 	<div class="container-fluid">
	<div class="col-md-2 col-xl-2 side-crop-img">
      <img src="<?php bloginfo('template_directory')?>/images/side-crop.png" class="img-responsive hidden-xs hidde-sm ">
      </div>
  <div class="col-lg-7 col-md-8 col-md-offset-0 blog_article_list">
    <section id="blog-landing">
		
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
		 <article class="white-panel"> 
		 <div class="art-img">
		 <?php $sldimg = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
	    <?php
				// Must be inside a loop.
									
			if ( has_post_thumbnail() ) {?>
	  <img src="<?php echo $sldimg; ?>" alt="<?php the_title();?>" width="50px" height="50px" >
	  <?php }
	else {?>
	 <img src="<?php bloginfo('template_directory')?>/images/blog.jpg" alt="<?php the_title();?>" width="50px" height="50px" >
	<?php }
	?></div>
      <div class="article_text">
        <h1><?php the_title();?></h1>
        <div class="article_date">
        <div class="art_date"><i class="fa fa-calendar" aria-hidden="true"></i><?php the_date('M j, Y'); ?></div>
        <div class="art_cmnt"><i class="fa fa-comment-o" aria-hidden="true"></i><?php comments_number( ); ?></div>
        </div>
       <?php the_excerpt();?>
        <div class="article_more"><a href="<?php the_permalink();?>">Read more</a></div>
        </div>
      </article>
<?php endwhile; ?>
<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
<?php else : ?>
<h2 class="center">Not Found</h2>
		 <div id="custom-search-input">
                <div class="input-group col-md-12">
				<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
                    <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="form-control input-lg" placeholder="search" />
                    <span class="input-group-btn" style="max-width:25px;">
                        <button class="btn btn-info btn-lg" type="button">
                          
							<input type="submit" id="searchsubmit" value="Search" style="margin-top:2px;background:url(<?php bloginfo('template_directory')?>/images/search.png) no-repeat;font-size:0;width:25px;" />
                        </button>
                    </span>
				</form>	
                </div>
            </div>
<?php endif; ?>
</section>
  </div>
   <div  class="col-md-3">
    
 <?php include('side.php') ?>
  </div>
</div>
    </section>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>