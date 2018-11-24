 <link rel="stylesheet" href="<?php bloginfo('template_directory')?>/css/flexslider.css" type="text/css" media="screen" />
 <script defer src="<?php bloginfo('template_directory')?>/js/jquery.flexslider.js"></script>
<script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>