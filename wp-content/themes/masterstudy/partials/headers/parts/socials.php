<?php global $stm_option; ?>
<div class="pull-right">
	<div class="header_top_bar_socs">
		<ul class="clearfix">
			<?php
			foreach ($stm_option['top_bar_use_social'] as $key => $val) {
				if (!empty($stm_option[$key]) && $val == 1) {
					echo "<li><a href='{$stm_option[$key]}'><i class='fab fa-{$key}'></i></a></li>";
				}
			}
			?>
		</ul>
	</div>
</div>