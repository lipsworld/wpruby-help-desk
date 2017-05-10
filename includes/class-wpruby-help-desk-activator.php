<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/includes
 * @author     WPRuby <info@wpruby.com>
 */
class Wpruby_Help_Desk_Activator {

	private $is_seeded = 'no';



	public function __construct(){
		$this->is_seeded = get_option('wpruby_help_desk_seeded');
	}
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
			$this->set_seeded('no');

			if($this->is_seeded !== 'yes'){
				$this->add_roles();
				$this->seed_pages();
				$this->seed_statuses();
				$this->seed_products();

				//set the seeded flag.
				$this->set_seeded('yes');
		 	}


	}
	//@TODO
	private function set_seeded( $value ){
		update_option( 'wpruby_help_desk_seeded', $value);
		$this->is_seeded = $value;
	}

	//@TODO
	private function seed_pages(){
				// insert Default Pages
				$main_page = array(
							'post_content'	=>	'',
							'post_title'	=>	__('Help Desk', 'wpruby-help-desk'),
							'post_type'		=>	'page',
							'post_status'	=>	'publish',
							'post_parent' => null,
				);
				$main_page_id = wp_insert_post(	$main_page	);

				$pages =	array(
					array(
								'post_content'	=>	'[submit_ticket]',
								'post_title'	=>	__('Submit Ticket', 'wpruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
					array(
								'post_content'	=>	'[my_tickets]',
								'post_title'	=>	__('My Tickets', 'wpruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
					array(
								'post_content'	=>	'[ruby_help_desk_login]',
								'post_title'	=>	__('Login', 'wpruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),

				);
				foreach ($pages as $key => $page_args) {
					$page_id = wp_insert_post(	$page_args );
					update_option( 'wpruby_' . $page_args['post_content'], $page_id);
				}
	}

	//@TODO
	private function seed_statuses(){
				// insert default Ticket Statuses
				$statuses = array(
					array(
						'term'	=>	'Closed',
						'color'	=>	'#ff0000',
						'slug'	=>	'closed',
					),
					array(
						'term'	=>	'In Progress',
						'color'	=>	'#679469',
						'slug'	=>	'in-progress',
					),
					array(
						'term'	=>	'New',
						'color'	=>	'#b491ce',
						'slug'	=>	'new',
					),
				);

				foreach($statuses as $key => $status){
					if(! term_exists($status['term'],	WPRUBY_TICKET_STATUS)){
							$term = wp_insert_term($status['term'], WPRUBY_TICKET_STATUS, array('slug' => $status['slug']));
							if(isset($term['term_id'])){
								update_term_meta ($term['term_id'], 'ticket_status_color', $status['color']);
								update_option( 'wpruby_ticket_status_' . $status['slug'], $term['term_id']);
							}
					}
				}
	}

	//TODO
	private function seed_products(){
			// insert default Ticket Statuses
			$products = array(
					array(
						'term'	=>	__('Sample Product', 'wpruby-help-desk'),
					)
			);
			foreach($products as $key => $product){
				if(! term_exists($product['term'],	WPRUBY_TICKET_PRODUCT)){
						$term = wp_insert_term($product['term'], WPRUBY_TICKET_PRODUCT);
				}
			}
	}

	//@TODO
	public function add_roles(){


		//info: add the help desk custom roles
		$author     = get_role( 'author' );
		$subscriber = get_role( 'subscriber' );
		add_role( WPRUBY_AGENT, __('Help Desk Agent', 'wpruby-help-desk'), $author->capabilities );
		add_role( WPRUBY_CUSTOMER, __('Help Desk Customer', 'wpruby-help-desk'), $subscriber->capabilities );

		//add the Agent role to all of the admin
		$administrators = get_users(
			array(
				'role'		=>	'administrator',
				'fields'  =>	array('ID', 'user_login')
			)
		);
		foreach($administrators as $admin){
			$admin_user = new WP_User($admin->ID);
			$admin_user->add_role(WPRUBY_AGENT);
		}

	}
}
