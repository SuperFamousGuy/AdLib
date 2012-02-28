/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: slimbox.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */
/*
 * ! Slimbox v1.57 - The ultimate lightweight Lightbox clone (c) 2007-2009
 * Christophe Beyls <http://www.digitalia.be> MIT-style license.
 */

var Slimbox = ( function() {

    
    var win = window, options, images, activeImage = -1, activeURL, prevImage, nextImage, compatibleOverlay, middle, centerWidth, centerHeight, eventKeyDown = keyDown
	    .bindWithEvent(), operaFix = window.opera && (navigator.appVersion >= "9.3"), documentElement = document.documentElement,

    
    preload = {}, preloadPrev = new Image(), preloadNext = new Image(),

    
    overlay, center, image, prevLink, nextLink, bottomContainer, bottom, caption, number,

    
    fxOverlay, fxResize, fxImage, fxBottom;

    
    var jw_timer;
    
    var jw_cat_id, jw_images_count;
    
    var previousURL, nextURL;

    /*
     * Initialization
     */

    win.addEvent("domready", function() {
	
	$(document.body).adopt($$(overlay = new Element("div", {
	    id : "lbOverlay"
	}), center = new Element("div", {
	    id : "lbCenter"
	}), bottomContainer = new Element("div", {
	    id : "lbBottomContainer"
	})).setStyle("display", "none"));

	image = new Element("div", {
	    id : "lbImage"
	}).injectInside(center).adopt(prevLink = new Element("a", {
	id : "lbPrevLink",
	href : "#"
	}), nextLink = new Element("a", {
	id : "lbNextLink",
	href : "#"
	}));
	prevLink.onclick = previous;
	
	prevLink.addEvent('click', function(e) {
	    new Event(e).stop();
	});
	nextLink.onclick = next;
	
	nextLink.addEvent('click', function(e) {
	    new Event(e).stop();
	});

	var closeLink;
	bottom = new Element("div", {
	    id : "lbBottom"
	}).injectInside(bottomContainer).adopt(closeLink = new Element("a", {
	id : "lbCloseLink",
	href : "#"
	}), caption = new Element("div", {
	    id : "lbCaption"
	}), number = new Element("div", {
	    id : "lbNumber"
	}), new Element("div", {
	    styles : {
		clear : "both"
	    }
	}));
	closeLink.onclick = overlay.onclick = close;
    });

    /*
     * Internal functions
     */

    function position() {
	var l = win.getScrollLeft(), w = operaFix ? documentElement.clientWidth : win
		.getWidth();
	$$(center, bottomContainer).setStyle("left", l + (w / 2));
	if (compatibleOverlay)
	    overlay.setStyles( {
	    left : l,
	    top : win.getScrollTop(),
	    width : w,
	    height : win.getHeight()
	    });
    }

    function setup(open) {
	[ "object", win.ie6 ? "select" : "embed" ].forEach( function(tag) {
	    $each(document.getElementsByTagName(tag), function(el) {
		if (open)
		    el._slimbox = el.style.visibility;
		el.style.visibility = open ? "hidden" : el._slimbox;
	    });
	});

	overlay.style.display = open ? "" : "none";

	var fn = open ? "addEvent" : "removeEvent";
	win[fn]("scroll", position)[fn]("resize", position);
	document[fn]("keydown", eventKeyDown);
    }

    function keyDown(event) {
	var code = event.code;
	if (options.closeKeys.contains(code))
	    close();
	else if (options.nextKeys.contains(code))
	    next();
	else if (options.previousKeys.contains(code))
	    previous();
	
	event.stop();
    }

    function previous() {
	
	jw_timer = $clear(jw_timer);
	
	return jwSlimboxGetImageFile(prevImage);
    }

    function next() {
	
	jw_timer = $clear(jw_timer);
	
	return jwSlimboxGetImageFile(nextImage);
    }

    
    function jwSlimboxGetImageFile(imageIndex) {

	var url = 'index.php?option=com_jwallpapers&task=ajaxGetImageUrl&cat_id=' + jw_cat_id + '&pos=' + imageIndex + '&pics_count=' + jwallpapers_pics_count;

	new Ajax(url, {
	method : 'get',
	onComplete : function(response, responseXML) {
	    
	    var root = responseXML.documentElement;
	    var jw_previous_image_file_node = root
		    .getElementsByTagName('previous_image_file').item(0);
	    var jw_active_image_file_node = root
		    .getElementsByTagName('active_image_file').item(0);
	    var jw_next_image_file_node = root
		    .getElementsByTagName('next_image_file').item(0);
	    
	    var jwprevious_image_file = jw_previous_image_file_node.firstChild.nodeValue;
	    var jw_active_image_file = jw_active_image_file_node.firstChild.nodeValue;
	    var jw_next_image_file = jw_next_image_file_node.firstChild.nodeValue;
	    
	    previousURL = jwprevious_image_file;
	    nextURL = jw_next_image_file;
	    
	    changeImage(imageIndex, jw_active_image_file);
	}
	}).request();
    }

    
    function changeImage(imageIndex, activeImageFile) {
	if (imageIndex >= 0) {
	    activeImage = imageIndex;
	    
	    activeURL = activeImageFile;
	    
	    prevImage = ((jw_images_count > 1 ? activeImage : 0) || (options.loop ? jw_images_count : 0)) - 1;
	    
	    nextImage = ((activeImage + 1) % jw_images_count) || (options.loop ? 0 : -1);

	    stop();
	    center.className = "lbLoading";

	    preload = new Image();
	    preload.onload = animateBox;
	    preload.src = activeURL;

	    
	    if (jw_images_count > 1 && jwallpapers_slideshow_period > 0) {
		jw_timer = next.delay(jwallpapers_slideshow_period * 1000);
	    }
	}

	return false;
    }

    function animateBox() {
	center.className = "";
	fxImage.set(0);
	image.setStyles( {
	width : preload.width,
	backgroundImage : "url(" + activeURL + ")",
	display : ""
	});
	$$(image, prevLink, nextLink).setStyle("height", preload.height);

	
	caption.setHTML("");
	
	
	number.setHTML((((jw_images_count > 1) && options.counterText) || "")
		.replace(/{x}/, activeImage + 1)
		.replace(/{y}/, jw_images_count));

	
	
	
	
	if (prevImage >= 0 && previousURL != "null")
	    preloadPrev.src = previousURL;
	
	if (nextImage >= 0 && nextURL != "null")
	    preloadNext.src = nextURL;

	centerWidth = image.offsetWidth;
	centerHeight = image.offsetHeight;
	var top = Math.max(0, middle - (centerHeight / 2));
	if (center.offsetHeight != centerHeight) {
	    fxResize.chain(fxResize.start.pass( {
	    height : centerHeight,
	    top : top
	    }, fxResize));
	}
	if (center.offsetWidth != centerWidth) {
	    fxResize.chain(fxResize.start.pass( {
	    width : centerWidth,
	    marginLeft : -centerWidth / 2
	    }, fxResize));
	}
	fxResize.chain( function() {
	    bottomContainer.setStyles( {
	    width : centerWidth,
	    top : top + centerHeight,
	    marginLeft : -centerWidth / 2,
	    visibility : "hidden",
	    display : ""
	    });
	    fxImage.start(1);
	});
	fxResize.callChain();
    }

    function animateCaption() {
	if (prevImage >= 0)
	    prevLink.style.display = "";
	if (nextImage >= 0)
	    nextLink.style.display = "";
	fxBottom.set(-bottom.offsetHeight).start(0);
	bottomContainer.style.visibility = "";
    }

    function stop() {
	preload.onload = Class.empty;
	preload.src = preloadPrev.src = preloadNext.src = activeURL;
	fxResize.clearChain();
	fxResize.stop();
	fxImage.stop();
	fxBottom.stop();
	$$(prevLink, nextLink, image, bottomContainer)
		.setStyle("display", "none");
    }

    function close() {
	if (activeImage >= 0) {
	    stop();
	    
	    
	    jw_timer = $clear(jw_timer);
	    
	    var jw_active_image = activeImage;
	    
	    activeImage = prevImage = nextImage = -1;
	    center.style.display = "none";
	    fxOverlay.stop().chain(setup).start(0);
	    
	    
	    if (jwallpapers_pic_pos - 1 != jw_active_image) {
		jwSlimboxSetActiveImage(jw_active_image);
	    }
	    
	}

	return false;
    }

    /*
    	API
     */

    Element.extend( {
	slimbox : function(_options, linkMapper) {
	    
	    $$(this).slimbox(_options, linkMapper);

	    return this;
	}
    });

    Elements.extend( {
	/*
		options:	Optional options object, see Slimbox.open()
		linkMapper:	Optional function taking a link DOM element and an index as arguments and returning an array containing 2 elements:
				the image URL and the image caption (may contain HTML)
		linksFilter:	Optional function taking a link DOM element and an index as arguments and returning true if the element is part of
				the image collection that will be shown on click, false if not. "this" refers to the element that was clicked.
				This function must always return true when the DOM element argument is "this".
	 */
	slimbox : function(_options, linkMapper, linksFilter) {
	    linkMapper = linkMapper || function(el) {
		return [ el.href, el.title ];
	    };

	    linksFilter = linksFilter || function() {
		return true;
	    };

	    var links = this;

	    links.forEach( function(link) {
		link.removeEvents("click").addEvent("click", function(event) {
		    
		    var filteredLinks = links.filter(linksFilter, this);
		    Slimbox.open(filteredLinks.map(linkMapper), filteredLinks
			    .indexOf(this), _options);
		    event.stop();
		}.bindWithEvent(link));
	    });

	    return links;
	}
    });

    return {
	open : function(_images, startImage, _options) {
	    options = $extend( {
	    loop : true, 
	    overlayOpacity : 0.8, 
	    overlayFadeDuration : 400, 
	    resizeDuration : 400, 
	    resizeTransition : false, 
	    initialWidth : 250, 
	    initialHeight : 250, 
	    imageFadeDuration : 400, 
	    captionAnimationDuration : 400, 
	    counterText : "Image {x} of {y}", 
	    closeKeys : [ 27, 88, 67 ], 
	    previousKeys : [ 37, 80 ], 
	    nextKeys : [ 39, 78 ]
	    
	    }, _options || {});

	    
	    fxOverlay = overlay.effect("opacity", {
		duration : options.overlayFadeDuration
	    });
	    fxResize = center.effects($extend( {
		duration : options.resizeDuration
	    }, options.resizeTransition ? {
		transition : options.resizeTransition
	    } : {}));
	    fxImage = image.effect("opacity", {
	    duration : options.imageFadeDuration,
	    onComplete : animateCaption
	    });
	    fxBottom = bottom.effect("margin-top", {
		duration : options.captionAnimationDuration
	    });

	    
	    

	    
	    
	    jw_cat_id = _images[0];
	    jw_images_count = _images[1];

	    middle = win.getScrollTop() + ((operaFix ? documentElement.clientHeight : win
		    .getHeight()) / 2);
	    centerWidth = options.initialWidth;
	    centerHeight = options.initialHeight;
	    center.setStyles( {
	    top : Math.max(0, middle - (centerHeight / 2)),
	    width : centerWidth,
	    height : centerHeight,
	    marginLeft : -centerWidth / 2,
	    display : ""
	    });
	    compatibleOverlay = win.ie6 || (overlay.currentStyle && (overlay.currentStyle.position != "fixed"));
	    if (compatibleOverlay)
		overlay.style.position = "absolute";
	    fxOverlay.set(0).start(options.overlayOpacity);
	    position();
	    setup(1);

	    
	    
	    options.loop = options.loop && (jw_images_count > 1);

	    
	    return jwSlimboxGetImageFile(startImage);
	}
    };

})();