<?php foreach ($fields as $id => $field): ?>
      <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      ?>
<?php print $field->content; ?>
  
<?php endforeach; ?>

