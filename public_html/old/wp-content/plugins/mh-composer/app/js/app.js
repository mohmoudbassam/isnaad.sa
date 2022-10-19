var MH_PageComposer = MH_PageComposer || {};

window.wp = window.wp || {};

(function ($) {
    var mhc_loading_attempts = 0;
    
	for (var i = 0; i < Math.ceil( mhc_options.mh_composer_modules_count/mhc_options.mh_composer_templates_amount ); i++){
		mhc_append_templates( i*mhc_options.mh_composer_templates_amount );
	};

	function mhc_append_templates( start_from ){
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: mhc_options.ajaxurl,
			data: {
				action : 'mhc_get_app_templates',
				mh_post_type : mhc_options.post_type,
				mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
				mh_templates_start_from : start_from
			},
			success: function( data ){
				//append retrieved templates to body
				$( 'body' ).append( data.templates );
			}
		});
	}
    
	$( document ).ready(function(){

		// Explicitly define ERB-style template delimiters to prevent
		// template delimiters being overwritten by 3rd party plugin
		_.templateSettings = {
			evaluate   : /<%([\s\S]+?)%>/g,
			interpolate: /<%=([\s\S]+?)%>/g,
			escape     : /<%-([\s\S]+?)%>/g
		};

		// Models

		MH_PageComposer.Module = Backbone.Model.extend({

			defaults: {
				type : 'element'
			}

		});

		MH_PageComposer.SavedTemplate = Backbone.Model.extend({

			defaults: {
				title : 'template',
				ID : 0,
				shortcode : '',
				is_shared : 'false',
				layout_type : '',
				module_type : '',
				categories : []
			}

		});

		MH_PageComposer.History = Backbone.Model.extend({

			defaults : {
				timestamp : _.now(),
				shortcode : '',
				current_active_history : false,
				verb : 'did',
				noun : 'something'
			},

			max_history_limit : 100,

			validate : function( attributes, options ){
				var histories_count = options.collection.length,
					active_history_model = options.collection.findWhere({ current_active_history : true }),
					shortcode            = attributes.shortcode,
					last_model           = _.isUndefined( active_history_model ) ? options.collection.at( ( options.collection.length - 1 ) ) : active_history_model,
					last_shortcode       = _.isUndefined( last_model ) ? false : last_model.get( 'shortcode' ),
					previous_active_histories;

				if ( shortcode === last_shortcode ){
					return 'duplicate';
				}

				// Turn history tracking off
				MH_PageComposer_App.enable_history = false;

				// Limit number of history limit
				var histories_count = options.collection.models.length,
					remove_limit = histories_count - ( this.max_history_limit - 1 ),
					ranges,
					deleted_model;

				// Some models are need to be removed
				if ( remove_limit > 0 ){
					// Loop and shift (remove first model in collection) n-times
					for (var i = 1; i <= remove_limit; i++){
						options.collection.shift();
					};
				}
			}

		});

		// helper module
		MH_PageComposer.Layout = Backbone.Model.extend({

			defaults: {
				moduleNumber : 0,
				forceRemove : false,
				modules : $.parseJSON( mhc_options.mh_composer_modules ),
				views : [
				]
			},

			initialize : function(){
				// Single and double quotes are replaced with %% in mh_composer_modules
				// to avoid js conflicts.
				// Replace them with appropriate signs.
				_.each( this.get( 'modules' ), function( module ){
					module['title'] = module['title'].replace( /%%/g, '"' );
					module['title'] = module['title'].replace( /\|\|/g, "'" );
				});
			},

			addView : function( module_cid, view ){
				var views = this.get( 'views' );

				views[module_cid] = view;
				this.set({ 'views' : views });
			},

			getView : function( cid ){
				return this.get( 'views' )[cid];
			},

			getChildViews : function( parent_id ){
				var views = this.get( 'views' ),
					child_views = {};

				_.each( views, function( view, key ){
					if ( typeof view !== 'undefined' && view['model']['attributes']['parent'] === parent_id )
						child_views[key] = view;
				});

				return child_views;
			},

			getChildrenViews : function( parent_id ){
				var this_el = this,
					views = this_el.get( 'views' ),
					child_views = {},
					grand_children;

				_.each( views, function( view, key ){
					if ( typeof view !== 'undefined' && view['model']['attributes']['parent'] === parent_id ) {
						grand_children = this_el.getChildrenViews( view['model']['attributes']['cid'] );

						if ( ! _.isEmpty( grand_children ) ){
							_.extend( child_views, grand_children );
						}

						child_views[key] = view;
					}

				});

				return child_views;
			},

			getParentViews : function( parent_cid ){
				var parent_view = this.getView( parent_cid ),
					parent_views = {};

				while( ! _.isUndefined( parent_view ) ){

					parent_views[parent_view['model']['attributes']['cid']] = parent_view;
					parent_view = this.getView( parent_view['model']['attributes']['parent'] );
				}

				return parent_views;
			},

			getSectionView : function( parent_cid ){
				var views = this.getParentViews( parent_cid ),
					section_view;

				section_view = _.filter( views, function( item ){
					if ( item.model.attributes.type === "section" ){
						return true;
					} else {
						return false;
					}
				});

				if ( _.isUndefined( section_view[0] ) ){
					return false;
				} else {
					return section_view[0];
				}
			},

			setNewParentID : function( cid, new_parent_id ){
				var views = this.get( 'views' );

				views[cid]['model']['attributes']['parent'] = new_parent_id;

				this.set({ 'views' : views });
			},

			removeView : function( cid ){
				var views = this.get( 'views' ),
					new_views = {};

				_.each( views, function( value, key ){
					if ( key != cid )
						new_views[key] = value;
				});

				this.set({ 'views' : new_views });
			},

			generateNewId : function(){
				var moduleNumber = this.get( 'moduleNumber' ) + 1;

				this.set({ 'moduleNumber' : moduleNumber });

				return moduleNumber;
			},

			generateTemplateName : function( name ){
				var default_elements = [ 'row', 'row_inner', 'section', 'column', 'column_inner'];

				if ( -1 !== $.inArray( name, default_elements ) ){
					name = 'mhc_' + name;
				}

				return '#mh-composer-' + name + '-module-template';
			},

			getModuleOptionsNames : function( module_type ){
				var modules = this.get('modules');

				return this.addAdminLabel( _.findWhere( modules, { label : module_type })['options'] );
			},

			getNumberOf : function( element_name, module_cid ){
				var views = this.get( 'views' ),
					num = 0;

				_.each( views, function( view ) {
					if ( typeof view !== 'undefined' ) {
						var type = view['model']['attributes']['type'];

						if ( view['model']['attributes']['parent'] === module_cid && ( type === element_name || type === ( element_name + '_inner' ) ) )
							num++;
					}
				} );

				return num;
			},

			getNumberOfModules : function( module_name ){
				var views = this.get( 'views' ),
					num = 0;

				_.each( views, function( view ){
					if ( typeof view !== 'undefined' ) {
						if ( view['model']['attributes']['type'] === module_name )
							num++;
					}
				});

				return num;
			},

			getTitleByShortcodeTag : function ( tag ){
				var modules = this.get('modules');

				return _.findWhere( modules, { label : tag })['title'];
			},

			isModuleFullwidth : function ( module_type ){
				var modules = this.get('modules');

				return 'on' === _.findWhere( modules, { label : module_type })['fullwidth_only'] ? true : false;
			},

			isChildrenLocked : function ( module_cid ){
				var children_views = this.getChildrenViews( module_cid ),
					children_locked = false;

				_.each( children_views, function( child ){
					if ( child.model.get( 'mhc_locked' ) === 'on' || child.model.get( 'mhc_parent_locked' ) === 'on' ){
						children_locked = true;
					}
				});

				return children_locked;
			},

			addAdminLabel : function ( optionsNames ){
				return _.union( optionsNames, ['admin_label'] );
			},
            
            removeSharedAttributes : function ( view, keep_attributes ) {
                var this_class                 = this,
                    keep_attributes            = _.isUndefined( keep_attributes ) ? false : keep_attributes,
                    shared_item_cid            = _.isUndefined( view.model.attributes.shared_parent_cid ) ? view.model.attributes.cid : view.model.attributes.shared_parent_cid,
                    shared_item_view           = this.getView( shared_item_cid );
                    shared_item_children_views = this.getChildrenViews( shared_item_cid );

                // Modify shared item's attributes
                if ( this.is_shared( shared_item_view.model ) ) {
                    if ( keep_attributes ) {
                        shared_item_view.model.set( 'mhc_temp_shared_module', shared_item_view.model.get( 'mhc_shared_module' ) );
                    }

                    shared_item_view.model.unset( 'mhc_shared_module' );
                }

                // Modify shared item children's attributes
                _.each( shared_item_children_views, function( shared_item_children_view ) {
                    if ( this_class.is_shared_children( shared_item_children_view.model ) ) {
                        if ( keep_attributes ) {
                            shared_item_children_view.model.set( 'mhc_temp_shared_parent', shared_item_children_view.model.get( 'mhc_shared_parent' ) );
                        }

                        shared_item_children_view.model.unset( 'mhc_shared_parent' );
                    }

                    if ( this_class.has_shared_parent_cid( shared_item_children_view.model ) ) {
                        if ( keep_attributes ) {
                            shared_item_children_view.model.set( 'mhc_temp_shared_parent_cid', shared_item_children_view.model.get( 'shared_parent_cid' ) );
                        }

                        shared_item_children_view.model.unset( 'shared_parent_cid' );
                    }
                });
            },

            removeTemporarySharedAttributes : function ( view, restore_attributes ) {
                var this_class         = this,
                    restore_attributes = _.isUndefined( restore_attributes ) ? false : restore_attributes,
                    shared_item_model = _.isUndefined( view.model.attributes.mhc_temp_shared_module ) ? MH_PageComposer_Modules.findWhere({ mhc_temp_shared_module : view.model.attributes.mhc_temp_shared_parent }) : view.model,
                    shared_item_cid   = shared_item_model.attributes.cid,
                    shared_item_view  = MH_PageComposer_Layout.getView( shared_item_cid );
                    shared_item_children_views = MH_PageComposer_Layout.getChildrenViews( shared_item_cid );

                if ( this.is_temp_shared( shared_item_view.model ) ) {
                    if ( restore_attributes ) {
                        shared_item_view.model.set( 'mhc_shared_module', shared_item_view.model.get( 'mhc_temp_shared_module' ) );
                    }

                    shared_item_view.model.unset( 'mhc_temp_shared_module' );
                }

                _.each( shared_item_children_views, function( shared_item_children_view ) {
                    if ( this_class.is_temp_shared_children( shared_item_children_view.model ) ) {
                        if ( restore_attributes ) {
                            shared_item_children_view.model.set( 'mhc_shared_parent', shared_item_children_view.model.get( 'mhc_temp_shared_parent' ) );
                        }

                        shared_item_children_view.model.unset( 'mhc_temp_shared_parent' );
                    }

                    if ( this_class.has_temp_shared_parent_cid( shared_item_children_view.model ) ) {
                        if ( restore_attributes ) {
                            shared_item_children_view.model.set( 'shared_parent_cid', shared_item_children_view.model.get( 'mhc_temp_shared_parent_cid' ) );
                        }

                        shared_item_children_view.model.unset( 'mhc_temp_shared_parent_cid' );
                    }
                });

                if ( restore_attributes ) {
                    // Update shared template
                    mhc_update_shared_template( shared_item_cid );
                }
            },

            is_app : function( model ) {
                if ( model.attributes.type === 'app' ) {
                    return true;
                }

                return false;
            },

            is_shared : function( model ) {
                // App cannot be shared module. Its model.get() returns error
                if ( this.is_app( model ) ) {
                    return false;
                }

                return model.has( 'mhc_shared_module' ) && model.get( 'mhc_shared_module' ) !== '' ? true : false;
            },

            is_shared_children : function( model ) {
                // App cannot be shared module. Its model.get() returns error
                if ( this.is_app( model ) ) {
                    return false;
                }

                return model.has( 'mhc_shared_parent' ) && model.get( 'mhc_shared_parent' ) !== '' ? true : false;
            },

            has_shared_parent_cid : function( model ) {
                return model.has( 'shared_parent_cid' ) && model.get( 'shared_parent_cid' ) !== '' ? true : false;
            },

            is_temp_shared : function( model ) {
                return model.has( 'mhc_temp_shared_module' ) && model.get( 'mhc_temp_shared_module' ) !== '' ? true : false;
            },

            is_temp_shared_children : function( model ) {
                return model.has( 'mhc_temp_shared_parent' ) && model.get( 'mhc_temp_shared_parent' ) !== '' ? true : false;
            },

            has_temp_shared_parent_cid : function( model ) {
                return model.has( 'mhc_temp_shared_parent_cid' ) && model.get( 'mhc_temp_shared_parent_cid' ) !== '' ? true : false;
            }

		});

		// Collections

		MH_PageComposer.Modules = Backbone.Collection.extend({

			model : MH_PageComposer.Module

		});

		MH_PageComposer.SavedTemplates = Backbone.Collection.extend({

			model : MH_PageComposer.SavedTemplate

		});

		MH_PageComposer.Histories = Backbone.Collection.extend({

			model : MH_PageComposer.History

		});


		//Views
		MH_PageComposer.TemplatesView = window.wp.Backbone.View.extend({
			className : 'mhc_saved_layouts_list',

			tagName : 'ul',

			render: function(){
				var shared_class = '',
					layout_category = typeof this.options.category === 'undefined' ? 'all' : this.options.category;

				this.collection.each(function( single_template ){
					if ( 'all' === layout_category || ( -1 !== $.inArray( layout_category, single_template.get( 'categories' ) ) ) ){
						var single_template_view = new MH_PageComposer.SingleTemplateView({ model: single_template });
						this.$el.append( single_template_view.el );
						shared_class = typeof single_template_view.model.get( 'is_shared' ) !== 'undefined' && 'shared' === single_template_view.model.get( 'is_shared' ) ? 'shared' : '';
					}
				}, this );

				if ( 'shared' === shared_class ){
					this.$el.addClass( 'mhc_shared' );
				}

				return this;
			}

		});

		MH_PageComposer.SingleTemplateView = window.wp.Backbone.View.extend({
			tagName : 'li',

			template: _.template( $( '#mh-composer-saved-entry' ).html() ),

			events: {
				'click' : 'insertSection',
			},

			initialize: function(){
				this.render();
			},

			render: function(){
				this.$el.html( this.template( this.model.toJSON() ) );

				if ( typeof this.model.get( 'module_type' ) !== 'undefined' && '' !== this.model.get( 'module_type' ) && 'module' === this.model.get( 'layout_type' ) ){
					this.$el.addClass( this.model.get( 'module_type' ) );
				}
			},

			insertSection : function( event ){
				var clicked_button     = $( event.target ),
					parent_id          = typeof clicked_button.closest( '.mhc_modal_settings' ).data( 'parent_cid' ) !== 'undefined' ? clicked_button.closest( '.mhc_modal_settings' ).data( 'parent_cid' ) : '',
					current_row        = typeof $( '.mhc-settings-heading' ).data( 'current_row' ) !== 'undefined' ? $( '.mhc-settings-heading' ).data( 'current_row' ) : '',
					shared_id          = 'shared' === this.model.get( 'is_shared' ) ? this.model.get( 'ID' ) : '',
					specialty_row      = typeof $( '.mhc-saved-modules-switcher' ).data( 'specialty_columns' ) !== 'undefined' ? 'on' : 'off',
					shortcode          = this.model.get( 'shortcode' ),
					update_shared      = false,
					shared_holder_id   = 'row' === this.model.get( 'layout_type' ) ? current_row : parent_id,
					shared_holder_view = MH_PageComposer_Layout.getView( shared_holder_id ),
					history_noun       = this.options.model.get( 'layout_type' ) === 'row_inner' ? 'saved_row' : 'saved_' + this.options.model.get( 'layout_type' );

					if ( 'on' === specialty_row ){
						shared_holder_id = shared_holder_view.model.get( 'parent' );
						shared_holder_view = MH_PageComposer_Layout.getView( shared_holder_id );
					}

					if ( 'section' !== this.model.get( 'layout_type' ) && ( ( typeof shared_holder_view.model.get( 'shared_parent_cid' ) !== 'undefined' && '' !== shared_holder_view.model.get( 'shared_parent_cid' ) ) || ( typeof shared_holder_view.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== shared_holder_view.model.get( 'mhc_shared_module' ) ) ) ){
						update_shared = true;
					}

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'added', history_noun );

				event.preventDefault();
				MH_PageComposer_App.createLayoutFromContent( shortcode , parent_id, '', { ignore_template_tag : 'ignore_template', current_row_cid : current_row, shared_id : shared_id, after_section : parent_id, is_reinit : 'reinit' });
				mh_reinitialize_composer_layout();

				if ( true === update_shared ){
						shared_module_cid = typeof shared_holder_view.model.get( 'shared_parent_cid' ) !== 'undefined' ? shared_holder_view.model.get( 'shared_parent_cid' ) : shared_holder_id;

					mhc_update_shared_template( shared_module_cid );
				}
			}
		});

		MH_PageComposer.TemplatesModal = window.wp.Backbone.View.extend({
			className : 'mhc_modal_settings',

			template : _.template( $( '#mh-composer-load_layout-template' ).html() ),

			events : {
				'click .mhc-options-tabs-links li a' : 'switchTab'
			},

			render: function(){

				this.$el.html( this.template({ "display_switcher" : "off" }) );

				this.$el.addClass( 'mhc_modal_no_tabs' );

				return this;
			},

			switchTab: function( event ){
				var $this_el = $( event.currentTarget ).parent();
				event.preventDefault();

				mh_handle_templates_switching( $this_el, 'section', '' );
			}

		});

		MH_PageComposer.SectionView = window.wp.Backbone.View.extend({

			className : 'mhc_section',

			template : _.template( $('#mh-composer-section-template').html() ),

			events: {
				'click .mhc-settings-section' : 'showSettings',
				'click .mhc-clone-section' : 'cloneSection',
				'click .mhc-remove-section' : 'removeSection',
				'click .mhc-section-add-main' : 'addSection',
				'click .mhc-section-add-fullwidth' : 'addFullwidthSection',
				'click .mhc-section-add-specialty' : 'addSpecialtySection',
				'click .mhc-section-add-saved' : 'addSavedSection',
				'click .mhc-expand' : 'expandSection',
				'contextmenu .mhc-section-add' : 'showRightClickOptions',
				'click.mhc_section > .mhc-controls .mhc-unlock' : 'unlockSection',
				'contextmenu.mhc_section > .mhc-controls' : 'showRightClickOptions',
				'contextmenu.mhc_row > .mhc-right-click-trigger-overlay' : 'showRightClickOptions',
				'click.mhc_section > .mhc-controls' : 'hideRightClickOptions',
				'click.mhc_row > .mhc-right-click-trigger-overlay' : 'hideRightClickOptions',
				'click > .mhc-locked-overlay' : 'showRightClickOptions',
				'contextmenu > .mhc-locked-overlay' : 'showRightClickOptions',
			},

			initialize : function(){
				this.child_views = [];
				this.listenTo( this.model, 'change:admin_label', this.renameModule );
                this.listenTo( this.model, 'change:mhc_disabled', this.toggleDisabledClass );
			},

			render : function(){
				this.$el.html( this.template( this.model.toJSON() ) );

				if ( this.model.get( 'mhc_specialty' ) === 'on' ){
					this.$el.addClass( 'mhc_section_specialty' );

					if ( this.model.get( 'mhc_specialty_placeholder' ) === 'true' ){
						this.$el.addClass( 'mhc_section_placeholder' );
					}
				}

				if ( typeof this.model.get( 'mhc_shared_module' ) !== 'undefined' || ( typeof this.model.get( 'mhc_template_type' ) !== 'undefined' && 'section' === this.model.get( 'mhc_template_type' ) && 'shared' === mhc_options.is_shared_template ) ){
					this.$el.addClass( 'mhc_shared' );
				}

				if ( typeof this.model.get( 'mhc_disabled' ) !== 'undefined' && this.model.get( 'mhc_disabled' ) === 'on' ){
					this.$el.addClass( 'mhc_disabled' );
				}

				if ( typeof this.model.get( 'mhc_locked' ) !== 'undefined' && this.model.get( 'mhc_locked' ) === 'on' ){
					this.$el.addClass( 'mhc_locked' );
				}

				if ( typeof this.model.get( 'mhc_collapsed' ) !== 'undefined' && this.model.get( 'mhc_collapsed' ) === 'on' ){
					this.$el.addClass( 'mhc_collapsed' );
				}
                
                if ( typeof this.model.get( 'pasted_module' ) !== 'undefined' && this.model.get( 'pasted_module' ) ){
					mhc_handle_clone_class( this.$el );
				}
                
                if ( ! _.isUndefined( this.model.get( 'mhc_temp_shared_module' ) ) ) {
					this.$el.addClass( 'mhc_shared_temp' );
				}

				this.makeRowsSortable();

				return this;
			},

			showSettings : function( event ){
				var that = this,
					$current_target = typeof event !== 'undefined' ? $( event.currentTarget ) : '',
					modal_view,
					view_settings = {
						model : this.model,
						collection : this.collection,
						attributes : {
							'data-open_view' : 'module_settings'
						},
						triggered_by_right_click : this.triggered_by_right_click,
						do_preview : this.do_preview
					};

				if ( typeof event !== 'undefined' ){
					event.preventDefault();
				}

				if ( this.isSectionLocked() ){
					return;
				}

                if ( '' !== $current_target && $current_target.closest( '.mhc_section_specialty' ).length ){
					var $specialty_section_columns = $current_target.closest( '.mhc_section_specialty' ).find( '.mhc-section-content > .mhc-column' ),
						columns_layout = '';

					if ( $specialty_section_columns.length ){
						$specialty_section_columns.each(function(){
							columns_layout += '' === columns_layout ? '1_1' : ',1_1';
						});
					}

					view_settings.model.attributes.columns_layout = columns_layout;

				}

				modal_view = new MH_PageComposer.ModalView( view_settings );
                
                mh_modal_view_rendered = modal_view.render();
                
                if ( false === mh_modal_view_rendered ) {
					setTimeout(function(){
						that.showSettings();
					}, 500 );

					MH_PageComposer_Events.trigger( 'mhc-loading:started' );

					return;
				}

				MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
                
                $('body').append( mh_modal_view_rendered.el );
                
                if ( 'on' === this.model.get( 'mhc_fullwidth' ) ){
					$( '.mhc_modal_settings_container' ).addClass( 'section_fullwidth' );
				}
                if ( 'on' === this.model.get( 'mhc_specialty' ) ){
					$( '.mhc_modal_settings_container' ).addClass( 'section_specialty' );
				}
                if ( 'on' !== this.model.get( 'mhc_specialty' ) &&  'on' !== this.model.get( 'mhc_fullwidth' )){
					$( '.mhc_modal_settings_container' ).addClass( 'section_regular' );
				}

				if ( ( typeof modal_view.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== modal_view.model.get( 'mhc_shared_module' ) ) || ( typeof this.model.get( 'mhc_template_type' ) !== 'undefined' && 'section' === this.model.get( 'mhc_template_type' ) && 'shared' === mhc_options.is_shared_template ) ){
					$( '.mhc_modal_settings_container' ).addClass( 'mhc_saved_shared_modal' );

					var saved_tabs = [ 'general', 'advanced', 'custom_css' ];
					_.each( saved_tabs, function( tab_name ){
						$( '.mhc_options_tab_' + tab_name ).addClass( 'mhc_saved_shared_tab' );
					});
				}

				mhc_open_current_tab();
			},

			addSection : function( event ){
				var module_id = MH_PageComposer_Layout.generateNewId();

				event.preventDefault();

				mhc_close_all_right_click_options();

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'added', 'section' );

				this.collection.add( [ {
					type : 'section',
					module_type : 'section',
					mhc_fullwidth : 'off',
					mhc_specialty : 'off',
					cid : module_id,
					view : this,
					created : 'auto',
					admin_label : mhc_options.noun['section']
				} ] );
			},

			addFullwidthSection : function( event ){
				var module_id = MH_PageComposer_Layout.generateNewId();

				event.preventDefault();

				mhc_close_all_right_click_options();

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'added', 'fullwidth_section' );

				this.collection.add( [ {
					type : 'section',
					module_type : 'section',
					mhc_fullwidth : 'on',
					mhc_specialty : 'off',
					cid : module_id,
					view : this,
					created : 'auto',
					admin_label : mhc_options.noun['section']
				} ] );
			},

			addSpecialtySection : function( event ){
				var module_id = MH_PageComposer_Layout.generateNewId(),
					$event_target = $(event.target),
					template_type = typeof $event_target !== 'undefined' && typeof $event_target.data( 'is_template' ) !== 'undefined' ? 'section' : '';

				event.preventDefault();

				mhc_close_all_right_click_options();

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'added', 'specialty_section' );

				this.collection.add( [ {
					type : 'section',
					module_type : 'section',
					mhc_fullwidth : 'off',
					mhc_specialty : 'on',
					cid : module_id,
					template_type : template_type,
					view : this,
					created : 'auto',
					admin_label : mhc_options.noun['section']
				} ] );
			},

			addSavedSection : function( event ){
				var parent_cid = this.model.get( 'cid' ),
					view_settings = {
						attributes : {
							'data-open_view' : 'saved_templates',
							'data-parent_cid' : parent_cid
						},
						view : this
					},
					main_view = new MH_PageComposer.ModalView( view_settings );

				mhc_close_all_right_click_options();

				$( 'body' ).append( main_view.render().el );

				generate_templates_view( 'include_shared', '', 'section', $( '.mhc-saved-modules-tab' ), 'regular', 0, 'all' );

				event.preventDefault();
			},

			expandSection : function( event ){
				event.preventDefault();

				var $parent = this.$el.closest('.mhc_section');

				$parent.removeClass('mhc_collapsed');

				// Add attribute to shortcode
				this.options.model.attributes.mhc_collapsed = 'off';

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'expanded', 'section' );

				// Rebuild shortcodes
				MH_PageComposer_App.saveAsShortcode();
			},

			unlockSection : function( event ){
				event.preventDefault();

				var this_el = this,
					$parent = this_el.$el.closest('.mhc_section'),
					request = mhc_user_lock_permissions(),
					children_views;

				request.done(function ( response ){
					if ( true === response ){
						$parent.removeClass('mhc_locked');

						// Add attribute to shortcode
						this_el.options.model.attributes.mhc_locked = 'off';

						children_views = MH_PageComposer_Layout.getChildrenViews( this_el.model.get('cid') );

						_.each( children_views, function( view, key ){
							view.$el.removeClass('mhc_parent_locked');
							view.model.set( 'mhc_parent_locked', 'off', { silent : true });
						});

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'unlocked', 'section' );

						// Rebuild shortcodes
						MH_PageComposer_App.saveAsShortcode();
					} else {
						alert( mhc_options.locked_section_permission_alert );
					}
				});
			},

			addRow : function( appendAfter ){
				var module_id = MH_PageComposer_Layout.generateNewId(),
					shared_parent = typeof this.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== this.model.get( 'mhc_shared_module' ) ? this.model.get( 'mhc_shared_module' ) : '',
					shared_parent_cid = '' !== shared_parent ? this.model.get( 'cid' ) : '',
					new_row_view;

				this.collection.add( [ {
					type : 'row',
					module_type : 'row',
					cid : module_id,
					parent : this.model.get( 'cid' ),
					view : this,
					appendAfter : appendAfter,
					mhc_shared_parent : shared_parent,
					shared_parent_cid : shared_parent_cid,
					admin_label : mhc_options.noun['row']
				} ] );
				new_row_view = MH_PageComposer_Layout.getView( module_id );
				new_row_view.displayColumnsOptions();
			},

			cloneSection : function( event ){
				event.preventDefault();

				if ( this.isSectionLocked() ){
					return;
				}

				var $cloned_element = this.$el.clone(),
					content,
					clone_section,
					view_settings = {
						model      : this.model,
						view       : this.$el,
						view_event : event
					};

				clone_section = new MH_PageComposer.RightClickOptionsView( view_settings, true );

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'cloned', 'section' );

				clone_section.copy( event );

				clone_section.pasteAfter( event );
			},

			makeRowsSortable : function(){
				var this_el = this,
					sortable_el = this_el.model.get( 'mhc_fullwidth' ) !== 'on'
						? '.mhc-section-content'
						: '.mhc_fullwidth_sortable_area',
					connectWith = ':not(.mhc_locked) > ' + sortable_el;

				if ( this_el.model.get( 'mhc_specialty' ) === 'on' ){
					return;
				}

				this_el.$el.find( sortable_el ).sortable({
					connectWith: connectWith,
                    delay: 100,
					cancel : '.mhc-settings, .mhc-clone, .mhc-remove, .mhc-row-add, .mhc-insert-module, .mhc-insert-column, .mhc_locked, .mhc-disable-sort',
					update : function( event, ui ){
						if ( ! $( ui.item ).closest( event.target ).length ){

							// don't allow to move the row to another section if the section has only one row
							if ( ! $( event.target ).find( '.mhc_row' ).length ){
								$(this).sortable( 'cancel' );
								alert( mhc_options.section_only_row_dragged_away );
							}

							// do not allow to drag rows into sections where sorting is disabled
							if ( $( ui.item ).closest( '.mhc-disable-sort').length ){
								$( event.target ).sortable( 'cancel' );
							}
							// makes sure the code runs one time, if row is dragged into another section
							return;

						}

						if ( $( ui.item ).closest( '.mhc_section.mhc_shared' ).length && $( ui.item ).hasClass( 'mhc_shared' ) ){
							$( ui.sender ).sortable( 'cancel' );
							alert( mhc_options.shared_row_alert );
						} else if ( ( $( ui.item ).closest( '.mhc_section.mhc_shared' ).length || $( ui.sender ).closest( '.mhc_section.mhc_shared' ).length ) && '' === mhc_options.template_post_id ){
							var module_cid = ui.item.data( 'cid' ),
									model,
									shared_module_cid,
									$moving_from,
									$moving_to;

							$moving_from = $( ui.sender ).closest( '.mhc_section.mhc_shared' );
							$moving_to = $( ui.item ).closest( '.mhc_section.mhc_shared' );


							if ( $moving_from === $moving_to ){
								model = this_el.collection.find(function( model ){
									return model.get('cid') == module_cid;
								});

								shared_module_cid = model.get( 'shared_parent_cid' );

								mhc_update_shared_template( shared_module_cid );
								mh_reinitialize_composer_layout();
							} else {
								var $shared_element = $moving_from;
								for ( var i = 1; i <= 2; i++ ){
									shared_module_cid = $shared_element.find( '.mhc-section-content' ).data( 'cid' );

									if ( typeof shared_module_cid !== 'undefined' && '' !== shared_module_cid ){

										mhc_update_shared_template( shared_module_cid );
										mh_reinitialize_composer_layout();
									}

									$shared_element = $moving_to;
								};
							}
						}

						MH_PageComposer_Layout.setNewParentID( ui.item.find( '.mhc-row-content' ).data( 'cid' ), this_el.model.attributes.cid );

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'moved', 'row' );

						MH_PageComposer_Events.trigger( 'mh-sortable:update' );

						// Prepare collection sorting based on layout position
						var section_cid       = parseInt( $(this).attr( 'data-cid') ),
							sibling_row_index = 0;

						// Loop row block based on DOM position to ensure its index order
						$(this).find('.mhc-row-content').each(function(){
							sibling_row_index++;

							var sibling_row_cid = parseInt( $(this).data('cid') ),
								layout_index    = section_cid + sibling_row_index,
								sibling_model   = MH_PageComposer_Modules.findWhere({ cid : sibling_row_cid });

							// Set layout_index
							sibling_model.set({ layout_index : layout_index });
						});

						// Sort collection based on layout_index
						MH_PageComposer_Modules.comparator = 'layout_index';
						MH_PageComposer_Modules.sort();
					},
					start : function( event, ui ){
						mhc_close_all_right_click_options();
					}
				});
			},

			addChildView : function( view ){
				this.child_views.push( view );
			},

			removeChildViews : function(){
				var child_views = MH_PageComposer_Layout.getChildViews( this.model.attributes.cid );

				_.each( child_views, function( view ) {
					if ( typeof view.model !== 'undefined' )
						view.model.destroy();

					view.remove();
				});
			},

			removeSection : function( event, remove_all ){
				var rows,
					remove_last_specialty_section = false;

				if ( event ) event.preventDefault();

				if ( this.isSectionLocked() || MH_PageComposer_Layout.isChildrenLocked( this.model.get( 'cid' ) ) ){
					return;
				}

				if ( this.model.get( 'mhc_fullwidth' ) === 'on' ){
					this.removeChildViews();
				} else {
					rows = MH_PageComposer_Layout.getChildViews( this.model.get('cid') );

					_.each( rows, function( row ){
						if ( row.model.get( 'type' ) === 'column' ){
							// remove column in specialty section
							row.removeColumn();
						} else {
							row.removeRow( false, true );
						}
					});
				}

				// the only section left is specialty or fullwidth section
				if ( ! MH_PageComposer_Layout.get( 'forceRemove' ) && ( this.model.get( 'mhc_specialty' ) === 'on' || this.model.get( 'mhc_fullwidth' ) === 'on' ) && MH_PageComposer_Layout.getNumberOfModules( 'section' ) === 1 ){
					remove_last_specialty_section = true;
				}

				// if there is only one section, don't remove it
				// allow to remove all sections if removeSection function is called directly
				// remove the specialty section even if it's the last one on the page
				if ( MH_PageComposer_Layout.get( 'forceRemove' ) || remove_last_specialty_section || MH_PageComposer_Layout.getNumberOfModules( 'section' ) > 1 ){
					this.model.destroy();

					MH_PageComposer_Layout.removeView( this.model.get('cid') );

					this.remove();
				}

				// start with the clean layout if the user removed the last specialty section on the page
				if ( remove_last_specialty_section ){
					MH_PageComposer_App.removeAllSections( true );

					return;
				}

				// Enable history saving and set meta for history
				if ( _.isUndefined( remove_all ) ){
					MH_PageComposer_App.allowHistorySaving( 'removed', 'section' );
				} else {
					MH_PageComposer_App.allowHistorySaving( 'cleared', 'layout' );
				}

				// trigger remove event if the row was removed manually ( using a button )
				if ( event ){
					MH_PageComposer_Events.trigger( 'mh-module:removed' );
				}
			},

			isSectionLocked : function(){
				if ( 'on' === this.model.get( 'mhc_locked' ) ){
					return true;
				}

				return false;
			},

			showRightClickOptions : function( event ){
				event.preventDefault();

				var mh_right_click_options_view,
					view_settings = {
						model      : this.model,
						view       : this.$el,
						view_event : event
					};

				mh_right_click_options_view = new MH_PageComposer.RightClickOptionsView( view_settings );
			},

			hideRightClickOptions : function( event ){
				event.preventDefault();

				mhc_close_all_right_click_options();
			},

			renameModule : function(){
				this.$( '.mhc-section-title' ).html( this.model.get( 'admin_label' ) );
			},
            
            toggleDisabledClass : function(){
				if ( typeof this.model.get( 'mhc_disabled' ) !== 'undefined' && 'on' === this.model.get( 'mhc_disabled' ) ){
					this.$el.addClass( 'mhc_disabled' );
				} else {
					this.$el.removeClass( 'mhc_disabled' );
				}
			}
		});

		MH_PageComposer.RowView = window.wp.Backbone.View.extend({
			className : 'mhc_row',

			template : _.template( $('#mh-composer-row-template').html() ),

			events : {
				'click .mhc-settings-row' : 'showSettings',
				'click .mhc-insert-column' : 'displayColumnsOptions',
				'click .mhc-clone-row' : 'cloneRow',
				'click .mhc-row-add' : 'addNewRow',
				'click .mhc-remove-row' : 'removeRow',
				'click .mhc-change-structure' : 'changeStructure',
				'click .mhc-expand' : 'expandRow',
				'contextmenu .mhc-row-add' : 'showRightClickOptions',
				'click.mhc_row > .mhc-controls .mhc-unlock' : 'unlockRow',
				'contextmenu.mhc_row > .mhc-controls' : 'showRightClickOptions',
				'contextmenu.mhc_row > .mhc-right-click-trigger-overlay' : 'showRightClickOptions',
				'contextmenu .mhc-column' : 'showRightClickOptions',
				'click.mhc_row > .mhc-controls' : 'hideRightClickOptions',
				'click.mhc_row > .mhc-right-click-trigger-overlay' : 'hideRightClickOptions',
				'click > .mhc-locked-overlay' : 'showRightClickOptions',
				'contextmenu > .mhc-locked-overlay' : 'showRightClickOptions',
			},

			initialize : function(){
				this.listenTo( MH_PageComposer_Events, 'mh-add:columns', this.toggleInsertColumnButton );
				this.listenTo( this.model, 'change:admin_label', this.renameModule );
                this.listenTo( this.model, 'change:mhc_disabled', this.toggleDisabledClass );
			},

			render : function(){
				var parent_views = MH_PageComposer_Layout.getParentViews( this.model.get( 'parent' ) );

				if ( typeof this.model.get( 'view' ) !== 'undefined' && typeof this.model.get( 'view' ).model.get( 'layout_specialty' ) !== 'undefined' ){
					this.model.set( 'specialty_row', '1', { silent : true });
				}

				this.$el.html( this.template( this.model.toJSON() ) );

				if ( typeof this.model.get( 'mhc_shared_module' ) !== 'undefined' || ( typeof this.model.get( 'mhc_template_type' ) !== 'undefined' && 'row' === this.model.get( 'mhc_template_type' ) && 'shared' === mhc_options.is_shared_template ) ){
					this.$el.addClass( 'mhc_shared' );
				}

				if ( typeof this.model.get( 'mhc_disabled' ) !== 'undefined' && this.model.get( 'mhc_disabled' ) === 'on' ){
					this.$el.addClass( 'mhc_disabled' );
				}

				if ( typeof this.model.get( 'mhc_locked' ) !== 'undefined' && this.model.get( 'mhc_locked' ) === 'on' ){
					this.$el.addClass( 'mhc_locked' );

					_.each( parent_views, function( parent ){
						parent.$el.addClass( 'mhc_children_locked' );
					});
				}

				if ( typeof this.model.get( 'mhc_parent_locked' ) !== 'undefined' && this.model.get( 'mhc_parent_locked' ) === 'on' ){
					this.$el.addClass( 'mhc_parent_locked' );
				}

				if ( typeof this.model.get( 'mhc_collapsed' ) !== 'undefined' && this.model.get( 'mhc_collapsed' ) === 'on' ){
					this.$el.addClass( 'mhc_collapsed' );
				}
                
                if ( typeof this.model.get( 'pasted_module' ) !== 'undefined' && this.model.get( 'pasted_module' ) ){
					mhc_handle_clone_class( this.$el );
				}
                
                if ( MH_PageComposer_Layout.is_temp_shared( this.model ) ) {
					this.$el.addClass( 'mhc_shared_temp' );
				}

				return this;
			},

			showSettings : function( event ){
				var that = this,
					modal_view,
					view_settings = {
						model : this.model,
						collection : this.collection,
						attributes : {
							'data-open_view' : 'module_settings'
						},
						triggered_by_right_click : this.triggered_by_right_click,
						do_preview : this.do_preview
					};

				if ( typeof event !== 'undefined' ){
					event.preventDefault();
				}

				if ( this.isRowLocked() ){
					return;
				}

				modal_view = new MH_PageComposer.ModalView( view_settings );
                
                mh_modal_view_rendered = modal_view.render();
                
                if ( false === mh_modal_view_rendered ) {
					setTimeout(function(){
						that.showSettings();
					}, 500 );

					MH_PageComposer_Events.trigger( 'mhc-loading:started' );

					return;
				}

				MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
                
                $('body').append( mh_modal_view_rendered.el );

				if ( ( typeof modal_view.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== modal_view.model.get( 'mhc_shared_module' ) ) || ( MH_PageComposer_Layout.getView( modal_view.model.get('cid') ).$el.closest( '.mhc_shared' ).length ) || ( typeof this.model.get( 'mhc_template_type' ) !== 'undefined' && 'row' === this.model.get( 'mhc_template_type' ) && 'shared' === mhc_options.is_shared_template ) ){
					$( '.mhc_modal_settings_container' ).addClass( 'mhc_saved_shared_modal' );

					var saved_tabs = [ 'general', 'advanced', 'custom_css' ];
					_.each( saved_tabs, function( tab_name ){
						$( '.mhc_options_tab_' + tab_name ).addClass( 'mhc_saved_shared_tab' );
					});
				}
			},

			displayColumnsOptions : function( event ){
				if ( event ){
					event.preventDefault();
				}

				if ( this.isRowLocked() ){
					return;
				}

				var view,
					this_view = this;

				this.model.set( 'open_view', 'column_settings', { silent : true });

				view = new MH_PageComposer.ModalView({
					model : this.model,
					collection : this.collection,
					attributes : {
						'data-open_view' : 'column_settings'
					},
					view : this_view
				});

				$('body').append( view.render().el );

				this.toggleInsertColumnButton();
			},

			changeStructure : function( event ){
				event.preventDefault();

				var view,
					this_view = this;

				if ( this.isRowLocked() ){
					return;
				}

				this.model.set( 'change_structure', 'true', { silent : true });

				this.model.set( 'open_view', 'column_settings', { silent : true });

				MH_PageComposer.Events = MH_PageComposer_Events;
				view = new MH_PageComposer.ModalView({
					model : this.model,
					collection : this.collection,
					attributes : {
						'data-open_view' : 'column_settings'
					},
					view : this_view
				});

				$('body').append( view.render().el );
			},

			expandRow : function( event ){
				event.preventDefault();

				var $parent = this.$el.closest('.mhc_row');

				$parent.removeClass('mhc_collapsed');

				// Add attribute to shortcode
				this.options.model.attributes.mhc_collapsed = 'off';

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'expanded', 'row' );

				// Rebuild shortcodes
				MH_PageComposer_App.saveAsShortcode();
			},

			unlockRow : function( event ){
				event.preventDefault();

				var this_el = this,
					$parent = this_el.$el.closest('.mhc_row'),
					request = mhc_user_lock_permissions(),
					children_views,
					parent_views;

				request.done(function ( response ){
					if ( true === response ){
						$parent.removeClass('mhc_locked');

						// Add attribute to shortcode
						this_el.options.model.attributes.mhc_locked = 'off';

						children_views = MH_PageComposer_Layout.getChildrenViews( this_el.model.get('cid') );

						_.each( children_views, function( view, key ){
							view.$el.removeClass('mhc_parent_locked');
							view.model.set( 'mhc_parent_locked', 'off', { silent : true });
						});

						parent_views = MH_PageComposer_Layout.getParentViews( this_el.model.get('parent') );

						_.each( parent_views, function( view, key ){
							if ( ! MH_PageComposer_Layout.isChildrenLocked( view.model.get( 'cid' ) ) ){
								view.$el.removeClass('mhc_children_locked');
							}
						});

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'unlocked', 'row' );

						// Rebuild shortcodes
						MH_PageComposer_App.saveAsShortcode();
					} else {
						alert( mhc_options.locked_row_permission_alert );
					}
				});
			},

			toggleInsertColumnButton : function(){
				var model_id = this.model.get( 'cid' ),
					columnsInRow;

				// check if the current row has at least one column
				columnsInRow = this.collection.find(function( model ){
					return ( model.get( 'type' ) === 'column' || model.get( 'type' ) === 'column_inner' ) && model.get( 'parent' ) === model_id;
				});

				if ( ! _.isUndefined( columnsInRow ) ){
					this.$( '.mhc-insert-column' ).hide();

					// show "change columns structure" icon, if current row's column layout is set
					this.$( '.mhc-change-structure' ).show();
				}
			},

			addNewRow : function( event ){
				var $parent_section = this.$el.closest( '.mhc-section-content' ),
					$current_target = $( event.currentTarget ),
					parent_view_cid = $current_target.closest( '.mhc-column-specialty' ).length ? $current_target.closest( '.mhc-column-specialty' ).data( 'cid' ) : $parent_section.data( 'cid' ),
					parent_view = MH_PageComposer_Layout.getView( parent_view_cid );

				event.preventDefault();

				mhc_close_all_right_click_options();

				if ( 'on' === this.model.get( 'mhc_parent_locked' ) ){
					return;
				}

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'added', 'row' );

				parent_view.addRow( this.$el );

			},

			cloneRow : function( event ){
				var shared_module_cid = '',
					parent_view = MH_PageComposer_Layout.getView( this.model.get( 'parent' ) ),
					clone_row,
					view_settings = {
						model      : this.model,
						view       : this.$el,
						view_event : event
					};

				event.preventDefault();

				if ( this.isRowLocked() ){
					return;
				}

				if ( this.$el.closest( '.mhc_section.mhc_shared' ).length && typeof parent_view.model.get( 'mhc_template_type' ) === 'undefined' ){
					shared_module_cid = this.model.get( 'shared_parent_cid' );
				}

				clone_row = new MH_PageComposer.RightClickOptionsView( view_settings, true );

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'cloned', 'row' );

				clone_row.copy( event );

				clone_row.pasteAfter( event );

				if ( '' !== shared_module_cid ){
					mhc_update_shared_template( shared_module_cid );
				}
			},

			removeRow : function( event, force ){
				var columns,
					shared_module_cid = '',
					parent_view = MH_PageComposer_Layout.getView( this.model.get( 'parent' ) );

				if ( this.isRowLocked() || MH_PageComposer_Layout.isChildrenLocked( this.model.get( 'cid' ) ) ){
					return;
				}

				if ( event ){
					event.preventDefault();

					// don't allow to remove a specialty section, even if there is only one row in it
					if ( this.$el.closest( '.mhc-column-specialty' ).length ){
						event.stopPropagation();
					}

					if ( this.$el.closest( '.mhc_section.mhc_shared' ).length && typeof parent_view.model.get( 'mhc_template_type' ) === 'undefined' ){
						shared_module_cid = this.model.get( 'shared_parent_cid' );
					}
				}

				columns = MH_PageComposer_Layout.getChildViews( this.model.get('cid') );

				_.each( columns, function( column ){
					column.removeColumn();
				});

				// if there is only one row in the section, don't remove it
				if ( MH_PageComposer_Layout.get( 'forceRemove' ) || MH_PageComposer_Layout.getNumberOf( 'row', this.model.get('parent') ) > 1 ){
					this.model.destroy();

					MH_PageComposer_Layout.removeView( this.model.get('cid') );

					this.remove();
				} else {
					this.$( '.mhc-insert-column' ).show();

					// hide "change columns structure" icon, column layout can be re-applied using "Insert column(s)" button
					this.$( '.mhc-change-structure' ).hide();
				}

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'removed', 'row' );

				// trigger remove event if the row was removed manually ( using a button )
				if ( event ){
					MH_PageComposer_Events.trigger( 'mh-module:removed' );
				}

				if ( '' !== shared_module_cid ){
					mhc_update_shared_template( shared_module_cid );
				}
			},

			isRowLocked : function(){
				if ( 'on' === this.model.get( 'mhc_locked' ) || 'on' === this.model.get( 'mhc_parent_locked' ) ){
					return true;
				}

				return false;
			},

			showRightClickOptions : function( event ){
				event.preventDefault();
				var $event_target = $( event.target ),
					mh_right_click_options_view,
					view_settings;

				// Do nothing if Module or "Insert Module" clicked
				if ( $event_target.closest( '.mhc-insert-module' ).length || $event_target.hasClass( 'mhc_module_block' ) || $event_target.closest( '.mhc_module_block' ).length ){
					return;
				}

				mh_right_click_options_view,
				view_settings = {
					model      : this.model,
					view       : this.$el,
					view_event : event
				};

				mh_right_click_options_view = new MH_PageComposer.RightClickOptionsView( view_settings );
			},

			hideRightClickOptions : function( event ){
				event.preventDefault();

				mhc_close_all_right_click_options();
			},

			renameModule : function(){
				this.$( '.mhc-row-title' ).html( this.model.get( 'admin_label' ) );
			},
            
            toggleDisabledClass : function(){
				if ( typeof this.model.get( 'mhc_disabled' ) !== 'undefined' && 'on' === this.model.get( 'mhc_disabled' ) ){
					this.$el.addClass( 'mhc_disabled' );
				} else {
					this.$el.removeClass( 'mhc_disabled' );
				}
			}
		});

		MH_PageComposer.ModalView = window.wp.Backbone.View.extend({

			className : 'mhc_modal_settings_container',

			template : _.template( $('#mh-composer-modal-template').html() ),

			events : {
				'click .mhc-modal-save' : 'saveSettings',
				'click .mhc-modal-preview-template' : 'preview',
				'click .mhc-preview-mobile' : 'resizePreviewScreen',
				'click .mhc-preview-tablet' : 'resizePreviewScreen',
				'click .mhc-preview-desktop' : 'resizePreviewScreen',
				'click .mhc-modal-close' : 'closeModal',
				'click .mhc-modal-save-template' : 'saveTemplate',
				'change #mhc_select_category' : 'applyFilter'
			},

			initialize : function( attributes ){
				this.listenTo( MH_PageComposer_Events, 'mh-add:columns', this.removeView );

				// listen to module settings box that is created after the user selects new module to add
				this.listenTo( MH_PageComposer_Events, 'mh-new_module:show_settings', this.removeView );

				this.listenTo( MH_PageComposer_Events, 'mh-saved_layout:loaded', this.removeView );

				this.options = attributes;
			},

			render : function(){
				var view,
					view_settings = {
						model : this.model,
						collection : this.collection,
						view : this.options.view
					},
					fake_value = false;
                
                this.$el.attr( 'tabindex', 0 ); // set tabindex to make the div focusable

				// update the row view if it has been dragged into another column
				if ( typeof this.model !== 'undefined' && typeof this.model.get( 'view' ) !== 'undefined' && ( this.model.get( 'module_type' ) === 'row_inner' || this.model.get( 'module_type' ) === 'row' ) && this.model.get( 'parent' ) !== this.model.get( 'view' ).$el.data( 'cid' ) ){
					this.model.set( 'view', MH_PageComposer_Layout.getView( this.model.get( 'parent' ) ), { silent : true });
				}

				if ( this.attributes['data-open_view'] === 'all_modules' && this.model.get( 'module_type' ) === 'section' && this.model.get( 'mhc_fullwidth' ) === 'on' ){
					this.model.set( 'type', 'column', { silent : true });
					fake_value = true;
				}

				if ( typeof this.model !== 'undefined' ){
					var this_parent_view = MH_PageComposer_Layout.getView( this.model.get( 'parent' ) ),
						this_template_type = typeof this.model.get( 'mhc_template_type' ) !== 'undefined' && 'module' === this.model.get( 'mhc_template_type' ) || typeof this.model.get( 'template_type' ) !== 'undefined' && 'module' === this.model.get( 'template_type' ),
						saved_tabs = typeof this.model.get( 'mhc_saved_tabs' ) !== 'undefined' && 'all' !== this.model.get( 'mhc_saved_tabs' ) || typeof this_parent_view !== 'undefined' && typeof this_parent_view.model.get( 'mhc_saved_tabs' ) !== 'undefined' && 'all' !== this_parent_view.model.get( 'mhc_saved_tabs' )

					if ( this.attributes['data-open_view'] === 'column_specialty_settings' ){
						this.model.set( 'open_view', 'column_specialty_settings', { silent : true });
					}

					this.$el.html( this.template( this.model.toJSON() ) );

					if ( this.attributes['data-open_view'] === 'column_specialty_settings' ){
						this.model.unset( 'open_view', 'column_specialty_settings', { silent : true });
					}

					if ( this_template_type && saved_tabs ){
						var selected_tabs = typeof this.model.get( 'mhc_saved_tabs' ) !== 'undefined' ? this.model.get( 'mhc_saved_tabs' ) : this_parent_view.model.get( 'mhc_saved_tabs' ) ,
							selected_tabs_array = selected_tabs.split( ',' ),
							possible_tabs_array = [ 'general', 'advanced', 'css' ],
							css_class = '',
							start_from_tab = '';

						if ( selected_tabs_array[0] !== 'all' ){
							_.each( possible_tabs_array, function ( tab ){
								if ( -1 === $.inArray( tab, selected_tabs_array ) ){
									css_class += ' mhc_hide_' + tab + '_tab';
								} else {
									start_from_tab = '' === start_from_tab ? tab : start_from_tab;
								}
							});

							start_from_tab = 'css' === start_from_tab ? 'custom_css' : start_from_tab;

						}

						this.$el.addClass( css_class );

						if ( typeof this.model.get( 'mhc_saved_tabs' ) === 'undefined' ){
							this.model.set( 'mhc_saved_tabs', selected_tabs, { silent : true });
						}
					}
				}
				else
					this.$el.html( this.template() );

				if ( fake_value )
					this.model.set( 'type', 'section', { silent : true });

				this.container = this.$('.mhc-modal-container');

				if ( this.attributes['data-open_view'] === 'column_settings' ){
					view = new MH_PageComposer.ColumnSettingsView( view_settings );
				} else if ( this.attributes['data-open_view'] === 'all_modules' ){
					view_settings['attributes'] = {
						'data-parent_cid' : this.model.get( 'cid' )
					}

					view = new MH_PageComposer.ModulesView( view_settings );
				} else if ( this.attributes['data-open_view'] === 'module_settings' ){
					view_settings['attributes'] = {
						'data-module_type' : this.model.get( 'module_type' )
					}

					view_settings['view'] = this;

					view = new MH_PageComposer.ModuleSettingsView( view_settings );
				} else if ( this.attributes['data-open_view'] === 'save_layout' ){
					view = new MH_PageComposer.SaveLayoutSettingsView( view_settings );
				} else if ( this.attributes['data-open_view'] === 'column_specialty_settings' ){
					view = new MH_PageComposer.ColumnSettingsView( view_settings );
				} else if ( this.attributes['data-open_view'] === 'saved_templates' ){
					view = new MH_PageComposer.TemplatesModal({ attributes: { 'data-parent_cid' : this.attributes['data-parent_cid'] } });
				}
                
                // do not proceed and return false if no template for this module exist yet
				if ( typeof view.attributes !== 'undefined' && 'no_template' === view.attributes['data-no_template'] ){
					return false;
				}

				this.container.append( view.render().el );

				if ( this.attributes['data-open_view'] === 'column_settings' ){
					// if column settings layout was generated, remove open_view attribute from a row
					// the row module modal window shouldn't have this attribute attached
					this.model.unset( 'open_view', { silent : true });
				}

				// show only modules that the current element can contain
				if ( this.attributes['data-open_view'] === 'all_modules' ){
					if ( this.model.get( 'module_type' ) === 'section' && typeof( this.model.get( 'mhc_fullwidth' ) !== 'undefined' ) && this.model.get( 'mhc_fullwidth' ) === 'on' ){
						$( view.render().el ).find( '.mhc-all-modules li:not(.mhc_fullwidth_only_module)' ).remove();
					} else {
						$( view.render().el ).find( 'li.mhc_fullwidth_only_module' ).remove();
					}
				}

				if ( $( '.mhc_modal_overlay' ).length ){
					$( '.mhc_modal_overlay' ).remove();
					$( 'body' ).removeClass( 'mhc_stop_scroll' );
				}
                
                
                if ( $( 'body' ).hasClass( 'mhc_modal_fade_in' ) ){
					$( 'body' ).append( '<div class="mhc_modal_overlay mhc_no_animation"></div>' );
				} else {
					$( 'body' ).append( '<div class="mhc_modal_overlay"></div>' );
				}

				$( 'body' ).addClass( 'mhc_stop_scroll' );

				return this;
			},

			closeModal : function( event ){
				event.preventDefault();

				if ( $( '.mh_modal_on_top' ).length ){
					$( '.mh_modal_on_top' ).remove();
				} else {

					if ( typeof this.model !== 'undefined' && this.model.get( 'type' ) === 'module' && this.$( '#mhc_content_new' ).length )
						mhc_tinymce_remove_control( 'mhc_content_new' );

					mhc_hide_active_color_picker( this );

					mhc_close_modal_view( this, 'trigger_event' );
				}
			},

			removeView : function(){
				if ( typeof this.model === 'undefined' || ( this.model.get( 'type' ) === 'row' || this.model.get( 'type' ) === 'column' || this.model.get( 'type' ) === 'row_inner' || this.model.get( 'type' ) === 'column_inner' || ( this.model.get( 'type' ) === 'section' && ( this.model.get( 'mhc_fullwidth' ) === 'on' || this.model.get( 'mhc_specialty' ) === 'on' ) ) ) ){
					if ( typeof this.model !== 'undefined' && typeof this.model.get( 'type' ) !== 'undefined' && ( this.model.get( 'type' ) === 'column' || this.model.get( 'type' ) === 'column_inner' || ( this.model.get( 'type' ) === 'section' &&  this.model.get( 'mhc_fullwidth' ) === 'on' ) ) ){
						var that = this,
							$opened_tab = $( that.el ).find( '.mhc-main-settings.active-container' );

						// if we're adding module from library, then close everything. Otherwise leave overlay in place and add specific classes
						if ( $opened_tab.hasClass( 'mhc-saved-modules-tab' ) ){
							mhc_close_modal_view( that );
						} else {
							that.remove();

							$( 'body' ).addClass( 'mhc_modal_fade_in' );
							$( '.mhc_modal_overlay' ).addClass( 'mhc_no_animation' );
							setTimeout(function(){
								$( '.mhc_modal_settings_container' ).addClass( 'mhc_no_animation' );
								$( 'body' ).removeClass( 'mhc_modal_fade_in' );
							}, 500);
						}
					} else {
						mhc_close_modal_view( this );
					}
				} else {
					this.removeOverlay();
				}
			},

			saveSettings : function( event, close_modal ){
				var that = this,
					shared_module_cid = '',
                    this_view = MH_PageComposer_Layout.getView( that.model.get( 'cid' ) ),
					this_parent_view = typeof that.model.get( 'parent' ) !== 'undefined' ? MH_PageComposer_Layout.getView( that.model.get( 'parent' ) ) : '',
                    shared_holder_view = '' !== this_parent_view && ( typeof that.model.get( 'mhc_shared_module' ) === 'undefined' || '' === that.model.get( 'mhc_shared_module' ) ) ? this_parent_view : this_view,
					update_template_only = false,
					close_modal = _.isUndefined( close_modal ) ? true : close_modal;


				event.preventDefault();

				// Disabling state and mark it. It takes a while for generating shortcode,
				// so ensure that user doesn't update the page before shortcode generation has completed
				$('#publish').addClass( 'disabled' );

				MH_PageComposer_App.disable_publish = true;

				if ( ( typeof shared_holder_view.model.get( 'shared_parent_cid' ) !== 'undefined' && '' !== shared_holder_view.model.get( 'shared_parent_cid' ) ) || ( typeof shared_holder_view.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== shared_holder_view.model.get( 'mhc_shared_module' ) ) ){
					shared_module_cid = typeof shared_holder_view.model.get( 'shared_parent_cid' ) !== 'undefined' ? shared_holder_view.model.get( 'shared_parent_cid' ) : shared_holder_view.model.get( 'cid' );
				}

				if ( ( typeof that.model.get( 'mhc_template_type' ) !== 'undefined' && 'module' === that.model.get( 'mhc_template_type' ) || '' !== shared_module_cid ) && ( typeof that.model.get( 'mhc_saved_tabs' ) !== 'undefined' ) || ( '' !== this_parent_view && typeof this_parent_view.model.get( 'mhc_saved_tabs' ) !== 'undefined' ) ){
					var selected_tabs_array    = typeof that.model.get( 'mhc_saved_tabs' ) === 'undefined' ? this_parent_view.model.get( 'mhc_saved_tabs' ).split( ',' ) : that.model.get( 'mhc_saved_tabs' ).split( ',' ),
						selected_tabs_selector = '',
						existing_attributes    = that.model.attributes;

					_.each( selected_tabs_array, function ( tab ){
						switch ( tab ){
							case 'general' :
								selected_tabs_selector += '' !== selected_tabs_selector ? ',' : '';
								selected_tabs_selector += '.mhc-options-tab-general input, .mhc-options-tab-general select, .mhc-options-tab-general textarea';
								break;
							case 'advanced' :
								selected_tabs_selector += '' !== selected_tabs_selector ? ',' : '';
								selected_tabs_selector += '.mhc-options-tab-advanced input, .mhc-options-tab-advanced select, .mhc-options-tab-advanced textarea';
								break;
							case 'css' :
								selected_tabs_selector += '' !== selected_tabs_selector ? ',' : '';
								selected_tabs_selector += '.mhc-options-tab-custom_css input, .mhc-options-tab-custom_css select, .mhc-options-tab-custom_css textarea';
								break;
						}
					});

					_.each( existing_attributes, function( value, key ){
						if ( -1 !== key.indexOf( 'mhc_' ) && 'mhc_template_type' !== key && 'mhc_saved_tabs' !== key && 'mhc_shared_module' !== key ){
							that.model.unset( key, { silent : true });
						}
					});

					if ( typeof that.model.get( 'mhc_saved_tabs' ) === 'undefined' ){
						that.model.set( 'mhc_saved_tabs', this_parent_view.model.get( 'mhc_saved_tabs' ) );
					}

					if ( typeof that.model.get( 'mhc_template_type' ) !== 'undefined' && 'module' === that.model.get( 'mhc_template_type' ) ){
						update_template_only = true;
					}
				}

				that.performSaving( selected_tabs_selector );

				if ( '' !== shared_module_cid ){
					mhc_update_shared_template( shared_module_cid );
				}

				// update all module settings only if we're updating not partially saved template
				if ( false === update_template_only && typeof selected_tabs_selector !== 'undefined' ){
					that.performSaving();
				}

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'edited', that.model.get( 'type' ), that.model.get( 'admin_label' ) );

				// In some contexts, closing modal view isn't needed & only settings saving needed
				if ( ! close_modal ){
					return;
				}

				mhc_tinymce_remove_control( 'mhc_content_new' );

				mhc_hide_active_color_picker( that );

				mhc_close_modal_view( that, 'trigger_event' );
			},

			preview : function( event ){
				var cid          = this.model.get( 'cid' ) ,
					shortcode,
					$button      = $( event.target ).is( 'a' ) ? $( event.target ) : $( event.target ).parent( 'a' ),
					$container   = $( event.target ).parents( '.mhc-modal-container' ),
					request_data,
					section_view,
					msie         = document.documentMode;

				event.preventDefault();

				// Save modified settings, if it is necesarry. Direct preview from right click doesn't need to be saved
				if ( _.isUndefined( this.options.triggered_by_right_click ) ){
					this.saveSettings( event, false );
				} else {
					// Triggered by right click is one time thing. Remove it as soon as it has been used
					delete this.options.triggered_by_right_click;
				}

				if ( ! _.isUndefined( this.options.do_preview ) ){
					// Do preview is one time thing. Remove it as soon as it has been used
					delete this.options.do_preview;
				}

				if ( mhc_options.is_mharty_vault === "1" && $.inArray( mhc_options.layout_type, [ "row", "module" ] ) > -1 ){
					// Composer Vault's layout editor auto generates section and row in module and row layout type
					// The auto generates item cause cause an issue during shortcode generation
					// Removing its cid will force MH_PageComposer_App.generateCompleteShortcode to generate the whole page's layout shortcode which solves the preview issue
					cid = undefined;
				} else if ( this.model.get( 'type' ) !== 'section' ){
					// Module's layout depends on the column it belongs. Hence, always preview the item in context of section
					section_view = MH_PageComposer_Layout.getSectionView( this.model.get( 'parent' ) );

					if ( ! _.isUndefined( section_view ) ){
						cid = section_view.model.attributes.cid;
					}
				}

				// Get shortcode based on section's cid
				shortcode = MH_PageComposer_App.generateCompleteShortcode( cid );

				request_data = {
					mhc_preview_nonce : mhc_options.mhc_preview_nonce,
					shortcode           : shortcode,
					post_title          : $('#title').val()
				};

				// Toggle button state
				$button.toggleClass( 'active' );

				// Toggle container state
				$container.toggleClass( 'mhc-item-previewing' );
                $('.mhc_modal_settings_container').toggleClass( 'mhc-window-previewing' );

				if ( $button.hasClass( 'active' ) ){
					// Create the iFrame on the fly. This will speed up modalView init
					var $iframe = $('<iframe />', {
								 	id : 'mhc-preview-screen',
								 	src : mhc_options.preview_url + '&mhc_preview_nonce=' + mhc_options.mhc_preview_nonce
								 }),
						has_render_page = false;

					// Add the iframe into preview tab
					 $('.mhc-preview-tab' ).html( $iframe );

					 // Pass the item's setup to the screen
					 $('#mhc-preview-screen').load(function(){
					 	if ( has_render_page ){
					 		return;
					 	}

					 	// Get iFrame
						preview = document.getElementById( 'mhc-preview-screen' );

						// IE9 below fix. They have postMessage, but it has to be in string
						if ( ! _.isUndefined( msie ) && msie < 10 ){
							request_data = JSON.stringify( request_data );
						}

						// Pass shortcode structure to iFrame to be displayed
						preview.contentWindow.postMessage( request_data, mhc_options.preview_url );

						has_render_page = true;
					 });
				} else {
					$( '.mhc-preview-tab' ).empty();

					// Reset active state
					$('.mhc-preview-screensize-switcher a').removeClass( 'active' );

					// Set desktop as active
					$('.mhc-preview-desktop').addClass( 'active' );
				}
			},

			resizePreviewScreen : function( event ){
				event.preventDefault();

				var $link = $( event.target ),
					width = _.isUndefined( $link.data( 'width' ) ) ? '100%' : $link.data( 'width' );

				// Reset active state
				$('.mhc-preview-screensize-switcher a').removeClass( 'active' );

				// Set current as active
				$link.addClass( 'active' );

				// Set iFrame width
				$('#mhc-preview-screen').animate({
					'width' : width
				});
			},

			performSaving : function( option_tabs_selector ){
				var attributes = {},
					defaults   = {},
					options_selector = typeof option_tabs_selector !== 'undefined' && '' !== option_tabs_selector ? option_tabs_selector : 'input, select, textarea, #mhc_content_main';

				var $mh_form_validation;
				$mh_form_validation = $(this)[0].$el.find('form.validate');
				if ( $mh_form_validation.length ){
					validator = $mh_form_validation.validate();
					if ( !validator.form() ){
						mh_composer_debug_message('failed form validation');
						mh_composer_debug_message('failed elements: ');
						mh_composer_debug_message( validator.errorList );
						validator.focusInvalid();
						return;
					}
					mh_composer_debug_message('passed form validation');
				}

				MH_PageComposer.Events.trigger( 'mh-modal-settings:save', this );

				this.$( options_selector ).each(function(){
					var $this_el = $(this),
						setting_value,
						checked_values = [],
						name = $this_el.is('#mhc_content_main') ? 'mhc_content_new' : $this_el.attr('id'),
						default_value = $this_el.data('default') || '',
						custom_css_option_value;

					// convert default value to string to make sure current and default values have the same type
					default_value = default_value + '';

					// name attribute is used in normal html checkboxes, use it instead of ID
					if ( $this_el.is( ':checkbox' ) ){
						name = $this_el.attr('name');
					}

					if ( typeof name === 'undefined' || ( -1 !== name.indexOf( 'qt_' ) && 'button' === $this_el.attr( 'type' ) ) ){
						// settings should have an ID and shouldn't be a Quick Tag button from the tinyMCE in order to be saved
						return true;
					}

					if ( $this_el.hasClass( 'mhc-helper-field' ) ){
						// don't process helper fields
						return true;
					}

					// All checkbox values are saved at once on the next step, so if the attribute name
					// already exists, do nothing
					if ( $this_el.is( ':checkbox' ) && typeof attributes[name] !== 'undefined' ){
						return true;
					}

					// Validate colorpicker - if invalid color given, return to default color
					if ( $this_el.hasClass( 'mhc-color-picker-hex' ) && new Color( $this_el.val() ).error ){
						$this_el.val( $this_el.data( 'selected-value') );
					}

					// Process all checkboxex for the current setting at once
					if ( $this_el.is( ':checkbox' ) && typeof attributes[name] === 'undefined' ){
						$this_el.closest( '.mhc-option-container' ).find( '[name="' + name + '"]:checked' ).each(function(){
							checked_values.push( $(this).val() );
						});

						setting_value = checked_values.join( "," );
					} else if ( $this_el.is( '#mhc_content_main' ) ){
						// Process main content

						setting_value = $this_el.html();

						// Replace temporary ^^ signs with double quotes
						setting_value = setting_value.replace( /\^\^/g, '%22' );
					} else if ( $this_el.closest( '.mhc-custom-css-option' ).length ){
						// Custom CSS settings content should be modified before it is added to the shortcode attribute

						custom_css_option_value = $this_el.val();

						// replace new lines with || in Custom CSS settings
						setting_value = '' !== custom_css_option_value ? custom_css_option_value.replace( /\n/g, '\|\|' ) : '';
                        
					} else if ( $this_el.hasClass( 'mhc-range-input' ) || $this_el.hasClass( 'mhc-validate-unit' ) ){
						// Process range sliders. Sanitize for valid unit first
						var mh_validate_default_unit = $this_el.hasClass( 'mhc-range-input' ) ? 'no_default_unit' : '';
						setting_value = mhc_sanitize_input_unit_value( $this_el.val(), false, mh_validate_default_unit );
                        
					} else if ( ! $this_el.is( ':checkbox' ) ){
						// Process all other settings: inputs, textarea#mhc_content_new, range sliders etc.

						setting_value = $this_el.is('textarea#mhc_content_new')
							? mhc_get_content( 'mhc_content_new' )
							: $this_el.val();

						if ( $this_el.hasClass( 'mhc-range-input' ) && setting_value === 'px' ){
							setting_value = '';
						}
					}

					// if default value is set, add it to the defaults object
					if ( default_value !== '' ){
						defaults[ name ] = default_value;
					}

					// save the attribute value
					attributes[name] = setting_value;
				});

				// add defaults object
				attributes['module_defaults'] = defaults;

				// set model attributes
				this.model.set( attributes );
			},

			saveTemplate : function( event ){
				var module_width = -1 !== this.model.get( 'module_type' ).indexOf( 'fullwidth' ) ? 'fullwidth' : 'regular',
					columns_layout = typeof this.model.get( 'columns_layout' ) !== 'undefined' ? this.model.get( 'columns_layout' ) : '0';
				event.preventDefault();

				mhc_create_prompt_modal( 'save_template', this, module_width, columns_layout );
			},

			removeOverlay : function(){
				var $overlay = $( '.mhc_modal_overlay' );
				if ( $overlay.length ){

					$overlay.addClass( 'mhc_overlay_closing' );

					setTimeout(function(){
						$overlay.remove();

						$( 'body' ).removeClass( 'mhc_stop_scroll' );
					}, 600 );
				}

				// Check for existence of disable_publish element, don't do auto enable publish
				// if not necesarry. Example: opening Modal View, then close it without further action
				if ( ! _.isUndefined( MH_PageComposer_App.disable_publish ) ){
					var auto_enable_publishing = setTimeout(function(){

						// Check for disable_publish state, auto enable after three seconds
						// This means no mhc_set_content triggered
						if ( ! _.isUndefined( MH_PageComposer_App.disable_publish ) ){
							$('#publish').removeClass( 'disabled' );

							delete MH_PageComposer_App.disable_publish;
						}
					}, 3000 );
				}
			},

			applyFilter : function(){
				var $event_target = $(event.target),
					all_data = $event_target.data( 'attr' ),
					selected_category = $event_target.val();
				all_data.append_to.html( '' );
				generate_templates_view( all_data.include_shared, '', all_data.layout_type, all_data.append_to, all_data.module_width, all_data.specialty_cols, selected_category );
			}

		});

		MH_PageComposer.ColumnView = window.wp.Backbone.View.extend({
			template : _.template( $('#mh-composer-column-template').html() ),

			events : {
				'click .mhc-insert-module' : 'addModule',
				'contextmenu > .mhc-insert-module' : 'showRightClickOptions',
				'click' : 'hideRightClickOptions'
			},

			initialize : function(){
				this.$el.attr( 'data-cid', this.model.get( 'cid' ) );
			},

			render : function(){
				var this_el = this,
					is_fullwidth_section = this.model.get( 'module_type' ) === 'section' && this.model.get( 'mhc_fullwidth' ) === 'on',
					connect_with = ( ! is_fullwidth_section ? ".mhc-column:not(.mhc-column-specialty, .mhc_parent_locked)" : ".mhc_fullwidth_sortable_area" );

				this.$el.html( this.template( this.model.toJSON() ) );

				if ( is_fullwidth_section )
					this.$el.addClass( 'mhc_fullwidth_sortable_area' );

				if ( this.model.get( 'layout_specialty' ) === '1' ){
					connect_with = '.mhc-column-specialty:not(.mhc_parent_locked)';
				}

				if ( this.model.get( 'created' ) === 'manually' && ! _.isUndefined( this.model.get( 'mhc_specialty_columns' ) ) ){
					this.$el.addClass( 'mhc-column-specialty' );
				}

				if ( this.isColumnParentLocked( this.model.get( 'parent' ) ) ){
					this.$el.addClass( 'mhc_parent_locked' );
					this.model.set( 'mhc_parent_locked', 'on', { silent : true });
				}

				this.$el.sortable({
					cancel : '.mhc-settings, .mhc-clone, .mhc-remove, .mhc-insert-module, .mhc-insert-column, .mhc_locked, .mhc-disable-sort',
					connectWith: connect_with,
                    delay: 100,
					items : ( this.model.get( 'layout_specialty' ) !== '1' ? '.mhc_module_block' : '.mhc_row' ),
					receive: function(event, ui){
						var $this = $(this),
							columns_number,
							cancel_action = false;

						if ( $this.hasClass( 'mhc-column-specialty' ) ){
							// revert if the last row is being dragged out of the specialty section
							// or the module block is placed directly into the section
							// or 3-column row is placed into the row that can't handle it
							if ( ! $( ui.sender ).find( '.mhc_row' ).length || $( ui.item ).is( '.mhc_module_block' ) ){
								alert( mhc_options.section_only_row_dragged_away );
								cancel_action = true;
							} else {
								columns_number = $(ui.item).find( '.mhc-row-container > .mhc-column' ).length;

								if ( columns_number === 3 && parseInt( MH_PageComposer_Layout.getView( $this.data( 'cid' ) ).model.get( 'specialty_columns' ) ) !== 3 ){
									alert( mhc_options.stop_dropping_3_col_row );
									cancel_action = true;
								}
							}
						}

						// do not allow to drag modules into sections and rows where sorting is disabled
						if ( $( ui.item ).closest( '.mhc-disable-sort').length ){
							cancel_action = true;
						}

						if ( ( $( ui.item ).closest( '.mhc_section.mhc_shared' ).length || $( ui.item ).closest( '.mhc_row.mhc_shared' ).length ) && $( ui.item ).hasClass( 'mhc_shared' ) ){
							alert( mhc_options.shared_module_alert );
							cancel_action = true;
						} else if ( ( $( ui.item ).closest( '.mhc_section.mhc_shared' ).length || $( ui.item ).closest( '.mhc_row.mhc_shared' ).length || $( ui.sender ).closest( '.mhc_row.mhc_shared' ).length || $( ui.sender ).closest( '.mhc_section.mhc_shared' ).length ) && '' === mhc_options.template_post_id ){
							var module_cid = ui.item.data( 'cid' ),
								model,
								shared_module_cid,
								$moving_from,
								$moving_to;

							$moving_from = $( ui.sender ).closest( '.mhc_row.mhc_shared' ).length ? $( ui.sender ).closest( '.mhc_row.mhc_shared' ) : $( ui.sender ).closest( '.mhc_section.mhc_shared' );
							$moving_to = $( ui.item ).closest( '.mhc_row.mhc_shared' ).length ? $( ui.item ).closest( '.mhc_row.mhc_shared' ) : $( ui.item ).closest( '.mhc_section.mhc_shared' );


							if ( $moving_from === $moving_to ){
								model = this_el.collection.find(function( model ){
									return model.get('cid') == module_cid;
								});

								shared_module_cid = model.get( 'shared_parent_cid' );

								mhc_update_shared_template( shared_module_cid );
								mh_reinitialize_composer_layout();
							} else {
								var $shared_element = $moving_from;
								for ( var i = 1; i <= 2; i++ ){
									shared_module_cid = typeof $shared_element.find( '.mhc-section-content' ).data( 'cid' ) !== 'undefined' ? $shared_element.find( '.mhc-section-content' ).data( 'cid' ) : $shared_element.find( '.mhc-row-content' ).data( 'cid' );

									if ( typeof shared_module_cid !== 'undefined' && '' !== shared_module_cid ){

										mhc_update_shared_template( shared_module_cid );
										mh_reinitialize_composer_layout();
									}

									$shared_element = $moving_to;
								};
							}
						}

						if ( cancel_action ){
							$(ui.sender).sortable('cancel');
							mh_reinitialize_composer_layout();
						}
					},
					update : function( event, ui ){
						var model,
							$module_block,
							module_cid = ui.item.data( 'cid' );

						$module_block = $( ui.item );

						if ( typeof module_cid === 'undefined' && $(event.target).is('.mhc-column-specialty') ){
							$module_block = $( ui.item ).closest( '.mhc_row' ).find( '.mhc-row-content' );

							module_cid = $module_block.data( 'cid' );
						}

						// if the column doesn't have modules, add the dragged module before 'Insert Module' button or append to column
						if ( ! $(event.target).is('.mhc-column-specialty') && $( ui.item ).closest( event.target ).length && $( event.target ).find( '.mhc_module_block' ).length === 1 ){
							// if .mhc-insert-module button exists, then add the module before that button. Otherwise append to column
							if ( $( event.target ).find( '.mhc-insert-module' ).length ){
								$module_block.insertBefore( $( event.target ).find( '.mhc-insert-module' ) );
							} else {
								$( event.target ).append( $module_block );
							}
						}

						model = this_el.collection.find(function( model ){
							return model.get('cid') == module_cid;
						});

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'moved', 'module', model.get( 'admin_label' ) );

						if ( model.get( 'parent' ) === this_el.model.attributes.cid && $( ui.item ).closest( event.target ).length ){
							// order of items have been changed within the same row

							MH_PageComposer_Events.trigger( 'mh-model-changed-position-within-column' );
						} else {
							model.set( 'parent', this_el.model.attributes.cid );
						}

						// Prepare collection sorting based on layout position
						var column_cid             = parseInt( $(this).attr( 'data-cid') ),
							sibling_module_index   = 0;

						// Loop module block based on DOM position to ensure its index order
						$(this).find('.mhc_module_block').each(function(){
							sibling_module_index++;

							var sibling_module_cid = parseInt( $(this).data('cid') ),
								layout_index       = column_cid + sibling_module_index,
								sibling_model      = MH_PageComposer_Modules.findWhere({ cid : sibling_module_cid });

							// Set layout_index
							sibling_model.set({ layout_index : layout_index });
						});

						// Sort collection based on layout_index
						MH_PageComposer_Modules.comparator = 'layout_index';
						MH_PageComposer_Modules.sort();
					},
					start : function( event, ui ){
						mhc_close_all_right_click_options();
					}
				});

				return this;
			},

			addModule : function( event ){
				var $event_target = $(event.target),
					$add_module_button = $event_target.is( 'span' ) ? $event_target.parent('.mhc-insert-module') : $event_target;

				event.preventDefault();
				event.stopPropagation();

				if ( this.isColumnLocked() )
					return;

				if ( ! $add_module_button.parent().is( event.delegateTarget ) ){
					return;
				}

				mhc_close_all_right_click_options();

				var view;

				view = new MH_PageComposer.ModalView({
					model : this.model,
					collection : this.collection,
					attributes : {
						'data-open_view' : 'all_modules'
					},
					view : this
				});

				$('body').append( view.render().el );
			},

			// Add New Row functionality for the specialty section column
			addRow : function( appendAfter ){
				var module_id = MH_PageComposer_Layout.generateNewId(),
					shared_parent = typeof this.model.get( 'mhc_shared_parent' ) !== 'undefined' && '' !== this.model.get( 'mhc_shared_parent' ) ? this.model.get( 'mhc_shared_parent' ) : '',
					shared_parent_cid = '' !== shared_parent ? this.model.get( 'shared_parent_cid' ) : '',
					new_row_view;

				if ( this.isColumnLocked() ){
					return;
				}

				this.collection.add( [ {
					type : 'row',
					module_type : 'row',
					cid : module_id,
					parent : this.model.get( 'cid' ),
					view : this,
					appendAfter : appendAfter,
					mhc_shared_parent : shared_parent,
					shared_parent_cid : shared_parent_cid,
					admin_label : mhc_options.noun['row']
				} ] );

				new_row_view = MH_PageComposer_Layout.getView( module_id );
				new_row_view.displayColumnsOptions();
			},

			removeColumn : function(){
				var modules;

				modules = MH_PageComposer_Layout.getChildViews( this.model.get('cid') );

				_.each( modules, function( module ){
					if ( module.model.get( 'type' ) === 'row' || module.model.get( 'type' ) === 'row_inner' ){
						module.removeRow();
					} else {
						module.removeModule();
					}
				});

				MH_PageComposer_Layout.removeView( this.model.get('cid') );

				this.model.destroy();

				this.remove();
			},

			isColumnLocked : function(){
				if ( 'on' === this.model.get( 'mhc_locked' ) || 'on' === this.model.get( 'mhc_parent_locked' ) ){
					return true;
				}

				return false;
			},

			isColumnParentLocked : function( cid ){
				var parent_view = MH_PageComposer_Layout.getView( cid );

				if ( ! _.isUndefined( parent_view ) && ( 'on' === parent_view.model.get('mhc_locked' ) || 'on' === parent_view.model.get('mhc_parent_locked' ) ) ){
					return true;
				}

				return false;
			},

			showRightClickOptions : function( event ){
				event.preventDefault();

				var mh_right_click_options_view,
					view_settings = {
						model      : this.model,
						view       : this.$el,
						view_event : event
					};

				// Fullwidth and regular section uses different type for column ( section vs column )
				// Add marker so it can be identified
				view_settings.model.attributes.is_insert_module = true;

				mh_right_click_options_view = new MH_PageComposer.RightClickOptionsView( view_settings );

				return;
			},

			hideRightClickOptions : function( event ){
				event.preventDefault();

				mhc_close_all_right_click_options();
			}
		});

		MH_PageComposer.ColumnSettingsView = window.wp.Backbone.View.extend({

			className : 'mhc_modal_settings',

			template : _.template( $('#mh-composer-column-settings-template').html() ),

			events : {
				'click .mhc-column-layouts li' : 'addColumns',
				'click .mhc-options-tabs-links li a' : 'switchTab'
			},

			initialize : function( attributes ){
				this.listenTo( MH_PageComposer_Events, 'mh-add:columns', this.removeView );

				this.listenTo( MH_PageComposer_Events, 'mh-modal-view-removed', this.removeViewAndEmptySection );

				this.options = attributes;
			},

			render : function(){
				this.$el.html( this.template( this.model.toJSON() ) );

				if ( MH_PageComposer_Layout.getView( this.model.get('cid') ).$el.closest( '.mhc_shared' ).length ){
					this.$el.addClass( 'mhc_no_shared' );
				}

				if ( typeof this.model.get( 'mhc_specialty' ) !== 'undefined' && 'on' === this.model.get( 'mhc_specialty' ) || typeof this.model.get( 'change_structure' ) !== 'undefined' && 'true' === this.model.get( 'change_structure' ) ){
					this.$el.addClass( 'mhc_modal_no_tabs' );
				}

				return this;
			},

			addColumns : function( event ){
				event.preventDefault();

				var that = this,
					$layout_el = $(event.target).is( 'li' ) ? $(event.target) : $(event.target).closest( 'li' ),
					layout = $layout_el.data('layout').split(','),
					layout_specialty = 'section' === that.model.get( 'type' ) && 'on' === that.model.get( 'mhc_specialty' )
						? $layout_el.data('specialty').split(',')
						: '',
					layout_elements_num = _.size( layout ),
					this_view = this.options.view;

				if ( typeof that.model.get( 'change_structure' ) !== 'undefined' && 'true' === that.model.get( 'change_structure' ) ){
					var row_columns = MH_PageComposer_Layout.getChildViews( that.model.get( 'cid' ) ),
						columns_structure_old = [],
						index_count = 0,
						shared_module_cid = typeof that.model.get( 'shared_parent_cid' ) !== 'undefined' ? that.model.get( 'shared_parent_cid' ) : '';

					_.each( row_columns, function( row_column ){
						columns_structure_old[index_count] = row_column.model.get( 'cid' );
						index_count = index_count + 1;
					});
				}

				_.each( layout, function( element, index ){
					var update_content = layout_elements_num == ( index + 1 )
						? 'true'
						: 'false',
						column_attributes = {
							type : 'column',
							cid : MH_PageComposer_Layout.generateNewId(),
							parent : that.model.get( 'cid' ),
							layout : element,
							view : this_view
						}

					if ( typeof that.model.get( 'mhc_shared_parent' ) !== 'undefined' && '' !== that.model.get( 'mhc_shared_parent' ) ){
						column_attributes.mhc_shared_parent = that.model.get( 'mhc_shared_parent' );
						column_attributes.shared_parent_cid = that.model.get( 'shared_parent_cid' );
					}

					if ( '' !== layout_specialty ){
						column_attributes.layout_specialty = layout_specialty[index];
						column_attributes.specialty_columns = parseInt( $layout_el.data('specialty_columns') );
					}

					if ( typeof that.model.get( 'specialty_row' ) !== 'undefined' ){
						that.model.set( 'module_type', 'row_inner', { silent : true });
						that.model.set( 'type', 'row_inner', { silent : true });
					}

					that.collection.add( [ column_attributes ], { update_shortcodes : update_content });
				});

				if ( typeof that.model.get( 'change_structure' ) !== 'undefined' && 'true' === that.model.get( 'change_structure' ) ){
					var columns_structure_new = [];

					row_columns = MH_PageComposer_Layout.getChildViews( that.model.get( 'cid' ) );
					index_count = 0;

					_.each( row_columns, function( row_column ){
						columns_structure_new[index_count] = row_column.model.get( 'cid' );
						index_count = index_count + 1;
					});

					// delete old columns IDs
					columns_structure_new.splice( 0, columns_structure_old.length );

					for	( index = 0; index < columns_structure_old.length; index++ ){
						var is_extra_column = ( columns_structure_old.length > columns_structure_new.length ) && ( index > ( columns_structure_new.length - 1 ) ) ? true : false,
							old_column_cid = columns_structure_old[index],
							new_column_cid = is_extra_column ? columns_structure_new[columns_structure_new.length-1] : columns_structure_new[index],
							column_html = MH_PageComposer_Layout.getView( old_column_cid ).$el.html(),
							modules = MH_PageComposer_Layout.getChildViews( old_column_cid ),
							$updated_column,
							column_html_old = '';

						MH_PageComposer_Layout.getView( old_column_cid ).model.destroy();

						MH_PageComposer_Layout.getView( old_column_cid ).remove();

						MH_PageComposer_Layout.removeView( old_column_cid );

						$updated_column = $('.mhc-column[data-cid="' + new_column_cid + '"]');

						if ( ! is_extra_column ){
							$updated_column.html( column_html );
						} else {
							$updated_column.find( '.mhc-insert-module' ).remove();

							column_html_old = $updated_column.html();

							$updated_column.html( column_html_old + column_html );
						}

						_.each( modules, function( module ){
							module.model.set( 'parent', new_column_cid, { silent : true });
						});
					}

					// Enable history saving and set meta for history
					MH_PageComposer_App.allowHistorySaving( 'edited', 'column' );

					mh_reinitialize_composer_layout();
				}

				if ( typeof that.model.get( 'template_type' ) !== 'undefined' && 'section' === that.model.get( 'template_type' ) && 'on' === that.model.get( 'mhc_specialty' ) ){
					mh_reinitialize_composer_layout();
				}

				if ( typeof that.model.get( 'mhc_template_type' ) !== 'undefined' && 'row' === that.model.get( 'mhc_template_type' ) ){
					mh_add_template_meta( '_mhc_row_layout', $layout_el.data( 'layout' ) );
				}

				if ( typeof shared_module_cid !== 'undefined' && '' !== shared_module_cid ){
					mhc_update_shared_template( shared_module_cid );
				}

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'added', 'column' );

				MH_PageComposer_Events.trigger( 'mh-add:columns' );
			},

			removeView : function(){
				var that = this;

				// remove it with some delay to make sure animation applied to modal before removal
				setTimeout(function(){
					that.remove();
				}, 300 );
			},

			switchTab : function( event ){
				var $this_el = $( event.currentTarget ).parent();

				event.preventDefault();

				mh_handle_templates_switching( $this_el, 'row', '' );
			},

			/**
			 * Remove modal view and empty specialty section, if the user hasn't selected a section layout
			 * and closed a modal window
			 */
			removeViewAndEmptySection : function(){
				if ( this.model.get( 'mhc_specialty' ) === 'on' ){
					this.options.view.model.destroy();

					MH_PageComposer_Layout.removeView( this.options.view.model.get('cid') );

					this.options.view.remove();
				}

				this.remove();
			}

		});

		MH_PageComposer.SaveLayoutSettingsView = window.wp.Backbone.View.extend({

			className : 'mhc_modal_settings',

			template : _.template( $('#mh-composer-load_layout-template').html() ),

			events : {
				'click .mhc_layout_button_load' : 'loadLayout',
				'click .mhc_layout_button_delete' : 'deleteLayout',
				'click .mhc-options-tabs-links li a' : 'switchTab'
			},

			initialize : function( attributes ){
				this.options = attributes;

				this.layoutIsLoading = false;

				this.listenTo( MH_PageComposer_Events, 'mh-modal-view-removed', this.remove );
			},

			render : function(){
				var $this_el = this.$el,
					post_type = $('#post_type').val();

				$this_el.html( this.template({ "display_switcher" : "on" }) );

				mh_load_saved_layouts( 'preset', 'mhc-all-modules-tab', $this_el, post_type );
				mh_load_saved_layouts( 'not_preset', 'mhc-saved-modules-tab', $this_el, post_type );

				return this;
			},

			deleteLayout : function( event ){
				event.preventDefault();

				var $layout = $( event.currentTarget ).closest( 'li' );

				if ( $layout.hasClass( 'mhc_deleting_layout' ) )
					return;
				else
					$layout.addClass( 'mhc_deleting_layout' );

				$.ajax({
					type: "POST",
					url: mhc_options.ajaxurl,
					data:
					{
						action : 'mhc_delete_layout',
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mh_layout_id : $layout.data( 'layout_id' )
					},
					beforeSend : function(){
						MH_PageComposer_Events.trigger( 'mhc-loading:started' );

						$layout.css( 'opacity', '0.5' );
					},
					complete : function(){
						MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
					},
					success: function( data ){
						if ( $layout.closest( 'ul' ).find( '> li' ).length == 1 )
							$layout.closest( 'ul' ).prev( 'h3' ).hide();

						$layout.remove();
					}
				});
			},

			loadLayout : function( event ){
				event.preventDefault();

				if ( this.layoutIsLoading ){
					return;
				} else {
					this.layoutIsLoading = true;

					this.$el.find( '.mhc-main-settings' ).css({ 'opacity' : '0.5' });
				}

				var $layout = $( event.currentTarget ).closest( 'li' ),
					replace_content = $layout.closest( '.mhc-main-settings' ).find( '#mhc_load_layout_replace' ).is( ':checked' ),
					content = mhc_get_content( 'content' ),
					this_el = this;

				$.ajax({
					type: "POST",
					url: mhc_options.ajaxurl,
					data:
					{
						action : 'mhc_load_layout',
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mh_layout_id : $layout.data( 'layout_id' ),
						mh_replace_content : ( replace_content ? 'on' : 'off' )
					},
					beforeSend : function(){
						MH_PageComposer_Events.trigger( 'mhc-loading:started' );
					},
					complete : function(){
						MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
						MH_PageComposer_Events.trigger( 'mh-saved_layout:loaded' );
					},
					success: function( data ){
						content = replace_content ? data : data + content;

						MH_PageComposer_App.removeAllSections();

						if ( content !== '' ){
							MH_PageComposer_App.allowHistorySaving( 'loaded', 'layout' );
						}

						MH_PageComposer_App.createNewLayout( content, 'load_layout' );
					}
				});
			},

			switchTab: function( event ){
				var $this_el = $( event.currentTarget ).parent();
				event.preventDefault();

				mh_handle_templates_switching( $this_el, 'layout', '' );
			}

		});

		MH_PageComposer.ModulesView = window.wp.Backbone.View.extend({

			className : 'mhc_modal_settings',

			template : _.template( $('#mh-composer-modules-template').html() ),

			events : {
				'click .mhc-all-modules li' : 'addModule',
				'click .mhc-options-tabs-links li a' : 'switchTab'
			},

			initialize : function( attributes ){
				this.options = attributes;

				this.listenTo( MH_PageComposer_Events, 'mh-modal-view-removed', this.remove );
			},

			render : function(){
				var template_type_holder = typeof MH_PageComposer_Layout.getView( this.model.get('parent') ) !== 'undefined' ? MH_PageComposer_Layout.getView( this.model.get('parent') ) : this;
				this.$el.html( this.template( MH_PageComposer_Layout.toJSON() ) );

				if ( MH_PageComposer_Layout.getView( this.model.get('cid') ).$el.closest( '.mhc_shared' ).length || typeof template_type_holder.model.get('mhc_template_type') !== 'undefined' && 'module' === template_type_holder.model.get('mhc_template_type') ){
					this.$el.addClass( 'mhc_no_shared' );
				}

				return this;
			},

			addModule : function( event ){
				var $this_el             = $( event.currentTarget ),
					label                = $this_el.find( '.mh_module_title' ).text(),
					type                 = $this_el.attr( 'class' ).replace( ' mhc_fullwidth_only_module', '' ),
					shared_module_cid    = '',
					parent_view          = MH_PageComposer_Layout.getView( this.model.get('parent') ),
					template_type_holder = typeof parent_view !== 'undefined' ? parent_view : this

				event.preventDefault();

				if ( typeof this.model.get( 'mhc_shared_parent' ) !== 'undefined' && typeof this.model.get( 'mhc_shared_parent' ) !== '' ){
					shared_module_cid = this.model.get( 'shared_parent_cid' );
				}

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'added', 'module', label );

				this.collection.add( [ {
					type : 'module',
					cid : MH_PageComposer_Layout.generateNewId(),
					module_type : type,
					admin_label : label,
					parent : this.attributes['data-parent_cid'],
					view : this.options.view,
					shared_parent_cid : shared_module_cid
				} ] );

				this.remove();

				if ( '' !== shared_module_cid ){
					mhc_update_shared_template( shared_module_cid );
				}

				if ( typeof template_type_holder.model.get( 'mhc_template_type' ) !== 'undefined' && 'module' === template_type_holder.model.get( 'mhc_template_type' ) ){
					mh_add_template_meta( '_mhc_module_type', type );
				}

				mhc_open_current_tab();
			},

			switchTab : function( event ){
				var $this_el = $( event.currentTarget ).parent(),
					module_width = typeof this.model.get( 'mhc_fullwidth' ) && 'on' === this.model.get( 'mhc_fullwidth' ) ? 'fullwidth' : 'regular';

				event.preventDefault();

				mh_handle_templates_switching( $this_el, 'module', module_width );
			}

		});

		MH_PageComposer.ModuleSettingsView = window.wp.Backbone.View.extend({

			className : 'mhc_module_settings',

			initialize : function(){
                if ( ! $( MH_PageComposer_Layout.generateTemplateName( this.attributes['data-module_type'] ) ).length ){
					this.attributes['data-no_template'] = 'no_template';
					return;
				}
                
				this.template = _.template( $( MH_PageComposer_Layout.generateTemplateName( this.attributes['data-module_type'] ) ).html() );
				this.listenTo( MH_PageComposer_Events, 'mh-modal-view-removed', this.removeModule );
				this.listenTo( MH_PageComposer_Events, 'mh-advanced-module:saved', this.renderMap );
			},

			events : {
			},

			render : function(){
				var $this_el = this.$el,
					content = '',
                    this_module_cid = this.model.attributes.cid,
					$content_textarea,
					$content_textarea_container,
					$content_textarea_option,
					advanced_mode = false,
					view,
					$color_picker,
					$upload_button,
					$video_image_button,
					$gallery_button,
					$icon_font_list,
					$mh_affect_fields,
					$mh_form_validation,
					$icon_font_options = [ "mhc_overlay_icon", "mhc_font_mhicons", "mhc_font_steadysets", "mhc_font_awesome", "mhc_font_lineicons", "mhc_font_etline", "mhc_font_icomoon", "mhc_font_linearicons" ];

				// Replace encoded double quotes with normal quotes,
				// escaping is applied in modules templates
				_.each( this.model.attributes, function( value, key, list ){
                    if ( typeof value === 'string' && key !== 'mhc_content_new' && -1 === $.inArray( key, $icon_font_options ) && ! /^\%\%\d+\%\%$/.test( $.trim( value ) ) ) {
						return list[ key ] = value.replace( /%22/g, '"' );
                    }
				});

				this.$el.html( this.template( this.model.attributes ) );

				$content_textarea = this.$el.find( '#mhc_content_new' );

				$color_picker = this.$el.find('.mhc-color-picker-hex');

				$color_picker_alpha = this.$el.find('.mh-composer-color-picker-alpha');

				$upload_button = this.$el.find('.mhc-upload-button');

				$video_image_button = this.$el.find('.mhc-video-image-button');

				$gallery_button = this.$el.find('.mhc-gallery-button');

				$time_picker = this.$el.find('.mhc-date-time-picker');

				$icon_font_list = this.$el.find('.mhc-icon');

				$validation_element = $this_el.find('.mh-validate-number');

				$mh_form_validation = $this_el.find('form.validate');

				// validation
				if ( $mh_form_validation.length ){
					mh_composer_debug_message('validation enabled');
					$mh_form_validation.validate({
						debug: true
					});
				}

				if ( $color_picker.length ){
					$color_picker.wpColorPicker({
						defaultColor : $color_picker.data('default-color'),
                        palettes : mhc_options.default_color_scheme.split( '|' ),
						change       : function( event, ui ){
							var $this_el      = $(this),
								$reset_button = $this_el.closest( '.mhc-option-container' ).find( '.mhc-reset-setting' ),
								$custom_color_container = $this_el.closest( '.mhc-custom-color-container' ),
								current_value = $this_el.val(),
								default_value;

							if ( $custom_color_container.length ){
								$custom_color_container.find( '.mhc-custom-color-picker' ).val( ui.color.toString() );
							}

							if ( ! $reset_button.length ){
								return;
							}

							default_value = mhc_get_default_setting_value( $this_el );

							if ( current_value !== default_value ){
								$reset_button.addClass( 'mhc-reset-icon-visible' );
							} else {
								$reset_button.removeClass( 'mhc-reset-icon-visible' );
							}
						},
						clear: function(){
							$(this).val( mhc_options.invalid_color );
                            //$(this).siblings('.mhc-main-setting').data('selected-value', '');
                            $(this).closest( '.mhc-option-container' ).find( '.mhc-main-setting' ).val( '' );
						}
					});

                    $color_picker.each(function(){
						var $this = $(this),
							default_color = $this.data('default-color') || '',
							$reset_button = $this.closest( '.mhc-option-container' ).find( '.mhc-reset-setting' );

						if ( ! $reset_button.length ){
							return true;
						}

						if ( default_color !== $this.val() ){
							$reset_button.addClass( 'mhc-reset-icon-visible' );
						}
					}); //end
				}

				if ( $color_picker_alpha.length ){
					$color_picker_alpha.each(function(){
						var $this_color_picker_alpha = $(this),
							color_picker_alpha_val = $this_color_picker_alpha.data('value').split('|'),
							color_picker_alpha_hex = color_picker_alpha_val[0] || '#444444',
							color_picker_alpha_opacity = color_picker_alpha_val[2] || 1.0;

						$this_color_picker_alpha.attr('data-opacity', color_picker_alpha_opacity );
						$this_color_picker_alpha.val( color_picker_alpha_hex );

						$this_color_picker_alpha.minicolors({
							control: 'hue',
							defaultValue: $(this).data('default-color') || '',
							opacity: true,
							changeDelay: 200,
							show: function(){
								$this_color_picker_alpha.minicolors('opacity', $this_color_picker_alpha.data('opacity') );
							},
							change: function(hex, opacity){
								if( !hex ){
									return;
								}

								var rgba_object = $this_color_picker_alpha.minicolors('rgbObject'),
									$field = $( $this_color_picker_alpha.data('field') ),
									values = [],
									values_string;

								values.push( hex );
								values.push( rgba_object.r + ', ' + rgba_object.g + ', ' + rgba_object.b );
								values.push( opacity );

								values_string = values.join('|');

								if ( $field.length ){
									$field.val( values_string );
								}
							},
							theme: 'bootstrap'
						});
					});
				}

				if ( $upload_button.length ){
					mhc_activate_upload( $upload_button );
				}

				if ( $video_image_button.length ){
					mhc_generate_video_image( $video_image_button );
				}

				if ( $gallery_button.length ){
					mhc_activate_gallery( $gallery_button );
				}

				if ( $time_picker.length ){
					$time_picker.datetimepicker();
				}

				if( $validation_element.length ){
					$validation_element.keyup(function(){
						var $this_el = $( this );

						if ( $this_el.val() < 0 || ( !$.isNumeric( $this_el.val() ) && $this_el.val() !== '' ) ){
							$this_el.val( 0 );
						}

						if ( $this_el.val() > 100 ){
							$this_el.val( 100 );
						}

						if ( $this_el.val() !=='' ){
							$this_el.val( Math.round( $this_el.val() ) );
						}
					});
				}

				if ( $icon_font_list.length ){
					var that = this;
					$icon_font_list.each(function(){
						var $this_icon_list     = $( this ),
							$icon_font_field    = $this_icon_list.siblings('.mhc-font-icon'),
							current_symbol_val  = $.trim( $icon_font_field.val() ),
							$icon_font_symbols  = $this_icon_list.find( 'li' ),
							active_symbol_class = 'mh_active',
							$current_symbol,
							top_offset,
							icon_index_number;

						function mhc_icon_font_init(){
							if ( current_symbol_val !== '' ){
								// font icon index is used now in the following format: %%index_number%%
								if ( current_symbol_val.search( /^%%/ ) !== -1 ){
									icon_index_number = parseInt( current_symbol_val.replace( /%/g, '' ) );
									$current_symbol   = $this_icon_list.find( 'li' ).eq( icon_index_number );
								} else {
									$current_symbol = $this_icon_list.find( 'li[data-icon="' + current_symbol_val + '"]' );
								}

								$current_symbol.addClass( active_symbol_class );

								if ( $this_icon_list.is( ':visible' ) ){
									setTimeout(function(){
										top_offset = $current_symbol.offset().top - $this_icon_list.offset().top;

										if ( top_offset > 0 ){
											$this_icon_list.animate({ scrollTop : top_offset }, 0 );
										}
									}, 110 );
								}
							}
						}
						mhc_icon_font_init();

						that.$el.find( '.mhc-options-tabs-links' ).on( 'mhc_main_tab:changed', mhc_icon_font_init );

						$icon_font_symbols.click(function(){
							var $this_element = $(this),
								this_symbol   = $this_element.index();

							if ( $this_element.hasClass( active_symbol_class ) ){
								return false;
							}

							$this_element.siblings( '.' + active_symbol_class ).removeClass( active_symbol_class ).end().addClass( active_symbol_class );

							this_symbol = '%%' + this_symbol + '%%';

							$icon_font_field.val( this_symbol );
						});
					});
				}

				if ( $content_textarea.length ){
					$content_textarea_option = $content_textarea.closest( '.mhc-option' );

					if ( $content_textarea_option.hasClass( 'mhc-option-advanced-module' ) )
						advanced_mode = true;

					if ( ! advanced_mode ){
						$content_textarea_container = $content_textarea.closest( '.mhc-option-container' );

						content = $content_textarea.html();

						$content_textarea.remove();

						$content_textarea_container.prepend( mhc_content_html );

						setTimeout(function(){
							if ( typeof window.switchEditors !== 'undefined' ){
								window.switchEditors.go( 'mhc_content_new', mh_get_editor_mode() );
							}

							mhc_set_content( 'mhc_content_new', content );

							window.wpActiveEditor = 'mhc_content_new';
						}, 100 );
					} else {
						var view_cid = MH_PageComposer_Layout.generateNewId();
						this.view_cid = view_cid;

						$content_textarea_option.hide();

						$content_textarea.attr( 'id', 'mhc_content_main' );

						view = new MH_PageComposer.AdvancedModuleSettingsView({
							model : this,
							el : this.$el.find( '.mhc-option-advanced-module-settings' ),
							attributes : {
								cid : view_cid
							}
						});

						MH_PageComposer_Layout.addView( view_cid, view );

						$content_textarea_option.before( view.render() );

						if ( $content_textarea.html() !== '' ){
							view.generateAdvancedSortableItems( $content_textarea.html(), this.$el.find( '.mhc-option-advanced-module-settings' ).data( 'module_type' ) );
                            MH_PageComposer_Events.trigger( 'mh-advanced-module:updated_order', this.$el );
						}
					}
				}

				this.renderMap();

				mhc_init_main_settings( this.$el, this_module_cid );

				if ( ! advanced_mode ){
					setTimeout(function(){
						$this_el.find('select, input, textarea, radio').filter(':eq(0)').focus();
					}, 1 );
				}

				return this;
			},

			removeModule : function(){
				// remove Module settings, when modal window is closed or saved

				this.remove();
			},
            
            is_latlng : function( address ){
				var latlng = address.split( ',' ),
					lat = ! _.isUndefined( latlng[0] ) ? parseFloat( latlng[0] ) : false,
					lng = ! _.isUndefined( latlng[1] ) ? parseFloat( latlng[1] ) : false;

				if ( lat && ! _.isNaN( lat ) && lng && ! _.isNaN( lng ) ){
					return new google.maps.LatLng( lat, lng );
				}

				return false;
			},

			renderMap: function(){
                this_el = this,
				$map = this.$el.find('.mhc-map');
                
				if ( $map.length ){
					view_cid = this.view_cid;

					var $address = this.$el.find('.mhc_address'),
						$address_lat = this.$el.find('.mhc_address_lat'),
						$address_lng = this.$el.find('.mhc_address_lng'),
						$find_address = this.$el.find('.mhc_find_address'),
						$zoom_level = this.$el.find('.mhc_zoom_level'),
						geocoder = new google.maps.Geocoder(),
						markers = {};
					var geocode_address = function(){
						var address = $address.val();
						if ( address.length <= 0 ){
							return;
						}
						geocoder.geocode({ 'address': address}, function(results, status){
							if (status == google.maps.GeocoderStatus.OK){
								var result            = results[0],
									location          = result.geometry.location,
									address_is_latlng = this_el.is_latlng( address );

								// If user passes valid lat lng instead of address, override geocode with given lat & lng
								if ( address_is_latlng ){
									location = address_is_latlng;
								}

								if ( ! isNaN( location.lat() ) && ! isNaN( location.lng() ) ){
									$address.val( result.formatted_address);
									$address_lat.val(location.lat());
									$address_lng.val(location.lng());
									update_center( location );
								} else {
									alert( mhc_options.map_pin_address_invalid );
								}
							} else {
								alert( mhc_options.geocode_error + ': ' + status);
							}
						});
					}

					var update_center = function( LatLng ){
						$map.map.setCenter( LatLng );
					}

					var update_zoom = function (){
						$map.map.setZoom( parseInt( $zoom_level.val() ) );
					}

					$address.on('blur', geocode_address );
					$find_address.on('click', function(e){
						e.preventDefault();
					});

					$zoom_level.on('blur', update_zoom );

					setTimeout(function(){
						$map.map = new google.maps.Map( $map[0], {
							zoom: parseInt( $zoom_level.val() ),
							mapTypeId: google.maps.MapTypeId.ROADMAP
						});

						if ( '' != $address_lat.val() && '' != $address_lng.val() ){
							update_center( new google.maps.LatLng( $address_lat.val(), $address_lng.val() ) );
						}

						if ( '' != $zoom_level ){
							update_zoom();
						}

						setTimeout(function(){
							var map_pins = MH_PageComposer_Layout.getChildViews( view_cid );
							//var bounds = new google.maps.LatLngBounds();
							if ( _.size( map_pins ) ){
								_.each( map_pins, function( map_pin, key ){

									// Skip current map pin if it has no lat or lng, as it will trigger maximum call stack exceeded
									if ( _.isUndefined( map_pin.model.get('mhc_pin_address_lat') ) || _.isUndefined( map_pin.model.get('mhc_pin_address_lng') ) ){
										return;
									}

									//var position = new google.maps.LatLng( parseFloat( map_pin.model.get('mhc_pin_address_lat') ) , parseFloat( map_pin.model.get('mhc_pin_address_lng') ) );

									markers[key] = new google.maps.Marker({
										map: $map.map,
										position: position,
                                        position: new google.maps.LatLng( parseFloat( map_pin.model.get('mhc_pin_address_lat') ) , parseFloat( map_pin.model.get('mhc_pin_address_lng') ) ),
										title: map_pin.model.get('mhc_title'),
										icon: { url: mhc_options.images_uri + '/marker.png', size: new google.maps.Size( 46, 43 ), anchor: new google.maps.Point( 16, 43 ) },
										shape: { coord: [1, 1, 46, 43], type: 'rect' }
									});

									//bounds.extend( position );
								});

//								if ( ! _.isUndefined( $map.map.getBounds() ) && ! _.isNull( $map.map.getBounds() ) ){
//									bounds.extend( $map.map.getBounds().getNorthEast() );
//									bounds.extend( $map.map.getBounds().getSouthWest() );
//								}
//								$map.map.fitBounds( bounds );
							}
						}, 500 );

						google.maps.event.addListener( $map.map, 'center_changed', function(){
							var center = $map.map.getCenter();
							$address_lat.val( center.lat() );
							$address_lng.val( center.lng() );
						});

						google.maps.event.addListener( $map.map, 'zoom_changed', function(){
							var zoom_level = $map.map.getZoom();
							$zoom_level.val( zoom_level );
						});

					}, 200 );
				}
			}

		});

		MH_PageComposer.AdvancedModuleSettingsView = window.wp.Backbone.View.extend({
			initialize : function(){
				this.listenTo( MH_PageComposer_Events, 'mh-advanced-module:updated', this.generateContent );

				this.listenTo( MH_PageComposer_Events, 'mh-modal-view-removed', this.removeModule );

				this.module_type = this.$el.data( 'module_type' );

				MH_PageComposer.Events = MH_PageComposer_Events;

				this.child_views = [];

				this.$el.attr( 'data-cid', this.attributes['cid'] );

				this.$sortable_options = this.$el.find('.mhc-sortable-options');

				this.$content_textarea = this.$el.siblings('.mhc-option-main-content').find('#mhc_content_main');

				this.$sortable_options.sortable({
					axis : 'y',
					cancel : '.mhc-advanced-setting-remove, .mhc-advanced-setting-options',
					update : function( event, ui ){
						MH_PageComposer_Events.trigger( 'mh-advanced-module:updated' );
                        MH_PageComposer_Events.trigger( 'mh-advanced-module:updated_order' );
					}
				});

				this.$add_sortable_item = this.$el.find( '.mhc-add-sortable-option' ).addClass( 'mhc-add-sortable-initial' );
			},

			events : {
				'click .mhc-add-sortable-option' : 'addModule',
				'click .mhc-advanced-setting-clone' : 'cloneModule'
			},

			render : function(){
				return this;
			},

			addModule : function( event ){
				event.preventDefault();

				this.model.collection.add( [ {
					type : 'module',
					module_type : this.module_type,
					cid : MH_PageComposer_Layout.generateNewId(),
					view : this,
					created : 'manually',
					mode : 'advanced',
					parent : this.attributes['cid'],
					parent_cid : this.model.model.attributes['cid']
				} ], { update_shortcodes : 'false' });

				this.$add_sortable_item.removeClass( 'mhc-add-sortable-initial' );
                MH_PageComposer_Events.trigger( 'mh-advanced-module:updated_order' );
			},
            
			cloneModule : function( event ){

				event.preventDefault();
				var cloned_cid = $( event.target ).closest( 'li' ).data( 'cid' ),
					cloned_model = MH_PageComposer_App.collection.find(function( model ){
						return model.get('cid') == cloned_cid;
					}),
					module_attributes = _.clone( cloned_model.attributes );

				module_attributes.created = 'manually';
				module_attributes.cloned_cid = cloned_cid;
				module_attributes.cid = MH_PageComposer_Layout.generateNewId();

				this.model.collection.add( module_attributes );

				MH_PageComposer_Events.trigger( 'mh-advanced-module:updated' );
				MH_PageComposer_Events.trigger( 'mh-advanced-module:saved' );
                MH_PageComposer_Events.trigger( 'mh-advanced-module:updated_order' );
			},

			generateContent : function(){
				var content = '';

				this.$sortable_options.find( 'li' ).each(function(){
					var $this_el = $(this);

					content += MH_PageComposer_App.generateModuleShortcode( $this_el, false );
				});

				// Replace double quotes with ^^ in temporary shortcodes
				content = content.replace( /%22/g, '^^' );

				this.$content_textarea.html( content );

				if ( ! this.$sortable_options.find( 'li' ).length )
					this.$add_sortable_item.addClass( 'mhc-add-sortable-initial' );
				else
					this.$add_sortable_item.removeClass( 'mhc-add-sortable-initial' );
			},

			generateAdvancedSortableItems : function( content, module_type ){
				var this_el = this,
					mhc_shortcodes_tags = MH_PageComposer_App.getShortCodeChildTags(),
					reg_exp = window.wp.shortcode.regexp( mhc_shortcodes_tags ),
					inner_reg_exp = MH_PageComposer_App.wp_regexp_not_shared( mhc_shortcodes_tags ),
					matches = content.match( reg_exp );

				if ( content !== '' )
					this.$add_sortable_item.removeClass( 'mhc-add-sortable-initial' );

				_.each( matches, function ( shortcode ){
					var shortcode_element = shortcode.match( inner_reg_exp ),
						shortcode_name = shortcode_element[2],
						shortcode_attributes = shortcode_element[3] !== ''
							? window.wp.shortcode.attrs( shortcode_element[3] )
							: '',
						shortcode_content = shortcode_element[5],
						module_cid = MH_PageComposer_Layout.generateNewId(),
						module_settings,
						prefixed_attributes = {},
						found_inner_shortcodes = typeof shortcode_content !== 'undefined' && shortcode_content !== '' && shortcode_content.match( reg_exp );

					module_settings = {
						type : 'module',
						module_type : module_type,
						cid : MH_PageComposer_Layout.generateNewId(),
						view : this_el,
						created : 'auto',
						mode : 'advanced',
						parent : this_el.attributes['cid'],
						parent_cid : this_el.model.model.attributes['cid']
					}

					if ( _.isObject( shortcode_attributes['named'] ) ){
						for ( var key in shortcode_attributes['named'] ){
							var prefixed_key = key !== 'admin_label' ? 'mhc_' + key : key,
								setting_value;

							if ( shortcode_name === 'column' && prefixed_key === 'mhc_type' )
								prefixed_key = 'layout';

							setting_value = shortcode_attributes['named'][key];

							// Replace temporary ^^ signs with double quotes
							setting_value = setting_value.replace( /\^\^/g, '"' );

							prefixed_attributes[prefixed_key] = setting_value;
						}

						module_settings['mhc_content_new'] = shortcode_content;

						module_settings = _.extend( module_settings, prefixed_attributes );
					}

					if ( ! found_inner_shortcodes ){
						module_settings['mhc_content_new'] = shortcode_content;
					}

					this_el.model.collection.add( [ module_settings ], { update_shortcodes : 'false' });
				});
			},

			removeModule : function(){
				// remove Module settings, when modal window is closed or saved

				_.each( this.child_views, function( view ){
					view.removeView();
				});

				this.remove();
			}

		});

		MH_PageComposer.AdvancedModuleSettingView = window.wp.Backbone.View.extend({
			tagName : 'li',

			initialize : function(){
				this.template = _.template( $( '#mh-composer-advanced-setting' ).html() );
			},

			events : {
				'click .mhc-advanced-setting-options' : 'showSettings',
				'click .mhc-advanced-setting-remove' : 'removeView'
			},

			render : function(){
				var view;

				this.$el.html( this.template( this.model.attributes ) );

				view = new MH_PageComposer.AdvancedModuleSettingTitleView({
					model : this.model,
					view : this
				});

				this.$el.prepend( view.render().el );

				this.child_view = view;

				if ( typeof this.model.get( 'cloned_cid' ) === 'undefined' || '' === this.model.get( 'cloned_cid' ) ){
					this.showSettings();
				}

				return this;
			},

			showSettings : function( event ){
				var view;

				if ( event ) event.preventDefault();

				view = new MH_PageComposer.AdvancedModuleSettingEditViewContainer({
					view : this,
					attributes : {
						show_settings_clicked : ( event ? true : false )
					}
				});

				$('.mhc_modal_settings_container').after( view.render().el );
			},

			removeView : function( event ){
				if ( event ) event.preventDefault();

				this.child_view.remove();

				this.remove();

				this.model.destroy();

				MH_PageComposer_Events.trigger( 'mh-advanced-module:updated' );
                MH_PageComposer_Events.trigger( 'mh-advanced-module:updated_order' );
			}
		});

		MH_PageComposer.AdvancedModuleSettingTitleView = window.wp.Backbone.View.extend({
			tagName : 'span',

			className : 'mh-sortable-title',

			initialize : function(){
				template_name = '#mh-composer-advanced-setting-' + this.model.get( 'module_type' ) + '-title';

				this.template = _.template( $( template_name ).html() );

				this.listenTo( MH_PageComposer_Events, 'mh-advanced-module:updated', this.render );
			},

			render : function(){
				var view;

				// If admin label is empty, delete it so composer will use heading value instead
				if ( ! _.isUndefined( this.model.attributes.mhc_admin_title ) && this.model.attributes.mhc_admin_title === '' ){
					delete this.model.attributes.mhc_admin_title;
				}

				this.$el.html( this.template( this.model.attributes ) );

				return this;
			}
		});

		MH_PageComposer.AdvancedModuleSettingEditViewContainer = window.wp.Backbone.View.extend({
			className : 'mhc_modal_settings_container',

			initialize : function(){
				this.template = _.template( $( '#mh-composer-advanced-setting-edit' ).html() );

				this.model = this.options.view.model;

				this.listenTo( MH_PageComposer_Events, 'mh-modal-view-removed', this.removeView );
			},

			events : {
				'click .mhc-modal-save' : 'saveSettings',
				'click .mhc-modal-close' : 'removeView'
			},
            
            is_latlng : function( address ){
				var latlng = address.split( ',' ),
					lat = ! _.isUndefined( latlng[0] ) ? parseFloat( latlng[0] ) : false,
					lng = ! _.isUndefined( latlng[1] ) ? parseFloat( latlng[1] ) : false;

				if ( lat && ! _.isNaN( lat ) && lng && ! _.isNaN( lng ) ){
					return new google.maps.LatLng( lat, lng );
				}

				return false;
			},

			render : function(){
				var this_module_cid = this.model.attributes.cid,
                    view,
					$color_picker,
					$upload_button,
					$video_image_button,
					$map,
					$social_network_picker,
					$icon_font_list,
                    this_el = this;

				this.$el.html( this.template() );

				this.$el.addClass( 'mhc_modal_settings_container_step2' );

				if ( this.model.get( 'created' ) !== 'auto' || this.attributes['show_settings_clicked'] ){
					view = new MH_PageComposer.AdvancedModuleSettingEditView({ view : this });

					this.$el.append( view.render().el );

					this.child_view = view;
				}

				MH_PageComposer.Events.trigger( 'mh-advanced-module-settings:render', this );

				$color_picker = this.$el.find('.mhc-color-picker-hex');

				$color_picker_alpha = this.$el.find('.mh-composer-color-picker-alpha');

				if ( $color_picker.length ){
					$color_picker.wpColorPicker({
						defaultColor : $color_picker.data('default-color'),
                        palettes : mhc_options.default_color_scheme.split( '|' ),
						change       : function( event, ui ){
							var $this_el      = $(this),
								$reset_button = $this_el.closest( '.mhc-option-container' ).find( '.mhc-reset-setting' ),
								$custom_color_container = $this_el.closest( '.mhc-custom-color-container' ),
								current_value = $this_el.val(),
								default_value;

							if ( $custom_color_container.length ){
								$custom_color_container.find( '.mhc-custom-color-picker' ).val( ui.color.toString() );
							}

							if ( ! $reset_button.length ){
								return;
							}

							default_value = mhc_get_default_setting_value( $this_el );

							if ( current_value !== default_value ){
								$reset_button.addClass( 'mhc-reset-icon-visible' );
							} else {
								$reset_button.removeClass( 'mhc-reset-icon-visible' );
							}
						}
					});
				}

				if ( $color_picker_alpha.length ){
					$color_picker_alpha.each(function(){
						var $this_color_picker_alpha = $(this),
							color_picker_alpha_val = $this_color_picker_alpha.data('value').split('|'),
							color_picker_alpha_hex = color_picker_alpha_val[0] || '#444444',
							color_picker_alpha_opacity = color_picker_alpha_val[2] || 1.0;

						$this_color_picker_alpha.attr('data-opacity', color_picker_alpha_opacity );
						$this_color_picker_alpha.val( color_picker_alpha_hex );

						$this_color_picker_alpha.minicolors({
							control: 'hue',
							defaultValue: $(this).data('default-color') || '',
							opacity: true,
							changeDelay: 200,
							show: function(){
								$this_color_picker_alpha.minicolors('opacity', $this_color_picker_alpha.data('opacity') );
							},
							change: function(hex, opacity){
								if( !hex ){
									return;
								}

								var rgba_object = $this_color_picker_alpha.minicolors('rgbObject'),
									$field = $( $this_color_picker_alpha.data('field') ),
									values = [],
									values_string;

								values.push( hex );
								values.push( rgba_object.r + ', ' + rgba_object.g + ', ' + rgba_object.b );
								values.push( opacity );

								values_string = values.join('|');

								if ( $field.length ){
									$field.val( values_string );
								}
							},
							theme: 'bootstrap'
						});
					});
				}

				$upload_button = this.$el.find('.mhc-upload-button');

				if ( $upload_button.length ){
					mhc_activate_upload( $upload_button );
				}

				$video_image_button = this.$el.find('.mhc-video-image-button');

				if ( $video_image_button.length ){
					mhc_generate_video_image( $video_image_button );
				}

				$map = this.$el.find('.mhc-map');

				if ( $map.length ){
					var map,
						marker,
						$address = this.$el.find('.mhc_pin_address'),
						$address_lat = this.$el.find('.mhc_pin_address_lat'),
						$address_lng = this.$el.find('.mhc_pin_address_lng'),
						$find_address = this.$el.find('.mhc_find_address'),
						$zoom_level = this.$el.find('.mhc_zoom_level'),
						geocoder = new google.maps.Geocoder();
					var geocode_address = function(){
						var address = $address.val().trim();
						if ( address.length <= 0 ){
							return;
						}
						geocoder.geocode({ 'address': address}, function(results, status){
							if (status == google.maps.GeocoderStatus.OK){
								var result            = results[0],
									location          = result.geometry.location,
									address_is_latlng = this_el.is_latlng( address );

								// If user passes valid lat lng instead of address, override geocode with given lat & lng
								if ( address_is_latlng ){
									location = address_is_latlng;
								}

								if ( ! isNaN( location.lat() ) && ! isNaN( location.lng() ) ){
									$address.val( result.formatted_address);
									$address_lat.val(location.lat());
									$address_lng.val(location.lng());
									update_map( location );
								} else {
									alert( mhc_options.map_pin_address_invalid );
								}
							} else {
								alert( mhc_options.geocode_error + ': ' + status);
							}
						});
					}

					var update_map = function( LatLng ){
						marker.setPosition( LatLng );
						map.setCenter( LatLng );
					}

					$address.on('change', geocode_address );
					$find_address.on('click', function(e){
						e.preventDefault();
					});

					setTimeout(function(){
						map = new google.maps.Map( $map[0], {
							zoom: parseInt( $zoom_level.val() ),
							mapTypeId: google.maps.MapTypeId.ROADMAP
						});

						marker = new google.maps.Marker({
							map: map,
							draggable: true,
							icon: { url: mhc_options.images_uri + '/marker.png', size: new google.maps.Size( 46, 43 ), anchor: new google.maps.Point( 16, 43 ) },
							shape: { coord: [1, 1, 46, 43], type: 'rect' },
						});

						google.maps.event.addListener(marker, 'dragend', function(){
							var drag_position = marker.getPosition();
							$address_lat.val(drag_position.lat());
							$address_lng.val(drag_position.lng());

							update_map(drag_position);

							latlng = new google.maps.LatLng( drag_position.lat(), drag_position.lng() );
							geocoder.geocode({'latLng': latlng }, function(results, status){
								if (status == google.maps.GeocoderStatus.OK){
									if ( results[0] ){
										$address.val( results[0].formatted_address );
									} else {
										alert( mhc_options.no_results );
									}
								} else {
									alert( mhc_options.geocode_error_2 + ': ' + status);
								}
							});

						});

						if ( '' != $address_lat.val() && '' != $address_lng.val() ){
							update_map( new google.maps.LatLng( $address_lat.val(), $address_lng.val() ) );
						}
					}, 200 );
				}

				$gallery_button = this.$el.find('.mhc-gallery-button');

				if ( $gallery_button.length ){
					mhc_activate_gallery( $gallery_button );
				}

				$social_network_picker = this.$el.find('.mhc-social-network');

				if ( $social_network_picker.length ){
					var $color_reset = this.$el.find('.reset-default-color'),
						$social_network_icon_color = this.$el.find('#mhc_bg_color');
					if ( $color_reset.length ){
						$color_reset.click(function(){
							$main_settings = $color_reset.parents('.mhc-main-settings');
							$social_network_picker = $main_settings.find('.mhc-social-network');
							$social_network_icon_color = $main_settings.find('#mhc_bg_color');
							if ( $social_network_icon_color.length ){
								$social_network_icon_color.wpColorPicker('color', $social_network_picker.find( 'option:selected' ).data('color') );
								$color_reset.css( 'display', 'none' );
							}
						});
					}

					$social_network_picker.change(function(){
						$main_settings = $social_network_picker.parents('.mhc-main-settings');

						if ( $social_network_picker.val().length ){
							var $social_network_title = $main_settings.find('#mhc_content_new'),
								$social_network_icon_color = $main_settings.find('#mhc_bg_color');

							if ( $social_network_title.length ){
								$social_network_title.val( $social_network_picker.find( 'option:selected' ).text() );
							}

							if ( $social_network_icon_color.length ){
								$social_network_icon_color.wpColorPicker('color', $social_network_picker.find( 'option:selected' ).data('color') );
							}
						}
					});

					if ( $social_network_icon_color.val() !== $social_network_picker.find( 'option:selected' ).data('color') ){
						$color_reset.css( 'display', 'inline' );
					}

				}

				$icon_font_list = this.$el.find('.mhc-icon');

				if ( $icon_font_list.length ){
					var that = this;
					$icon_font_list.each(function(){
						var $this_icon_list = $( this ),
							$icon_font_field    = $this_icon_list.siblings('.mhc-font-icon'),
							current_symbol_val  = $.trim( $icon_font_field.val() ),
							$icon_font_symbols  = $this_icon_list.find( 'li' ),
							active_symbol_class = 'mh_active',
							$current_symbol,
							top_offset,
							icon_index_number;

						function mhc_icon_font_init(){
							if ( current_symbol_val !== '' ){
								// font icon index is used now in the following format: %%index_number%%
								if ( current_symbol_val.search( /^%%/ ) !== -1 ){
									icon_index_number = parseInt( current_symbol_val.replace( /%/g, '' ) );
									$current_symbol   = $this_icon_list.find( 'li' ).eq( icon_index_number );
								} else {
									$current_symbol = $this_icon_list.find( 'li[data-icon="' + current_symbol_val + '"]' );
								}

								$current_symbol.addClass( active_symbol_class );

								if ( $this_icon_list.is( ':visible' ) ){
									setTimeout(function(){
										top_offset = $current_symbol.offset().top - $this_icon_list.offset().top;

										if ( top_offset > 0 ){
											$this_icon_list.animate({ scrollTop : top_offset }, 0 );
										}
									}, 110 );
								}
							}
						}
						mhc_icon_font_init();

						that.$el.find( '.mhc-options-tabs-links' ).on( 'mhc_main_tab:changed', mhc_icon_font_init );

						$icon_font_symbols.click(function(){
							var $this_element = $(this),
								this_symbol   = $this_element.index();

							if ( $this_element.hasClass( active_symbol_class ) ){
								return false;
							}

							$this_element.siblings( '.' + active_symbol_class ).removeClass( active_symbol_class ).end().addClass( active_symbol_class );

							this_symbol = '%%' + this_symbol + '%%';

							$icon_font_field.val( this_symbol );
						});
					});
				}

				mhc_set_child_defaults( this.$el, this_module_cid );

				mhc_init_main_settings( this.$el, this_module_cid );

				return this;
			},

			removeView : function( event ){
				if ( event ) event.preventDefault();

				// remove advanced tab WYSIWYG, only if the close button is clicked
				if ( this.$el.find( '#mhc_content_new' ) && event )
					mhc_tinymce_remove_control( 'mhc_content_new' );

				mhc_hide_active_color_picker( this );

				if ( this.child_view )
					this.child_view.remove();

				this.remove();
			},

			saveSettings : function( event ){
                var this_view = this,
					attributes = {},
					this_model_defaults = this.model.get( 'module_defaults' ) || '';

				event.preventDefault();

				this.$( 'input, select, textarea' ).each(function(){
					var $this_el = $(this),
						id = $this_el.attr('id'),
						setting_value;
						/*checked_values = [],
						name = $this_el.is('#mhc_content_main') ? 'mhc_content_new' : $this_el.attr('id');*/

					if ( typeof id === 'undefined' || ( -1 !== id.indexOf( 'qt_' ) && 'button' === $this_el.attr( 'type' ) ) ){
						// settings should have an ID and shouldn't be a Quick Tag button from the tinyMCE in order to be saved
						return true;
					}

					id = $this_el.attr('id').replace( 'data.', '' );

					setting_value = $this_el.is('#mhc_content_new')
						? mhc_get_content( 'mhc_content_new' )
						: $this_el.val();
                    
                    // do not save the default values into module attributes
					if ( '' !== this_model_defaults && typeof this_model_defaults[id] !== 'undefined' && this_model_defaults[id] === setting_value ){
                        this_view.model.unset( id );
						return true;
					}

					attributes[ id ] = setting_value;
				});

				// Check if this is map module's pin view
				if ( ! _.isUndefined( attributes.mhc_pin_address ) && ! _.isUndefined( attributes.mhc_pin_address_lat ) && ! _.isUndefined( attributes.mhc_pin_address_lng ) ){
					// None of mhc_pin_address, mhc_pin_address_lat, and mhc_pin_address_lng fields can be empty
					// If one of them is empty, it'll trigger Uncaught RangeError: Maximum call stack size exceeded message
					if ( attributes.mhc_pin_address === '' || attributes.mhc_pin_address_lat === '' || attributes.mhc_pin_address_lng === '' ){
						alert( mhc_options.map_pin_address_error );
						return;
					}
				}

				this.model.set( attributes, { silent : true });

				MH_PageComposer_Events.trigger( 'mh-advanced-module:updated' );
				MH_PageComposer_Events.trigger( 'mh-advanced-module:saved' );

				mhc_tinymce_remove_control( 'mhc_content_new' );

				this.removeView();
			}
		});

		MH_PageComposer.AdvancedModuleSettingEditView = window.wp.Backbone.View.extend({
			className : 'mhc_module_settings',

			initialize : function(){
				this.model = this.options.view.options.view.model;

				this.template = _.template( $( '#mh-composer-advanced-setting-' + this.model.get( 'module_type' ) ).html() );
			},

			events : {
			},

			render : function(){
				var $this_el = this.$el,
					$content_textarea,
					$content_textarea_container;

				this.$el.html( this.template({ data : this.model.toJSON() }) );

				this.$el.find( '.mhc-main-settings' ).addClass( 'mhc-main-settings-advanced' );

				$content_textarea = this.$el.find( 'div#mhc_content_new' );

				if ( $content_textarea.length ){
					$content_textarea_container = $content_textarea.closest( '.mhc-option-container' );

					content = $content_textarea.html();

					$content_textarea.remove();

					$content_textarea_container.prepend( mhc_content_html );

					setTimeout(function(){
						if ( typeof window.switchEditors !== 'undefined' )
							window.switchEditors.go( 'mhc_content_new', mh_get_editor_mode() );

						mhc_set_content( 'mhc_content_new', content );

						window.wpActiveEditor = 'mhc_content_new';
					}, 300 );
				}

				setTimeout(function(){
					$this_el.find('select, input, textarea, radio').filter(':eq(0)').focus();
				}, 1 );

				return this;
			}
		});

		MH_PageComposer.BlockModuleView = window.wp.Backbone.View.extend({

			className : function(){
				var className = 'mhc_module_block';

				if ( typeof this.model.attributes.className !== 'undefined' ){
					className += this.model.attributes.className;
				}

				return className;
			},

			template : _.template( $( '#mh-composer-block-module-template' ).html() ),

			initialize : function(){
				this.listenTo( this.model, 'change:admin_label', this.renameModule );
                this.listenTo( this.model, 'change:mhc_disabled', this.toggleDisabledClass );
				this.listenTo( this.model, 'change:mhc_shared_module', this.removeShared );
			},

			events : {
				'click .mhc-settings' : 'showSettings',
				'click .mhc-clone-module' : 'cloneModule',
				'click .mhc-remove-module' : 'removeModule',
				'click .mhc-unlock' : 'unlockModule',
				'contextmenu' : 'showRightClickOptions',
				'click' : 'hideRightClickOptions',
			},

			render : function(){
				var parent_views = MH_PageComposer_Layout.getParentViews( this.model.get( 'parent' ) );

				this.$el.html( this.template( this.model.attributes ) );

				if ( typeof this.model.attributes.mhc_shared_module !== 'undefined' || ( typeof this.model.attributes.mhc_template_type !== 'undefined' && 'module' === this.model.attributes.mhc_template_type && 'shared' === mhc_options.is_shared_template ) ){
					this.$el.addClass( 'mhc_shared' );
				}

				if ( typeof this.model.get( 'mhc_locked' ) !== 'undefined' && this.model.get( 'mhc_locked' ) === 'on' ){
					_.each( parent_views, function( parent ){
						parent.$el.addClass( 'mhc_children_locked' );
					});
				}

				if ( typeof this.model.get( 'mhc_parent_locked' ) !== 'undefined' && this.model.get( 'mhc_parent_locked' ) === 'on' ){
					this.$el.addClass( 'mhc_parent_locked' );
				}

				if ( MH_PageComposer_Layout.isModuleFullwidth( this.model.get( 'module_type' ) ) )
					this.$el.addClass( 'mhc_fullwidth_module' );
                
                if ( typeof this.model.get( 'pasted_module' ) !== 'undefined' && this.model.get( 'pasted_module' ) ){
					mhc_handle_clone_class( this.$el );
				}

				return this;
			},

			cloneModule : function( event ){
				var shared_module_cid = '',
					clone_module,
					view_settings = {
						model      : this.model,
						view       : this.$el,
						view_event : event
					};

				event.preventDefault();

				if ( this.isModuleLocked() ){
					return;
				}

				if ( typeof this.model.get( 'mhc_shared_module' ) !== 'undefined' ){
					shared_module_cid = this.model.get( 'cid' );
				}

				clone_module = new MH_PageComposer.RightClickOptionsView( view_settings, true );

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'cloned', 'module', this.model.get( 'admin_label' ) );

				clone_module.copy( event );

				clone_module.pasteAfter( event );

				if ( '' !== shared_module_cid ){
					mhc_update_shared_template( shared_module_cid );
				}
			},

			renameModule : function(){
				this.$( '.mhc-module-title' ).html( this.model.get( 'admin_label' ) );
			},

			removeShared : function(){
				if ( this.isModuleLocked() ){
					return;
				}

				if ( typeof this.model.get( 'mhc_shared_module' ) === 'undefined' ){
					this.$el.removeClass( 'mhc_shared' );
				}
			},
            
           toggleDisabledClass : function(){
				if ( typeof this.model.get( 'mhc_disabled' ) !== 'undefined' && 'on' === this.model.get( 'mhc_disabled' ) ){
					this.$el.addClass( 'mhc_disabled' );
				} else {
					this.$el.removeClass( 'mhc_disabled' );
				}
			},

			showSettings : function( event ){
				var that = this,
					modal_view,
					view_settings = {
						model : this.model,
						collection : this.collection,
						attributes : {
							'data-open_view' : 'module_settings'
						},
						triggered_by_right_click : this.triggered_by_right_click,
						do_preview : this.do_preview
					};

				if ( typeof event !== 'undefined' ){
					event.preventDefault();
				}
                
                mhc_close_all_right_click_options();

				if ( this.isModuleLocked() ){
					return;
				}

				if ( typeof this.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== this.model.get( 'mhc_shared_module' ) ){
					mh_composer_get_shared_module( view_settings );

					// Set marker variable to undefined after being used to prevent unwanted preview
					this.triggered_by_right_click = undefined;
					this.do_preview = undefined;
				} else {
					modal_view = new MH_PageComposer.ModalView( view_settings );

                    mh_modal_view_rendered = modal_view.render();
                    
                    if ( false === mh_modal_view_rendered ) {
						setTimeout(function(){
							that.showSettings();
						}, 500 );

						MH_PageComposer_Events.trigger( 'mhc-loading:started' );

						return;
					}

					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );

                    $('body').append( mh_modal_view_rendered.el );
				}

				// set initial active tab for partially saved module templates.
				mhc_open_current_tab();

				if ( ( typeof this.model.get( 'mhc_shared_parent' ) !== 'undefined' && '' !== this.model.get( 'mhc_shared_parent' ) ) || ( MH_PageComposer_Layout.getView( this.model.get('cid') ).$el.closest( '.mhc_shared' ).length ) ){
					$( '.mhc_modal_settings_container' ).addClass( 'mhc_saved_shared_modal' );

					var saved_tabs = [ 'general', 'advanced', 'custom_css' ];
					_.each( saved_tabs, function( tab_name ){
						$( '.mhc_options_tab_' + tab_name ).addClass( 'mhc_saved_shared_tab' );
					});
				}
			},

			removeModule : function( event ){
				var shared_module_cid = '';

				if ( this.isModuleLocked() ){
					return;
				}

				if ( event ){
					event.preventDefault();

					if ( ( this.$el.closest( '.mhc_section.mhc_shared' ).length || this.$el.closest( '.mhc_row.mhc_shared' ).length ) && '' === mhc_options.template_post_id ){
						shared_module_cid = this.model.get( 'shared_parent_cid' );
					}
				}

				this.model.destroy();

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( 'removed', 'module', this.model.get( 'admin_label' ) );

				MH_PageComposer_Layout.removeView( this.model.get('cid') );

				this.remove();

				// if single module is removed from the composer
				if ( event ){
					MH_PageComposer_Events.trigger( 'mh-module:removed' );
				}

				if ( '' !== shared_module_cid ){
					mhc_update_shared_template( shared_module_cid );
				}
			},

			unlockModule : function( event ){
				event.preventDefault();

				var this_el = this,
					$parent = this_el.$el.closest('.mhc_module_block'),
					request = mhc_user_lock_permissions(),
					parent_views;

				request.done(function ( response ){
					if ( true === response ){
						$parent.removeClass('mhc_locked');

						// Add attribute to shortcode
						this_el.options.model.attributes.mhc_locked = 'off';

						parent_views = MH_PageComposer_Layout.getParentViews( this_el.model.get('parent') );

						_.each( parent_views, function( view, key ){
							if ( ! MH_PageComposer_Layout.isChildrenLocked( view.model.get( 'cid' ) ) ){
								view.$el.removeClass('mhc_children_locked');
							}
						});

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'unlocked', 'module', this_el.options.model.get( 'admin_label' ) );

						// Rebuild shortcodes
						MH_PageComposer_App.saveAsShortcode();
					} else {
						alert( mhc_options.locked_module_permission_alert );
					}
				});
			},

			isModuleLocked : function(){
				if ( 'on' === this.model.get( 'mhc_locked' ) || 'on' === this.model.get( 'mhc_parent_locked' ) ){
					return true;
				}

				return false;
			},

			showRightClickOptions : function( event ){
				event.preventDefault();

				var mh_right_click_options_view,
					view_settings = {
						model      : this.model,
						view       : this.$el,
						view_event : event
					};

				mh_right_click_options_view = new MH_PageComposer.RightClickOptionsView( view_settings );
			},

			hideRightClickOptions : function( event ){
				event.preventDefault();

				mhc_close_all_right_click_options();
			}
		});

		MH_PageComposer.RightClickOptionsView = window.wp.Backbone.View.extend({

			tagName : 'div',

			id : 'mh-composer-right-click-controls',

			template : _.template( $('#mh-composer-right-click-controls-template').html() ),

			events : {
				'click .mhc-right-click-rename' : 'rename',
				'click .mhc-right-click-save-to-vault' : 'saveToVault',
				'click .mhc-right-click-undo' : 'undo',
				'click .mhc-right-click-redo' : 'redo',
				'click .mhc-right-click-disable' : 'disable',
                'click .mhc_disable_on_option' : 'disable_device',
				'click .mhc-right-click-lock' : 'lock',
				'click .mhc-right-click-collapse' : 'collapse',
				'click .mhc-right-click-copy' : 'copy',
				'click .mhc-right-click-paste-after' : 'pasteAfter',
				'click .mhc-right-click-paste-app' : 'pasteApp',
				'click .mhc-right-click-paste-column' : 'pasteColumn',
				'click .mhc-right-click-preview' : 'preview',
                'click .mhc-right-click-disable-shared' : 'disableShared'
			},

			initialize : function( attributes, skip_render ){
				var skip_render                       = _.isUndefined( skip_render ) ? false : skip_render,
					allowed_vault_clipboard_content;

				this.type                             = this.options.model.attributes.type;
				this.mhc_has_storage_support        = mhc_has_storage_support();
				this.has_compatible_clipboard_content = MHC_Clipboard.get( this.getClipboardType() );
				this.history_noun                     = this.type === 'row_inner' ? 'row' : this.type;

				// Composer Vault adjustment
				if ( mhc_options.is_mharty_vault === '1' && this.has_compatible_clipboard_content !== false ){
					// There are four recognized layout type: layout, section, row, module
					switch( mhc_options.layout_type ){
						case 'module' :
							allowed_vault_clipboard_content = [];
							break;
						case 'row' :
							allowed_vault_clipboard_content = ['module'];
							break;
						case 'section' :
							allowed_vault_clipboard_content = ['module', 'row'];
							break;
						default :
							allowed_vault_clipboard_content = ['module', 'row', 'section'];
							break;
					}

					// If current clipboard type isn't allowed, disable pasteAfter
					if ( $.inArray( this.type, allowed_vault_clipboard_content ) == -1 ){
						this.has_compatible_clipboard_content = false;
					}
				}

				// Enable right options control rendering to be skipped
				if ( skip_render === false ){
					this.render();
				}
			},

			render : function(){
				var $parent = $( this.options.view ),
					$options_wrap = this.$el.html( this.template() ),
					view_offset = this.options.view.offset(),
					parent_offset_x = this.options.view_event.pageX - view_offset.left - 200,
					parent_offset_y = this.options.view_event.pageY - view_offset.top;

				// close other options, if there's any
				this.closeAllRightClickOptions();

				// Prevent recursive right click options
				if ( $( this.options.view_event.toElement ).is('#mh-composer-right-click-controls a')  ){
					return;
				}

				// Don't display empty right click options
				if ( $options_wrap.find('li').length < 1 ){
					return;
				}

				// Append options to the page
				$parent.append( $options_wrap );

				// Fixing options' position and animating it
				$options_wrap.find('.options').css({
					'top' : parent_offset_y,
					'left' : parent_offset_x,
					'margin-top': ( 0 - $options_wrap.find('.options').height() - 40 ),
				}).animate({
					'margin-top': ( 0 - $options_wrap.find('.options').height() - 10 ),
					'opacity' : 1
				}, 300 );

				// Add full screen page overlay (right/left click anywhere outside composer to close options)
				$('#mhc_layout').prepend('<div id="mhc_layout_right_click_overlay" />');
			},

			closeAllRightClickOptions : function(){
				mhc_close_all_right_click_options();

				return false;
			},

			rename : function( event ){
				event.preventDefault();

				var $parent = this.$el.parent(),
					cid = this.options.model.attributes.cid;

				mhc_create_prompt_modal( 'rename_admin_label', cid );

				// close the click right options
				this.closeAllRightClickOptions();
			},
            
            disableShared : function ( event ) {
				event.preventDefault();

				this.closeAllRightClickOptions();

				// Remove global attributes
				MH_PageComposer_Layout.removeSharedAttributes( this );

				mh_reinitialize_composer_layout();
			},
            
			saveToVault : function ( event ){
				event.preventDefault();

				var model          = this.options.model,
                    type           = model.attributes.type,
					view_settings  = {
						model : model,
						collection : MH_PageComposer_Modules,
						attributes : {
							'data-open_view' : 'module_settings'
						}
					};

				// Close right click options UI
				this.closeAllRightClickOptions();

				if ( this.type === 'app' ){
					// Init save current page to vault modal view
					mhc_create_prompt_modal( 'save_layout' );
				} else {
					// Init modal view
					modal_view = new MH_PageComposer.ModalView( view_settings );

					// Append modal view
					$('body').append( modal_view.render().el );

					// set initial active tab for partially saved module templates.
					mhc_open_current_tab();

					// Init save template modal view
					modal_view.saveTemplate( event );
				}
			},

			undo : function( event ){
				event.preventDefault();

				// Undoing...
				MH_PageComposer_App.undo( event );

				// Close right click options UI
				this.closeAllRightClickOptions();
			},

			redo : function( event ){
				event.preventDefault();

				// Redoing...
				MH_PageComposer_App.redo( event );

				// Close right click options UI
				this.closeAllRightClickOptions();
			},

			disable : function( event ) {
				event.preventDefault();

				var $this_button = $( event.target ).hasClass( 'mhc-right-click-disable' ) ? $( event.target ) : $( event.target ).closest( 'a' ),
					this_options_container = $this_button.closest( 'li' ).find( 'span.mhc_disable_on_options' ),
					single_options = this_options_container.find( 'span.mhc_disable_on_option' ),
					is_all_disabled = typeof this.options.model.attributes.mhc_disabled !== 'undefined' && 'on' === this.options.model.attributes.mhc_disabled ? true : false,
					disabled_on = typeof this.options.model.attributes.mhc_disabled_on !== 'undefined' ? this.options.model.attributes.mhc_disabled_on : '',
					disabled_on_array,
					i,
					device;

				$this_button.addClass( 'mhc_right_click_hidden' );

				this_options_container.addClass( 'mhc_right_click_visible' );

				// backward compatibility with old option
				if ( is_all_disabled ) {
					single_options.addClass( 'mhc_disable_on_active' );
				} else if ( '' !== disabled_on ) {
					disabled_on_array = disabled_on.split('|');
					i = 0,
					device = 'phone';

					single_options.each( function() {
						var this_option = $( this );

						if ( this_option.hasClass( 'mhc_disable_on_' + device ) && 'on' === disabled_on_array[ i ] ) {
							this_option.addClass( 'mhc_disable_on_active' );
						}

						i++;
						device = 1 === i ? 'tablet' : 'desktop';
					} );
				}

				return false;
			},

			disable_device : function( event ) {
				var $this_button = $( event.target ),
					this_option = $( this ),
					new_option_state = $this_button.hasClass( 'mhc_disable_on_active' ) ? 'off' : 'on',
					disabled_on = typeof this.options.model.attributes.mhc_disabled_on !== 'undefined' ? this.options.model.attributes.mhc_disabled_on : '',
					$parent = this.$el.parent(),
					history_verb,
					disabled_on_array,
					option_index,
					history_addition;

				// determine which option should be updated, Phone, Tablet or Desktop.
				if ( $this_button.hasClass( 'mhc_disable_on_phone' ) ) {
					option_index = 0;
					history_addition = 'phone';
				} else if ( $this_button.hasClass( 'mhc_disable_on_tablet' ) ) {
					option_index = 1;
					history_addition = 'tablet';
				} else {
					option_index = 2;
					history_addition = 'desktop';
				}

				if ( '' !== disabled_on ) {
					disabled_on_array = disabled_on.split('|');
				} else {
					disabled_on_array = ['','',''];
				}

				disabled_on_array[ option_index ] = new_option_state;

				this.options.model.attributes.mhc_disabled_on = disabled_on_array[0] + '|' + disabled_on_array[1] + '|' + disabled_on_array[2];

				if ( 'on' === disabled_on_array[0] && 'on' === disabled_on_array[1] && 'on' === disabled_on_array[2] ) {
					parent_background_color = $parent.css('backgroundColor');

					$parent.addClass('mhc_disabled');

					// Add attribute to shortcode
					this.options.model.attributes.mhc_disabled = 'on';
					history_verb = 'disabled';
				} else {
					// toggle mhc_disabled class
					$parent.removeClass( 'mhc_disabled' );

					// Remove attribute to shortcode
					this.options.model.attributes.mhc_disabled = 'off';
					history_verb = 'off' === new_option_state ? 'enabled' : 'disabled';
				}

				$this_button.toggleClass( 'mhc_disable_on_active' );

				// Update Shared module
				this.updateSharedModule();

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( history_verb, this.history_noun, undefined, history_addition );

				// Rebuild shortcodes
				MH_PageComposer_App.saveAsShortcode();
                
                return false;
			},

			lock : function( event ){
				event.preventDefault();

				var $parent = this.$el.parent();

				// toggle mhc_locked class
				if ( $parent.hasClass('mhc_locked') ){
					this.unlockItem();

					// Enable history saving and set meta for history
					MH_PageComposer_App.allowHistorySaving( 'unlocked', this.history_noun );
				} else {
					this.lockItem();

					// Enable history saving and set meta for history
					MH_PageComposer_App.allowHistorySaving( 'locked', this.history_noun );
				}

				// Update shared module
				this.updateSharedModule();

				// close the click right options
				this.closeAllRightClickOptions();

				// Rebuild shortcodes
				MH_PageComposer_App.saveAsShortcode();
			},

			unlockItem : function(){
				var this_el = this,
					$parent = this_el.$el.parent(),
					request = mhc_user_lock_permissions(),
					children_views,
					parent_views;

				request.done(function ( response ){
					if ( true === response ){
						$parent.removeClass('mhc_locked');

						// Add attribute to shortcode
						this_el.options.model.attributes.mhc_locked = 'off';

						if ( 'module' !== this_el.options.model.get( 'type' ) ){
							children_views = MH_PageComposer_Layout.getChildrenViews( this_el.model.get('cid') );

							_.each( children_views, function( view, key ){
								view.$el.removeClass('mhc_parent_locked');
								view.model.set( 'mhc_parent_locked', 'off', { silent : true });
							});
						}

						if ( 'section' !== this_el.options.model.get( 'type' ) ){
							parent_views = MH_PageComposer_Layout.getParentViews( this_el.model.get( 'parent' ) );

							_.each( parent_views, function( view, key ){
								if ( ! MH_PageComposer_Layout.isChildrenLocked( view.model.get( 'cid' ) ) ){
									view.$el.removeClass('mhc_children_locked');
								}
							});
						}

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'unlocked', this_el.history_noun );

						// Rebuild shortcodes
						MH_PageComposer_App.saveAsShortcode();
					} else {
						alert( mhc_options.locked_item_permission_alert );
					}
				});
			},

			lockItem : function(){
				var this_el = this,
					$parent = this_el.$el.parent(),
					request = mhc_user_lock_permissions(),
					children_views,
					parent_views;

				request.done(function ( response ){
					if ( true === response ){
						$parent.addClass('mhc_locked');

						// Add attribute to shortcode
						this_el.options.model.attributes.mhc_locked = 'on';

						if ( 'module' !== this_el.options.model.get( 'type' ) ){
							children_views = MH_PageComposer_Layout.getChildrenViews( this_el.model.get('cid') );

							_.each( children_views, function( view, key ){
								view.$el.addClass('mhc_parent_locked');
								view.model.set( 'mhc_parent_locked', 'on', { silent : true });
							});
						}

						if ( 'section' !== this_el.options.model.get( 'type' ) ){
							parent_views = MH_PageComposer_Layout.getParentViews( this_el.model.get( 'parent' ) );

							_.each( parent_views, function( view, key ){
								view.$el.addClass( 'mhc_children_locked' );
							});
						}

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'locked', this_el.history_noun );

						// Rebuild shortcodes
						MH_PageComposer_App.saveAsShortcode();
					} else {
						alert( mhc_options.locked_item_permission_alert );
					}
				});
			},

			collapse : function( event ){
				event.preventDefault();

				var $parent = this.$el.parent(),
					cid = this.options.model.attributes.cid,
					history_verb;

				$parent.toggleClass('mhc_collapsed');

				if ( $parent.hasClass('mhc_collapsed') ){
					// Add attribute to shortcode
					this.options.model.attributes.mhc_collapsed = 'on';
					history_verb = 'collapsed';
				} else {
					// Add attribute to shortcode
					this.options.model.attributes.mhc_collapsed = 'off';
					history_verb = 'expanded';
				}

				// Update shared module
				this.updateSharedModule();

				// close the click right options
				this.closeAllRightClickOptions();

				// Enable history saving and set meta for history
				MH_PageComposer_App.allowHistorySaving( history_verb, this.history_noun );

				// Rebuild shortcodes
				MH_PageComposer_App.saveAsShortcode();
			},

			copy : function( event ){
				event.preventDefault();

				var module_attributes = _.clone( this.model.attributes ),
					type              = module_attributes.type,
					clipboard_content;

				// Normalize row_inner as row. Specialty's section row is detected as row_inner
				// but selector-wise, there's no .mhc_row_inner. It uses the same .mhc_row
				if ( type === 'row_inner' ){
					type = 'row';
				}

				// Delete circular structure element carried by default by specialty section's row inner
				if ( ! _.isUndefined( module_attributes.view ) ){
					delete module_attributes.view;
				}

				// Delete appendAfter element, its leftover can cause misunderstanding on rendering UI
				if ( ! _.isUndefined( module_attributes.appendAfter ) ){
					delete module_attributes.appendAfter;
				}

				// append childview's data to mobile_attributes for row and section
				if ( type === 'row' || type === 'section' ){
					module_attributes.childviews = this.getChildViews( module_attributes.cid );
				}

				module_attributes.created = 'manually';

				// Set clipboard content
				clipboard_content = JSON.stringify( module_attributes );

				// Save content to clipboard
				MHC_Clipboard.set( this.getClipboardType(), clipboard_content );

				// close the click right options
				this.closeAllRightClickOptions();
			},

			pasteAfter : function( event, parent, clipboard_type, has_cloned_cid ){
				event.preventDefault();

				var parent            = _.isUndefined( parent ) ? this.model.get( 'parent' ) : parent,
					clipboard_type    = _.isUndefined( clipboard_type ) ? this.getClipboardType() : clipboard_type,
					clipboard_content,
					has_cloned_cid    = _.isUndefined( has_cloned_cid ) ? true : has_cloned_cid;

				// Get clipboard content
				clipboard_content = MHC_Clipboard.get( clipboard_type );
				clipboard_content = JSON.parse( clipboard_content );

				if ( has_cloned_cid ){
					clipboard_content.cloned_cid = this.model.get( 'cid' );
				}

				// Paste views recursively
				this.setPasteViews( clipboard_content, parent, 'main_parent' );

				// Trigger events
				MH_PageComposer_Events.trigger( 'mh-advanced-module:updated' );
				MH_PageComposer_Events.trigger( 'mh-advanced-module:saved' );

				// Update shared module
				this.updateSharedModule();

				// close the click right options
				this.closeAllRightClickOptions();

				// Enable history saving and set meta for history
				// pasteAfter can be used for clone, so only use copied if history verb being used is default
				if ( MH_PageComposer_Visualize_Histories.verb === 'did' ){
					MH_PageComposer_App.allowHistorySaving( 'copied', this.history_noun );
				}

				// Rebuild shortcodes
				MH_PageComposer_App.saveAsShortcode();
			},

			pasteApp : function( event ){
				event.preventDefault();

				// Get last' section model
				var sections     = MH_PageComposer_Modules.where({ 'type' : 'section' }),
					last_section = _.last( sections );

				// Set last section as this.model and this.options.model so setPasteViews() can parse the clipboard correctly
				this.model = last_section;
				this.options.model = last_section;

				// Paste Item
				this.pasteAfter( event, undefined, 'mhc_clipboard_section', false );
			},

			pasteColumn : function( event ){
				event.preventDefault();

				var parent         = this.model.get( 'cid' ),
					clipboard_type = this.model.get('type') === 'section' ? 'mhc_clipboard_module_fullwidth' : 'mhc_clipboard_module';

				// Paste item
				this.pasteAfter( event, parent, clipboard_type, false );
			},

			getClipboardType : function(){
				var type              = this.model.attributes.type,
					module_type        = _.isUndefined( this.model.attributes.module_type ) ? this.model.attributes.type : this.model.attributes.module_type,
					clipboard_key     = 'mhc_clipboard_' + type,
					fullwidth_prefix  = 'mhc_fullwidth';

				// Added fullwidth prefix
				if ( module_type.substr( 0, fullwidth_prefix.length ) === fullwidth_prefix ){
					clipboard_key += '_fullwidth';
				}

				return clipboard_key;
			},

			getChildViews : function( parent ){
				var this_el = this,
					views = MH_PageComposer_Modules.models,
					child_attributes,
					child_views = [];

				_.each( views, function( view, key ){
					if ( view.attributes.parent === parent ){
						child_attributes = view.attributes;

						// Delete circular structure element carried by default by specialty section's row inner
						if ( ! _.isUndefined( child_attributes.view ) ){
							delete child_attributes.view;
						}

						// Delete appendAfter element, its leftover can cause misunderstanding on rendering UI
						if ( ! _.isUndefined( child_attributes.appendAfter ) ){
							delete child_attributes.appendAfter;
						}

						child_attributes.created = 'manually';

						// Append grand child views, if there's any
						child_attributes.childviews = this_el.getChildViews( view.attributes.cid );
						child_views.push( child_attributes );
					}
				});

				return child_views;
			},

			setPasteViews : function( view, parent, is_main_parent ){
				var this_el    = this,
					cid        = MH_PageComposer_Layout.generateNewId(),
					view_index = this.model.collection.indexOf( this.model ),
					childviews = ( ! _.isUndefined( view.childviews ) && _.isArray( view.childviews ) ) ? view.childviews : false,
					shared_module_elements = [ 'mhc_shared_parent', 'shared_parent_cid' ];

				// Add newly generated cid and parent to the pasted view
				view.cid    = cid;
				view.parent = parent;
                
                if ( typeof is_main_parent !== 'undefined' && 'main_parent' === is_main_parent ){
					view.pasted_module = true;
				} else {
					view.pasted_module = false;
				}

				// Set new shared_parent_cid for pasted element
				if ( ! _.isUndefined( view.mhc_shared_module ) && _.isUndefined( view.shared_parent_cid ) && _.isUndefined( this.set_shared_parent_cid ) ){
					this.shared_parent_cid = cid;
					this.set_shared_parent_cid = true;
				}

				if ( ! _.isUndefined( view.shared_parent_cid ) ){
					view.shared_parent_cid = this.shared_parent_cid;
				}

				// If the view is pasted inside shared module, inherit its shared module child attributes
				_.each( shared_module_elements, function( shared_module_element ){
					if ( ! _.isUndefined( this_el.options.model.get( shared_module_element ) ) && _.isUndefined( view[ shared_module_element ] ) ){
						view[ shared_module_element ] = this_el.options.model.get( shared_module_element );
					}
				});

				// Remove template type leftover. Template type is used by Composer Vault to remove item's settings and clone button
				if ( ! _.isUndefined( view.mhc_template_type ) ){
					delete view.mhc_template_type;
				}

				// Delete unused childviews
				delete view.childviews;

				// Add view to collections
				this.model.collection.add( view, { at : view_index });

				// If current view has childviews (row & module), repeat the process above recursively
				if ( childviews ){
					_.each( childviews, function( childview ){
						this_el.setPasteViews( childview, cid );
					});
				};
			},

			updateSharedModule : function (){
				var shared_module_cid;
                
                if ( ! MH_PageComposer_Layout.is_shared( this.model ) ) {
					shared_module_cid = this.options.model.get( 'cid' );
				} else if ( ! MH_PageComposer_Layout.is_shared_children( this.model ) ) {
					shared_module_cid = this.options.model.get( 'shared_parent_cid' );
				}

				if ( ! _.isUndefined( shared_module_cid ) ){
					mhc_update_shared_template( shared_module_cid );
				}
			},

			hasOption : function( option_name ){
				var cid          = typeof this.model.get === 'function' ? this.model.get( 'cid' ) : false,
					has_option   = false,
					type         = this.options.model.attributes.type;
                    

				switch( option_name ){
					case "rename" :
							if ( this.hasOptionSupport( [ "module", "section", "row_inner", "row" ] ) &&
								 this.options.model.attributes.mhc_locked !== "on" ){
								has_option = true;
							}
						break;
					case "save-to-vault" :
							if ( this.hasOptionSupport( [ "app", "section", "row_inner", "row", "module" ] ) && ! MH_PageComposer_Layout.is_shared( this.options.model ) && ! MH_PageComposer_Layout.is_shared_children( this.options.model ) && this.options.model.attributes.mhc_locked !== "on" &&
								 mhc_options.is_mharty_vault !== "1" ){
								has_option = true;
							}
						break;
                    case "disable-shared" :
							if ( this.hasOptionSupport( [ "section", "row_inner", "row", "module" ] ) &&
								 ( MH_PageComposer_Layout.is_shared( this.options.model ) || MH_PageComposer_Layout.is_shared_children( this.options.model) )
							) {
								has_option = true;
							}
						break;
					case "undo" :
							if ( this.hasOptionSupport( [ "app", "section", "row_inner", "row", "column", "column_inner", "module" ] ) &&
								 this.hasUndo() ){
								has_option = true;
							}
						break;
					case "redo" :
							if ( this.hasOptionSupport( [ "app", "section", "row_inner", "row", "column", "column_inner", "module" ] ) &&
								 this.hasRedo() ){
								has_option = true;
							}
						break;
					case "disable" :
							if ( this.hasOptionSupport( [ "section", "row_inner", "row", "module" ] ) &&
								 this.options.model.attributes.mhc_locked !== "on" &&
								 this.hasDisabledParent() === false &&
								 _.isUndefined( this.model.attributes.mhc_skip_module ) ){
								has_option = true;
							}
						break;
					case "lock" :
							if ( this.hasOptionSupport( [ "section", "row_inner", "row", "module" ] ) &&
								 _.isUndefined( this.model.attributes.mhc_skip_module ) ){
								has_option = true;
							}
						break;
					case "collapse" :
							if ( this.hasOptionSupport( [ "section", "row_inner", "row" ] ) &&
								 this.options.model.attributes.mhc_locked !== "on" &&
								 _.isUndefined( this.model.attributes.mhc_skip_module ) ){
								has_option = true;
							}
						break;
					case "copy" :
							if ( this.hasOptionSupport( [ "section", "row_inner", "row", "module" ] ) &&
								 this.mhc_has_storage_support &&
								 this.options.model.attributes.mhc_locked !== "on" &&
								 _.isUndefined( this.model.attributes.mhc_skip_module ) ){
								has_option = true;
							}
						break;
					case "paste-after" :
							if ( this.hasOptionSupport( [ "section", "row_inner", "row", "module" ] ) &&
								 this.mhc_has_storage_support &&
								 this.has_compatible_clipboard_content &&
								 this.options.model.attributes.mhc_locked !== "on" ){
								has_option = true;
							}
						break;
					case "paste-app" :
							if ( this.hasOptionSupport( [ "app" ] ) &&
								 this.mhc_has_storage_support &&
								 MHC_Clipboard.get( "mhc_clipboard_section" ) ){
								has_option = true;
							}
						break;
					case "paste-column" :
							if ( ! _.isUndefined( this.model.attributes.is_insert_module ) &&
								( ( ( this.type === "column" || this.type == "column_inner" ) && MHC_Clipboard.get( "mhc_clipboard_module" ) ) || ( this.type === "section" && MHC_Clipboard.get( "mhc_clipboard_module_fullwidth" ) ) ) &&
								this.mhc_has_storage_support ){
								has_option = true;
							}
						break;
					case "preview" :
							if ( this.hasOptionSupport( [ "section", "row_inner", "row", "module" ] ) &&
								this.options.model.attributes.mhc_locked !== "on" ){
								has_option = true;
							}
						break;
				}

				return has_option;
			},

			hasOptionSupport : function( approved_types ){
				if ( _.isUndefined( _.findWhere( approved_types, this.type ) ) ){
					return false;
				}

				return true;
			},

			hasUndo : function(){
				return MH_PageComposer_App.hasUndo();
			},

			hasRedo : function(){
				return MH_PageComposer_App.hasRedo();
			},

			hasDisabledParent : function(){
				var parent_view = MH_PageComposer_Layout.getView( this.model.attributes.parent ),
					parent_views = {},
					has_disabled_parents = false;

				// Loop until parent_view is undefined (reaches section)
				while ( ! _.isUndefined( parent_view  ) ){
					// Check whether current parent is disabled or not
					if ( ! _.isUndefined( parent_view.model.attributes.mhc_disabled ) && parent_view.model.attributes.mhc_disabled === "on" ){
						has_disabled_parents = true;
					}

					// Append views to object
					parent_views[parent_view.model.attributes.cid] = parent_view;

					// Refresh parent_view for new loop
					parent_view = MH_PageComposer_Layout.getView( parent_view.model.attributes.parent );
				}

				return has_disabled_parents;
			},

			preview : function( event ){
				event.preventDefault();

				// Get item's view
				var view = MH_PageComposer_Layout.getView( this.model.get( 'cid' ) );

				// Close all right click options
				this.closeAllRightClickOptions();

				// Tell view that it is initiated from right click options so it can tell modalView
				view.triggered_by_right_click = true;

				// Tell modal view that this instance is intended for previewing
				// This is specifically needed for shared module
				view.do_preview = true;

				// Display ModalView
				view.showSettings( event );

				// Emulate preview clicking
				$('.mhc-modal-preview-template').trigger( 'click' );
			}
		});

		MH_PageComposer.visualizeHistoriesView = window.wp.Backbone.View.extend({

			el : '#mhc-histories-visualizer',

			template : _.template( $('#mh-composer-histories-visualizer-item-template').html() ),

			events : {
				'click li' : 'rollback'
			},

			verb : 'did',

			noun : 'module',

			noun_alias : undefined,

			getItemID : function( model ){
				return '#mhc-history-' + model.get( 'timestamp' );
			},

			getVerb : function(){
				var verb = this.verb;

				if ( ! _.isUndefined( mhc_options.verb[verb] ) ){
					verb = mhc_options.verb[verb];
				}

				return verb;
			},

			getNoun : function(){
				var noun = this.noun;

				if ( ! _.isUndefined( this.noun_alias ) ){
					noun = this.noun_alias;
				} else if ( ! _.isUndefined( mhc_options.noun[noun] ) ){
					noun = mhc_options.noun[noun];
				}

				return noun;
			},

			addItem : function( model ){
				// Setting the passed model as class' options so the template can be rendered correctly
				this.options = model;

				// Prepend history item to container
				this.$el.prepend( this.template() );

				// Fix max-height for history visualizer
				this.setHistoriesHeight();
			},

			changeItem : function( model ){
				var item_id      = this.getItemID( model ),
					$item        = $( item_id ),
					active_model = model.collection.findWhere({ current_active_history : true }),
					active_index = model.collection.indexOf( active_model ),
					item_index   = model.collection.indexOf( model );

				// Setting the passed model as class' options so the template can be rendered correctly
				this.options = model;

				// Remove all class related to changed item
				this.$el.find('li').removeClass( 'undo redo active' );

				// Update currently item class, relative to current index
				// Use class change instead of redraw the whole index using template() because verb+noun changing is too tricky
				if ( active_index === item_index ){
					$item.addClass( 'active' );

					this.$el.find('li:lt('+ $item.index() +')').addClass( 'redo' );

					this.$el.find('li:gt('+ $item.index() +')').addClass( 'undo' );
				} else {
					// Change upon history is tricky because there is no active model found. Assume that everything is undo action
					this.$el.find('li:not( .active, .redo )').addClass( 'undo' );
				}

				// Fix max-height for history visualizer
				this.setHistoriesHeight();
			},

			removeItem : function( model ){
				var item_id = this.getItemID( model );

				// Remove model's item from UI
				this.$el.find( item_id ).remove();

				// Fix max-height for history visualizer
				this.setHistoriesHeight();
			},

			setHistoryMeta : function( verb, noun, noun_alias ){
				if ( ! _.isUndefined( verb ) ){
					this.verb = verb;
				}

				if ( ! _.isUndefined( noun ) ){
					this.noun = noun;
				}

				if ( ! _.isUndefined( noun_alias ) ){
					this.noun_alias = noun_alias;
				} else {
					this.noun_alias = undefined;
				}
			},

			setHistoriesHeight : function(){
				var this_el = this;

				// Wait for 200 ms before making change to ensure that $layout has been changed
				setTimeout(function(){
					var $layout                = $( '#mhc_layout' ),
						$layout_header         = $layout.find( '.hndle' ),
						$layout_controls       = $( '#mhc_layout_controls' ),
						visualizer_height      = $layout.outerHeight() - $layout_header.outerHeight() - $layout_controls.outerHeight();

					this_el.$el.css({ 'max-height' : visualizer_height });
				}, 200 );
			},

			rollback : function( event ){
				event.preventDefault();

				var this_el     = this,
					$clicked_el = $( event.target ),
					$this_el    = $clicked_el.is( 'li' ) ? $clicked_el : $clicked_el.parent('li'),
					timestamp   = $this_el.data( 'timestamp' ),
					model       = this.options.collection.findWhere({ timestamp : timestamp }),
					shortcode   = model.get( 'shortcode' );

				// Turn off other current_active_history
				MH_PageComposer_App.resetCurrentActiveHistoryMarker();

				// Update undo model's current_active_history
				model.set({ current_active_history : true });

				// add loading state
				MH_PageComposer_Events.trigger( 'mhc-loading:started' );

				// Set shortcode to editor
				mhc_set_content( 'content', shortcode, 'saving_to_content' );

				// Rebuild the composer
				setTimeout(function(){
					var $composer_container = $( '#mhc_layout' ),
						composer_height     = $composer_container.innerHeight();

					$composer_container.css({ 'height' : composer_height });

					MH_PageComposer_App.removeAllSections();

					MH_PageComposer_App.$el.find( '.mhc_section' ).remove();

					// Ensure that no history is added for rollback
					MH_PageComposer_App.enable_history = false;

					MH_PageComposer_App.createLayoutFromContent( mh_prepare_template_content( shortcode ), '', '', { is_reinit : 'reinit' });

					$composer_container.css({ 'height' : 'auto' });

					// remove loading state
					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );

					// Update undo button state
					MH_PageComposer_App.updateHistoriesButtonState();
				}, 600 );
			}
		});

		MH_PageComposer.AppView = window.wp.Backbone.View.extend({

			el : $('#mhc_main_container'),

			template : _.template( $('#mh-composer-app-template').html() ),

			template_button : _.template( $('#mh-composer-add-specialty-section-button').html() ),

			events: {
				'click .mhc-layout-buttons-save' : 'saveLayout',
				'click .mhc-layout-buttons-load' : 'loadLayout',
				'click .mhc-layout-buttons-clear' : 'clearLayout',
				'click .mhc-layout-buttons-history' : 'toggleHistory',
				'click #mhc-histories-visualizer-overlay' : 'closeHistory',
				'contextmenu #mhc-histories-visualizer-overlay' : 'closeHistory',
				'click .mhc-layout-buttons-redo' : 'redo',
				'click .mhc-layout-buttons-undo' : 'undo',
				'contextmenu .mhc-layout-buttons-save' : 'showRightClickOptions',
				'contextmenu .mhc-layout-buttons-load' : 'showRightClickOptions',
				'contextmenu .mhc-layout-buttons-clear' : 'showRightClickOptions',
				'contextmenu .mhc-layout-buttons-redo' : 'showRightClickOptions',
				'contextmenu .mhc-layout-buttons-undo' : 'showRightClickOptions',
				'contextmenu #mhc_main_container_right_click_overlay' : 'showRightClickOptions',
				'click #mhc_main_container_right_click_overlay' : 'hideRightClickOptions'
			},

			initialize : function(){
				this.listenTo( this.collection, 'add', this.addModule );
				this.listenTo( MH_PageComposer_Histories, 'add', this.addVisualizeHistoryItem );
				this.listenTo( MH_PageComposer_Histories, 'change', this.changeVisualizeHistoryItem );
				this.listenTo( MH_PageComposer_Histories, 'remove', this.removeVisualizeHistoryItem );
				this.listenTo( MH_PageComposer_Events, 'mh-sortable:update', _.debounce( this.saveAsShortcode, 128 ) );
				this.listenTo( MH_PageComposer_Events, 'mh-model-changed-position-within-column', _.debounce( this.saveAsShortcode, 128 ) );
				this.listenTo( MH_PageComposer_Events, 'mh-module:removed', _.debounce( this.saveAsShortcode, 128 ) );
				this.listenTo( MH_PageComposer_Events, 'mhc-loading:started', this.startLoadingAnimation );
				this.listenTo( MH_PageComposer_Events, 'mhc-loading:ended', this.endLoadingAnimation );
                this.listenTo( MH_PageComposer_Events, 'mhc-content-updated', this.recalculateModulesOrder );
				this.listenTo( MH_PageComposer_Events, 'mh-advanced-module:updated_order', this.updateAdvancedModulesOrder );
                this.listenTo( MH_PageComposer_Events, 'mhc-content-updated', this.updateYoastContent );

				this.$composer_toggle_button = $( 'body' ).find( '#mhc_toggle_composer' );
				this.$composer_toggle_button_wrapper = $( 'body' ).find( '.mhc_toggle_composer_wrapper' );

				this.render();

				this.maybeGenerateInitialLayout();
			},

			render : function(){
				this.$el.html( this.template() );

				this.makeSectionsSortable();

				this.addLoadingAnimation();

				$('#mhc_main_container_right_click_overlay').remove();

				this.$el.prepend('<div id="mhc_main_container_right_click_overlay" />');

				this.updateHistoriesButtonState();

				return this;
			},

			addLoadingAnimation : function(){
				$( 'body' ).append( '<div id="mhc_loading_animation"></div>' );

				this.$loading_animation = $( '#mhc_loading_animation' ).hide();
			},

			startLoadingAnimation : function(){
				if ( this.pageComposerIsActive() ){
					// place the loading animation container before the closing body tag
					if ( this.$loading_animation.next().length ){
						$( 'body' ).append( this.$loading_animation );
						this.$loading_animation = $( '#mhc_loading_animation' );
					}

					this.$loading_animation.show();
				};
			},

			endLoadingAnimation : function(){
				this.$loading_animation.hide();
			},

			pageComposerIsActive : function(){
//check the button wrapper class as well because button may not be added in some cases
				return this.$composer_toggle_button.hasClass( 'mhc_composer_is_used' ) || this.$composer_toggle_button_wrapper.hasClass( 'mhc_composer_is_used' );
			},

			saveLayout : function( event ){
				event.preventDefault();

				mhc_close_all_right_click_options();

				mhc_create_prompt_modal( 'save_layout' );
			},

			loadLayout : function( event ){
				event.preventDefault();

				var view;

				mhc_close_all_right_click_options();

				view = new MH_PageComposer.ModalView({
					attributes : {
						'data-open_view' : 'save_layout'
					},
					view : this
				});

				$('body').append( view.render().el );
			},

			clearLayout : function( event ){
				event.preventDefault();

				mhc_close_all_right_click_options();

				mhc_create_prompt_modal( 'clear_layout' );
			},

			getHistoriesCount : function(){
				return this.options.history.length;
			},

			getHistoriesIndex : function(){
				var active_model       = this.options.history.findWhere({ current_active_history : true }),
					active_model_index = _.isUndefined( active_model ) ? ( this.options.history.models.length - 1 ) : this.options.history.indexOf( active_model );

				return active_model_index;
			},

			enableHistory : function(){
				if ( _.isUndefined( this.enable_history ) ){
					return false;
				} else {
					return this.enable_history;
				}
			},

			allowHistorySaving : function( verb, noun, noun_alias ){
				this.enable_history = true;

				// Enable history saving and set meta for history
				MH_PageComposer_Visualize_Histories.setHistoryMeta( verb, noun, noun_alias );
			},

			reviseHistories : function(){
				var model,
					this_el = this;

				if ( this.hasRedo() ){
					// Prepare reversed index (deleting unused model using ascending index changes the order of collection)
					var history_index = _.range( ( this.getHistoriesIndex() + 1 ), this.getHistoriesCount() ).reverse();

					// Loop the reversed index then delete the matched models
					_.each( history_index, function( index ){
						model = this_el.options.history.at( index );
						this_el.options.history.remove( model );
					});
				}

				// Update undo button state
				this.updateHistoriesButtonState();
			},

			resetCurrentActiveHistoryMarker : function(){
				var current_active_histories = this.options.history.where({ current_active_history : true });

				if ( ! _.isEmpty( current_active_histories ) ){
					_.each( current_active_histories, function( current_active_history ){
						current_active_history.set({ current_active_history : false });
					});
				}

			},

			hasUndo : function(){
				return this.getHistoriesIndex() > 0 ? true : false;
			},

			hasRedo : function(){
				return ( this.getHistoriesCount() - this.getHistoriesIndex() ) > 1 ? true : false;
			},

			hasOverlayRendered : function(){
				if ( $('.mhc_modal_overlay').length ){
					return true;
				}

				return false;
			},

			updateHistoriesButtonState : function(){
				if ( this.hasUndo() ){
					$( '.mhc-layout-buttons-undo' ).removeClass( 'disabled' );
				} else {
					$( '.mhc-layout-buttons-undo' ).addClass( 'disabled' );
				}

				if ( this.hasRedo() ){
					$( '.mhc-layout-buttons-redo' ).removeClass( 'disabled' );
				} else {
					$( '.mhc-layout-buttons-redo' ).addClass( 'disabled' );
				}

				if ( this.hasUndo() || this.hasRedo() ){
					$( '.mhc-layout-buttons-history' ).removeClass( 'disabled' );
				} else {
					$( '.mhc-layout-buttons-history' ).addClass( 'disabled' );
				}
			},

			getUndoModel : function(){
				var model = this.options.history.at( this.getHistoriesIndex() - 1 );

				if ( _.isUndefined( model ) ){
					return false;
				} else {
					return model;
				}
			},

			undo : function( event ){
				event.preventDefault();

				var this_el = this,
					undo_model = this.getUndoModel(),
					undo_content,
					current_active_histories;

				// Bail if there's no undo histories to be used
				if ( ! this.hasUndo() ){
					return;
				}

				// Bail if no undo model found
				if ( _.isUndefined( undo_model ) ){
					return;
				}

				// Bail if there is overlay rendered (usually via hotkeys)
				if ( this.hasOverlayRendered() ){
					return;
				}

				// Get undo content
				undo_content     = undo_model.get( 'shortcode' );

				// Turn off other current_active_history
				this.resetCurrentActiveHistoryMarker();

				// Update undo model's current_active_history
				undo_model.set({ current_active_history : true });

				// add loading state
				MH_PageComposer_Events.trigger( 'mhc-loading:started' );

				// Set last history's content into main editor
				mhc_set_content( 'content', undo_content, 'saving_to_content' );

				// Rebuild the composer
				setTimeout(function(){
					var $composer_container = $( '#mhc_layout' ),
						composer_height     = $composer_container.innerHeight();

					$composer_container.css({ 'height' : composer_height });

					MH_PageComposer_App.removeAllSections();

					MH_PageComposer_App.$el.find( '.mhc_section' ).remove();


					// Temporarily disable history until new layout has been generated
					this_el.enable_history = false;

					MH_PageComposer_App.createLayoutFromContent( mh_prepare_template_content( undo_content ), '', '', { is_reinit : 'reinit' });

					$composer_container.css({ 'height' : 'auto' });

					// remove loading state
					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );

					// Update undo button state
					this_el.updateHistoriesButtonState();
				}, 600 );
			},

			getRedoModel : function(){
				var model = this.options.history.at( this.getHistoriesIndex() + 1 );

				if ( _.isUndefined( model ) ){
					return false;
				} else {
					return model;
				}
			},

			toggleHistory : function( event ){
				event.preventDefault();

				var $mhc_history_visualizer = $('#mhc-histories-visualizer');

				if ( $mhc_history_visualizer.hasClass( 'active' ) ){
					$mhc_history_visualizer.addClass( 'fadeout' );

					// Remove class after being animated
					setTimeout(function(){
						$mhc_history_visualizer.removeClass( 'fadeout' );
					}, 500 );
				}

				$( '.mhc-layout-buttons-history, #mhc-histories-visualizer, #mhc-histories-visualizer-overlay' ).toggleClass( 'active' );
			},

			closeHistory : function( event ){
				event.preventDefault();

				this.toggleHistory( event );
			},

			redo : function( event ){
				event.preventDefault();

				var this_el = this,
					redo_model = this.getRedoModel(),
					redo_model_index,
					redo_content,
					current_active_histories;

				// Bail if there's no redo histories to be used
				if ( ! this.hasRedo() ){
					return;
				}

				// Bail if no redo model found
				if ( _.isUndefined( redo_model ) || ! redo_model ){
					return;
				}

				// Bail if there is overlay rendered (usually via hotkeys)
				if ( this.hasOverlayRendered() ){
					return;
				}

				redo_model_index = this.options.history.indexOf( redo_model );
				redo_content     = redo_model.get( 'shortcode' );

				// Turn off other current_active_history
				this.resetCurrentActiveHistoryMarker();

				// Update redo model's current_active_history
				redo_model.set({ current_active_history : true });

				// add loading state
				MH_PageComposer_Events.trigger( 'mhc-loading:started' );

				// Set last history's content into main editor
				mhc_set_content( 'content', redo_content, 'saving_to_content' );

				// Rebuild the composer
				setTimeout(function(){
					var $composer_container = $( '#mhc_layout' ),
						composer_height     = $composer_container.innerHeight();

					$composer_container.css({ 'height' : composer_height });

					MH_PageComposer_App.removeAllSections();

					MH_PageComposer_App.$el.find( '.mhc_section' ).remove();

					// Temporarily disable history until new layout has been generated
					this_el.enable_history = false;

					MH_PageComposer_App.createLayoutFromContent( mh_prepare_template_content( redo_content ), '', '', { is_reinit : 'reinit' });

					$composer_container.css({ 'height' : 'auto' });

					// remove loading state
					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );

					// Update redo button state
					this_el.updateHistoriesButtonState();
				}, 600 );
			},

			addHistory : function( content ){
				if ( this.enableHistory() ){
					var date = new Date(),
						hour = date.getHours() > 12 ? date.getHours() - 12 : date.getHours(),
						minute = date.getMinutes(),
						datetime_suffix = date.getHours() > 12 ? "PM" : "AM";

					// If there's a redo, remove models after active model
					if ( this.hasRedo() ){
						this.reviseHistories();
					}

					this.resetCurrentActiveHistoryMarker();

					// Save content to composer history for undo/redo
					this.options.history.add({
						timestamp : _.now(),
						datetime : ( "0" + hour).slice(-2) + ":" + ( "0" + minute ).slice(-2) + " " + datetime_suffix,
						shortcode : content,
						current_active_history : true,
						verb : MH_PageComposer_Visualize_Histories.verb,
						noun : MH_PageComposer_Visualize_Histories.noun
					}, { validate : true });

					// Return history meta to default. Prevent confusion and for debugging
					MH_PageComposer_Visualize_Histories.setHistoryMeta( 'did', 'something' );
				}

				// Update undo button state
				this.updateHistoriesButtonState();
			},

			addVisualizeHistoryItem : function( model ){
				MH_PageComposer_Visualize_Histories.addItem( model );
			},

			changeVisualizeHistoryItem : function( model ){
				MH_PageComposer_Visualize_Histories.changeItem( model );
			},

			removeVisualizeHistoryItem : function( model ){
				MH_PageComposer_Visualize_Histories.removeItem( model );
			},

			maybeGenerateInitialLayout : function(){
				var module_id = MH_PageComposer_Layout.generateNewId(),
					this_el = this;

				MH_PageComposer_Events.trigger( 'mhc-loading:started' );

				setTimeout(function(){
					var fix_shortcodes = true,
						content = '';
                    
                    
                // check whether the tinyMCE container is loaded already if not - try again.
                if ( typeof window.tinyMCE !== 'undefined' && window.tinyMCE.get( 'content' ) && ! window.tinyMCE.get( 'content' ).isHidden() && ! $( 'iframe#content_ifr' ).length ) {
                    mhc_loading_attempts++;

                    //stop loading after 30 unsuccessful attempts
                    if ( 30 < mhc_loading_attempts ) {
                        MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
                        //add message to help
                        return;
                    }

                    this_el.maybeGenerateInitialLayout();
                    return;
                }

					/*
					 * Visual editor adds paragraph tags around shortcodes,
					 * it causes &nbsp; to be inserted into a module content area
					 */
					content = mhc_get_content( 'content', fix_shortcodes );

					// Enable history saving and set meta for history
					if ( content !== '' ){
						this_el.allowHistorySaving( 'loaded', 'page' );
					}

					// Save page loaded
					this_el.addHistory( content );

					if  ( this_el.pageComposerIsActive() ){
						if ( -1 === content.indexOf( '[mhc_') ){
							MH_PageComposer_App.reInitialize();
						} else if ( -1 !== content.indexOf( 'specialty_placeholder') ){
							this_el.createLayoutFromContent( mh_prepare_template_content( content ) );
							$( '.mhc_section_specialty' ).append( this_el.template_button() );
						} else {
							this_el.createLayoutFromContent( mh_prepare_template_content( content ) );
						}
					} else {
						this_el.createLayoutFromContent( content );
					}
                    
                    mhc_maybe_apply_wpautop_to_models( mh_get_editor_mode(), 'initial_load' );
                    
                    MH_PageComposer_Events.trigger( 'mhc-content-updated' );
					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
                    
                    $( '#mhc_main_container' ).addClass( 'mhc_loading_animation' );

					setTimeout(function(){
						$( '#mhc_main_container' ).removeClass( 'mhc_loading_animation' );
					}, 500 );

					// start listening to any collection events after all modules have been generated
					this_el.listenTo( this_el.collection, 'change reset add', _.debounce( this_el.saveAsShortcode, 128 ) );
				}, 1000 );
			},

			wp_regexp_not_shared : _.memoize(function( tag ){
				return new RegExp( '\\[(\\[?)(' + tag + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)' );
			}),

			getShortCodeParentTags : function (){
				var shortcodes = 'mhc_section|mhc_row|mhc_column|mhc_column_inner|mhc_row_inner'.split('|');

				shortcodes = shortcodes.concat( mhc_options.mh_composer_module_parent_shortcodes.split('|') );
				shortcodes = shortcodes.join('|');
				return shortcodes;
			},

			getShortCodeChildTags : function (){
				return mhc_options.mh_composer_module_child_shortcodes;
			},

			getShortCodeRawContentTags : function (){
				var raw_content_shortcodes = mhc_options.mh_composer_module_raw_content_shortcodes,
					raw_content_shortcodes_array;

				raw_content_shortcodes_array = raw_content_shortcodes.split( '|' )

				return raw_content_shortcodes_array;
			},
			//ignore_template_tag, current_row_cid, shared_id, is_reinit, after_section, shared_parent
			createLayoutFromContent : function( content, parent_cid, inner_shortcodes, additional_options ){
				var this_el = this,
					mhc_shortcodes_tags = typeof inner_shortcodes === 'undefined' || '' === inner_shortcodes ? this.getShortCodeParentTags() : this.getShortCodeChildTags(),
					reg_exp = window.wp.shortcode.regexp( mhc_shortcodes_tags ),
					inner_reg_exp = this.wp_regexp_not_shared( mhc_shortcodes_tags ),
					matches = content.match( reg_exp ),
					mhc_raw_shortcodes = this.getShortCodeRawContentTags(),
					additional_options_received = typeof additional_options === 'undefined' ? {} : additional_options;

				_.each( matches, function ( shortcode ){
					var shortcode_element = shortcode.match( inner_reg_exp ),
						shortcode_name = shortcode_element[2],
						shortcode_attributes = shortcode_element[3] !== ''
							? window.wp.shortcode.attrs( shortcode_element[3] )
							: '',
						shortcode_content = shortcode_element[5],
						module_cid = MH_PageComposer_Layout.generateNewId(),
						module_settings,
						prefixed_attributes = {},
						found_inner_shortcodes = typeof shortcode_content !== 'undefined' && shortcode_content !== '' && shortcode_content.match( reg_exp ),
						shared_module_id = '';

					if ( shortcode_name === 'mhc_section' || shortcode_name === 'mhc_row' || shortcode_name === 'mhc_column' || shortcode_name === 'mhc_row_inner' || shortcode_name === 'mhc_column_inner' )
						shortcode_name = shortcode_name.replace( 'mhc_', '' );

					module_settings = {
						type : shortcode_name,
						cid : module_cid,
						created : 'manually',
						module_type : shortcode_name
					}

					if ( typeof additional_options_received.current_row_cid !== 'undefined' && '' !== additional_options_received.current_row_cid ){
						module_settings['current_row'] = additional_options_received.current_row_cid;
					}

					if ( typeof additional_options_received.shared_id !== 'undefined' && '' !== additional_options_received.shared_id ){
						module_settings['mhc_shared_module'] = additional_options_received.shared_id;
					}

					if ( typeof additional_options_received.shared_parent !== 'undefined' && '' !== additional_options_received.shared_parent ){
						module_settings['mhc_shared_parent'] = additional_options_received.shared_parent;
						module_settings['shared_parent_cid'] = additional_options_received.shared_parent_cid;
					}

					if ( shortcode_name === 'section' && ( typeof additional_options_received.after_section !== 'undefined' && '' !== additional_options_received.after_section ) ){
						module_settings['after_section'] = additional_options_received.after_section;
					}

					if ( shortcode_name !== 'section' ){
						module_settings['parent'] = parent_cid;
					}

					if ( shortcode_name.indexOf( 'mhc_' ) !== -1 ){
						module_settings['type'] = 'module';

						module_settings['admin_label'] = MH_PageComposer_Layout.getTitleByShortcodeTag( shortcode_name );
					} else {
						module_settings['admin_label'] = shortcode_name;
					}

					if ( _.isObject( shortcode_attributes['named'] ) ){
						shared_module_id = typeof shortcode_attributes['named']['shared_module'] !== 'undefined' && '' === shared_module_id ? shortcode_attributes['named']['shared_module'] : shared_module_id;

						for ( var key in shortcode_attributes['named'] ){
							if ( typeof additional_options_received.ignore_template_tag === 'undefined' || '' === additional_options_received.ignore_template_tag || ( 'ignore_template' === additional_options_received.ignore_template_tag && 'template_type' !== key ) ){
								var prefixed_key = key !== 'admin_label' && key !== 'specialty_columns' ? 'mhc_' + key : key;

								if ( ( shortcode_name === 'column' || shortcode_name === 'column_inner' ) && prefixed_key === 'mhc_type' )
									prefixed_key = 'layout';

								prefixed_attributes[prefixed_key] = shortcode_attributes['named'][key];
							}
						}

						module_settings = _.extend( module_settings, prefixed_attributes );

					}

					if ( typeof module_settings['specialty_columns'] !== 'undefined' ){
						module_settings['layout_specialty'] = '1';
						module_settings['specialty_columns'] = parseInt( module_settings['specialty_columns'] );
					}

					if ( ! found_inner_shortcodes ){
						if ( $.inArray( shortcode_name, mhc_raw_shortcodes ) > -1 ){
							module_settings['mhc_raw_content'] = _.unescape( shortcode_content );
						} else {
							module_settings['mhc_content_new'] = shortcode_content;
						}
					}

					if ( ! module_settings['mhc_disabled'] !== 'undefined' && module_settings['mhc_disabled'] === 'on' ){
						module_settings.className = ' mhc_disabled';
					}

					if ( ! module_settings['mhc_locked'] !== 'undefined' && module_settings['mhc_locked'] === 'on' ){
						module_settings.className = ' mhc_locked';
					}

					this_el.collection.add( [ module_settings ] );

					if ( 'reinit' === additional_options_received.is_reinit || ( shared_module_id === '' || ( shared_module_id !== '' && 'row' !== shortcode_name && 'row_inner' !== shortcode_name && 'section' !== shortcode_name ) ) ){
						if ( found_inner_shortcodes ){
							var shared_parent_id = typeof additional_options_received.shared_parent === 'undefined' || '' === additional_options_received.shared_parent ? shared_module_id : additional_options_received.shared_parent,
								shared_parent_cid_new = typeof additional_options_received.shared_parent_cid === 'undefined' || '' === additional_options_received.shared_parent_cid
									? typeof shared_module_id !== 'undefined' && '' !== shared_module_id ? module_cid : ''
									: additional_options_received.shared_parent_cid;

							this_el.createLayoutFromContent( shortcode_content, module_cid, '', { is_reinit : additional_options_received.is_reinit, shared_parent : shared_parent_id, shared_parent_cid : shared_parent_cid_new });
						}
					} else {
						//calculate how many shared modules we requested on page
						mhc_shareds_requested++;

						mhc_load_shared_row( shared_module_id, module_cid );
						this_el.createLayoutFromContent( shortcode_content, module_cid, '', { is_reinit : 'reinit' });
					}
				});
			},

			addModule : function( module ){
				var view,
					modal_view,
					row_parent_view,
					row_layout,
					view_settings = {
						model : module,
						collection : MH_PageComposer_Modules
					},
					cloned_cid = typeof module.get('cloned_cid') !== 'undefined' ? module.get('cloned_cid') : false;

				switch ( module.get( 'type' ) ){
					case 'section' :
						view = new MH_PageComposer.SectionView( view_settings );

						MH_PageComposer_Layout.addView( module.get('cid'), view );

						if ( ! _.isUndefined( module.get( 'view' ) ) ){
							module.get( 'view' ).$el.after( view.render().el );
						} else if ( typeof module.get( 'after_section' ) !== 'undefined' && '' !== module.get( 'after_section' ) ){
							MH_PageComposer_Layout.getView( module.get( 'after_section' ) ).$el.after( view.render().el );
						} else if ( typeof module.get( 'current_row' ) !== 'undefined' ){
							this.replaceElement( module.get( 'current_row' ), view );
						} else if ( cloned_cid ){
							this.$el.find( 'div[data-cid="' + cloned_cid + '"]' ).closest('.mhc_section').after( view.render().el );
						} else {
							this.$el.append( view.render().el );
						}

						if ( 'on' === module.get( 'mhc_fullwidth' ) ){
							$( view.render().el ).addClass( 'mhc_section_fullwidth' );

							var sub_view = new MH_PageComposer.ColumnView( view_settings );

							view.addChildView( sub_view );

							$( view.render().el ).find( '.mhc-section-content' ).append( sub_view.render().el );
						}

						if ( 'on' === module.get( 'mhc_specialty' ) && 'auto' === module.get( 'created' ) ){
							$( view.render().el ).addClass( 'mhc_section_specialty' );

							var mh_view;

							mh_view = new MH_PageComposer.ModalView({
								model : view_settings.model,
								collection : view_settings.collection,
								attributes : {
									'data-open_view' : 'column_specialty_settings'
								},
								mh_view : view,
								view : view
							});

							$('body').append( mh_view.render().el );
						}

						// add Rows layout once the section has been created in "auto" mode

						if ( 'manually' !== module.get( 'created' ) && 'on' !== module.get( 'mhc_fullwidth' ) && 'on' !== module.get( 'mhc_specialty' ) ){
							view.addRow();
						}

						break;
					case 'row' :
					case 'row_inner' :
						view = new MH_PageComposer.RowView( view_settings );

						MH_PageComposer_Layout.addView( module.get('cid'), view );

						/*this.$("[data-cid=" + module.get('parent') + "]").append( view.render().el );*/
						if ( ! _.isUndefined( module.get( 'current_row' ) ) ){
							this.replaceElement( module.get( 'current_row' ), view );
						} else if ( ! _.isUndefined( module.get( 'appendAfter' ) ) ){
							module.get( 'appendAfter' ).after( view.render().el );
						} else if ( cloned_cid ){
							MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( 'div[data-cid="' + cloned_cid + '"]' ).parent().after( view.render().el );
						} else {
							if ( MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '.mhc-section-content' ).length ){
								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '.mhc-section-content' ).append( view.render().el );
							} else {
								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '> .mhc-insert-module' ).hide().end().append( view.render().el );
							}
						}
                        
                // unset the columns_layout to be calculated properly when columns added
                         module.unset( 'columns_layout' );

						// add parent view to inner rows that have been converted from shortcodes
						if ( module.get('created') === 'manually' && module.get('module_type') === 'row_inner' ){
							module.set( 'view', MH_PageComposer_Layout.getView( module.get( 'parent' ) ), { silent : true });
						}

						/*module.get( 'view' ).$el.find( '.mhc-section-content' ).append( view.render().el );*/

						break;
					case 'column' :
					case 'column_inner' :
						view_settings['className'] = 'mhc-column mhc-column-' + module.get( 'layout' );

						if ( ! _.isUndefined( module.get( 'layout_specialty' ) ) && '1' === module.get( 'layout_specialty' ) ){
							view_settings['className'] += ' mhc-column-specialty';
						}

						view = new MH_PageComposer.ColumnView( view_settings );

						MH_PageComposer_Layout.addView( module.get('cid'), view );

						if ( _.isUndefined( module.get( 'layout_specialty' ) ) ){
							/* Need to pass the columns layout into the parent row model to save the row template properly */
							row_parent_view = MH_PageComposer_Layout.getView( module.get( 'parent' ) );
							row_layout = typeof row_parent_view.model.get( 'columns_layout' ) !== 'undefined' ? row_parent_view.model.get( 'columns_layout' ) + ',' + module.get( 'layout' ) : module.get( 'layout' );
							row_parent_view.model.set( 'columns_layout', row_layout );

							if ( MH_PageComposer_Layout.getView( module.get( 'parent' ) ).model.get( 'mhc_specialty' ) !== 'on' ){
								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '.mhc-row-container' ).append( view.render().el );

								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).toggleInsertColumnButton();
							} else {
								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '.mhc-section-content' ).append( view.render().el );
							}
						} else {
							MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '.mhc-section-content' ).append( view.render().el );

							if ( '1' === module.get( 'layout_specialty' ) ){
								if ( 'manually' !== module.get( 'created' ) ){
									this.collection.add( [ {
										type : 'row',
										module_type : 'row',
										cid : MH_PageComposer_Layout.generateNewId(),
										parent : module.get( 'cid' ),
										view : view,
										admin_label : mhc_options.noun['row']
									} ] );
								}

								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).model.set( 'specialty_columns', parseInt( module.get( 'specialty_columns' ) ) );
							}
						}

						/*module.get( 'view' ).$el.find( '.mhc-row-container' ).append( view.render().el );*/

						/*this.$("[data-cid=" + module.get('parent') + "] .mhc-row-container").append( view.render().el );*/

						break;
					case 'module' :
						view_settings['attributes'] = {
							'data-cid' : module.get( 'cid' )
						}

						if ( module.get( 'mode' ) !== 'advanced' && module.get( 'created' ) === 'manually' && MH_PageComposer_Layout.getView( module.get( 'parent' ) ).model.get( 'module_type' ) === 'column_inner' ){
							var inner_column_parent_row = MH_PageComposer_Layout.getView( module.get( 'parent' ) ).model.get( 'parent' );

							MH_PageComposer_Layout.getView( inner_column_parent_row ).$el.find( '.mhc-insert-column' ).hide();
						}

						if ( typeof module.get( 'mode' ) !== 'undefined' && module.get( 'mode' ) === 'advanced' ){
							// create sortable tab

							view = new MH_PageComposer.AdvancedModuleSettingView( view_settings );

							module.attributes.view.child_views.push( view );

							if ( typeof module.get( 'cloned_cid' ) !== 'undefined' && '' !== module.get( 'cloned_cid' ) ){
								MH_PageComposer_Layout.getView( module.get( 'cloned_cid' ) ).$el.after( view.render().el );
							} else {
								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find('.mhc-sortable-options').append( view.render().el );
							}

							MH_PageComposer_Layout.addView( module.get('cid'), view );


						} else {
							var template_type = '';

							MH_PageComposer_Events.trigger( 'mh-new_module:show_settings' );

							view = new MH_PageComposer.BlockModuleView( view_settings );

							if ( typeof module.attributes.view !== 'undefined' && module.attributes.view.model.get( 'mhc_fullwidth' ) === 'on' ){
								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).addChildView( view );
								template_type = MH_PageComposer_Layout.getView( module.get( 'parent' ) ).model.get( 'mhc_template_type' );
							} else if ( typeof module.attributes.view !== 'undefined' ){
								template_type = MH_PageComposer_Layout.getView( MH_PageComposer_Layout.getView( module.get( 'parent' ) ).model.get( 'parent' ) ).model.get( 'mhc_template_type' );
							}

							// Append new module in proper position. Clone shouldn't be appended. It should be added after the cloned item
							if ( cloned_cid ){
								MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( 'div[data-cid="' + cloned_cid + '"]' ).after( view.render().el );
							} else {
								// if .mhc-insert-module button exists, then add the module before that button. Otherwise append module to the parent
								if ( MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '.mhc-insert-module' ).length ){
									MH_PageComposer_Layout.getView( module.get( 'parent' ) ).$el.find( '.mhc-insert-module' ).before( view.render().el );
								} else {
									var parent_view = MH_PageComposer_Layout.getView( module.get( 'parent' ) );

									// append module to appropriate div if it's a fullwidth section
									if ( typeof parent_view.model.get( 'mhc_fullwidth' ) !== 'undefined' && 'on' === parent_view.model.get( 'mhc_fullwidth' ) ){
										parent_view.$el.find( '.mhc_fullwidth_sortable_area' ).append( view.render().el );
									} else {
										parent_view.$el.append( view.render().el );
									}
								}
							}

							MH_PageComposer_Layout.addView( module.get('cid'), view );

							if ( typeof template_type !== 'undefined' && 'module' === template_type ){
								module.set( 'template_type', 'module', { silent : true });
							}

							if ( 'manually' !== module.get( 'created' ) ){
								view_settings['attributes'] = {
									'data-open_view' : 'module_settings'
								}
								this.openModuleSettings( view_settings );
							}
						}
						break;
				}

				// Always unset cloned_cid attribute after adding module.
				// It prevents module mishandling for module which is cloned multiple time
				module.unset('cloned_cid');
			},
            
            openModuleSettings : function( view_settings ){
				var modal_view = new MH_PageComposer.ModalView( view_settings ),
					that = this;

                mh_modal_view_rendered = modal_view.render();
                
                if ( false === mh_modal_view_rendered ) {
					setTimeout(function(){
						that.openModuleSettings( view_settings );
					}, 500 );

					MH_PageComposer_Events.trigger( 'mhc-loading:started' );

					return;
				}

				MH_PageComposer_Events.trigger( 'mhc-loading:ended' );

                $('body').append( mh_modal_view_rendered.el );
			},

			saveAsShortcode : function( mh_model, mh_collection, mh_options ){
				var this_el = this,
					action_setting = arguments.length > 0 && typeof arguments[0] === 'object' && arguments[0]['mh_action'] || '';

				if ( mh_options && mh_options['update_shortcodes'] == 'false' )
					return;

				shortcode = this_el.generateCompleteShortcode();

				this.addHistory( shortcode );

				setTimeout(function(){
					// Save to content is performed each time, except when a layout is being loaded
					var action = action_setting || '';

					mhc_set_content( 'content', shortcode, action );
                    MH_PageComposer_Events.trigger( 'mhc-content-updated' );
                    
				}, 500 );
			},

			generateCompleteShortcode : function( cid, layout_type, ignore_shared_tag, ignore_shared_tabs ){
				var shortcode = '',
					this_el = this,
					all_sections = typeof cid === 'undefined' ? true : false,
					layout_type = typeof layout_type === 'undefined' ? '' : layout_type;

				this.$el.find( '.mhc_section' ).each(function(){
					var $this_section = $(this).find( '.mhc-section-content' ),
						include_whole_section = false,
						skip_section = typeof $this_section.data( 'skip' ) === 'undefined' ? false : $this_section.data( 'skip' );

					if ( ( ( false === all_sections && cid === $this_section.data( 'cid' ) ) || true === all_sections ) && true !== skip_section ){
						shortcode += this_el.generateModuleShortcode( $(this), true, layout_type, ignore_shared_tag );
						include_whole_section = true;
					}

					if ( $this_section.closest( '.mhc_section' ).hasClass( 'mhc_section_fullwidth' ) ){
						$this_section.find( '.mhc_module_block' ).each(function(){
							var fullwidth_module_cid = $( this ).data( 'cid' );
							if ( ( false === all_sections && ( cid === fullwidth_module_cid || true === include_whole_section ) ) || true === all_sections ){
								shortcode += this_el.generateModuleShortcode( $(this), false, layout_type, ignore_shared_tag, '', ignore_shared_tabs );
							}
						});
					} else if ( $this_section.closest( '.mhc_section' ).hasClass( 'mhc_section_specialty' ) && ( ( true === include_whole_section || true === all_sections || 'module' === layout_type || 'row' === layout_type ) && true !== skip_section ) ){
						$this_section.find( '> .mhc-column' ).each(function(){
							var $this_column = $(this),
								column_cid = $this_column.data( 'cid' ),
								module = MH_PageComposer_Modules.findWhere({ cid : column_cid }),
								specialty_columns = module.get( 'layout_specialty' ) === '1' ? ' specialty_columns="' + module.get( 'specialty_columns' ) + '"' : '',
								specialty_column_layout = module.get('layout');

							if ( true === include_whole_section || true === all_sections ){
								shortcode += '[mhc_column type="' + specialty_column_layout + '"' + specialty_columns +']';
							}

							if ( $this_column.hasClass( 'mhc-column-specialty' ) ){
								// choose each row
								$this_column.find( '.mhc_row' ).each(function(){
									var $this_row = $(this),
										row_cid = $this_row.find( '.mhc-row-content' ).data( 'cid' ),
										module = MH_PageComposer_Modules.findWhere({ cid : row_cid }),
										include_whole_inner_row = false;

									if ( true === include_whole_section || true === all_sections || ( 'row' === layout_type && row_cid === cid ) ){
										include_whole_inner_row = true;
										shortcode += this_el.generateModuleShortcode( $(this), true, layout_type, ignore_shared_tag, 'row_inner' );
									}

									$this_row.find( '.mhc-column' ).each(function(){
										var $this_column_inner = $(this),
											column_cid = $this_column_inner.data( 'cid' ),
											module = MH_PageComposer_Modules.findWhere({ cid : column_cid });

										if ( true === include_whole_inner_row ){
											shortcode += '[mhc_column_inner type="' + module.get('layout') + '" saved_specialty_column_type="' + specialty_column_layout + '"]';
										}

										$this_column_inner.find( '.mhc_module_block' ).each(function(){
											var inner_module_cid = $( this ).data( 'cid' );

											if ( ( false === all_sections && ( cid === inner_module_cid || true === include_whole_section || true === include_whole_inner_row ) ) || true === all_sections ){
												shortcode += this_el.generateModuleShortcode( $(this), false, layout_type, ignore_shared_tag, '', ignore_shared_tabs );
											}
										});

										if ( true === include_whole_inner_row ){
											shortcode += '[/mhc_column_inner]';
										}
									});

									if ( true === include_whole_section || true === all_sections || ( 'row' === layout_type && row_cid === cid ) ){
										shortcode += '[/mhc_row_inner]';
									}
								});
							} else {
								// choose each module
								$this_column.find( '.mhc_module_block' ).each(function(){
									var specialty_module_cid = $( this ).data( 'cid' );

									if ( ( false === all_sections && ( cid === specialty_module_cid || true === include_whole_section ) ) || true === all_sections ){
										shortcode += this_el.generateModuleShortcode( $(this), false, layout_type, ignore_shared_tag, '', ignore_shared_tabs );
									}
								});
							}

							if ( true === include_whole_section || true === all_sections ){
								shortcode += '[/mhc_column]';
							}
						});
					} else {
						$this_section.find( '.mhc_row' ).each(function(){
							var $this_row = $(this),
								$this_row_content = $this_row.find( '.mhc-row-content' ),
								row_cid = $this_row_content.data( 'cid' ),
								include_whole_row = false,
								skip_row = typeof $this_row_content.data( 'skip' ) === 'undefined' ? false : $this_row_content.data( 'skip' );

							if ( ( ( false === all_sections && ( cid === row_cid || true === include_whole_section ) ) || true === all_sections ) && true !== skip_row ){
								shortcode += this_el.generateModuleShortcode( $(this), true, layout_type, ignore_shared_tag );
								include_whole_row = true;
							}

							$this_row.find( '.mhc-column' ).each(function(){
								var $this_column = $(this),
									column_cid = $this_column.data( 'cid' ),
									module = MH_PageComposer_Modules.findWhere({ cid : column_cid });

								if ( ( ( false === all_sections && ( true === include_whole_section || true === include_whole_row ) ) || true === all_sections ) && true !== skip_row ){
									shortcode += '[mhc_column type="' + module.get('layout') + '"]';
								}

								$this_column.find( '.mhc_module_block' ).each(function(){
									var module_cid = $( this ).data( 'cid' );
									if ( ( false === all_sections && ( cid === module_cid || true === include_whole_section || true === include_whole_row ) ) || true === all_sections ){
										shortcode += this_el.generateModuleShortcode( $(this), false, layout_type, ignore_shared_tag, '', ignore_shared_tabs );
									}
								});

								if ( ( ( false === all_sections && ( true === include_whole_section || true === include_whole_row ) ) || true === all_sections ) && true !== skip_row ){
									shortcode += '[/mhc_column]';
								}

							});

							if ( ( ( false === all_sections && ( cid === row_cid || true === include_whole_section ) ) || true === all_sections ) && true !== skip_row ){
								shortcode += '[/mhc_row]';
							}

						});
					}
					if ( ( ( false === all_sections && cid === $this_section.data( 'cid' ) ) || true === all_sections ) && true !== skip_section ){
						shortcode += '[/mhc_section]';
					}

				});

			return shortcode;
			},

			generateModuleShortcode : function( $module, open_tag_only, layout_type, ignore_shared_tag, defined_module_type, ignore_shared_tabs ){
				var attributes = '',
					content = '',
					$this_module = $module,
					prefix = $this_module.is( '.mhc_section' ) || $this_module.is( '.mhc_row' ) || $this_module.is( '.mhc_row_inner' )
						? 'mhc_'
						: '',
					module_cid = typeof $this_module.data( 'cid' ) === 'undefined'
						? $this_module.find( '.mhc-data-cid' ).data( 'cid' )
						: $this_module.data( 'cid' ),
					module = MH_PageComposer_Modules.find(function( model ){
						return model.get('cid') == module_cid;
					}),
					module_type = typeof module !== 'undefined' ? module.get( 'module_type' ) : 'undefined',
					module_settings,
					shortcode,
					template_module_type;

				if ( typeof defined_module_type !== 'undefined' && '' !== defined_module_type ){
					module_type = defined_module_type;
				}

				module_settings = module.attributes;
                
//                if ( typeof ignore_shared_tag !== 'undefined' && 'ignore_shared' === ignore_shared_tag && typeof module_settings.mhc_saved_tabs !== 'undefined' && 'all' !== module_settings.mhc_saved_tabs && -1 === module_settings.mhc_saved_tabs.indexOf( 'general' ) ){
//					delete module_settings['admin_label'];
//				}

                for ( var key in module_settings ){
					if ( typeof ignore_shared_tag === 'undefined' || 'ignore_shared' !== ignore_shared_tag || ( typeof ignore_shared_tag !== 'undefined' && 'ignore_shared' === ignore_shared_tag && 'mhc_shared_module' !== key && 'mhc_shared_parent' !== key ) ){
						if ( typeof ignore_shared_tabs === 'undefined' || 'ignore_shared_tabs' !== ignore_shared_tabs || ( typeof ignore_shared_tabs !== 'undefined' && 'ignore_shared_tabs' === ignore_shared_tabs && 'mhc_saved_tabs' !== key ) ){
							var setting_name = key,
								setting_value;

							if ( setting_name.indexOf( 'mhc_' ) === -1 && setting_name !== 'admin_label' ) continue;

							setting_value = typeof( module.get( setting_name ) ) !== 'undefined' ? module.get( setting_name ) : '';

							if ( setting_name === 'mhc_content_new' || setting_name === 'mhc_raw_content' ){
								content = setting_value;

								if ( setting_name === 'mhc_raw_content' ){
									content = _.escape( content );
								}

								content = $.trim( content );

								if ( setting_name === 'mhc_content_new' ){
									content = "\n\n" + content + "\n\n";
								}

							} else if ( setting_value !== '' ){
								// check if there is a default value for a setting
								if ( typeof module_settings['module_defaults'] !== 'undefined' && typeof module_settings['module_defaults'][ setting_name ] !== 'undefined' ){
									var module_setting_default = module_settings['module_defaults'][ setting_name ],
										string_setting_value = setting_value + '';
									// don't add an attribute to a shortcode, if default value is equal to the current value
									if ( module_setting_default === setting_value ){
										delete module.attributes[ setting_name ];
										continue;
									}
								}

								setting_name = setting_name.replace( 'mhc_', '' );

								// Make sure double quotes are encoded, before adding values to shortcode
								if ( typeof setting_value === 'string' ){
									setting_value = setting_value.replace( /\"/g, '%22' );
								}

								attributes += ' ' + setting_name + '="' + setting_value + '"';
							}
						}
					}
				}

				template_module_type = 'section' !== module_type && 'row' !== module_type ? 'module' : module_type;
				template_module_type = 'row_inner' === module_type ? 'row' : template_module_type;

				if ( typeof layout_type !== 'undefined' && ( layout_type === template_module_type ) ){
					attributes += ' template_type="' + layout_type + '"';
				}

				if ( typeof module_settings['template_type'] !== 'undefined' ){
					attributes += ' template_type="' + module_settings['template_type'] + '"';
				}

				shortcode = '[' + prefix + module_type + attributes;

				if ( content === '' && ( typeof module_settings['type'] !== 'undefined' && module_settings['type'] === 'module' ) ){
					open_tag_only = true;
					shortcode += ' /]';
				} else {
					shortcode += ']';
				}

				if ( ! open_tag_only )
					shortcode += content + '[/' + prefix + module_type + ']';

				return shortcode;
			},

			makeSectionsSortable : function(){
				var this_el = this;

				this.$el.sortable({
					items  : '> *:not(#mhc_layout_controls, #mhc_main_container_right_click_overlay, #mhc-histories-visualizer, #mhc-histories-visualizer-overlay)',
					cancel : '.mhc-settings, .mhc-clone, .mhc-remove, .mhc-section-add, .mhc-row-add, .mhc-insert-module, .mhc-insert-column, .mhc_locked, .mhc-disable-sort',
                    delay: 100,
					update : function( event, ui ){
						// Enable history saving and set meta for history
						this_el.allowHistorySaving( 'moved', 'section' );

						MH_PageComposer_Events.trigger( 'mh-sortable:update' );
					},
					start : function( event, ui ){
						mhc_close_all_right_click_options();
					}
				});
			},

			reInitialize : function(){
				var content = mhc_get_content( 'content' ),
					contentIsEmpty = content == '',
					default_initial_column_type = mhc_options.default_initial_column_type,
					default_initial_text_module = mhc_options.default_initial_text_module;

				MH_PageComposer_Events.trigger( 'mhc-loading:started' );

				this.removeAllSections();

				if ( content.indexOf( '[mhc_section' ) === -1 ){
					if ( ! contentIsEmpty ){
						content = '[mhc_column type="' + default_initial_column_type + '"][' + default_initial_text_module + ']' + content + '[/' + default_initial_text_module + '][/mhc_column]';
					}

					content = '[mhc_section][mhc_row]' + content + '[/mhc_row][/mhc_section]';
				}

				this.createNewLayout( content );

				MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
			},

			removeAllSections : function( create_initial_layout ){
				var content;

				// force removal of all the sections and rows
				MH_PageComposer_Layout.set( 'forceRemove', true );

				this.$el.find( '.mhc-section-content' ).each(function(){
					var $this_el = $(this),
						this_view = MH_PageComposer_Layout.getView( $this_el.data( 'cid' ) );

					// don't remove cloned sections
					if ( typeof this_view !== 'undefined' ){
						// Remove sections. Use remove_all flag so it can differ "remove section" and "clear layout"
						this_view.removeSection( false, true );
					}
				});

				MH_PageComposer_Layout.set( 'forceRemove', false );

				if ( create_initial_layout ){
					content = '[mhc_section][mhc_row][/mhc_row][/mhc_section]';
					this.createNewLayout( content );
				}
			},

			// creates new layout from any content and saves new shortcodes once
			createNewLayout : function( content, action ){
				var action = action || '';

				this.stopListening( this.collection, 'change reset add', this.saveAsShortcode );

				if ( action === 'load_layout' && typeof window.switchEditors !== 'undefined' ){
					content = window.switchEditors.wpautop( content );

					content = content.replace( /<p>\[/g, '[' );
					content = content.replace( /\]<\/p>/g, ']' );
					content = content.replace( /\]<br \/>/g, ']' );
					content = content.replace( /<br \/>\n\[/g, '[' );
				}

				this.createLayoutFromContent( content );

				this.saveAsShortcode({ mh_action : action });

				this.listenTo( this.collection, 'change reset add', _.debounce( this.saveAsShortcode, 128 ) );
			},

			//replaces the Original element with Replacement element in composer
			replaceElement : function ( original_cid, replacement_view ){
				var original_view = MH_PageComposer_Layout.getView( original_cid );

				original_view.$el.after( replacement_view.render().el );

				original_view.model.destroy();

				MH_PageComposer_Layout.removeView( original_cid );

				original_view.remove();
			},

			showRightClickOptions : function( event ){
				event.preventDefault();

				var mh_right_click_options_view,
					view_settings = {
						model      : {
							attributes : {
								type : 'app',
								module_type : 'app'
							}
						},
						view       : this.$el,
						view_event : event
					};

				mh_right_click_options_view = new MH_PageComposer.RightClickOptionsView( view_settings );
			},

			hideRightClickOptions : function( event ){
				event.preventDefault();

				mhc_close_all_right_click_options();
            },
            
            // calculates the order for each component
			recalculateModulesOrder : function(){
				var all_modules = this.collection;

				this.order_modules_array = [];
				this.order_modules_array['children_count'] = [];

				// go through all the components content and set the module_order attribute for each.
				this.$el.find( '.mhc_section' ).each(function(){
					var $this_section = $(this).find( '.mhc-section-content' ),
						section_cid = $this_section.data( 'cid' );

					MH_PageComposer_App.setModuleOrder( section_cid );

					if ( $this_section.closest( '.mhc_section' ).hasClass( 'mhc_section_fullwidth' ) ){
						$this_section.find( '.mhc_module_block' ).each(function(){
							var fullwidth_module_cid = $( this ).data( 'cid' );

							MH_PageComposer_App.setModuleOrder( fullwidth_module_cid );
						});
					} else if ( $this_section.closest( '.mhc_section' ).hasClass( 'mhc_section_specialty' ) ){
						$this_section.find( '> .mhc-column' ).each(function(){
							var $this_column = $(this),
								column_cid = $this_column.data( 'cid' );

							MH_PageComposer_App.setModuleOrder( column_cid );

							if ( $this_column.hasClass( 'mhc-column-specialty' ) ){
								// choose each row
								$this_column.find( '.mhc_row' ).each(function(){
									var $this_row = $(this),
										row_cid = $this_row.find( '.mhc-row-content' ).data( 'cid' );

									MH_PageComposer_App.setModuleOrder( row_cid );

									$this_row.find( '.mhc-column' ).each(function(){
										var $this_column_inner = $(this),
											column_cid = $this_column_inner.data( 'cid' );

										MH_PageComposer_App.setModuleOrder( column_cid );

										$this_column_inner.find( '.mhc_module_block' ).each(function(){
											var inner_module_cid = $( this ).data( 'cid' );

											MH_PageComposer_App.setModuleOrder( inner_module_cid );
										});
									});
								});
							} else {
								// choose each module
								$this_column.find( '.mhc_module_block' ).each(function(){
									var specialty_module_cid = $( this ).data( 'cid' );

									MH_PageComposer_App.setModuleOrder( specialty_module_cid, 'specialty' );
								});
							}
						});
					} else {
						$this_section.find( '.mhc_row' ).each(function(){
							var $this_row = $(this),
								$this_row_content = $this_row.find( '.mhc-row-content' ),
								row_cid = $this_row_content.data( 'cid' );

							MH_PageComposer_App.setModuleOrder( row_cid );

							$this_row.find( '.mhc-column' ).each(function(){
								var $this_column = $(this),
									column_cid = $this_column.data( 'cid' );

								MH_PageComposer_App.setModuleOrder( column_cid );

								$this_column.find( '.mhc_module_block' ).each(function(){
									var module_cid = $( this ).data( 'cid' );

									MH_PageComposer_App.setModuleOrder( module_cid );
								});
							});
						});
					}
				});
			},

			// reload content for the Yoast after it was changed in the composer
			updateYoastContent : function(){
				if ( ! mhc_is_yoast_seo_active() ){
					return;
				}

				var content = mhc_get_content( 'content', true );
                //perform the do_shortcode for the current content from composer
                //and force Yoast to reload
				$.ajax({
					type: "POST",
					url: mhc_options.ajaxurl,
					data: {
						action : 'mhc_execute_content_shortcodes',
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mhc_unprocessed_data : content
					},
					success: function( data ){
						mhc_processed_yoast_content = data;
						YoastSEO.app.pluginReloaded( 'MHC_Yoast_Content' );
					}
				});
            },
            
            // calculate and add the module_order attribute for the module.
			setModuleOrder: function( cid, is_specialty ){
				var modules_with_child = $.parseJSON( mhc_options.mh_composer_modules_with_children ),
					current_model,
					module_order,
					parent_row,
					module_type,
					start_from,
					child_slug;

				current_model = MH_PageComposer_Modules.findWhere({ cid : cid });

				module_type = typeof current_model.attributes.module_type !== 'undefined' ? current_model.attributes.module_type : current_model.attributes.type;

				// determine the column type. Check the parent, if parent == row_inner, then column type = column_inner
				if ( 'column' === module_type || 'column_inner' === module_type || 'specialty' === is_specialty ){
					parent_row = MH_PageComposer_Modules.findWhere({ cid : current_model.attributes.parent });

					// inner columns may have column module_type, so check the parent row to determine the column_inner type
					if ( 'column' === module_type && 'row_inner' === parent_row.attributes.module_type ){
						module_type = 'column_inner';
					}
				}

				// check whether the module order exist for current module_type otherwise set to 0
				module_order = typeof this.order_modules_array[ module_type ] !== 'undefined' ? this.order_modules_array[ module_type ] : 0;

				current_model.attributes.module_order = module_order;

				// reset columns_order attribute to recalculate it properly
				if ( ( 'row' === module_type || 'row_inner' === module_type || 'section' === module_type ) && typeof current_model.attributes.columns_order !== 'undefined' ){
					current_model.attributes.columns_order = [];
				}

				// columns order should be stored in the Row/Specialty section as well
				if ( 'column' === module_type || 'column_inner' === module_type || 'specialty' === is_specialty ){
					if ( typeof parent_row.attributes.columns_order !== 'undefined' ){
						parent_row.attributes.columns_order.push( module_order );
					} else {
						parent_row.attributes.columns_order = [ module_order ];
					}
				}

				// calculate child items for modules which support them and update count in module attributes
				if ( typeof modules_with_child[ module_type ] !== 'undefined' ){
					child_slug = modules_with_child[ module_type ];
					start_from = typeof this.order_modules_array['children_count'][ child_slug ] !== 'undefined' ? this.order_modules_array['children_count'][ child_slug ] : 0;
					current_model.attributes.child_start_from = start_from; // this attributed used as a start point for calculation of child modules order

					if ( typeof current_model.attributes.mhc_content_new !== 'undefined' && '' !== current_model.attributes.mhc_content_new ){
						mhc_shortcodes_tags = MH_PageComposer_App.getShortCodeChildTags(),
						reg_exp = window.wp.shortcode.regexp( mhc_shortcodes_tags ),
						matches = current_model.attributes.mhc_content_new.match( reg_exp );
						start_from += null !== matches ? matches.length : 0;
					}

					this.order_modules_array['children_count'][ child_slug ] = start_from;
				}

				// increment the module order for current module_type
				this.order_modules_array[ module_type ] = module_order + 1;
			},

			updateAdvancedModulesOrder: function( $this_el ){
				var $modules_container = typeof $this_el !== 'undefined' ? $this_el.find( '.mhc-option-advanced-module-settings' ) : $( '.mhc-option-advanced-module-settings' ),
					modules_count = 0,

					$modules_list;

				if ( $modules_container.length ){
					$modules_list = $modules_container.find( '.mhc-sortable-options > li' );

					if ( $modules_list.length ){
						$modules_list.each(function(){
							var $this_item = $( this ),
								this_cid = $this_item.data( 'cid' ),
								current_model,
								current_parent,
								start_from;

							current_model = MH_PageComposer_Modules.findWhere({ cid : this_cid });
							current_parent = MH_PageComposer_Modules.findWhere({ cid : current_model.attributes.parent_cid });

							start_from = typeof current_parent.attributes.child_start_from !== 'undefined' ? current_parent.attributes.child_start_from : 0;

							current_model.attributes.module_order = modules_count + start_from;

							modules_count++;
						});
					}
				}
			}

		});

		// Close and remove right click options
		function mhc_close_all_right_click_options(){
			// Remove right click options UI
			$('#mh-composer-right-click-controls').remove();

			// Remove composer overlay (right/left click anywhere outside composer to close right click options UI)
			$('#mhc_layout_right_click_overlay').remove();
		}

		$('body').on( 'click contextmenu', '#mhc_layout_right_click_overlay', function( event ){
			event.preventDefault();

			mhc_close_all_right_click_options();
		});

		function mhc_activate_upload( $upload_button ){
			$upload_button.click(function( event ){
				var $this_el = $(this);

				event.preventDefault();

				mhc_file_frame = wp.media.frames.mhc_file_frame = wp.media({
					title: $this_el.data( 'choose' ),
					library: {
						type: $this_el.data( 'type' )
					},
					button: {
						text: $this_el.data( 'update' ),
					},
					multiple: false
				});

				mhc_file_frame.on( 'select', function(){
					var attachment = mhc_file_frame.state().get('selection').first().toJSON();

					$this_el.siblings( '.mhc-upload-field' ).val( attachment.url );

					mhc_generate_preview_image( $this_el );
				});

				mhc_file_frame.open();
			});

			$upload_button.siblings( '.mhc-upload-field' ).on( 'input', function(){
				mhc_generate_preview_image( $(this).siblings( '.mhc-upload-button' ) );
			});

			$upload_button.siblings( '.mhc-upload-field' ).each(function(){
				mhc_generate_preview_image( $(this).siblings( '.mhc-upload-button' ) );
			});
		}

		function mhc_activate_gallery( $gallery_button ){
			$gallery_button.click(function( event ){
				var $this_el = $(this)
					$gallery_ids = $gallery_button.closest( '.mhc-option' ).siblings( '.mhc-option-gallery_ids' ).find( '.mhc-gallery-ids-field' ),
					$gallery_orderby = $gallery_button.closest( '.mhc-option' ).siblings( '.mhc-option-gallery_orderby' ).find( '.mhc-gallery-ids-field' );

				event.preventDefault();

				// Check if the `wp.media.gallery` API exists.
				if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.gallery )
					return;

				var gallery_ids = $gallery_ids.val().length ? ' ids="' + $gallery_ids.val() + '"' : '',
					gallery_orderby = $gallery_orderby.val().length ? ' orderby="' + $gallery_orderby.val() + '"' : '',
					gallery_shortcode = '[gallery' + gallery_ids + gallery_orderby + ']';

				mhc_file_frame = wp.media.frames.mhc_file_frame = wp.media.gallery.edit( gallery_shortcode );

				if ( !gallery_ids ){
					mhc_file_frame.setState('gallery-vault');
				}

				// Remove the 'Columns' and 'Link To' unneeded settings
				function remove_unneeded_gallery_settings( $el ){
					setTimeout(function(){
						$el.find( '.gallery-settings' ).find( 'label.setting' ).each(function(){
							if ( $(this).find( '.link-to, .columns, .size' ).length ){
								$(this).remove();
							} else {
								if ( $(this).has( 'input[type=checkbox]' ).length ){
									$(this).children( 'input[type=checkbox]' ).css( 'margin', '11px 5px' );
								}
							}
						});
					}, 10 );
				}
				// Remove initial unneeded settings
				remove_unneeded_gallery_settings( mhc_file_frame.$el );
				// Remove unneeded settings upon re-viewing edit view
				mhc_file_frame.on( 'content:render:browse', function( browser ){
					remove_unneeded_gallery_settings( browser.$el );
				});

				mhc_file_frame.state( 'gallery-edit' ).on( 'update', function( selection ){

					var shortcode_atts = wp.media.gallery.shortcode( selection ).attrs.named;
					if ( shortcode_atts.ids ){
						$gallery_ids.val( shortcode_atts.ids );
					}

					if ( shortcode_atts.orderby ){
						$gallery_orderby.val( shortcode_atts.orderby );
					} else {
						$gallery_orderby.val( '' );
					}

				});

			});
		}

		function mhc_generate_video_image( $video_image_button ){
			$video_image_button.click(function( event ){
				var $this_el = $(this),
					$upload_field = $( '#mhc_src.mhc-upload-field' ),
					video_url = $upload_field.val().trim();

				event.preventDefault();

				$.ajax({
					type: "POST",
					url: mhc_options.ajaxurl,
					data:
					{
						action : 'mhc_video_get_oembed_thumbnail',
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mh_video_url : video_url
					},
					success: function( response ){
						if ( response.length ){
							$('#mhc_image_src').val( response ).trigger('input');
						} else {
							$this_el.after( '<div class="mhc-error">' + mhc_options.video_module_image_error + '</div>' );
							$this_el.siblings('.mhc-error').delay(5000).fadeOut(800);
						}

					}
				});
			});
		}

		function mhc_generate_preview_image( $upload_button ){
			var $upload_field = $upload_button.siblings( '.mhc-upload-field' ),
				$preview = $upload_field.siblings( '.mhc-upload-preview' ),
				image_url = $upload_field.val().trim();

			if ( $upload_button.data( 'type' ) !== 'image' ) return;

			if ( image_url === '' ){
				if ( $preview.length ) $preview.remove();

				return;
			}

			if ( ! $preview.length ){
				$upload_button.siblings('.description').before( '<div class="mhc-upload-preview">' + '<strong class="mhc-upload-preview-title">' + mhc_options.preview_image + '</strong>' + '<img src="" width="408" /></div>' );
				$preview = $upload_field.siblings( '.mhc-upload-preview' );
			}

			$preview.find( 'img' ).attr( 'src', image_url );
		}

		var MH_PageComposer_Events = _.extend({}, Backbone.Events ),
			MH_PageComposer_Layout = new MH_PageComposer.Layout,
			MH_PageComposer_Modules = new MH_PageComposer.Modules,
			MH_PageComposer_Histories = new MH_PageComposer.Histories,
			MH_PageComposer_App = new MH_PageComposer.AppView({
				model : MH_PageComposer.Module,
				collection : MH_PageComposer_Modules,
				history : MH_PageComposer_Histories
			}),
			MH_PageComposer_Visualize_Histories = new MH_PageComposer.visualizeHistoriesView,
			$mhc_content = $( '#mhc_hidden_editor' ),
			mhc_content_html = $mhc_content.html(),
			mhc_file_frame,
			$toggle_composer_button = $('#mhc_toggle_composer'),
			$toggle_composer_button_wrapper = $('.mhc_toggle_composer_wrapper'),
			$composer = $( '#mhc_layout' ),
			$mhc_old_content = $('#mhc_old_content'),
			$post_format_wrapper = $('#formatdiv'),
			$use_composer_custom_field = $( '#mhc_use_composer' ),
			$main_editor_wrapper = $( '#mhc_main_editor_wrap' ),
			$mhc_setting = $( '.mhc_page_setting' ),
			$mhc_layout_settings = $( '.mhc_page_layout_settings' ),
			$mhc_templates_cache = [],
			mhc_shareds_requested = 0,
			mhc_shareds_loaded = 0,
            mhc_processed_yoast_content = false,
            mhc_quick_tags_init_done = {};

		MH_PageComposer.Events = MH_PageComposer_Events;

		$mhc_content.remove();

		// button can be disabled, therefore use the button wrapper to determine whether to display composer or not
		if ( $toggle_composer_button_wrapper.hasClass( 'mhc_composer_is_used' ) ){
			$composer.show();

			mhc_hide_layout_settings();
		}

		$toggle_composer_button.click(function( event ){
			event.preventDefault();

			var $this_el = $(this),
				is_composer_used = $this_el.hasClass( 'mhc_composer_is_used' ),
				content;

			if ( is_composer_used ){
				mhc_create_prompt_modal( 'deactivate_composer' );
			} else {
				content = mhc_get_content( 'content' );

				$mhc_old_content.val( content );

				MH_PageComposer_App.reInitialize();

				$use_composer_custom_field.val( 'on' );

				$composer.show();

				$this_el.text( $this_el.data( 'editor' ) );

				$main_editor_wrapper.toggleClass( 'mhc_hidden' );

				$this_el.toggleClass( 'mhc_composer_is_used' );

				MH_PageComposer_Events.trigger( 'mh-activate-composer' );

				mhc_hide_layout_settings();
			}
		});

		function mhc_deactivate_composer(){
			var $body = $( 'body' ),
				page_position = 0;

			mhc_set_content( 'content', $mhc_old_content.val() );

			window.wpActiveEditor = 'content';

			$use_composer_custom_field.val( 'off' );

			$composer.hide();

			$toggle_composer_button.text( $toggle_composer_button.data( 'composer' ) ).toggleClass( 'mhc_composer_is_used' );

			$main_editor_wrapper.toggleClass( 'mhc_hidden' );

			mhc_show_layout_settings();

			page_position = $body.scrollTop();

			$body.scrollTop( page_position + 1 );

			MH_PageComposer_Events.trigger( 'mh-deactivate-composer' );

			//trigger window resize event to trigger tinyMCE editor toolbar sizes recalculation.
			$( window ).trigger( 'resize' );
		}

		function mhc_create_prompt_modal( action, cid_or_element, module_width, columns_layout ){
			var	on_top_class = -1 !== $.inArray( action, [ 'save_template', 'reset_advanced_settings' ] ) ? ' mh_modal_on_top' : '',
				on_top_both_actions_class = 'reset_advanced_settings' === action ? ' mh_modal_on_top_both_actions' : '',
				$modal = $( '<div class="mhc_modal_overlay' + on_top_class + on_top_both_actions_class + '" data-action="' + action + '"></div>' ),
				modal_interface = $( '#mh-composer-prompt-modal-' + action ).length ? $( '#mh-composer-prompt-modal-' + action ).html() : $( '#mh-composer-prompt-modal' ).html(),
				modal_content = _.template( $( '#mh-composer-prompt-modal-' + action + '-text' ).html() ),
				modal_attributes = {},
				$switch_button_wrapper,
				$switch_button,
				$switch_select;

			mhc_close_all_right_click_options();

			// Lock body scroll
			$('body').addClass('mhc_stop_scroll');
            
			if ( 'save_template' === action ){
				var current_view = MH_PageComposer_Layout.getView( cid_or_element.model.get( 'cid' ) ),
					parent_view = typeof current_view.model.get( 'parent' ) !== 'undefined' ? MH_PageComposer_Layout.getView( current_view.model.get( 'parent' ) ) : '',
					$shared_children = current_view.$el.find( '.mhc_shared' ),
					has_shared = $shared_children.length ? 'has_shared' : 'no_shareds';

				modal_attributes.is_shared = typeof current_view.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== current_view.model.get( 'mhc_shared_module' ) ? 'shared' : 'regular';
				modal_attributes.is_shared_child = '' !== parent_view && ( ( typeof parent_view.model.get( 'mhc_shared_module' ) !== 'undefined' && '' !== parent_view.model.get( 'mhc_shared_module' ) ) || ( typeof parent_view.model.get( 'shared_parent_cid' ) !== 'undefined' && '' !== parent_view.model.get( 'shared_parent_cid' ) ) ) ? 'shared' : 'regular';
				modal_attributes.module_type = current_view.model.get( 'type' );
			}

			$modal.append( modal_interface );

			$modal.find( '.mhc_prompt_modal' ).prepend( modal_content( modal_attributes ) );

			$( 'body' ).append( $modal );
            
            if ( $('.mhc_prompt_modal').css('bottom') === 'auto' ) {
				window.mhc_align_vertical_modal( $modal.find('.mhc_prompt_modal'), '.mhc_prompt_buttons' );
			}

			setTimeout(function(){
				$modal.find('select, input, textarea, radio').filter(':eq(0)').focus();
			}, 1 );

			if ( 'rename_admin_label' === action ){
				var admin_label = $modal.find( 'input#mhc_new_admin_label' ),
					current_view = MH_PageComposer_Layout.getView( cid_or_element ),
					current_admin_label = current_view.model.get( 'admin_label' ).trim();

				if ( current_admin_label !== '' ){
					admin_label.val( current_admin_label );
				}
			}

			$( '.mhc_modal_overlay .mhc_prompt_proceed' ).click(function( event ){
				event.preventDefault();

				var $prompt_modal = $(this).closest( '.mhc_modal_overlay' );

				switch( $prompt_modal.data( 'action' ).trim() ){
					case 'deactivate_composer' :
						mhc_deactivate_composer();
						break;
					case 'clear_layout' :
						MH_PageComposer_App.removeAllSections( true );
						break;

					case 'rename_admin_label' :
						var admin_label = $prompt_modal.find( '#mhc_new_admin_label' ).val().trim(),
							current_view = MH_PageComposer_Layout.getView( cid_or_element );

						//@todo Do we want to allow blank admin labels
						if ( admin_label == '' ){
							$prompt_modal.find( '#mhc_new_admin_label' ).focus()

							return;
						}

						current_view.model.set( 'admin_label', admin_label, { silent : true });
						current_view.renameModule();

						// Enable history saving and set meta for history
						MH_PageComposer_App.allowHistorySaving( 'renamed', 'module', admin_label );

						mh_reinitialize_composer_layout();

						break;
					case 'reset_advanced_settings' :
						cid_or_element.each(function(){
							mhc_reset_element_settings( $(this) );
						});
						break;
					case 'save_layout' :
						var layout_name = $prompt_modal.find( '#mhc_new_layout_name' ).val().trim();

						if ( layout_name == '' ){
							$prompt_modal.find( '#mhc_new_layout_name' ).focus()

							return;
						}

						$.ajax({
							type: "POST",
							url: mhc_options.ajaxurl,
							data:
							{
								action : 'mhc_save_layout',
								mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
								mh_layout_name : layout_name,
								mh_layout_content : mhc_get_content( 'content' ),
								mh_layout_type : 'layout',
								mh_post_type : mhc_options.post_type
							},
							success: function( data ){
							}
						});

						break;
					case 'save_template' :
						var template_name                = $prompt_modal.find( '#mhc_new_template_name' ).val().trim(),
							layout_scope                 = $prompt_modal.find( $( '#mhc_template_shared' ) ).is( ':checked' ) ? 'shared' : 'not_shared',
							$module_settings_container   = $( '.mhc_module_settings' ),
							module_type                  = $module_settings_container.data( 'module_type' ),
							layout_type                  = ( 'section' === module_type || 'row' === module_type ) ? module_type : 'module',
							module_width_upd             = typeof module_width !== 'undefined' ? module_width : 'regular',
							module_cid                   = cid_or_element.model.get( 'cid' ),
							template_shortcode           = '',
							selected_tabs                = '',
							selected_cats                = '',
							new_cat                      = $prompt_modal.find( '#mhc_new_cat_name' ).val(),
							ignore_shared                = typeof has_shared !== 'undefined' && 'has_shared' === has_shared && 'shared' === layout_scope ? 'ignore_shared' : 'include_shared',
							ignore_saved_tabs            = 'ignore_shared' === ignore_shared ? ignore_shared_tabs : '',
                            $modal_settings_container    = $( '.mhc_modal_settings_container' ),
							$modal_overlay               = $( '.mhc_modal_overlay' );

							layout_type = 'row_inner' === module_type ? 'row' : layout_type;

						if ( template_name == '' ){
							$prompt_modal.find( '#mhc_new_template_name' ).focus();

							return;
						}

						if ( $( '.mhc_select_module_tabs' ).length ){
							if ( ! $( '.mhc_select_module_tabs input' ).is( ':checked' ) ){
								$( '.mhc_error_message_save_template' ).css( "display", "block" );
								return;
							} else {
								selected_tabs = '';

								$( '.mhc_select_module_tabs input' ).each(function(){
									var this_input = $( this );

									if ( this_input.is( ':checked' ) ){
										selected_tabs += '' !== selected_tabs ? ',' + this_input.val() : this_input.val();
									}

								});

								selected_tabs = 'general,advanced,css' === selected_tabs ? 'all' : selected_tabs;
							}

							if ( 'all' !== selected_tabs ){
								var selected_tabs_selector = '',
									selected_tabs_array = selected_tabs.split(','),
									existing_attributes = cid_or_element.model.attributes;

								_.each( selected_tabs_array, function ( tab ){
									switch ( tab ){
										case 'general' :
											selected_tabs_selector += '.mhc-options-tab-general input, .mhc-options-tab-general select, .mhc-options-tab-general textarea';
											break;
										case 'advanced' :
											selected_tabs_selector += '' !== selected_tabs_selector ? ',' : '';
											selected_tabs_selector += '.mhc-options-tab-advanced input, .mhc-options-tab-advanced select, .mhc-options-tab-advanced textarea';
											break;
										case 'css' :
											selected_tabs_selector += '' !== selected_tabs_selector ? ',' : '';
											selected_tabs_selector += '.mhc-options-tab-custom_css input, .mhc-options-tab-custom_css select, .mhc-options-tab-custom_css textarea';
											break;
									}
								});

								_.each( existing_attributes, function( value, key ){
									if ( -1 !== key.indexOf( 'mhc_' ) ){
										cid_or_element.model.unset( key, { silent : true });
									}
								});
							}

							cid_or_element.model.set( 'mhc_saved_tabs', selected_tabs, { silent : true });
						}

						if ( $( '.layout_cats_container input' ).is( ':checked' ) ){

							$( '.layout_cats_container input' ).each(function(){
								var this_input = $( this );

								if ( this_input.is( ':checked' ) ){
									selected_cats += '' !== selected_cats ? ',' + this_input.val() : this_input.val();
								}
							});

						}

						cid_or_element.performSaving( selected_tabs_selector );

						template_shortcode = MH_PageComposer_App.generateCompleteShortcode( module_cid, layout_type, ignore_shared, ignore_saved_tabs );

						if ( 'row_inner' === module_type ){
							template_shortcode = template_shortcode.replace( /mhc_row_inner/g, 'mhc_row' );
							template_shortcode = template_shortcode.replace( /mhc_column_inner/g, 'mhc_column' );
						}

						// save all the settings after template was generated.
						if ( 'all' !== selected_tabs ){
							cid_or_element.performSaving();
						}
                        
                        $modal_settings_container.addClass( 'mhc_modal_closing' );
						$modal_overlay.addClass( 'mhc_overlay_closing' );

						setTimeout(function(){
							$modal_settings_container.remove();
							$modal_overlay.remove();
							$( 'body' ).removeClass( 'mhc_stop_scroll' );
						}, 600 );

						$.ajax({
							type: "POST",
							url: mhc_options.ajaxurl,
							dataType: 'json',
							data:
							{
								action : 'mhc_save_layout',
								mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
								mh_layout_name : template_name,
								mh_layout_content : template_shortcode,
								mh_layout_scope : layout_scope,
								mh_layout_type : layout_type,
								mh_module_width : module_width_upd,
								mh_columns_layout : columns_layout,
								mh_selected_tabs : selected_tabs,
								mh_module_type : module_type,
								mh_layout_cats : selected_cats,
								mh_layout_new_cat : new_cat,
								mh_post_type : mhc_options.post_type,
							},
							beforeSend: function( data ){
								//show overlay which blocks the entire screen to avoid js errors if user starts editing the module immediately after saving
								if ( 'shared' === layout_scope ){
									if ( ! $( 'body' ).find( '.mhc_shared_loading_overlay' ).length ){
										$( 'body' ).append( '<div class="mhc_shared_loading_overlay"></div>' );
									}
								}
							},
							success : function( data ){
								if ( 'shared' === layout_scope ){
									var model = MH_PageComposer_App.collection.find(function( model ){
										return model.get( 'cid' ) == module_cid;
									});

									model.set( 'mhc_shared_module', data.post_id );

									if ( 'ignore_shared' === ignore_shared ){
										if ( $shared_children.length ){
											$shared_children.each(function(){
												var child_cid = $( this ).data( 'cid' );

												if ( typeof child_cid !== 'undefined' && '' !== child_cid ){
													var child_model = MH_PageComposer_App.collection.find(function( model ){
														return model.get( 'cid' ) == child_cid;
													});

													child_model.unset( 'mhc_shared_module' );
													child_model.unset( 'mhc_saved_tabs' );
												}
											});
										}
									}

									mh_reinitialize_composer_layout();

									setTimeout(function(){
										$( 'body' ).find( '.mhc_shared_loading_overlay' ).remove();
									}, 650 );
								}
							}
						});
						break;
				}

				mhc_close_modal( $( this ) );
			});

			$( '.mhc_modal_overlay .mhc_prompt_dont_proceed' ).click(function( event ){
				event.preventDefault();

				mhc_close_modal( $( this ) );
			});
		}

        function mhc_handle_clone_class( $element ){
			$element.addClass( 'mhc_animate_clone' );

			setTimeout(function(){
				if ( $element.length ){
					$element.removeClass( 'mhc_animate_clone' );
				}
			}, 500 );
		}

		function mhc_close_modal( $this_button ){
			var $modal_overlay = $this_button.closest( '.mhc_modal_overlay' );
            
            // Unlock body scroll
			$('body').removeClass('mhc_stop_scroll');

			$modal_overlay.addClass( 'mhc_modal_closing' );

			setTimeout(function(){
				$modal_overlay.remove();
			}, 600 );
		}

		function mhc_close_modal_view( that, trigger_event ){
			that.removeOverlay();

			$( '.mhc_modal_settings_container' ).addClass( 'mhc_modal_closing' );

			setTimeout(function(){
				that.remove();

				if ( 'trigger_event' === trigger_event ){
					MH_PageComposer_Events.trigger( 'mh-modal-view-removed' );
				}
			}, 600 );
		}

		function mhc_hide_layout_settings(){
			if ( $mhc_setting.filter( ':visible' ).length > 1 ){
				$mhc_layout_settings.find('.mhc_page_layout_settings').hide();
				$mhc_layout_settings.find('.mhc_side_nav_settings').show();
			}
			else{
				if ( 'post' !== mhc_options.post_type ){
					$mhc_layout_settings.closest( '#mh_settings_meta_box' ).find('.mhc_page_layout_settings').hide();
				}

				$mhc_layout_settings.closest( '#mh_settings_meta_box' ).find('.mhc_side_nav_settings').show();
			}

			// On post, hide post format UI and layout settings if pagecomposer is activated
			if ( $post_format_wrapper.length ){
				$post_format_wrapper.hide();

				var active_post_format = $post_format_wrapper.find( 'input[type="radio"]:checked').val();
				$( '.mh_mharty_format_setting.mh_mharty_' + active_post_format + '_settings' ).hide();
			}
		}

		function mhc_show_layout_settings(){
			$mhc_layout_settings.show().closest( '#mh_settings_meta_box' ).show();
			$mhc_layout_settings.closest( '#mh_settings_meta_box' ).find('.mhc_side_nav_settings').hide();

			// On post, show post format UI and layout settings if pagecomposer is deactivated
			if ( $post_format_wrapper.length ){
				$post_format_wrapper.show();

				var active_post_format = $post_format_wrapper.find( 'input[type="radio"]:checked').val();
				$( '.mh_mharty_format_setting.mh_mharty_' + active_post_format + '_settings' ).show();
			}

		}

		function mhc_get_content( textarea_id, fix_shortcodes ){
			var content,
				fix_shortcodes = typeof fix_shortcodes !== 'undefined' ? fix_shortcodes : false;

			if ( typeof window.tinyMCE !== 'undefined' && window.tinyMCE.get( textarea_id ) && ! window.tinyMCE.get( textarea_id ).isHidden() ){
				content = window.tinyMCE.get( textarea_id ).getContent();
			} else {
				content = $( '#' + textarea_id ).val();
			}

			if ( fix_shortcodes && typeof window.tinyMCE !== 'undefined' ){
				content = content.replace( /<p>\[/g, '[' );
				content = content.replace( /\]<\/p>/g, ']' );
			}

			return content.trim();
		}

		function mh_get_editor_mode(){
			var mh_editor_mode = 'tinymce';

			if ( 'html' === getUserSetting( 'editor' ) ){
				mh_editor_mode = 'html';
			}

			return mh_editor_mode;
		}

		function mhc_is_editor_in_visual_mode( id ){
			var is_editor_in_visual_mode = !! ( typeof window.tinyMCE !== 'undefined' && window.tinyMCE.get( id ) && ! window.tinyMCE.get( id ).isHidden() );

			return is_editor_in_visual_mode;
		}

		function mhc_set_content( textarea_id, content, current_action ){
			var current_action                = current_action || '',
				main_editor_in_visual_mode    = mhc_is_editor_in_visual_mode( 'content' ),
				current_editor_in_visual_mode = mhc_is_editor_in_visual_mode( textarea_id ),
                trimmed_content = $.trim( content );
            
            if ( typeof window.tinyMCE !== 'undefined' && window.tinyMCE.get( textarea_id ) && current_editor_in_visual_mode ){
				var editor = window.tinyMCE.get( textarea_id );

				editor.setContent( trimmed_content, { format : 'html'  });
			} else {
				$( '#' + textarea_id ).val( trimmed_content );
			}
            
            // initiate quicktags only once to avoid issue with duplication of tags
			if ( ! mhc_quick_tags_init_done[textarea_id] && 'content' !== textarea_id ) {
				// generate quick tag buttons for the editor in Text mode
				( typeof tinyMCEPreInit.mceInit[textarea_id] !== "undefined" ) ? quicktags( { id : textarea_id } ) : quicktags( tinyMCEPreInit.qtInit[textarea_id] );
				QTags._buttonsInit();
				mhc_quick_tags_init_done[textarea_id] = true;
			}

			// Enabling publish button + removes disable_publish mark
			if ( ! wp.heartbeat || ! wp.heartbeat.hasConnectionError() ){
				$('#publish').removeClass( 'disabled' );

				delete MH_PageComposer_App.disable_publish;
			}
		}

		function mhc_tinymce_remove_control( textarea_id ){
			if ( typeof window.tinyMCE !== 'undefined' ){
				window.tinyMCE.execCommand( 'mceRemoveEditor', false, textarea_id );

				if ( typeof window.tinyMCE.get( textarea_id ) !== 'undefined' ){
					window.tinyMCE.remove( '#' + textarea_id );
				}
                
                // set the quick tags init variable to false for current textarea so quicktags be initiated properly next time
				mhc_quick_tags_init_done[textarea_id] = false;
			}
		}

		function mhc_update_affected_fields( $affected_fields ){
			if ( $affected_fields.length ){
				$affected_fields.each(function(){
					$(this).trigger( 'change' );
				});
			}
		}

		function mhc_custom_color_remove( $element ){
			var $this_el = $element,
				$color_picker_container = $this_el.closest( '.mhc-custom-color-container' ),
				$color_choose_button = $color_picker_container.siblings( '.mhc-choose-custom-color-button' ),
				$hidden_color_input = $color_picker_container.find( '.mhc-custom-color-picker' ),
				hidden_class = 'mhc_hidden';

			$color_choose_button.removeClass( hidden_class );
			$color_picker_container.addClass( hidden_class );

			$hidden_color_input.val( '' );

			return false;
		}

        // check the advanced settings and update defaults based on the current settings of the parent module
		function mhc_set_child_defaults( $container, module_cid ){
			var $advanced_tab          = $container.find( '.mhc-options-tab-advanced' ),
				$advanced_tab_settings = $advanced_tab.find( '.mhc-main-setting' ),
				$parent_container      = $( '.mhc_modal_settings_container:not(.mhc_modal_settings_container_step2)'),
				$parent_container_adv  = $parent_container.find( '.mhc-options-tab-advanced' ),
				current_module         = MH_PageComposer_Modules.findWhere({ cid : module_cid });

			if ( $advanced_tab.length ){
				$advanced_tab_settings.each(function(){
					var $this_option = $( this ),
						$option_main_input,
						option_id;

					// process only range options
					if ( $this_option.hasClass( 'mhc-range' ) ){
						$option_main_input = $this_option.siblings( '.mhc-range-input' );

						$option_main_input.each(function(){
							var $current_option = $( this ),
								option_id = $current_option.attr( 'id' ),
								option_parent = $( '#' + option_id );

							if ( option_parent.length ){
								// check whether module already has module_defaults, otherwise set it to empty array
								current_module.attributes['module_defaults'] = current_module.attributes['module_defaults'] || [];
								// update 'module_defaults' to avoid saving the default values into database
								current_module.attributes['module_defaults'][ option_id ] = option_parent.val();
								// update default attribute in the option settings to display the correct value
								$current_option.data( 'default_inherited', option_parent.val() );
								$current_option.data( 'default', option_parent.val() );
							}
						});
					}
				});
			}
		}
		function mhc_init_main_settings( $container, this_module_cid ){
			var $main_tabs                   = $container.find( '.mhc-options-tabs-links' ),
				$settings_tab               = $container.find( '.mhc-options-tab' ),
				$mh_affect_fields           = $container.find( '.mhc-affects' ),
                $validate_unit_field        = $container.find( '.mhc-validate-unit' ),
				$range_field                = $container.find( '.mhc-range' ),
				$range_input                = $container.find( '.mhc-range-input' ),
				$advanced_tab               = $container.find( '.mhc-options-tab-advanced' ),
				$advanced_tab_settings      = $advanced_tab.find( '.mhc-main-setting' ),
				$custom_color_picker        = $container.find( '.mhc-custom-color-picker' ),
				$custom_color_choose_button = $container.find( '.mhc-choose-custom-color-button' ),
				$switch_button_wrapper      = $container.find( '.mhc_switch_button_wrapper' ),
				$switch_button              = $container.find( '.mhc_switch_button' ),
				$switch_select              = $container.find( 'select' ),
                $custom_css_option = $container.find( '.mhc-options-tab-custom_css .mhc-option' ),
				$checkboxes_set = $container.find( '.mhc_checkboxes_wrapper' ),
				$checkbox       = $checkboxes_set.find( 'input[type="checkbox"]' ),
                hidden_class                = 'mhc_hidden',
                $google_maps_api_option = $container.find( '#mhc_google_api_key' ),
				$google_maps_api_button = $container.find( '.mhc_update_google_key' );

			if ( $google_maps_api_option.length ) {
				$google_maps_api_button.attr( 'href', mhc_options.theme_panel_advanced );

				if ( '' === mhc_options.google_api_key ) {
					$google_maps_api_option.addClass( 'mhc_hidden_field' );
					$google_maps_api_button.text( $google_maps_api_button.data( 'empty_text' ) ).addClass( 'mhc_no_field_visible' );
				} else {
					$google_maps_api_option.val( mhc_options.google_api_key );
				}
			}
            
			if ( $checkboxes_set.length ){
				$checkboxes_set.each(function(){
					var $this_container = $( this ),
						value = $this_container.find( 'input.mhc-main-setting' ).val(),
						checkboxes = $this_container.find( 'input[type="checkbox"]' ),
						values_array,
						i;

					if ( '' !== value ){
						values_array = value.split( '|' );
						i = 0;

						checkboxes.each(function(){
							if ( 'on' === values_array[ i ] ){
								var $this_checkbox = $( this );
								$this_checkbox.prop( 'checked', true );
							}
							i++;
						});
					}

				});
			}

			$checkbox.click(function(){
				var $this_checkbox = $( this ),
					current_checkbox_class = $( this ).attr( 'class' ),
					$this_container = $this_checkbox.closest( '.mhc_checkboxes_wrapper' ),
					$all_checkboxes = $this_container.find( 'input[type="checkbox"]' ),
					$value_field = $this_container.find( 'input.mhc-main-setting' ),
					new_value = true === $this_checkbox.prop( 'checked' ) ? 'on' : 'off',
					i = 0,
					empty_values_array = [],
					checkbox_order,
					values_array;

					$all_checkboxes.each(function(){
						if ( $( this ).hasClass( current_checkbox_class ) ){
							checkbox_order = i;
						}
						i++;
						empty_values_array.push( '' );
					});

					if ( '' !== $value_field.val() ){
						values_array = $value_field.val().split( '|' );
					} else {
						values_array = empty_values_array;
					}

					values_array[ checkbox_order ] = new_value;

					$value_field.val( values_array.join( '|' ) );

			});

			if ( typeof window.switchEditors !== 'undefined' ){
				$container.find( '.wp-switch-editor' ).click(function(){
					var $this_el = $(this),
						editor_mode;

					editor_mode = $this_el.hasClass( 'switch-tmce' ) ? 'tinymce' : 'html';
                    
                    mhc_maybe_apply_wpautop_to_models( editor_mode );

					window.switchEditors.go( 'content', editor_mode );
				});
			}
            
			$custom_color_picker.each(function(){
				var $this_color_picker      = $(this),
					this_color_picker_value = $this_color_picker.val(),
					$container              = $this_color_picker.closest( '.mhc-custom-color-container' ),
					$choose_color_button    = $container.siblings( '.mhc-choose-custom-color-button' ),
					$main_color_picker      = $container.find( '.mhc-color-picker-hex' );

				if ( '' === this_color_picker_value ){
					return true;
				}

				$container.removeClass( hidden_class );
				$choose_color_button.addClass( hidden_class );

				$main_color_picker.wpColorPicker( 'color', this_color_picker_value );
			});

			$custom_color_choose_button.click(function(){
				var $this_el = $(this),
					$color_picker_container = $this_el.siblings( '.mhc-custom-color-container' ),
					$color_picker = $color_picker_container.find( '.mhc-color-picker-hex' ),
					$hidden_color_input = $color_picker_container.find( '.mhc-custom-color-picker' );

				$this_el.addClass( hidden_class );
				$color_picker_container.removeClass( hidden_class );

				$hidden_color_input.val( $color_picker.wpColorPicker( 'color' ) );

				return false;
			});

			$switch_button_wrapper.each(function(){
				var $this_el = $( this ),
					$this_switcher = $this_el.find( '.mhc_switch_button' ),
					selected_value = $this_el.find( 'select' ).val();

				if ( 'on' === selected_value ){
					$this_switcher.removeClass( 'mhc_off_state' );
					$this_switcher.addClass( 'mhc_on_state' );
				} else {
					$this_switcher.removeClass( 'mhc_on_state' );
					$this_switcher.addClass( 'mhc_off_state' );
				}
			});

			$switch_button.click(function(){
				var $this_el = $( this ),
					$this_select = $this_el.closest( '.mhc_switch_button_wrapper' ).find( 'select' );

				if ( $this_el.hasClass( 'mhc_off_state') ){
					$this_el.removeClass( 'mhc_off_state' );
					$this_el.addClass( 'mhc_on_state' );
					$this_select.val( 'on' );
				} else {
					$this_el.removeClass( 'mhc_on_state' );
					$this_el.addClass( 'mhc_off_state' );
					$this_select.val( 'off' );
				}

				$this_select.trigger( 'change' );

			});

			$switch_select.change(function(){
				var $this_el = $( this ),
					$this_switcher = $this_el.closest( '.mhc_switch_button_wrapper' ).find( '.mhc_switch_button' ),
					new_value = $this_el.val();

				if ( 'on' === new_value ){
					$this_switcher.removeClass( 'mhc_off_state' );
					$this_switcher.addClass( 'mhc_on_state' );
				} else {
					$this_switcher.removeClass( 'mhc_on_state' );
					$this_switcher.addClass( 'mhc_off_state' );
				}

			});

			$main_tabs.find( 'li a' ).click(function(){
				var $this_el              = $(this),
					tab_index             = $this_el.closest( 'li' ).index(),
					$links_container      = $this_el.closest( 'ul' ),
					$tabs                 = $links_container.siblings( '.mhc-options-tabs' ),
					active_link_class     = 'mhc-options-tabs-links-active',
					$active_tab_link      = $links_container.find( '.' + active_link_class ),
					active_tab_link_index = $active_tab_link.index(),
					$current_tab          = $tabs.find( '.mhc-options-tab' ).eq( active_tab_link_index ),
					$next_tab             = $tabs.find( '.mhc-options-tab' ).eq( tab_index ),
					fade_speed            = 300;

				if ( active_tab_link_index !== tab_index ){
					$next_tab.css({ 'display' : 'none', opacity : 0 });

					$current_tab.css({ 'display' : 'block', 'opacity' : 1 }).stop( true, true ).animate({ opacity : 0 }, fade_speed, function(){
						$(this).css( 'display', 'none' );

						$next_tab.css({ 'display' : 'block', 'opacity' : 0 }).stop( true, true ).animate({ opacity : 1 }, fade_speed, function(){
							var $this = $(this);

							//mhc_update_affected_fields( $mh_affect_fields );

							if ( ! $this.find( '.mhc-option:visible' ).length ){
								$this.append( '<p class="mhc-all-options-hidden">' + mhc_options.all_tab_options_hidden + '<p>' );
							} else {
								$('.mhc-all-options-hidden').remove();
							}

							$main_tabs.trigger( 'mhc_main_tab:changed' );
						});
					});

					$active_tab_link.removeClass( active_link_class );
					$links_container.find( 'li' ).eq( tab_index ).addClass( active_link_class );
					//$( '.mhc-main-settings' ).animate({ scrollTop :  0 }, 400, 'swing' );
                    $( '.mhc-options-tabs' ).animate({ scrollTop :  0 }, 400, 'swing' );
				}

				return false;
			});

			$settings_tab.each(function(){
				var $this_tab          = $(this),
					$toggles           = $this_tab.find( '.mhc-options-toggle-enabled' ),
					open_class         = 'mhc-option-toggle-content-open',
					closed_class       = 'mhc-option-toggle-content-closed',
					content_area_class = 'mhc-option-toggle-content',
					animation_speed    = 300;

				$toggles.find( 'h3' ).click(function(){
					var $this_el                  = $(this),
						$content_area             = $this_el.siblings( '.' + content_area_class ),
						$container                = $this_el.closest( '.mhc-options-toggle-container' ),
						$open_toggle              = $toggles.filter( '.' + open_class ),
						$open_toggle_content_area = $open_toggle.find( '.' + content_area_class );

					if ( $container.hasClass( open_class ) ){
						return;
					}

					$open_toggle.removeClass( open_class ).addClass( closed_class );
					$open_toggle_content_area.slideToggle( animation_speed );

					$container.removeClass( closed_class ).addClass( open_class );
					$content_area.slideToggle( animation_speed, function(){
						mhc_update_affected_fields( $mh_affect_fields );
					});
				});
			});

			$range_field.on( 'input change', function(){
				var $this_el          = $(this),
					range_value       = $this_el.val(),
					$range_input      = $this_el.siblings( '.mhc-range-input' ),
					initial_value_set = $range_input.data( 'initial_value_set' ) || false,
					number,
					length,
                    range_input_value = mhc_sanitize_input_unit_value( $.trim( $range_input.val() ), false, 'no_default_unit' );

				if ( range_input_value === '' && ! initial_value_set ){
					$this_el.val( 0 );
					$range_input.data( 'initial_value_set', true );

					return;
				}

				number = parseFloat( range_input_value );
				range_input_value += '';
				length = $.trim( range_input_value.replace( number, '' ) );

				if ( length !== '' ){
					range_value += length;
				}

				$range_input.val( range_value );
			});

			if ( $range_field.length ){
				$range_field.each(function(){
					var $this_el          = $(this),
						default_value     = $.trim( $this_el.data( 'default' ) ),
						$range_input      = $this_el.siblings( '.mhc-range-input' ),
						range_input_value = $.trim( $range_input.val() );

					if ( range_input_value === '' ){
						if ( default_value !== '' ){
							$range_input.val( default_value );

							default_value = parseFloat( default_value ) || 0;
						}

						$this_el.val( default_value );
					}
				});
			}

			$range_input.on( 'keyup change', function(){
				var $this_el      = $(this),
					this_value    = $this_el.val(),
					$range_slider = $this_el.siblings( '.mhc-range' ),
					slider_value;

				slider_value = parseFloat( this_value ) || 0;

				$range_slider.val( slider_value ).trigger( 'mhc_setting:change' );
			});
            
            if ( $validate_unit_field.length ){
				$validate_unit_field.each(function(){
					var $this_el = $(this),
						value    = mhc_sanitize_input_unit_value( $.trim( $this_el.val() ) );

					$this_el.val( value );
				});
			}

			if ( $advanced_tab_settings.length ){
				$advanced_tab_settings.on( 'change mhc_setting:change mh_main_custom_margin:change', function(){
					var $this_el         = $(this),
						$reset_button    = $this_el.closest( '.mhc-option-container' ).find( '.mhc-reset-setting' ),
						default_value    = mhc_get_default_setting_value( $this_el ),
				        is_range_option  = $this_el.hasClass( 'mhc-range' ),
						$current_element = is_range_option ? $this_el.siblings( '.mhc-range-input' ) : $this_el,
						current_value    = $current_element.val();

					if ( $current_element.is( 'select' ) && default_value === '' && $current_element.prop( 'selectedIndex' ) === 0 ){
						$reset_button.removeClass( 'mhc-reset-icon-visible' );
                        
						return;
					}

					if ( ( current_value !== default_value && ! is_range_option ) || ( is_range_option && current_value !== default_value + 'px' && current_value !== default_value ) ){
						setTimeout(function(){
							$reset_button.addClass( 'mhc-reset-icon-visible' );
						}, 50 );

					} else {
						$reset_button.removeClass( 'mhc-reset-icon-visible' );
					}
				});

				$advanced_tab_settings.trigger( 'change' );

			}

				$advanced_tab.find( '.mhc-reset-setting' ).click(function(){
					mhc_reset_element_settings( $(this) );
				});


			if ( $mh_affect_fields.length ){
				$mh_affect_fields.change(function(){
					var $this_field         = $(this), // this field value affects another field visibility
						new_field_value     = $this_field.val(),
						new_field_value_number = parseInt( new_field_value ),
						$affected_fields     = $( $this_field.data( 'affects' ) ),
						this_field_tab_index = $this_field.closest( '.mhc-options-tab' ).index();

					$affected_fields.each(function(){
						var $affected_field          = $(this),
							$affected_container      = $affected_field.closest( '.mhc-option' ),
                            is_text_trigger          = 'text' === $this_field.attr( 'type' ) && typeof show_if_not === 'undefined' && typeof show_if === 'undefined', // need to know if trigger is text field
							show_if                  = $affected_container.data( 'depends_show_if' ) || 'on',
							show_if_not              = is_text_trigger ? '' : $affected_container.data( 'depends_show_if_not' ),
							show                     = show_if === new_field_value || ( typeof show_if_not !== 'undefined' && show_if_not !== new_field_value ),
							affected_field_tab_index = $affected_field.closest( '.mhc-options-tab' ).index(),
							$dependant_fields        = $affected_container.find( '.mhc-affects' ); // affected field might affect some other fields as well

						// make sure hidden text fields do not break the visibility of option
						if ( is_text_trigger && ! $this_field.is( ':visible' ) ){
							return;
						}
                        
                        // if the affected field should be displayed, but the field that affects it is not visible, don't show the affected field ( it only can happen on settings page load )
						if ( this_field_tab_index === affected_field_tab_index && show && ! $this_field.is( ':visible' ) ){
							show = false;
						}

						// shows or hides the affected field container
						$affected_container.toggle( show ).addClass( 'mhc_animate_affected' );
                        
                        setTimeout(function(){
							$affected_container.removeClass( 'mhc_animate_affected' );
						}, 500 );

						// if the affected field affects other fields, find out if we need to hide/show them
						if ( $dependant_fields.length ){
							var $inner_affected_elements = $( $dependant_fields.data( 'affects' ) );

							if ( ! $affected_container.is( ':visible' ) ){
								// if the main affected field is hidden, hide all fields it affects

								$inner_affected_elements.each(function(){
									$(this).closest( '.mhc-option' ).hide();
								});
							} else {
								// if the main affected field is displayed, trigger the change event for all fields it affects

								$affected_field.trigger( 'change' );
							}
						}
					});
				});

				// trigger change event for all dependant ( affected ) fields to show on settings page load
				setTimeout(function(){
                    // make all settings visible to properly enable all affected fields
					$settings_tab.css({ 'display' : 'block' });
                    
					mhc_update_affected_fields( $mh_affect_fields );
                    
                    // After all affected fields is being processed return all tabs to the initial state
					$settings_tab.css({ 'display' : 'none' });
					mhc_open_current_tab();
				}, 100 );
			}
            
            // update the unique class for opened module when custom css tab opened
			$container.find( '.mhc-options-tabs-links' ).on( 'mhc_main_tab:changed', function(){
				var $custom_css_tab = $( '.mhc-options-tabs-links' ).find( '.mhc_options_tab_custom_css' ),
					$module_order_placeholder = $( '.mhc-options-tab-custom_css' ).find( '.mhc_module_order_placeholder' ),
					opened_module,
					module_order;

				if ( $custom_css_tab.hasClass( 'mhc-options-tabs-links-active' ) ){
					var opened_module = MH_PageComposer_Modules.findWhere({ cid : this_module_cid });

					module_order = typeof opened_module.attributes.module_order !== 'undefined' ? opened_module.attributes.module_order : '';

					// replace empty placeholders with module order value if any
					if ( $module_order_placeholder.length ){
						$module_order_placeholder.replaceWith( module_order );
					}
				}
			});

			// show/hide css selector field for the custom css options on focus
			if ( $custom_css_option.length ){
				$custom_css_option.focusin(function(){
					var $this = $( this ),
						$this_main_container = $this.closest( '.mhc-option' ),
						$css_selector_holder = $this_main_container.find( 'label > span' ),
						$other_inputs_selectors = $this_main_container.siblings().find( 'label > span' );

					// show the css selector span for option with focus
					if ( $css_selector_holder.length ){
						$css_selector_holder.removeClass( 'mhc_hidden_css_selector' );
						$css_selector_holder.css({ 'display' : 'inline-block' });
						$css_selector_holder.addClass( 'mhc_visible_css_selector' );
					}

					// hide the css selector span for other options
					if ( $other_inputs_selectors.length ){
						$other_inputs_selectors.removeClass( 'mhc_visible_css_selector' );
						$other_inputs_selectors.addClass( 'mhc_hidden_css_selector' );

						setTimeout(function(){
							$other_inputs_selectors.css({ 'display' : 'none' });
							$other_inputs_selectors.removeClass( 'mhc_hidden_css_selector' );
						}, 200 );
					}
				});
			}
		}

		function mhc_get_default_setting_value( $element ){
			var default_data_name = $element.hasClass( 'mhc-color-picker-hex' ) ? 'default-color' : 'default',
				default_value;
            // need to check for 'undefined' type instead of $element.data( default_data_name ) || '' because default value maybe 0
			default_value = typeof $element.data( default_data_name ) !== 'undefined' ? $element.data( default_data_name ) : '';
			// convert any type to string
			default_value = default_value + '';

			return default_value;
		}

		/*
		 * Reset icon or a setting field can be used as $element
		 */
		function mhc_reset_element_settings( $element ){
			var $this_el          = $element,
				$option_container = $this_el.closest( '.mhc-option-container' ),
				$main_setting     = $option_container.find( '.mhc-main-setting' ),
				default_value     = mhc_get_default_setting_value( $main_setting );

			if ( $main_setting.is( 'select' ) && default_value === '' ){
				$main_setting.prop( 'selectedIndex', 0 ).trigger( 'change' );

				return;
			}

			if ( $main_setting.hasClass( 'mhc-custom-color-picker' ) ){
				mhc_custom_color_remove( $this_el );

				return;
			}

			if ( $main_setting.hasClass( 'mhc-color-picker-hex' ) ){
				$main_setting.wpColorPicker( 'color', default_value );
                
                if ( default_value === '' ){
					$main_setting.siblings('.wp-picker-clear').trigger('click');
				}

				if ( ! $this_el.hasClass( 'mhc-reset-setting' ) ){
					$this_el = $option_container.find( '.mhc-reset-setting' );
				}

				$this_el.hide();

				return;
			}

			if ( $main_setting.hasClass( 'mhc-range' ) ){
				$main_setting = $this_el.siblings( '.mhc-range-input' );
                default_value = mhc_get_default_setting_value( $main_setting );
			}

			$main_setting.val( default_value );
            
            $main_setting.data( 'has_saved_value', 'no' );

            $main_setting.trigger( 'change' );
		}
                   
        function mhc_sanitize_input_unit_value( value, auto_important, default_unit ){
			var value = typeof value === 'undefined' ? '' : value,
				valid_one_char_units  = [ "%" ],
				valid_two_chars_units = [ "em", "px", "cm", "mm", "in", "pt", "pc", "ex", "vh", "vw" ],
				important             = "!important",
				important_length      = important.length,
				has_important         = false,
				value_length          = value.length,
				auto_important       = _.isUndefined( auto_important ) ? false : auto_important,
				unit_value,
				result;

			if ( value === '' ){
				return '';
			}

			// check for !important
			if ( value.substr( ( 0 - important_length ), important_length ) === important ){
				has_important = true;
				value_length = value_length - important_length;
				value = value.substr( 0, value_length ).trim();
			}

			if ( $.inArray( value.substr( -1, 1 ), valid_one_char_units ) !== -1 ){
				unit_value = parseFloat( value ) + "%";

				// Re-add !important tag
				if ( has_important && ! auto_important ){
					unit_value = unit_value + ' ' + important;
				}

				return unit_value;
			}

			if ( $.inArray( value.substr( -2, 2 ), valid_two_chars_units ) !== -1 ){
				var unit_value = parseFloat( value ) + value.substr( -2, 2 );

				// Re-add !important tag
				if ( has_important && ! auto_important ){
					unit_value = unit_value + ' ' + important;
				}

				return unit_value;
			}

			if( isNaN( parseFloat( value ) ) ){
				return '';
			}

			result = parseFloat( value );
			if ( _.isUndefined( default_unit ) || 'no_default_unit' !== default_unit ){
				result += 'px';
			}

			// Return and automatically append px (default value)
			return result;
		}

		function mhc_hide_active_color_picker( container ){
			container.$( '.mhc-color-picker-hex:visible' ).each(function(){
				$(this).closest( '.wp-picker-container' ).find( '.wp-color-result' ).trigger( 'click' );
			});
		}

		function mh_composer_debug_message(){
			if ( mhc_options.debug && window.console ){
				if ( 2 === arguments.length ){
					console.log( arguments[0], arguments[1] );
				} else {
					console.log( arguments[0] );
				}
			}
		}

		function mh_reinitialize_composer_layout(){
			MH_PageComposer_App.saveAsShortcode();

			setTimeout(function(){
				var $composer_container = $( '#mhc_layout' ),
					composer_height     = $composer_container.innerHeight();

				$composer_container.css({ 'height' : composer_height });

				content = mhc_get_content( 'content', true );

				MH_PageComposer_App.removeAllSections();

				MH_PageComposer_App.$el.find( '.mhc_section' ).remove();

				MH_PageComposer_App.createLayoutFromContent( mh_prepare_template_content( content ), '', '', { is_reinit : 'reinit' });

				$composer_container.css({ 'height' : 'auto' });
			}, 600 );
		}

		function mh_prepare_template_content( content ){
			if ( -1 !== content.indexOf( '[mhc_' ) ){
				if  ( -1 === content.indexOf( 'mhc_row' ) && -1 === content.indexOf( 'mhc_section' ) ){
					if ( -1 === content.indexOf( 'mhc_fullwidth' ) ){
						var saved_tabs = /(\\?")(.*?)\1/.exec( content );
						content = '[mhc_section template_type="module" skip_module="true"][mhc_row template_type="module" skip_module="true"][mhc_column type="4_4" saved_tabs="' + saved_tabs[2] + '"]' + content + '[/mhc_column][/mhc_row][/mhc_section]';
					} else {
						var saved_tabs = /(\\?")(.*?)\1/.exec( content );
						content = '[mhc_section fullwidth="on" template_type="module" skip_module="true" saved_tabs="' + saved_tabs[2] + '"]' + content + '[/mhc_section]';
					}
				} else if ( -1 === content.indexOf( 'mhc_section' ) ){
					content = '[mhc_section template_type="row" skip_module="true"]' + content + '[/mhc_section]';
				}
			}

			return content;
		}

		function generate_templates_view( include_shared, is_shared, layout_type, append_to, module_width, specialty_cols, selected_category, previous_result ){
			var is_shared = '' === is_shared ? 'not_shared' : is_shared;
			if ( typeof $mhc_templates_cache[layout_type + '_' + is_shared + '_' + module_width + '_' + specialty_cols] !== 'undefined' ){
				var templates_collection = new MH_PageComposer.SavedTemplates( $mhc_templates_cache[layout_type + '_' + is_shared + '_' + module_width + '_' + specialty_cols] ),
					templates_view = new MH_PageComposer.TemplatesView({ collection: templates_collection, category: selected_category });

				append_to.append( templates_view.render().el );

				if ( 'include_shared' === include_shared && 'not_shared' === is_shared ){
					generate_templates_view( 'include_shared', 'shared', layout_type, append_to, module_width, specialty_cols, selected_category );
				} else {
					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
					append_to.prepend( mhc_generate_layouts_filter( selected_category ) );
					$( '#mhc_select_category' ).data( 'attr', { include_shared : include_shared, is_shared : '', layout_type : layout_type, append_to : append_to, module_width : module_width, specialty_cols : specialty_cols });
				}
			} else {
				$.ajax({
					type: "POST",
					url: mhc_options.ajaxurl,
					dataType: 'json',
					data:
					{
						action : 'mhc_get_saved_templates',
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mh_is_shared : is_shared,
                        mh_post_type : mhc_options.post_type,
						mh_layout_type : layout_type,
						mh_module_width : module_width,
						mh_specialty_columns : specialty_cols
					},
					beforeSend : function(){
						MH_PageComposer_Events.trigger( 'mhc-loading:started' );
					},
					complete : function(){
						if ( 'include_shared' !== include_shared || ( 'include_shared' === include_shared && 'shared' === is_shared )  ){
							MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
							append_to.prepend( mhc_generate_layouts_filter( selected_category ) );
							$( '#mhc_select_category' ).data( 'attr', { include_shared : include_shared, is_shared : '', layout_type : layout_type, append_to : append_to, module_width : module_width, specialty_cols : specialty_cols });
						}
					},
					success: function( data ){
                        var request_result = '';
                        
						if ( typeof data.error !== 'undefined' ){
							//show error message only for shared section or when shared section wasn't included
                            if ( ( 'include_shared' === include_shared && 'shared' === is_shared && 'success' !== previous_result ) || 'include_shared' !== include_shared ){
								append_to.append( '<ul><li>' + data.error + '</li></ul>');
                                request_result = 'fail';
							}
						} else {
							var templates_collection = new MH_PageComposer.SavedTemplates( data ),
								templates_view = new MH_PageComposer.TemplatesView({ collection: templates_collection });

							$mhc_templates_cache[layout_type + '_' + is_shared + '_' + module_width + '_' + specialty_cols] = data;
							append_to.append( templates_view.render().el );
                            request_result = 'success';
						}

						if ( 'include_shared' === include_shared && 'not_shared' === is_shared ){
							generate_templates_view( 'include_shared', 'shared', layout_type, append_to, module_width, specialty_cols, selected_category, request_result )
						}
					}
				});
			}
		}

		function mhc_generate_layouts_filter( selected_category ){
			var all_cats        = $.parseJSON( mhc_options.layout_categories ),
				$cats_selector  = '<select id="mhc_select_category">',
				selected_option = 'all' === selected_category || '' === selected_category ? ' selected' : '';

				$cats_selector += '<option value="all"' + selected_option + '>' + mhc_options.all_cat_text + '</option>';

				if( ! $.isEmptyObject( all_cats ) ){

					$.each( all_cats, function( i, single_cat ){
						if ( ! $.isEmptyObject( single_cat ) ){
							selected_option = selected_category === single_cat.slug ? ' selected' : '';
							$cats_selector += '<option value="' + single_cat.slug + '"' + selected_option + '>' + single_cat.name + '</option>';
						}
					});
				}

				$cats_selector += '</select>';

				return $cats_selector;
		}

		// function to load saved layouts, it works differently than loading saved rows, sections and modules, so we need a separate function
		function mh_load_saved_layouts( layout_type, container_class, $this_el, post_type ){
			if ( typeof $mhc_templates_cache[layout_type + '_layouts'] !== 'undefined' ){
				$this_el.find( '.mhc-main-settings.' + container_class ).append( $mhc_templates_cache[layout_type + '_layouts'] );
			} else {
				$.ajax({
					type: "POST",
					url: mhc_options.ajaxurl,
					data:
					{
						action : 'mhc_show_all_layouts',
						mh_layouts_built_for_post_type: post_type,
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mh_load_layouts_type : layout_type //'preset' or not preset
					},
					beforeSend : function(){
						MH_PageComposer_Events.trigger( 'mhc-loading:started' );
					},
					complete : function(){
						MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
					},
					success: function( data ){
						$this_el.find( '.mhc-main-settings.' + container_class ).append( data );
						$mhc_templates_cache[layout_type + '_layouts'] = data;
					}
				});
			}
		}

		function mh_handle_templates_switching( $clicked_button, module_type, module_width ){
			if ( ! $clicked_button.hasClass( 'mhc-options-tabs-links-active' ) ){
				var specialty_columns = typeof $clicked_button.closest( '.mhc-options-tabs-links' ).data( 'specialty_columns' ) !== 'undefined' ? $clicked_button.closest( '.mhc-options-tabs-links' ).data( 'specialty_columns' ) : 0;
				$( '.mhc-options-tabs-links li' ).removeClass( 'mhc-options-tabs-links-active' );
				$clicked_button.addClass( 'mhc-options-tabs-links-active' );

				$( '.mhc-main-settings.active-container' ).css({ 'display' : 'block', 'opacity' : 1 }).stop( true, true ).animate({ opacity : 0 }, 300, function(){
					$( this ).css( 'display', 'none' );
					$( this ).removeClass( 'active-container' );
					$( '.' + $clicked_button.data( 'open_tab' ) ).addClass( 'active-container' ).css({ 'display' : 'block', 'opacity' : 0 }).stop( true, true ).animate({ opacity : 1 }, 300 );
				});

				if ( typeof $clicked_button.data( 'content_loaded' ) === 'undefined' && ! $clicked_button.hasClass( 'mhc-new-module' ) && 'layout' !== module_type ){
					var include_shared = $clicked_button.closest( '.mhc_modal_settings' ).hasClass( 'mhc_no_shared' ) ? 'no_shared' : 'include_shared';
					generate_templates_view( include_shared, '', module_type, $( '.' + $clicked_button.data( 'open_tab' ) ), module_width, specialty_columns, 'all' );
					$clicked_button.data( 'content_loaded', 'true' );
				}
			}
		}

		function mhc_maybe_apply_wpautop_to_models( editor_mode, load ) {
            if ( typeof window.switchEditors === 'undefined' ) {
				return;
			}
            
            var tinymce_advanced_noautop = tinyMCEPreInit.mceInit.mhc_content_new.tadv_noautop; // get the noautop option from tinyMCE advanced plugin

			_.each( MH_PageComposer_App.collection.models, function( model ){
				var model_content = model.get( 'mhc_content_new' );

                if ( typeof model_content !== 'undefined' ) {
					if ( editor_mode === 'tinymce' ) {
						model_content = window.switchEditors.wpautop( model_content.replace( /<p> <\/p>/g, "<p>&nbsp;</p>" ) );
					} else {
						// do not remove the <p> and <br /> tags in the Text editor, if such option is enabled in TinyMCE Advanced Plugin
						if ( typeof tinymce_advanced_noautop !== 'undefined' && tinymce_advanced_noautop === true ) {
							return;
						}
                        
                        // do not remove <br /> tags on initial page load
						if ( ! _.isUndefined( load ) && load === 'initial_load' ) {
							return;
						}

						model_content = window.switchEditors.pre_wpautop( model_content );
					}

					model.set( 'mhc_content_new', model_content, { silent : true });
				}
			});
		}

		function mh_add_template_meta( custom_field_name, value ){
			var current_post_id = mhc_options.template_post_id;
			$.ajax({
					type: "POST",
					url: mhc_options.ajaxurl,
					data:
					{
						action : 'mhc_add_template_meta',
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mh_meta_value : value,
						mh_custom_field : custom_field_name,
						mh_post_id : current_post_id
					}
			});
		}

		function mh_composer_get_shared_module( view_settings ){
			var modal_view,
				shortcode_atts;

			$.ajax({
				type: "POST",
				url: mhc_options.ajaxurl,
				dataType: 'json',
				data:
				{
					action : 'mhc_get_shared_module',
					mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
					mh_shared_id : view_settings.model.get( 'mhc_shared_module' )
				},
				beforeSend : function(){
					MH_PageComposer_Events.trigger( 'mhc-loading:started' );
				},
				complete : function(){
					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
				},
				success: function( data ){
					if ( data.error ){
						// if shared template not found, then make module not shared.
						view_settings.model.unset( 'mhc_shared_module' );
						view_settings.model.unset( 'mhc_saved_tabs' );
					} else {
						var mhc_shortcodes_tags = MH_PageComposer_App.getShortCodeParentTags(),
							reg_exp = window.wp.shortcode.regexp( mhc_shortcodes_tags ),
							inner_reg_exp = MH_PageComposer_App.wp_regexp_not_shared( mhc_shortcodes_tags ),
							matches = data.shortcode.match( reg_exp );

						_.each( matches, function ( shortcode ){
							var shortcode_element = shortcode.match( inner_reg_exp ),
								shortcode_name = shortcode_element[2],
								shortcode_attributes = shortcode_element[3] !== ''
									? window.wp.shortcode.attrs( shortcode_element[3] )
									: '',
								shortcode_content = shortcode_element[5],
								module_settings,
				                found_inner_shortcodes = typeof shortcode_content !== 'undefined' && shortcode_content !== '' && shortcode_content.match( reg_exp ),
								saved_tabs = shortcode_attributes['named']['saved_tabs'] || view_settings.model.get('mhc_saved_tabs') || '',
								ignore_admin_label = 'all' !== saved_tabs && -1 === saved_tabs.indexOf( 'general' ); 

								if ( _.isObject( shortcode_attributes['named'] ) ){
									for ( var key in shortcode_attributes['named'] ){
								        if ( 'template_type' !== key && ( 'admin_label' !== key || ( 'admin_label' === key && ! ignore_admin_label ) ) ){
											var prefixed_key = key !== 'admin_label' ? 'mhc_' + key : key;

											if ( '' !== key ){
												view_settings.model.set( prefixed_key, shortcode_attributes['named'][key], { silent : true });
											}
										}
									}
								}

								//var saved_tabs = shortcode_attributes['named']['saved_tabs'] || view_settings.model.get('mhc_saved_tabs') || '';

								if ( '' !== saved_tabs && ( 'general' === saved_tabs || 'all' === saved_tabs ) ){
									view_settings.model.set( 'mhc_content_new', shortcode_content, { silent : true });
								}
						});
					}

					modal_view = new MH_PageComposer.ModalView( view_settings );
					$( 'body' ).append( modal_view.render().el );

					// Emulate preview clicking if this is triggered via right click
					if ( view_settings.triggered_by_right_click === true && view_settings.do_preview === true ){
						$('.mhc-modal-preview-template').trigger( 'click' );
					}

					var saved_tabs = view_settings.model.get( 'mhc_saved_tabs' );

					if ( typeof saved_tabs !== 'undefined' ){
						saved_tabs = 'all' === saved_tabs ? [ 'general', 'advanced', 'css' ] : saved_tabs.split( ',' );
						_.each( saved_tabs, function( tab_name ){
							tab_name = 'css' === tab_name ? 'custom_css' : tab_name;
							$( '.mhc_options_tab_' + tab_name ).addClass( 'mhc_saved_shared_tab' );
						});
						$( '.mhc_modal_settings_container' ).addClass( 'mhc_saved_shared_modal' );
					}
				}
			});
		}

		function mhc_load_shared_row( post_id, module_cid ){
			if ( ! $( 'body' ).find( '.mhc_shared_loading_overlay' ).length ){
				$( 'body' ).append( '<div class="mhc_shared_loading_overlay"></div>' );
			}
			$.ajax({
				type: "POST",
				url: mhc_options.ajaxurl,
				dataType: 'json',
				data:
				{
					action : 'mhc_get_shared_module',
					mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
					mh_shared_id : post_id
				},
				success: function( data ){
					if ( data.error ){
						// if shared template not found, then make module and all child modules not shared.
						var this_view = MH_PageComposer_Layout.getView( module_cid ),
							$child_elements = this_view.$el.find( '[data-cid]' );
						this_view.model.unset( 'mhc_shared_module' );

						if ( $child_elements.length ){
							$child_elements.each(function(){
								var $this_child = $( this ),
									child_cid = $this_child.data( 'cid' );
								if ( typeof child_cid !== 'undefined' && '' !== child_cid ){
									var child_view = MH_PageComposer_Layout.getView( child_cid );
									if ( typeof child_view !== 'undefined' ){
										child_view.model.unset( 'mhc_shared_parent' );
									}
								}
							});
						}
					} else {
						MH_PageComposer_App.createLayoutFromContent( data.shortcode, '', '', { ignore_template_tag : 'ignore_template', current_row_cid : module_cid, shared_id : post_id, is_reinit : 'reinit' });
					}

					mhc_shareds_loaded++;

					//make sure all shared modules have been processed and reinitialize the layout
					if ( mhc_shareds_requested === mhc_shareds_loaded ){
						mh_reinitialize_composer_layout();

						setTimeout(function(){
							$( 'body' ).find( '.mhc_shared_loading_overlay' ).remove();
						}, 650 );
					}
				}
			});
		}

		function mhc_update_shared_template( shared_module_cid ){
			var shared_module_view           = MH_PageComposer_Layout.getView( shared_module_cid ),
				post_id                      = shared_module_view.model.get( 'mhc_shared_module' ),
				layout_type                  = shared_module_view.model.get( 'type' );
				layout_type_updated          = 'row_inner' === layout_type ? 'row' : layout_type,
				template_shortcode           = MH_PageComposer_App.generateCompleteShortcode( shared_module_cid, layout_type_updated, 'ignore_shared' );

				if ( 'row_inner' === layout_type ){
					template_shortcode = template_shortcode.replace( /mhc_row_inner/g, 'mhc_row' );
					template_shortcode = template_shortcode.replace( /mhc_column_inner/g, 'mhc_column' );
				}

			$.ajax({
				type: "POST",
				url: mhc_options.ajaxurl,
				data:
				{
					action : 'mhc_update_layout',
					mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
					mh_layout_content : template_shortcode,
					mh_template_post_id : post_id,
				}
			});
		}

		function mhc_open_current_tab(){
            var $container = $( '.mhc_modal_settings_container' );
			if ( $( '.mhc_modal_settings_container' ).hasClass( 'mhc_hide_general_tab' ) ){
				$container.find( '.mhc-options-tabs-links li' ).removeClass( 'mhc-options-tabs-links-active' );
				$container.find( '.mhc-options-tabs .mhc-options-tab' ).css({ 'display' : 'none', opacity : 0 });

				if ( $container.hasClass( 'mhc_hide_advanced_tab' ) ){
					$container.find( '.mhc-options-tabs-links li.mhc_options_tab_custom_css' ).addClass( 'mhc-options-tabs-links-active' );
					$container.find( '.mhc-options-tabs .mhc-options-tab.mhc-options-tab-custom_css' ).css({ 'display' : 'block', opacity : 1 });
				} else {
					$container.find( '.mhc-options-tabs-links li.mhc_options_tab_advanced' ).addClass( 'mhc-options-tabs-links-active' );
					$container.find( '.mhc-options-tabs .mhc-options-tab.mhc-options-tab-advanced' ).css({ 'display' : 'block', opacity : 1 });
				}
			} else {
				$container.find( '.mhc-options-tabs .mhc-options-tab.mhc-options-tab-general' ).css({ 'display' : 'block', opacity : 1 });
			}
		}

		/**
		* Check if current user has permission to lock/unlock content
		*/
		function mhc_user_lock_permissions(){
			var permissions = $.ajax({
				type: "POST",
				url: mhc_options.ajaxurl,
				dataType: 'json',
				data:
				{
					action : 'mhc_current_user_can_lock',
					mh_admin_load_nonce : mhc_options.mh_admin_load_nonce
				},
				beforeSend : function(){
					MH_PageComposer_Events.trigger( 'mhc-loading:started' );
				},
				complete : function(){
					MH_PageComposer_Events.trigger( 'mhc-loading:ended' );
				},
			});

			return permissions;
		}

		/**
		* Check for localStorage support
		*/
		function mhc_has_storage_support(){
			try {
				return 'localStorage' in window && window.localStorage !== null;
			} catch (e){
				return false;
			}
		}

        /**
		 * Check whether the Yoast SEO plugin is active
		 */
		function mhc_is_yoast_seo_active(){
			if ( typeof YoastSEO !== 'undefined' && typeof YoastSEO === 'object' ){
				return true;
			}
			return false;
		}

		/**
		* Clipboard mechanism. Clipboard is only capable of handling one copied content at the onetime
		* @todo add fallback support
		*/
		MHC_Clipboard = {
			key : 'mhc_clipboard_',
			set : function( type, content ){
				if ( mhc_has_storage_support() ){
					// Save the type of copied content
					localStorage.setItem( this.key + 'type', type );

					// Save the copied content
					localStorage.setItem( this.key + 'content', content );
				} else {
					alert( mhc_options.localstorage_unavailability_alert );
				}
			},
			get : function( type ){
				if ( mhc_has_storage_support() ){
					// Get saved type and content
					var saved_type =  localStorage.getItem( this.key + 'type' ),
						saved_content = localStorage.getItem( this.key + 'content' );

					// Check for the compatibility of saved data and paste destination
					// Return value if the supplied type equal with saved value, or if the getter doesn't care about the content's type
					if ( typeof type === 'undefined' || type === saved_type ){
						return saved_content;
					} else {
						return false;
					}
				} else {
					alert( mhc_options.localstorage_unavailability_alert );
				}
			}
		};

		/**
		* Composer hotkeys
		*/
		$(window).keydown(function( event ){
            // do not override default hotkeys inside input fields
			if ( typeof event.target !== 'undefined' && $( event.target ).is( 'input, textarea' ) ){
				return;
			}
            
            if ( event.keyCode === 90 && event.metaKey && event.shiftKey && ! event.altKey || event.keyCode === 90 && event.ctrlKey && event.shiftKey && ! event.altKey ){
				// Redo
				event.preventDefault();

				MH_PageComposer_App.redo( event );

				return false;
            } else if ( event.keyCode === 90 && event.metaKey && ! event.altKey || event.keyCode === 90 && event.ctrlKey && ! event.altKey ){
				// Undo
				event.preventDefault();

				MH_PageComposer_App.undo( event );

				return false;
			}
		});
        // set the correct content for Yoast SEO plugin if it's activated
		if ( mhc_is_yoast_seo_active() ){
			var MHC_Yoast_Content = function(){
				YoastSEO.app.registerPlugin( 'MHC_Yoast_Content', { status: 'ready' });

				YoastSEO.app.registerModification( 'content', this.mhc_update_content, 'MHC_Yoast_Content', 5 );
			}

			/**
			 * Return the content processed by do_shortcode()
			 */
			MHC_Yoast_Content.prototype.mhc_update_content = function( data ){
				var final_content = mhc_processed_yoast_content || mhc_options.yoast_content;

				return final_content;
			};
			new MHC_Yoast_Content();
		}
        
        $( window ).resize( function() {
			var $mhc_prompt_modal = $('.mhc_prompt_modal.mhc_auto_centerize_modal');

			if ( $mhc_prompt_modal.length ) {
				$mhc_prompt_modal.removeAttr( 'style' );
				window.mhc_align_vertical_modal( $mhc_prompt_modal, '.mhc_prompt_buttons' );
            }
		});
	});

})(jQuery);

(function($){

	window.mh_composer = window.mh_composer || {};
    
    /* Override the Yoast function to fix the typing lag caused by Yoast seo plugin
	 * remove the following part from original function:
	 *		e.editor.on('keydown', function() {
	 *			that.loadShortcodes.bind( that, that.declareReloaded.bind( that ) )();
	 *		});
	 */
	if ( typeof window.YoastShortcodePlugin !== 'undefined' ) {
		window.YoastShortcodePlugin.prototype.bindElementEvents = function() {
			var contentElement = document.getElementById( 'content' ) || false;
			var that = this;

			if (contentElement) {
				contentElement.addEventListener( 'keydown', this.loadShortcodes.bind( this, this.declareReloaded.bind( this ) ) );
				contentElement.addEventListener( 'change', this.loadShortcodes.bind( this, this.declareReloaded.bind( this ) ) );
			}

			if( typeof tinyMCE !== 'undefined' && typeof tinyMCE.on === 'function' ) {
				tinyMCE.on( 'addEditor', function( e ) {
					e.editor.on( 'change', function() {
						that.loadShortcodes.bind( that, that.declareReloaded.bind( that ) )();
					});
				});
			}
		}
	}
    
	$( document ).ready(function(){
		var mh_composer = {},
			mh_composer_template_options = {
                tabs: {},
				switch_button: {}
            };
        
        window.mh_composer_template_options = mh_composer_template_options;

		// hook for necessary adv form field logic for tabbed posts module
		function adv_setting_form_category_select_update_hidden( that ){
			$select_field = that.$el.find('#mhc_category_id');
			$hidden_name_field = that.$el.find('#mhc_category_name');

			if ( $select_field.length && $hidden_name_field.length ){
				category_name = $select_field.find('option:selected').text().trim();
				$hidden_name_field.val( category_name );

				$select_field.on('change', function(){
					category_name = $(this).find('option:selected').text().trim();
					$hidden_name_field.val( category_name );
				});
			}
		}
		MH_PageComposer.Events.on('mh-advanced-module-settings:render', adv_setting_form_category_select_update_hidden );

		mh_composer = {
			font_icon_list_template: function(){
				var template = $('#mh-composer-font-icon-list-items').html();

				return template;
			},
            steadysets_icon_list_template: function(){
				var template = $('#mh-composer-font-steadysets-icon-list-items').html();

				return template;
			},
            awesome_icon_list_template: function(){
				var template = $('#mh-composer-font-awesome-icon-list-items').html();

				return template;
			},
            etline_icon_list_template: function(){
				var template = $('#mh-composer-font-etline-icon-list-items').html();

				return template;
			},
            lineicons_icon_list_template: function(){
				var template = $('#mh-composer-font-lineicons-icon-list-items').html();

				return template;
			},
            icomoon_icon_list_template: function(){
				var template = $('#mh-composer-font-icomoon-icon-list-items').html();

				return template;
			},
			linearicons_icon_list_template: function(){
				var template = $('#mh-composer-font-linearicons-icon-list-items').html();

				return template;
            },
            preview_tabs_output: function(){
				var template = $('#mh-composer-preview-icons-template').html();

				return template;
			},
			options_tabs_output: function( options ){
				var template = _.template( $('#mh-composer-options-tabs-links-template').html() ),
                    options_filtered = {},
					options_filtered_index = 1,
					template_processed;

                window.mh_composer_template_options['tabs']['options'] = $.extend({}, options );

				template_processed = template( window.mh_composer_template_options.tabs );

				return template_processed;
			},
			options_switch_button_output: function( options ){
				var template = _.template( $('#mh-composer-switch-button-template').html() ),
					template_processed;

                window.mh_composer_template_options['switch_button']['options'] = $.extend({}, options );

				template_processed = template( window.mh_composer_template_options.switch_button );

				return template_processed;
			}
		};

		$.extend( window.mh_composer, mh_composer );

		// Adjust the height of tinymce iframe when fullscreen mode enabled from the mharty composer
		function mhc_adjust_fullscreen_mode(){
			var $modal_container = $( '.mhc_modal_settings_container' );

			// if fullscreen mode enabled then calculate and apply correct height
			if ( $modal_container.find( 'div.mce-fullscreen' ).length ){
				setTimeout(function(){
					var modal_height = $modal_container.innerHeight(),
						toolbar_height = $modal_container.find( '.mce-toolbar-grp' ).innerHeight();

					$modal_container.find( 'iframe' ).height( modal_height - toolbar_height );
				}, 100 );
			}
		}

		// recalculate sizes of tinymce iframe when Fullscreen button clicked
		$( 'body' ).on( 'click', '.mhc_module_settings .mce-i-fullscreen', function(){
			mhc_adjust_fullscreen_mode();
		});

		// recalculate sizes of tinymce iframe when window resized
		$( window ).resize(function(){
			mhc_adjust_fullscreen_mode();
		});

		// handle Escape and Enter buttons in the composer
		$( document ).keydown(function(e){

			if ( ! $( '.mhc_modal_settings_container' ).is( ':focus' ) && ! $( '.mhc_modal_settings_container *' ).is( ':focus' ) && ! $( '.mhc_prompt_modal' ).is( ':visible' ) ){
				return;
			}

			var $save_button = $( '.mhc-modal-save' ),
				$proceed_button = $( '.mhc_prompt_proceed' ),
				$close_button = $( '.mhc-modal-close' ),
				$composer_buttons = $( '#mhc_main_container a, #mhc_toggle_composer' );

			switch( e.which ){
				// Enter button handling
				case 13 :
					// do nothing if focus is in the textarea or in the map address field so enter will work as expected
					if ( $( '.mhc-option-container textarea, #mhc_address, #mhc_pin_address' ).is( ':focus' ) ){
						return;
					}
					//remove focus from the composer buttons to avoid unexpected behavior
					$composer_buttons.blur();

					if ( $save_button.length || $proceed_button.length ){
						// it's possible that proceed button displayed above the save, we need to click only proceed button in that case
						if ( $proceed_button.length ){
							$proceed_button.click();
						} else {
							// it's possible that there are 2 Modals appear on top of each other, save the one which is on top
							if ( typeof $save_button[1] !== 'undefined' ){
								$save_button[1].click();
							} else {
								$save_button.click();
							}
						}
					}
					break;
				// Escape button handling
				case 27 :
					// click close button if it exist on the screen
					if ( $close_button.length ){
						// it's possible that there are 2 Modals appear on top of each other, close the one which is on top
						if ( typeof $close_button[1] !== 'undefined' ){
							$close_button[1].click();
						} else {
							$close_button.click();
						}
					}
					break;
			}
		});
	});
    
    // hide cache notice
    $( '.mhc_hide_cache_notice' ).click( function() {
        $( this ).closest( '.update-nag' ).hide();

        $.ajax({
            type: "POST",
            url: mhc_options.ajaxurl,
            data: {
                action : 'mhc_hide_cache_notice',
                mh_admin_load_nonce : mhc_options.mh_admin_load_nonce
            }
        });
    });
    
    // Fix for fullscreen editor in firefox
    $('body.wp-admin').on( 'click', '.mhc-modal-container .mce-widget.mce-btn[aria-label="Fullscreen"] button', function(){
        setTimeout( function(){
            $(window).trigger( 'resize' );
        }, 50 );
    });
    
})(jQuery);