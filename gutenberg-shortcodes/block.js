/**
 * MB Spirit Shortcode builder
 *
 * Simple interactivity to launch and manage shortcodes.
 *
 * 
 */
 var scinfo = {};
( function ( blocks, i18n, element, blockEditor ) {
	var el = element.createElement;
	var __ = i18n.__;
	var useBlockProps = blockEditor.useBlockProps;

	var blockStyle = {
		margin: "0px auto",
		backgroundImage: 'linear-gradient(to bottom,#f0ad4e 0,#eb9316 100%)',
		borderColor: '#e38d13',
		cursor:'pointer',
		color: '#fff',
		padding: '10px 20px',
		
	};
	var activeShortCode = '';

	blocks.registerBlockType( 'mb-spirit/shortcode-builder', {
		edit: function (props) {
			return [
				el(
					'div',
					useBlockProps({style: {padding: '10px',border: '2px solid #e38d13',margin: "0px auto",display:'flex',alignItems:'center'}}),
					[
						el(
							'div',
							{style:{margin: "0px auto",flexGrow:1}},
							[
								el(
									'div',
									{style:{margin: "0px"}},
									"Add MB Spirit Widgets to your pages for dynamic content from MindBody"
								),
								el(
									'div',
									{'data-sc-code':'mb-spirit',style:{margin: "0px",fontSize:'10px',fontFamily:'monospace'}},
									props.attributes.shortCode
								)
							],
						),
						el(
							'div',
							{},
							el(
								'button',
							    
								{ 
									style: blockStyle, 
									type: "button", 
									onClick: function()
									{
										scinfo = {
											btn: jQuery('')
											,ed: jQuery('')
											,textarea: jQuery('')
											,gutenburg: true
											,gutenburgCallback: function(shortcode) {
												props.setAttributes({shortCode:shortcode});
												jQuery('[data-block="' + props.clientId + '"] [data-sc-code="mb-spirit"').html(shortcode);
											}
											,tinyactive: false
											,store_value:false
											,store_desc:false
											,widget_type:false
										};
										jQuery.getJSON(
											ajaxurl,
											{action:'mb_spirit_api_proxy',endpoint:'wp_shortcode_builder',tb:1},
											function(res) {
												jQuery('#mb-spirit-widget-modal').remove();
												var $modal = jQuery('<div id="mb-spirit-widget-modal" class="mb-spirit-modal-wrap"><div class="mb-spirit-modal"><div class="mb-spirit-modal-header"><h3>MB Spirit Widgets</h3><div class="modal-close">&times</div></div><div class="mb-spirit-modal-content"><div id="mb-spirit-shortcodes"></div></div></div></div>');
												$modal.find('#mb-spirit-shortcodes').html(res.wp_html);
												jQuery('body').append($modal);
												$modal.fadeOut(5);
												setTimeout(function(){$modal.fadeIn();},100);
												$modal.find('.modal-close').on('click',function(){
													$modal.fadeOut(250,function(){$modal.remove();});
												});
											}
										);

									}
								}
								,
								__(
									'MB Spirit Shortcodes',
									'mb-spirit'
								)
							)
						),
					]
				)
			];
		},
		save: () => null,
	} );
} )(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element,
	window.wp.blockEditor
);