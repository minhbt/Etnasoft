<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">    
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>"
lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>

<?php echo $head; ?>

<title><?php print $head_title; ?></title>
<?php print $styles; ?>
<?php print $scripts; ?>
<?php print $menu_script; ?>
</head>
    <body id="custom" <?php //print $body_classes; ?>>

        <div id="page-wrap">
            <div id="container">

                <div id="first-navbar" class="clearfix">
                    <a class="logo" href="<?php print $base_path; ?>" ><?php print $site_name; ?></a>
                    <?php if($primary_links): ?>
                        <?php print $primary_links_mod; ?>
                    <?php endif; ?>
                    <?php print $first_navbar; ?>
                </div> <!-- End of #header div -->

               <div id="drop-down-menu-area">
                    <!-- It will be there as soon as possible -->
                    <img src="<?php print $random_image ?>" width="960" height="206" alt="Stub" />
                </div> <!-- End of #drop-down-menu-area -->       

                <div id="second-navbar">
                    <?php if($node_title) : ?>
                        <h1 class="breadcrumbs-root-page"><?php print $node_title; ?></h1>
                    <?php else : ?>
                        <?php print theme('breadcrumb', $breadcrumbs_arr); ?>
                    <?php endif; ?>
                </div> <!-- End of #navbar div -->

                <div id="content" class="clearfix"> 

                    <?php if (!empty($tabs) && $logged_in): ?>
                        <div class="tabs">
                            <?php print $tabs; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($messages) && $logged_in): print $messages; endif; ?>
                    <?php if (!empty($help) && $logged_in): print $help; endif; ?>  
                    <div class="left-col">
                        <?php print $content; ?>
                    </div>

                    <?php if(!empty($right)) : ?>
                    <div class="right-col">
                        <?php print $right; ?>
                    </div> <!-- End of .right-col div -->
                    <?php endif; ?>

                    <div style="clear:both"></div>
                    
                    <?php if(!empty($after_content)) : ?>
                    <div class="left-col"> 
                        <?php print $after_content; ?>
                    </div> <!-- End of .left-col div -->
                    <?php endif; ?>

                    <?php if(!empty($after_right)) : ?>
                    <div class="right-col">
                        <?php print $after_right; ?>
                    </div> <!-- End of .right-col div -->
                    <?php endif; ?>

                    <div id="footer-place"></div> <!-- End of #footer-place div -->

                </div> <!--End of #content div -->

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
