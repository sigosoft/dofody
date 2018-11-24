<?php include('header.php');?>
    <nav id="header" class="navbar navbar-default navbar-custom navbar-fixed-top" role="navigation">
        <div class="container navbar-container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a id="brand" class="navbar-brand page-scroll" href="#page-top"><img src="images/logo.png" class="img-responsive"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                   
                    <li>
                        <a class="hover" href="index.php">HOME</a>
                    </li>
                    <li class="dropdown active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">PRODUCT <span class="caret"></span></a>
                <ul class="dropdown-menu"><li><a href="products-curtains&upholstry.php">curtains & upholstery</a></li>
                  <li><a href="products-wallpapers&textures.php">wallpapers & textures</a></li>
                  <li><a href="products-blinds&rods.php">blinds & rods</a></li>
                  <li><a href="products-bed linen.php">bed linen</a></li>
                  <li><a href="products-rugs&carpets.php">rugs & carpets</a></li>
                  <li><a href="products -bedding.php">bedding</a></li>
                </ul>
              </li>
                    <li>
                        <a class="hover" href="home-stylist.php">HOME STYLIST</a>
                    </li>
                    <li>
                        <a href="design-studio.php">DESIGN STUDIO</a>
                    </li>
                 <!--   <li>
                        <a class="hover" href="#">BLOG</a>
                    </li>-->
                    <li>
                        <a class="hover" href="contact.php">CONTACT</a>
                    </li>
                    <li>
                        <a class="hover" href="shop-now.php">SHOP NOW</a>
                    </li>
                    <li class="hidden-xs">
                    	<a href="#toggle-search" class=""><span class="glyphicon glyphicon-search"></span></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <section class="bed-linen">
    	<div class="container">
          <div class="row">
            <div class="center-block col-md-6 text-center new-row" style="float: none;">
              <h2>GALLERY</h2>
              <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Gallery</li> 
              </ul>
            </div>
          </div>
        </div>
    </section>
    


   <section id="works" class="works">


<div class="container">
<div class="row">



<link href="css/pagination.css" rel="stylesheet" type="text/css">
<style>
.work-item {
    float: left;
    width: 30.3%;
    position: relative;
    margin: 15px;
}

</style>




<div class="project-wrapper">
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane fade in active" id="curtains">
    
<?php
 /*   include("admin/includes/connection.php");
	
	$qry =mysql_query("select * from gallery order by id desc");
	while($row=mysql_fetch_array($qry))
	{*/
?> 
 
    
           <?php
	/*
		Place code to connect to your DB here.
	*/
	include("admin/includes/connection.php");	// include your code to connect to DB.

	$tbl_name="gallery";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name ";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "gallery.php"; 	//your file name  (the name of this file)
	$limit = 9; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM $tbl_name ORDER BY id desc LIMIT $start, $limit";
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<center><div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">Prev</a>";
		else
			$pagination.= "<span class=\"disabled\">Previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">Next</a>";
		else
			$pagination.= "<span class=\"disabled\">Next</span>";
		$pagination.= "</div></center>\n";		
	}
?>

	<?php
		while($row = mysql_fetch_array($result))
		{
	
		// Your while loop here
	
		
	echo        
 
    

		"<figure class=work-item branding isotope-item>
			<img src=admin/upload/gallery/$row[image] alt= class=img-responsive>
          	<figcaption class=overlay>
            	<h4>$row[title1]</h4>
            	<p>$row[title2]</p>
            	<a class=fancybox rel=works title=2222 href=#><i class=fa fa-arrow-circle-o-right aria-hidden=true></i></a>
          	</figcaption>
        </figure>";
      
   }
	?>

<div class="container">
<div class="row">
<?=$pagination?>
 </div>
 </div> 

    </div>



</div>


      </div>
      </div>
      </div>
      
    </section>
    
        <div tabindex="-1" class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">
 
	<div class="modal-body">
		
	</div>
   </div>
  </div>
</div>
    
    
    <div class="clearfix"></div>
      <script type="text/javascript">
        $(document).ready(function() {
          var $lightbox = $('#lightbox');
          
          $('[data-target="#lightbox"]').on('click', function(event) {
              var $img = $(this).find('img'), 
                  src = $img.attr('src'),
                  alt = $img.attr('alt'),
                  css = {
                      'maxWidth': $(window).width() - 100,
                      'maxHeight': $(window).height() - 100
                  };
          
              $lightbox.find('.close').addClass('hidden');
              $lightbox.find('img').attr('src', src);
              $lightbox.find('img').attr('alt', alt);
              $lightbox.find('img').css(css);
          });
          
          $lightbox.on('shown.bs.modal', function (e) {
              var $img = $lightbox.find('img');
                  
              $lightbox.find('.modal-dialog').css({'width': $img.width()});
              $lightbox.find('.close').removeClass('hidden');
          });
      });

        $(document).ready(function() {
        //Set the carousel options
        $('#quote-carousel , #quote-carousel2').carousel({
          pause: true,
          interval: 4000,
        });
      });
    </script>
    <script type="text/javascript">
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
} 

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
});
</script>



<?php include('footer.php');?>