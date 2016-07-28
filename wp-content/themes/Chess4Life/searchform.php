<form class="form-search" id="searchform" action="<?php echo home_url( '/' ); ?>" role="search">
	<label for="s" class="screen-reader-text sr-only"><?php _e( 'Search for:', 'stylish' ); ?></label>
	
	<div class="input-group">	
		<input name="s" class="search-query form-control input-lg" id="s" type="text" value="<?php echo get_search_query(); ?>" placeholder="<?php _e( 'Click to search', 'stylish' ); ?>">
		<span class="input-group-btn">
			<button class="search-submit btn btn-lg btn-default" id="searchsubmit" type="submit">
				<i class="fa fa-search"></i>
				<span class="screen-reader-text sr-only"><?php _e( 'Search', 'stylish' ); ?></span>
			</button>
		</span>
	</div>
</form>