<?php 
/**
 * 
 */
class MoomooMetaBox 
{
	
	function __construct()
	{
		// Put this into your __construct function
		add_action('add_meta_boxes', array($this, 'add_moomoo_video_url_metabox'));
		add_action('save_post', array($this, 'save_moomoo_video_url_metabox_data'));
	}
	public function add_moomoo_video_url_metabox() {
		add_meta_box('moomoo_video_url', __('Video Url', 'domain-name'), array($this, 'moomoo_video_url_metabox_callback'), array('post','page'), 'side', 'high');
	}

	public function moomoo_video_url_metabox_callback($post) { 
		
		$value = get_post_meta( $post->ID, 'video_url', true );
		?>
		<label>Enter Video Url:</label>
		<input type="text" name="moomoo_video_url[video_url]" value="<?php echo $value;?>" style="width: 100%" />
		<?php
	}

	public function save_moomoo_video_url_metabox_data($post_id) {
		if (!isset($_POST['moomoo_video_url'])) {
			return $post_id;
		}
		foreach ($_POST['moomoo_video_url'] as $key => $field) {
			update_post_meta($post_id, $key, $field);
		}
	}
}
new MoomooMetaBox();
 ?>