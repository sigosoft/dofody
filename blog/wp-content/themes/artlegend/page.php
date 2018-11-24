<?php get_header(); ?>
<?php include('flex.php') ?>
<style>
  input {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    margin-left: 15px;
    margin-bottom: 2%;
    padding-right: 9px;
}
textarea#comment {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 5px;
}
p.comment-form-author ,p.comment-form-email,p.comment-form-url{
    width: 50%;
	float:left;
}
p.comment-form-author input, p.comment-form-email input,p.comment-form-url input{
	    border: 1px solid #ccc;
    height: 35px;
    border-radius: 5px;
}
.comment {
    border: 1px solid #cccccc52;
    padding: 10px;
    margin-bottom: 15px;
    background: #fdf4f4ab;
}
input#submit{
	color: #fff;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: 400;
    background: #ed148f;
    border-radius: 0;
    margin-right: 2%;
    padding: 11px 50px;
    border-color: transparent;
    margin-top: 20px;
}

#comment-box{
      width: 84.333333%;
}
.sin-blg #custom-search-input input{
      width: 75% !important;
}
.post-image img{
  width:80px;
  height:60px;


}
 @media (max-width:480px) {

post-date {
    font-size:8px!important;
    margin-top: 0;
    color: #989898;
}

}


</style>

  



    <!-- Navigation -->

    
    <div class="row crop ">
    <img style="  position: absolute;
    top: 20%;
    right: 10%;" src="<?php bloginfo('template_directory')?>/images/crop.png" class="" >
    </div>
    <br>
        
    <div class="container " style="margin-top: 15%;" >
    <div class="head-area" style="margin-left: 12%;">
      <h1 style="  font-family: 'Montserrat', sans-serif; font-size: 28px;font-weight: 900;padding-bottom: 2%;"><?php echo $row['dtitle']; ?></h1>
      <!-- <span style=" color: #6f6f6f;font-size: 22px;font-style: italic; padding-bottom: 10%;font-family: Serif72Beta;" class="tagline" >Read about the goings on</span> -->
      </div>
    
      </div>
         
      
   
<div class="container-fluid sin-blg">

    
  <!-- welcome content -->
      <div class="row welcome" >
      <div class="col-md-2 col-xl-2 side-crop-img">
      <img src="<?php bloginfo('template_directory')?>/images/side-crop.png" class="img-responsive hidden-xs hidde-sm ">
      </div>

           <div class="col-md-7  col-sm-8 col-lg-6 col-xl-7  content-area " > <!-- left panel -->
		   <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
    <h3 class="content-head" style="font-family: Serif72Beta;"><?php the_title(); ?></h3>
          

<?php /* <div class="flexslider">
  <ul class="slides">

  

  <li>
          <img src="<?php the_post_thumbnail_url( );?>" width="720px" height="290px" alt="a project image" style="max-width:100%;" />
    </li>
	<li>
          <img src="<?php the_post_thumbnail_url( );?>" width="720px" height="290px" alt="a project image" style="max-width:100%;" />
    </li>
	<li>
          <img src="<?php the_post_thumbnail_url( );?>" width="720px" height="290px" alt="a project image" style="max-width:100%;" />
    </li>


    
   
   
  </ul>
</div> */ ?>
<div class="slider-sec">
<img src="<?php the_post_thumbnail_url( );?>" width="720px" height="290px" alt="a project image" style="max-width:100%;height:auto;" />
</div>


            <!-- <a class=" baner btn btn-lg btn-primary" href="#" role="button">SHOP NOW</a>  -->
           
                 <div class="sub-meta" style=" font-family: 'Montserrat', sans-serif;
    color: #6f6f6f;
    font-style: italic;
    font-size: 10px;
    border-top: 1px solid #6f6f6f;
    border-bottom: 1px solid #6f6f6f; padding: 5px;
    margin-top: 3%;">
    
          <span class="post-date">
            <i class="fa fa-calendar" aria-hidden="true"></i> <?php the_date('M j, Y'); ?> 
          </span>
          <div class="pull-right"  >
          <span class="post-date">
            <i  class="fa fa-comment-o" aria-hidden="true"></i> <?php comments_number( ); ?>
          </span>
          <span class="post-date" >
            <i class="fa fa-user" aria-hidden="true"></i> POSTED BY : <?php the_author(); ?> 
          </span>
          </div>
        </div>
        <div class="blog-content">
        <p style="margin-top: 2%;">
         <?php the_content();?>
        
</p>

</div>
 <hr>
<span style="font-size: 20px;" class="comment-count"><?php comments_number( ); ?> </span><span style="font-size: 20px;" class="comment-count pull-right "></span>
 <hr>
 

 <?php endwhile; endif; ?>
    
         
    <br>
    <br>
   
 </div>

<div class="col-md-3 col-lg-3 col-sm-4 right-side " style="margin-left: ">
             <?php include('side.php') ?>
    </div>
  </div>

   </div>
 </div>
   </div>
 


  </div>
</div>
</div>
 </div>
</div>
 

<?php get_footer(); ?>