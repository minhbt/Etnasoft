<?php
// $Id: search-block-form.tpl.php,v 1.1 2007/10/31 18:06:38 dries Exp $

/**
 * @file search-block-form.tpl.php
 * Default theme implementation for displaying a search form within a block region.
 *
 * Available variables:
 * - $search_form: The complete search form ready for print.
 * - $search: Array of keyed search elements. Can be used to print each form
 *   element separately.
 *
 * Default keys within $search:
 * - $search['search_block_form']: Text input area wrapped in a div.
 * - $search['submit']: Form submit button.
 * - $search['hidden']: Hidden form elements. Used to validate forms when submitted.
 *
 * Since $search is keyed, a direct print of the form element is possible.
 * Modules can add to the search form so it is recommended to check for their
 * existance before printing. The default keys will always exist.
 *
 *   <?php if (isset($search['extra_field'])): ?>
 *     <div class="extra-field">
 *       <?php print $search['extra_field']; ?>
 *     </div>
 *   <?php endif; ?>
 *
 * To check for all available data within $search, use the code below.
 *
 *   <?php print '<pre>'. check_plain(print_r($search, 1)) .'</pre>'; ?>
 *
 * @see template_preprocess_search_block_form()
 */
?>
<div id="search-form">

    <div class="w"> 
<?php
$search["search_block_form"]= str_replace("Search this site: ", "Search:", $search["search_block_form"]);

  //    * "Search" button with "Go!" *      ////
  $search["submit"]=str_replace('value="Search"', 'value="GO"', $search["submit"]);

    print $search["search_block_form"];
    print "<a href=\"javascript:document.forms['search-block-form'].submit();\">Ok!</a>";
   // print $search["submit"];
    print $search["hidden"];
?>                      
        <?php //print $search_form; ?>
    </div>
</div>
