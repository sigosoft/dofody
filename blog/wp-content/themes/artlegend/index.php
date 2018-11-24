<?php get_header(); ?>

<!-- Banner Area Start -->
		<div id="banner" class="banner-area bg-blue bg-1 fix">
		    <div class="container-fluid">
                <div class="banner-image-wrapper">
                    <div class="banner-image">
                        <div class="banner-image-cell">
                            <img src="<?php bloginfo('template_directory')?>/images/banner/2.png" alt="">
                        </div>
                    </div>
                </div>  
                <div class="banner-text">
                    <div class="text-content-wrapper">
                        <div class="text-content">
                            <h1 class="title1">Welcome to Dofody Blog!</h1>
                            <p>Use your phone or computer and connect face to face with a Doctor, anytime, anywhere! It works just like a normal consultation, where your Doctor takes the history, may perform examinations, order investigations and prescribe. </p>
                            <div class="banner-button">
                                <a class="default-btn button" href="#blog">Explore</a>	                
                                              
                            </div>
                        </div>
                    </div>
                </div>
		    </div>
		</div>
		<!-- Banner Area End -->
		<!-- feature Area Start -->
	<!-- 	<div id="feature" class="service-area bg-2">
		    <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-service-container">
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/voip.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Business</span>
                                    <span>VOIP</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/pbx.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Hosted</span>
                                    <span>PBX</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/sip.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Traking</span>
                                    <span>SIP</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/clock.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Call</span>
                                    <span>Center</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/resi.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Residential</span>
                                    <span>VOIP</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div> -->
                <div id="Savetime" class=" bg-2">
		    <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="savetime">
                            <h2>Save time & money with Dofody</h2>
<p>Did you know that 70% of medical ailments can be treated with telehealth technology? Save your precious tiime and your hard earned money by consulting qualified Doctors online. No need to rush to the hospital through the busy traffic and then wait another 45 minutes just to see a Doctor!</p>
                        </div>
                    </div>
                </div>
                </div>
                </div>

	         <section class="blog_header">
    	<div class="container">
          <div class="row">
            <div class="center-block col-md-12  new-row" style="float: none; margin-top:15px;">
            
              <div class="col-lg-11 col-lg-offset-1 col-md-12 col-md-offset-0 left_space_1"><h4><b>KEEP UP WITH US...</b></h4>
             
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
	
	<?php 	query_posts(array('post_type' => 'post',
								//'category_name'=>'slider',
								'showposts' => -1,
								) );  
								?>
							
								<?php while (have_posts()) : the_post(); ?>
								 <?php $sldimg = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>

      <article class="white-panel"> 
	  <div class="art-img">
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
 <?php endwhile;wp_reset_query();?>      
      
   
    </section>
  </div>
  <div  class="col-md-3">
    
 <?php include('side.php') ?>
  </div>
</div>
    </section>

    
<br><br>
<style>

</style>
<?php get_footer(); ?> 