<?php //if (get_theme_mod('tabber') == 'Yes') { ?>
<div class="tabber">
	<ul id="tabs" class="tabs">
		<li><a href="#popular-posts" rel="popular-posts" class="selected">Popular</a></li>
		<li><a href="#recent-comments" rel="recent-comments">Comments</a></li>
		<li><a href="#monthly-archives" rel="monthly-archives">Archives</a></li>
		<li><a href="#tag-cloud" rel="tag-cloud">Tags</a></li>
	</ul>
<div class="clear"></div>
	<ul id="popular-posts" class="tabcontent">
		Tab1
	</ul>
	<ul id="recent-comments" class="tabcontent">
		Tab2
	</ul>
	<ul id="monthly-archives" class="tabcontent">
		Tab3
	</ul>
	<ul id="tag-cloud" class="tabcontent">
		Tab4
	</ul>
<script type="text/javascript">
	var tabs=new ddtabcontent("tabs")
	tabs.setpersist(false)
	tabs.setselectedClassTarget("link")
	tabs.init()
	</script>
</div> <!--end: tabber-->
<div class="clear"></div>
<?php //} else { ?>
<?php //} ?>
