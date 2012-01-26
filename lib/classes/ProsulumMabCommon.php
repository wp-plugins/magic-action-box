<?php
/**
 * TODO:
 *
 * - complete getMetaBoxViewTemplate() function
 */

class ProsulumMabCommon{

	public static function show_action_box( $content ){
		//buffer output
		ob_start();
		?>
		
		<div class="magic-action-box">
			<div class="mab-type-optin mab-pad mb-default">
				<div class="mab-aside">
				</div>
				<div class="mab-content">
					<h3 class="mab-title">If you enjoyed this article, get email updates (it's free).</h3>
					<form method="POST">
						<p class="mab-field">
							<label for="mab-name">Name</label>
							<input type="text" id="mab-name" placeholder="Enter your name" name="the-name" />
						</p>
						<p class="mab-field">
							<label for="apab-email">Email Address</label>
							<input type="email" id="mab-email" placeholder="Enter your email" name="the-email" />
						</p>
						<input class="mab-submit" type="submit" value="Submit" />
					</form>
				</div>
			</div>
		</div>
		
		<?php
		//get contents of output buffer
		$action = ob_get_contents();		
		$out = $content . "\n" . $action;
		ob_end_clean();
		
		return $out;
		
	}
	
	/**
	 * @param string $filename reference a file relative to the MAB_VIEWS_DIR
	 * @param mixed $data data to pass on to the view file
	 * @return string contents of the file
	 */
	public static function getView( $filename, $data = null ){
		
		if( empty( $filename ) ) return '';
		
		//TODO: allow custom views to override standard views
		
		
		$filename = trailingslashit( MAB_VIEWS_DIR ) . $filename;
		
		//check if file exists
		if( !file_exists( $filename ) ) return '';
		
		ob_start();
		include( $filename );
		$contents = ob_get_contents();
		ob_end_clean();
		
		return $contents;
		
	}
	
	/**
	 * Get View Template for MetaBoxes
	 */
	public static function getMetaBoxViewTemplate( $template = '' ){
		
		$filenames = array(
			
		);
	}
	
	/**
	 * Get Settings
	 *
	 * Wrapper function for ProsulumMabBase->get_settings() function
	 *
	 * @return array Magic Action Box settings
	 */
	public static function getSettings(){
		global $MabBase;
		return $MabBase->get_settings();
	}
	
	/**
	 * Get Action Box Styles
	 */
	public static function getStyles(){
		$styles = array(
			'user' => array( 'id' => 'user', 'name' => 'User Settings', 'description' => 'Create your own style.' ),
			'default' => array( 'id' => 'default', 'name' => 'Default', 'description' => 'Starter style for your action box.' ),
			'dark' => array( 'id' => 'dark', 'name' => 'Dark', 'description' => '' ),
			'royalty' => array( 'id' => 'royalty', 'name' => 'Royalty', 'description' => ''),
			'pink' => array( 'id' => 'pink', 'name' => 'Pink', 'description' => ''),
			'none' => array( 'id' => 'none', 'name' => 'None', 'description' => 'Don\'t use any style designs. Useful if you wish to roll out your own design.')
		);
		
		return $styles;
	}
	
	/**
	 * Get a single action box style
	 */
	public static function getSingleStyle( $id ){
		$styles = self::getStyles();
		if( isset( $styles[$id] ) ){
			return $styles[$id];
		}
	}
	
	/**
	 * Get Single Action Box Style Resource
	 * @param string $id unique id for the action box style
	 * @param string $type thumb | css
	 * @return url - url to the resource
	 */
	public static function getStyleResource( $id, $type ){
		$style = self::getSingleStyle( $id );
		
		$styleUrl = trailingslashit( MAB_STYLES_URL . "{$id}/" );
		$styleDir = trailingslashit( MAB_STYLES_DIR . "{$id}/" );
		
		/* TODO: Allow to override location of resources */
		switch( $type ){
			case 'css':
			case 'stylesheet':
				if( file_exists( $styleDir . 'style.css' ) ){
					return $styleUrl . 'style.css';
				} else {
					return '';
				}
				break;
			case 'thumb':
			case 'image':
				if( file_exists( $styleDir . 'thumb.png' ) ){
					return $styleUrl . 'thumb.png';
				} else {
					return '';
				}
				break;
			default:
				return '';
				break;
		}
	}
	
	/**
	 * Deletes all the files in the temp directory under 
	 * wp-content/uploads/magic-action-box/
	 */
	public static function clearCacheDir( $ext = '*' ){
		mab_make_stylesheet_path_writable();
		$dir = mab_get_stylesheet_location('path');
		foreach( glob( $dir . "*.{$ext}" ) as $file ){
			unlink( $file );
		}
	}
}
