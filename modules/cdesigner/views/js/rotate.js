/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/


(function(c,d){c.widget("ui.rotatable",c.ui.mouse,{widgetEventPrefix:"rotate",options:{handle:!1,angle:!1,wheelRotate:!0,snap:!1,step:22.5,handleOffset:{top:0,left:0},rotationCenterX:!1,rotationCenterY:!1,start:null,rotate:null,stop:null},rotationCenterX:function(a){if(a===d)return this.options.rotationCenterX;this.options.rotationCenterX=a},rotationCenterY:function(a){if(a===d)return this.options.rotationCenterY;this.options.rotationCenterY=a},handle:function(a){if(a===d)return this.options.handle;
this.options.handle=a},angle:function(a){if(a===d)return this.options.angle;this.elementCurrentAngle=this.options.angle=a;this.performRotation(this.options.angle)},_create:function(){var a;this.options.handle?a=this.options.handle:(a=c(document.createElement("div")),a.addClass("ui-rotatable-handle"));this.listeners={rotateElement:c.proxy(this.rotateElement,this),startRotate:c.proxy(this.startRotate,this),stopRotate:c.proxy(this.stopRotate,this),wheelRotate:c.proxy(this.wheelRotate,this)};this.options.wheelRotate&&
this.element.bind("wheel",this.listeners.wheelRotate);a.draggable({helper:"clone",start:this.dragStart,handle:a});a.bind("mousedown",this.listeners.startRotate);a.closest(this.element).length||a.appendTo(this.element);0!=this.options.angle?(this.elementCurrentAngle=this.options.angle,this.performRotation(this.elementCurrentAngle)):this.elementCurrentAngle=0},_destroy:function(){this.element.removeClass("ui-rotatable");this.element.find(".ui-rotatable-handle").remove();this.options.wheelRotate&&this.element.unbind("wheel",
this.listeners.wheelRotate)},performRotation:function(a){this.element.css("transform-origin",this.options.rotationCenterX+"% "+this.options.rotationCenterY+"%");this.element.css("-ms-transform-origin",this.options.rotationCenterX+"% "+this.options.rotationCenterY+"%");this.element.css("-webkit-transform-origin",this.options.rotationCenterX+"% "+this.options.rotationCenterY+"%");this.element.css("transform","rotate("+a+"rad)");this.element.css("-moz-transform","rotate("+a+"rad)");this.element.css("-webkit-transform",
"rotate("+a+"rad)");this.element.css("-o-transform","rotate("+a+"rad)")},getElementOffset:function(){this.performRotation(0);var a=this.element.offset();this.performRotation(this.elementCurrentAngle);return a},getElementCenter:function(){var a=this.getElementOffset();if(!1===this.options.rotationCenterX)var b=a.left+this.element.width()/2,a=a.top+this.element.height()/2;else b=a.left+this.element.width()/100*this.options.rotationCenterX,a=a.top+this.element.height()/100*this.options.rotationCenterY;
return[b,a]},dragStart:function(a){if(this.element)return!1},startRotate:function(a){var b=this.getElementCenter();this.mouseStartAngle=Math.atan2(a.pageY-this.options.handleOffset.top-b[1],a.pageX-this.options.handleOffset.left-b[0]);this.elementStartAngle=this.elementCurrentAngle;this.hasRotated=!1;this._propagate("start",a);c(document).bind("mousemove",this.listeners.rotateElement);c(document).bind("mouseup",this.listeners.stopRotate);return!1},rotateElement:function(a){if(!this.element||this.element.disabled)return!1;
var b=this.getRotateAngle(a),c=this.elementCurrentAngle;this.elementCurrentAngle=b;this._propagate("rotate",a);if(!1===this._propagate("rotate",a))return this.elementCurrentAngle=c,!1;var d=this.ui();if(!1===this._trigger("rotate",a,d))return this.elementCurrentAngle=c,!1;d.angle.current!=b&&(this.elementCurrentAngle=b=d.angle.current);this.performRotation(b);c!=b&&(this.hasRotated=!0);return!1},stopRotate:function(a){if(this.element&&!this.element.disabled)return c(document).unbind("mousemove",this.listeners.rotateElement),
c(document).unbind("mouseup",this.listeners.stopRotate),this.elementStopAngle=this.elementCurrentAngle,this._propagate("stop",a),setTimeout(function(){this.element=!1},10),!1},getRotateAngle:function(a){var b=this.getElementCenter(),b=Math.atan2(a.pageY-this.options.handleOffset.top-b[1],a.pageX-this.options.handleOffset.left-b[0])-this.mouseStartAngle+this.elementStartAngle;if(this.options.snap||a.shiftKey)b=this._calculateSnap(b);return b},wheelRotate:function(a){var b=Math.round(a.originalEvent.deltaY/
10)*Math.PI/180;if(this.options.snap||a.shiftKey)b=this._calculateSnap(b);b=this.elementCurrentAngle+b;this.angle(b);this._trigger("rotate",a,this.ui())},_calculateSnap:function(a){a=a/Math.PI*180;a=Math.round(a/this.options.step)*this.options.step;return a*Math.PI/180},_propagate:function(a,b){c.ui.plugin.call(this,a,[b,this.ui()]);"rotate"!==a&&this._trigger(a,b,this.ui())},plugins:{},ui:function(){return{api:this,element:this.element,angle:{start:this.elementStartAngle,current:this.elementCurrentAngle,
stop:this.elementStopAngle}}}})})(jQuery);