<?php 
if ( !defined('ABSPATH') ){ die(); }

global $avia_config; 

//allows you to modify the search parameters. for example bbpress search_id needs to be 'bbp_search' instead of 's'. you can also deactivate ajax search by setting ajax_disable to true
$search_params = apply_filters( 'avf_frontend_search_form_param', array(
	'placeholder'  	=> __( 'Search','avia_framework' ),
	'search_id'	   	=> 's',
	'form_action'	=> home_url( '/' ),
	'ajax_disable'	=> false
) );


?>

<form action="<?php echo $search_params['form_action']; ?>" id="searchform" method="get" class="av_disable_ajax_search">
	<div class="search-form">
		<input type="text" id="s" class="search-input" name="<?php echo $search_params['search_id']; ?>" value="<?php if( ! empty( $_GET['s'] ) ) echo get_search_query(); ?>" placeholder='<?php echo $search_params['placeholder']; ?>' />
        <button>
            <span>Search</span>
        </button>
	</div>
</form>