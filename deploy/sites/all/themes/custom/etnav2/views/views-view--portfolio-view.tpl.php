<div class="portfolio-view<?php //print $classes; ?>">

  <?php if ($rows): ?>
      <?php print $rows; ?>
  <?php elseif ($empty): ?>
      <?php print $empty; ?>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

</div> <?php /* class view */ ?>
