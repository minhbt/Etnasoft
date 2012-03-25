
// Extending jquery with function
// exist() that check jQuery object for emptyness
jQuery.fn.exist = function() 
{
    if(this.length > 0)
        return true;
    return false;
}

// Creating namespace
var industrial_menu = {};


// Menu settings
industrial_menu.current = { 
    $top_level:     jQuery([]), // Main navigation bar
    $first_level:   jQuery([]), // First submenu, child of navaigation bar
    $second_level:  jQuery([])  // Second submenu, child of first submenu
};

/**
 * Open top-level submenu for current link if exist.
 * @param link - jQuery object, active link.
 */
industrial_menu.first_level_menu_open = function(link)
{
    // Getting active <li> element
    var $menu_item = $(link).parent();
    // Getting submenu if exist
    var $submenu = $menu_item.find('ul.subnav');

    if($submenu.exist())
    {
        // Set some effect for current <a> element
        $(link).not('ul.subnav a').addClass('top-level-hover');
        // Show submenu
        $submenu.slideDown(100);
        // If submenu exist we don't
        // want follow this link ;)
    }
}

/**
 * Open submenu for current link element
 * in parent menu if exist.
 * @param link - jQuery object, active link
 */
industrial_menu.second_level_menu_open = function(link)
{
    var $menu_item = $(link).parent();
    var $submenu = $menu_item.find('ul.subsubnav');

    if($submenu.exist())
    {
        $menu_item.not('ul.subsubnav li').addClass('first-level-hover');
        $(link).not('ul.subsubnav a').addClass('first-level-hover-a');
        // Cause submenu have absolute positioning
        // we need to calculate it's position for
        // each <li> element that have submenu
        $submenu.css({ 
            top: -$menu_item.position().top,
            left: $menu_item.width()
        });
        // Show submenu
        $submenu.show();
    }
}

/** 
 * Close all submenus. Full reset
 */
industrial_menu.close_all_menus = function() {
    // Cache selectors
    $top_ul = $('#first-navbar ul.top-level');
    $first_ul = $('#first-navbar ul.subnav');
    $second_ul = $('#first-navbar ul.subsubnav');
    // Close menu & submenu
    $first_ul.slideUp(200);
    $second_ul.hide();
    // Remove hover classes
    $top_ul.removeClass('top-level-hover');
}

/**
 * Reset active trail menu i.e. 
 * close & remove all hover effects
 */
industrial_menu.active_trail_menu_close = function() {
    // Hide second level menu
    this.current.$top_level.parent().find('ul.subsubnav').hide();
    // Slide Up first level menu
    this.current.$top_level.parent().find('ul.subnav').slideUp(200);
    // Remove top level menu hover
    this.current.$top_level.removeClass('top-level-hover');
    // Remove first level menu hover
    this.current.$first_level.parent().removeClass('first-level-hover');
    this.current.$first_level.removeClass('first-level-hover-a');
}

industrial_menu.active_trail_menu_open = function() {
    switch(this.path.length) {
        case 1: default:
            // Only top-level menu link active,
            // so we should just open first-level menu
            this.first_level_menu_open(this.current.$top_level.children('a'));
            break;                                   
        case 2:
            // We need to open first-level menu
            // and set hover on active item
            this.first_level_menu_open(this.current.$top_level.children('a'));
            this.current.$first_level.addClass('first-level-hover');
	        this.current.$first_level.children('a').addClass('first-level-hover-a');
            break;
        case 3:
            // Open both menus and
            // highlight active items
            industrial_menu.first_level_menu_open(industrial_menu
                                    .current.$top_level.children('a'));
            industrial_menu.second_level_menu_open(industrial_menu
                                    .current.$first_level.children('a'));
            industrial_menu.current.$second_level.addClass('second-level-hover');
            break;
    }
}

/**
 * Main function for industrial_menu object
 * Doing all funny stuff's here =)
 */
industrial_menu.main = function()
{
    // Processing click event for top level menu
    $('#first-navbar ul.top-level a').not('ul.subnav a').bind('mouseover', 
        function()
        {
                industrial_menu.reset_menu_state();
                industrial_menu.first_level_menu_open(this);
                return false;
        }
    );

    $('#first-navbar ul.top-level a').not('ul.subnav a').bind('mouseout', 
            function() {
                industrial_menu.reset_menu_state();
                industrial_menu.active_trail_menu_open();
            }
    );
    
    //Processing second level menu click event
    //$('#first-navbar ul.subnav a').not('ul.subsubnav a').click(
        //function() 
        //{
            //if (!industrial_menu.second_level_menu_open(this))
            //{
                //if (industrial_menu.current.$first_level.exist())
                //{
                    //Close sibling submenu
                    //industrial_menu.current.$first_level.parent().find('ul.subsubnav').hide();
                    //Remove hover effect
                    //industrial_menu.current.$first_level.removeClass('first-level-hover');
                //}
                //Store active link in object
                //industrial_menu.current.$first_level = $(this);
                //return false;
            //}
            //return true;
        //}
    //);

    /**
     * Set hover effect for links of top-level menu
     * thet have submenus.
     */
    $('#first-navbar ul.top-level').children('li').hover(
        function()
        {
            if($(this).find('ul.subnav').exist())
            {
                $(this).find('a span')
                       .not('ul.subnav span')
                       .addClass('submenu-exist');
            }
            $(this).children('a')
                   .not(industrial_menu.current.$top_level)
                   .addClass('top-level-hover');
        },
        function()
        {
            $(this).find('a span')
                   .not('ul.subnav span')
                   .removeClass('submenu-exist');
            $(this).children('a')
                   .not(industrial_menu.current.$top_level)
                   .removeClass('top-level-hover');
        }
    );

    /**
     * Set hover effect for first-submenu
     */
    $('#first-navbar ul.subnav').children('li').hover(
        function()
        {
            $(this).not(industrial_menu.current.$first_level.parent()).addClass('first-level-hover');
            $(this).children('a').not(industrial_menu.current.$first_level).addClass('first-level-hover-a');
        },
        function()
        {
            $(this).not(industrial_menu.current.$first_level.parent()).removeClass('first-level-hover');
            $(this).children('a').not(industrial_menu.current.$first_level).removeClass('first-level-hover-a');
        }
    );

    /**
     * Set hover effect for second-submenu
     */
    //$('#first-navbar ul.subsubnav li').hover(
            //function()
            //{
                //$(this).children('a').addClass('second-level-hover');
            //},
            //function()
            //{
                //$(this).children('a').removeClass('second-level-hover');
            //}
    //);

    /**
     * Open active menu on page load
     */

    // Get all <li> in trail
    industrial_menu.path = $('#first-navbar li.active-trail');

    // We want to place all related <li> in trail
    // to menu.current object.
    var root = '#first-navbar ul.top-level';
    var li = 'li.active-trail';
    var ul = ['ul.subnav', 'ul.subsubnav', ''];
    var items = ['$top_level', '$first_level', '$second_level'];

    for(var i = 0; i < industrial_menu.path.length; i++) {
        industrial_menu.current[items[i]] = 
            $(root).children(li);
        root += ' ' + li + ' ' + ul[i];
    }

    industrial_menu.active_trail_menu_open();

}

// Extend drupal js object that
// replace $(document).ready for us
Drupal.behaviors.etna_menu = industrial_menu.main;
