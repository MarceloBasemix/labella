/*!
 * Mazine Wordpress Theme Javascipt helper
 *
 * Copyright 2011
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://transparentideas.com
 * 
 */
 
 var themeURL = null;
 
 var setThemeURL = function(url){
 		  
 		  		themeURL = url+'/';	
 		  
 		  }
 
 var checkout_step = function(step, cont){
 
 	switch(step){
 	
 		case 2: $('#step-2').show(); $(cont).animate({marginLeft:'-940px'}, 1000, function(){ $('#step-1').hide(); $('html').scrollTop(); });  break;
 		case 1: $('#step-1').show(); $(cont).animate({marginLeft:'0px'}, 1000, function(){  $('#step-2').hide();  $('html').scrollTop(); }); break;
 	}
 
 } 
 
 function ThemeHelper(){
 
 	var mazineCart = new HeaderCart();
 	var categoriesSlider = new InifiniteSlider();
 	var viewSwitcher = new ListingViewSwitcher();
 	
 	var FancyBoxInit = function(selector){
 		
 		$(selector).each(function(){
 			$(this).css('position','relative');
 			$(this).append('<div id="plus" style="height:23px; width:23px; background:url('+themeURL+'images/img_mg.png) center center; position:absolute; top:1px; right:1px; "></div>');
 			$(this).removeAttr('rel');
 		});
 		
 		$(selector).fancybox({
				'opacity'		: true,
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'titlePosition'	: 'inside',
				'transitionOut'	: 'elastic',
				'overlayColor'	: '#23262B'
		});
 	};
 
 	var GalleryInit = function(selector){

		var init = function(){
			$(selector + ' .ic_container').capslide({
	            caption_color	: 'black',
	            caption_bgcolor	: 'white',
	            overlay_bgcolor : '#832EA5',
	            showcaption	    : false,
	            border : '2px solid #fff'
	        });
	
	         $(selector + ' .ic_container a').fancybox({
					'opacity'		: true,
					'overlayShow'	: true,
					'transitionIn'	: 'elastic',
					'titlePosition'	: 'inside',
					'transitionOut'	: 'elastic',
					'overlayColor'	: '#23262B',
					'showNavArrows' : true
			});
			
			$(selector + ' .ic_container').each(function(){
			
				$(this).find('.ic_caption').bind('click', function() {
	    	 		$(this).parent().find('a').trigger('click'); 
	    		})
			
			});
			
			
		}
		
		init();
		
		$(selector).css('min-height', $(selector).height());
		$(selector).css('display', 'block');
		
		var fullCollection = $(selector).clone();
		
		$('#filters').find('li a').each(function(){
			$(this).click(function(){
				if ($(this).attr('id') != 'none')
					var filteredCollection = fullCollection.find('li.' + $(this).attr('id'));
				else 
					var filteredCollection = fullCollection.find('li');
				
				$('#filters li a').removeClass('selected');
				$(this).addClass('selected');
					
				$(selector).quicksand(filteredCollection,{
					adjustHeight: 'dynamic',
					duration: 900,
				    easing: 'easeInOutQuad',
				    useScaling:true	
				
				},init);
					
			});
		});
		
    
 	}
 	 	
 	return{
 			
 		    googleMapsContacts:function(address, map_container){
 		  	
 		  		var geocoder;
				var map;
				var container = map_container;
				var addr = address;
				
				
					
					geocoder = new google.maps.Geocoder();
				    var latlng = new google.maps.LatLng(-34.397, 150.644);
				    var options = {
				      zoom: 15,
				      center: latlng,
				      mapTypeId: google.maps.MapTypeId.ROADMAP
				    }
				    map = new google.maps.Map(document.getElementById(container), options);
				    var address = addr;
				    geocoder.geocode( { 'address': address}, function(results, status) {
				      if (status == google.maps.GeocoderStatus.OK) {
				        map.setCenter(results[0].geometry.location);
				        var marker = new google.maps.Marker({
				            map: map, 
				            position: results[0].geometry.location
				        });
				      } else {
				        if(window.console){console.log("Geocode was not successful for the following reason: " + status);}
				      }
				    });
				 		  	
 		  	
 		  },
 		  
 		  
 		  	
 		   		  
 		  initAfterDocumentReady:function(){
    		
    		$(window).load(function(){
				
				$('body').css('visibility', 'visible'); 
				    		
    			try{
					ddsmoothmenu.init({
    					mainmenuid: "smoothmenu1", 
    					orientation: 'h', 
    					classname: 'ddsmoothmenu', 
    					contentsource: "markup" 
					});
					
					//$("#smoothmenu1 ul li:first").addClass("alpha");
					$("#smoothmenu1 ul li:last-child").addClass("omega");
					$(".list2 li:first").addClass("alpha");
					$(".list2 li:last-child").addClass("omega");
										
					$('#header_search_button').click(function(){
								if (($('#s').val() !='') && ($('#s').val() != 'enter search terms')){								
									$(this).parents('form').trigger('submit');
								}
						    });
										
				} catch(error){
					if (window.console) {
						console.log(error)
					}
				}
				
				try{
					
					$('.cat-item, .page_item').hover(function() {
						
					  $(this).find('>.children').not('.children .children').slideToggle('fast', function() {
					    // Animation complete.
					  });
					  
					  $('.children .children').show();
					  
					});
				
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					$('.ddsmoothmenu ul li ul li, footer ul.list li, .box ul li, footer .inner-box ul li').not('.children li').not($('.box ul li').has('.children')).not('.socialwrap li').not('.featured li').hover(function() {
            			$(this).animate({ paddingLeft: '7px' }, 250);
          			}, function() {
            			$(this).animate({ paddingLeft: '0px' }, 250);  
					});
					
					$('.box ul li').has('.children').css('background','url('+themeURL+'images/sub_m.png)  100% 7px no-repeat');
					
					
				} catch(error){
					if (window.console) { 
						console.log(error)
					}
				}
				
				try {
					mazineCart.init('#cart', '#cart_content', '#cart_bottom_contents', 75);
 				} catch(error){
					if (window.console) { 
						console.log(error)
					}				
				}
				
				try{
					categoriesSlider.init('.infiniteSlider', 6);
				} catch(error){
				
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					FancyBoxInit('.featured li a, .ngg-widget a');
				} catch(error) {
					if(window.console){
						console.log(error);
					}
				}
				
								
				try{
					GalleryInit('.images-gallery');	
				} catch(error) {
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					viewSwitcher.init('#products', '#view_switcher');
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					if ($('#coin-slider').length > 0){		
						$('#coin-slider').coinslider({width:940, height:360});
					 }	
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					$(document).ready(function() {
						$('.totop').click(function(){
							$('html, body').animate({scrollTop:0}, 'slow');
						});
					});
				}catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				
				
				try{
					$('.tooltipit, #content img').not('.images-gallery li img').not('.product-image img').not('.featured li img').tooltip({
						track: true,
						delay: 0,
						showURL: false,
						showBody: " - ",
						fade: 250
					});					
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					$('.tooltipit2').tooltip();					
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					$(function() {
							$( "#tabs" ).tabs({ fxFade: true, fxSpeed: 'fast' });
						});
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					$(function() {
							$( "#accordion" ).accordion();
						});
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
				
				try{
					$(function() {
							$(" div.image, div.wp-caption, #content img").not('.images-gallery li img').not('.product-image img').hover(function()
							{
								$(this).fadeTo(200, 0.8);
								
							}, function(){
								$(this).fadeTo(200, 1);
							});
						});
				} catch(error){
					if(window.console){
						console.log(error);
					}
				}
			
			});    
  		}
  	};
 }
 
 function ListingViewSwitcher(){
 	var state;
 	var productsContainer;
 	var theSwitch;
 	
 	(function ($) {
	    $.fn.AutoHeight = function () {
	    
	        var height = 0,
	            reset = $.browser.msie ? "1%" : "auto";
	        return this.css("height", reset).each(function () {
	            height = (Math.max(height, $(this).height()));
	        }).css("height", height).each(function () {
	            var h = $(this).height();
	            if (h > height) {
	                $(this).css("height", height - (h - height)+5);
	            }
	            
	            $(this).find('.action').css('position', 'absolute');
 			$(this).find('.action').css('bottom', '10px');
 			$(this).find('.action').css('margin-left', '');
	            
	        });
	    };
	})(jQuery);
 	
 	var SwitchView = function(){
 		productsContainer.fadeOut(400, function(){
 			if (state == 'grid') { 
 				state = 'list';
 				$(productsContainer).find('ul li').attr('style','');
 				productsContainer.removeClass('grid');
 				productsContainer.addClass('list');
 				if($.browser.msie) {$(productsContainer).find('ul li').css('height','auto');   }
 				theSwitch.removeClass('list_view');
 				$(productsContainer).find('ul li .action').css('position','relative');
 				$(productsContainer).find('ul li .action').css('bottom','');
 				$(productsContainer).find('ul li .action').css('margin-left','193px');
 				theSwitch.addClass('grid_view');
 				theSwitch.html('grid view');
 				productsContainer.fadeIn(400);
 			} else if (state == 'list') {
 				state = 'grid';
 				productsContainer.removeClass('list');
 				productsContainer.addClass('grid');
 				theSwitch.removeClass('grid_view');
 				theSwitch.addClass('list_view');
 				theSwitch.html('list view');
 				productsContainer.fadeIn(400);
 				$(productsContainer).find('ul li').AutoHeight();	
 			}
 		});
 	}
 	
 	return{
 		init:function(container, switcher){
 			
 			state = $(container).attr('class');
 				
 			productsContainer = $(container);
 			theSwitch = $(switcher);
 			$(switcher).bind('click', SwitchView);
 			if ($.browser.msie) $(productsContainer).css('filter','');
 			if (state != 'list') $(productsContainer).find('ul li').AutoHeight();
 			
 			$(productsContainer).removeClass('grid');
 			$(productsContainer).removeClass('list');
 			$(productsContainer).addClass(state);
 		}
 	}
 	
 }
 
 function HeaderCart(){
 
 	var closedHeight;
 	var isPlaying = false;
 	var isOpened = false
 	var mOver = false;
 	var curWidth;
 	var initOffset;
 	
 	return{
 		init:function(eventCatcher, animatedItem, fadeInOutItem){
 			 closedHeight = $(animatedItem).height();
 			 $(fadeInOutItem).hide();
 			 var mouseEnter = function(){
 			 	
 			 	$(eventCatcher).unbind('mouseenter');
 			 	$(eventCatcher).unbind('mouseleave');
 			 	
 			  	$(fadeInOutItem).fadeIn(900);
 			 	$(animatedItem).animate({
 			 		height:$(fadeInOutItem).height()+closedHeight+'px'
 			 	},700,'easeInOutQuad', function(){$(eventCatcher).mouseenter(mouseEnter);$(eventCatcher).mouseleave(mouseLeave);if(!mOver)mouseLeave();});
 			 
 			 }
 			 var mouseLeave = function(){
 		 		
 		 		$(eventCatcher).unbind('mouseenter');
 			 	$(eventCatcher).unbind('mouseleave');	
 			 	$(fadeInOutItem).fadeOut(600,function(){$(eventCatcher).mouseenter(mouseEnter);$(eventCatcher).mouseleave(mouseLeave); });
 			 	$(animatedItem).animate({
 			 		height:closedHeight+'px'
 			 	},700,'easeInOutQuad')
 			 
 			 }
 			 
 			 $(eventCatcher).mouseover(function(){mOver=true;})
 			 $(eventCatcher).mouseout(function(){mOver=false;})
 			 $(eventCatcher).mouseenter(mouseEnter);
 			 $(eventCatcher).mouseleave(mouseLeave);
     	 	  			 	 			 	
 			 
 			 //Position Fixed
 			/*  $(eventCatcher).css('left', $(eventCatcher).offset().left + 'px');
 			 $(eventCatcher).css('position','fixed');
 			 $(window).resize(function(){
 			  	
 			 $(eventCatcher).css('left', initOffset + 'px');
 			  	$(eventCatcher).css('left', $('#search_form').offset().left - 8  + 'px');
 			 });
 			 */
 			
 		}
 	}
 	
 }
 
 
 
 function InifiniteSlider(){

 	var items = new Array();
 	var views = new Array();
 	var i = 0;
 	var i_content = '';
 	var new_dom = '';
 	var cur_view = 0;
 	var view_width;
 	var slider;
 	
 	var NextIt = function(offset){
 		marge = cur_view + offset;
 		if (marge < 0) return views.length + marge;
 		else
 		if (marge > (views.length - 1)) return marge - views.length;
 		else 
 		return marge; 
 	}
 	
 	var Rebuild = function(){
 		$(slider + ' .wrapper').hide();
 		$('#ul_container').remove();
 		$(slider + ' .wrapper').prepend('<div id="ul_container" style="width:' + $(slider + ' .wrapper').width() * 3 + 'px; position:absolute; height:'+$(slider + ' ul li').height()+'px; top:0; left:-' + $(slider + ' .wrapper').width() + 'px "></div>');
 		$('#ul_container').prepend(views[NextIt(-1)]);
 		$('#ul_container').prepend(views[cur_view]);
 		$('#ul_container').prepend(views[NextIt(1)]);
 		$(slider + ' .wrapper').show();
 	}
 	
 	
 	return{
 		init:function(cont, viewableItems){
 			slider = cont;
 			$(slider).css('position', 'relative');
 			$(slider + ' .wrapper').css('overflow', 'hidden');
 			$(slider).prepend('<a id="left_but" style="position:absolute; top:52px; left:-26px; font-size:0px; cursor:pointer; width:21px; height:34px; background:url('+themeURL+'images/cat_slid_left.png) center center no-repeat; ">&laquo;</a><a id="right_but" style="position:absolute; top:52px; right:-26px; cursor:pointer; font-size:0px; width:21px; height:34px; background:url('+themeURL+'images/cat_slid_right.png) center center no-repeat">&raquo;</a>');
 			view_width = $(slider + ' .wrapper').width();
 			collection = $(slider + ' ul li');
 			$(slider + ' ul').remove();
 			collection.each(function(){
 				if (i == 0) iclass = ' class="alpha"'; else iclass = '';
 				i_content += '<li' + iclass + ' style="list-style:none;">' + $(this).html() + '</li>';
 				if (i == viewableItems-1) {items.push(i_content); i_content = ''; i = 0;}
 				else i++;	
 			});
 			
 			if (i_content != '') items.push(i_content);
 			
 			$.each(items,function(index, value){
 				views.push('<ul style="width:'+$(slider + ' .wrapper').width()+'px; display:block; float:left;">'+value+'</ul>');
 			})

 			Rebuild();
			
 			var RightClicker = function(){
 				$('#left_but').unbind('click');
 				$('#right_but').unbind('click');
 				$('#ul_container').animate({
 					left: $('#ul_container').position().left - $(slider + ' .wrapper').width() + 'px'
 				}, 1000, 'easeInOutQuad', function(){
 					if (--cur_view < 0) cur_view = views.length - 1;
 					Rebuild();
 					$('#left_but').bind('click', LeftClicker);
 					$('#right_but').bind('click', RightClicker);
 				});
 			}
 			
 			var LeftClicker = function(){
 				$('#left_but').unbind('click');
 				$('#right_but').unbind('click');
 				$('#ul_container').animate({
 					left: '0px'
 				}, 1000, 'easeInOutQuad', function(){
 					if (++cur_view > views.length - 1) cur_view = 0;
 					Rebuild();
 					$('#left_but').bind('click', LeftClicker);
 					$('#right_but').bind('click', RightClicker);
 				});
 			}
 			$('#left_but').click(LeftClicker);
 			$('#right_but').click(RightClicker);
 		}
	 }
 }
 
var mazineTheme = new ThemeHelper();
mazineTheme.initAfterDocumentReady(); 	
