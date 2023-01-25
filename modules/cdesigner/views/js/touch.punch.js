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

(function(c){c.support.touch="ontouchend" in document;if(!c.support.touch){return}var b=c.ui.mouse.prototype,f=b._mouseInit,g=b._mouseDestroy,e,d,i,h;function a(k,l){if(k.originalEvent.touches.length>1){return}k.preventDefault();var m=k.originalEvent.changedTouches[0],j=document.createEvent("MouseEvents");j.initMouseEvent(l,true,true,window,1,m.screenX,m.screenY,m.clientX,m.clientY,false,false,false,false,0,null);k.target.dispatchEvent(j)}b._touchStart=function(k){var j=this;if(i||!j._mouseCapture(k.originalEvent.changedTouches[0])){return}i=true;h=false;e=k.originalEvent.touches[0].screenX;d=k.originalEvent.touches[0].screenY;a(k,"mouseover");a(k,"mousemove");a(k,"mousedown")};b._touchMove=function(l){if(!i){return}var k=l.originalEvent.touches[0].screenX,j=l.originalEvent.touches[0].screenY;if(e>=k-2&&e<=k+2&&d>=j-2&&d<=j+2){h=false;return}h=true;a(l,"mousemove")};b._touchEnd=function(j){if(!i){return}a(j,"mouseup");a(j,"mouseout");if(!h){a(j,"click")}i=false};b._mouseInit=function(){var j=this;j.element.bind({touchstart:c.proxy(j,"_touchStart"),touchmove:c.proxy(j,"_touchMove"),touchend:c.proxy(j,"_touchEnd")});f.call(j)};b._mouseDestroy=function(){var j=this;j.element.unbind({touchstart:c.proxy(j,"_touchStart"),touchmove:c.proxy(j,"_touchMove"),touchend:c.proxy(j,"_touchEnd")});g.call(j)}})(jQuery);