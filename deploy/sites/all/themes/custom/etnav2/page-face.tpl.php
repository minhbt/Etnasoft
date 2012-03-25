<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">    
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>"
lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
    <head>
   
   <!-- <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /> -->

	<?php echo $head; ?>

        <title><?php print $head_title; ?></title>
        <?php print $styles; ?>
        <?php print $scripts; ?>
        <?php print $harmonica_script; ?>
        <?php print $menu_script; ?>
    </head>
    <body id="front" <?php //print $body_classes; ?>>

        <div id="page-wrap">
            <div id="container">

                <div id="first-navbar" class="clearfix">
                    <a class="logo" href="<?php print $base_path; ?>" ><?php print $site_name; ?></a>
                    <?php if($primary_links): ?>
                        <?php print $primary_links_mod; ?>
                    <?php endif; ?>
                    <?php print $first_navbar; ?>
                </div> <!-- End of #header div -->
                
                <?php if ($applet_place):
                  print $applet_place;
                ?>
                <script type="text/javascript"> 
                   $(document).ready(function(){ 
                       $('#slide p').pngFix(); 
                   }); 
               </script> 
                <?php
                  endif;
                ?>

                <div id="single-line-news" class="clearfix">
                    <?php print $single_line_news; ?>
                </div> <!-- End of #single-line-news -->

                <div id="second-navbar">
                    <h1 class="breadcrumbs-root-page">About Us</h1>
                </div> <!-- End of #navbar div -->
                
               <div class="clearfix" id="content">                  
                  <div id="center"><div id="squeeze">
                     <!-- BEGIN site intro block -->
                     <div class="block clearfix" id="site-info">
                     <!-- BEGIN site info col -->
                     <div class="col-left">
                        <?php if (!empty($tabs) && $logged_in): ?>
                            <div class="tabs">
                                <?php print $tabs; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($messages) && $logged_in): print $messages; endif; ?>
                        <?php if (!empty($help) && $logged_in): print $help; endif; ?>  
                        <?php print $content; ?>
                     </div>
                     <!-- END site info col -->
                     
                     <!-- BEGIN Our Offers col -->
                     <div class="col-right">
                     <?php if(!empty($right)) : ?>
                     <h2>Our Offers</h2>                  
                     <?php print $right; ?>
                     <?php endif; ?>
                     </div> <!-- End of .right-col div -->
                     <!-- END Our Offers col -->
                     </div>
                  <!-- END site intro block -->
                  
                  <?php if(!empty($after_content)) : ?>
                  <?php print $after_content; ?>
                  <?php endif; ?>
                  </div></div>
                  
                  
                  <div id="site-right">
                     <?php if(!empty($after_right)) : ?>
                        <?php print $after_right; ?>
                     <?php endif; ?>
                  </div>
               </div>

                <!-- CONTENT END -->
                <!-- FOOTER BEGIN -->
                
                <!-- BEGIN site footer -->
               <div id="footer" class="clearfix">
                  <!-- BEGIN footer left -->
                  <div class="col-left">
                  <?php if($primary_links): ?>
                  <div id="footer-navi">
                     <?php print $primary_links_mod; ?>
                  </div>
                  <?php endif; ?>
                  </div>
                  <!-- END footer left -->
                  
                  <!-- BEGIN footer right -->
                  <div class="col-right">
                     <div id="footer-navi-right">
                      <?php
                      $footer_nav = menu_navigation_links('menu-footer-links');
                      if(!empty($footer_nav)) : ?>
                          <?php print theme('links', $footer_nav, array('class' => '')); ?>
                      <?php endif; ?>
                      </div>
                      <?php print $footer_right ?>
                      <?php print $footer_bottom; ?>
                      <?php print $footer_left; ?>
                  </div>
                  <!-- END footer right -->
               </div>
               <!-- END site footer -->                    

            </div> <!-- End of #container div -->
        </div> <!-- End of #page-wrap div -->

        <!-- FOOTER END -->
        <?php echo $before_closure; ?>
        <?php print $closure; ?>

    </body>
</html>
