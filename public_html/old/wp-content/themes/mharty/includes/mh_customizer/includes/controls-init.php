<?php

/**
 * Build the controls
 */
function mh_customizer_customizer_controls( $wp_customize ) {

	$controls = apply_filters( 'mh_customizer/controls', array() );

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {

			if ( 'background' == $control['type'] ) {

				$wp_customize->add_setting( $control['setting'] . '_color', array(
					'default'    => $control['default']['color'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_image', array(
					'default'    => $control['default']['image'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_repeat', array(
					'default'    => $control['default']['repeat'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_size', array(
					'default'    => $control['default']['size'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_attach', array(
					'default'    => $control['default']['attach'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_position', array(
					'default'    => $control['default']['position'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				if ( false != $control['default']['opacity'] ) {

					$wp_customize->add_setting( $control['setting'] . '_opacity', array(
						'default'    => $control['default']['opacity'],
						'type'       => 'theme_mod',
						'capability' => 'edit_theme_options'
					) );

				}
			} else {

				// Add settings
				$wp_customize->add_setting( $control['setting'], array(
					'default'    => isset( $control['default'] ) ? $control['default'] : '',
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

			}

			// Checkbox controls
			if ( 'checkbox' == $control['type'] ) {

				$wp_customize->add_control( new MHCustomizer_Customize_Checkbox_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);
			// Color Controls
			} elseif ( 'color' == $control['type'] ) {

				$wp_customize->add_control( new MHCustomizer_Customize_Color_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => isset( $control['priority'] ) ? $control['priority'] : '',
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);
				
			// Image Controls
			} elseif ( 'image' == $control['type'] ) {

				$wp_customize->add_control( new MHCustomizer_Customize_Image_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);

			// Radio Controls
			} elseif ( 'radio' == $control['type'] ) {

				$wp_customize->add_control( new MHCustomizer_Customize_Radio_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'mode'        => isset( $control['mode'] ) ? $control['mode'] : 'radio', // Can be 'radio', 'image' or 'buttonset'.
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);

			// Select Controls
			} elseif ( 'select' == $control['type'] ) {

				$wp_customize->add_control( new MHCustomizer_Select_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);
				
			// Text Controls
			} elseif ( 'text' == $control['type'] ) {

				$wp_customize->add_control( new MHCustomizer_Customize_Text_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);

			// Text Controls
			} elseif ( 'textarea' == $control['type'] ) {

				$wp_customize->add_control( new MHCustomizer_Customize_Textarea_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);
			
			// Range Controls
			} elseif ( 'range' == $control['type'] ) {
				
				$wp_customize->add_control( new MHCustomizer_Customize_Range_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'input_attrs' => $control['input_attrs'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					) )
				);
			}
		}
	}
}
add_action( 'customize_register', 'mh_customizer_customizer_controls', 99 );
