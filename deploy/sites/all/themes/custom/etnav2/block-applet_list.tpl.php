<div id="list-area">
    <?php $block->content ?>
    <?php $nav = menu_navigation_links('menu-applet-links'); ?>
<?php 
print "<ul>";

$i = 2;
foreach($nav as $key => $val) {
    print '<li id="item-'.$i.'">'.l($val['title'], $val['href']).'</li>';
    $i++;
}

print "</ul>";
?>
</div>
