<div class="themes-php">
	<div class="wrap">
		<?php screen_icon('edit-comments'); ?>
		<h2 id="mab-settings-header">Designs</h2>
<!-- END HEADER -->

<?php 
## MESSAGES
if( isset( $_GET['deleted'] ) && 'true' == $_GET['deleted'] ):
?>
<div id="mab-settings-deleted-message" class="updated fade"><p><strong><?php esc_html_e( 'Item Deleted', 'mab' ); ?></strong></p></div>
<?php elseif( isset( $_GET['mab-preconfigured-buttons'] ) && 'true' == $_GET['mab-preconfigured-buttons'] ): ?>
<div id="mab-settings-preconfigured-message" class="updated fade"><p><strong><?php esc_html_e( 'Preconfigured Buttons Created', 'mab' ); ?></strong></p></div>
<?php endif;

##END MESSAGES
?>

<?php
$buttons = $data['buttons'];
?>

<h3><?php _e('CSS3 Buttons', 'mab' ); ?> <a href="<?php echo esc_url(admin_url('admin.php?page=mab-button-settings')); ?>" class="button button-primary"><?php _e('Create New', 'mab' ); ?></a> <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'page' => 'mab-design', 'mab-create-preconfigured' => 'true' ), admin_url('admin.php') ), 'mab-create-preconfigured' ) ); ?>" class="button button-secondary"><?php _e('Create Preconfigured Buttons', 'mab' ); ?></a></h3>

<table class="widefat">
	<thead>
		<tr>
			<th scope="col"><?php _e('Title','mab' ); ?></th>
			<th scope="col"><?php _e('Last Saved', 'mab' ); ?></th>
			<th scope="col"><?php _e('Example Button', 'mab' ); ?></th>
			<th scope="col"><?php _e('Actions', 'mab' ); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th scope="col"><?php _e('Title','mab' ); ?></th>
			<th scope="col"><?php _e('Last Saved', 'mab' ); ?></th>
			<th scope="col"><?php _e('Example Button', 'mab' ); ?></th>
			<th scope="col"><?php _e('Actions', 'mab' ); ?></th>
		</tr>
	</tfoot>
	<tbody>
		<?php //var_dump( $buttons ); 
		foreach( $buttons as $key => $button ):
		?>
		<tr>
			<td><?php echo esc_html( $button['title'] ); ?></td>
			<td><?php echo esc_html(date( 'F j, Y \a\t g:iA', $button['timesaved'] ) ); ?></td>
			<td><a href="#" onclick="return false;" style="display:block; float: left; margin: 5px 0;" class="mab-button-<?php echo $key; ?>"><?php echo esc_html($button['title']); ?></a></td>
			<td><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'mab-button-settings', 'mab-button-id' => $key), admin_url('admin.php') ) ); ?>"><?php _e('Edit','mab'); ?></a>
			<?php //TODO: Add "Duplicate" link ?>
			| <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'page' => 'mab-design', 'mab-button-id' => $key, 'mab-delete-button' => 'true'), admin_url('admin.php') ), 'mab-delete-button') ); ?>"><?php _e('Delete','mab' ); ?></a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<!-- FOOTER -->
	</div><!-- .wrap -->
</div><!-- .themes-php -->
