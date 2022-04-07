/**
 * Our Main entry point for Theme's frontend JS code.
 */

import jQuery from 'jquery';
import objectFit from './utils/object-fit'; // importing default exported element - free name specified here.
import { bodyJsClass } from './utils/js'; // imported named export.

// set JS classes on body.
bodyJsClass();

// call object fit images with dependency injected jQuery;
objectFit( jQuery );

// Slick slider
import 'slick-carousel';

// Announcement Bar
import announcement from './components/announcement-bar';
announcement( jQuery );

// Video block
import playVideo from './blocks/pf-common/video';
playVideo( jQuery );

// Audio Button
import audioBtn from './blocks/pf-common/audio-btn';
audioBtn( jQuery );

// Accordion block
import accordion from './blocks/pf-common/accordion';
accordion( jQuery );

// Gallery block - connecting Fancybox
import galleryFancybox from './blocks/pf-common/gallery-fancybox';
galleryFancybox( jQuery );

// Gallery block - connecting PF script
import { initGalleryBlocks } from './blocks/pf-common/gallery-block';
initGalleryBlocks();

// Tabs block
import tabs from './blocks/pf-common/tabs';
tabs( jQuery );

// Slider block
import slider from './blocks/pf-common/slider';
slider( jQuery );

// Scroll to Element
import { initScrollToElement, scrollToElement } from './blocks/pf-common/scroll-to-element';
initScrollToElement(); // initialize a.scroll-to hash links if necessary.

// page-nav
import pageNav from './blocks/pf-common/page-nav';
pageNav( jQuery );
