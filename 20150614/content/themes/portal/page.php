<?php $pv = get_page_view();?>
<div id="content">
    <?php if ( !empty($pv->title) ) : $GLOBALS['the_title'] = $pv->title; ?>
        <h2 class="pagetitle"><?php echo sanitize( $pv->title ); ?></h2>
        <div class="entry">
            <?php echo sanitize( $pv->content ); ?>
        </div> <!--end: entry-->
      <div class="clear"></div>
    <?php else : ?>
        <h2 class="pagetitle">Page Not Found</h2>
    <?php endif; ?>
</div> <!--end: content-->