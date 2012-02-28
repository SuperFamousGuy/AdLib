/*======================================================================*\
|| #################################################################### ||
|| # Copyright �2006-2009 Youjoomla LLC. All Rights Reserved.           ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http:www.youjoomla.com | http:www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
var SmoothDropLine = new Class({
	Implements: [Options],
	
	options: {
		container:null,
		smoothFx:null,
		contpoz: false,
		horizLeftOffset: 10, // submenus, left offset
		horizRightOffset: -10, // submenus opening into the opposite direction
		horizTopOffset: 20, // submenus, top offset
		verticalTopOffset: 30, // main menus top offset
		verticalLeftOffset: 10, // main menus, left offset
		maxOutside: 50 // maximum pixels a panel can go outside the window and get pushed back
	},
	
	initialize: function(options) {
		this.setOptions(options);		
		if( !this.options.container ) return;
		this.container = $type(this.options.container) == 'element' ? this.options.container : $(this.options.container);
		// debug container
		this.debug = new Element('div').injectInside($(document.body)).setStyles({
			'position':'absolute', 
			'display':'block', 
			'top':0, 
			'left':0, 
			'width':400, 
			'font-size':11, 
			'text-align':'left', 
			'pading-left':10
		}).set({'id':'debug'});
		
		this.start();	
	},
	
	start: function(){
		
		this.injectIn = document.body;
		this.dir = $(document.body).getStyle('direction');
		this.isIe7 = this.options.contpoz;
		if( this.dir!=='rtl' ) this.isIe7 = false;
		
		/* get first level of parents */
		var list = this.container.getElement('ul.subul_main');	
		
		//this.container.removeClass('horiz_rtl');
		$('horiznav').removeClass('horiz_rtl');
		
		/* store menu tree */
		this.menuTree = new Hash();
		/* used to give unique id to each li.haschild element */
		this.parentCount = 0;
		/* stores all elements for later injection */
		this.toInject = new Array();
		/* go into the lists and get all li.haschild and ul's assigned to each one */
		this.parseLists( list, 0, false );
		// parseLists injects all neccessary HTML but not list from menu in order to be able to retrieve the correct size for it. Time to inject the elements
		this.toInject.each( function(data){
			data.list.injectTop( data.inner );
		})
				
		this.parent = null;
		this.element = null;
		this.pathOver = null;
		this.pathOut = null;
		this.topParent = null;
		
		this.menuTree.each( function( elements, key ){			
			var level = key;
			
			elements.each(function(info, i){
				if( info.trigger.hasClass('active') ){
					info.trigger.addClass('is_active')
				}
				if( info.topParent.hasClass('active') ){
					info.topParent.addClass('is_active')
				}
				
				info.trigger.addEvent('mouseenter', function(event){
					this.getPath(key);
					this.pathOver = this.path.join('|');
					
					if( this.parent == key && i!==this.element ){
						var t = this.menuTree.get( key );
						t.each(function(m, k){
							if( k!==i ){
								m.fx.slideOut();
							}
						})
					}
					
					info.topParent.setStyles({
						'position':'static'
					}).addClass('active');					
					info.topList.setStyles({
						'z-index':100,
						'left':0,
						'margin':0,
						'height':37,
						'left':0
					})
					
					this.topParent = info.topParent;
					this.parent = key;
					this.element = i;					
					this.showMenu( info );
					
				}.bind(this))
				
				// mouseover UL
				info.list.addEvent('mouseenter', function(event){
					this.getPath(key);
					this.pathOver = this.path.join('|');
					this.topParent = info.topParent;
					this.parent = key;
					this.element = i;					
				}.bind(this))
				
				// mouse out LI
				info.trigger.addEvent('mouseleave', function(){
					this.getPath(key);
					var liOutPath = this.pathOut = this.path.join('|');
					this.element = false;
					
					var f = function(){
						
						// if path is the same, do element index check to see if user navigates in same parent element
						if( this.pathOver == liOutPath ){							
							var m = this.menuTree.get( this.parent );
							m.each( function(e, k){
								if( k !== this.element ){
									m[k].fx.slideOut();
									if( !m[k].trigger.hasClass('is_active') )
										m[k].trigger.removeClass('active');
								}
							}.bind(this))								
														
						}else{
							
							var pathIn = this.pathOver.split('|');
							var pathOut = liOutPath.split('|');
							
							pathOut.each( function(k, i){
								if( !pathIn.contains( k ) ){
									var m = this.menuTree.get( k );
									m.each( function(e, x){
										m[x].fx.slideOut();	
										if( !m[x].trigger.hasClass('is_active') )
											m[x].trigger.removeClass('active');
									}.bind(this))
								}								
							}.bind(this));							
						}	
						
						if( this.topParent !== info.topParent ){						
							info.topParent.removeProperty('style');
							if( !info.topParent.hasClass('is_active') ){
								info.topParent.removeClass('active');
							}
							info.topList.removeProperty('style');	
						}
					}					
					f.delay(200, this);
					
				}.bind(this))			
				
				// mouseout UL
				
				info.list.addEvent('mouseleave', function(){
					this.getPath(key);
					var ulOutPath = this.pathOut = this.path.join('|');					
					
					var f = function(){
						// if path is the same, do element index check to see if user navigates in same parent element
						if( this.pathOver == ulOutPath ){
							
							var m = this.menuTree.get( this.parent );
							m.each( function(e, k){
								if( k !== this.element ){
									m[k].fx.slideOut();
									if( !m[k].trigger.hasClass('is_active') )
										m[k].trigger.removeClass('active');
								}
							}.bind(this))				
						}else{
							var pathIn = this.pathOver.split('|');
							var pathOut = ulOutPath.split('|');
							
							pathOut.each( function(k, i){
								if( !pathIn.contains( k ) ){
									var m = this.menuTree.get( k );
									m.each( function(e, x){
										m[x].fx.slideOut();	
										if( !m[x].trigger.hasClass('is_active') )
											m[x].trigger.removeClass('active');
									}.bind(this))
								}								
							}.bind(this));
						}
						
						if( this.topParent !== info.topParent ){						
							info.topParent.removeProperty('style');	
							if( !info.topParent.hasClass('is_active') ){
								info.topParent.removeClass('active');
							}
							info.topList.removeProperty('style');	
						}	
						
					}					
					f.delay(200, this);					
					
				}.bind(this))
				
				// stop body mouseover event when mouse is over li or ul's in menu 
				info.trigger.addEvent('mouseover', this.stopDefault);
				info.list.addEvent('mouseover', this.stopDefault);		
				info.positioner.addEvent('mouseover', this.stopDefault);
				// stop mouse wheel on lists when ie7 because of position fixed on elements
				if( this.isIe7 )
					info.list.addEvent('mousewheel', this.stopDefault);
				
			}.bind(this))			
		}.bind(this))
		
		// hide all menus on body mouseover
		//*
		this.injectIn.addEvent('mouseover', function(event){														
			this.menuTree.each( function( elements, key ){
				elements.each( function(c){
					c.fx.slideOut();
					if( this.topParent ){
						this.topParent.removeProperty('style');	
						if( !this.topParent.hasClass('is_active') ){
							this.topParent.removeClass('active');
						}
						this.topParent.getElement('ul.dropline').removeProperty('style');
						this.resetAllContainers();
						this.topParent = null;
					}
					if( !c.trigger.hasClass('is_active') )
						c.trigger.removeClass('active');
					
				}.bind(this))
			}.bind(this))
		}.bind(this))
		
		list.addEvent('mouseover', function(event){	
			this.element = null;
		}.bind(this))
		
		//*/
	},
	
	resetAllContainers: function(){
		var mainList = $('horiznav').getElement('.menunavd');
		var firstRow = mainList.getChildren();
		
		firstRow.each( function(el, i){
			if( !el.hasClass('haschild') ) return;						
			var list = el.getElement('ul.dropline');
			list.setStyles({
				'z-index':'',
				'left':'',
				'margin':'',
				'height':''
			});			
		}.bind(this))
	},
	stopDefault: function( event ){
		new Event(event).stop();
		return false;
	},
	
	showMenu: function( nodeInfo ){		
		var d = this.dir == 'rtl' ? this.showRtl(nodeInfo) : this.showLtr(nodeInfo);
		
		nodeInfo.positioner.setStyles({'top':d.top, 'left':d.left, 'z-index':2000});
		nodeInfo.trigger.addClass('active');
		nodeInfo.fx.slideIn( d.toLeft );		
	},
	
	showLtr: function(info){
		
		var c = info.trigger.getCoordinates();					
		var top = info.level == 0 ? c.top + this.options.verticalTopOffset.toInt() : c.top - this.options.horizTopOffset.toInt();
		var left = info.level == 0 ? c.left - this.options.verticalLeftOffset.toInt() : c.left + c.width - this.options.horizLeftOffset.toInt();
		
		// get window size
		var winSize = window.getSize();
		// get list width
		var listWidth = info.size.x + 20;
		var toLeft = false;
		
		var outside = (left + listWidth) - winSize.x;
		
		if( outside > this.options.maxOutside ){
			var extra = winSize.x - (left + listWidth) ;
			left = info.level == 0 ? c.left - this.options.verticalLeftOffset.toInt() + extra : 
				   c.left - this.options.horizRightOffset.toInt();
			toLeft = info.level == 0 ? false : true;	   
		}else if( outside > 0 ){
			left -= outside;
		}		
		return {'top':top, 'left':left, 'toLeft':toLeft};	
	},
	
	showRtl: function(info){
		
		var c = info.trigger.getCoordinates();		
		var top = info.level == 0 ? c.top + this.options.verticalTopOffset.toInt() : c.top - this.options.horizTopOffset.toInt();
		var left = info.level == 0 ? c.left - ( info.size.x - c.width ) - this.options.verticalLeftOffset.toInt() : c.left - this.options.horizRightOffset.toInt();
		
		// set default to open to left		
		var toLeft = info.level == 0 ? false : true;
		// check level for positioning
		if( info.level == 0 ){
			// level 0, simple check, if left is outside window(negative), set it to 0
			if( left < 0 ) left = 0;			
		}else{
			// subsequent levels
			if( left - info.size.x < 0 ){	
				left =  c.left + c.width - this.options.horizLeftOffset.toInt();
				toLeft = false;	   
			}
		}		
		return {'top':top, 'left':left, 'toLeft':toLeft};		
	},
	
	/* starting with any key, returns the complete path to the root */
	getPath: function( key, path ){
		
		if( !path ){
			this.path = new Array();
			this.path.include(key);
		}else{
			this.path = path;
		}
		
		this.menuTree.each( function(items, k){
			
			items.each( function(data, i){
				if( data.id == key ){
					this.path.include( k );
					this.getPath( k, this.path );
					return;
				}
			}.bind(this))			
		}.bind(this))		
	},
	
	parseLists: function( li, level, parent, prev_parent ){
		
		var mainParents = li.getChildren();
		mainParents.each( function(el, i){
			// only elements with class haschild have submenus
			if( !el.hasClass('haschild') ) return;
			
			// set unique id and add level class to li.haschild element
			var id = 'level'+level+'-'+this.parentCount;
			el.set({'rel': 'level-'+level});
			var list = el.getElement('ul.subul_main');
			
			// get list parent and check if it is group holder
			var p = list.getParent().getParent();			
			// if menu is group holder it gets to keep his children
			if( p.hasClass('group_holder') ){
				this.parseLists( list, level+1, id, prev_parent );
				return;
			}
			else{
				// menuWrap returns an object containing the div that positions the submenu and the fx instance
				var listDetails = this.menuWrap( list, level );
			}
			
			// construct the menu tree
			var key = prev_parent || parent||'root';
			if( !this.menuTree.hasKey( key ) ){
				this.menuTree.set( key, new Array() );
			}	
			
			var topList = this.container.getElement('ul.dropline');
			
			this.menuTree.get(key).include({
				'list' : list,						   
				'trigger' : el,
				'fx' : listDetails.fx,
				'positioner' : listDetails.positioner,
				'size':listDetails.size,
				'level' : level,
				'id' : id,
				'topParent':this.container,
				'topList':topList
			});
			
			// if menu is group holder, the next level list is part of this menu so pass the id to the script to make it descent from group holder
			var prev_p = list.hasClass('group_holder') ? id : null;			
			// this variable is used to generate unique ids
			this.parentCount++;
			// search the next level
			this.parseLists( list, level+1, id, prev_p );			
			
		}.bind(this))	
	},
	
	menuWrap: function( list, level ){
		
		var listSize = list.getSize();	
		
		// create markup for list
		var topParent = new Element('div').setStyles({
			'position': this.isIe7 ? 'fixed' : 'absolute', 
			'left':0,
			'top':-3000, 
			'display':'block', 
			'z-index':1000, 
			'font-size':YJSG_topmenu_font,
			'height':1,
			'width':'auto',
			'padding':0,
			'margin':0
		}).addClass('top_menu YJSG_listContainer');			
		
		var inner = new Element('div').set({
			'class':'YJSG-inner horiznav'
		}).setStyles({
			'width':listSize.x, 
			'height': level == 0 ? listSize.y + 20 : 'auto',
			'line-height':'normal',
			'padding':'13px 10px', // padding is added because of round corners positioned absolute that go outside the list by 13 pixels top-bottom and 10 pixels left-right
			'background':'none',
			'display':'block',
			'position':'relative'
		});	
		
		var clear = new Element('div').setStyles({
			'display':'block', 
			'clear':'both', 
			'position':'relative', 
			'width':'100%'
		}).set({
			'html':'<!--clear-->'
		});
		
		// keep list for later injection to be able to retrieve the correct size for it
		var elems = {'inner': inner, 'list': list};
		this.toInject.include( elems );
		// inject surrounding markup in body
		topParent.adopt(inner.adopt(clear)).injectInside( this.injectIn );
		
		// set fx on elements
		var slide_mode = level ? 'horizontal' : 'vertical';
		var fx = new YJFx(inner, {'duration': 250, 'mode': slide_mode, 'wait':false});
		fx.hide();
		return {'positioner':topParent, 'fx': fx, 'size':listSize};
	}
	
});

var YJFx = new Class({	
	Extends: Fx.Slide,
	initialize: function(el, options){
		this.parent(el, options);
		// for ie7, if content wrap doesn't have display and position, slide don't work
		this.wrapper.setStyles({'display':'block', 'position':'relative'});
		if( this.options.mode == 'horizontal' ){		
			this.wrapFx = new Fx.Morph( this.wrapper, {wait:this.options.wait, duration:this.options.duration});
			this.elemFx = new Fx.Morph( this.element,  {wait:this.options.wait, duration:this.options.duration});
		}
		this.leftSlide = false;
	},
	
	slideIn: function( leftSlide ){
		
		if( leftSlide ){			
			this.elemFx.set({'margin-left':0});
			this.wrapFx.start({'width':this.offset, 'margin-left':-this.offset});
			this.leftSlide = true;
			return;
		}		
		
		return this.start('in', this.options.mode);
	},

	slideOut: function(){
		
		if( this.leftSlide ){
			this.wrapFx.start({'width':0, 'margin-left':0});
			return;
		}
		
		return this.start('out', this.options.mode);
	}
})

window.addEvent('domready', function(){
	
	var mainList = $('horiznav').getElement('.menunavd');
	var firstRow = mainList.getChildren();
	var fx = new Fx.Morph('topmenu_holder', {wait:false, duration:350});
	$('topmenu_holder').setStyles({'overflow': 'hidden'});
	
	var s = $('topmenu_holder').getSize();
	var p = $('topmenu_holder').getStyle('padding-top').toInt() + $('topmenu_holder').getStyle('padding-bottom').toInt();	
	$(document.body).addEvent('mouseover', function(){
		fx.start({'height': s.y-p});
	})
	
	
	firstRow.each( function(el, i){
		if( !el.hasClass('haschild') ) return;
		
		var list = el.getElement('ul.dropline');		
		el.addEvent('mouseenter', function(event){
			
			firstRow.each(function(e, m){				
				if( !e.hasClass('haschild') ) return;
				if( i == m ) return;
				var l = e.getElement('ul.dropline');
				e.removeProperty('style');
				if( !e.hasClass('is_active') ) 
					e.removeClass('active');
				l.setStyles({
					'z-index':'',
					'left':'',
					'margin':'',
					'height':'',
					'border':''
				});			
			})	
			fx.start({'height':84});
		})
		
		el.addEvent('mouseover', function(event){
			new Event(event).stop();
			return false;
		})
		
		SmoothDroplineParams.container = el;
		SmoothDroplineParams.smoothFx = fx;
		
		var smoothDrop = new SmoothDropLine(
			SmoothDroplineParams
		);	
	})	
})