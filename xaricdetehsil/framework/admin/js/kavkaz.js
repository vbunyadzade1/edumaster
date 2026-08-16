jQuery(window).on( 'load', function() {

	/* PAGE TEMPLATES OPTIONS
	------------------------------------------------------------------------------------------*/

	var $pageTemplateAttr = "select[name='page_template']";
	if( jQuery('body').hasClass('block-editor-page') ){
		$pageTemplateAttr = '.editor-page-attributes__template select';
	}

	// on load
	var selected_item = jQuery( $pageTemplateAttr ).val();

	if (selected_item == 'template-blog.php' || selected_item == 'template-masonry.php' || selected_item == 'template-media.php' ) {
		jQuery('#kavkaz-template-blog').show();
	}
	else if (selected_item == 'template-best-reviews.php') {
		jQuery('#kavkaz-template-blog, #kavkaz_posts_num-item').show();
	}
	else if (selected_item == 'template-authors.php') {
		jQuery('#kavkaz-template-authors').show();
	}

	// on Chnage
	jQuery($pageTemplateAttr).change(function(){
		var selected_item = jQuery($pageTemplateAttr).val();
		jQuery('#kavkaz-template-blog, #kavkaz-template-authors, #kavkaz_posts_num-item').hide();

		if (selected_item == 'template-blog.php' || selected_item == 'template-masonry.php' || selected_item == 'template-media.php' ) {
			jQuery('#kavkaz-template-blog').fadeIn();
		}
		if (selected_item == 'template-best-reviews.php') {
			jQuery('#kavkaz-template-blog, #kavkaz_posts_num-item').fadeIn();
		}
		if (selected_item == 'template-authors.php') {
			jQuery('#kavkaz-template-authors').fadeIn();
		}
	});

});



jQuery(document).ready(function() {


	jQuery('.kavkaz-tooltip').each(function() {
		jQuery(this).tooltip({
			content: function() {
				return jQuery(this).prop('title');
			},
			tooltipClass: 'kavkaz-ui-tooltip',
			position: {
				my: 'center top',
				at: 'center bottom+10',
				collision: 'flipfit'
			},
			hide: {
				duration: 200
			},
			show: {
				duration: 200
			}
		});
	});


	if( jQuery('li.menu-top.toplevel_page_panel .kavkaz-theme-update').length ){
		jQuery('li.menu-top.toplevel_page_panel .wp-menu-name').append( ' <span class="update-plugins"><span class="update-count">'+kavkazLang.update+'</span></span>' );
	}

	// Preview Fonts
	jQuery("select[name='kavkaz_options[typography_test][font]']").change(function(){
		var selected_font = jQuery("select[name='kavkaz_options[typography_test][font]'] option:selected").val();
		var parts = selected_font.split(':');
		var output =  parts[0] ;
		jQuery("#kavkaz-fonts-css").attr( 'href' , 'https://fonts.googleapis.com/css?family='+output );
		jQuery("#font-preview").css( "font-family" , output );
	});

	jQuery("input[name='kavkaz_options[typography_test][color]']").change(function(){
		var selected_color = jQuery("input[name='kavkaz_options[typography_test][color]']").val();
		jQuery("#font-preview").css( "color" , selected_color );
	});

	jQuery("select[name='kavkaz_options[typography_test][size]']").change(function(){
		var selected_size = jQuery("select[name='kavkaz_options[typography_test][size]'] option:selected").val();
		jQuery("#font-preview").css( "font-size" , selected_size+'px' );
	});

	jQuery("select[name='kavkaz_options[typography_test][weight]']").change(function(){
		var selected_weight = jQuery("select[name='kavkaz_options[typography_test][weight]'] option:selected").val();
		jQuery("#font-preview").css( "font-weight" , selected_weight );
	});

	jQuery("select[name='kavkaz_options[typography_test][style]']").change(function(){
		var selected_style = jQuery("select[name='kavkaz_options[typography_test][style]'] option:selected").val();
		jQuery("#font-preview").css( "font-style" , selected_style );
	});


// Del Preview Image
	jQuery(document).on("click", ".del-img" , function(){
		jQuery(this).parent().fadeOut(function() {
			jQuery(this).hide();
			jQuery(this).parent().find('input[class="img-path"]').attr('value', '' );
		});
	});

// Breaking News options
	var selected_breaking = jQuery("input[name='kavkaz_options[breaking_type]']:checked").val();

	jQuery('#breaking_cat-item , #breaking_tag-item , #breaking_custom-item , #breaking_number-item').hide();

	if (selected_breaking == 'category') {jQuery('#breaking_cat-item , #breaking_number-item').show();}
	if (selected_breaking == 'tag') {jQuery('#breaking_tag-item , #breaking_number-item').show();}
	if (selected_breaking == 'custom') { jQuery('#breaking_custom-item').show(); }

	jQuery("input[name='kavkaz_options[breaking_type]']").change(function(){
		var selected_breaking = jQuery("input[name='kavkaz_options[breaking_type]']:checked").val();
		if (selected_breaking == 'category') {
			jQuery('#breaking_tag-item , #breaking_custom-item').hide();
			jQuery('#breaking_cat-item , #breaking_number-item').fadeIn();
		}
		if (selected_breaking == 'tag') {
			jQuery('#breaking_cat-item , #breaking_custom-item').hide();
			jQuery('#breaking_tag-item , #breaking_number-item').fadeIn();
		}
		if (selected_breaking == 'custom') {
			jQuery('#breaking_cat-item , #breaking_tag-item , #breaking_number-item').hide();
			jQuery('#breaking_custom-item').fadeIn();
		}

	 });

// Single Post Head
	var selected_item = jQuery("select[name='kavkaz_post_head'] option:selected").val();

	if (selected_item == 'video') {jQuery('#kavkaz_video_url-item, #kavkaz_video_self-item, #kavkaz_embed_code-item').show();}
	if (selected_item == 'audio') {jQuery('#kavkaz_audio_mp3-item, #kavkaz_audio_m4a-item, #kavkaz_audio_oga-item').show();}
	if (selected_item == 'soundcloud') {jQuery('#kavkaz_audio_soundcloud-item, #kavkaz_audio_soundcloud_play-item, #kavkaz_audio_soundcloud_visual-item').show();}
	if (selected_item == 'slider') {jQuery('#kavkaz_post_slider-item').show();}
	if (selected_item == 'map') {jQuery('#kavkaz_googlemap_url-item').show();}

	jQuery("select[name='kavkaz_post_head']").change(function(){
		var selected_item = jQuery("select[name='kavkaz_post_head'] option:selected").val();
		if (selected_item == 'video') {
			jQuery('#kavkaz_post_slider-item, #kavkaz_googlemap_url-item, #kavkaz_audio_mp3-item, #kavkaz_audio_m4a-item, #kavkaz_audio_oga-item, #kavkaz_audio_soundcloud-item, #kavkaz_audio_soundcloud_play-item, #kavkaz_audio_soundcloud_visual-item').hide();
			jQuery('#kavkaz_video_url-item, #kavkaz_video_self-item, #kavkaz_embed_code-item').fadeIn();
		}
		if (selected_item == 'audio') {
			jQuery('#kavkaz_video_url-item, #kavkaz_video_self-item, #kavkaz_embed_code-item, #kavkaz_post_slider-item, #kavkaz_googlemap_url-item, #kavkaz_audio_soundcloud-item, #kavkaz_audio_soundcloud_play-item, #kavkaz_audio_soundcloud_visual-item').hide();
			jQuery('#kavkaz_audio_mp3-item, #kavkaz_audio_m4a-item, #kavkaz_audio_oga-item').fadeIn();
		}
		if (selected_item == 'soundcloud') {
			jQuery('#kavkaz_video_url-item, #kavkaz_video_self-item, #kavkaz_embed_code-item, #kavkaz_post_slider-item, #kavkaz_googlemap_url-item, #kavkaz_audio_mp3-item, #kavkaz_audio_m4a-item, #kavkaz_audio_oga-item').hide();
			jQuery('#kavkaz_audio_soundcloud-item, #kavkaz_audio_soundcloud_play-item, #kavkaz_audio_soundcloud_visual-item').fadeIn();
		}
		if (selected_item == 'slider') {
			jQuery('#kavkaz_video_url-item, #kavkaz_video_self-item, #kavkaz_embed_code-item, #kavkaz_googlemap_url-item, #kavkaz_audio_mp3-item, #kavkaz_audio_m4a-item, #kavkaz_audio_oga-item, #kavkaz_audio_soundcloud-item, #kavkaz_audio_soundcloud_play-item, #kavkaz_audio_soundcloud_visual-item').hide();
			jQuery('#kavkaz_post_slider-item').fadeIn();
		}
		if (selected_item == 'map') {
			jQuery('#kavkaz_video_url-item, #kavkaz_video_self-item, #kavkaz_embed_code-item, #kavkaz_post_slider-item, #kavkaz_audio_mp3-item, #kavkaz_audio_m4a-item, #kavkaz_audio_oga-item, #kavkaz_audio_soundcloud-item, #kavkaz_audio_soundcloud_play-item, #kavkaz_audio_soundcloud_visual-item').hide();
			jQuery('#kavkaz_googlemap_url-item').fadeIn();
		}
		if (selected_item == 'thumb' || selected_item == 'none' || selected_item == '') {
			jQuery('#kavkaz_video_url-item, #kavkaz_video_self-item, #kavkaz_embed_code-item, #kavkaz_post_slider-item, #kavkaz_googlemap_url-item, #kavkaz_audio_mp3-item, #kavkaz_audio_m4a-item, #kavkaz_audio_oga-item, #kavkaz_audio_soundcloud-item, #kavkaz_audio_soundcloud_play-item, #kavkaz_audio_soundcloud_visual-item').hide();
		}
	 });

// Slider Type
	var selected_pos = jQuery("input[name='slider_type']:checked").val();
	if (selected_pos == 'elastic') {jQuery('#elastic').show();}
	if (selected_pos == 'flexi') {jQuery('#flexi').show();}
	jQuery("input[name='slider_type']").change(function(){
		var selected_pos = jQuery("input[name='slider_type']:checked").val();
		if (selected_pos == 'elastic') {
			jQuery('#flexi').hide();
			jQuery('#elastic').fadeIn();
		}
		if (selected_pos == 'flexi') {
			jQuery('#elastic').hide();
			jQuery('#flexi').fadeIn();
		}
	 });

// Slider Category Type
	var selected_pos = jQuery("input[name='kavkaz_cat[slider_type]']:checked").val();
	if (selected_pos == 'elastic') {jQuery('#elastic').show();}
	if (selected_pos == 'flexi') {jQuery('#flexi').show();}
	jQuery("input[name='kavkaz_cat[slider_type]']").change(function(){
		var selected_pos = jQuery("input[name='kavkaz_cat[slider_type]']:checked").val();
		if (selected_pos == 'elastic') {
			jQuery('#flexi').hide();
			jQuery('#elastic').fadeIn();
		}
		if (selected_pos == 'flexi') {
			jQuery('#elastic').hide();
			jQuery('#flexi').fadeIn();
		}
	 });

// Slider Query Type
	var selected_type = jQuery("input[name='slider_query']:checked").val();

	if (selected_type == 'category') {jQuery('#slider_cat-item').show();}
	if (selected_type == 'tag') {jQuery('#slider_tag-item').show();}
	if (selected_type == 'post') {jQuery('#slider_posts-item').show();}
	if (selected_type == 'page') {jQuery('#slider_pages-item').show();}
	if (selected_type == 'custom') {jQuery('#slider_custom-item').show();}

	jQuery("input[name='slider_query']").change(function(){
		var selected_type = jQuery("input[name='slider_query']:checked").val();
		if (selected_type == 'category') {
			jQuery('#slider_tag-item ,#slider_posts-item ,#slider_pages-item,#slider_custom-item').hide();
			jQuery('#slider_cat-item').fadeIn();
		}
		if (selected_type == 'tag') {
			jQuery('#slider_cat-item ,#slider_posts-item ,#slider_pages-item,#slider_custom-item').hide();
			jQuery('#slider_tag-item').fadeIn();
		}
		if (selected_type == 'post') {
			jQuery('#slider_cat-item ,#slider_tag-item ,#slider_pages-item,#slider_custom-item').hide();
			jQuery('#slider_posts-item').fadeIn();
		}
		if (selected_type == 'page') {
			jQuery('#slider_cat-item ,#slider_posts-item ,#slider_tag-item,#slider_custom-item').hide();
			jQuery('#slider_pages-item').fadeIn();
		}
		if (selected_type == 'custom') {
			jQuery('#slider_cat-item ,#slider_posts-item ,#slider_tag-item,#slider_pages-item').hide();
			jQuery('#slider_custom-item').fadeIn();
		}
	 });


// Featured Posts Query Type
	var selected_type = jQuery("input[name='featured_posts_query']:checked").val();

	if (selected_type == 'category') {jQuery('#featured_posts_cat-item').show();}
	if (selected_type == 'tag') {jQuery('#featured_posts_tag-item').show();}
	if (selected_type == 'post') {jQuery('#featured_posts_posts-item').show();}
	if (selected_type == 'page') {jQuery('#featured_posts_pages-item').show();}
	if (selected_type == 'custom') {jQuery('#featured_posts_custom-item').show();}

	jQuery("input[name='featured_posts_query']").change(function(){
		var selected_type = jQuery("input[name='featured_posts_query']:checked").val();
		if (selected_type == 'category') {
			jQuery('#featured_posts_tag-item ,#featured_posts_posts-item ,#featured_posts_pages-item,#featured_posts_custom-item').hide();
			jQuery('#featured_posts_cat-item').fadeIn();
		}
		if (selected_type == 'tag') {
			jQuery('#featured_posts_cat-item ,#featured_posts_posts-item ,#featured_posts_pages-item,#featured_posts_custom-item').hide();
			jQuery('#featured_posts_tag-item').fadeIn();
		}
		if (selected_type == 'post') {
			jQuery('#featured_posts_cat-item ,#featured_posts_tag-item ,#featured_posts_pages-item,#featured_posts_custom-item').hide();
			jQuery('#featured_posts_posts-item').fadeIn();
		}
		if (selected_type == 'page') {
			jQuery('#featured_posts_cat-item ,#featured_posts_posts-item ,#featured_posts_tag-item,#featured_posts_custom-item').hide();
			jQuery('#featured_posts_pages-item').fadeIn();
		}
		if (selected_type == 'custom') {
			jQuery('#featured_posts_cat-item ,#featured_posts_posts-item ,#featured_posts_tag-item,#featured_posts_pages-item').hide();
			jQuery('#featured_posts_custom-item').fadeIn();
		}
	 });

// Save Settings Alert
	jQuery(".mpanel-save").click( function() {
		jQuery('#save-alert').fadeIn();
	});


/* Page Builder
-------------------------------------------------------------------------------- */
	//Enable/Disable the Builder For the page
	jQuery("#kavkaz_page_builder").click( function() {

		if( jQuery(this).hasClass( 'builder_active' ) ){
			jQuery(this).removeClass( 'button-primary builder_active' );

			jQuery( '#postdivrich, #pageparentdiv, #postimagediv, #kavkaz_post_head_options_box, #kavkaz_ads_options_box, #kavkaz_sidebar_position_full' ).fadeIn();
			jQuery( '#Home_Builder' ).hide();

			jQuery( '#kavkaz_builder_active' ).val( '' );
		}else{
			jQuery(this).addClass( 'button-primary builder_active' );

			jQuery( '#Home_Builder' ).fadeIn();
			jQuery( '#postdivrich, #pageparentdiv, #postimagediv, #kavkaz_post_head_options_box, #kavkaz_ads_options_box, #kavkaz-template-authors, #kavkaz-template-blog, #kavkaz_sidebar_position_full' ).hide();

			jQuery( '#kavkaz_builder_active' ).val( 'yes' );

			//Sidebar
			jQuery( '#kavkaz_sidebar_pos_full').attr("checked","")
			jQuery( "#kavkaz_sidebar_position_full").removeClass("selected");
			jQuery( "#kavkaz_sidebar_position_default").addClass("selected");
			jQuery( '#kavkaz_sidebar_pos_default' ).attr("checked","checked");

			//Page templates
			jQuery( '#page_template option:first-child' ).attr("selected","selected");
		}
		return false;
	});

	//If Builder Active hide boxes
	if ( jQuery("#kavkaz_builder_active").val() == 'yes') {
		jQuery('#postdivrich, #pageparentdiv, #postimagediv, #kavkaz_post_head_options_box, #kavkaz_ads_options_box, #kavkaz-template-authors, #kavkaz-template-blog, #kavkaz_sidebar_position_full').hide();
	}

	// Build The Boxes
	var kavkazCategories = jQuery('#cats_default').html();
	var kavkazCategoriesTabs = jQuery('#cats_default_tabs').html();
	var kavkazProductsCategories = jQuery('#products_default').html();

	jQuery(".add-cat").click(function() {
		var style = jQuery( this ).data( 'style' );
		jQuery('#cat_sortable').append('\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
				<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/'+style+'-small.png" />'+ kavkazLang.bulider_block +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div style="display:block" class="widget-content">\
					<label><span>'+ kavkazLang.bulider_category +'</span>\
						<select name="kavkaz_home_cats['+ nextCell +'][id]" id="kavkaz_home_cats['+ nextCell +'][id]">'+kavkazCategories+'</select>\
					</label>\
					<label><span>'+ kavkazLang.bulider_order +'</span>\
						<select name="kavkaz_home_cats['+ nextCell +'][order]" id="kavkaz_home_cats['+ nextCell +'][order]">\
							<option value="latest" selected="selected">'+ kavkazLang.bulider_latest +'</option>\
							<option value="rand">'+ kavkazLang.bulider_random +'</option>\
						</select>\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][number]">\
						<span>'+ kavkazLang.bulider_posts +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][number]" name="kavkaz_home_cats['+ nextCell +'][number]" value="5" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][offset]">\
						<span>'+ kavkazLang.bulider_offset +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][offset]" name="kavkaz_home_cats['+ nextCell +'][offset]" value="" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][thumb_first]">\
						<span>'+ kavkazLang.bulider_thumbnail +'</span>\
						<input class="on-of" type="checkbox" name="kavkaz_home_cats['+ nextCell +'][thumb_first]" value="true" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][thumb_small]">\
						<span>'+ kavkazLang.bulider_thumbnails +'</span>\
						<input class="on-of" type="checkbox" name="kavkaz_home_cats['+ nextCell +'][thumb_small]" value="true" />\
					</label>\
					<input id="kavkaz_home_cats['+ nextCell +'][style]" name="kavkaz_home_cats['+ nextCell +'][style]" type="hidden" value="'+style+'" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="n" type="hidden" />\
					<a class="del-cat"></a>\
				</div>\
			</li>');
		jQuery('#listItem_'+ nextCell).find('.on-of').checkbox({empty: emptyImg });
		jQuery('#listItem_'+ nextCell).hide().fadeIn();
		nextCell ++ ;
	});

	jQuery("#add-slider").click(function() {
		jQuery('#cat_sortable').append('\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
				<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/scrolling-small.png" />'+ kavkazLang.bulider_scrolling +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div class="widget-content" style="display:block">\
					<label>\
						<span>'+ kavkazLang.bulider_category +'</span>\
						<select name="kavkaz_home_cats['+ nextCell +'][id]" id="kavkaz_home_cats['+ nextCell +'][id]">'+kavkazCategories+'</select>\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][title]">\
						<span>'+ kavkazLang.bulider_title +'</span>\
						<input id="kavkaz_home_cats['+ nextCell +'][title]" name="kavkaz_home_cats['+ nextCell +'][title]" value="'+ kavkazLang.bulider_scrolling +'" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][number]">\
						<span>'+ kavkazLang.bulider_posts +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][number]" name="kavkaz_home_cats['+ nextCell +'][number]" value="12" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][offset]">\
						<span>'+ kavkazLang.bulider_offset +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][offset]" name="kavkaz_home_cats['+ nextCell +'][offset]" value="" type="text" />\
					</label>\
					<input id="kavkaz_home_cats['+ nextCell +'][boxid]" name="kavkaz_home_cats['+ nextCell +'][boxid]" value="s_'+ 1 + Math.floor(Math.random() * 1500)+'" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="s" type="hidden" />\
					<a class="del-cat"></a>\
				</div>\
			</li>');
		jQuery('#listItem_'+ nextCell).hide().fadeIn();
		nextCell ++ ;
	});

	jQuery(".add-news-picture").click(function() {
		var style = jQuery( this ).data( 'style' );
		jQuery('#cat_sortable').append('\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
				<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/pic-'+style+'-small.png" />'+ kavkazLang.bulider_picture +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div class="widget-content" style="display:block">\
					<label>\
						<span>'+ kavkazLang.bulider_category +'</span>\
						<select name="kavkaz_home_cats['+ nextCell +'][id]" id="kavkaz_home_cats['+ nextCell +'][id]">'+kavkazCategories+'</select>\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][title]">\
						<span>'+ kavkazLang.bulider_title +'</span>\
						<input id="kavkaz_home_cats['+ nextCell +'][title]" name="kavkaz_home_cats['+ nextCell +'][title]" value="News In Picture" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][offset]">\
						<span>'+ kavkazLang.bulider_offset +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][offset]" name="kavkaz_home_cats['+ nextCell +'][offset]" value="" type="text" />\
					</label>\
					<input id="kavkaz_home_cats['+ nextCell +'][boxid]" name="kavkaz_home_cats['+ nextCell +'][boxid]" value="news-pic_'+ 1 + Math.floor(Math.random() * 1500)+'" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="news-pic" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][style]" name="kavkaz_home_cats['+ nextCell +'][style]" type="hidden" value="'+style+'" />\
					<a class="del-cat"></a>\
				</div>\
			</li>');

		jQuery('#listItem_'+ nextCell).hide().fadeIn();
		nextCell ++ ;
	});

	jQuery("#add-news-videos").click(function() {
		jQuery('#cat_sortable').append('\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
				<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/videos-small.png" />'+ kavkazLang.bulider_videos +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div class="widget-content" style="display:block">\
					<label>\
						<span>'+ kavkazLang.bulider_category +'</span>\
						<select name="kavkaz_home_cats['+ nextCell +'][id]" id="kavkaz_home_cats['+ nextCell +'][id]">'+kavkazCategories+'</select>\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][title]">\
						<span>'+ kavkazLang.bulider_title +'</span>\
						<input id="kavkaz_home_cats['+ nextCell +'][title]" name="kavkaz_home_cats['+ nextCell +'][title]" value="'+ kavkazLang.bulider_videos +'" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][offset]">\
						<span>'+ kavkazLang.bulider_offset +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][offset]" name="kavkaz_home_cats['+ nextCell +'][offset]" value="" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][lightbox]">\
						<span>'+ kavkazLang.bulider_lightbox +'</span>\
						<input class="on-of" type="checkbox" name="kavkaz_home_cats['+ nextCell +'][lightbox]" value="true" checked="checked" />\
					</label>\
					<p class="kavkaz_message_hint">'+ kavkazLang.bulider_videos_lightbox +'</p>\
					<input id="kavkaz_home_cats['+ nextCell +'][boxid]" name="kavkaz_home_cats['+ nextCell +'][boxid]" value="videos_'+ 1 + Math.floor(Math.random() * 1500)+'" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="videos" type="hidden" />\
					<a class="del-cat"></a>\
				</div>\
			</li>');
		jQuery('#listItem_'+ nextCell).find('.on-of').checkbox({empty: emptyImg });
		jQuery('#listItem_'+ nextCell).hide().fadeIn();
		nextCell ++ ;
	});


	jQuery(".add-recent").click(function() {
		var style = jQuery( this ).data( 'style' );
		var num = 15 ;
		if( style == 'default' ){
			num = 3;
		}
		var recentBox = '\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
			<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/recent-'+style+'-small.png" />'+ kavkazLang.bulider_recent +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div style="display:block" class="widget-content">\
					<label>\
						<span class="option-contents">'+ kavkazLang.bulider_exclude +'</span>\
						<select multiple="multiple" name="kavkaz_home_cats['+ nextCell +'][exclude][]" id="kavkaz_home_cats['+ nextCell +'][exclude][]">'+kavkazCategories+'</select>\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][title]">\
						<span>'+ kavkazLang.bulider_title +'</span>\
						<input id="kavkaz_home_cats['+ nextCell +'][title]" name="kavkaz_home_cats['+ nextCell +'][title]" value="'+ kavkazLang.bulider_recent +'" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][number]">\
						<span>'+ kavkazLang.bulider_posts +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][number]" name="kavkaz_home_cats['+ nextCell +'][number]" value="'+num+'" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][offset]">\
						<span>'+ kavkazLang.bulider_offset +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][offset]" name="kavkaz_home_cats['+ nextCell +'][offset]" value="" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][pagi]">\
						<span>'+ kavkazLang.bulider_pagination +'</span>\
						<input class="on-of" type="checkbox" name="kavkaz_home_cats['+ nextCell +'][pagi]" value="true" />\
					</label>';

		if( style != 'default' ){
			recentBox += '\
					<label for="kavkaz_home_cats['+ nextCell +'][share]">\
						<span>'+ kavkazLang.bulider_social +'</span>\
						<input class="on-of" type="checkbox" name="kavkaz_home_cats['+ nextCell +'][share]" value="true" />\
					</label>';
		}

			recentBox += '\
					<input id="kavkaz_home_cats['+ nextCell +'][display]" name="kavkaz_home_cats['+ nextCell +'][display]" type="hidden" value="'+style+'" />\
					<p class="kavkaz_message_hint">'+ kavkazLang.bulider_warning +'</p>\
					<input id="kavkaz_home_cats['+ nextCell +'][boxid]" name="kavkaz_home_cats['+ nextCell +'][boxid]" value="recent_'+ 1 + Math.floor(Math.random() * 1500)+'" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="recent" type="hidden" />\
					<a class="del-cat"></a>\
				</div>\
			</li>';

			jQuery('#cat_sortable').append( recentBox );
			jQuery('#listItem_'+ nextCell).find('.on-of').checkbox({empty: emptyImg });
			jQuery('#listItem_'+ nextCell).hide().fadeIn();

		nextCell ++ ;
	});

	jQuery("#add-tabs").click(function() {
		var tabsContent = '';
		jQuery.each( categoriesTabs, function( key, value ) {
			tabsContent = tabsContent+'<li>\
									<input name="kavkaz_home_cats['+ nextCell +'][cat][]" type="checkbox" value="'+key+'">\
									<span>'+value+'</span>\
								</li>\
								';
			});

		jQuery('#cat_sortable').append('\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
			<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/tabs-small.png" />'+ kavkazLang.bulider_tabs +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div style="display:block" class="widget-content">\
					<span class="label">'+ kavkazLang.bulider_categories +'</span>\
					<div class="clear"></div> <p></p>\
					<ul class="tabs_cats">\
					'+tabsContent+'\
					</ul>\
					<input id="kavkaz_home_cats['+ nextCell +'][boxid]" name="kavkaz_home_cats['+ nextCell +'][boxid]" value="tabs_'+ 1 + Math.floor(Math.random() * 1500)+'" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="tabs" type="hidden" />\
					<a class="del-cat"></a>\
				</div>\
			</li>');
		jQuery('#listItem_'+ nextCell).hide().fadeIn();
		nextCell ++ ;
	});

	jQuery("#add-products").click(function() {
		jQuery('#cat_sortable').append('\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
			<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/woo-small.png" />'+ kavkazLang.bulider_woocommerce +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div style="display:block" class="widget-content">\
					<label>\
						<span class="option-contents">'+ kavkazLang.bulider_categories +'</span>\
						<select multiple="multiple" name="kavkaz_home_cats['+ nextCell +'][cats][]" id="kavkaz_home_cats['+ nextCell +'][cats][]">'+kavkazProductsCategories+'</select>\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][title]">\
						<span>'+ kavkazLang.bulider_title +'</span>\
						<input id="kavkaz_home_cats['+ nextCell +'][title]" name="kavkaz_home_cats['+ nextCell +'][title]" value="'+ kavkazLang.bulider_recent_products +'" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][number]">\
						<span>'+ kavkazLang.bulider_products +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][number]" name="kavkaz_home_cats['+ nextCell +'][number]" value="3" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][offset]">\
						<span>'+ kavkazLang.bulider_pro_offset +'</span>\
						<input style="width:50px;" id="kavkaz_home_cats['+ nextCell +'][offset]" name="kavkaz_home_cats['+ nextCell +'][offset]" value="" type="text" />\
					</label>\
					<label for="kavkaz_home_cats['+ nextCell +'][display]">\
						<span>'+ kavkazLang.bulider_mode +'</span>\
						<select id="kavkaz_home_cats['+ nextCell +'][display]" name="kavkaz_home_cats['+ nextCell +'][display]">\
							<option value="default">'+ kavkazLang.bulider_default +'</option>\
							<option value="scrolling">'+ kavkazLang.bulider_scroll +'</option>\
						</select>\
					</label>\
					<input id="kavkaz_home_cats['+ nextCell +'][boxid]" name="kavkaz_home_cats['+ nextCell +'][boxid]" value="recent_'+ 1 + Math.floor(Math.random() * 1500)+'" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="woocommerce" type="hidden" />\
					<a class="del-cat"></a>\
				</div>\
			</li>');
		jQuery('#listItem_'+ nextCell).hide().fadeIn();
		nextCell ++ ;
	});

	jQuery("#add-ads").click(function() {
		jQuery('#cat_sortable').append('\
			<li id="listItem_'+ nextCell +'" class="ui-state-default">\
				<div class="widget-head"><img src="'+ templatePath +'/framework/admin/images/code-small.png" />'+ kavkazLang.bulider_text_html +'<a style="display:none" class="toggle-open">+</a><a style="display:block" class="toggle-close">-</a></div>\
				<div class="widget-content" style="display:block">\
					<textarea name="kavkaz_home_cats['+ nextCell +'][text]" id="kavkaz_home_cats['+ nextCell +'][text]"></textarea>\
					<small>'+ kavkazLang.bulider_supports +'</small>\
					<input id="kavkaz_home_cats['+ nextCell +'][boxid]" name="kavkaz_home_cats['+ nextCell +'][boxid]" value="ads_'+ 1 + Math.floor(Math.random() * 1500)+'" type="hidden" />\
					<input id="kavkaz_home_cats['+ nextCell +'][type]" name="kavkaz_home_cats['+ nextCell +'][type]" value="ads" type="hidden" />\
					<a class="del-cat"></a>\
				</div>\
			</li>');
		jQuery('#listItem_'+ nextCell).hide().fadeIn();
		nextCell ++ ;
	});

/*---------------------------------------------------------------------- END OF THE BUILDER */



// Toggle open/Close
	jQuery(document).on("click", ".toggle-open" , function(){
		jQuery(this).parent().parent().find(".widget-content").slideToggle(300);
		jQuery(this).hide();
		jQuery(this).parent().find(".toggle-close").show();
		});

	jQuery(document).on("click", ".toggle-close" , function(){
		jQuery(this).parent().parent().find(".widget-content").slideToggle("fast");
		jQuery(this).hide();
		jQuery(this).parent().find(".toggle-open").show();
		});

// Expand/collapse all
	jQuery(document).on("click", "#expand-all" , function(){
		jQuery("#cat_sortable .widget-content").slideDown(300);
		jQuery("#cat_sortable .toggle-close").show();
		jQuery("#cat_sortable .toggle-open").hide();
		});
	jQuery(document).on("click", "#collapse-all" , function(){
		jQuery("#cat_sortable .widget-content").slideUp(300);
		jQuery("#cat_sortable .toggle-close").hide();
		jQuery("#cat_sortable .toggle-open").show();
		});

// Del Cats
	jQuery(document).on("click", ".del-cat" , function(){
		jQuery(this).parent().parent().addClass('removered').fadeOut(function() {
			jQuery(this).remove();
		});
	});

// Delete Sidebars Icon
	jQuery(document).on("click", ".del-sidebar" , function(){
		var option = jQuery(this).parent().find('input').val();
		jQuery(this).parent().parent().addClass('removered').fadeOut(function() {
			jQuery(this).remove();
			jQuery('#custom-sidebars select').find('option[value="'+option+'"]').remove();

		});
	});

// Delete Custom Text Icon
	jQuery(document).on("click", ".del-custom-text" , function(){
		var option = jQuery(this).parent().find('input').val();
		jQuery(this).parent().parent().addClass('removered').fadeOut(function() {
			jQuery(this).remove();
		});
	});

// Sidebar Builder
	jQuery("#sidebarAdd").click(function() {
		var SidebarName = jQuery('#sidebarName').val();
		if( SidebarName.length > 0){
			jQuery('#sidebarsList').append('<li><div class="widget-head">'+SidebarName+' <input id="kavkaz_sidebars" name="kavkaz_options[sidebars][]" type="hidden" value="'+SidebarName+'" /><a class="del-sidebar"></a></div></li>');
			jQuery('#custom-sidebars select').append('<option value="'+SidebarName+'">'+SidebarName+'</option>');
		}
		jQuery('#sidebarName').val('');

	});

// Custom Breaking News Text
	jQuery("#TextAdd").click(function() {
		var customlink = jQuery('#custom_link').val();
		var customtext = jQuery('#custom_text').val();
		if( customtext.length > 0 && customlink.length > 0  ){
			jQuery('#customList').append('<li><div class="widget-head"><a href="'+customlink+'" target="_blank">'+customtext+'</a> <input name="kavkaz_options[breaking_custom]['+customnext+'][link]" type="hidden" value="'+customlink+'" /> <input name="kavkaz_options[breaking_custom]['+customnext+'][text]" type="hidden" value="'+customtext+'" /><a class="del-custom-text"></a></div></li>');
		}
		customnext ++ ;
		jQuery('#custom_link , #custom_text').val('');

	});

// Background Type
	var bg_selected_radio = jQuery("input[name='kavkaz_options[background_type]']:checked").val();
	if (bg_selected_radio == 'custom') {	jQuery('#pattern-settings').hide();	}
	if (bg_selected_radio == 'pattern') {	jQuery('#bg_image_settings').hide();	}
	jQuery("input[name='kavkaz_options[background_type]']").change(function(){
		var bg_selected_radio = jQuery("input[name='kavkaz_options[background_type]']:checked").val();
		if (bg_selected_radio == 'pattern') {
			jQuery('#pattern-settings').fadeIn();
			jQuery('#bg_image_settings').hide();
		}else{
			jQuery('#bg_image_settings').fadeIn();
			jQuery('#pattern-settings').hide();
		}
	 });

// Panel Tabs
	jQuery(".tabs-wrap").hide();
	jQuery(".kavkaz-panel-tabs ul li:first").addClass("active").show();
	jQuery(".tabs-wrap:first").show();
	jQuery("li.kavkaz-tabs:not(.kavkaz-not-tab)").click(function() {
		jQuery(".kavkaz-panel-tabs ul li").removeClass("active");
		jQuery(this).addClass("active");
		jQuery(".tabs-wrap").hide();
		var activeTab = jQuery(this).find("a").attr("href");
		jQuery(activeTab).fadeIn('fast');
		return false;
	});


// Ctageories options
	jQuery(".kavkaz-cats-options input:checked").parent().addClass("selected");
	jQuery(document).on("click", ".kavkaz-cats-options .checkbox-select" , function(event){
		event.preventDefault();
		jQuery(this).parent().parent().find("li").removeClass("selected");
		jQuery(this).parent().addClass("selected");
		jQuery(this).parent().find(":radio").attr("checked","checked");

	});


// Ctageories Tabs box
	jQuery(".tabs_cats input:checked").parent().addClass("selected");
	jQuery(document).on("click", ".tabs_cats span" , function( event ){
		if( jQuery(this).parent().find(":checkbox").is(':checked') ){
			event.preventDefault();
			jQuery(this).parent().removeClass("selected");
			jQuery(this).parent().find(":checkbox").removeAttr("checked");
		}else{
			jQuery(this).parent().addClass("selected");
			jQuery(this).parent().find(":checkbox").attr("checked","checked");
		}
	});


	var allPanels = jQuery('.kavkaz-accordion > .kavkaz-accordion-contnet').hide();
	jQuery('.kavkaz-accordion > .accordion-head > a').click(function() {
		$this = jQuery(this);
		$target =  $this.parent().next();
		if(!$target.hasClass('active')){
			allPanels.removeClass('active').slideUp();
			$target.addClass('active').slideDown();
		}
		return false;
	});


	jQuery( 'ul.kavkaz-options:not(.kavkaz-cats-options)' ).each(function( index ) {
		var boxID = jQuery( this ).attr( 'id' );
		//alert( boxID );
		jQuery( '#' + boxID ).find( "input:checked" ).parent().addClass("selected");
		jQuery( '#' + boxID ).find( ".checkbox-select" ).click(
			function(event) {
				event.preventDefault();
				jQuery( '#' + boxID ).find( "li" ).removeClass("selected");
				jQuery(this).parent().addClass("selected");
				jQuery(this).parent().find(":radio").attr("checked","checked");
			}
		);
	});

	/*
	//Yoast Seo Pluign
	if( jQuery( '#yoast_wpseo_metadesc').length && jQuery( '#content' ).length && jQuery('#kavkaz_builder_active').length ){
		jQuery("#yoast_wpseo_metadesc").keyup(function(){
			if( jQuery( '#kavkaz_builder_active' ).val() == 'yes' ){
				var contentVal 	= jQuery(this).val();
				if( contentVal.length ){
					contentVal		= '[kavkaz_yost_content] '+contentVal+' [/kavkaz_yost_content]';
				}
				$geTheEditor	= jQuery( '#content' );

				var geTheEditorContent 	= $geTheEditor.val().replace( /\[kavkaz_yost_content\]([\s\S]*?)\[\/kavkaz_yost_content\]/g, '');
				$geTheEditor.val( geTheEditorContent + contentVal );
			}
		});
	}
	*/


});


// image Uploader Functions
	function kavkaz_set_uploader(field, styling ) {
		var kavkaz_bg_uploader;
		jQuery(document).on("click", "#upload_"+field+"_button" , function( event ){
			event.preventDefault();
			kavkaz_bg_uploader = wp.media.frames.kavkaz_bg_uploader = wp.media({
				title: 'Choose Image',
				library: {type: 'image'},
				button: {text: 'Select'},
				multiple: false
			});

			kavkaz_bg_uploader.on( 'select', function() {
				var selection = kavkaz_bg_uploader.state().get('selection');
				selection.map( function( attachment ) {
					attachment = attachment.toJSON();

					if( styling )
						jQuery('#'+field+'-img').val(attachment.url);
					else
						jQuery('#'+field).val(attachment.url);

					jQuery('#'+field+'-preview').show();
					jQuery('#'+field+'-preview img').attr("src", attachment.url );
				});
			});
			kavkaz_bg_uploader.open();
		});
	}


function toggleVisibility(id) {
	var e = document.getElementById(id);
		if(e.style.display == 'block')
					e.style.display = 'none';
			 else
					e.style.display = 'block';
}

// SEO Preview
jQuery(document).ready(function () {
	
	jQuery("#seo_home_title").bind("input", function () {
		jQuery(".kavkaz_seotitle").text(jQuery(this).val());
	});

	jQuery("#seo_home_description").bind("input", function () {
		jQuery(".kavkaz_seodescription").text(jQuery(this).val());
	});
	
 	jQuery("#seo_home_title").on('keyup paste', function(){
        var Characters = jQuery("#seo_home_title").val().replace(/(<([^>]+)>)/ig,"").length;
        jQuery("#kavkaz_seotitle_num").text("Characters left: " + (Characters));
    });	
	
 	jQuery("#seo_home_description").on('keyup paste', function(){
        var Characters = jQuery("#seo_home_description").val().replace(/(<([^>]+)>)/ig,"").length;
        jQuery("#kavkaz_seodescription_num").text("Characters left: " + (Characters));
    });		

	jQuery("#kavkaz_seotitle").bind("input", function () {
		jQuery(".kavkaz_seotitle").text(jQuery(this).val());
	});

	jQuery("#kavkaz_seodescription").bind("input", function () {
		jQuery(".kavkaz_seodescription").text(jQuery(this).val());
	});
	
 	jQuery("#kavkaz_seotitle").on('keyup paste', function(){
        var Characters = jQuery("#kavkaz_seotitle").val().replace(/(<([^>]+)>)/ig,"").length;
        jQuery("#kavkaz_seotitle_num").text("Characters left: " + (Characters));
    });	
	
 	jQuery("#kavkaz_seodescription").on('keyup paste', function(){
        var Characters = jQuery("#kavkaz_seodescription").val().replace(/(<([^>]+)>)/ig,"").length;
        jQuery("#kavkaz_seodescription_num").text("Characters left: " + (Characters));
    });	

});

// CheckBox
(function($){var i=function(e){if(!e)var e=window.event;e.cancelBubble=true;if(e.stopPropagation)e.stopPropagation()};$.fn.checkbox=function(f){try{document.execCommand('BackgroundImageCache',false,true)}catch(e){}var g={cls:'jquery-checkbox',empty:'empty.png'};g=$.extend(g,f||{});var h=function(a){var b=a.checked;var c=a.disabled;var d=$(a);if(a.stateInterval)clearInterval(a.stateInterval);a.stateInterval=setInterval(function(){if(a.disabled!=c)d.trigger((c=!!a.disabled)?'disable':'enable');if(a.checked!=b)d.trigger((b=!!a.checked)?'check':'uncheck')},10);return d};return this.each(function(){var a=this;var b=h(a);if(a.wrapper)a.wrapper.remove();a.wrapper=$('<span class="'+g.cls+'"><span class="mark"><img src="'+g.empty+'" /></span></span>');a.wrapperInner=a.wrapper.children('span:eq(0)');a.wrapper.hover(function(e){a.wrapperInner.addClass(g.cls+'-hover');i(e)},function(e){a.wrapperInner.removeClass(g.cls+'-hover');i(e)});b.css({position:'absolute',zIndex:-1,visibility:'hidden'}).after(a.wrapper);var c=false;if(b.attr('id')){c=$('label[for='+b.attr('id')+']');if(!c.length)c=false}if(!c){c=b.closest?b.closest('label'):b.parents('label:eq(0)');if(!c.length)c=false}if(c){c.hover(function(e){a.wrapper.trigger('mouseover',[e])},function(e){a.wrapper.trigger('mouseout',[e])});c.click(function(e){b.trigger('click',[e]);i(e);return false})}a.wrapper.click(function(e){b.trigger('click',[e]);i(e);return false});b.click(function(e){i(e)});b.bind('disable',function(){a.wrapperInner.addClass(g.cls+'-disabled')}).bind('enable',function(){a.wrapperInner.removeClass(g.cls+'-disabled')});b.bind('check',function(){a.wrapper.addClass(g.cls+'-checked')}).bind('uncheck',function(){a.wrapper.removeClass(g.cls+'-checked')});$('img',a.wrapper).bind('dragstart',function(){return false}).bind('mousedown',function(){return false});if(window.getSelection)a.wrapper.css('MozUserSelect','none');if(a.checked)a.wrapper.addClass(g.cls+'-checked');if(a.disabled)a.wrapperInner.addClass(g.cls+'-disabled')})}})(jQuery);

// WooCommerce Metabox
jQuery(function($){
    $('body').on('click', '.kavkaz_upload_image_button', function(e){
        e.preventDefault();

            var button = $(this),
                custom_uploader = wp.media({
            title: 'Insert image',
            library : {
                // uncomment the next line if you want to attach image to the current post
                // uploadedTo : wp.media.view.settings.post.id, 
                type : 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false // for multiple image selection set to true
        }).on('select', function() { // it also has "open" and "close" events 
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
            /* if you sen multiple to true, here is some code for getting the image IDs
            var attachments = frame.state().get('selection'),
                attachment_ids = new Array(),
                i = 0;
            attachments.each(function(attachment) {
                attachment_ids[i] = attachment['id'];
                console.log( attachment );
                i++;
            });
            */
        })
        .open();
    });

    /*
     * Remove image event
     */
    $('body').on('click', '.kavkaz_remove_image_button', function(){
        $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
        return false;
    });

});

// Add Faq item
jQuery(document).ready(function($) {
    $('#add-row').on('click', function() {
        var row = $('.empty-row.screen-reader-text').clone(true);
        row.removeClass('empty-row screen-reader-text');
        row.insertBefore('#download-urlet-one tbody>tr:last');
        return false;
    });

    $('.remove-row').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
});