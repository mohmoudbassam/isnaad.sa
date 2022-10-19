<?php

/**
 * Customize Color Control Class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
 */
class MHCustomizer_Customize_Color_Control extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'color';

	/**
	 * @access public
	 * @var array
	 */
	public $statuses;
	public $description = '';
	public $subtitle = '';
	public $framework_var = '';

	/**
	 * Constructor.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->statuses = array( '' => esc_html__( 'Default', 'mharty' ) );
		parent::__construct( $manager, $id, $args );
		$this->framework_var = ( isset( $args['framework_var'] ) && ! is_null( $args['framework_var'] ) ) ? $args['framework_var'] : null;
	}

	/**
	 * Enqueue scripts/styles for the color picker.
	 *
	 * @since 3.4.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['statuses'] = $this->statuses;
	}

	/**
	 * Render the control's content.
	 *
	 * @since 3.4.0
	 */
	public function render_content() {
		$this_default = $this->setting->default;
		$default_attr = '';
		$this_id      = $this->id;

		if ( $this_default ) {
			if ( false === strpos( $this_default, '#' ) )
				$this_default = '#' . $this_default;
			$default_attr = ' data-default-color="' . esc_attr( $this_default ) . '"';
		}

		$setting_attr  = ' data-customize-setting-link="' . esc_attr( $this_id ) . '"';
		$framework_var = ' data-framework-var="' . $this->framework_var . '"';

		// The input's value gets set by JS. Don't fill it.
		?>
		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && ! empty( $this->description ) ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>
			<div class="customize-control-content">
				<input class="color-picker-hex mh_customizer-color-picker" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value' ); ?>"<?php echo $default_attr; ?> <?php echo $setting_attr; ?> <?php echo $framework_var; ?>/>
			</div>
		</label>
		<?php

	}
}
///////////////////////////////////////////////////////////
class MHCustomizer_Customize_Checkbox_Control extends WP_Customize_Control {

	public $type = 'checkbox';
	public $description = '';
	public $subtitle = '';

	public function render_content() { ?>
		<label class="customizer-checkbox">
			<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" id="<?php echo $this->id . esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
			<strong><?php echo esc_html( $this->label ); ?></strong>
			<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
				<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>
		</label>
		<?php
	}
}
///////////////////////////////////////////////////////////
/**
 * Customize Image Control Class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
 */
class MHCustomizer_Customize_Image_Control extends WP_Customize_Upload_Control {
	public $type = 'image';
	public $get_url;
	public $statuses;
	public $extensions = array( 'jpg', 'jpeg', 'gif', 'png' );
	public $description = '';
	public $subtitle = '';

	protected $tabs = array();

	/**
	 * Constructor.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Upload_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $manager, $id, $args ) {
		$this->statuses = array( '' => esc_html__( 'No Image', 'mharty' ) );

		parent::__construct( $manager, $id, $args );

		$this->add_tab( 'upload-new', esc_html__( 'Upload New', 'mharty' ), array( $this, 'tab_upload_new' ) );
		$this->add_tab( 'uploaded',   esc_html__( 'Uploaded', 'mharty' ),   array( $this, 'tab_uploaded' ) );

		// Early priority to occur before $this->manager->prepare_controls();
		add_action( 'customize_controls_init', array( $this, 'prepare_control' ), 5 );
	}

	/**
	 * Prepares the control.
	 *
	 * If no tabs exist, removes the control from the manager.
	 *
	 * @since 3.4.2
	 */
	public function prepare_control() {
		if ( ! $this->tabs )
			$this->manager->remove_control( $this->id );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Upload_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['statuses'] = $this->statuses;
	}

	/**
	 * Render the control's content.
	 *
	 * @since 3.4.0
	 */
	public function render_content() {
		$src = $this->value();
		if ( isset( $this->get_url ) )
			$src = call_user_func( $this->get_url, $src );

		?>
		<div class="customize-image-picker">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>

			<div class="customize-control-content">
				<div class="dropdown preview-thumbnail" tabindex="0">
					<div class="dropdown-content">
						<?php if ( empty( $src ) ): ?>
							<img style="display:none;" />
						<?php else: ?>
							<img src="<?php echo esc_url( set_url_scheme( $src ) ); ?>" />
						<?php endif; ?>
						<div class="dropdown-status"></div>
					</div>
					<div class="dropdown-arrow"></div>
				</div>
			</div>

			<div class="library">
				<ul>
					<?php foreach ( $this->tabs as $id => $tab ): ?>
						<li data-customize-tab='<?php echo esc_attr( $id ); ?>' tabindex='0'>
							<?php echo esc_html( $tab['label'] ); ?>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php foreach ( $this->tabs as $id => $tab ): ?>
					<div class="library-content" data-customize-tab='<?php echo esc_attr( $id ); ?>'>
						<?php call_user_func( $tab['callback'] ); ?>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="actions">
				<a href="#" class="remove"><?php esc_html_e( 'Remove Image', 'mharty' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Add a tab to the control.
	 *
	 * @since 3.4.0
	 *
	 * @param string $id
	 * @param string $label
	 * @param mixed $callback
	 */
	public function add_tab( $id, $label, $callback ) {
		$this->tabs[ $id ] = array(
			'label'    => $label,
			'callback' => $callback,
		);
	}

	/**
	 * Remove a tab from the control.
	 *
	 * @since 3.4.0
	 *
	 * @param string $id
	 */
	public function remove_tab( $id ) {
		unset( $this->tabs[ $id ] );
	}

	/**
	 * @since 3.4.0
	 */
	public function tab_upload_new() {
		if ( ! _device_can_upload() ) {
			echo '<p>' . mh_wp_kses( sprintf( __('The web browser on your device cannot be used to upload files. You may be able to use the <a href="%s">native app for your device</a> instead.'), 'https://wordpress.org/mobile/' ) ) . '</p>';
		} else {
			?>
			<div class="upload-dropzone">
				<?php mh_wp_kses( __('Drop a file here or <a href="#" class="upload">select a file</a>.') ); ?>
			</div>
			<div class="upload-fallback">
				<span class="button-secondary"><?php esc_html_e( 'Select File', 'mharty' ); ?></span>
			</div>
			<?php
		}
	}

	/**
	 * @since 3.4.0
	 */
	public function tab_uploaded() {
		?>
		<div class="uploaded-target"></div>
		<?php
	}

	/**
	 * @since 3.4.0
	 *
	 * @param string $url
	 * @param string $thumbnail_url
	 */
	public function print_tab_image( $url, $thumbnail_url = null ) {
		$url = set_url_scheme( $url );
		$thumbnail_url = ( $thumbnail_url ) ? set_url_scheme( $thumbnail_url ) : $url;
		?>
		<a href="#" class="thumbnail" data-customize-image-value="<?php echo esc_url( $url ); ?>">
			<img src="<?php echo esc_url( $thumbnail_url ); ?>" />
		</a>
		<?php
	}
}
///////////////////////////////////////////////////
class MHCustomizer_Customize_Radio_Control extends WP_Customize_Control {

	public $type = 'radio';
	public $description = '';
	public $mode = 'radio';
	public $subtitle = '';

	public function enqueue() {

		if ( 'buttonset' == $this->mode || 'image' == $this->mode ) {
			wp_enqueue_script( 'jquery-ui-button' );
		}

	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;

		?>
		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
			<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
				<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
		</span>

		<div id="input_<?php echo $this->id; ?>" class="<?php echo $this->mode; ?>">
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>
			<?php

			// JqueryUI Button Sets
			if ( 'buttonset' == $this->mode ) {

				foreach ( $this->choices as $value => $label ) : ?>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo $this->id . $value; ?>">
							<?php echo esc_html( $label ); ?>
						</label>
					</input>
					<?php
				endforeach;

			// Image radios.
			} elseif ( 'image' == $this->mode ) {

				foreach ( $this->choices as $value => $label ) : ?>
					<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo $this->id . $value; ?>">
							<img src="<?php echo esc_html( $label ); ?>">
						</label>
					</input>
					<?php
				endforeach;

			// Normal radios
			} else {

				foreach ( $this->choices as $value => $label ) :
					?>
					<label class="customizer-radio">
						<input class="mh_customizer-radio" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<?php echo esc_html( $label ); ?><br/>
					</label>
					<?php
				endforeach;

			}
			?>
		</div>
		<?php if ( 'buttonset' == $this->mode || 'image' == $this->mode ) { ?>
			<script>
			jQuery(document).ready(function($) {
				$( '[id="input_<?php echo $this->id; ?>"]' ).buttonset();
			});
			</script>
		<?php }

	}
}
///////////////////////////////////////////////////
class MHCustomizer_Select_Control extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'select';
	public $description = '';
	public $subtitle = '';

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		} ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && ! empty( $this->description ) ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>
            <select <?php $this->link(); ?>>
				<?php
				foreach ( $this->choices as $value => $label ) {
					if ($value == 'Arabic' || $value == 'Latin' || $value == 'Stack'){
						echo '<optgroup label="' . esc_attr( $value ) . '">';
					}elseif ($value == 'End Arabic' || $value == 'End Latin' || $value == 'End Stack'){
						echo '</optgroup>';
					}else{
				echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
					}
				} ?>
			</select>
          	</label>
		<?php

	}
}
//////////////////////////////////////////////////////////////
class MHCustomizer_Customize_Sliderui_Control extends WP_Customize_Control {

	public $type = 'slider';
	public $description = '';
	public $subtitle = '';

	public function enqueue() {

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-slider' );

	}

	public function render_content() { ?>
		<label>

			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>

			<input type="text" class="mh_customizer-slider" id="input_<?php echo $this->id; ?>" disabled value="<?php echo $this->value(); ?>" <?php $this->link(); ?>/>

		</label>

		<div id="slider_<?php echo $this->id; ?>" class="ss-slider"></div>
		<script>
		jQuery(document).ready(function($) {
			$( '[id="slider_<?php echo $this->id; ?>"]' ).slider({
					value : <?php echo $this->value(); ?>,
					min   : <?php echo $this->choices['min']; ?>,
					max   : <?php echo $this->choices['max']; ?>,
					step  : <?php echo $this->choices['step']; ?>,
					slide : function( event, ui ) { $( '[id="input_<?php echo $this->id; ?>"]' ).val(ui.value).keyup(); }
			});
			$( '[id="input_<?php echo $this->id; ?>"]' ).val( $( '[id="slider_<?php echo $this->id; ?>"]' ).slider( "value" ) );
		});
		</script>
		<?php

	}
}
/////////////////////////////////////////////////////////////////////
class MHCustomizer_Customize_Text_Control extends WP_Customize_Control {

	public $type = 'text';
	public $description = '';
	public $subtitle = '';

	public function render_content() { ?>

		<label class="customizer-text">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>

				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>

			<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		</label>
		<?php

	}
}
///////////////////////////////////////////////////
class MHCustomizer_Customize_Textarea_Control extends WP_Customize_Control {

	public $type = 'textarea';
	public $description = '';
	public $subtitle = '';

	public function render_content() { ?>
		<label class="customizer-textarea">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>

			<textarea class="of-input" rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php

	}
}
/////////////////////////////////////////////////////
class MHCustomizer_Customize_Range_Control extends WP_Customize_Control {
	public $type = 'range';
	public $description = '';
	public $subtitle = '';

	public function render_content() {
	?>
	<label class="customizer-range">
        <span class="customize-control-title">
            <?php echo esc_html( $this->label ); ?>
            <?php if ( isset( $this->description ) && '' != $this->description ) { ?>
                <a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
            <?php } ?>
        </span>
        <?php if ( '' != $this->subtitle ) : ?>
            <div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
        <?php endif; ?>
        
		<input type="<?php echo esc_attr( $this->type ); ?>" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> data-reset_value="<?php echo esc_attr( $this->setting->default ); ?>" />
		<input type="number" <?php $this->input_attrs(); ?> class="mh-customizer-range-input" value="<?php echo esc_attr( $this->value() ); ?>" />
		<span class="mh_customizer_reset_slider"></span>
	</label>
	<?php
	}
}
/**
 * Customize Upload Control Class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
 */
class MHCustomizer_Customize_Upload_Control extends WP_Customize_Control {
	public $type    = 'upload';
	public $removed = '';
	public $context;
	public $extensions = array();
	public $description = '';
	public $subtitle = '';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 3.4.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'wp-plupload' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['removed'] = $this->removed;

		if ( $this->context )
			$this->json['context'] = $this->context;

		if ( $this->extensions )
			$this->json['extensions'] = implode( ',', $this->extensions );
	}

	/**
	 * Render the control's content.
	 *
	 * @since 3.4.0
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>

			<div>
				<a href="#" class="button-secondary upload"><?php esc_html_e( 'Upload', 'mharty' ); ?></a>
				<a href="#" class="remove"><?php esc_html_e( 'Remove', 'mharty' ); ?></a>
			</div>
		</label>
		<?php

	}
}