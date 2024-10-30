<?php
/*
  Plugin Name: MB Spirit
  Version: 1.1.0
  Plugin URI: https://mb-spirit.com/wordpress-plugin
  Description: Connect your web site to your MINDBODY account through MB Spirit to incorporate schedules, staff, and events and more
  Author: Bistromatics Inc.
  Author URI: https://mb-spirit.com
 */

defined( 'ABSPATH' ) or die("Hi there!  I'm just a plugin, not much I can do when called directly.");

define('MB_SPIRIT_VERSION', '1.1.0');

register_uninstall_hook( __FILE__, 'mb_spirit_uninstall' );

function mb_spirit_uninstall() {
	delete_option('mb_spirit_options');
}

if ( ! class_exists( 'mb_spirit' ) ) {
	class mb_spirit {
		const API_BASE = 'https://mb-spirit.com/api';
		protected $icon = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyOC4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyNzguNiAyNzguNSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjc4LjYgMjc4LjU7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiNGODk3MUQ7fQ0KCS5zdDF7ZmlsbDojQkNCREMwO30NCgkuc3Qye2ZpbGw6I0ZCQjQ2Mjt9DQoJLnN0M3tmaWxsOiM4QThDOEU7fQ0KPC9zdHlsZT4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xNDMuMiw0MC42Yy01NS4xLDAtOTkuOCw0NC4yLTk5LjgsOTguN2MwLDU0LjUsNDQuNyw5OC43LDk5LjgsOTguN2MxLjUsMCwzLDAsNC41LTAuMQ0KCQljLTQ4LTIuMy04Ni4xLTQxLjYtODYuMS04OS42YzAtNDkuNiw0MC42LTg5LjcsOTAuNy04OS43YzQ4LjYsMCw4OC4yLDM3LjgsOTAuNiw4NS4yYzAuMS0xLjUsMC4xLTMsMC4xLTQuNQ0KCQlDMjQzLDg0LjgsMTk4LjMsNDAuNiwxNDMuMiw0MC42eiBNMjE1LjIsMTcuN2wtMjIuNywyNi43YzMuNSwxLjgsNywzLjgsMTAuMyw2TDIxNS4yLDE3Ljd6IE0zNS41LDEzOS4zYzAtMS40LDAuMS0yLjgsMC4xLTQuMQ0KCQlMMCwxNDAuOWwzNS44LDYuM0MzNS42LDE0NC42LDM1LjUsMTQyLDM1LjUsMTM5LjN6IE0xMTcuMywwbDAsMzUuOGMzLjktMSw3LjktMS43LDEyLTIuMkwxMTcuMywweiBNNjIuOCw2OC40TDMxLjcsNTAuMmwyMy40LDI3LjcNCgkJQzU3LjUsNzQuNiw2MC4xLDcxLjUsNjIuOCw2OC40eiBNMjQzLjMsOTkuNmMxLjUsMy43LDIuOCw3LjUsMy45LDExLjRsMzEuNS0xNy41TDI0My4zLDk5LjZ6IE0zMy42LDIzMC44bDMxLjYtMTgNCgkJYy0yLjgtMi45LTUuNS02LTgtOS4yTDMzLjYsMjMwLjh6IE0xMTYuNCwyNzguNWwxMi40LTMzLjZjLTQuMS0wLjUtOC4xLTEuMy0xMi0yLjNMMTE2LjQsMjc4LjV6Ii8+DQoJPGc+DQoJCTxnPg0KCQkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTE4NS4yLDEwMC43Yy05LjgtMTEuMS0yNC4yLTE4LjEtNDAuMi0xOC4xYy0yOS42LDAtNTMuNSwyMy43LTUzLjUsNTNjMCw0LjUsMC42LDguOCwxLjcsMTIuOQ0KCQkJCWMtMC4yLTEuOC0wLjMtMy42LTAuMy01LjRjMC0yOS43LDI0LjMtNTMuNyw1NC4zLTUzLjdjMTQsMCwyNi43LDUuMywzNi4zLDEzLjhDMTg0LDEwMi40LDE4NC42LDEwMS42LDE4NS4yLDEwMC43eiIvPg0KCQkJPHBhdGggY2xhc3M9InN0MiIgZD0iTTE4NS4yLDEwMC43Yy01LjQsOC4xLTE0LjMsMTIuOC0xNC4zLDEyLjhjMTYuMiwzLjIsMjYuOCwxMi43LDI2LjgsMTIuN0MxOTQuNiwxMDksMTg1LjIsMTAwLjcsMTg1LjIsMTAwLjcNCgkJCQl6Ii8+DQoJCTwvZz4NCgkJPGc+DQoJCQk8cGF0aCBjbGFzcz0ic3QzIiBkPSJNMTg0LjUsODIuNmMyMC4xLDEyLjUsMzMuNSwzNC41LDMzLjUsNTkuN2MwLDM4LjktMzEuOSw3MC41LTcxLjMsNzAuNWMtMTYuMSwwLTMxLTUuMy00Mi45LTE0LjMNCgkJCQljLTAuNywwLjktMS4zLDEuOC0yLDIuN2MwLDAtMC4xLTAuMS0wLjMtMC4yYzEzLjMsMTMsMzEuNiwyMS4xLDUxLjksMjEuMWM0MC45LDAsNzQtMzIuOCw3NC03My4yDQoJCQkJQzIyNy41LDExOS41LDIwOS45LDk0LjIsMTg0LjUsODIuNnoiLz4NCgkJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik04MC40LDE1OC43YzMuMywyOC41LDIxLjUsNDIuNiwyMS41LDQyLjZjOS0xMy43LDI0LjEtMjEuNSwyNC4xLTIxLjVDOTguNywxNzQuNSw4MC40LDE1OC43LDgwLjQsMTU4Ljd6Ii8+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==";
		protected $plugin_id = 'mb_spirit';
		protected $notices = array(); // wp display notices
		public    $single_item = array(); // container for details on a single item
		public    $single_added = false; // indicates that there is already a shortcode rendering a single entry and not to repeat
		public    $ready = false; // API has keys and is ready for rendering widgets
		public    $tb_init = false; // Thickbox Initialized
		protected $opt_key = 'mb_spirit_options';
		protected $opts = null; // container for plugin settings
		// loaded from mb-spirit.com/api
		protected $list_pages = array('schedule_page','event_list_page','staff_list_page','class_description_list_page');
		// loaded from mb-spirit.com/api
		protected $opt_settings = array(
			'use_classic_editor' => array(true,'bool',"Use Classic Editor","Set by default, we recommend use of the classic editor to allow insertion of short-codes. If you prefer the Gutenberg editor, you can still use short codes, but the tools are not yet available to allow insertion."),
			'public' => array(false,'bool',"Public","Allow MB Spirit content to be injected into pages from this plugin. If not enabled, content will only be shown if a user is logged in."),
			'api_key' => array(false,'text',"API Key","Public key used to access your data through the MB Spirit API (please register with MB Spirit first!)"),
			'api_secret' => array(true,'text',"API Secret","Private key for the MB Spirit system. Allows remote management of your MB Spirit account from inside WordPress."),
			'seo_embed' => array(true,'bool',"SEO Optimized","Fetch the widget content via the server to allow this content to be indexed by search engines."),
			'schedule_page' => array(true,'widget_page',"Schedule Page","Select a page and format to display your schedule. Shortcodes will be optimized for SEO by generating links for staff details.",'schedule'),
			'event_list_page' => array(true,'widget_page',"Event List Page","Select a page and format to display your events. Shortcodes will be optimized for SEO by generating links for event details.",'event'),
			'staff_list_page' => array(true,'widget_page',"Staff List Page","Select a page and format to display your staff. Shortcodes will be optimized for SEO by generating links for staff details.",'staff'),
			'class_description_list_page' => array(true,'widget_page',"Class Description List Page","Select a page and format to display your class descriptions. Shortcodes will be optimized for SEO by generating links for class description details.",'class_description'),
			'emoji' => array(true,'bool',"Suppress Emoji's","Disable replacement of special characters with images, introduced in WordPress 4.2. Improves presentation of widget navigation buttons."),
		);
		protected $seo_user_agents = '~bot|facebook|crawl|slurp|spider~i';

		/*
		Define language and add all core actions and filters
		*/
		public function __construct() {
			$this->lang = 'en';
			$locale = substr(get_locale(),0,2);
			if (defined('ICL_LANGUAGE_CODE')) {
				$this->lang = constant('ICL_LANGUAGE_CODE');
			} elseif (!empty($locale)) {
				$this->lang = $locale;
			}
			add_action( 'init', array($this, 'init') );
			
			$this->init_wpseo();
			add_action('elementor/editor/before_enqueue_scripts', function() {
				wp_register_script('mb-spirit-widgets-admin',plugins_url('/js/admin.js', __FILE__));
				wp_enqueue_script('mb-spirit-widgets-admin');
				wp_enqueue_style( $this->plugin_id, plugins_url('/style/admin.css', __FILE__), array(), MB_SPIRIT_VERSION );
			});
			if (is_admin()) {
				add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_page_links') );
				add_action( 'activated_plugin', array($this,'activation_redirect') );		
				add_action( 'admin_enqueue_scripts', array($this, 'init_scripts') );
				add_action( 'admin_menu', array($this, 'admin_menu') );
				add_action( 'admin_notices', array($this, 'show_notices') );
				add_action( 'wp_dashboard_setup', array($this, 'add_dashboard_widgets') );
				add_filter( 'wp_link_query_args', array($this, 'editor_link_query'));
				add_filter( 'wp_link_query', array($this, 'editor_links'), 10, 2 );
				add_action( 'wp_ajax_mb_spirit_add_sc_to_page', array($this, 'add_sc_to_page') );
				add_action( 'wp_ajax_mb_spirit_dismiss_notice', array($this, 'dismiss_notice') );
				add_action( 'wp_ajax_mb_spirit_api_proxy', array($this, 'api_proxy') );
				add_action( 'wp_ajax_mb_spirit_complete_register', array($this, 'complete_register') );
				add_action( 'wp_ajax_mb_spirit_lookup_account', array($this, 'lookup_account') );
				add_action( 'wp_ajax_mb_spirit_connect_account', array($this, 'connect_account') );
				add_action( 'wp_ajax_mb_spirit_refresh_site', array($this, 'refresh_site') );
				add_action( 'wp_ajax_mb_spirit_refresh_state', array($this, 'refresh_state') );
				register_activation_hook( __FILE__, array($this, 'install') );
			} else {
				add_action( 'wp_enqueue_scripts', array($this, 'init_scripts') );
				add_filter( 'document_title_parts', array( $this, 'check_page_title' ));
				add_shortcode( 'mb-spirit', array( $this, 'sc_mb_spirit' ) );
				add_filter( 'the_content', array( $this, 'render_default_pages' ) );
			}
		}
		
		/**
		 * Initialize settings with basic defaults, set all settings to blank
		 *
		 * @since 1.0.0
		 *
		 * @param array   $settings     Current value of settings in the WordPress options key
		 * @return array Filtered settings returned from API call
		 */
		public function install() {
			if (!get_option($this->opt_key)) {
				$settings = array();
				foreach ($this->opt_settings as $k=>$info) {
					$settings[$k] = '';
				}
				add_option($this->opt_key,$settings);
				$this->opts = get_option($this->opt_key);
			}
		}

		/**
		 * Remove settings option key on uninstall (previously set on deactivation hook)
		 *
		 * @since 1.0.5
		 *
		 */
		public function uninstall() {
			delete_option($this->opt_key);
		}

		/**
		 * Redirect immediately to settings page on activation
		 *
		 * @since 1.0.5
		 *
		 * @param string   $plugin     slug of the plugin
		 * @return void
		*/
		public function activation_redirect( $plugin ) {
			if( $plugin == plugin_basename( __FILE__ ) ) {
				exit( wp_redirect( admin_url( 'admin.php?page=mb_spirit_register' ) ) );
			}
		}

		/**
		 * Add link to change settings on plugins page
		 *
		 * @since 1.0.5
		 *
		 * @param string   $plugin     slug of the plugin
		 * @return void
		*/
		public function plugin_page_links($links) {
			$addlinks = array(
				'<a href="' . admin_url( 'admin.php?page=mb_spirit_register' ) . '">' . __("Register",$this->plugin_id) . '</a>',
				'<a href="' . admin_url( 'admin.php?page=mb_spirit' ) . '">' . __("Settings",$this->plugin_id) . '</a>',
			);
			return array_merge( $links, $addlinks );
		}

		/**
		 * Set up options, add thickbox, and process settings updates if present
		 * Check if API is ready and process any API proxy requests
		 * Add action to add media button for MB Spirit if API is ready
		 *
		 * @since 1.0.0
		 *
		 */
		public function init() {
			load_plugin_textdomain($this->plugin_id, false, basename(dirname(__FILE__)));
			$this->opts = get_option($this->opt_key);
			$this->opts['seo_user_agents'] = !empty($this->opts['seo_user_agents']) ? $this->opts['seo_user_agents'] : $this->seo_user_agents;
			$this->opts['force_flush'] = isset($this->opts['force_flush']) ? $this->opts['force_flush'] : false;
			if (!empty($this->opts['use_classic_editor'])) {
				add_filter( 'gutenberg_can_edit_post', '__return_false', 9 );
				add_filter( 'use_block_editor_for_post', '__return_false', 9 );
			} else {
				$this->gutenberg_blocks();
			}
			
			if (is_admin() && current_user_can('manage_options')) {
				// TODO: try to load only when required
				//add_action( 'admin_footer', array($this, 'init_thickbox') );

				// we are updating the settings for the plugin
				if (isset($_POST[$this->opt_key])) {
					$this->load_settings();
					$v = $_POST[$this->opt_key];
					foreach ($this->opt_settings as $k=>$info) {
						switch ($info[1]) {
							case 'bool' :
								$v[$k] = (bool)$v[$k];
								break;
							case 'email' :
								$v[$k] = filter_var($v[$k],FILTER_VALIDATE_EMAIL);
								break;
							case 'widget_page' :
								$v[$k]['page'] = (int)$v[$k]['page'];
								if ($v[$k]['page'] > 0) {
									$v[$k]['widget'] = rawurldecode($v[$k]['widget']);
									$v[$k]['code_info'] = json_decode(rawurldecode($v[$k]['code_info']),true);
								} else {
									$v[$k] = null;
								}
								break;
							case 'pagelist' :
							case 'number' :
								$v[$k] = (int)$v[$k];
								break;
							case 'programlist' :
								$v[$k] = join(',',array_map('intval',$v[$k]));
								break;
							case 'url' :
							case 'fqdn' :
							case 'text' :
								$v[$k] = $v[$k];
								break;
						}
					}
					$v = $this->filter_settings($v);
					$v['seo_user_agents'] = $this->seo_user_agents;
					update_option($this->opt_key, $v);
					$this->opts = get_option($this->opt_key);
					$this->notices[] = array(
						'id'    => $this->plugin_id . 'savedokay',
						'title' =>__("Settings Saved", $this->plugin_id),
					);
				} // end settings update

			}
			$this->APIReady = $this->do_checks();
			if ($this->APIReady) {
				if (!empty($_GET['mb_spirit_refresh_site'])) {
					$res = $this->refresh_site();
					echo json_encode($res['status'] == 'OK');
					exit;
				}
				if (!empty($_GET['mb_spirit_refresh_state'])) {
					try {
						$res = $this->apiCall('refresh_state','list');
						echo json_encode($res);
					} catch (Exception $e) {
						echo json_encode($e);
					}
					exit;
				}

				add_action( 'media_buttons', array($this, 'media_btn') );
			}
		}
		
		public function api_proxy() {
			//$this->APIReady = $this->do_checks();
			$error = "Invalid action";
			if (defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && $this->APIReady && !empty($_GET['endpoint'])) {
				$endpoint = $_GET['endpoint'];
				unset($_GET['endpoint']);
				$verb = !empty($_GET['verb']) ? $_GET['verb'] : null;
				unset($_GET['verb']);
				$req = !empty($_POST) ? $_POST : $_GET;
				try {
					$res = $this->apiCall($endpoint,null,$req);
					echo json_encode($res);
					exit;
				} catch (Exception $e) {
					$error = $e->getMessage();
				}
			}
			echo json_encode(array('status'=>'ERROR','message'=>$error));
			exit;
		}
		
		public function complete_register() {
			if (defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && !empty($_POST['email']) && !empty($_POST['password'])) {
				$_POST['site_url'] = get_bloginfo('wpurl');
				try {
					$res = $this->apiCall('wp_register','complete',$_POST,'POST');
					if ($res['status'] == 'OK') {
						$res['content'] = $this->add_pagelist($res['content']);
						$this->opts = get_option($this->opt_key);
						$this->opts['api_key'] = $res['api_key'];
						$this->opts['api_secret'] = $res['api_secret'];
						update_option($this->opt_key, $this->opts);
					}
				} catch (Exception $e) {
					$res = array('status'=>'ERROR');
				}
			} else {
				$res = array('status'=>'ERROR');
			}
			echo json_encode($res);
			exit;
		}
		
		public function lookup_account() {
			if (defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && !empty($_POST['email']) && !empty($_POST['password'])) {
				$_POST['site_url'] = get_bloginfo('wpurl');
				try {
					$res = $this->apiCall('wp_user_sites','list',$_POST,'POST');
				} catch (Exception $e) {
					$res = array('status'=>'ERROR');
				}
			} else {
				$res = array('status'=>'ERROR');
			}
			echo json_encode($res);
			exit;
		}
		
		public function connect_account() {
			if (defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && !empty($_POST['token']) && !empty($_POST['secret'])) {
				$this->opts = get_option($this->opt_key);
				$this->opts['api_key'] = $_POST['token'];
				$this->opts['api_secret'] = $_POST['secret'];
				update_option($this->opt_key, $this->opts);
				$res = $this->apiCall('ping');
				if ($res['status'] == 'OK') {
					$congratulations = !empty($res['new_register_message']) ? $res['new_register_message'] : __("Congratulations, your account has been successfully linked to this WordPress site!",$this->plugin_id);
					$res['message'] = sprintf('<p class="leadin">%s</p>%s',$congratulations,$res['demo_option']);
					$res['message'] = $this->add_pagelist($res['message']);
				}
			} else {
				$res = array('status'=>'ERROR','message'=>__("No tokens passed in to link site",$this->plugin_id));
			}
			echo json_encode($res);
			exit;
		}

		public function add_sc_to_page() {
			if (defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && !empty($_POST['shortcode'])) {
				if (!empty($_POST['page_id'])) {
					$post = get_post((int)$_POST['page_id']);
					if (!empty($post)) {
						$update_post = array(
							'ID'=>(int)$post['ID'],
							'post_content'=>$post['post_content'] . "\n\n" . $_POST['shortcode'],
						);
						wp_update_post( $update_post );
						$res = array('status'=>'OK','id'=>(int)$update_post['ID']);
					} else {
						$res = array('status'=>'ERROR','message'=>__("Page not found to add shortcode too",$this->plugin_id));
					}
				} else {
					$new_post = array(
						'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
						'post_content'  => $_POST['shortcode'],
						'post_status'   => 'publish',
						'post_type'   => 'page'
					);
					$id = wp_insert_post( $new_post );
					$res = array('status'=>'OK','id'=>$id);
				}
			} else {
				$res = array('status'=>'ERROR','message'=>__("No shortcode passed in to link to page",$this->plugin_id));
			}
			echo json_encode($res);
			exit;
		}

		public function render_gb_block($attributes,$content,$block) {
			return $attributes['shortCode'];
			
		}
		public function gutenberg_blocks() {
			if ( ! function_exists( 'register_block_type' ) ) {
				// Gutenberg is not active.
				return;
			}

			// __DIR__ is the current directory where block.json file is stored.
			register_block_type(
				__DIR__ . '/gutenberg-shortcodes',
				[
					'render_callback'=>array($this, 'render_gb_block' ),
					'icon' => array(
					    // Specifying a background color to appear with the icon e.g.: in the inserter.
					    'background' => '#eb9316',
					    // Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
					    'foreground' => '#ffffff',
					    // Specifying a dashicon for the block
					    'src' => 'shortcode',
					)
				]
			);

			if ( function_exists( 'wp_set_script_translations' ) ) {
				/**
				 * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
				 * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
				 * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
				 */
				wp_set_script_translations( 'shortcode-builder', 'mb-spirit' );
			}
		}

		/**
		 * Load required styles and scripts for admin, additional scripts loaded on demand
		 * from MB Spirit as required through the API service
		 *
		 * @since 1.0.0
		 *
		 */
		public function init_scripts() {
			if (is_admin()) {
				wp_register_script('mb-spirit-widgets-admin',plugins_url('/js/admin.js', __FILE__));
				wp_enqueue_script('mb-spirit-widgets-admin');
				wp_enqueue_style( $this->plugin_id, plugins_url('/style/admin.css', __FILE__), array(), MB_SPIRIT_VERSION );
			} elseif ($this->APIReady) {
				// added in 1.0.4 to resolve render issues where emoji icons replace standard arrows
				if (!empty($this->opts['emoji'])) {
					remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
					remove_action( 'wp_print_styles', 'print_emoji_styles' );
				}
				wp_register_style('mb-spirit-widgets', self::API_BASE . '/css/widgets.default.css');
				wp_enqueue_style( 'mb-spirit-widgets' );
				wp_enqueue_script('mb-spirit-dyn-widget', self::API_BASE . '/widgets/'.$this->opts['api_key'], null, MB_SPIRIT_VERSION, true );
			}
		}


		/**
		 * Use API to retrieve the settings required to operate the plugin
		 *
		 * MB Spirit strives for updatability of components without the need for continuous
		 * upgrades of the plugin, so loads contextual settings from the MB Spirit API.
		 *
		 * @since 1.0.0
		 *
		 * @param bool   $flush     Optional, default is false, allowing for caching of transient
		 */
		public function load_settings($flush = false) {
			$this->opts = !empty($this->opts) ? $this->opts : get_option($this->opt_key);
			try {
				$res = $this->apiCall('wp_settings','list',array('lang'=>$this->lang,'options'=>json_encode($this->opts)));
	 			set_transient('MB_SPIRIT_SETTINGS_INFO', $res, 1 * YEAR_IN_SECONDS );
			} catch (Exception $e) {
	 			$res = get_transient('MB_SPIRIT_SETTINGS_INFO', $res);
			}
			$this->opt_settings = !empty($res['opt_settings']) ? $res['opt_settings'] : $this->opt_settings;
			$this->list_pages = !empty($res['list_pages']) ? $res['list_pages'] : $this->list_pages;
			$this->options_form = $res['options_form'];
			$this->widget_form = $res['widget_form'];
			$this->seo_user_agents = $res['seo_user_agents'];
		}
		
		/**
		 * Pass settings array to the API to retrieve the settings required to operate the plugin
		 *
		 * MB Spirit strives for updatability of components without the need for continuous
		 * upgrades of the plugin, so filters contextual settings through the MB Spirit API.
		 *
		 * @since 1.0.0
		 *
		 * @param array   $settings     Current value of settings in the WordPress options key
		 * @return array Filtered settings returned from API call
		 */
		private function filter_settings($settings) {
			try {
				$res = $this->apiCall('wp_settings','filter',array('lang'=>$this->lang,'options'=>json_encode($settings)),'POST');
				if ($res['status'] == 'OK') {
					$settings = $res['settings'];
				}
				return $settings;
			} catch (Exception $e) {
				return $settings;
			}
		}

		/**
		 * Clear all transient data for MB Spirit and push a site refresh to MB Spirit
		 *
		 * @since 1.0.10
		 *
		 * @param array   $settings     Additional settings for the refresh service call
		 * @return mixed  Value returned from API call or false if failed
		 */
		public function refresh_site($options = array()) {
			$res = array('status'=>'ERROR','message'=>"API Not Ready");
			if (defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && $this->APIReady) {
				global $wpdb;
				// remove all transients
				$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_MB_SPIRIT_%'");
				try {
					$res = $this->apiCall('refresh_site','list',$options);
				} catch (Exception $e) {
					$res = array('status'=>'ERROR','message'=>$e->getMessage());
				}
			}
			echo json_encode($res);
			exit;
		}
		
		/**
		/**
		 * Clear all transient data for MB Spirit and push a site refresh to MB Spirit
		 *
		 * @since 1.0.10
		 *
		 * @param array   $settings     Additional settings for the refresh service call
		 * @return mixed  Value returned from API call or false if failed
		 */
		public function refresh_state() {
			$res = array('status'=>'ERROR','message'=>"API Not Ready");
			if (defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && $this->APIReady) {
				try {
					$res = $this->apiCall('refresh_state','list');
				} catch (Exception $e) {
					$res = array('status'=>'ERROR','message'=>$e->getMessage());
				}
			}
			echo json_encode($res);
			exit;
		}

		/*
		 * Check for core components and settings
		 * If there are credentials present PING the API to check the validity of the credentials
		 * Set notices for admin display if errors are detected
		 *
		 * @since 1.0.0
		 *
		 * @return bool Indicates whether the API is ready to receive calls
		 */
		public function do_checks() {
			$showNotices = is_admin();
			if ($showNotices) {
				if (!function_exists('curl_init')) {
					$this->notices[] = array(
						'id'    => $this->plugin_id . 'curl_init',
						'type'=>'error',
						'title' =>__("Error with curl",$this->plugin_id),
						'desc'  =>__("cURL is not available for the MB Spirit plugin to operate. Please ensure that this function is available and has not been filtered out with the php.ini setting: `disable_functions`.",$this->plugin_id),
					);
				}
			}

			if ( empty($this->opts['api_key']) || empty($this->opts['api_secret']) ) { 
				if ($showNotices) {
					$this->notices[] = array(
						'id'    => $this->plugin_id . 'inactive',
						'type'=>'warning',
						'title' =>__("Register for MB Spirit",$this->plugin_id),
						'desc'  =>sprintf(
							__("MB Spirit is not yet configured with an account. You need to either %s with MB Spirit or enter the credentials for your site under %s enable the plugin when ready.", $this->plugin_id),
							'<a href="admin.php?page=mb_spirit_register">' . __("MB Spirit &rarr; Register", $this->plugin_id) . '</a>',
							'<a href="admin.php?page=mb_spirit">' . __("MB Spirit &rarr; Settings", $this->plugin_id) . '</a>'
						),
					);
				}
				return false;
			} else {
				$ok_credentials = true;
				if ($showNotices) {
					try {
						$res = $this->apiCall('ping','full');
						$ok_credentials = $res['status'] == 'OK';
						if ($res['status'] !== 'OK') {
							$this->notices[] = array(
								'id'    => $this->plugin_id . 'credentials',
								'type'=>'error',
								'title' =>__("Error with API credentials",$this->plugin_id),
								'desc'  =>sprintf(
									__("The MB Spirit credentials you entered are incorrect. Check your credentials under %s.",$this->plugin_id),
									'<a href="admin.php?page=mb_spirit">' . __("MB Spirit &rarr; Settings", $this->plugin_id) . '</a>'
								)
							);
						} elseif (!empty($res['notices'])) {
							foreach ($res['notices'] as $i=>$n) {
								$this->notices[] = array(
									'id'    => $this->plugin_id . '_user_notice_' . $i,
									'type'=>!empty($n['type']) ? $n['type'] : 'success',
									'uid' =>$n['uid'],
									'title' =>$n['title'],
									'desc'  =>$n['desc']
								);
							}
						}
					} catch (Exception $e) {
						$this->notices[] = array(
							'type'=>'error',
							'title' =>__("MB Spirit is Offline",$this->plugin_id),
							'desc'  =>sprintf(
								__("MB Spirit is not responding at this time. We are working on resolving the issues. Check at %s for updates",$this->plugin_id),
								'<a href="https://twitter.com/getmbspirit">twitter.com/getmbspirit</a>'
							)
						);
						$ok_credentials = false;
					}
				}
			}
			if ($ok_credentials && (bool)$this->opts['public'] == false) {
				$this->notices[] = array(
					'id'    => $this->plugin_id . 'inactive',
					'type'=>'warning',
					'title' =>__("MB Spirit in Sandbox",$this->plugin_id),
					'desc'  =>sprintf(
						__("MB Spirit is running in sandbox mode. Content will hidden to visitors who are not logged in within your WordPress site. Check the config under %s enable the plugin when ready.", $this->plugin_id),
						'<a href="admin.php?page=mb_spirit">' . __("MB Spirit &rarr; Settings", $this->plugin_id) . '</a>'
					),
				);
			}
			return true;
		}

		/**
		 * If Yoast SEO is enabled, we will handle setting SEO optimized entries for meta data
		 * handles facebook and twitter as well as basic search engine meta data
		 *
		 * @since 1.0.0
		 *
		 */
		public function init_wpseo() {
			add_filter( 'wpseo_canonical', array( $this, 'set_single_url'));
			add_filter( 'wpseo_metadesc', array( $this, 'set_single_desc'));
			add_filter( 'wpseo_opengraph_desc', array( $this, 'set_single_desc'));
			add_filter( 'wpseo_twitter_description', array( $this, 'set_single_desc'));
			add_filter( 'wpseo_title', array( $this, 'set_single_title'));
			add_filter( 'wpseo_twitter_title', array( $this, 'set_single_title'));
			add_filter( 'wpseo_opengraph_image', array( $this, 'set_single_img'));
			add_filter( 'wpseo_twitter_image', array( $this, 'set_single_img'));
		}

		/**
		 * Set the URL for the permalink to include GET params for a single entry
		 *
		 * @since 1.0.0
		 *
		 * @param string   $url     Current value of URL from hook
		 * @return string  Modified URL if single entry present
		 */
		public function set_single_url($url) {
			if ( is_singular() && !empty($_GET['single']) && !empty($_GET['id'])) {
				$url .= sprintf('?single=%s&id=%d',$_GET['single'],$_GET['id']);
			}
			return $url;
		}

		/**
		 * Set the description for the page for a single entry
		 *
		 * @since 1.0.0
		 *
		 * @param string   $url     Current value of description from hook
		 * @return string  Modified description if single entry present
		 */
		public function set_single_desc($desc) {
			if ( is_singular() && !empty($_GET['single']) && !empty($_GET['id'])) {
				$this->single_item = $this->single_item ? $this->single_item : $this->get_single($_GET['single'],$_GET['id']);
				$sdesc = apply_filters( 'mb_spirit_single_desc', $this->single_item['info']['og_desc'] );
				if (!empty($sdesc)) {
					$desc = $sdesc;
				}
			}
			return $desc;
		}

		/**
		 * Set the title for the page for a single entry
		 *
		 * @since 1.0.0
		 *
		 * @param string   $url     Current value of title from hook
		 * @return string  Modified title if single entry present
		 */
		public function set_single_title($title) {
			if ( is_singular() && !empty($_GET['single']) && !empty($_GET['id'])) {
				$this->single_item = $this->single_item ? $this->single_item : $this->get_single($_GET['single'],$_GET['id']);
				$stitle = apply_filters( 'mb_spirit_single_title', $this->single_item['title'] );
				if (!empty($stitle) && !isset($this->single_item['title-added'])) {
					$title .= ' - ' . $stitle;
					$this->single_item['title-added'] = true;
				}
			}
			return $title;
		}

		/**
		 * Set the image URL for the page for a single entry
		 *
		 * @since 1.0.0
		 *
		 * @param string   $url     Current value of image URL from hook
		 * @return string  Modified image URL if single entry present
		 */
		public function set_single_img($url) {
			if ( is_singular() && !empty($_GET['single']) && !empty($_GET['id'])) {
				$this->single_item = $this->single_item ? $this->single_item : $this->get_single($_GET['single'],$_GET['id']);
				$surl = apply_filters( 'mb_spirit_single_image', $this->single_item['info']['profile_img_full'] );
				if (!empty($surl)) {
					$url = $surl;
				}
			}
			return $url;
		}

		/**
		 * Append content to pages defined as the defaults in settings, using the widget definitions supplied
		 * Under settings, you can set pages to display your default widgets for quick setup
		 *
		 * @since 1.0.0
		 *
		 * @param string   $content     Current value of page content
		 * @return string  Content with the widget code added if matching a page
		 */
		public function render_default_pages($content) {
			if ( $this->APIReady && is_singular() && is_main_query()) {
				foreach ($this->list_pages as $t) {
					$o = $this->opts[$t];
					if (!empty($o['page']) && $o['page'] == get_the_ID() && !empty($o['widget'])) {
						$mod_content = apply_filters( 'mb_spirit_default_page_content', $content, $t, $o['widget'] );
						$mod_content = apply_filters( 'mb_spirit_default_page_content_'.$t, $mod_content, $o['widget'] );
						if ($mod_content != $content) {
							$content = $mod_content;
						} else {
							$content .= do_shortcode($o['widget']);
						}
					} 
				}
			}
			return $content;
		}

		/**
		 * Hooked from document_title_parts, modify the parts of the title to include reference
		 * to a single item if present
		 *
		 * @since 1.0.0
		 *
		 * @param array    $title     Title parts array from hook
		 * @return array  Modified title parts as required
		 */
		public function check_page_title($title) {
			if ( is_singular() && !empty($_GET['single']) && !empty($_GET['id'])) {
				$this->single_item = $this->get_single($_GET['single'],$_GET['id']);
				$stitle = apply_filters( 'mb_spirit_single_title', $res['title'] );
				if (!empty($stitle)) {
					$title['title'] .= ' - ' . $stitle;
				}
			}
			return $title;
		}
		
		/**
		 * Fetch a single entry for an item via the API service for SEO optimized pages
		 *
		 * @since 1.0.0
		 *
		 * @param string    $type   Type of entry to fetch
		 * @param int       $id     Entry ID
		 * @param array     $attrs     Shortcode attributes inherited from parent widget
		 * @return array    The entry data object, including raw data for processing by hooks
		 */
		private function get_single($type,$id,$attrs = array()) {
			$request = array(
				'schedule'=>@$attrs['data-schedule'],
				'events'=>@$attrs['data-events'],
				'bootstrap'=>@$attrs['data-bootstrap'],
				'date_info'=>@$attrs['data-date_info'],
				'reg_btns'=>@$attrs['data-reg_btns'],
				'appointments'=>@$attrs['data-appointments'],
				'single'=>$type,
				'full_data'=>1,
				'id'=>$id
			);
			$request = apply_filters( 'mb_spirit_single_request', $request );
			$cacheKey = 'MB_SPIRIT_CALL_'.md5(print_r($request,1));
			if (isset($_GET['flush']) || $this->opts['force_flush'] === true) {
				delete_transient( $cacheKey );
			}
			$res = is_user_logged_in() ? false : get_transient( $cacheKey );
			if ($res === false) {
				try {
					$res = $this->apiCall($request['single'],null,$request);
				} catch (Exception $e) {
					return null;
				}
				$res = apply_filters( 'mb_spirit_single_reponse', $res );
				if (!is_user_logged_in()) {
		 			set_transient( $cacheKey, $res, 1 * HOUR_IN_SECONDS );
				}
			}
			return $res;
		}

		/**
		 * Handle retrieval of widget codes from the API service
		 * and execute these codes for SEO rendering
		 *
		 * @since 1.0.0
		 *
		 * @param array     $atts     Shortcode attributes
		 * @param string    $content  Content of shortcode
		 * @param int       $tag      Name of this shortcode
		 * @return string   The html to display in place of the shortcode
		 */
		public function sc_mb_spirit($atts=array(), $content = null, $tag = null  ) {
			global $post;
			$content = preg_replace('~^\s+$~s','',$content);
			$html = '';
			if ($this->opts['public'] == false && !is_user_logged_in()) {
				return '';
			}
			// let logged in users see that the API isn't ready
			if (!$this->APIReady && is_user_logged_in()) {
				return __("API for MB Spirit not set up properly", $this->plugin_id);
			// else just hide the issue from public users
			} elseif (!$this->APIReady) {
				return '';
			}

			/* Parse defaults */
			$atts = wp_parse_args($atts,array(
				'widget'=>'schedule',
				'source'=>'preset',
				'id'=>'default',
				'embed'=>'false',
			));
			// handle transient on widget list
			$cacheKey = 'MB_SPIRIT_WIDGET_LIST';
			// flush the widget details if forcing or the user is logged in
			if (isset($_GET['flush']) || $this->opts['force_flush'] === true || is_user_logged_in()) {
				delete_transient( $cacheKey );
			}
			$cached = get_transient( $cacheKey );
			if ($cached === false) {
				try {
					$res = $this->apiCall('widget_list','list');
				} catch (Exception $e) {
					return "Error with MB Spirit: ". $e->getMessage();
				}
				$cached = $res;
				if (!is_user_logged_in()) {
			 		set_transient( $cacheKey, $cached, 2 * HOUR_IN_SECONDS );
				}
			}
			$atts = apply_filters( 'mb_spirit_sc_attr', $atts, $tag );
			if (!empty($cached['types'][$atts['widget']][$atts['source']][$atts['id']]['rendered-code'])) {
				$html = $cached['types'][$atts['widget']][$atts['source']][$atts['id']]['rendered-code'];
			} elseif (is_user_logged_in()) {
				return sprintf(
					'<div class="mb-spirit-widget-missing">
						<p style="color: red;"><strong>%s</strong></p>
						<p>
							<strong>%s:</strong> %s;
							<strong>%s:</strong> %s;
							<strong>%s:</strong> %s;
							<strong>%s:</strong> %s
						</p>
					</div>'
					,__("Widget Unavailable", $this->plugin_id)
					,__("Description", $this->plugin_id)
					,$atts['desc']
					,__("Type", $this->plugin_id)
					,$atts['widget']
					,__("Source", $this->plugin_id)
					,$atts['source']
					,__("ID", $this->plugin_id)
					,$atts['id']
				);
			} else {
				return __("No information available", $this->plugin_id);
			}
			// process inline attributes to override defaults from widget
			$wAttr = array();
			if (preg_match('~(<div data-mb-spirit\s*=\s*"[^"]+")([^>]*)>~si',$html,$m)) {
				list($widgetTag,$start,$attstr) = $m;
				preg_match_all('~\bdata-([a-z0-9_-]+)\s*=\s*"([^"]+)"~',$attstr,$a,PREG_SET_ORDER);
				foreach ($a as $r) {
					$wAttr['data-'.$r[1]] = $r[2];
				}
				foreach ($atts as $k=>$v) {
					if (in_array($k,array('desc','widget','source','id','--embed'))) { continue; }
					$wAttr['data-'.$k] = $v;
				}
				$attList = array();
				$wAttr = apply_filters( 'mb_spirit_sc_widget_attr', $wAttr, $tag, $atts );
				foreach ($wAttr as $k=>$v) {
					$attList[] = sprintf(' %s="%s"',$k,htmlentities($v));
				} 
				$html = str_replace($widgetTag,$start . join('',$attList) . '>',$html);
			}
			foreach ($wAttr as $k=>$v) {
				$k = str_replace('data-','',$k);
				$request[$k] = $v;
			}
			$request = apply_filters( 'mb_spirit_sc_widget_request', $request, $tag, $atts );
			// if we are debugging or if we detect this to be a search engine, render the result of the widget for SEO if that is enabled
			if ( 
				$this->bool($atts['embed']) || // widget requires embedding by definition
				isset($_GET['nojs']) || // test parameter to force a server render of widget
				(
					$this->opts['seo_embed'] && // SEO embedding on
					isset($_SERVER['HTTP_USER_AGENT']) && // we have a user agent string to test
					preg_match($this->opts['seo_user_agents'], $_SERVER['HTTP_USER_AGENT']) // the user agent string matches our pattern
				)
			) {
				// handle the single item entries as well for better SEO
				if (
					is_singular() && 
					!empty($_GET['single']) && 
					in_array($_GET['single'],$cached['single']) && 
					!empty($_GET['id']) && 
					$this->single_added == false &&
					empty($request['no_single'])
				) {
					$wres = $this->get_single($_GET['single'],$_GET['id'],$wAttr);
					$html = $cached['single_wrap'];
					$html = str_replace('{title}',$wres['title'],$html);
					$html = str_replace('{html}',$wres['html'],$html);
					$html = apply_filters( 'mb_spirit_seo_single', $html, $wres, $_GET['single'], $_GET['id'] );
					$this->single_added = true;
					return $html;
				// handle the list entries
				} else {
					if (!empty($content)) {
						$html = preg_replace('~^\s*(<[^>]*>).*?(</[^>]*>)\s*$~s','$1'.$this->rx_esc($content).'$2',$html);
					}
					$html = apply_filters( 'mb_spirit_seo_html', $html );
					$request['mb-spirit'] = $atts['widget'].'_widget';
					$request['notrack'] = $this->bool($atts['embed']) ? 'false' : 'true';
					$request = apply_filters( 'mb_spirit_seo_request', $request );
					$cacheKey = 'MB_SPIRIT_CALL_'.md5(print_r($request,1));
					if (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'no-cache' || isset($_GET['flush']) || $this->opts['force_flush'] === true) {
						delete_transient( $cacheKey );
					}
					$wres = get_transient( $cacheKey );
					if ($wres === false) {
						try {
							$wres = $this->apiCall($request['mb-spirit'],null,$request);
						} catch (Exception $e) {
							return $e->getMessage();
						}
				 		set_transient( $cacheKey, $wres, 1 * HOUR_IN_SECONDS );
					}
					$wres = apply_filters( 'mb_spirit_seo_response', $wres, $request );
					foreach ($wres['html'] as $k=>$h) {
						if (preg_match('~(<div[^>]*\bclass="[^"]*\bmb-spirit-'.$k.'\b[^"]*"[^>]*>).*?(</div>)~si',$html,$f)) {
							$html = str_replace($f[0],$f[1].$h.$f[2],$html);
						} else {
							$html = preg_replace('~(</div>\s*$)~s','<div class="mb-spirit-'.$k.'">'.$this->rx_esc($h).'</div>$1',$html);
						}
					}
				}
			}
			$filtered_html = apply_filters( 'mb_spirit_widget_output', $html, $content, $request['mb-spirit'], $request );
			if (!empty($filtered_html) && $filtered_html != $html) {
				$html = $filtered_html;
			// if there's content inside the tag, keep it at the beginning of the output
			} elseif (!empty($content)) {
				$html = preg_replace('~^\s*(<[^>]*>).*?(</[^>]*>)\s*$~s','$1'.$this->rx_esc($content).'$2',$html);
			}
			return $html;
		}

		/**
		 * Test editor links to determine if anything would be shown and trick results if not to ensure next hook will be triggered
		 * This addresses an issue with the wp_link_query method that returns false before allowing result modification if there are no results
		 *
		 * @since 1.0.11
		 *
		 * @param  array $results     Current value of link results from WordPress routine
		 * @param  array $query       WP_Query object containing information about the request
		 * @return array original link results modified with links returned from API call
		 */
		public function editor_link_query($query) {
			$query['s_orig'] = $query['s'];
			$get_posts = new WP_Query;
			$posts = $get_posts->query( $query );
			// Check if any posts were found.
			if ( ! $get_posts->post_count ) {
				unset($query['s']);
				$query['no_results'] = true;
			}
			return $query;
		}
		/**
		 * Modify editor link list to allow addition of results from MB Spirit register/buy links to be added
		 *
		 * @since 1.0.11
		 *
		 * @param  array $results     Current value of link results from WordPress routine
		 * @param  array $query       WP_Query object containing information about the request
		 * @return array original link results modified with links returned from API call
		 */
		public function editor_links($results,$query) {
			if ($this->APIReady) {
				if (!empty($query['s_orig'])) {
					if ($query['no_results']) {
						$results = array();
					}
					try {
						$query['s'] = $query['s_orig'];
						$res = $this->apiCall('wp_get_links','list',$query);
						if ($res['status'] == 'OK' && !empty($res['links'])) {
							foreach ($res['links'] as $l) {
								$results[] = $l;
							}
						}
					} catch (Exception $e) {
						error_log($e->getMessage());
					}
				}
			}
			return $results;
		}
		
		/**
		 * Insert a Media button for MB Spirit above the editor
		 *
		 * @since 1.0.0
		 *
		 * @param string    $editor_name      Name of the editor requesting the button (used to ID the editor in callbacks)
		 */
		public function media_btn($editor_name) {
			printf(
				'<a href="#" class="button" onclick="mb_spirit_button(this);return false;" data-editor="%s"><img src="%s" alt="%s" width="16" height="16" style="padding:0;" /> %s</a>'
				, $editor_name
				, plugins_url( '/style/img/mb-spirit-icon-32.png', __FILE__ )
				, __("MB Spirit", $this->plugin_id)
				, __("MB Spirit", $this->plugin_id)
			);
		}
		
		/**
		 * Add thickbox the the page if not already present
		 *
		 * @since 1.0.0
		 *
		 */
		public function init_thickbox() {
			if ($this->tb_init == false) {
				add_thickbox();
				printf(
					'<div id="mb-spirit-shortcodes" style="display:none;"><p>%s</p></div>'
					,__("Loading your widgets from MB Spirit", $this->plugin_id)
				);
				$this->tb_init = true;
			}
		}
		
		/**
		 * Initialize the admin menu for MB Spirit
		 *
		 * @since 1.0.0
		 *
		 */
		public function admin_menu() {
			$menuid = $this->plugin_id . '_mgmt';
			add_menu_page( __('MB Spirit', $this->plugin_id ), __("MB Spirit", $this->plugin_id ), 'manage_options', $menuid, array( $this, 'show_overview_page' ), $this->icon, 20 );
			$this->overview_screen = add_submenu_page( $menuid, __("MB Spirit", $this->plugin_id ), __("Overview", $this->plugin_id ), 'manage_options', $menuid, array($this,'show_overview_page'));
			$this->settings_screen = add_submenu_page( $menuid, __("Manage Settings", $this->plugin_id ), __("Manage Settings", $this->plugin_id ), 'manage_options', $this->plugin_id, array( $this, 'options_page' ) );
			$this->register_screen = add_submenu_page( $menuid, __("Register", $this->plugin_id ), __("Register", $this->plugin_id ), 'manage_options', $this->plugin_id . '_register', array( $this, 'show_register_page' ) );
		}
		
		/**
		 * Hook the dashboard widgets to add a new widget for MB Spirit
		 *
		 * @since 1.0.0
		 *
		 */
		public function add_dashboard_widgets() {
			wp_add_dashboard_widget(
				'mb_spirit_dashboard_widget',         // Widget slug.
				__("MB Spirit", $this->plugin_id),         // Title.
				array($this, 'dashboard_widgets' )// Display function.
			);
		}
		/**
		 * Retrieve content from API to display in dashboard widget
		 *
		 * @since 1.0.0
		 *
		 */
		public function dashboard_widgets() {
			try {
				$res = $this->apiCall('wp_dashboard','list',array('lang'=>$lang));
				echo $res['content'];
			} catch (Exception $e) {
				echo __("MB Spirit is Offline",$this->plugin_id);
			}
		}

		/**
		 * Retrieve content from API to display for overview page
		 *
		 * @since 1.0.0
		 *
		 */
		public function show_overview_page() {
			if ($this->APIReady) {
				$_GET['lang'] = $this->lang;
				try {
					$res = $this->apiCall('wp_intro','list',$_GET);
					$res['content'] = $this->add_pagelist($res['content']);
					echo $res['content'];
				} catch (Exception $e) {
					echo __("MB Spirit is Offline",$this->plugin_id);
				}
			} else {
				$this->show_register_page();
			}
		}

		/**
		 * Retrieve content from API to display register page
		 *
		 * @since 1.0.3
		 *
		 */
		public function show_register_page() {
			$_GET['lang'] = $this->lang;
			try {
				$res = $this->apiCall('wp_register','form');
				// we don't pass their information, but do populate what we can from the WordPress install
				$current_user = wp_get_current_user();
				$res['content'] = str_replace('{email}',esc_attr($current_user->user_email),$res['content']);
				$res['content'] = str_replace('{full_name}',esc_attr($current_user->display_name),$res['content']);
				$res['content'] = str_replace('{site_name}',esc_attr(get_bloginfo('name')),$res['content']);
				$res['content'] = str_replace('{form_action}',$_SERVER['REQUEST_URI'],$res['content']);
				$res['content'] = str_replace('{powered_by_mindbody}',$this->mb_powered(true),$res['content']);
				$res['content'] = str_replace('{submit_button}',get_submit_button(__("Complete Registration")),$res['content']);
				$res['content'] = $this->add_pagelist($res['content']);
				echo $res['content'];
			} catch (Exception $e) {
				echo __("MB Spirit is Offline",$this->plugin_id);
			}
		}

		/**
		 * Retrieve options page from API and render settings
		 *
		 * @since 1.0.0
		 *
		 */
		public function options_page() {
			if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
				die(__('Forbidden', $this->plugin_id));
			}

			$this->opts = get_option($this->opt_key);
			$this->load_settings();
			preg_match_all('~\{page_list\:([^:}]+)(?:\:([^:}]+))?\}~',$this->options_form,$pagelists,PREG_SET_ORDER);
			foreach ($pagelists as $pl) {
				$v = $this->opts[$pl[1]];
				$f = sprintf('%s[%s]',$this->opt_key,$pl[1]);
				$id = $pl[1];
				if (!empty($pl[2])) {
					$v = isset($v[$pl[2]]) ? $v[$pl[2]] : '';
					$f .= '['.$pl[2].']';
					$id .= '-' . $pl[2];
				}
				$input = wp_dropdown_pages(array('selected'=>$v,'echo'=>false,'name'=>$f,'id'=>$id,'show_option_none'=>__('Select Page', $this->plugin_id)));
				$this->options_form = str_replace($pl[0],$input,$this->options_form);
			}
			$this->options_form = str_replace('{mb_spirit_icon}',plugins_url( '/style/img/mb-spirit-icon-32.png', __FILE__ ),$this->options_form);
			$this->options_form = str_replace('{form_action}',$_SERVER['REQUEST_URI'],$this->options_form);
			$this->options_form = str_replace('{powered_by_mindbody}',$this->mb_powered(true),$this->options_form);
			$this->options_form = str_replace('{submit_button}',get_submit_button(__("Save Settings", $this->plugin_id)),$this->options_form);
			echo $this->options_form;
		}
		
		private function add_pagelist($content,$selected = array()) {
			preg_match_all('~\{page_list\:([^:}]+)(?:\:([^:}]+))?\}~',$content,$pagelists,PREG_SET_ORDER);
			foreach ($pagelists as $pl) {
				list($fullMatch,$field,$elem) = $pl;
				$id = $field;
				if (!empty($elem)) {
					$field .= '['.$elem.']';
					$id .= '-' . $elem;
				}
				$input = wp_dropdown_pages(array('selected'=>$selected,'echo'=>false,'name'=>$field,'id'=>$id,'show_option_none'=>__('Select Page', $this->plugin_id)));
				$content = str_replace($fullMatch,$input,$content);
			}
			return $content;
		}
		
		/**
		 * Add a MINDBODY Powered By icon to pages
		 *
		 * @since 1.0.0
		 *
		 */
		public function mb_powered($return = false) {
			$img = '<div class="clearfix margin-top-20"><img src="' . plugins_url( 'style/img/powered-by-mindbody.png', __FILE__ ) . '" height="20"></div>';
			if ($return) { return $img; } else { echo $img; }
		}

		/**
		 * Display status notices in the WP Admin if present
		 *
		 * @since 1.0.0
		 *
		 */
		public function show_notices() {
			$screen = get_current_screen();
			if ($screen->id == 'mb-spirit_page_mb_spirit_register') { return; }

			$dismissed = !empty($this->opts['dismissed_notices']) ? (array)$this->opts['dismissed_notices'] : array();
			foreach ($this->notices as $n) {
				if (!empty($n['uid']) && in_array($n['uid'],$dismissed)) {
					continue;
				}
				printf(
					'<div id="%s"%s class="notice notice-%s fade is-dismissible"><p><strong>%s</strong><br>%s</p></div>'
					,$n['id']
					,!empty($n['uid']) ? sprintf(' data-mbs-uid="%s"',$n['uid']) : ''
					,!empty($n['type']) ? $n['type'] : 'success'
					,$n['title']
					,$n['desc']
					,__("Dismiss this notice.")
				);
			}
		}
		
		/**
		 * Save WP Admin notice as dismissed
		 *
		 * @since 1.0.9
		 *
		 */
		public function dismiss_notice() {
			$res = array('status'=>'ERROR');
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX && is_admin() && !empty($_GET['uid'])) {
				$this->opts = get_option($this->opt_key);
				if (empty($this->opts['dismissed_notices'])) {
					$this->opts['dismissed_notices'] = array();
				}
				$this->opts['dismissed_notices'][] = $_GET['uid'];
				update_option($this->opt_key, $this->opts);
				$res = array('status'=>'OK');
			}
			echo json_encode($res);
			exit;
		}
		
		/**
		 * Handle calls to the API service, converting the result from JSON to PHP arrays
		 *
		 * @since 1.0.0
		 *
		 * @param string    $endpoint    The API endpoint
		 * @param string    $action      The API action if required
		 * @param array     $params      Parameters for the call
		 * @param string    $method      The method for the call 
		 * @param bool      $decodeJSON  Decode the response as JSON data 
		 * @return mixed    Either the JSON data as a PHP array or the raw response as a string
		 */
		public function apiCall($endpoint, $action = 'list', $params = array(), $method = 'GET', $decodeJSON = true) {
			$url = sprintf(
			 '%s/%s/%s',
				self::API_BASE,
				$endpoint,
				$action
			);
			if (!is_array($params)) {
				$params = array();
			}
			$params = apply_filters( 'mb_spirit_api_request', $params, $endpoint, $action, $method );
			$params['token'] = $this->opts['api_key'];
			$params['secret'] = $this->opts['api_secret'];
			$params['lang'] = $this->lang;
			$ch = curl_init();
			//==============================================================
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, "MB Spirit For WordPress v. " . MB_SPIRIT_VERSION);
			if ($method == 'GET') {
				$url .= !empty($params) ? '?' . http_build_query($params) : '';
			} else {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
			}
			curl_setopt($ch, CURLOPT_URL, $url);
			$headers = array();
			$headers[] = 'Cache-Control: ' . ( isset($_SERVER['HTTP_CACHE_CONTROL']) ? $_SERVER['HTTP_CACHE_CONTROL'] : 'max-age=3600' );
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, false);
			//=============================================================
			try {
				$res = curl_exec($ch);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
			if (curl_getinfo($ch,CURLINFO_HTTP_CODE) != 200) {
				throw new Exception("Request failed with status: ".curl_getinfo($ch,CURLINFO_HTTP_CODE));
			}
			$res = apply_filters( 'mb_spirit_api_response_raw', $res, $endpoint, $action, $method );
			if ($decodeJSON) {
				$out = json_decode($res,true);
				if (empty($out) || !is_array($out)) {
					throw new Exception("Invalid JSON: ".$res);
				}
				$out = apply_filters( 'mb_spirit_api_response', $out, $endpoint, $action, $method );
			} else {
				$out = $res;
			}
			return $out;
		}
		
		public function bool($value) {
			return filter_var($value,FILTER_VALIDATE_BOOLEAN);
		}

		public function rx_esc($value) {
			$value = str_replace('\\','\\\\',$value);
			$value = str_replace('$','\\$',$value);
			return $value;
		}

	}
}

$MB_Spirit = new mb_spirit();


if ( ! class_exists( 'mb_spirit_widget' ) ) {

	class mb_spirit_widget extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'mb_spirit_widget',
				'description' => "Add MB Spirit Widgets into your site"
			);
			$this->WP_Widget(
				'mb_spirit_widget',
				'MB Spirit Widgets',
				$widget_ops
			);
		}

		public function widget($args, $instance) { // widget sidebar output
			global $post;
			global $MB_Spirit;
			if ($MB_Spirit->APIReady == false) { return; }
			if (!is_singular()) {
				return;
			}
			$strip_atts = array('item_container');
			foreach ($strip_atts as $k) {
				$instance['widget'] = preg_replace('~\s+'.$k.'\s*=\s*"[^"]*"~','',$instance['widget']);
			}
			$instance['widget'] = str_replace('[mb-spirit','[mb-spirit no_single="true"',$instance['widget']);
			$content = do_shortcode($instance['widget']);
			if (!empty($content)) {
				// Change title if defined
				extract($args);
				if(!empty($instance['title'])) {
					echo $before_widget . 
					$before_title . $instance['title'] . $after_title .
					$content . $after_widget;
				} else {
					echo $before_widget . $content . $after_widget;
				}
			}
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			global $MB_Spirit;
			$MB_Spirit->load_settings();
			$MB_Spirit->init_thickbox('widget_list');
			$form = $MB_Spirit->widget_form;
			preg_match_all('~\{([^:}]+)\:([^}]+)\}~',$form,$replacements,PREG_SET_ORDER);
			foreach ($replacements as $r) {
				if ($r[1] == 'id') {
					$form = str_replace($r[0],$this->get_field_id($r[2]),$form);
				} elseif ($r[1] == 'name') {
					$form = str_replace($r[0],$this->get_field_name($r[2]),$form);
				} elseif ($r[1] == 'value') {
					$form = str_replace($r[0],esc_attr($instance[$r[2]]),$form);
				} elseif ($r[1] == 'enc') {
					$form = str_replace($r[0],esc_attr(rawurlencode($instance[$r[2]])),$form);
				} elseif ($r[1] == 'encjs') {
					$form = str_replace($r[0],esc_attr(rawurlencode(json_encode($instance[$r[2]]))),$form);
				} elseif ($r[1] == 'displayif') {
					$form = str_replace($r[0],!empty($instance[$r[2]])?'':' style="display: none;"',$form);
				} elseif ($r[1] == 'code_info') {
					$display = is_array($instance['code_info'][$r[2]]) ? join('<br>',$instance['code_info'][$r[2]]) : $instance['code_info'][$r[2]];
					$form = str_replace($r[0],$display,$form);
				} else {
					$form = str_replace($r[0],print_r($r,1),$form);
				}
			}
			$form = str_replace('{exists}',!empty($instance)?'':' style="display: none;"',$form);
			$form = str_replace('{mb_spirit_icon}',plugins_url( '/style/img/mb-spirit-icon-32.png', __FILE__ ),$form);
			$form = str_replace('{powered_by_mindbody}',$MB_Spirit->mb_powered(true),$form);
			echo $form;
		}

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new, $old ) {
			global $MB_Spirit;
			if ($MB_Spirit->APIReady == false) { return; }
			// processes widget options to be saved
			$instance = array();
			$instance['title'] = !empty($new['title']) ? strip_tags($new['title']) : '';
			$instance['widget'] = rawurldecode($new['widget']);
			$instance['code_info'] = json_decode(rawurldecode($new['code_info']),true);
			return $instance;
		}
	}
	function wp_register_mb_spirit_widget() {
		return register_widget("mb_spirit_widget");
	}
	add_action('widgets_init' , 'wp_register_mb_spirit_widget');
}


