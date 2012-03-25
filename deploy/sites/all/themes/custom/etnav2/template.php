<?php

function etnav2_preprocess(&$vars, $hook) {
    if($hook == 'page') {

        // Working with base css styles
        $css = $vars['css'];
        unset($css['all']['module']['modules/system/defaults.css']);
        $vars['styles'] = drupal_get_css($css);

        // Adding conditional styles fo IE
        $query_string = '?'. substr(variable_get('css_js_query_string', '0'), 0, 1);
        $base_path = base_path() . drupal_get_path('theme', 'etnav2');
        $vars['styles'] .= <<< IE_STYLES
<!--[if lte IE 8]><link type="text/css" rel="stylesheet" media="all" href="$base_path/css/ie.css$query_string" /><![endif]-->
IE_STYLES;
        
        // Adding some scripts variables specific for template
         $vars['harmonica_script'] = <<< H_SCRIPT
<script type="text/javascript" src="$base_path/js/jquery.cycle.all.min.js$query_string"></script>
<script type="text/javascript" src="$base_path/js/jquery.pngFix.pack.js$query_string"></script>
H_SCRIPT;

         $vars['menu_script'] = <<< M_SCRIPT
<script type="text/javascript" src="$base_path/js/menu.js$query_string"></script>
M_SCRIPT;

        // Adding Jquery UI librarie
        //jquery_ui_add('ui.dialog');

        $vars['breadcrumbs_arr'] = drupal_get_breadcrumb();
        $vars['random_image'] = get_random_image();

        if($node = menu_get_object()) {
            $vars['node_title'] = $node->title;
            if($node->type == 'news') {
                $vars['node_title'] = 'News';
            }
            if($node->type == 'client') {
                $vars['node_title'] = 'Clients';
            }
            if($node->type == 'portfolio') {
                $vars['node_title'] = null;
            }
            if($node->type == 'face_page' || drupal_is_front_page()) {
            //if($node->type == 'internal' || $node->type == 'section_root' || $node->type == 'practices_page' || 
            //    $node->type == 'services_page' || $node->type == 'company_page' || $node->type == 'solutions_page' || $node->type == 'portfolio') {
                $sugg = array();
                $sugg['page_internal'] = 'page-face';
                $vars['template_files'] = $sugg;
            }
        }
        else
        {
            if($view = views_get_page_view()) {
                $vars['node_title'] = $view->view->get_title();
            }
        }
        $tree = menu_tree_page_data('primary-links');
        $vars['primary_links_mod'] = etnav2_menu_tree_output($tree);

    }
}

function etnav2_preprocess_node(&$vars) {
  if(arg(0) == 'taxonomy' || arg(0) == 'showcase'){
    $suggestions = array('node-taxonomy'); //So, node-taxonomy.tpl.php will be known afterwards.
    $vars['template_files'] = array_merge($vars['template_files'], $suggestions);
  }

  if($node = menu_get_object()) {
      if($node->type == 'portfolio') {
          $suggestions = array('node-taxonomy'); //So, node-taxonomy.tpl.php will be known afterwards.
          $vars['template_files'] = array_merge($vars['template_files'], $suggestions);
      }
  }
}

//function etnav2_breadcrumb($breadcrumb) {
    //if (!empty($breadcrumb)) {
        //$num = count($breadcrumb);
        //$output = array();
        //$output[] = '<h1 class="breadcrumbs-root-page">'.$breadcrumb[0].'</h1>';
        //for($i = 1; $i < $num - 1; $i++)
            //$output[] = '<h2 class="breadcrumbs-page">'.$breadcrumb[$i].'</h2>';
        //return implode($output);
    //}
//}

function etnav2_breadcrumb($breadcrumb) {
    if (!empty($breadcrumb)) {
        $output = '';
        $section = '';
        $num = count($breadcrumb);
        if($num > 2) {
            $section = substr($breadcrumb[1], strpos($breadcrumb[1], '>') + 1, strlen($breadcrumb[1]));
            $section = substr($section, 0, strpos($section, '<'));
        }
        if($section == 'Showcase') {
            $first_crumb = true;
            foreach($breadcrumb as $crumb) {
                if($first_crumb) {
                    $first_crumb = false;
                    $output .= '<h1 class="breadcrumbs-root-page">'.$crumb.'</h1>';
                }
                else {
                    $output .= '<h2 class="breadcrumbs-page">'.$crumb.'</h2>';
                }
            }
        }
        else {
            $output = '<h1 class="breadcrumbs-root-page">'.$breadcrumb[$num-1].'</h1>';
        }
        return $output;
    }
}

function etnav2_preprocess_search_block_form(&$vars, $hook) {

    // Modify elements of the search form
    $vars['form']['search_theme_form']['#title'] = t('Search:');

    // Set a default value for the search box
    $vars['form']['search_theme_form']['#value'] = t('');

    // Add a custom class to the search box
    $vars['form']['search_theme_form']['#attributes'] = array('class' => t('cleardefault'));

    // Change the text on the submit button
    $vars['form']['submit']['#value'] = t('&rarr;');

    // Rebuild the rendered version (search form only, rest remains unchanged)
    unset($vars['form']['search_theme_form']['#printed']);
    $vars['search']['search_theme_form'] = drupal_render($vars['form']['search_theme_form']);

    // Rebuild the rendered version (submit button, rest remains unchanged)
    unset($vars['form']['submit']['#printed']);
    $vars['search']['submit'] = drupal_render($vars['form']['submit']);

    // Collect all form elements to make it easier to print the whole form.
    $vars['search_form'] = implode($vars['search']);
}


function etnav2_links($links, $attributes = array('class' => '')) {

    $output = '';
    if (count($links) > 0) {

        if ($attributes['class'] == '') {
            $output = '<ul>';
        }
        else {
            $output = '<ul'. drupal_attributes($attributes) .'>';
        }

        $num_links = count($links);
        $i = 1;

        foreach ($links as $key => $link) {
            $class = $key;

            // Add first, last and active classes to the list of links to help out themers.
            if ($i == 1) {
                $class .= ' first';
            }
            if ($i == $num_links) {
                $class .= ' last';
            }
            $output .= '<li>';

            if (isset($link['href'])) {
                // Pass in $link as $options, they share the same keys. 
            }
            $output .= l($link['title'], $link['href'], array('attributes' => array('class' => $class)));


            $i++;
            $output .= "</li>\n";
        }

        $output .= '</ul>';
    }

    return $output;
}                                  

function etnav2_menu_item_link($link, $attributes = array('class' => ''), $iter = 1)
{
    if($iter == 1) {
        if ($attributes['class'] == '') {
            return '<a href="'.check_url(url($link['href'], array())).'"><span>'.$link['title'].'</span></a>';     
        }
        return '<a href="'.check_url(url($link['href'], array())).'" class="'.$attributes['class'].'"><span>'.$link['title'].'</span></a>';     
    }
    else {
        if ($attributes['class'] == '') {
            return '<a href="'.check_url(url($link['href'], array())).'">'.$link['title'].'</a>';     
        }
        return '<a href="'.check_url(url($link['href'], array())).'" class="'.$attributes['class'].'">'.$link['title'].'</a>';     
    }
}

function etnav2_menu_tree($tree, $iter = 1) 
{
    switch($iter) {
    case 1:
        return '<ul class="top-level clearfix">'. $tree .'</ul>';
        break;
    case 2:
        return '<ul class="subnav">'. $tree .'</ul>';
        break;
    case 3:
        return '<ul class="subsubnav">'. $tree .'</ul>';
        break;
    }
    return '<ul class="top-level">'. $tree .'</ul>';
}   

function etnav2_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
    //$class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
    //if (!empty($extra_class)) {
        //$class .= ' '. $extra_class;
    //}
    
    if(!empty($class)) {
        if($in_active_trail)
            $class .= ' active-trail';
        return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
    }

    if($in_active_trail) {
        $class = 'active-trail';
        return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
    }

    return '<li>'. $link . $menu ."</li>\n";

}          

function etnav2_menu_tree_output($tree, $iter = 0) 
{
    $iter++;
    $output = '';
    $items = array();

    foreach ($tree as $data) {
        if (!$data['link']['hidden']) {
            $items[] = $data;
        }
    }

    $num_items = count($items);
    foreach ($items as $i => $data) {
        $extra_class = NULL;
        if ($i == 0) {
            $extra_class = 'first';
        }
        if ($i == $num_items - 1) {
            $extra_class = 'last';
        }
        $link = theme('menu_item_link', $data['link'], $attributes = array('class' => $extra_class), $iter);
        if ($data['below']) {
            $output .= theme('menu_item', $link, $data['link']['has_children'],
                etnav2_menu_tree_output($data['below'], $iter), $data['link']['in_active_trail'], $extra_class);
        }
        else {
            $output .= theme('menu_item', $link, $data['link']['has_children'], '',
                $data['link']['in_active_trail'], $extra_class);
        }
    }
    return $output ? theme('menu_tree', $output, $iter) : '';
}

/**
* override theme_aggregator_block_item
 */
function etnav2_aggregator_block_item($item, $feed = 0) {

  $output = '';
  
  $output .= sprintf('<div class="views-row"><div class="title"><span>%s</span><a href="%s">%s</a></div>
                  <div class="teaser">%s</div></div>', date("M d Y", $item->timestamp), check_url($item->link), check_plain($item->title), $item->description);
  
  return $output;
}


function get_random_image() 
{
    $path = base_path() . drupal_get_path('theme', 'etnav2');
    return $path . '/images/etna/' . rand(1, 11) . '.jpg';
}

?>
