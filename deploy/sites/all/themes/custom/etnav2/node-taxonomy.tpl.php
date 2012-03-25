<div id="node-<?php echo $node->nid; ?>" class=" portfolio-node node<?php if($sticky) echo ' sticky'; ?><?php if(!$status) echo ' node-unpublished'; ?>">
    <h2><a href="<?php echo $node_url; ?>"><?php echo $title; ?></a></h2>        
    <div class="node-body clearfix">

        <?php if ($node->field_screenshot[0]['view']) : ?>
            <div class="screenshot">
	      <a href="<?php echo base_path().$node->field_screenshot[0]['filepath']; ?>"><?php echo theme('imagecache', 'showcase_screens', $node->field_screenshot[0]['filepath']); ?></a>
              <?php if(!empty($node->field_screenshot_2[0]['filename'])) : ?>
              <a href="<?php echo base_path().$node->field_screenshot_2[0]['filepath']; ?>"><?php echo theme('imagecache', 'showcase_screens', $node->field_screenshot_2[0]['filepath']); ?></a>
              <?php endif; ?>
            </div>
        <?php endif; ?> 
        <?php echo $content; ?>

    </div><!-- .node-body -->
    <div class="tag-line clearfix">
        <ul>
        <?php foreach($node->taxonomy as $term): ?>
            <li><a href="<?php echo base_path().'showcase/'.$term->tid; ?>"><?php echo $term->name; ?></a></li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>

