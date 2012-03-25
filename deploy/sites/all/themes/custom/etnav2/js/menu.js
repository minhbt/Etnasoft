
// Extending jquery with function
// exist() that check jQuery object for emptyness
jQuery.fn.exist = function() {
    if(this.length > 0)
        return true;
    return false;
}

// Creating namespace
var industrial_menu = {};

// Menu settings
industrial_menu.root = '#first-navbar ';
industrial_menu.slide_up_time = 10;
industrial_menu.slide_down_time = 10;

industrial_menu.trail = { 
    $top_li:     jQuery([]), 
    $first_li:   jQuery([]),
    $second_li:  jQuery([])  
};

industrial_menu.init = function() {
    // Cache <ul> elements queries
    this.$top_ul = $(this.root + 'ul.top-level');
    this.$first_ul = $(this.root + 'ul.subnav');
    this.$second_ul = $(this.root + 'ul.subsubnav');
}

/** 
 * Close all submenus. Full reset
 */
industrial_menu.close_all = function() {
    // Close menu & submenu
    this.$first_ul.hide();
    this.$second_ul.hide();
    // Remove hover classes
    this.$top_ul.removeClass('top-level-hover');
    this.$top_ul.find('a').not('ul.subnav a').removeClass('submenu-exist');
}

/**
 * Open top-level submenu for current link if exist.
 */
industrial_menu.first_menu_open = function(link)
{
    // Getting active <li> element
    var $menu_item = $(link).parent();
    // Getting submenu if exist
    var $submenu = $menu_item.find('ul.subnav');

    if($submenu.exist()){
        // Set some effect for current <a> element
        $(link).not('ul.subnav a').addClass('top-level-hover').addClass('submenu-exist');
        //$(link).find('a').not('ul.subnav a').addClass('submenu-exist');
        // Show submenu
        if($submenu.css('display') == 'none')
            $submenu.show();
    }
}

/**
 * Open submenu for current link element
 * in parent menu if exist.
 */
industrial_menu.second_menu_open = function(link)
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

industrial_menu.active_trail_menu_open = function() {
    switch(this.path.length) {
        case 1: default:
            // Only top-level menu link active,
            // so we should just open first-level menu
            this.first_menu_open(this.trail.$top_li.children('a'));
            break;                                   
        case 2:
            // We need to open first-level menu
            // and set hover on active item
            this.first_menu_open(this.trail.$top_li.children('a'));
            this.trail.$first_li.addClass('first-level-hover');
	        this.trail.$first_li.children('a').addClass('first-level-hover-a');
            break;
        case 3:
            // Open both menus and
            // highlight active items
            industrial_menu.first_menu_open(industrial_menu
                                    .trail.$top_li.children('a'));
            industrial_menu.second_menu_open(industrial_menu
                                    .trail.$first_li.children('a'));
            industrial_menu.current.$second_li.addClass('second-level-hover');
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
    $('#first-navbar ul.top-level').children('li').hover( 
        function()
        {
            if($(this).find('ul.subnav').exist()) {
                $(this).find('a span')
                       .not('ul.subnav span')
                       .addClass('submenu-exist');
            }

            if(industrial_menu.trail.$top_li.children('a').hasClass('top-level-hover'))
                industrial_menu.trail.$top_li.children('a').removeClass('top-level-hover'); 

            $(this).children('a')
                   //.not(industrial_menu.trail.$top_li)
                   .addClass('top-level-hover').addClass('submenu-exist');



            // Close ALL menus
            industrial_menu.close_all();
            // Open menu under the mouse if it's an active trail menu
            // so, it can't be opened twice
            industrial_menu.first_menu_open($(this).children('a'));
        },
        function() {

            $(this).find('a span')
                   .not('ul.subnav span')
                   .removeClass('submenu-exist');

            $(this).children('a')
                   .not(industrial_menu.trail.$top_li.children('a'))
                   .removeClass('top-level-hover').removeClass('submenu-exist'); 

            // Close ALL menus
            industrial_menu.close_all();
            // Restore active menu trail 
             industrial_menu.active_trail_menu_open();
        }
    );
    
    /**
     * Set hover effect for first-submenu
     */
    $('#first-navbar ul.subnav').children('li').hover(
        function()
        {
            $(this).not(industrial_menu.trail.$first_li).addClass('first-level-hover');
            $(this).not(industrial_menu.trail.$first_li).children('a').addClass('first-level-hover-a');
        },
        function()
        {
            $(this).not(industrial_menu.trail.$first_li).removeClass('first-level-hover');
            $(this).not(industrial_menu.trail.$first_li).children('a').removeClass('first-level-hover-a');
        }
    );

    industrial_menu.init();

    // Get all <li> in trail
    industrial_menu.path = $('#first-navbar li.active-trail');

    // We want to place all related <li> in trail
    // to menu.current object.
    var li = 'li.active-trail';
    var ul = [
        industrial_menu.$top_ul,
        industrial_menu.$first_ul,
        industrial_menu.$second_ul
    ];
    var items = ['$top_li', '$first_li', '$second_li'];

    for(var i = 0; i < industrial_menu.path.length; i++) {
        industrial_menu.trail[items[i]] = ul[i].children(li);
    }

    industrial_menu.active_trail_menu_open();

}

// Extend drupal js object that
// replace $(document).ready for us
Drupal.behaviors.etna_menu = industrial_menu.main;
