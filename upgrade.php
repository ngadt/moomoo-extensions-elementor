<?php

defined( 'ABSPATH' ) || exit;


if( ! class_exists( 'moomooUpgradePlugin' ) ) {

	class moomooUpgradePlugin{

		
		public $version;
		public $cache_key;
		public $cache_allowed;

		public function __construct() {

			$plugin_data = get_plugin_data( plugin_dir_path(__FILE__).'/'.MM_PLUGIN_NAME_MAIN_FILE);	
			$this->current_version = $plugin_data['Version'];
			$this->cache_key = 'moomoo_upgrade';
			$this->cache_allowed = false;

			add_filter( 'plugins_api', array( $this, 'info' ), 20, 3 );
			add_filter( 'site_transient_update_plugins', array( $this, 'update' ) );
			add_filter( 'transient_update_plugins', array( $this, 'update' ) );			
			add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );

		}

		public function request(){

			$remote = get_transient( $this->cache_key );

			if( false === $remote || ! $this->cache_allowed ) {

				$remote = wp_remote_get(
					'https://raw.githubusercontent.com/ngadt/moomoo-extensions-elementor/master/info.json',
					array(
						'timeout' => 10,
						'headers' => array(
							'Accept' => 'application/json'
						)
					)
				);


				if(
					is_wp_error( $remote )
					|| 200 !== wp_remote_retrieve_response_code( $remote )
					|| empty( wp_remote_retrieve_body( $remote ) )
				) {
					return false;
				}

				set_transient( $this->cache_key, $remote, DAY_IN_SECONDS );

			}

			$remote = json_decode( wp_remote_retrieve_body( $remote ) );

			return $remote;

		}


		function info( $res, $action, $args ) {

			// print_r( $action );
			// print_r( $args );

			// do nothing if you're not getting plugin information right now
			if( 'plugin_information' !== $action ) {
				return false;
			}

			// do nothing if it is not our plugin
			if( MM_PLUGIN_NAME !== $args->slug ) {
				return false;
			}

			// get updates
			$remote = $this->request();

			if( ! $remote ) {
				return false;
			}

			$res = new stdClass();

			$res->name = $remote->name;
			$res->slug = $remote->slug;
			$res->version = $remote->new_version;
			$res->requires_wordpress = $remote->requires_wordpress;			
			$res->download_link = $remote->download_url;
			$res->trunk = $remote->download_url;
			$res->requires_php = $remote->requires_php;
			$res->last_updated = $remote->last_updated;

			$res->sections = array(
				'description' => $remote->sections->description,
				'installation' => $remote->sections->installation,
				'changelog' => $remote->sections->changelog
			);

			if( ! empty( $remote->banners ) ) {
				$res->banners = array(
					'low' => $remote->banners->low,
					'high' => $remote->banners->high
				);
			}

			return $res;

		}

		public function update( $transient ) {

			if ( empty($transient->checked ) ) {
				return $transient;
			}

			$remote = $this->request();
			
			if(
				$remote
				&& version_compare( $this->current_version, $remote->new_version, '<' )
				&& version_compare( $remote->requires_wordpress, get_bloginfo( 'version' ), '<' )
				&& version_compare( $remote->requires_php, PHP_VERSION, '<' )
			) {
				$res = new stdClass();
				$res->slug = MM_PLUGIN_NAME;
				$res->plugin = MM_PLUGIN_NAME.'/'.MM_PLUGIN_NAME_MAIN_FILE; 
				$res->new_version = $remote->version;				
				$res->package = $remote->download_url;
				$transient->response[ $res->plugin ] = $res;

	    }

			return $transient;

		}

		public function purge(){

			if (
				$this->cache_allowed
				&& 'update' === $options['action']
				&& 'plugin' === $options[ 'type' ]
			) {
				// just clean the cache when new plugin version is installed
				delete_transient( $this->cache_key );
			}

		}


	}

	new moomooUpgradePlugin();

}
