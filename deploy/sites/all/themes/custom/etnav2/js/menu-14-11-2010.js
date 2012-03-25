
var ind_menu = {};

var ind_menu.root = '#first-navbar';
var ind_menu.active_li = 'li.active-trail';

ind_menu.trail = {
    top_li: null;
    first_li: null;
    second_li: null;
};





ind_menu.main = function() {

    var root_ul = document.getElementByID(this.root);
    var all_top_li = root_ul
    
}
// Extend drupal js object that
// replace $(document).ready for us
Drupal.behaviors.etna_menu = ind_menu.main;
