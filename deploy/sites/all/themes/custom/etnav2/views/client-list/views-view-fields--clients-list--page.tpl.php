
<?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
<?php endif; ?>

<!--<h2><?php //print $fields['title']->content; ?></h2>-->

<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="logo">
            <?php print $fields['field_logo_fid']->content; ?>
        </td> 
        <td class="text">
            <?php print $fields['teaser']->content; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php $link = $fields['field_website_link_value']->content; ?>
            <div class="client-website">
                <?php print 'Website: <a href="http://' . $link . '" rel="nofollow">' . $link . '</a>'; ?>
            </div>
        </td>
    </tr>
</table>

