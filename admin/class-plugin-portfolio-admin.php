<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://thierrycharriot.github.io
 * @since      1.0.0
 *
 * @package    Plugin_Portfolio
 * @subpackage Plugin_Portfolio/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Portfolio
 * @subpackage Plugin_Portfolio/admin
 * @author     Thierry Charriot <thierrycharriot@chez.lui>
 */
class Plugin_Portfolio_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {	

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-portfolio-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {	

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-portfolio-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Display form settings in profile page
	 *
	 * @param [type] $profileuser
	 * @return void
	 */
	public function portfolio_settings_add( $user ) {
		//var_dump( $user->ID ); die(); // debug OK
		?>
			<h3>Settings Portfolio</h3>
		
				<table class="form-table">
					<tr>
						<th>
							<label for="portfolio_user_profession"><?php esc_html_e( 'Your Profession' ); ?></label>
						</th>
						<td>
							<input type="text" name="portfolio_user_profession" id="portfolio_user_profession" value="<?php 
							// https://developer.wordpress.org/reference/functions/get_the_author_meta/
							// get_the_author_meta( string $field = '', int|false $user_id = false ): string
							// Retrieves the requested data of the author of the current post.
							echo esc_attr( get_the_author_meta( 'usermeta_user_profession', $user->ID ) ); 
							?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th>
							<label for="portfolio_cv_link"><?php esc_html_e( 'Your Curriculum link' ); ?></label>
						</th>
						<td>
							<input type="text" id="portfolio_cv_link" name="portfolio_cv_link" value="<?php echo esc_attr( get_the_author_meta( 'usermeta_cv_link', $user->ID )  ); ?>" class="regular-text"/>
						</td>
					</tr>
				</table>
			
		<?php
	}

	/**
	 * Register settings portfolio
	 *
	 * @param [type] $user_id
	 * @return void
	 */
	public function portfolio_settings_register( $user_id ) {
		//var_dump( $user_id ); die(); // OK
		//var_dump( $_POST['user_profession'] ); die(); // OK

		// https://developer.wordpress.org/reference/functions/current_user_can/
		// current_user_can( string $capability, mixed $args ): bool
		// Returns whether the current user has the specified capability.
		// https://developer.wordpress.org/reference/functions/edit_user/
		// edit_user( int $user_id ): int|WP_Error
		// Edit user settings based on contents of $_POST
		if ( !current_user_can('edit_user', $user_id) ) {
			return false;
		}

		// https://developer.wordpress.org/reference/functions/update_user_meta/
		// update_user_meta( int $user_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool
		// Updates user meta field based on user ID.
		// https://developer.wordpress.org/reference/functions/sanitize_text_field/
		// sanitize_text_field( string $str ): string
		// Sanitizes a string from user input or from the database.
		update_user_meta( $user_id, 'usermeta_user_profession', sanitize_text_field( $_POST['portfolio_user_profession'] ) );
		update_user_meta( $user_id, 'usermeta_cv_link', sanitize_text_field( $_POST['portfolio_cv_link'] ) );
		
	}

}