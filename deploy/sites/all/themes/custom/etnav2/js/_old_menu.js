/*
* TODO:
* 1. I need three level menu, so i need three current object
* 2. I need to rewrite functions and variables names to be convient
* 3. Maybe I need to write some helper functions
* 4. Have to write some additional CSS for menu
* 5. Testing
* 6. Bugfixing
* 7. Commenting
*
*/

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
    $top_level: jQuery([]),   // Main navigation bar
    $first_level: jQuery([]), // First submenu, child of navaigation bar
    $second_level: jQuery([]) // Second submenu, child of first submenu
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
        return false;
    }
    // No submenu, so we think it's a normal
    // link & we allow browser follow it.
    return true;
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
        // If submenu exist we don't
        // want follow this link ;)
        return false;
    }
    return true;
}

/**
 * Main function for industrial_menu object
 * Doing all funny stuff's here =)
 */
industrial_menu.main = function()
{
    // Processing click event for top level menu
    $('#first-navbar ul.top-level a').not('ul.subnav a').bind('click', 
        function()
        {
            if (!industrial_menu.first_level_menu_open(this))
            {
                // Close all submenus
                industrial_menu.current.$top_level.parent().find('ul.subsubnav').hide();
                industrial_menu.current.$top_level.parent().find('ul.subnav').slideUp(200);
                // Remove hover effect  on active item ...
                industrial_menu.current.$top_level.removeClass('top-level-hover');
                // and on active subitems
                industrial_menu.current.$first_level.parent().removeClass('first-level-hover');
                industrial_menu.current.$first_level.removeClass('first-level-hover-a');
                // Store active link in object 
                industrial_menu.current.$top_level = $(this);
                industrial_menu.current.$first_level = $([]);
                return false;
            }
            return true;
        }
    );

    // Processing second level menu click event
    $('#first-navbar ul.subnav a').not('ul.subsubnav a').click(
        function() 
        {
            if (!industrial_menu.second_level_menu_open(this))
            {
                if (industrial_menu.current.$first_level.exist())
                {
                    // Close sibling submenu
                    industrial_menu.current.$first_level.parent().find('ul.subsubnav').hide();
                    // Remove hover effect
                    industrial_menu.current.$first_level.removeClass('first-level-hover');
                }
                // Store active link in object
                industrial_menu.current.$first_level = $(this);
                return false;
            }
            return true;
        }
    );

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
    $('#first-navbar ul.subsubnav li').hover(
            function()
            {
                $(this).children('a').addClass('second-level-hover');
            },
            function()
            {
                $(this).children('a').removeClass('second-level-hover');
            }
    );

    /**
     * Open active menu on page load
     */

    // menu trail - object containing
    // active menu <li> items 
    var path = $('#first-navbar li.active-trail');

    switch(path.length) {
        case 1: default:
            // Only top-level menu link active,
            // so we should just open first-level menu
            var $top_level_item = $('#first-navbar ul.top-level').children('li.active-trail');
            var $first_level_item = $('#first-navbar li.active-trail ul.subnav').children('li.active-trail');
            industrial_menu.first_level_menu_open($top_level_item.children('a'));
            industrial_menu.current.$top_level = $top_level_item.children('a');
            industrial_menu.current.$first_level = $first_level_item.children('a');
            break;
        case 2:
            // We need to open first-level menu
            // and set hover on active item
            var $top_level_item = $('#first-navbar ul.top-level').children('li.active-trail');
            var $first_level_item = $('#first-navbar li.active-trail ul.subnav').children('li.active-trail');
            industrial_menu.first_level_menu_open($top_level_item.children('a'));
            industrial_menu.current.$top_level = $top_level_item.children('a');
            industrial_menu.current.$first_level = $first_level_item.children('a');
            $first_level_item.addClass('first-level-hover');
	    $first_level_item.children('a').addClass('first-level-hover-a');
            break;
        case 3:
            // Open both menus and
            // highlight active items
            var $top_level_item = $('#first-navbar ul.top-level').children('li.active-trail');
            var $first_level_item = $('#first-navbar li.active-trail ul.subnav').children('li.active-trail');
            var $second_level_item = $('#first-navbar li.active-trail li.active-trail ul').children('li.active-trail');
            industrial_menu.first_level_menu_open($top_level_item.children('a'));
            industrial_menu.second_level_menu_open($first_level_item.children('a'));
            industrial_menu.current = {
                $top_level: $top_level_item.children('a'),
                $first_level: $first_level_item.children('a'),
                $second_level: $second_level_item.children('a')
            };
            $second_level_item.addClass('second-level-hover');
            break;
    }

}

// Extend drupal js object that
// replace $(document).ready for us
Drupal.behaviors.etna_menu = industrial_menu.main;
