/*!
 * Creative Elements - live Theme & Page Builder
 * Copyright 2019-2022 WebshopWorks.com & Elementor.com
 */

/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 182);
/******/ })
/************************************************************************/
/******/ ({

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});
var userAgent = navigator.userAgent;

exports.default = {
	webkit: -1 !== userAgent.indexOf('AppleWebKit'),
	firefox: -1 !== userAgent.indexOf('Firefox'),
	ie: /Trident|MSIE/.test(userAgent),
	edge: -1 !== userAgent.indexOf('Edge'),
	mac: -1 !== userAgent.indexOf('Macintosh')
};

/***/ }),

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Vie) {
	_inherits(_class, _elementorModules$Vie);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: '__construct',
		value: function __construct(options) {
			var _this2 = this;

			this.motionFX = options.motionFX;

			this.runImmediately = this.run;

			this.run = function () {
				_this2.animationFrameRequest = requestAnimationFrame(_this2.run.bind(_this2));

				if ('page' === _this2.motionFX.getSettings('range')) {
					_this2.runImmediately();

					return;
				}

				var dimensions = _this2.motionFX.getSettings('dimensions'),
				    elementTopWindowPoint = dimensions.elementTop - pageYOffset,
				    elementEntrancePoint = elementTopWindowPoint - innerHeight,
				    elementExitPoint = elementTopWindowPoint + dimensions.elementHeight;

				if (elementEntrancePoint <= 0 && elementExitPoint >= 0) {
					_this2.runImmediately();
				}
			};
		}
	}, {
		key: 'runCallback',
		value: function runCallback() {
			var callback = this.getSettings('callback');

			callback.apply(undefined, arguments);
		}
	}, {
		key: 'destroy',
		value: function destroy() {
			cancelAnimationFrame(this.animationFrameRequest);
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			_get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), 'onInit', this).call(this);

			this.run();
		}
	}]);

	return _class;
}(elementorModules.ViewModule);

exports.default = _class;

/***/ }),

/***/ 13:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Handles managing all events for whatever you plug it into. Priorities for hooks are based on lowest to highest in
 * that, lowest priority hooks are fired first.
 */

var EventManager = function EventManager() {
	var slice = Array.prototype.slice,
		MethodsAvailable;

	/**
  * Contains the hooks that get registered with this EventManager. The array for storage utilizes a "flat"
  * object literal such that looking up the hook utilizes the native object literal hash.
  */
	var STORAGE = {
		actions: {},
		filters: {}
	};

	/**
  * Removes the specified hook by resetting the value of it.
  *
  * @param type Type of hook, either 'actions' or 'filters'
  * @param hook The hook (namespace.identifier) to remove
  *
  * @private
  */
	function _removeHook(type, hook, callback, context) {
		var handlers, handler, i;

		if (!STORAGE[type][hook]) {
			return;
		}
		if (!callback) {
			STORAGE[type][hook] = [];
		} else {
			handlers = STORAGE[type][hook];
			if (!context) {
				for (i = handlers.length; i--;) {
					if (handlers[i].callback === callback) {
						handlers.splice(i, 1);
					}
				}
			} else {
				for (i = handlers.length; i--;) {
					handler = handlers[i];
					if (handler.callback === callback && handler.context === context) {
						handlers.splice(i, 1);
					}
				}
			}
		}
	}

	/**
  * Use an insert sort for keeping our hooks organized based on priority. This function is ridiculously faster
  * than bubble sort, etc: http://jsperf.com/javascript-sort
  *
  * @param hooks The custom array containing all of the appropriate hooks to perform an insert sort on.
  * @private
  */
	function _hookInsertSort(hooks) {
		var tmpHook, j, prevHook;
		for (var i = 1, len = hooks.length; i < len; i++) {
			tmpHook = hooks[i];
			j = i;
			while ((prevHook = hooks[j - 1]) && prevHook.priority > tmpHook.priority) {
				hooks[j] = hooks[j - 1];
				--j;
			}
			hooks[j] = tmpHook;
		}

		return hooks;
	}

	/**
  * Adds the hook to the appropriate storage container
  *
  * @param type 'actions' or 'filters'
  * @param hook The hook (namespace.identifier) to add to our event manager
  * @param callback The function that will be called when the hook is executed.
  * @param priority The priority of this hook. Must be an integer.
  * @param [context] A value to be used for this
  * @private
  */
	function _addHook(type, hook, callback, priority, context) {
		var hookObject = {
			callback: callback,
			priority: priority,
			context: context
		};

		// Utilize 'prop itself' : http://jsperf.com/hasownproperty-vs-in-vs-undefined/19
		var hooks = STORAGE[type][hook];
		if (hooks) {
			// TEMP FIX BUG
			var hasSameCallback = false;
			jQuery.each(hooks, function () {
				if (this.callback === callback) {
					hasSameCallback = true;
					return false;
				}
			});

			if (hasSameCallback) {
				return;
			}
			// END TEMP FIX BUG

			hooks.push(hookObject);
			hooks = _hookInsertSort(hooks);
		} else {
			hooks = [hookObject];
		}

		STORAGE[type][hook] = hooks;
	}

	/**
  * Runs the specified hook. If it is an action, the value is not modified but if it is a filter, it is.
  *
  * @param type 'actions' or 'filters'
  * @param hook The hook ( namespace.identifier ) to be ran.
  * @param args Arguments to pass to the action/filter. If it's a filter, args is actually a single parameter.
  * @private
  */
	function _runHook(type, hook, args) {
		var handlers = STORAGE[type][hook],
			i,
			len;

		if (!handlers) {
			return 'filters' === type ? args[0] : false;
		}

		len = handlers.length;
		if ('filters' === type) {
			for (i = 0; i < len; i++) {
				args[0] = handlers[i].callback.apply(handlers[i].context, args);
			}
		} else {
			for (i = 0; i < len; i++) {
				handlers[i].callback.apply(handlers[i].context, args);
			}
		}

		return 'filters' === type ? args[0] : true;
	}

	/**
  * Adds an action to the event manager.
  *
  * @param action Must contain namespace.identifier
  * @param callback Must be a valid callback function before this action is added
  * @param [priority=10] Used to control when the function is executed in relation to other callbacks bound to the same hook
  * @param [context] Supply a value to be used for this
  */
	function addAction(action, callback, priority, context) {
		if ('string' === typeof action && 'function' === typeof callback) {
			priority = parseInt(priority || 10, 10);
			_addHook('actions', action, callback, priority, context);
		}

		return MethodsAvailable;
	}

	/**
  * Performs an action if it exists. You can pass as many arguments as you want to this function; the only rule is
  * that the first argument must always be the action.
  */
	function doAction() /* action, arg1, arg2, ... */{
		var args = slice.call(arguments);
		var action = args.shift();

		if ('string' === typeof action) {
			_runHook('actions', action, args);
		}

		return MethodsAvailable;
	}

	/**
  * Removes the specified action if it contains a namespace.identifier & exists.
  *
  * @param action The action to remove
  * @param [callback] Callback function to remove
  */
	function removeAction(action, callback) {
		if ('string' === typeof action) {
			_removeHook('actions', action, callback);
		}

		return MethodsAvailable;
	}

	/**
  * Adds a filter to the event manager.
  *
  * @param filter Must contain namespace.identifier
  * @param callback Must be a valid callback function before this action is added
  * @param [priority=10] Used to control when the function is executed in relation to other callbacks bound to the same hook
  * @param [context] Supply a value to be used for this
  */
	function addFilter(filter, callback, priority, context) {
		if ('string' === typeof filter && 'function' === typeof callback) {
			priority = parseInt(priority || 10, 10);
			_addHook('filters', filter, callback, priority, context);
		}

		return MethodsAvailable;
	}

	/**
  * Performs a filter if it exists. You should only ever pass 1 argument to be filtered. The only rule is that
  * the first argument must always be the filter.
  */
	function applyFilters() /* filter, filtered arg, arg2, ... */{
		var args = slice.call(arguments);
		var filter = args.shift();

		if ('string' === typeof filter) {
			return _runHook('filters', filter, args);
		}

		return MethodsAvailable;
	}

	/**
  * Removes the specified filter if it contains a namespace.identifier & exists.
  *
  * @param filter The action to remove
  * @param [callback] Callback function to remove
  */
	function removeFilter(filter, callback) {
		if ('string' === typeof filter) {
			_removeHook('filters', filter, callback);
		}

		return MethodsAvailable;
	}

	/**
  * Maintain a reference to the object scope so our public methods never get confusing.
  */
	MethodsAvailable = {
		removeFilter: removeFilter,
		applyFilters: applyFilters,
		addFilter: addFilter,
		removeAction: removeAction,
		doAction: doAction,
		addAction: addAction
	};

	// return all of the publicly available methods
	return MethodsAvailable;
};

module.exports = EventManager;

/***/ }),

/***/ 10:
/***/ (function(module, exports, __webpack_require__) {

var $ = jQuery;

window.Sticky = function( element, userSettings ) {
	var $element,
		isSticky = false,
		isFollowingParent = false,
		isReachedEffectsPoint = false,
		prevPageYOffset = pageYOffset,
		elements = {},
		settings;

	var defaultSettings = {
		to: 'top',
		offset: 0,
		effectsOffset: 0,
		parent: false,
		classes: {
			sticky: 'sticky',
			stickyActive: 'sticky-active',
			stickyEffects: 'sticky-effects',
			spacer: 'sticky-spacer',
		},
	};

	var initElements = function() {
		$element = $( element ).addClass( settings.classes.sticky );

		elements.$window = $( window );

		if ( settings.parent ) {
			if ( 'parent' === settings.parent ) {
				elements.$parent = $element.parent();
			} else {
				elements.$parent = $element.closest( settings.parent );
			}
		}
	};

	var initSettings = function() {
		settings = jQuery.extend( true, defaultSettings, userSettings );
	};

	var bindEvents = function() {
		elements.$window.on( {
			scroll: onWindowScroll,
			resize: onWindowResize,
		} );
	};

	var unbindEvents = function() {
		elements.$window
			.off( 'scroll', onWindowScroll )
			.off( 'resize', onWindowResize );
	};

	var init = function() {
		initSettings();

		initElements();

		bindEvents();

		checkPosition();
	};

	var backupCSS = function( $elementBackupCSS, backupState, properties ) {
		var css = {},
			elementStyle = $elementBackupCSS[ 0 ].style;

		properties.forEach( function( property ) {
			css[ property ] = undefined !== elementStyle[ property ] ? elementStyle[ property ] : '';
		} );

		$elementBackupCSS.data( 'css-backup-' + backupState, css );
	};

	var getCSSBackup = function( $elementCSSBackup, backupState ) {
		return $elementCSSBackup.data( 'css-backup-' + backupState );
	};

	var addSpacer = function() {
		elements.$spacer = $element.clone()
			.addClass( settings.classes.spacer )
			.css( {
				visibility: 'hidden',
				transition: 'none',
				animation: 'none',
			} );

		$element.after( elements.$spacer );
	};

	var removeSpacer = function() {
		elements.$spacer.remove();
	};

	var stickElement = function() {
		backupCSS( $element, 'unsticky', [ 'position', 'width', 'margin-top', 'margin-bottom', 'top', 'bottom' ] );

		var css = {
			position: 'fixed',
			width: getElementOuterSize( $element, 'width' ),
			marginTop: 0,
			marginBottom: 0,
		};

		css[ settings.to ] = settings.offset;

		css[ 'top' === settings.to ? 'bottom' : 'top' ] = '';

		$element
			.css( css )
			.addClass( settings.classes.stickyActive );
	};

	var unstickElement = function() {
		$element
			.css( getCSSBackup( $element, 'unsticky' ) )
			.removeClass( settings.classes.stickyActive );
	};

	var followParent = function() {
		backupCSS( elements.$parent, 'childNotFollowing', [ 'position' ] );

		elements.$parent.css( 'position', 'relative' );

		backupCSS( $element, 'notFollowing', [ 'position', 'top', 'bottom' ] );

		var css = {
			position: 'absolute',
		};

		css[ settings.to ] = '';

		css[ 'top' === settings.to ? 'bottom' : 'top' ] = 0;

		$element.css( css );

		isFollowingParent = true;
	};

	var unfollowParent = function() {
		elements.$parent.css( getCSSBackup( elements.$parent, 'childNotFollowing' ) );

		$element.css( getCSSBackup( $element, 'notFollowing' ) );

		isFollowingParent = false;
	};

	var getElementOuterSize = function( $elementOuterSize, dimension, includeMargins ) {
		var computedStyle = getComputedStyle( $elementOuterSize[ 0 ] ),
			elementSize = parseFloat( computedStyle[ dimension ] ),
			sides = 'height' === dimension ? [ 'top', 'bottom' ] : [ 'left', 'right' ],
			propertiesToAdd = [];

		if ( 'border-box' !== computedStyle.boxSizing ) {
			propertiesToAdd.push( 'border', 'padding' );
		}

		if ( includeMargins ) {
			propertiesToAdd.push( 'margin' );
		}

		propertiesToAdd.forEach( function( property ) {
			sides.forEach( function( side ) {
				elementSize += parseFloat( computedStyle[ property + '-' + side ] );
			} );
		} );

		return elementSize;
	};

	var getElementViewportOffset = function( $elementViewportOffset ) {
		var windowScrollTop = elements.$window.scrollTop(),
			elementHeight = getElementOuterSize( $elementViewportOffset, 'height' ),
			viewportHeight = innerHeight,
			elementOffsetFromTop = $elementViewportOffset.offset().top,
			distanceFromTop = elementOffsetFromTop - windowScrollTop,
			topFromBottom = distanceFromTop - viewportHeight;

		return {
			top: {
				fromTop: distanceFromTop,
				fromBottom: topFromBottom,
			},
			bottom: {
				fromTop: distanceFromTop + elementHeight,
				fromBottom: topFromBottom + elementHeight,
			},
		};
	};

	var stick = function() {
		addSpacer();

		stickElement();

		isSticky = true;

		// fix: restore checked property
		$element.find('input[checked]').prop('checked', true);

		$element.trigger( 'sticky:stick' );
	};

	var unstick = function() {
		unstickElement();

		removeSpacer();

		isSticky = false;

		$element.trigger( 'sticky:unstick' );
	};

	var checkParent = function() {
		var elementOffset = getElementViewportOffset( $element ),
			isTop = 'top' === settings.to;

		if ( isFollowingParent ) {
			var isNeedUnfollowing = isTop ? elementOffset.top.fromTop > settings.offset : elementOffset.bottom.fromBottom < -settings.offset;

			if ( isNeedUnfollowing ) {
				unfollowParent();
			}
		} else {
			var parentOffset = getElementViewportOffset( elements.$parent ),
				parentStyle = getComputedStyle( elements.$parent[ 0 ] ),
				borderWidthToDecrease = parseFloat( parentStyle[ isTop ? 'borderBottomWidth' : 'borderTopWidth' ] ),
				parentViewportDistance = isTop ? parentOffset.bottom.fromTop - borderWidthToDecrease : parentOffset.top.fromBottom + borderWidthToDecrease,
				isNeedFollowing = isTop ? parentViewportDistance <= elementOffset.bottom.fromTop : parentViewportDistance >= elementOffset.top.fromBottom;

			if ( isNeedFollowing ) {
				followParent();
			}
		}
	};

	var checkEffectsPoint = function( distanceFromTriggerPoint ) {
		if ( isReachedEffectsPoint && -distanceFromTriggerPoint < settings.effectsOffset ) {
			$element.removeClass( settings.classes.stickyEffects );

			isReachedEffectsPoint = false;
		} else if ( ! isReachedEffectsPoint && -distanceFromTriggerPoint >= settings.effectsOffset ) {
			$element.addClass( settings.classes.stickyEffects );

			isReachedEffectsPoint = true;
		}
	};

	var checkPosition = function() {
		var offset = settings.offset,
			distanceFromTriggerPoint;

		if ( isSticky ) {
			var spacerViewportOffset = getElementViewportOffset( elements.$spacer );

			distanceFromTriggerPoint = 'top' === settings.to ? spacerViewportOffset.top.fromTop - offset : -spacerViewportOffset.bottom.fromBottom - offset;

			if ( settings.parent ) {
				checkParent();
			}

			if ( distanceFromTriggerPoint > 0 ) {
				unstick();
			}
		} else {
			var elementViewportOffset = getElementViewportOffset( $element );

			distanceFromTriggerPoint = 'top' === settings.to ? elementViewportOffset.top.fromTop - offset : -elementViewportOffset.bottom.fromBottom - offset;

			if ( distanceFromTriggerPoint <= 0 ) {
				stick();

				if ( settings.parent ) {
					checkParent();
				}
			}
		}

		checkEffectsPoint( distanceFromTriggerPoint );
	};

	var onWindowScroll = function() {
		if (isSticky && settings.autoHide) {
			var t = 10, // tolerance
				autoHideOffset = settings.autoHideOffset.size * ('vh' === settings.autoHideOffset.unit ? $(window).height() / 100 : 1);

			if (pageYOffset >= autoHideOffset && pageYOffset > prevPageYOffset + t) {
				$element
					.off('transitionend.ceSticky')
					.css({
						transition: 'transform ' + settings.autoHideDuration.size + 's',
						transform: 'translateY(calc(-100% - ' + settings.offset + 'px))'
					})
					.addClass(settings.classes.stickyHide);
			}
			if (pageYOffset < autoHideOffset || pageYOffset < prevPageYOffset - t) {
				$element
					.removeClass(settings.classes.stickyHide)
					.css('transform', '')
					.one('transitionend.ceSticky', function () {
						$element.css('transition', '');
					});
			}

			prevPageYOffset = pageYOffset;
		}

		checkPosition();
	};

	var onWindowResize = function() {
		if ( ! isSticky ) {
			return;
		}

		unstickElement();

		stickElement();

		if ( settings.parent ) {
			// Force recalculation of the relation between the element and its parent
			isFollowingParent = false;

			checkParent();
		}
	};

	this.destroy = function() {
		if ( isSticky ) {
			unstick();
		}

		unbindEvents();

		$element.removeClass( settings.classes.sticky )
			.css('transform', '')
			.off('transitionend.ceSticky')
			.removeClass(settings.classes.stickyHide);
	};

	init();
};

$.fn.sticky = function( settings ) {
	var isCommand = 'string' === typeof settings;

	this.each( function() {
		var $this = $( this );

		if ( ! isCommand ) {
			$this.data( 'sticky', new Sticky( this, settings ) );

			return;
		}

		var instance = $this.data( 'sticky' );

		if ( ! instance ) {
			throw Error( 'Trying to perform the `' + settings + '` method prior to initialization' );
		}

		if ( ! instance[ settings ] ) {
			throw ReferenceError( 'Method `' + settings + '` not found in sticky instance' );
		}

		instance[ settings ].apply( instance, Array.prototype.slice.call( arguments, 1 ) );

		if ( 'destroy' === settings ) {
			$this.removeData( 'sticky' );
		}
	} );

	return this;
};

var StickyHandler = elementorModules.frontend.handlers.Base.extend({

	bindEvents: function bindEvents() {
		ceFrontend.addListenerOnce(this.getUniqueHandlerID() + 'sticky', 'resize', this.run);
	},

	unbindEvents: function unbindEvents() {
		ceFrontend.removeListeners(this.getUniqueHandlerID() + 'sticky', 'resize', this.run);
	},

	isActive: function isActive() {
		return undefined !== this.$element.data('sticky');
	},

	activate: function activate() {
		var elementSettings = this.getElementSettings(),
			stickyOptions = {
				to: elementSettings.sticky,
				offset: elementSettings.sticky_offset,
				effectsOffset: elementSettings.sticky_effects_offset,
				autoHide: elementSettings.sticky_auto_hide,
				autoHideOffset: elementSettings.sticky_auto_hide_offset || {size: 0},
				autoHideDuration: elementSettings.sticky_auto_hide_duration || {size: 0},
				classes: {
					sticky: 'elementor-sticky',
					stickyActive: 'elementor-sticky--active elementor-section--handles-inside',
					stickyEffects: 'elementor-sticky--effects',
					stickyHide: 'ce-sticky--hide',
					spacer: 'elementor-sticky__spacer'
				}
			};

		if (elementSettings.sticky_parent) {
			stickyOptions.parent = '.elementor-widget-wrap';
		}

		this.$element.sticky(stickyOptions);
	},

	deactivate: function deactivate() {
		if (!this.isActive()) {
			return;
		}

		this.$element.sticky('destroy');
	},

	run: function run(refresh) {
		if (!this.getElementSettings('sticky')) {
			this.deactivate();

			return;
		}

		var currentDeviceMode = ceFrontend.getCurrentDeviceMode(),
			activeDevices = this.getElementSettings('sticky_on');

		if (-1 !== activeDevices.indexOf(currentDeviceMode)) {
			if (true === refresh) {
				this.reactivate();
			} else if (!this.isActive()) {
				this.activate();
			}
		} else {
			this.deactivate();
		}
	},

	reactivate: function reactivate() {
		this.deactivate();

		this.activate();
	},

	onElementChange: function onElementChange(settingKey) {
		if (-1 !== ['sticky', 'sticky_on'].indexOf(settingKey)) {
			this.run(true);
		}

		if (-1 !== ['sticky_offset', 'sticky_effects_offset', 'sticky_parent', 'sticky_auto_hide', 'sticky_auto_hide_offset', 'sticky_auto_hide_duration'].indexOf(settingKey)) {
			this.reactivate();
		}
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.run();
	},

	onDestroy: function onDestroy() {
		elementorModules.frontend.handlers.Base.prototype.onDestroy.apply(this, arguments);

		this.deactivate();
	}
});

module.exports = function ($scope) {
	new StickyHandler({ $element: $scope });
};

/***/ }),

/***/ 15:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Mod) {
	_inherits(_class, _elementorModules$Mod);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'get',
		value: function get(key, options) {
			options = options || {};

			var storage = void 0;

			try {
				storage = options.session ? sessionStorage : localStorage;
			} catch (e) {
				return key ? undefined : {};
			}

			var elementorStorage = storage.getItem('elementor');

			if (elementorStorage) {
				elementorStorage = JSON.parse(elementorStorage);
			} else {
				elementorStorage = {};
			}

			if (!elementorStorage.__expiration) {
				elementorStorage.__expiration = {};
			}

			var expiration = elementorStorage.__expiration;

			var expirationToCheck = [];

			if (key) {
				if (expiration[key]) {
					expirationToCheck = [key];
				}
			} else {
				expirationToCheck = Object.keys(expiration);
			}

			var entryExpired = false;

			expirationToCheck.forEach(function (expirationKey) {
				if (new Date(expiration[expirationKey]) < new Date()) {
					delete elementorStorage[expirationKey];

					delete expiration[expirationKey];

					entryExpired = true;
				}
			});

			if (entryExpired) {
				this.save(elementorStorage, options.session);
			}

			if (key) {
				return elementorStorage[key];
			}

			return elementorStorage;
		}
	}, {
		key: 'set',
		value: function set(key, value, options) {
			options = options || {};

			var elementorStorage = this.get(null, options);

			elementorStorage[key] = value;

			if (options.lifetimeInSeconds) {
				var date = new Date();

				date.setTime(date.getTime() + options.lifetimeInSeconds * 1000);

				elementorStorage.__expiration[key] = date.getTime();
			}

			this.save(elementorStorage, options.session);
		}
	}, {
		key: 'save',
		value: function save(object, session) {
			var storage = void 0;

			try {
				storage = session ? sessionStorage : localStorage;
			} catch (e) {
				return;
			}

			storage.setItem('elementor', JSON.stringify(object));
		}
	}]);

	return _class;
}(elementorModules.Module);

exports.default = _class;

/***/ }),

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _environment = __webpack_require__(1);

var _environment2 = _interopRequireDefault(_environment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var HotKeys = function () {
	function HotKeys() {
		_classCallCheck(this, HotKeys);

		this.hotKeysHandlers = {};
	}

	_createClass(HotKeys, [{
		key: 'applyHotKey',
		value: function applyHotKey(event) {
			var handlers = this.hotKeysHandlers[event.which];

			if (!handlers) {
				return;
			}

			jQuery.each(handlers, function (key, handler) {
				if (handler.isWorthHandling && !handler.isWorthHandling(event)) {
					return;
				}

				// Fix for some keyboard sources that consider alt key as ctrl key
				if (!handler.allowAltKey && event.altKey) {
					return;
				}

				event.preventDefault();

				handler.handle(event);
			});
		}
	}, {
		key: 'isControlEvent',
		value: function isControlEvent(event) {
			return event[_environment2.default.mac ? 'metaKey' : 'ctrlKey'];
		}
	}, {
		key: 'addHotKeyHandler',
		value: function addHotKeyHandler(keyCode, handlerName, handler) {
			if (!this.hotKeysHandlers[keyCode]) {
				this.hotKeysHandlers[keyCode] = {};
			}

			this.hotKeysHandlers[keyCode][handlerName] = handler;
		}
	}, {
		key: 'bindListener',
		value: function bindListener($listener) {
			$listener.on('keydown', this.applyHotKey.bind(this));
		}
	}]);

	return HotKeys;
}();

exports.default = HotKeys;

/***/ }),

/***/ 17:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Vie) {
	_inherits(_class, _elementorModules$Vie);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				selectors: {
					elements: '.elementor-element',
					nestedDocumentElements: '.elementor .elementor-element'
				},
				classes: {
					editMode: 'elementor-edit-mode'
				}
			};
		}
	}, {
		key: 'getDefaultElements',
		value: function getDefaultElements() {
			var selectors = this.getSettings('selectors');

			return {
				$elements: this.$element.find(selectors.elements).not(this.$element.find(selectors.nestedDocumentElements))
			};
		}
	}, {
		key: 'getDocumentSettings',
		value: function getDocumentSettings(setting) {
			var elementSettings = void 0;

			if (this.isEdit) {
				elementSettings = {};

				var settings = elementor.settings.page.model;

				jQuery.each(settings.getActiveControls(), function (controlKey) {
					elementSettings[controlKey] = settings.attributes[controlKey];
				});
			} else {
				elementSettings = this.$element.data('elementor-settings') || {};
			}

			return this.getItems(elementSettings, setting);
		}
	}, {
		key: 'runElementsHandlers',
		value: function runElementsHandlers() {
			this.elements.$elements.each(function (index, element) {
				return ceFrontend.elementsHandler.runReadyTrigger(element);
			});
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			this.$element = this.getSettings('$element');

			_get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), 'onInit', this).call(this);

			this.isEdit = this.$element.hasClass(this.getSettings('classes.editMode'));

			if (this.isEdit) {
				elementor.settings.page.model.on('change', this.onSettingsChange.bind(this));
			} else {
				this.runElementsHandlers();
			}
		}
	}, {
		key: 'onSettingsChange',
		value: function onSettingsChange() {}
	}]);

	return _class;
}(elementorModules.ViewModule);

exports.default = _class;

/***/ }),

/***/ 18:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.frontend.handlers.Base.extend({
	$activeContent: null,

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				tabTitle: '.elementor-tab-title',
				tabContent: '.elementor-tab-content'
			},
			classes: {
				active: 'elementor-active'
			},
			showTabFn: 'show',
			hideTabFn: 'hide',
			toggleSelf: true,
			hidePrevious: true,
			autoExpand: true
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		return {
			$tabTitles: this.findElement(selectors.tabTitle),
			$tabContents: this.findElement(selectors.tabContent)
		};
	},

	activateDefaultTab: function activateDefaultTab() {
		var settings = this.getSettings();

		if (!settings.autoExpand || 'editor' === settings.autoExpand && !this.isEdit) {
			return;
		}

		var defaultActiveTab = this.getEditSettings('activeItemIndex') || 1,
			originalToggleMethods = {
			showTabFn: settings.showTabFn,
			hideTabFn: settings.hideTabFn
		};

		// Toggle tabs without animation to avoid jumping
		this.setSettings({
			showTabFn: 'show',
			hideTabFn: 'hide'
		});

		this.changeActiveTab(defaultActiveTab);

		// Return back original toggle effects
		this.setSettings(originalToggleMethods);
	},

	deactivateActiveTab: function deactivateActiveTab(tabIndex) {
		var settings = this.getSettings(),
			activeClass = settings.classes.active,
			activeFilter = tabIndex ? '[data-tab="' + tabIndex + '"]' : '.' + activeClass,
			$activeTitle = this.elements.$tabTitles.filter(activeFilter),
			$activeContent = this.elements.$tabContents.filter(activeFilter);

		$activeTitle.add($activeContent).removeClass(activeClass);

		$activeContent[settings.hideTabFn]();
	},

	activateTab: function activateTab(tabIndex) {
		var settings = this.getSettings(),
			activeClass = settings.classes.active,
			$requestedTitle = this.elements.$tabTitles.filter('[data-tab="' + tabIndex + '"]'),
			$requestedContent = this.elements.$tabContents.filter('[data-tab="' + tabIndex + '"]');

		$requestedTitle.add($requestedContent).addClass(activeClass);

		$requestedContent[settings.showTabFn]();
	},

	isActiveTab: function isActiveTab(tabIndex) {
		return this.elements.$tabTitles.filter('[data-tab="' + tabIndex + '"]').hasClass(this.getSettings('classes.active'));
	},

	bindEvents: function bindEvents() {
		var _this = this;

		this.elements.$tabTitles.on({
			keydown: function keydown(event) {
				if ('Enter' === event.key) {
					event.preventDefault();

					_this.changeActiveTab(event.currentTarget.getAttribute('data-tab'));
				}
			},
			click: function click(event) {
				event.preventDefault();

				_this.changeActiveTab(event.currentTarget.getAttribute('data-tab'));
			}
		});
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.activateDefaultTab();
	},

	onEditSettingsChange: function onEditSettingsChange(propertyName) {
		if ('activeItemIndex' === propertyName) {
			this.activateDefaultTab();
		}
	},

	changeActiveTab: function changeActiveTab(tabIndex) {
		var isActiveTab = this.isActiveTab(tabIndex),
			settings = this.getSettings();

		if ((settings.toggleSelf || !isActiveTab) && settings.hidePrevious) {
			this.deactivateActiveTab();
		}

		if (!settings.hidePrevious && isActiveTab) {
			this.deactivateActiveTab(tabIndex);
		}

		if (!isActiveTab) {
			this.activateTab(tabIndex);
		}
	}
});

/***/ }),

/***/ 90:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _handler = __webpack_require__(91);

var _handler2 = _interopRequireDefault(_handler);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Mod) {
	_inherits(_class, _elementorModules$Mod);

	function _class() {
		_classCallCheck(this, _class);

		var _this = _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).call(this));

		ceFrontend.hooks.addAction('frontend/element_ready/global', function ($element) {
			ceFrontend.elementsHandler.addHandler(_handler2.default, { $element: $element });
		});
		return _this;
	}

	return _class;
}(elementorModules.Module);

exports.default = _class;

/***/ }),

/***/ 91:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

var _motionFx = __webpack_require__(92);

var _motionFx2 = _interopRequireDefault(_motionFx);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$fro) {
	_inherits(_class, _elementorModules$fro);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: '__construct',
		value: function __construct() {
			var _get2;

			for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
				args[_key] = arguments[_key];
			}

			(_get2 = _get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), '__construct', this)).call.apply(_get2, [this].concat(args));

			this.toggle = ceFrontend.debounce(this.toggle, 200);
		}
	}, {
		key: 'bindEvents',
		value: function bindEvents() {
			ceFrontend.elements.$window.on('resize', this.toggle);
		}
	}, {
		key: 'unbindEvents',
		value: function unbindEvents() {
			ceFrontend.elements.$window.off('resize', this.toggle);
		}
	}, {
		key: 'initEffects',
		value: function initEffects() {
			this.effects = {
				translateY: {
					interaction: 'scroll',
					actions: ['translateY']
				},
				translateX: {
					interaction: 'scroll',
					actions: ['translateX']
				},
				rotateZ: {
					interaction: 'scroll',
					actions: ['rotateZ']
				},
				scale: {
					interaction: 'scroll',
					actions: ['scale']
				},
				opacity: {
					interaction: 'scroll',
					actions: ['opacity']
				},
				blur: {
					interaction: 'scroll',
					actions: ['blur']
				},
				mouseTrack: {
					interaction: 'mouseMove',
					actions: ['translateXY']
				},
				tilt: {
					interaction: 'mouseMove',
					actions: ['tilt']
				}
			};
		}
	}, {
		key: 'prepareOptions',
		value: function prepareOptions(name) {
			var _this2 = this;

			var elementSettings = this.getElementSettings(),
			    type = 'motion_fx' === name ? 'element' : 'background',
			    interactions = {};

			jQuery.each(elementSettings, function (key, value) {
				var keyRegex = new RegExp('^' + name + '_(.+?)_effect'),
				    keyMatches = key.match(keyRegex);

				if (!keyMatches || !value) {
					return;
				}

				var options = {},
				    effectName = keyMatches[1];

				jQuery.each(elementSettings, function (subKey, subValue) {
					var subKeyRegex = new RegExp(name + '_' + effectName + '_(.+)'),
					    subKeyMatches = subKey.match(subKeyRegex);

					if (!subKeyMatches) {
						return;
					}

					var subFieldName = subKeyMatches[1];

					if ('effect' === subFieldName) {
						return;
					}

					if ('object' === (typeof subValue === 'undefined' ? 'undefined' : _typeof(subValue))) {
						subValue = Object.keys(subValue.sizes).length ? subValue.sizes : subValue.size;
					}

					options[subKeyMatches[1]] = subValue;
				});

				var effect = _this2.effects[effectName],
				    interactionName = effect.interaction;

				if (!interactions[interactionName]) {
					interactions[interactionName] = {};
				}

				effect.actions.forEach(function (action) {
					return interactions[interactionName][action] = options;
				});
			});

			var $element = this.$element,
			    $dimensionsElement = void 0;

			var elementType = this.getElementType();

			if ('element' === type && 'section' !== elementType) {
				$dimensionsElement = $element;

				var childElementSelector = void 0;

				if ('column' === elementType) {
					childElementSelector = '.elementor-column-wrap';
				} else {
					childElementSelector = '.elementor-widget-container';
				}

				$element = $element.find('> ' + childElementSelector);
			}

			var options = {
				type: type,
				interactions: interactions,
				elementSettings: elementSettings,
				$element: $element,
				$dimensionsElement: $dimensionsElement,
				refreshDimensions: this.isEdit,
				range: 'viewport',
				classes: {
					element: 'elementor-motion-effects-element',
					parent: 'elementor-motion-effects-parent',
					backgroundType: 'elementor-motion-effects-element-type-background',
					container: 'elementor-motion-effects-container',
					layer: 'elementor-motion-effects-layer',
					perspective: 'elementor-motion-effects-perspective'
				}
			};

			if ('page' === elementSettings.motion_fx_range || 'fixed' === this.getCurrentDeviceSetting('_position')) {
				options.range = 'page';
			}

			if ('background' === type && 'column' === this.getElementType()) {
				options.addBackgroundLayerTo = ' > .elementor-element-populated';
			}

			return options;
		}
	}, {
		key: 'activate',
		value: function activate(name) {
			var options = this.prepareOptions(name);

			if (jQuery.isEmptyObject(options.interactions)) {
				return;
			}

			this[name] = new _motionFx2.default(options);
		}
	}, {
		key: 'deactivate',
		value: function deactivate(name) {
			if (this[name]) {
				this[name].destroy();

				delete this[name];
			}
		}
	}, {
		key: 'toggle',
		value: function toggle() {
			var _this3 = this;

			var currentDeviceMode = ceFrontend.getCurrentDeviceMode(),
			    elementSettings = this.getElementSettings();

			['motion_fx', 'background_motion_fx'].forEach(function (name) {
				var devices = elementSettings[name + '_devices'],
				    isCurrentModeActive = !devices || -1 !== devices.indexOf(currentDeviceMode);

				if (isCurrentModeActive && (elementSettings[name + '_motion_fx_scrolling'] || elementSettings[name + '_motion_fx_mouse'])) {
					if (_this3[name]) {
						_this3.refreshInstance(name);
					} else {
						_this3.activate(name);
					}
				} else {
					_this3.deactivate(name);
				}
			});
		}
	}, {
		key: 'refreshInstance',
		value: function refreshInstance(instanceName) {
			var instance = this[instanceName];

			if (!instance) {
				return;
			}

			var preparedOptions = this.prepareOptions(instanceName);

			instance.setSettings(preparedOptions);

			instance.refresh();
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			_get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), 'onInit', this).call(this);

			this.initEffects();

			this.toggle();
		}
	}, {
		key: 'onElementChange',
		value: function onElementChange(propertyName) {
			var _this4 = this;

			if (/motion_fx_((scrolling)|(mouse)|(devices))$/.test(propertyName)) {
				this.toggle();

				return;
			}

			var propertyMatches = propertyName.match('.*?motion_fx');

			if (propertyMatches) {
				var instanceName = propertyMatches[0];

				this.refreshInstance(instanceName);

				if (!this[instanceName]) {
					this.activate(instanceName);
				}
			}

			if (/^_position/.test(propertyName)) {
				['motion_fx', 'background_motion_fx'].forEach(function (instanceName) {
					_this4.refreshInstance(instanceName);
				});
			}
		}
	}, {
		key: 'onDestroy',
		value: function onDestroy() {
			var _this5 = this;

			_get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), 'onDestroy', this).call(this);

			['motion_fx', 'background_motion_fx'].forEach(function (name) {
				_this5.deactivate(name);
			});
		}
	}]);

	return _class;
}(elementorModules.frontend.handlers.Base);

exports.default = _class;

/***/ }),

/***/ 92:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

var _scroll = __webpack_require__(93);

var _scroll2 = _interopRequireDefault(_scroll);

var _mouseMove = __webpack_require__(94);

var _mouseMove2 = _interopRequireDefault(_mouseMove);

var _actions2 = __webpack_require__(95);

var _actions3 = _interopRequireDefault(_actions2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Vie) {
	_inherits(_class, _elementorModules$Vie);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				type: 'element',
				$element: null,
				$dimensionsElement: null,
				addBackgroundLayerTo: null,
				interactions: {},
				refreshDimensions: false,
				range: 'viewport',
				classes: {
					element: 'motion-fx-element',
					parent: 'motion-fx-parent',
					backgroundType: 'motion-fx-element-type-background',
					container: 'motion-fx-container',
					layer: 'motion-fx-layer',
					perspective: 'motion-fx-perspective'
				}
			};
		}
	}, {
		key: 'bindEvents',
		value: function bindEvents() {
			this.onWindowResize = this.onWindowResize.bind(this);

			ceFrontend.elements.$window.on('resize', this.onWindowResize);
		}
	}, {
		key: 'unbindEvents',
		value: function unbindEvents() {
			ceFrontend.elements.$window.off('resize', this.onWindowResize);
		}
	}, {
		key: 'addBackgroundLayer',
		value: function addBackgroundLayer() {
			var settings = this.getSettings();

			this.elements.$motionFXContainer = jQuery('<div>', { class: settings.classes.container });

			this.elements.$motionFXLayer = jQuery('<div>', { class: settings.classes.layer });

			this.updateBackgroundLayerSize();

			this.elements.$motionFXContainer.prepend(this.elements.$motionFXLayer);

			var $addBackgroundLayerTo = settings.addBackgroundLayerTo ? this.$element.find(settings.addBackgroundLayerTo) : this.$element;

			$addBackgroundLayerTo.prepend(this.elements.$motionFXContainer);
		}
	}, {
		key: 'removeBackgroundLayer',
		value: function removeBackgroundLayer() {
			this.elements.$motionFXContainer.remove();
		}
	}, {
		key: 'updateBackgroundLayerSize',
		value: function updateBackgroundLayerSize() {
			var settings = this.getSettings(),
			    speed = {
				x: 0,
				y: 0
			},
			    mouseInteraction = settings.interactions.mouseMove,
			    scrollInteraction = settings.interactions.scroll;

			if (mouseInteraction && mouseInteraction.translateXY) {
				speed.x = mouseInteraction.translateXY.speed * 10;
				speed.y = mouseInteraction.translateXY.speed * 10;
			}

			if (scrollInteraction) {
				if (scrollInteraction.translateX) {
					speed.x = scrollInteraction.translateX.speed * 10;
				}

				if (scrollInteraction.translateY) {
					speed.y = scrollInteraction.translateY.speed * 10;
				}
			}

			this.elements.$motionFXLayer.css({
				width: 100 + speed.x + '%',
				height: 100 + speed.y + '%'
			});
		}
	}, {
		key: 'defineDimensions',
		value: function defineDimensions() {
			var $dimensionsElement = this.getSettings('$dimensionsElement') || this.$element,
			    elementOffset = $dimensionsElement.offset();

			var dimensions = {
				elementHeight: $dimensionsElement.outerHeight(),
				elementWidth: $dimensionsElement.outerWidth(),
				elementTop: elementOffset.top,
				elementLeft: elementOffset.left
			};

			dimensions.elementRange = dimensions.elementHeight + innerHeight;

			this.setSettings('dimensions', dimensions);

			if ('background' === this.getSettings('type')) {
				this.defineBackgroundLayerDimensions();
			}
		}
	}, {
		key: 'defineBackgroundLayerDimensions',
		value: function defineBackgroundLayerDimensions() {
			var dimensions = this.getSettings('dimensions');

			dimensions.layerHeight = this.elements.$motionFXLayer.height();
			dimensions.layerWidth = this.elements.$motionFXLayer.width();
			dimensions.movableX = dimensions.layerWidth - dimensions.elementWidth;
			dimensions.movableY = dimensions.layerHeight - dimensions.elementHeight;

			this.setSettings('dimensions', dimensions);
		}
	}, {
		key: 'initInteractionsTypes',
		value: function initInteractionsTypes() {
			this.interactionsTypes = {
				scroll: _scroll2.default,
				mouseMove: _mouseMove2.default
			};
		}
	}, {
		key: 'prepareSpecialActions',
		value: function prepareSpecialActions() {
			var settings = this.getSettings(),
			    hasTiltEffect = !!(settings.interactions.mouseMove && settings.interactions.mouseMove.tilt);

			this.elements.$parent.toggleClass(settings.classes.perspective, hasTiltEffect);
		}
	}, {
		key: 'cleanSpecialActions',
		value: function cleanSpecialActions() {
			var settings = this.getSettings();

			this.elements.$parent.removeClass(settings.classes.perspective);
		}
	}, {
		key: 'runInteractions',
		value: function runInteractions() {
			var _this2 = this;

			var settings = this.getSettings();

			this.actions.setCSSTransformVariables(settings.elementSettings);
			this.prepareSpecialActions();

			jQuery.each(settings.interactions, function (interactionName, actions) {
				_this2.interactions[interactionName] = new _this2.interactionsTypes[interactionName]({
					motionFX: _this2,
					callback: function callback() {
						for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
							args[_key] = arguments[_key];
						}

						jQuery.each(actions, function (actionName, actionData) {
							var _actions;

							return (_actions = _this2.actions).runAction.apply(_actions, [actionName, actionData].concat(args));
						});
					}
				});

				_this2.interactions[interactionName].runImmediately();
			});
		}
	}, {
		key: 'destroyInteractions',
		value: function destroyInteractions() {
			this.cleanSpecialActions();

			jQuery.each(this.interactions, function (interactionName, interaction) {
				return interaction.destroy();
			});

			this.interactions = {};
		}
	}, {
		key: 'refresh',
		value: function refresh() {
			this.actions.setSettings(this.getSettings());

			if ('background' === this.getSettings('type')) {
				this.updateBackgroundLayerSize();

				this.defineBackgroundLayerDimensions();
			}

			this.actions.refresh();

			this.destroyInteractions();

			this.runInteractions();
		}
	}, {
		key: 'destroy',
		value: function destroy() {
			this.destroyInteractions();

			this.actions.refresh();

			var settings = this.getSettings();

			this.$element.removeClass(settings.classes.element);

			this.elements.$parent.removeClass(settings.classes.parent);

			if ('background' === settings.type) {
				this.$element.removeClass(settings.classes.backgroundType);

				this.removeBackgroundLayer();
			}
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			_get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), 'onInit', this).call(this);

			var settings = this.getSettings();

			this.$element = settings.$element;

			this.elements.$parent = this.$element.parent();

			this.$element.addClass(settings.classes.element);

			this.elements.$parent = this.$element.parent();

			this.elements.$parent.addClass(settings.classes.parent);

			if ('background' === settings.type) {
				this.$element.addClass(settings.classes.backgroundType);

				this.addBackgroundLayer();
			}

			this.defineDimensions();

			settings.$targetElement = 'element' === settings.type ? this.$element : this.elements.$motionFXLayer;

			this.interactions = {};

			this.actions = new _actions3.default(settings);

			this.initInteractionsTypes();

			this.runInteractions();
		}
	}, {
		key: 'onWindowResize',
		value: function onWindowResize() {
			this.defineDimensions();
		}
	}]);

	return _class;
}(elementorModules.ViewModule);

exports.default = _class;

/***/ }),

/***/ 93:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _base = __webpack_require__(5);

var _base2 = _interopRequireDefault(_base);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_BaseInteraction) {
	_inherits(_class, _BaseInteraction);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'run',
		value: function run() {
			if (pageYOffset === this.windowScrollTop) {
				return;
			}

			var motionFXSettings = this.motionFX.getSettings();

			if (motionFXSettings.refreshDimensions) {
				this.motionFX.defineDimensions();
			}

			this.windowScrollTop = pageYOffset;

			var passedRangePercents = void 0;

			if ('page' === motionFXSettings.range) {
				passedRangePercents = document.documentElement.scrollTop / (document.body.scrollHeight - innerHeight) * 100;
			} else {
				var dimensions = motionFXSettings.dimensions,
					element = motionFXSettings.$element[0],
				    elementTopWindowPoint = element && ~element.className.indexOf('sticky--active') ? element.getBoundingClientRect().top : dimensions.elementTop - pageYOffset,
				    elementEntrancePoint = elementTopWindowPoint - innerHeight;

				passedRangePercents = 100 / dimensions.elementRange * (elementEntrancePoint * -1);
			}

			this.runCallback(passedRangePercents);
		}
	}]);

	return _class;
}(_base2.default);

exports.default = _class;

/***/ }),

/***/ 94:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

var _base = __webpack_require__(5);

var _base2 = _interopRequireDefault(_base);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var MouseMoveInteraction = function (_BaseInteraction) {
	_inherits(MouseMoveInteraction, _BaseInteraction);

	function MouseMoveInteraction() {
		_classCallCheck(this, MouseMoveInteraction);

		return _possibleConstructorReturn(this, (MouseMoveInteraction.__proto__ || Object.getPrototypeOf(MouseMoveInteraction)).apply(this, arguments));
	}

	_createClass(MouseMoveInteraction, [{
		key: 'bindEvents',
		value: function bindEvents() {
			if (!MouseMoveInteraction.mouseTracked) {
				ceFrontend.elements.$window.on('mousemove', MouseMoveInteraction.updateMousePosition);

				MouseMoveInteraction.mouseTracked = true;
			}
		}
	}, {
		key: 'run',
		value: function run() {
			var mousePosition = MouseMoveInteraction.mousePosition,
			    oldMousePosition = this.oldMousePosition;

			if (oldMousePosition.x === mousePosition.x && oldMousePosition.y === mousePosition.y) {
				return;
			}

			this.oldMousePosition = {
				x: mousePosition.x,
				y: mousePosition.y
			};

			var passedPercentsX = 100 / innerWidth * mousePosition.x,
			    passedPercentsY = 100 / innerHeight * mousePosition.y;

			this.runCallback(passedPercentsX, passedPercentsY);
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			this.oldMousePosition = {};

			_get(MouseMoveInteraction.prototype.__proto__ || Object.getPrototypeOf(MouseMoveInteraction.prototype), 'onInit', this).call(this);
		}
	}]);

	return MouseMoveInteraction;
}(_base2.default);

exports.default = MouseMoveInteraction;


MouseMoveInteraction.mousePosition = {};

MouseMoveInteraction.updateMousePosition = function (event) {
	MouseMoveInteraction.mousePosition = {
		x: event.clientX,
		y: event.clientY
	};
};

/***/ }),

/***/ 95:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Mod) {
	_inherits(_class, _elementorModules$Mod);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'getMovePointFromPassedPercents',
		value: function getMovePointFromPassedPercents(movableRange, passedPercents) {
			var movePoint = passedPercents / movableRange * 100;

			return +movePoint.toFixed(2);
		}
	}, {
		key: 'getEffectValueFromMovePoint',
		value: function getEffectValueFromMovePoint(range, movePoint) {
			return range * movePoint / 100;
		}
	}, {
		key: 'getStep',
		value: function getStep(passedPercents, options) {
			if ('element' === this.getSettings('type')) {
				return this.getElementStep(passedPercents, options);
			}

			return this.getBackgroundStep(passedPercents, options);
		}
	}, {
		key: 'getElementStep',
		value: function getElementStep(passedPercents, options) {
			return -(passedPercents - 50) * options.speed;
		}
	}, {
		key: 'getBackgroundStep',
		value: function getBackgroundStep(passedPercents, options) {
			var movableRange = this.getSettings('dimensions.movable' + options.axis.toUpperCase());

			return -this.getEffectValueFromMovePoint(movableRange, passedPercents);
		}
	}, {
		key: 'getDirectionMovePoint',
		value: function getDirectionMovePoint(passedPercents, direction, range) {
			var movePoint = void 0;

			if (passedPercents < range.start) {
				if ('out-in' === direction) {
					movePoint = 0;
				} else if ('in-out' === direction) {
					movePoint = 100;
				} else {
					movePoint = this.getMovePointFromPassedPercents(range.start, passedPercents);

					if ('in-out-in' === direction) {
						movePoint = 100 - movePoint;
					}
				}
			} else if (passedPercents < range.end) {
				if ('in-out-in' === direction) {
					movePoint = 0;
				} else if ('out-in-out' === direction) {
					movePoint = 100;
				} else {
					movePoint = this.getMovePointFromPassedPercents(range.end - range.start, passedPercents - range.start);

					if ('in-out' === direction) {
						movePoint = 100 - movePoint;
					}
				}
			} else if ('in-out' === direction) {
				movePoint = 0;
			} else if ('out-in' === direction) {
				movePoint = 100;
			} else {
				movePoint = this.getMovePointFromPassedPercents(100 - range.end, 100 - passedPercents);

				if ('in-out-in' === direction) {
					movePoint = 100 - movePoint;
				}
			}

			return movePoint;
		}
	}, {
		key: 'translateX',
		value: function translateX(actionData, passedPercents) {
			actionData.axis = 'x';
			actionData.unit = 'px';

			this.transform('translateX', passedPercents, actionData);
		}
	}, {
		key: 'translateY',
		value: function translateY(actionData, passedPercents) {
			actionData.axis = 'y';
			actionData.unit = 'px';

			this.transform('translateY', passedPercents, actionData);
		}
	}, {
		key: 'translateXY',
		value: function translateXY(actionData, passedPercentsX, passedPercentsY) {
			this.translateX(actionData, passedPercentsX);

			this.translateY(actionData, passedPercentsY);
		}
	}, {
		key: 'tilt',
		value: function tilt(actionData, passedPercentsX, passedPercentsY) {
			var options = {
				speed: actionData.speed / 10,
				direction: actionData.direction
			};

			this.rotateX(options, passedPercentsY);

			this.rotateY(options, 100 - passedPercentsX);
		}
	}, {
		key: 'rotateX',
		value: function rotateX(actionData, passedPercents) {
			actionData.axis = 'x';
			actionData.unit = 'deg';

			this.transform('rotateX', passedPercents, actionData);
		}
	}, {
		key: 'rotateY',
		value: function rotateY(actionData, passedPercents) {
			actionData.axis = 'y';
			actionData.unit = 'deg';

			this.transform('rotateY', passedPercents, actionData);
		}
	}, {
		key: 'rotateZ',
		value: function rotateZ(actionData, passedPercents) {
			actionData.unit = 'deg';

			this.transform('rotateZ', passedPercents, actionData);
		}
	}, {
		key: 'scale',
		value: function scale(actionData, passedPercents) {
			var movePoint = this.getDirectionMovePoint(passedPercents, actionData.direction, actionData.range);

			this.updateRulePart('transform', 'scale', 1 + actionData.speed * movePoint / 1000);
		}
	}, {
		key: 'transform',
		value: function transform(action, passedPercents, actionData) {
			if (actionData.direction) {
				passedPercents = 100 - passedPercents;
			}

			this.updateRulePart('transform', action, this.getStep(passedPercents, actionData) + actionData.unit);
		}
	}, {
		key: 'setCSSTransformVariables',
		value: function setCSSTransformVariables(elementSettings) {
			this.CSSTransformVariables = [];
			var self = this;

			jQuery.each(elementSettings, function(settingKey, settingValue) {
				var transformKeyMatches = settingKey.match(/_transform_(.+?)_effect/m);

				if (transformKeyMatches && settingValue) {
					if ('perspective' === transformKeyMatches[1]) {
						self.CSSTransformVariables.unshift(transformKeyMatches[1]);
						return;
					}

					if (self.CSSTransformVariables.includes(transformKeyMatches[1])) {
						return;
					}

					self.CSSTransformVariables.push(transformKeyMatches[1]);
				}
			});
		}
	}, {
		key: 'opacity',
		value: function opacity(actionData, passedPercents) {
			var movePoint = this.getDirectionMovePoint(passedPercents, actionData.direction, actionData.range),
			    level = actionData.level / 10,
			    opacity = 1 - level + this.getEffectValueFromMovePoint(level, movePoint);

			this.$element.css('opacity', opacity);
		}
	}, {
		key: 'blur',
		value: function blur(actionData, passedPercents) {
			var movePoint = this.getDirectionMovePoint(passedPercents, actionData.direction, actionData.range),
			    blur = actionData.level - this.getEffectValueFromMovePoint(actionData.level, movePoint);

			this.updateRulePart('filter', 'blur', blur + 'px');
		}
	}, {
		key: 'updateRulePart',
		value: function updateRulePart(ruleName, key, value) {
			if (!this.rulesVariables[ruleName]) {
				this.rulesVariables[ruleName] = {};
			}

			if (!this.rulesVariables[ruleName][key]) {
				this.rulesVariables[ruleName][key] = true;

				this.updateRule(ruleName);
			}

			var cssVarKey = '--' + key;

			this.$element[0].style.setProperty(cssVarKey, value);
		}
	}, {
		key: 'updateRule',
		value: function updateRule(ruleName) {
			var value = '';
			value += this.concatTransformCSSProperties(ruleName);

			jQuery.each(this.rulesVariables[ruleName], function (variableKey) {
				value += variableKey + '(var(--' + variableKey + '))';
			});

			this.$element.css(ruleName, value);
		}
	}, {
		key: 'concatTransformCSSProperties',
		value: function concatTransformCSSProperties(ruleName) {
			var value = '';

			if ('transform' === ruleName) {
				jQuery.each(this.CSSTransformVariables, function(index, variableKey) {
					var variableName = variableKey;

					if (variableKey.startsWith('flip')) {
						variableKey = variableKey.replace('flip', 'scale');
					} // Adding default value because of the hover state. if there is no default the transform will break.

					var defaultUnit = variableKey.startsWith('rotate') || variableKey.startsWith('skew') ? 'deg' : 'px',
						defaultValue = variableKey.startsWith('scale') ? 1 : 0 + defaultUnit;
					value += variableKey + '(var(--e-transform-' + variableName + ', ' + defaultValue + '))';
				});
			}

			return value;
		}
	}, {
		key: 'runAction',
		value: function runAction(actionName, actionData, passedPercents) {
			if (actionData.affectedRange) {
				if (actionData.affectedRange.start > passedPercents) {
					passedPercents = actionData.affectedRange.start;
				}

				if (actionData.affectedRange.end < passedPercents) {
					passedPercents = actionData.affectedRange.end;
				}
			}

			for (var _len = arguments.length, args = Array(_len > 3 ? _len - 3 : 0), _key = 3; _key < _len; _key++) {
				args[_key - 3] = arguments[_key];
			}

			this[actionName].apply(this, [actionData, passedPercents].concat(args));
		}
	}, {
		key: 'refresh',
		value: function refresh() {
			this.rulesVariables = {};
			this.CSSTransformVariables = [];
			this.$element.css({
				transform: '',
				filter: '',
				opacity: ''
			});
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			this.$element = this.getSettings('$targetElement');

			this.refresh();
		}
	}]);

	return _class;
}(elementorModules.Module);

exports.default = _class;

/***/ }),

/***/ 100:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Countdown = function( $countdown, endTime, actions, $expireMessage, $ ) {
	var timeInterval,
		elements = {
			$daysSpan: $countdown.find( '.elementor-countdown-days' ),
			$hoursSpan: $countdown.find( '.elementor-countdown-hours' ),
			$minutesSpan: $countdown.find( '.elementor-countdown-minutes' ),
			$secondsSpan: $countdown.find( '.elementor-countdown-seconds' )
		};

	var updateClock = function() {
		var timeRemaining = Countdown.getTimeRemaining( endTime );

		$.each( timeRemaining.parts, function( timePart ) {
			var $element = elements[ '$' + timePart + 'Span' ],
				partValue = this.toString();

			if ( 1 === partValue.length ) {
				partValue = 0 + partValue;
			}

			if ( $element.length ) {
				$element.text( partValue );
			}
		} );

		if ( timeRemaining.total <= 0 ) {
			clearInterval( timeInterval );
			runActions();
		}
	};

	var initializeClock = function() {
		timeInterval = setInterval( updateClock, 1000 );

		updateClock();
	};

	var runActions = function() {
		$countdown.trigger( 'countdown_expire', $countdown );

		if ( !actions ) {
			return;
		}

		actions.forEach( function(action) {
			switch ( action.type ) {
				case 'hide':
					$countdown.hide();
					break;

				case 'redirect':
					if ( action.redirect_url && !ceFrontend.isEditMode() ) {
						action.redirect_is_external
							? window.open(action.redirect_url)
							: window.location.href = action.redirect_url
						;
					}
					break;

				case 'message':
					$expireMessage.show();
					break;
			}
		} );
	};

	initializeClock();
};

Countdown.getTimeRemaining = function( endTime ) {
	var timeRemaining = endTime - new Date(),
		seconds = Math.floor( ( timeRemaining / 1000 ) % 60 ),
		minutes = Math.floor( ( timeRemaining / 1000 / 60 ) % 60 ),
		hours = Math.floor( ( timeRemaining / ( 1000 * 60 * 60 ) ) % 24 ),
		days = Math.floor( timeRemaining / ( 1000 * 60 * 60 * 24 ) );

	if ( days < 0 || hours < 0 || minutes < 0 ) {
		seconds = minutes = hours = days = 0;
	}

	return {
		total: timeRemaining,
		parts: {
			days: days,
			hours: hours,
			minutes: minutes,
			seconds: seconds
		}
	};
};

module.exports = function( $scope, $ ) {
	var $element = $scope.find( '.elementor-countdown-wrapper' ),
		date = new Date( $element.data( 'date' ) * 1000 ),
		actions = $element.data( 'expire-actions' ),
		$expireMessage = $scope.find( '.elementor-countdown-expire--message' );

	new Countdown( $element, date, actions, $expireMessage, $ );
};

/***/ }),

/***/ 108:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


if (jQuery.fn.smartmenus) {
	// Override the default stupid detection
	jQuery.SmartMenus.prototype.isCSSOn = function () {
		return true;
	};
}

var MenuHandler = elementorModules.frontend.handlers.Base.extend({

	stretchElement: null,

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				menu: '.elementor-nav',
				anchorLink: '.elementor-nav--main .elementor-item-anchor',
				mainMenu: '.elementor-nav__container.elementor-nav--main',
				dropdownMenu: '.elementor-nav__container.elementor-nav--dropdown',
				menuToggle: '.elementor-menu-toggle'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
			elements = {};

		elements.$menu = this.$element.find(selectors.menu);
		elements.$anchorLink = this.$element.find(selectors.anchorLink);
		elements.$mainMenu = this.$element.find(selectors.mainMenu);
		elements.$dropdownMenu = this.$element.find(selectors.dropdownMenu);
		elements.$dropdownMenuFinalItems = elements.$dropdownMenu.find('.menu-item:not(.menu-item-has-children) > a');
		elements.$menuToggle = this.$element.find(selectors.menuToggle);

		return elements;
	},

	bindEvents: function bindEvents() {
		if (!this.elements.$menu.length) {
			return;
		}

		this.elements.$menuToggle.on('click', this.toggleMenu.bind(this));

		if (this.getElementSettings('full_width')) {
			this.elements.$dropdownMenuFinalItems.on('click', this.toggleMenu.bind(this, false));
		}

		ceFrontend.addListenerOnce(this.$element.data('model-cid'), 'resize', this.stretchMenu);
	},

	initStretchElement: function initStretchElement() {
		this.stretchElement = new elementorModules.frontend.tools.StretchElement({ element: this.elements.$dropdownMenu });
	},

	toggleMenu: function toggleMenu(show) {
		var isDropdownVisible = this.elements.$menuToggle.hasClass('elementor-active');

		if ('boolean' !== typeof show) {
			show = !isDropdownVisible;
		}

		this.elements.$menuToggle.toggleClass('elementor-active', show);

		if (show && this.getElementSettings('full_width')) {
			this.stretchElement.stretch();
		}
	},

	followMenuAnchors: function followMenuAnchors() {
		var self = this;

		self.elements.$anchorLink.each(function () {
			if (location.pathname === this.pathname && '' !== this.hash) {
				self.followMenuAnchor(jQuery(this));
			}
		});
	},

	followMenuAnchor: function followMenuAnchor($element) {
		var anchorSelector = $element[0].hash;

		var offset = -300,
			$anchor = void 0;

		try {
			// `decodeURIComponent` for UTF8 characters in the hash.
			$anchor = jQuery(decodeURIComponent(anchorSelector));
		} catch (e) {
			return;
		}

		if (!$anchor.length) {
			return;
		}

		if (!$anchor.hasClass('elementor-menu-anchor')) {
			var halfViewport = jQuery(window).height() / 2;
			offset = -$anchor.outerHeight() + halfViewport;
		}

		ceFrontend.waypoint($anchor, function (direction) {
			if ('down' === direction) {
				$element.addClass('elementor-item-active');
			} else {
				$element.removeClass('elementor-item-active');
			}
		}, { offset: '50%', triggerOnce: false });

		ceFrontend.waypoint($anchor, function (direction) {
			if ('down' === direction) {
				$element.removeClass('elementor-item-active');
			} else {
				$element.addClass('elementor-item-active');
			}
		}, { offset: offset, triggerOnce: false });
	},

	stretchMenu: function stretchMenu() {
		if (this.getElementSettings('full_width')) {
			this.stretchElement.stretch();

			this.elements.$dropdownMenu.css('top', this.elements.$menuToggle.outerHeight());
		} else {
			this.stretchElement.reset();
		}
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		if (!this.elements.$menu.length) {
			return;
		}
		var align = this.getElementSettings('align_submenu'),
			noMouseOver = 'click' === this.getElementSettings('show_submenu_on');

		this.elements.$menu.smartmenus({
			subIndicators: false,
			subIndicatorsPos: 'append',
			subMenusMaxWidth: '1000px',
			noMouseOver: noMouseOver,
			rightToLeftSubMenus: align ? 'right' === align : ceFrontend.config.is_rtl
		});

		if (noMouseOver) {
			this.elements.$mainMenu.filter('.elementor-langs, .elementor-currencies, .elementor-sign-in').children()
				.on('click', 'a.elementor-item.has-submenu.highlighted', function (event) {
					// Close submenu on 2nd click
					this.elements.$menu.smartmenus('menuHide', jQuery(event.currentTarget).next());
					event.currentTarget.blur();
					event.preventDefault();
				}.bind(this))
			;
		}

		if ('accordion' === this.getElementSettings('animation_dropdown')) {
			// Trick for accordion mobile menu
			var $accordion = this.elements.$dropdownMenu.children().on('click.ce', 'a.has-submenu', function () {
				var $ul = jQuery(this.parentNode).siblings().children('a.highlighted').next();

				$ul.length && $accordion.smartmenus('menuHide', $ul);
			});
		}

		this.initStretchElement();

		this.stretchMenu();

		if (!ceFrontend.isEditMode()) {
			this.followMenuAnchors();
		}
	},

	onElementChange: function onElementChange(propertyName) {
		if ('full_width' === propertyName) {
			this.stretchMenu();
		}
	}
});

module.exports = function ($scope) {
	new MenuHandler({ $element: $scope });
};

/***/ }),

/***/ 122:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var AjaxSearchHandler = elementorModules.frontend.handlers.Base.extend({

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				wrapper: '.elementor-search',
				container: '.elementor-search__container',
				icon: '.elementor-search__icon',
				input: '.elementor-search__input',
				clear: '.elementor-search__clear',
				toggle: '.elementor-search__toggle',
				submit: '.elementor-search__submit',
				closeButton: '.dialog-close-button'
			},
			classes: {
				isFocus: 'elementor-search--focus',
				isTopbar: 'elementor-search--topbar',
				lightbox: 'elementor-lightbox'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
			elements = {};

		elements.$wrapper = this.$element.find(selectors.wrapper);
		elements.$container = this.$element.find(selectors.container);
		elements.$input = this.$element.find(selectors.input);
		elements.$clear = this.$element.find(selectors.clear);
		elements.$icon = this.$element.find(selectors.icon);
		elements.$toggle = this.$element.find(selectors.toggle);
		elements.$submit = this.$element.find(selectors.submit);
		elements.$closeButton = this.$element.find(selectors.closeButton);

		return elements;
	},

	bindEvents: function bindEvents() {
		var self = this,
			$container = self.elements.$container,
			$closeButton = self.elements.$closeButton,
			$input = self.elements.$input,
			$clear = self.elements.$clear,
			$wrapper = self.elements.$wrapper,
			$icon = self.elements.$icon,
			skin = this.getElementSettings('skin'),
			classes = this.getSettings('classes');

		$input.one('focus', $.proxy(this, 'loadAutocomplete'));

		$clear.on('click', function () {
			$input.val('').triggerHandler('keydown');
			$clear.css({
				visibility: '',
				pointerEvents: '',
			});
		});

		$input.on('input', function () {
			var empty = !$input.val();

			$clear.css({
				visibility: empty ? '' : 'visible',
				pointerEvents: empty ? '' : 'all',
			});
		});

		if ('topbar' === skin) {
			// Activate topbar mode on click
			self.elements.$toggle.on('click', function () {
				$container.toggleClass(classes.isTopbar).toggleClass(classes.lightbox);
				$input.focus();
			});

			$closeButton.on('click', function () {
				$container.removeClass(classes.isTopbar).removeClass(classes.lightbox);
			});
			// Deactivate topbar mode on click or on esc.
			ceFrontend.elements.$document.keyup(function (event) {
				var ESC_KEY = 27;

				if (ESC_KEY === event.keyCode) {
					if ($container.hasClass(classes.isTopbar)) {
						$container.click();
					}
				}
			}).on('click', function (event) {
				if ($container.hasClass(classes.isTopbar) && !$(event.target).closest($wrapper).length) {
					$container.removeClass(classes.isTopbar).removeClass(classes.lightbox);
				}
			});
		} else {
			// Apply focus style on wrapper element when input is focused
			$input.on({
				focus: function focus() {
					$wrapper.addClass(classes.isFocus);
				},
				blur: function blur() {
					$wrapper.removeClass(classes.isFocus);
				}
			});
		}

		if ('minimal' === skin) {
			// Apply focus style on wrapper element when icon is clicked in minimal skin
			$icon.on('click', function () {
				$wrapper.addClass(classes.isFocus);
				$input.focus();
			});
		}
	},

	loadAutocomplete: function loadAutocomplete() {
		var baseDir = window.baseDir || prestashop.urls.base_url,
			include = $.ui ? ($.ui.autocomplete ? '' : 'jquery.ui.autocomplete') : 'jquery-ui';

		if (include) {
			$('<link rel="stylesheet">').attr({
				href: baseDir + 'js/jquery/ui/themes/base/minified/' + include + '.min.css'
			}).appendTo(document.head);

			if ('jquery-ui' === include) {
				$('<link rel="stylesheet">').attr({
					href: baseDir + 'js/jquery/ui/themes/base/minified/jquery.ui.theme.min.css'
				}).appendTo(document.head);
			}
			$.ajax({
				url: baseDir + 'js/jquery/ui/' + include + '.min.js',
				cache: true,
				dataType: 'script',
				success: $.proxy(this, 'initAutocomplete')
			});
		} else {
			this.initAutocomplete();
		}
	},

	initAutocomplete: function initAutocomplete() {
		$.fn.ceAjaxSearch || $.widget('ww.ceAjaxSearch', $.ui.autocomplete, {
			_create: function () {
				this._super();
				this.menu.element.addClass('elementor-search__products');
				this.element.on('focus' + this.eventNamespace, $.proxy(this, '_openOnFocus'))
				$(document).on('click' + this.eventNamespace, $.proxy(this, '_closeOnDocumentClick'));

				// Don't close on blur
				this._off(this.element, 'blur');
				// Trick for disable auto-scrolling on hover
				this.menu.element.outerHeight = function() {
					if (window.event && 'mouseover' === event.type) {
						return Infinity;
					}
					return $.fn.outerHeight.apply(this, arguments);
				};
			},

			_openOnFocus: function (event) {
				this.menu.element.show();
				this._resizeMenu();
				this.menu.element.position(
					$.extend({of: this.element}, this.options.position)
				);
			},

			_closeOnDocumentClick: function (event) {
				$(event.target).closest(this.options.appendTo).length || this._close();
			},

			search: function (value, event) {
				value = value != null ? value : this._value();
				this._super(value, event);

				if (value.length < this.options.minLength) {
					// Clear previous results
					this.menu.element.empty();
				}
			},

			_renderItem: function (ul, prod) {
				var es = this.options.elementSettings,
					cover = prod.cover && prod.cover.small.url || prestashop.urls.img_prod_url + prestashop.language.iso_code + '-default-small_default.jpg';

				return $('<li class="elementor-search__product">').html(
					'<a class="elementor-search__product-link" href="' + encodeURI(prod.url) + '">' +
						(es.show_image ? '<img class="elementor-search__product-image" src="' + encodeURI(cover) + '" alt="' + prod.name.replace(/"/g, '&quot;') + '">' : '') +
						'<div class="elementor-search__product-details">' +
							'<div class="elementor-search__product-name">' + prod.name + '</div>' +
							(es.show_category ? '<div class="elementor-search__product-category">' + prod.category_name + '</div>' : '') +
							(es.show_description ? '<div class="elementor-search__product-description">' + (prod.description_short || '').replace(/<\/?\w+.*?>/g, '') + '</div>' : '') +
							(es.show_price ? '<div class="elementor-search__product-price">' + (prod.has_discount ? '<del>' + prod.regular_price + '</del> ' : '') + prod.price + '</div>' : '') +
						'</div>' +
					'</a>'
				).appendTo(ul);
			},

			_resizeMenu: function () {
				this._super();
				this.options.position.my = 'left top+' + this.menu.element.css('margin-top');

				setTimeout(function () {
					this.menu.element.css({
						maxHeight: 'calc(100vh - ' + (this.menu.element.offset().top - $(window).scrollTop())  + 'px)',
						overflowY: 'auto',
						WebkitOverflowScrolling: 'touch',
					});
				}.bind(this), 1);
			},
		});
		var action = this.elements.$wrapper.prop('action'),
			searchName = this.elements.$input.prop('name');

		this.elements.$input.ceAjaxSearch({
			appendTo: 'topbar' === this.getElementSettings('skin')
				? this.elements.$container
				: this.elements.$wrapper
			,
			minLength: 3,
			elementSettings: this.getElementSettings(),

			source: function (query, response) {
				var data = {
					ajax: true,
					resultsPerPage: this.options.elementSettings.list_limit || 10,
				};
				data[searchName] = query.term;

				$.post(action, data, null, 'json')
					.then(function (resp) {
						response(resp.products);
					})
					.fail(response)
				;
			},

			select: function (event, ui) {
				if (location.href !== ui.item.url && !ceFrontend.isEditMode()) {
					location.href = ui.item.url;
				};
			},
		});
	}
});

module.exports = function ($scope) {
	new AjaxSearchHandler({ $element: $scope });
};

/***/ }),
/***/ 123:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var AnimatedHeadlineHandler = elementorModules.frontend.handlers.Base.extend({
	svgPaths: {
		circle: ['M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7'],
		underline_zigzag: ['M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9'],
		x: ['M497.4,23.9C301.6,40,155.9,80.6,4,144.4', 'M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7'],
		strikethrough: ['M3,75h493.5'],
		curly: ['M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6'],
		diagonal: ['M13.5,15.5c131,13.7,289.3,55.5,475,125.5'],
		double: ['M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2', 'M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8'],
		double_underline: ['M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6', 'M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4'],
		underline: ['M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7']
	},

	getDefaultSettings: function getDefaultSettings() {
		var settings = {
			animationDelay: 2500,
			//letters effect
			lettersDelay: 50,
			//typing effect
			typeLettersDelay: 150,
			selectionDuration: 500,
			//clip effect
			revealDuration: 600,
			revealAnimationDelay: 1500
		};

		settings.typeAnimationDelay = settings.selectionDuration + 800;

		settings.selectors = {
			headline: '.elementor-headline',
			dynamicWrapper: '.elementor-headline-dynamic-wrapper'
		};

		settings.classes = {
			dynamicText: 'elementor-headline-dynamic-text',
			dynamicLetter: 'elementor-headline-dynamic-letter',
			textActive: 'elementor-headline-text-active',
			textInactive: 'elementor-headline-text-inactive',
			letters: 'elementor-headline-letters',
			animationIn: 'elementor-headline-animation-in',
			typeSelected: 'elementor-headline-typing-selected'
		};

		return settings;
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		return {
			$headline: this.$element.find(selectors.headline),
			$dynamicWrapper: this.$element.find(selectors.dynamicWrapper)
		};
	},

	getNextWord: function getNextWord($word) {
		return $word.is(':last-child') ? $word.parent().children().eq(0) : $word.next();
	},

	switchWord: function switchWord($oldWord, $newWord) {
		$oldWord.removeClass('elementor-headline-text-active').addClass('elementor-headline-text-inactive');

		$newWord.removeClass('elementor-headline-text-inactive').addClass('elementor-headline-text-active');
	},

	singleLetters: function singleLetters() {
		var classes = this.getSettings('classes');

		this.elements.$dynamicText.each(function () {
			var $word = jQuery(this),
			    letters = $word.text().split(''),
			    isActive = $word.hasClass(classes.textActive);

			$word.empty();

			letters.forEach(function (letter) {
				var $letter = jQuery('<span>', { class: classes.dynamicLetter }).text(letter);

				if (isActive) {
					$letter.addClass(classes.animationIn);
				}

				$word.append($letter);
			});

			$word.css('opacity', 1);
		});
	},

	showLetter: function showLetter($letter, $word, bool, duration) {
		var self = this,
		    classes = this.getSettings('classes');

		$letter.addClass(classes.animationIn);

		if (!$letter.is(':last-child')) {
			setTimeout(function () {
				self.showLetter($letter.next(), $word, bool, duration);
			}, duration);
		} else if (!bool) {
			setTimeout(function () {
				self.hideWord($word);
			}, self.getSettings('animationDelay'));
		}
	},

	hideLetter: function hideLetter($letter, $word, bool, duration) {
		var self = this,
		    settings = this.getSettings();

		$letter.removeClass(settings.classes.animationIn);

		if (!$letter.is(':last-child')) {
			setTimeout(function () {
				self.hideLetter($letter.next(), $word, bool, duration);
			}, duration);
		} else if (bool) {
			setTimeout(function () {
				self.hideWord(self.getNextWord($word));
			}, self.getSettings('animationDelay'));
		}
	},

	showWord: function showWord($word, $duration) {
		var self = this,
		    settings = self.getSettings(),
		    animationType = self.getElementSettings('animation_type');

		if ('typing' === animationType) {
			self.showLetter($word.find('.' + settings.classes.dynamicLetter).eq(0), $word, false, $duration);

			$word.addClass(settings.classes.textActive).removeClass(settings.classes.textInactive);
		} else if ('clip' === animationType) {
			self.elements.$dynamicWrapper.animate({ width: $word.width() + 10 }, settings.revealDuration, function () {
				setTimeout(function () {
					self.hideWord($word);
				}, settings.revealAnimationDelay);
			});
		}
	},

	hideWord: function hideWord($word) {
		var self = this,
		    settings = self.getSettings(),
		    classes = settings.classes,
		    letterSelector = '.' + classes.dynamicLetter,
		    animationType = self.getElementSettings('animation_type'),
		    nextWord = self.getNextWord($word);

		if ('typing' === animationType) {
			self.elements.$dynamicWrapper.addClass(classes.typeSelected);

			setTimeout(function () {
				self.elements.$dynamicWrapper.removeClass(classes.typeSelected);

				$word.addClass(settings.classes.textInactive).removeClass(classes.textActive).children(letterSelector).removeClass(classes.animationIn);
			}, settings.selectionDuration);
			setTimeout(function () {
				self.showWord(nextWord, settings.typeLettersDelay);
			}, settings.typeAnimationDelay);
		} else if (self.elements.$headline.hasClass(classes.letters)) {
			var bool = $word.children(letterSelector).length >= nextWord.children(letterSelector).length;

			self.hideLetter($word.find(letterSelector).eq(0), $word, bool, settings.lettersDelay);

			self.showLetter(nextWord.find(letterSelector).eq(0), nextWord, bool, settings.lettersDelay);
		} else if ('clip' === animationType) {
			self.elements.$dynamicWrapper.animate({ width: '2px' }, settings.revealDuration, function () {
				self.switchWord($word, nextWord);
				self.showWord(nextWord);
			});
		} else {
			self.switchWord($word, nextWord);

			setTimeout(function () {
				self.hideWord(nextWord);
			}, settings.animationDelay);
		}
	},

	animateHeadline: function animateHeadline() {
		var self = this,
		    animationType = self.getElementSettings('animation_type'),
		    $dynamicWrapper = self.elements.$dynamicWrapper;

		if ('clip' === animationType) {
			$dynamicWrapper.width($dynamicWrapper.width() + 10);
		} else if ('typing' !== animationType) {
			//assign to .elementor-headline-dynamic-wrapper the width of its longest word
			var width = 0;

			self.elements.$dynamicText.each(function () {
				var wordWidth = jQuery(this).width();

				if (wordWidth > width) {
					width = wordWidth;
				}
			});

			$dynamicWrapper.css('width', width);
		}

		//trigger animation
		setTimeout(function () {
			self.hideWord(self.elements.$dynamicText.eq(0));
		}, self.getSettings('animationDelay'));
	},

	getSvgPaths: function getSvgPaths(pathName) {
		var pathsInfo = this.svgPaths[pathName],
		    $paths = jQuery();

		pathsInfo.forEach(function (pathInfo) {
			$paths = $paths.add(jQuery('<path>', { d: pathInfo }));
		});

		return $paths;
	},

	fillWords: function fillWords() {
		var elementSettings = this.getElementSettings(),
		    classes = this.getSettings('classes'),
		    $dynamicWrapper = this.elements.$dynamicWrapper;

		if ('rotate' === elementSettings.headline_style) {
			var rotatingText = (elementSettings.rotating_text || '').split('\n');

			rotatingText.forEach(function (word, index) {
				var $dynamicText = jQuery('<span>', { class: classes.dynamicText }).html(word.replace(/ /g, '&nbsp;'));

				if (!index) {
					$dynamicText.addClass(classes.textActive);
				}

				$dynamicWrapper.append($dynamicText);
			});
		} else {
			var $dynamicText = jQuery('<span>', { class: classes.dynamicText + ' ' + classes.textActive }).text(elementSettings.highlighted_text),
			    $svg = jQuery('<svg>', {
				xmlns: 'http://www.w3.org/2000/svg',
				viewBox: '0 0 500 150',
				preserveAspectRatio: 'none'
			}).html(this.getSvgPaths(elementSettings.marker));

			$dynamicWrapper.append($dynamicText, $svg[0].outerHTML);
		}

		this.elements.$dynamicText = $dynamicWrapper.children('.' + classes.dynamicText);
	},

	rotateHeadline: function rotateHeadline() {
		var settings = this.getSettings();

		//insert <span> for each letter of a changing word
		if (this.elements.$headline.hasClass(settings.classes.letters)) {
			this.singleLetters();
		}

		//initialise headline animation
		this.animateHeadline();
	},

	initHeadline: function initHeadline() {
		if ('rotate' === this.getElementSettings('headline_style')) {
			this.rotateHeadline();
		}
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.fillWords();

		this.initHeadline();
	}
});

module.exports = function( $scope, $ ) {
	new AnimatedHeadlineHandler({ $element: $scope });
};

/***/ }),
/***/ 124:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var ShoppingCart = elementorModules.frontend.handlers.Base.extend({

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				container: '.elementor-cart__container',
				toggle: '.elementor-cart__toggle .elementor-button',
				closeButton: '.elementor-cart__close-button'
			},
			classes: {
				isShown: 'elementor-cart--shown',
				lightbox: 'elementor-lightbox',
				isHidden: 'elementor-cart-hidden'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
			elements = {};

		elements.$container = this.$element.find(selectors.container);
		elements.$toggle = this.$element.find(selectors.toggle);
		elements.$closeButton = this.$element.find(selectors.closeButton);

		return elements;
	},

	bindEvents: function bindEvents() {
		var self = this,
			$ = jQuery,
			$container = self.elements.$container,
			$closeButton = self.elements.$closeButton,
			classes = this.getSettings('classes');

		// Activate topbar mode on click
		self.elements.$toggle.on('click', function (event) {
			if (!self.elements.$toggle.hasClass(classes.isHidden)) {
				event.preventDefault();
				$container.toggleClass(classes.isShown);
			}
		});

		// Deactivate topbar mode on click or on esc.
		$container.on('click', function (event) {
			if ($container.hasClass(classes.isShown) && $container[0] === event.target) {
				$container.removeClass(classes.isShown);
			}
		});

		$closeButton.on('click', function () {
			$container.removeClass(classes.isShown);
		});

		ceFrontend.elements.$document.keyup(function (event) {
			var ESC_KEY = 27;

			if (ESC_KEY === event.keyCode) {
				if ($container.hasClass(classes.isShown)) {
					$container.click();
				}
			}
		});

		$container.on('click', '.elementor-cart__product-remove a', function (event) {
			var dataset = $(this).data();
				dataset.linkAction = 'delete-from-cart';

			$(this).closest('.elementor-cart__product').addClass('ce-disabled');

			event.preventDefault();

			$.ajax({
				url: this.href,
				method: 'POST',
				dataType: 'json',
				data: {
					ajax: 1,
					action: 'update',
				},
			}).then(function (resp) {
				prestashop.emit('updateCart', {
					reason: dataset,
					resp: resp,
				});
			}).fail(function (resp) {
				prestashop.emit('handleError', {
					eventType: 'updateProductInCart',
					resp: resp,
					cartAction: dataset.linkAction,
				});
			});
		});

		prestashop.on('updateCart', function(data) {
			if (!data || !data.resp || !data.resp.cart) {
				return;
			}
			var cart = data.resp.cart,
				gift = $container.find('.elementor-cart__products').data('gift'),
				$products = $();

			// Show ps_shoppingcart modal on update
			if (self.getElementSettings('action_show_modal') && 'add-to-cart' === data.reason.linkAction && !data.resp.hasError) {
				ShoppingCart.xhr && ShoppingCart.xhr.abort();
				ShoppingCart.xhr = $.post(
					self.getElementSettings('modal_url'),
					{
						ajax: true,
						action: 'addToCartModal',
						id_product: data.reason.idProduct,
						id_product_attribute: data.reason.idProductAttribute,
						id_customization: data.reason.idCustomization,
					},
					function (resp) {
						$('#blockcart-modal').remove();
						$(document.body).append(resp.modal).children('#blockcart-modal').modal();
					},
					'json'
				);
			}

			// Update toggle
			self.elements.$toggle.find('.elementor-button-text')
				.html(cart['subtotals']['products']['value'])
			;
			self.elements.$toggle.find('.elementor-button-icon')
				.attr('data-counter', cart['products_count'])
				.data('counter', cart['products_count'])
			;
			// Update products
			cart.products.forEach(function (product) {
				var $prod = $(
						'<div class="elementor-cart__product">' +
							'<div class="elementor-cart__product-image"></div>' +
							'<div class="elementor-cart__product-name">' +
								'<div class="elementor-cart__product-attrs"></div>' +
							'</div>' +
							'<div class="elementor-cart__product-price"></div>' +
							'<div class="elementor-cart__product-remove ceicon-times"></div>' +
						'</div>'
					),
					$attrs = $prod.find('.elementor-cart__product-attrs'),
					cover = product.cover || prestashop.urls.no_picture_image;

				if (product.embedded_attributes && product.embedded_attributes.id_image) {
					// PS 1.7.8 fix - product.cover contains wrong image
					var i, id_cover = product.embedded_attributes.id_image.split('-').pop();
					for (i = 0; i < product.images.length; i++) {
						if (id_cover == product.images[i].id_image) {
							cover = product.images[i];
							break;
						}
					}
				}

				$('<img>').appendTo($prod.find('.elementor-cart__product-image')).attr({
					src: cover.bySize.cart_default && cover.bySize.cart_default.url || cover.small.url,
					alt: cover.legend,
				});
				$('<a>').prependTo($prod.find('.elementor-cart__product-name'))
					.attr('href', product['url'])
					.html(product['name'])
				;
				// Add product attributes
				for (var label in product['attributes']) {
					$('<div class="elementor-cart__product-attr">').html(
						'<span class="elementor-cart__product-attr-label">' + label + ':</span> ' +
						'<span class="elementor-cart__product-attr-value">' + product['attributes'][label] + '</span>'
					).appendTo($attrs);
				}
				// Add product customizations
				product.customizations && product.customizations.forEach(function (customization) {
					customization.fields.forEach(function (field) {
						$('<div class="elementor-cart__product-attr">').html(
							'<span class="elementor-cart__product-attr-label">' + field['label'] + ':</span> ' +
							'<span class="elementor-cart__product-attr-value">' +
								('image' === field['type'] ? $('<img>').attr('src', field['image']['small']['url'])[0].outerHTML : field['text']) +
							'</span>'
						).appendTo($attrs);
					});
				});
				$prod.find('.elementor-cart__product-price').html(
					'<span class="elementor-cart__product-quantity">' + product['quantity'] + '</span> &times; ' + (product['is_gift'] ? gift : product['price']) + ' '
				).append(product['has_discount'] ? $('<del>').html(product['regular_price']) : []);

				$('<a>').appendTo($prod.find('.elementor-cart__product-remove')).attr({
					href: product['remove_from_cart_url'],
					rel: 'nofollow',
					'data-id-product': product['id_product'],
					'data-id-product-attribute': product['id_product_attribute'],
					'data-id-customization': product['id_customization'],
				}).data({
					'idProduct': product['id_product'],
					'idProductAttribute': product['id_product_attribute'],
					'idCustomization': product['id_customization'],
				});
				$products.push($prod[0]);
			});
			// Update cart
			$container.find('.elementor-cart__products')
				.empty()
				.append($products)
			;
			$container.find('.elementor-cart__empty-message')
				.toggleClass('elementor-hidden', !!cart['products_count'])
			;
			$container.find('.elementor-cart__summary').html(
				'<div class="elementor-cart__summary-label">' + cart['summary_string'] + '</div>' +
				'<div class="elementor-cart__summary-value">' + cart['subtotals']['products']['value'] + '</div>' +
				'<span class="elementor-cart__summary-label">' + cart['subtotals']['shipping']['label'] + '</span>' +
				'<span class="elementor-cart__summary-value">' + cart['subtotals']['shipping']['value'] + '</span>' +
				'<strong class="elementor-cart__summary-label">' + cart['totals']['total']['label'] + '</strong>' +
				'<strong class="elementor-cart__summary-value">' + cart['totals']['total']['value'] + '</strong>'
			);
			$container.find('.elementor-alert-warning')
				.toggleClass('elementor-hidden', !cart['minimalPurchaseRequired'])
				.html('<span class="elementor-alert-description">' + cart['minimalPurchaseRequired'] + '</span>');
			;
			$container.find('.elementor-button--checkout')
				.toggleClass('ce-disabled', cart['minimalPurchaseRequired'] || !cart['products_count'])
			;

			// Open shopping cart after updated
			if (self.getElementSettings('action_open_cart')) {
				self.elements.$container.hasClass(classes.isShown) || self.elements.$toggle.triggerHandler('click');
			}
		});
	}
});

module.exports = function ($scope) {
	new ShoppingCart({ $element: $scope });
};

/***/ }),

/***/ 182:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _documentsManager = __webpack_require__(183);

var _documentsManager2 = _interopRequireDefault(_documentsManager);

var _hotKeys = __webpack_require__(16);

var _hotKeys2 = _interopRequireDefault(_hotKeys);

var _storage = __webpack_require__(15);

var _storage2 = _interopRequireDefault(_storage);

var _environment = __webpack_require__(1);

var _environment2 = _interopRequireDefault(_environment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; } /* global ceFrontendConfig */


var EventManager = __webpack_require__(13),
	ElementsHandler = __webpack_require__(184),
	YouTubeModule = __webpack_require__(196),
	AnchorsModule = __webpack_require__(197),
	LightboxModule = __webpack_require__(198),
	LinkActionsModule = _interopRequireDefault(__webpack_require__(199)),
	MotionFXModule = _interopRequireDefault(__webpack_require__(90));

var Frontend = function (_elementorModules$Vie) {
	_inherits(Frontend, _elementorModules$Vie);

	function Frontend() {
		var _ref;

		_classCallCheck(this, Frontend);

		for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
			args[_key] = arguments[_key];
		}

		var _this = _possibleConstructorReturn(this, (_ref = Frontend.__proto__ || Object.getPrototypeOf(Frontend)).call.apply(_ref, [this].concat(args)));

		_this.config = ceFrontendConfig;
		return _this;
	}

	// TODO: BC since 2.5.0


	_createClass(Frontend, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				selectors: {
					elementor: '.elementor',
					adminBar: '#wpadminbar'
				},
				classes: {
					ie: 'elementor-msie'
				}
			};
		}
	}, {
		key: 'getDefaultElements',
		value: function getDefaultElements() {
			var defaultElements = {
				window: window,
				$window: jQuery(window),
				$document: jQuery(document),
				$head: jQuery(document.head),
				$body: jQuery(document.body),
				$deviceMode: jQuery('<span>', { id: 'elementor-device-mode', class: 'elementor-screen-only' })
			};
			defaultElements.$body.append(defaultElements.$deviceMode);

			return defaultElements;
		}
	}, {
		key: 'bindEvents',
		value: function bindEvents() {
			var _this2 = this;

			this.elements.$window.on('resize', function () {
				return _this2.setDeviceModeData();
			});
		}

		/**
   * @deprecated 2.4.0 Use just `this.elements` instead
   */

	}, {
		key: 'getElements',
		value: function getElements(elementName) {
			return this.getItems(this.elements, elementName);
		}

		/**
   * @deprecated 2.4.0 This method was never in use
   */

	}, {
		key: 'getPageSettings',
		value: function getPageSettings(settingName) {
			var settingsObject = this.isEditMode() ? elementor.settings.page.model.attributes : this.config.settings.page;

			return this.getItems(settingsObject, settingName);
		}
	}, {
		key: 'getGeneralSettings',
		value: function getGeneralSettings(settingName) {
			var settingsObject = this.isEditMode() ? elementor.settings.general.model.attributes : this.config.settings.general;

			return this.getItems(settingsObject, settingName);
		}
	}, {
		key: 'getCurrentDeviceMode',
		value: function getCurrentDeviceMode() {
			return getComputedStyle(this.elements.$deviceMode[0], ':after').content.replace(/"/g, '');
		}
	}, {
		key: 'getCurrentDeviceSetting',
		value: function getCurrentDeviceSetting(settings, settingKey) {
			var devices = ['desktop', 'tablet', 'mobile'],
				currentDeviceMode = ceFrontend.getCurrentDeviceMode();

			var currentDeviceIndex = devices.indexOf(currentDeviceMode);

			while (currentDeviceIndex > 0) {
				var currentDevice = devices[currentDeviceIndex],
					fullSettingKey = settingKey + '_' + currentDevice,
					deviceValue = settings[fullSettingKey];

				if (deviceValue) {
					return deviceValue;
				}

				currentDeviceIndex--;
			}

			return settings[settingKey];
		}
	}, {
		key: 'isEditMode',
		value: function isEditMode() {
			return this.config.environmentMode.edit;
		}
	}, {
		key: 'isWPPreviewMode',
		value: function isWPPreviewMode() {
			return this.config.environmentMode.wpPreview;
		}
	}, {
		key: 'initDialogsManager',
		value: function initDialogsManager() {
			var dialogsManager = void 0;

			this.getDialogsManager = function () {
				if (!dialogsManager) {
					dialogsManager = new DialogsManager.Instance();
				}

				return dialogsManager;
			};
		}
	}, {
		key: 'initHotKeys',
		value: function initHotKeys() {
			this.hotKeys = new _hotKeys2.default();

			this.hotKeys.bindListener(this.elements.$window);
		}
	}, {
		key: 'initOnReadyComponents',
		value: function initOnReadyComponents() {
			this.utils = {
				youtube: new YouTubeModule(),
				anchors: new AnchorsModule(),
				lightbox: new LightboxModule()
			};

			// TODO: BC since 2.4.0
			// this.modules = {
			// 	StretchElement: elementorModules.frontend.tools.StretchElement,
			// 	Masonry: elementorModules.utils.Masonry
			// };

			this.elementsHandler = new ElementsHandler(jQuery);

			this.documentsManager = new _documentsManager2.default();

			this.trigger('components:init');
		}
	}, {
		key: 'initOnReadyElements',
		value: function initOnReadyElements() {
			this.elements.$wpAdminBar = this.elements.$document.find(this.getSettings('selectors.adminBar'));
		}
	}, {
		key: 'addIeCompatibility',
		value: function addIeCompatibility() {
			var el = document.createElement('div'),
				supportsGrid = 'string' === typeof el.style.grid;

			if (!_environment2.default.ie && supportsGrid) {
				return;
			}

			this.elements.$body.addClass(this.getSettings('classes.ie'));

			var msieCss = '<link rel="stylesheet" id="elementor-frontend-css-msie" href="' + this.config.urls.assets + 'css/frontend-msie.min.css?' + this.config.version + '" type="text/css" />';

			this.elements.$body.append(msieCss);
		}
	}, {
		key: 'setDeviceModeData',
		value: function setDeviceModeData() {
			this.elements.$body.attr('data-elementor-device-mode', this.getCurrentDeviceMode());
		}
	}, {
		key: 'addListenerOnce',
		value: function addListenerOnce(listenerID, event, callback, to) {
			if (!to) {
				to = this.elements.$window;
			}

			if (!this.isEditMode()) {
				to.on(event, callback);

				return;
			}

			this.removeListeners(listenerID, event, to);

			if (to instanceof jQuery) {
				var eventNS = event + '.' + listenerID;

				to.on(eventNS, callback);
			} else {
				to.on(event, callback, listenerID);
			}
		}
	}, {
		key: 'removeListeners',
		value: function removeListeners(listenerID, event, callback, from) {
			if (!from) {
				from = this.elements.$window;
			}

			if (from instanceof jQuery) {
				var eventNS = event + '.' + listenerID;

				from.off(eventNS, callback);
			} else {
				from.off(event, callback, listenerID);
			}
		}

		// Based on underscore function

	}, {
		key: 'debounce',
		value: function debounce(func, wait) {
			var timeout = void 0;

			return function () {
				var context = this,
					args = arguments;

				var later = function later() {
					timeout = null;

					func.apply(context, args);
				};

				var callNow = !timeout;

				clearTimeout(timeout);

				timeout = setTimeout(later, wait);

				if (callNow) {
					func.apply(context, args);
				}
			};
		}
	}, {
		key: 'waypoint',
		value: function waypoint($element, callback, options) {
			var defaultOptions = {
				offset: '100%',
				triggerOnce: true
			};

			options = jQuery.extend(defaultOptions, options);

			var correctCallback = function correctCallback() {
				var element = this.element || this,
					result = callback.apply(element, arguments);

				// If is Waypoint new API and is frontend
				if (options.triggerOnce && this.destroy) {
					this.destroy();
				}

				return result;
			};

			return $element.elementorWaypoint
				? $element.elementorWaypoint(correctCallback, options)
				: $element.waypoint(correctCallback, options)
			;
		}
	}, {
		key: 'muteMigrationTraces',
		value: function muteMigrationTraces() {
			jQuery.migrateMute = true;

			jQuery.migrateTrace = false;
		}
	}, {
		key: 'init',
		value: function init() {
			this.hooks = new EventManager();

			this.storage = new _storage2.default();

			this.addIeCompatibility();

			this.setDeviceModeData();

			this.initDialogsManager();

			if (this.isEditMode()) {
				this.muteMigrationTraces();
			}

			this.modules = {
				linkActions: new LinkActionsModule.default(),
				motionFX: new MotionFXModule.default()
			};

			// Keep this line before `initOnReadyComponents` call
			this.elements.$window.trigger('elementor/frontend/init');

			if (!this.isEditMode()) {
				this.initHotKeys();
			}

			this.initOnReadyElements();

			this.initOnReadyComponents();
		}
	}, {
		key: 'Module',
		get: function get() {
			// if ( this.isEditMode() ) {
			// 	parent.elementorCommon.helpers.deprecatedMethod( 'ceFrontend.Module', '2.5.0', 'elementorModules.frontend.handlers.Base' );
			// }

			return elementorModules.frontend.handlers.Base;
		}
	}]);

	return Frontend;
}(elementorModules.ViewModule);

window.ceFrontend = new Frontend();

if (!ceFrontend.isEditMode()) {
	jQuery(function () {
		return ceFrontend.init();
	});
}

/***/ }),

/***/ 183:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _document = __webpack_require__(17);

var _document2 = _interopRequireDefault(_document);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Vie) {
	_inherits(_class, _elementorModules$Vie);

	function _class() {
		var _ref;

		_classCallCheck(this, _class);

		for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
			args[_key] = arguments[_key];
		}

		var _this = _possibleConstructorReturn(this, (_ref = _class.__proto__ || Object.getPrototypeOf(_class)).call.apply(_ref, [this].concat(args)));

		_this.documents = {};

		_this.initDocumentClasses();

		_this.attachDocumentsClasses();
		return _this;
	}

	_createClass(_class, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				selectors: {
					document: '.elementor'
				}
			};
		}
	}, {
		key: 'getDefaultElements',
		value: function getDefaultElements() {
			var selectors = this.getSettings('selectors');

			return {
				$documents: jQuery(selectors.document)
			};
		}
	}, {
		key: 'initDocumentClasses',
		value: function initDocumentClasses() {
			this.documentClasses = {
				base: _document2.default
			};

			ceFrontend.hooks.doAction('elementor/frontend/documents-manager/init-classes', this);
		}
	}, {
		key: 'addDocumentClass',
		value: function addDocumentClass(documentType, documentClass) {
			this.documentClasses[documentType] = documentClass;
		}
	}, {
		key: 'attachDocumentsClasses',
		value: function attachDocumentsClasses() {
			var _this2 = this;

			this.elements.$documents.each(function (index, document) {
				return _this2.attachDocumentClass(jQuery(document));
			});
		}
	}, {
		key: 'attachDocumentClass',
		value: function attachDocumentClass($document) {
			var documentData = $document.data(),
				documentID = documentData.elementorId,
				documentType = documentData.elementorType,
				DocumentClass = this.documentClasses[documentType] || this.documentClasses.base;

			this.documents[documentID] = new DocumentClass({
				$element: $document,
				id: documentID
			});
		}
	}]);

	return _class;
}(elementorModules.ViewModule);

exports.default = _class;

/***/ }),

/***/ 184:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($) {
	var self = this;

	// element-type.skin-type
	var handlers = {
		// Elements
		section: __webpack_require__(185),

		// Widgets
		'accordion.default': __webpack_require__(186),
		'alert.default': __webpack_require__(187),
		'counter.default': __webpack_require__(188),
		'countdown.default': __webpack_require__(100),
		'product-sale-countdown.default': __webpack_require__(100),
		'nav-menu.default': __webpack_require__(108),
		'language-selector.default': __webpack_require__(108),
		'currency-selector.default': __webpack_require__(108),
		'sign-in.default': __webpack_require__(108),
		'ajax-search.default': __webpack_require__(122),
		'animated-headline.default': __webpack_require__(123),
		'shopping-cart.default': __webpack_require__(124),
		'progress.default': __webpack_require__(189),
		'tabs.default': __webpack_require__(190),
		'toggle.default': __webpack_require__(191),
		'video.default': __webpack_require__(192),
		'image-carousel.default': __webpack_require__(193),
		'testimonial-carousel.default': __webpack_require__(193),
		'product-carousel.default': __webpack_require__(193),
		'trustedshops-reviews.default': __webpack_require__(193),
		'text-editor.default': __webpack_require__(194),
		'contact-form.default': __webpack_require__(200),
		'email-subscription.default': __webpack_require__(200),
		'product-images.default': __webpack_require__(202),
	};

	var handlersInstances = {};

	var addGlobalHandlers = function addGlobalHandlers() {
		ceFrontend.hooks.addAction('frontend/element_ready/global', __webpack_require__(195));
	};

	var addElementsHandlers = function addElementsHandlers() {
		$.each(handlers, function (elementName, funcCallback) {
			ceFrontend.hooks.addAction('frontend/element_ready/' + elementName, funcCallback);
		});

		// Sticky
		ceFrontend.hooks.addAction('frontend/element_ready/section', __webpack_require__(10));
		ceFrontend.hooks.addAction('frontend/element_ready/widget', __webpack_require__(10));
	};

	var init = function init() {
		self.initHandlers();
	};

	this.initHandlers = function () {
		addGlobalHandlers();

		addElementsHandlers();
	};

	this.addHandler = function (HandlerClass, options) {
		var elementID = options.$element.data('model-cid');

		var handlerID = void 0;

		// If element is in edit mode
		if (elementID) {
			handlerID = HandlerClass.prototype.getConstructorID();

			if (!handlersInstances[elementID]) {
				handlersInstances[elementID] = {};
			}

			var oldHandler = handlersInstances[elementID][handlerID];

			if (oldHandler) {
				oldHandler.onDestroy();
			}
		}

		var newHandler = new HandlerClass(options);

		if (elementID) {
			handlersInstances[elementID][handlerID] = newHandler;
		}
	};

	this.getHandlers = function (handlerName) {
		if (handlerName) {
			return handlers[handlerName];
		}

		return handlers;
	};

	this.runReadyTrigger = function (scope) {
		// Initializing the `$scope` as frontend jQuery instance
		var $scope = jQuery(scope),
			elementType = $scope.attr('data-element_type');

		if (!elementType) {
			return;
		}

		ceFrontend.hooks.doAction('frontend/element_ready/global', $scope, $);

		ceFrontend.hooks.doAction('frontend/element_ready/' + elementType, $scope, $);

		if ('widget' === elementType) {
			ceFrontend.hooks.doAction('frontend/element_ready/' + $scope.attr('data-widget_type'), $scope, $);
		}
	};

	init();
};

/***/ }),

/***/ 185:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var BackgroundVideo = elementorModules.frontend.handlers.Base.extend({
	player: null,

	isYTVideo: null,

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				backgroundVideoContainer: '.elementor-background-video-container',
				backgroundVideoEmbed: '.elementor-background-video-embed',
				backgroundVideoHosted: '.elementor-background-video-hosted'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
			elements = {
			$backgroundVideoContainer: this.$element.find(selectors.backgroundVideoContainer)
		};

		elements.$backgroundVideoEmbed = elements.$backgroundVideoContainer.children(selectors.backgroundVideoEmbed);

		elements.$backgroundVideoHosted = elements.$backgroundVideoContainer.children(selectors.backgroundVideoHosted);

		return elements;
	},

	calcVideosSize: function calcVideosSize() {
		var containerWidth = this.elements.$backgroundVideoContainer.outerWidth(),
			containerHeight = this.elements.$backgroundVideoContainer.outerHeight(),
			aspectRatioSetting = '16:9',
			//TEMP
		aspectRatioArray = aspectRatioSetting.split(':'),
			aspectRatio = aspectRatioArray[0] / aspectRatioArray[1],
			ratioWidth = containerWidth / aspectRatio,
			ratioHeight = containerHeight * aspectRatio,
			isWidthFixed = containerWidth / containerHeight > aspectRatio;

		return {
			width: isWidthFixed ? containerWidth : ratioHeight,
			height: isWidthFixed ? ratioWidth : containerHeight
		};
	},

	changeVideoSize: function changeVideoSize() {
		if (this.isYTVideo && !this.player) {
			// tmp fix for JS errors
			return;
		}
		var $video = this.isYTVideo ? jQuery(this.player.getIframe()) : this.elements.$backgroundVideoHosted,
			size = this.calcVideosSize();

		$video.width(size.width).height(size.height);
	},

	startVideoLoop: function startVideoLoop() {
		var self = this;

		// If the section has been removed
		if (!self.player.getIframe().contentWindow) {
			return;
		}

		var elementSettings = self.getElementSettings(),
			startPoint = elementSettings.background_video_start || 0,
			endPoint = elementSettings.background_video_end;

		self.player.seekTo(startPoint);

		if (endPoint) {
			var durationToEnd = endPoint - startPoint + 1;

			setTimeout(function () {
				self.startVideoLoop();
			}, durationToEnd * 1000);
		}
	},

	prepareYTVideo: function prepareYTVideo(YT, videoID) {
		var self = this,
			$backgroundVideoContainer = self.elements.$backgroundVideoContainer,
			elementSettings = self.getElementSettings(),
			startStateCode = YT.PlayerState.PLAYING;

		// Since version 67, Chrome doesn't fire the `PLAYING` state at start time
		if (window.chrome) {
			startStateCode = YT.PlayerState.UNSTARTED;
		}

		$backgroundVideoContainer.addClass('elementor-loading elementor-invisible');

		self.player = new YT.Player(self.elements.$backgroundVideoEmbed[0], {
			videoId: videoID,
			events: {
				onReady: function onReady() {
					self.player.mute();

					self.changeVideoSize();

					self.startVideoLoop();

					self.player.playVideo();
				},
				onStateChange: function onStateChange(event) {
					switch (event.data) {
						case startStateCode:
							$backgroundVideoContainer.removeClass('elementor-invisible elementor-loading');

							break;
						case YT.PlayerState.ENDED:
							self.player.seekTo(elementSettings.background_video_start || 0);
					}
				}
			},
			playerVars: {
				controls: 0,
				rel: 0
			}
		});
	},

	activate: function activate() {
		var self = this,
			videoLink = self.getElementSettings('background_video_link'),
			videoID = ceFrontend.utils.youtube.getYoutubeIDFromURL(videoLink);

		self.isYTVideo = !!videoID;

		if (videoID) {
			ceFrontend.utils.youtube.onYoutubeApiReady(function (YT) {
				setTimeout(function () {
					self.prepareYTVideo(YT, videoID);
				});
			});
		} else {
			self.elements.$backgroundVideoHosted.attr('src', videoLink).one('canplay', self.changeVideoSize);
		}

		ceFrontend.elements.$window.on('resize', self.changeVideoSize);
	},

	deactivate: function deactivate() {
		if (this.isYTVideo && this.player.getIframe()) {
			this.player.destroy();
		} else {
			this.elements.$backgroundVideoHosted.removeAttr('src');
		}

		ceFrontend.elements.$window.off('resize', this.changeVideoSize);
	},

	run: function run() {
		var elementSettings = this.getElementSettings();

		if ('video' === elementSettings.background_background && elementSettings.background_video_link) {
			this.activate();
		} else {
			this.deactivate();
		}
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.run();
	},

	onElementChange: function onElementChange(propertyName) {
		if ('background_background' === propertyName) {
			this.run();
		}
	}
});

var StretchedSection = elementorModules.frontend.handlers.Base.extend({

	stretchElement: null,

	bindEvents: function bindEvents() {
		var handlerID = this.getUniqueHandlerID();

		ceFrontend.addListenerOnce(handlerID, 'resize', this.stretch);

		ceFrontend.addListenerOnce(handlerID, 'sticky:stick', this.stretch, this.$element);

		ceFrontend.addListenerOnce(handlerID, 'sticky:unstick', this.stretch, this.$element);
	},

	unbindEvents: function unbindEvents() {
		ceFrontend.removeListeners(this.getUniqueHandlerID(), 'resize', this.stretch);
	},

	initStretch: function initStretch() {
		this.stretchElement = new elementorModules.frontend.tools.StretchElement({
			element: this.$element,
			selectors: {
				container: this.getStretchContainer()
			}
		});
	},

	getStretchContainer: function getStretchContainer() {
		return ceFrontend.getGeneralSettings('elementor_stretched_section_container') || document.documentElement;
	},

	stretch: function stretch() {
		if (!this.getElementSettings('stretch_section')) {
			return;
		}

		this.stretchElement.stretch();
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.initStretch();

		this.stretch();
	},

	onElementChange: function onElementChange(propertyName) {
		if ('stretch_section' === propertyName) {
			if (this.getElementSettings('stretch_section')) {
				this.stretch();
			} else {
				this.stretchElement.reset();
			}
		}
	},

	onGeneralSettingsChange: function onGeneralSettingsChange(changed) {
		if ('elementor_stretched_section_container' in changed) {
			this.stretchElement.setSettings('selectors.container', this.getStretchContainer());

			this.stretch();
		}
	}
});

var Shapes = elementorModules.frontend.handlers.Base.extend({

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				container: '> .elementor-shape-%s'
			},
			svgURL: ceFrontend.config.urls.assets + 'img/shapes/'
		};
	},

	getDefaultElements: function getDefaultElements() {
		var elements = {},
			selectors = this.getSettings('selectors');

		elements.$topContainer = this.$element.find(selectors.container.replace('%s', 'top'));

		elements.$bottomContainer = this.$element.find(selectors.container.replace('%s', 'bottom'));

		return elements;
	},

	getSvgURL: function getSvgURL(shapeType, fileName) {
		var svgURL = this.getSettings('svgURL') + fileName + '.svg';
		if (elementor.config.additional_shapes && shapeType in elementor.config.additional_shapes) {
			svgURL = elementor.config.additional_shapes[shapeType];
		}
		return svgURL;
	},


	buildSVG: function buildSVG(side) {
		var self = this,
			baseSettingKey = 'shape_divider_' + side,
			shapeType = self.getElementSettings(baseSettingKey),
			$svgContainer = this.elements['$' + side + 'Container'];

		$svgContainer.attr('data-shape', shapeType);

		if (!shapeType) {
			$svgContainer.empty(); // Shape-divider set to 'none'
			return;
		}

		var fileName = shapeType;

		if (self.getElementSettings(baseSettingKey + '_negative')) {
			fileName += '-negative';
		}

		var svgURL = self.getSvgURL(shapeType, fileName);

		jQuery.get(svgURL, function (data) {
			$svgContainer.empty().append(data.childNodes[0]);
		});

		this.setNegative(side);
	},

	setNegative: function setNegative(side) {
		this.elements['$' + side + 'Container'].attr('data-negative', !!this.getElementSettings('shape_divider_' + side + '_negative'));
	},

	onInit: function onInit() {
		var self = this;

		elementorModules.frontend.handlers.Base.prototype.onInit.apply(self, arguments);

		['top', 'bottom'].forEach(function (side) {
			if (self.getElementSettings('shape_divider_' + side)) {
				self.buildSVG(side);
			}
		});
	},

	onElementChange: function onElementChange(propertyName) {
		var shapeChange = propertyName.match(/^shape_divider_(top|bottom)$/);

		if (shapeChange) {
			this.buildSVG(shapeChange[1]);

			return;
		}

		var negativeChange = propertyName.match(/^shape_divider_(top|bottom)_negative$/);

		if (negativeChange) {
			this.buildSVG(negativeChange[1]);

			this.setNegative(negativeChange[1]);
		}
	}
});

var HandlesPosition = elementorModules.frontend.handlers.Base.extend({

	isFirstSection: function isFirstSection() {
		return this.$element.is('.elementor-edit-mode .elementor-top-section:first');
	},

	isOverflowHidden: function isOverflowHidden() {
		return 'hidden' === this.$element.css('overflow');
	},

	getOffset: function getOffset() {
		if ('body' === elementor.config.document.container) {
			return this.$element.offset().top;
		}

		var $container = jQuery(elementor.config.document.container);
		return this.$element.offset().top - $container.offset().top;
	},

	setHandlesPosition: function setHandlesPosition() {
		var isOverflowHidden = this.isOverflowHidden();

		if (!isOverflowHidden && !this.isFirstSection()) {
			return;
		}

		var offset = isOverflowHidden ? 0 : this.getOffset(),
			$handlesElement = this.$element.find('> .elementor-element-overlay > .elementor-editor-section-settings'),
			insideHandleClass = 'elementor-section--handles-inside';

		if (offset < 25 || this.$element.closest('[data-elementor-type^="product-"]').length) {
			this.$element.addClass(insideHandleClass);

			if (offset < -5) {
				$handlesElement.css('top', -offset);
			} else {
				$handlesElement.css('top', '');
			}
		} else {
			this.$element.removeClass(insideHandleClass);
		}
	},

	onInit: function onInit() {
		this.setHandlesPosition();

		this.$element.on('mouseenter', this.setHandlesPosition);
	}
});

module.exports = function ($scope) {
	if (ceFrontend.isEditMode() || $scope.hasClass('elementor-section-stretched')) {
		ceFrontend.elementsHandler.addHandler(StretchedSection, { $element: $scope });
	}

	if (ceFrontend.isEditMode()) {
		ceFrontend.elementsHandler.addHandler(Shapes, { $element: $scope });
		ceFrontend.elementsHandler.addHandler(HandlesPosition, { $element: $scope });
	}

	ceFrontend.elementsHandler.addHandler(BackgroundVideo, { $element: $scope });
};

/***/ }),

/***/ 186:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TabsModule = __webpack_require__(18);

module.exports = function ($scope) {
	ceFrontend.elementsHandler.addHandler(TabsModule, {
		$element: $scope,
		showTabFn: 'slideDown',
		hideTabFn: 'slideUp'
	});
};

/***/ }),

/***/ 187:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($scope, $) {
	$scope.find('.elementor-alert-dismiss').on('click', function () {
		$(this).parent().fadeOut();
	});
};

/***/ }),

/***/ 188:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($scope, $) {
	ceFrontend.waypoint($scope.find('.elementor-counter-number'), function () {
		var $number = $(this),
			data = $number.data();

		var decimalDigits = data.toValue.toString().match(/\.(.*)/);

		if (decimalDigits) {
			data.rounding = decimalDigits[1].length;
		}

		$number.numerator(data);
	});
};

/***/ }),

/***/ 189:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function ($scope, $) {
	ceFrontend.waypoint($scope.find('.elementor-progress-bar'), function () {
		var $progressbar = $(this);

		$progressbar.css('width', $progressbar.data('max') + '%');
	});
};

/***/ }),

/***/ 190:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TabsModule = __webpack_require__(18);

module.exports = function ($scope) {
	ceFrontend.elementsHandler.addHandler(TabsModule, {
		$element: $scope,
		toggleSelf: false
	});
};

/***/ }),

/***/ 191:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TabsModule = __webpack_require__(18);

module.exports = function ($scope) {
	ceFrontend.elementsHandler.addHandler(TabsModule, {
		$element: $scope,
		showTabFn: 'slideDown',
		hideTabFn: 'slideUp',
		hidePrevious: false,
		autoExpand: 'editor'
	});
};

/***/ }),

/***/ 192:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var VideoModule = elementorModules.frontend.handlers.Base.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				imageOverlay: '.elementor-custom-embed-image-overlay',
				video: '.elementor-video',
				videoIframe: '.elementor-video-iframe'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		return {
			$imageOverlay: this.$element.find(selectors.imageOverlay),
			$video: this.$element.find(selectors.video),
			$videoIframe: this.$element.find(selectors.videoIframe)
		};
	},

	getLightBox: function getLightBox() {
		return ceFrontend.utils.lightbox;
	},

	handleVideo: function handleVideo() {
		if (!this.getElementSettings('lightbox')) {
			this.elements.$imageOverlay.remove();

			this.playVideo();
		}
	},

	playVideo: function playVideo() {
		if (this.elements.$video.length) {
			this.elements.$video[0].play();

			return;
		}

		var $videoIframe = this.elements.$videoIframe,
			lazyLoad = $videoIframe.data('lazy-load');

		if (lazyLoad) {
			$videoIframe.attr('src', lazyLoad);
		}

		var newSourceUrl = $videoIframe[0].src.replace('&autoplay=0', '');

		$videoIframe[0].src = newSourceUrl + '&autoplay=1';
	},

	animateVideo: function animateVideo() {
		this.getLightBox().setEntranceAnimation(this.getCurrentDeviceSetting('lightbox_content_animation'));
	},

	handleAspectRatio: function handleAspectRatio() {
		this.getLightBox().setVideoAspectRatio(this.getElementSettings('aspect_ratio'));
	},

	bindEvents: function bindEvents() {
		this.elements.$imageOverlay.on('click', this.handleVideo);
	},

	onElementChange: function onElementChange(propertyName) {
		if (0 === propertyName.indexOf('lightbox_content_animation')) {
			this.animateVideo();

			return;
		}

		var isLightBoxEnabled = this.getElementSettings('lightbox');

		if ('lightbox' === propertyName && !isLightBoxEnabled) {
			this.getLightBox().getModal().hide();

			return;
		}

		if ('aspect_ratio' === propertyName && isLightBoxEnabled) {
			this.handleAspectRatio();
		}
	}
});

module.exports = function ($scope) {
	ceFrontend.elementsHandler.addHandler(VideoModule, { $element: $scope });
};

/***/ }),

/***/ 193:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var ImageCarouselHandler = elementorModules.frontend.handlers.Base.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				carousel: '.elementor-image-carousel'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		return {
			$carousel: this.$element.find(selectors.carousel)
		};
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		var elementSettings = this.getElementSettings(),
			slidesToShow = +elementSettings.slides_to_show || elementSettings.default_slides_count,
			isSingleSlide = 1 === slidesToShow,
			centerPadding = elementSettings.center_padding && elementSettings.center_padding.size + '',
			centerPaddingTablet = elementSettings.center_padding_tablet && elementSettings.center_padding_tablet.size + '',
			centerPaddingMobile = elementSettings.center_padding_mobile && elementSettings.center_padding_mobile.size + '',
			defaultLGDevicesSlidesCount = isSingleSlide ? 1 : elementSettings.default_slides_count - 1 || 1,
			breakpoints = ceFrontend.config.breakpoints;

		var slickOptions = {
			touchThreshold: 100,
			slidesToShow: slidesToShow,
			slidesToScroll: +elementSettings.slides_to_scroll || 1,
			swipeToSlide: !elementSettings.slides_to_scroll,
			variableWidth: 'yes' === elementSettings.variable_width,
			centerMode: 'yes' === elementSettings.center_mode,
			centerPadding: centerPadding ? centerPadding + elementSettings.center_padding.unit : void 0,
			autoplay: 'yes' === elementSettings.autoplay,
			autoplaySpeed: elementSettings.autoplay_speed,
			infinite: 'yes' === elementSettings.infinite,
			pauseOnHover: 'yes' === elementSettings.pause_on_hover,
			speed: elementSettings.speed,
			arrows: -1 !== ['arrows', 'both'].indexOf(elementSettings.navigation),
			dots: -1 !== ['dots', 'both'].indexOf(elementSettings.navigation),
			rtl: 'rtl' === elementSettings.direction,
			responsive: [{
				breakpoint: breakpoints.lg,
				settings: {
					centerPadding: centerPaddingTablet ? centerPaddingTablet + elementSettings.center_padding_tablet.unit : void 0,
					slidesToShow: +elementSettings.slides_to_show_tablet || defaultLGDevicesSlidesCount,
					slidesToScroll: +elementSettings.slides_to_scroll_tablet || 1,
					swipeToSlide: !elementSettings.slides_to_scroll_tablet,
					autoplay: 'yes' === elementSettings.autoplay_tablet,
					infinite: elementSettings.infinite_tablet ? 'yes' === elementSettings.infinite_tablet : void 0
				}
			}, {
				breakpoint: breakpoints.md,
				settings: {
					centerPadding: centerPaddingMobile ? centerPaddingMobile + elementSettings.center_padding_mobile.unit : (
						centerPaddingTablet ? centerPaddingTablet + elementSettings.center_padding_tablet.unit : void 0
					),
					slidesToShow: +elementSettings.slides_to_show_mobile || 1,
					slidesToScroll: +elementSettings.slides_to_scroll_mobile || 1,
					swipeToSlide: !elementSettings.slides_to_scroll_mobile,
					autoplay: 'yes' === elementSettings.autoplay_mobile,
					infinite: elementSettings.infinite_mobile ? 'yes' === elementSettings.infinite_mobile : void 0
				}
			}]
		};

		if (isSingleSlide) {
			slickOptions.fade = 'fade' === elementSettings.effect;
		}

		this.elements.$carousel.slick(slickOptions);
	}
});

module.exports = function ($scope) {
	ceFrontend.elementsHandler.addHandler(ImageCarouselHandler, { $element: $scope });
};

/***/ }),

/***/ 194:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var TextEditor = elementorModules.frontend.handlers.Base.extend({
	dropCapLetter: '',

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				paragraph: 'p:first'
			},
			classes: {
				dropCap: 'elementor-drop-cap',
				dropCapLetter: 'elementor-drop-cap-letter'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
			classes = this.getSettings('classes'),
			$dropCap = jQuery('<span>', { class: classes.dropCap }),
			$dropCapLetter = jQuery('<span>', { class: classes.dropCapLetter });

		$dropCap.append($dropCapLetter);

		return {
			$paragraph: this.$element.find(selectors.paragraph),
			$dropCap: $dropCap,
			$dropCapLetter: $dropCapLetter
		};
	},

	wrapDropCap: function wrapDropCap() {
		var isDropCapEnabled = this.getElementSettings('drop_cap');

		if (!isDropCapEnabled) {
			// If there is an old drop cap inside the paragraph
			if (this.dropCapLetter) {
				this.elements.$dropCap.remove();

				this.elements.$paragraph.prepend(this.dropCapLetter);

				this.dropCapLetter = '';
			}

			return;
		}

		var $paragraph = this.elements.$paragraph;

		if (!$paragraph.length) {
			return;
		}

		var paragraphContent = $paragraph.html().replace(/&nbsp;/g, ' '),
			firstLetterMatch = paragraphContent.match(/^ *([^ ] ?)/);

		if (!firstLetterMatch) {
			return;
		}

		var firstLetter = firstLetterMatch[1],
			trimmedFirstLetter = firstLetter.trim();

		// Don't apply drop cap when the content starting with an HTML tag
		if ('<' === trimmedFirstLetter) {
			return;
		}

		this.dropCapLetter = firstLetter;

		this.elements.$dropCapLetter.text(trimmedFirstLetter);

		var restoredParagraphContent = paragraphContent.slice(firstLetter.length).replace(/^ */, function (match) {
			return new Array(match.length + 1).join('&nbsp;');
		});

		$paragraph.html(restoredParagraphContent).prepend(this.elements.$dropCap);
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.wrapDropCap();
	},

	onElementChange: function onElementChange(propertyName) {
		if ('drop_cap' === propertyName) {
			this.wrapDropCap();
		}
	}
});

module.exports = function ($scope) {
	ceFrontend.elementsHandler.addHandler(TextEditor, { $element: $scope });
};

/***/ }),

/***/ 195:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var GlobalHandler = elementorModules.frontend.handlers.Base.extend({
	getWidgetType: function getWidgetType() {
		return 'global';
	},
	animate: function animate() {
		var $element = this.$element,
			animation = this.getAnimation();

		if ('none' === animation) {
			$element.removeClass('elementor-invisible');
			return;
		}

		var elementSettings = this.getElementSettings(),
			animationDelay = elementSettings._animation_delay || elementSettings.animation_delay || 0;

		$element.addClass('elementor-invisible').removeClass(animation);

		if (this.currentAnimation) {
			$element.removeClass(this.currentAnimation);
		}

		this.currentAnimation = animation;

		setTimeout(function () {
			$element.removeClass('elementor-invisible').addClass('animated ' + animation);
		}, animationDelay);
	},
	getAnimation: function getAnimation() {
		return this.getCurrentDeviceSetting('animation') || this.getCurrentDeviceSetting('_animation');
	},
	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		if (this.getAnimation()) {
			ceFrontend.waypoint(this.$element, this.animate.bind(this));
		}
	},
	onElementChange: function onElementChange(propertyName) {
		if (/^_?animation/.test(propertyName)) {
			this.animate();
		}
	}
});

module.exports = function ($scope) {
	ceFrontend.elementsHandler.addHandler(GlobalHandler, { $element: $scope });
};

/***/ }),

/***/ 196:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			isInserted: false,
			APISrc: 'https://www.youtube.com/iframe_api',
			selectors: {
				firstScript: 'script:first'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		return {
			$firstScript: jQuery(this.getSettings('selectors.firstScript'))
		};
	},

	insertYTAPI: function insertYTAPI() {
		this.setSettings('isInserted', true);

		this.elements.$firstScript.before(jQuery('<script>', { src: this.getSettings('APISrc') }));
	},

	onYoutubeApiReady: function onYoutubeApiReady(callback) {
		var self = this;

		if (!self.getSettings('IsInserted')) {
			self.insertYTAPI();
		}

		if (window.YT && YT.loaded) {
			callback(YT);
		} else {
			// If not ready check again by timeout..
			setTimeout(function () {
				self.onYoutubeApiReady(callback);
			}, 350);
		}
	},

	getYoutubeIDFromURL: function getYoutubeIDFromURL(url) {
		var videoIDParts = url.match(/^(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^?&"'>]+)/);

		return videoIDParts && videoIDParts[1];
	}
});

/***/ }),

/***/ 197:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	getDefaultSettings: function getDefaultSettings() {
		return {
			scrollDuration: 500,
			selectors: {
				links: 'a[href*="#"]',
				targets: '.elementor-element, .elementor-menu-anchor',
				scrollable: 'html, body'
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var $ = jQuery,
			selectors = this.getSettings('selectors');

		return {
			$scrollable: $(selectors.scrollable)
		};
	},

	bindEvents: function bindEvents() {
		ceFrontend.elements.$document.on('click', this.getSettings('selectors.links'), this.handleAnchorLinks);
	},

	handleAnchorLinks: function handleAnchorLinks(event) {
		var clickedLink = event.currentTarget,
			isSamePathname = location.pathname === clickedLink.pathname,
			isSameHostname = location.hostname === clickedLink.hostname,
			$anchor;

		if (!isSameHostname || !isSamePathname || clickedLink.hash.length < 2) {
			return;
		}

		try {
			$anchor = jQuery(clickedLink.hash).filter(this.getSettings('selectors.targets'));
		} catch (e) {
			return;
		}

		if (!$anchor.length) {
			return;
		}

		var scrollTop = $anchor.offset().top,
			$activeStickies = jQuery('.elementor-section.elementor-sticky--active'),
			maxStickyHeight = 0;

		// Offset height of tallest sticky
		if ($activeStickies.length > 0) {
			maxStickyHeight = Math.max.apply(null, $activeStickies.map(function () {
				return jQuery(this).outerHeight();
			}).get());

			scrollTop -= maxStickyHeight;
		}

		event.preventDefault();

		scrollTop = ceFrontend.hooks.applyFilters('frontend/handlers/menu_anchor/scroll_top_distance', scrollTop);

		this.elements.$scrollable.animate({
			scrollTop: scrollTop
		}, this.getSettings('scrollDuration'));
	},

	onInit: function onInit() {
		elementorModules.ViewModule.prototype.onInit.apply(this, arguments);

		this.bindEvents();
	}
});

/***/ }),

/***/ 198:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.ViewModule.extend({
	oldAspectRatio: null,

	oldAnimation: null,

	swiper: null,

	getDefaultSettings: function getDefaultSettings() {
		return {
			classes: {
				aspectRatio: 'elementor-aspect-ratio-%s',
				item: 'elementor-lightbox-item',
				image: 'elementor-lightbox-image',
				videoContainer: 'elementor-video-container',
				videoWrapper: 'elementor-fit-aspect-ratio',
				playButton: 'elementor-custom-embed-play',
				playButtonIcon: 'fa',
				playing: 'elementor-playing',
				hidden: 'elementor-hidden',
				invisible: 'elementor-invisible',
				preventClose: 'elementor-lightbox-prevent-close',
				slideshow: {
					container: 'swiper-container',
					slidesWrapper: 'swiper-wrapper',
					prevButton: 'elementor-swiper-button elementor-swiper-button-prev',
					nextButton: 'elementor-swiper-button elementor-swiper-button-next',
					prevButtonIcon: 'ceicon-chevron-left',
					nextButtonIcon: 'ceicon-chevron-right',
					slide: 'swiper-slide',
					header: 'elementor-slideshow__header',
					footer: 'elementor-slideshow__footer',
					title: 'elementor-slideshow__title',
					description: 'elementor-slideshow__description',
					counter: 'elementor-slideshow__counter',
					iconZoomIn: 'fa fa-search-plus', // 'ceicon-zoom-in-bold',
					iconZoomOut: 'fa fa-search-minus', // 'ceicon-zoom-out-bold',
					zoomMode: 'elementor-slideshow--zoom-mode',
				}
			},
			selectors: {
				links: 'a, [data-elementor-lightbox]',
				slideshow: {
					activeSlide: '.swiper-slide-active',
					prevSlide: '.swiper-slide-prev',
					nextSlide: '.swiper-slide-next'
				}
			},
			modalOptions: {
				id: 'elementor-lightbox',
				entranceAnimation: 'zoomIn',
				videoAspectRatio: 169,
				position: {
					enable: false
				}
			}
		};
	},

	getModal: function getModal() {
		if (!module.exports.modal) {
			this.initModal();
		}

		return module.exports.modal;
	},

	initModal: function initModal() {
		var modal = module.exports.modal = ceFrontend.getDialogsManager().createWidget('lightbox', {
			className: 'elementor-lightbox',
			closeButton: true,
			closeButtonClass: 'ceicon-close',
			selectors: {
				preventClose: '.' + this.getSettings('classes.preventClose')
			},
			hide: {
				onClick: true
			}
		});

		modal.on('hide', function () {
			modal.setMessage('');
		});
	},

	showModal: function showModal(options) {
		var self = this,
			defaultOptions = self.getDefaultSettings().modalOptions;

		self.setSettings('modalOptions', jQuery.extend(defaultOptions, options.modalOptions));

		var modal = self.getModal();

		modal.setID(self.getSettings('modalOptions.id'));

		modal.onShow = function () {
			DialogsManager.getWidgetType('lightbox').prototype.onShow.apply(modal, arguments);

			self.setEntranceAnimation();
		};

		modal.onHide = function () {
			DialogsManager.getWidgetType('lightbox').prototype.onHide.apply(modal, arguments);

			modal.getElements('message').removeClass('animated');
		};

		switch (options.type) {
			case 'image':
				self.setImageContent(options.url);

				break;
			case 'video':
				self.setVideoContent(options);

				break;
			case 'slideshow':
				self.setSlideshowContent(options.slideshow);

				break;
			default:
				self.setHTMLContent(options.html);
		}

		modal.show();
	},

	setHTMLContent: function setHTMLContent(html) {
		this.getModal().setMessage(html);
	},

	setImageContent: function setImageContent(imageURL) {
		var self = this,
			classes = self.getSettings('classes'),
			$item = jQuery('<div>', { class: classes.item }),
			$image = jQuery('<img>', { src: imageURL, class: classes.image + ' ' + classes.preventClose });

		$item.append($image);

		self.getModal().setMessage($item);
	},

	setVideoContent: function setVideoContent(options) {
		var classes = this.getSettings('classes'),
			$videoContainer = jQuery('<div>', { class: classes.videoContainer }),
			$videoWrapper = jQuery('<div>', { class: classes.videoWrapper }),
			$videoElement,
			modal = this.getModal();

		if ('hosted' === options.videoType) {
			var videoParams = jQuery.extend({ src: options.url, autoplay: '' }, options.videoParams);

			$videoElement = jQuery('<video>', videoParams);
		} else {
			var videoURL = options.url.replace('&autoplay=0', '') + '&autoplay=1';

			$videoElement = jQuery('<iframe>', { src: videoURL, allowfullscreen: 1 });
		}

		$videoContainer.append($videoWrapper);

		$videoWrapper.append($videoElement);

		modal.setMessage($videoContainer);

		this.setVideoAspectRatio();

		var onHideMethod = modal.onHide;

		modal.onHide = function () {
			onHideMethod();

			modal.getElements('message').removeClass('elementor-fit-aspect-ratio');
		};
	},

	getSlideshowHeader: function getSlideshowHeader() {
		var $ = jQuery,
			showCounter = 'yes' === ceFrontend.getGeneralSettings('elementor_lightbox_enable_counter'),
			showFullscreen = 'yes' === ceFrontend.getGeneralSettings('elementor_lightbox_enable_fullscreen'),
			showZoom = 'yes' === ceFrontend.getGeneralSettings('elementor_lightbox_enable_zoom'),
			showShare = 'yes' === ceFrontend.getGeneralSettings('elementor_lightbox_enable_share'),
			classes = this.getSettings('classes'),
			slideshowClasses = classes.slideshow,
			elements = this.elements;

		if (!(showCounter || showFullscreen || showZoom || showShare)) {
			return;
		}

		elements.$header = $('<header>', {
			class: slideshowClasses.header + ' ' + classes.preventClose
		});

		if (showCounter) {
			elements.$counter = $('<span>', {
				class: slideshowClasses.counter
			});
			elements.$header.append(elements.$counter);
		}

		if (showFullscreen) {
			elements.$iconExpand = $('<i>', {
				class: slideshowClasses.iconExpand
			}).append($('<span>'), $('<span>'));
			elements.$iconExpand.on('click', this.toggleFullscreen);
			elements.$header.append(elements.$iconExpand);
		}

		if (showZoom) {
			elements.$iconZoom = $('<i>', {
				class: slideshowClasses.iconZoomIn
			});
			elements.$iconZoom.on('click', this.toggleZoomMode);
			elements.$header.append(elements.$iconZoom);
		}

		return elements.$header;
	},

	toggleZoomMode: function toggleZoomMode() {
		if (1 !== this.swiper.zoom.scale) {
			this.deactivateZoom();
		} else {
			this.activateZoom();
		}
	},

	activateZoom: function activateZoom() {
		var swiper = this.swiper,
			elements = this.elements,
			classes = this.getSettings('classes');
		swiper.zoom.in();
		swiper.allowSlideNext = false;
		swiper.allowSlidePrev = false;
		swiper.allowTouchMove = false;
		elements.$container.addClass(classes.slideshow.zoomMode);
		elements.$iconZoom.removeClass(classes.slideshow.iconZoomIn).addClass(classes.slideshow.iconZoomOut);
	},

	deactivateZoom: function deactivateZoom() {
		var swiper = this.swiper,
			elements = this.elements,
			classes = this.getSettings('classes');
		swiper.zoom.out();
		swiper.allowSlideNext = true;
		swiper.allowSlidePrev = true;
		swiper.allowTouchMove = true;
		elements.$container.removeClass(classes.slideshow.zoomMode);
		elements.$iconZoom.removeClass(classes.slideshow.iconZoomOut).addClass(classes.slideshow.iconZoomIn);
	},

	getSlideshowFooter: function getSlideshowFooter() {
		var $ = jQuery,
			classes = this.getSettings('classes'),
			$footer = $('<footer>', {
				class: classes.slideshow.footer + ' ' + classes.preventClose
			}),
			$title = $('<div>', {
				class: classes.slideshow.title
			}),
			$description = $('<div>', {
				class: classes.slideshow.description
			});
		return $footer.append($title, $description);
	},

	setSlideshowContent: function setSlideshowContent(options) {
		var $ = jQuery,
			self = this,
			isSingleSlide = 1 === options.slides.length,
			hasTitle = '' !== ceFrontend.getGeneralSettings('elementor_lightbox_title_src'),
			hasDescription = '' !== ceFrontend.getGeneralSettings('elementor_lightbox_description_src'),
			showFooter = hasTitle || hasDescription,
			classes = self.getSettings('classes'),
			slideshowClasses = classes.slideshow,
			$container = $('<div>', { class: slideshowClasses.container }),
			$slidesWrapper = $('<div>', { class: slideshowClasses.slidesWrapper });

		if (!isSingleSlide) {
			var $prevButton = $('<div>', { class: slideshowClasses.prevButton + ' ' + classes.preventClose }).html($('<i>', { class: slideshowClasses.prevButtonIcon })),
				$nextButton = $('<div>', { class: slideshowClasses.nextButton + ' ' + classes.preventClose }).html($('<i>', { class: slideshowClasses.nextButtonIcon }));
		}

		options.slides.forEach(function (slide) {
			var slideClass = slideshowClasses.slide + ' ' + classes.item;

			if (slide.video) {
				slideClass += ' ' + classes.video;
			}

			var $slide = $('<div>', { class: slideClass });

			if (slide.video) {
				$slide.attr('data-elementor-slideshow-video', slide.video);

				var $playIcon = $('<div>', { class: classes.playButton }).html($('<i>', { class: classes.playButtonIcon }));

				$slide.append($playIcon);
			} else {
				var $zoomContainer = $('<div>', { class: 'swiper-zoom-container' }),
					$slideImage = $('<img>', {
						class: classes.image + ' ' + classes.preventClose,
						src: slide.image,
						'data-title': slide.title,
						'data-description': slide.description
					});
				$zoomContainer.append($slideImage);
				$slide.append($zoomContainer);
			}

			$slidesWrapper.append($slide);
		});

		this.elements.$container = $container;
		this.elements.$header = this.getSlideshowHeader();
		$container.prepend(this.elements.$header).append($slidesWrapper, $prevButton, $nextButton);

		if (showFooter) {
			this.elements.$footer = this.getSlideshowFooter();
			$container.append(this.elements.$footer);
		}

		var modal = self.getModal();

		modal.setMessage($container);

		var onShowMethod = modal.onShow;

		modal.onShow = function () {
			onShowMethod();

			var swiperOptions = {
				pagination: {
					el: '.' + slideshowClasses.counter,
					type: 'fraction'
				},
				on: {
					slideChangeTransitionEnd: self.onSlideChange
				},
				zoom: true,
				spaceBetween: 100,
				grabCursor: true,
				runCallbacksOnInit: false,
				loop: !isSingleSlide,
				keyboard: true
			};

			if (!isSingleSlide) {
				swiperOptions.navigation = {
					prevEl: $prevButton,
					nextEl: $nextButton
				};
			}

			if (options.swiper) {
				$.extend(swiperOptions, options.swiper);
			}

			self.swiper = new Swiper($container, swiperOptions);

			self.setVideoAspectRatio();

			self.playSlideVideo();

			if (showFooter) {
				self.updateFooterText();
			}
		};
	},

	setVideoAspectRatio: function setVideoAspectRatio(aspectRatio) {
		aspectRatio = aspectRatio || this.getSettings('modalOptions.videoAspectRatio');

		var $widgetContent = this.getModal().getElements('widgetContent'),
			oldAspectRatio = this.oldAspectRatio,
			aspectRatioClass = this.getSettings('classes.aspectRatio');

		this.oldAspectRatio = aspectRatio;

		if (oldAspectRatio) {
			$widgetContent.removeClass(aspectRatioClass.replace('%s', oldAspectRatio));
		}

		if (aspectRatio) {
			$widgetContent.addClass(aspectRatioClass.replace('%s', aspectRatio));
		}
	},

	getSlide: function getSlide(slideState) {
		return jQuery(this.swiper.slides).filter(this.getSettings('selectors.slideshow.' + slideState + 'Slide'));
	},

	updateFooterText: function updateFooterText() {
		if (!this.elements.$footer) {
			return;
		}

		var classes = this.getSettings('classes'),
			$activeSlide = this.getSlide('active'),
			$image = $activeSlide.find('.elementor-lightbox-image'),
			titleText = $image.data('title'),
			descriptionText = $image.data('description'),
			$title = this.elements.$footer.find('.' + classes.slideshow.title),
			$description = this.elements.$footer.find('.' + classes.slideshow.description);
		$title.text(titleText || '');
		$description.text(descriptionText || '');
	},

	playSlideVideo: function playSlideVideo() {
		var $activeSlide = this.getSlide('active'),
			videoURL = $activeSlide.data('elementor-slideshow-video');

		if (!videoURL) {
			return;
		}

		var classes = this.getSettings('classes'),
			$videoContainer = jQuery('<div>', { class: classes.videoContainer + ' ' + classes.invisible }),
			$videoWrapper = jQuery('<div>', { class: classes.videoWrapper }),
			$videoFrame = jQuery('<iframe>', { src: videoURL }),
			$playIcon = $activeSlide.children('.' + classes.playButton);

		$videoContainer.append($videoWrapper);

		$videoWrapper.append($videoFrame);

		$activeSlide.append($videoContainer);

		$playIcon.addClass(classes.playing).removeClass(classes.hidden);

		$videoFrame.on('load', function () {
			$playIcon.addClass(classes.hidden);

			$videoContainer.removeClass(classes.invisible);
		});
	},

	setEntranceAnimation: function setEntranceAnimation(animation) {
		animation = animation || ceFrontend.getCurrentDeviceSetting(this.getSettings('modalOptions'), 'entranceAnimation');

		var $widgetMessage = this.getModal().getElements('message');

		if (this.oldAnimation) {
			$widgetMessage.removeClass(this.oldAnimation);
		}

		this.oldAnimation = animation;

		if (animation) {
			$widgetMessage.addClass('animated ' + animation);
		}
	},

	isLightboxLink: function isLightboxLink(element) {
		if ('A' === element.tagName && (element.hasAttribute('download') || !/\.(png|jpe?g|gif|svg|webp)(\?.*)?$/i.test(element.href))) {
			return false;
		}

		var generalOpenInLightbox = +ceFrontend.getGeneralSettings('elementor_global_image_lightbox'),
			currentLinkOpenInLightbox = element.dataset.elementorOpenLightbox;

		return 'yes' === currentLinkOpenInLightbox || generalOpenInLightbox && 'no' !== currentLinkOpenInLightbox;
	},

	getLightBoxImageAttribute: function getLightBoxImageAttribute(link, type) {
		var src = ceFrontend.getGeneralSettings('elementor_lightbox_' + type + '_src');

		switch (src) {
			case 'title':
			case 'alt':
				return $(link).find('img').prop(src) || '';
			case 'caption':
				return $(link).closest('figure').find('figcaption').text() || (
					$(link).closest('[class*="widget-product"]').length ? $(link).find('img').prop('alt') : ''
				);
		}
		return '';
	},

	openLink: function openLink(event) {
		var self = this,
			element = event.currentTarget,
			$target = jQuery(event.target),
			editMode = ceFrontend.isEditMode(),
			isClickInsideElementor = !!$target.closest('#elementor').length;

		if (!this.isLightboxLink(element)) {
			if (editMode && isClickInsideElementor) {
				event.preventDefault();
			}

			return;
		}

		event.preventDefault();

		if (editMode && !ceFrontend.getGeneralSettings('elementor_enable_lightbox_in_editor')) {
			return;
		}

		var lightboxData = {};

		if (element.dataset.elementorLightbox) {
			lightboxData = JSON.parse(element.dataset.elementorLightbox);
		}

		if (lightboxData.type && 'slideshow' !== lightboxData.type) {
			this.showModal(lightboxData);

			return;
		}

		if (!element.dataset.elementorLightboxSlideshow) {
			this.showModal({
				type: 'image',
				url: element.href
			});

			return;
		}

		var slideshowID = element.dataset.elementorLightboxSlideshow;

		var $allSlideshowLinks = jQuery(this.getSettings('selectors.links')).filter(function () {
			return slideshowID === this.dataset.elementorLightboxSlideshow;
		});

		var slides = [],
			uniqueLinks = {};

		$allSlideshowLinks.each(function () {
			var slideVideo = this.dataset.elementorLightboxVideo,
				uniqueID = slideVideo || this.href;

			if (uniqueLinks[uniqueID]) {
				return;
			}

			uniqueLinks[uniqueID] = true;

			var slideIndex = this.dataset.elementorLightboxIndex;

			if (undefined === slideIndex) {
				slideIndex = $allSlideshowLinks.index(this);
			}

			var slideData = {
				image: this.href,
				index: slideIndex,
				title: self.getLightBoxImageAttribute(this, 'title'),
				description: self.getLightBoxImageAttribute(this, 'description')
			};

			if (slideVideo) {
				slideData.video = slideVideo;
			}

			slides.push(slideData);
		});

		slides.sort(function (a, b) {
			return a.index - b.index;
		});

		var initialSlide = element.dataset.elementorLightboxIndex;

		if (undefined === initialSlide) {
			initialSlide = $allSlideshowLinks.index(element);
		}

		this.showModal({
			type: 'slideshow',
			modalOptions: {
				id: 'elementor-lightbox-slideshow-' + slideshowID
			},
			slideshow: {
				slides: slides,
				swiper: {
					initialSlide: +initialSlide
				}
			}
		});
	},

	bindEvents: function bindEvents() {
		ceFrontend.elements.$document.on('click', this.getSettings('selectors.links'), this.openLink);
	},

	onSlideChange: function onSlideChange() {
		this.getSlide('prev').add(this.getSlide('next')).add(this.getSlide('active')).find('.' + this.getSettings('classes.videoWrapper')).remove();
		this.playSlideVideo();
		this.updateFooterText();
	}
});

/***/ }),

/***/ 199:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _class = function (_elementorModules$Vie) {
	_inherits(_class, _elementorModules$Vie);

	function _class() {
		_classCallCheck(this, _class);

		return _possibleConstructorReturn(this, (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments));
	}

	_createClass(_class, [{
		key: 'getDefaultSettings',
		value: function getDefaultSettings() {
			return {
				selectors: {
					links: 'a[href^="#ce-action"]'
				}
			};
		}
	}, {
		key: 'bindEvents',
		value: function bindEvents() {
			ceFrontend.elements.$document.on('click', this.getSettings('selectors.links'), this.runLinkAction.bind(this));
		}
	}, {
		key: 'initActions',
		value: function initActions() {
			this.actions = {
				lightbox: function (settings) {
					if (!ceFrontend.isEditMode() || ceFrontend.getGeneralSettings('elementor_enable_lightbox_in_editor')) {
						return ceFrontend.utils.lightbox.showModal(settings);
					}
				},
				closeLightbox: function () {
					var modal = ceFrontend.utils.lightbox.getModal();
					if (modal.isVisible()) {
						modal.hide();
					}
				},
				carousel: function (settings, event) {
					function getNearestCarousel(element, selector) {
						var r = element.getBoundingClientRect(),
							p = {
								x: r.left + r.width / 2,
								y: r.top + r.height / 2,
							},
							closest = {
								d: Infinity,
								elem: null,
							};
						$(selector || document.body).find('.slick-slider').each(function () {
							var r = this.getBoundingClientRect(),
								d = Math.hypot(Math.max(r.left - p.x, 0, p.x - r.right), Math.max(r.top - p.y, 0, p.y - r.bottom));
							if (d < closest.d) {
								closest.d = d;
								closest.elem = this;
							}
						});
						return closest.elem;
					}

					var $self = $(getNearestCarousel(event && event.currentTarget || document.activeElement, settings.selector));

					if ('goto' === settings.action) {
						$self.slick('slickGoTo', settings.goto - 1);
					} else {
						$self.slick(settings.action);
					}
				},
				quickview: function (settings) {
					var dataset = settings.id_product ? {
						idProduct: settings.id_product,
						idProductAttribute: settings.id_product_attribute || 0
					} : $(document.activeElement).closest('[data-id-product]').data() || {
						idProduct: $('input[id=product_page_product_id]:last').val()
					};
					if (dataset.idProduct) {
						ceFrontend.modules.linkActions.actions.closeLightbox();

						prestashop.emit('clickQuickView', {dataset: dataset});
					}
				},
				addToCart: function (settings) {
					var data = $(document.activeElement).closest('[data-id-product]').data(),
						idProduct = settings.id_product || data && data.idProduct;
					if (idProduct) {
						$.post(prestashop.urls.pages.cart, {
							add: 1,
							action: 'update',
							id_product: idProduct,
							token: prestashop.static_token
						}, null, 'json').then(function (resp) {
							prestashop.emit('updateCart', {
								reason: {
									idProduct: resp.id_product || idProduct,
									idProductAttribute: resp.id_product_attribute,
									idCustomization: resp.id_customization,
									linkAction: 'add-to-cart',
									cart: resp.cart
								},
								resp: resp
							});
						}).fail(function (resp) {
							prestashop.emit('handleError', {eventType: 'addProductToCart', resp: resp});
						});
					} else {
						$('form[id="add-to-cart-or-refresh"] [data-button-action="add-to-cart"]:last').click();
					}
					ceFrontend.modules.linkActions.actions.closeLightbox();
				},
				buyNow: function (settings) {
					var events = prestashop._events.updateCart;
					delete prestashop._events.updateCart;

					prestashop.once('updateCart', function (data) {
						if (data.resp && data.resp.success) {
							location.href = prestashop.urls.pages[settings.redirect || 'order'];
						} else {
							prestashop._events.updateCart = events;
							prestashop.emit('updateCart', data);
						}
					});
					ceFrontend.modules.linkActions.actions.addToCart(settings);
				}
			};
		}
	}, {
		key: 'addAction',
		value: function addAction(name, callback) {
			this.actions[name] = callback;
		}
	}, {
		key: 'runAction',
		value: function runAction(url, event) {
			url = decodeURIComponent(url);

			var actionMatch = url.match(/action=(\w+)(.+)/);

			if (!actionMatch) {
				return;
			}

			var action = this.actions[actionMatch[1]];

			if (!action) {
				return;
			}

			var settings = JSON.parse(actionMatch[2]);

			for (var _len = arguments.length, restArgs = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
				restArgs[_key - 1] = arguments[_key];
			}

			action.apply(undefined, [settings].concat(restArgs), event);
		}
	}, {
		key: 'runLinkAction',
		value: function runLinkAction(event) {
			event.preventDefault();

			this.runAction(event.currentTarget.href, event);
		}
	}, {
		key: 'runHashAction',
		value: function runHashAction() {
			if (location.hash) {
				this.runAction(location.hash);
			}
		}
	}, {
		key: 'onInit',
		value: function onInit() {
			_get(_class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype), 'onInit', this).call(this);

			this.initActions();

			// ceFrontend.on( 'components:init', this.runHashAction.bind( this ) );
		}
	}]);

	return _class;
}(elementorModules.ViewModule);

exports.default = _class;

/***/ }),

/***/ 200:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var WidgetAjaxForm = (function(c){return(c.constructor.prototype=c).constructor})({
	constructor: function WidgetAjaxForm( $element ) {
		this.$element = $element;

		this.settings = {
			selectors: {
				form: 'form',
				submitButton: '[type="submit"]'
			}
		};

		this.elements = {};
		this.elements.$form = this.$element.find( this.settings.selectors.form );
		this.elements.$submitButton = this.elements.$form.find( this.settings.selectors.submitButton );

		this.bindEvents();
	},

	bindEvents: function() {
		this.elements.$form.on( 'submit', $.proxy( this, 'handleSubmit' ) );
	},

	beforeSend: function() {
		var $form = this.elements.$form;

		$form
			.animate( { opacity: '0.45' }, 500 )
			.addClass( 'elementor-form-waiting' )
		;
		$form.find( '.elementor-message' ).remove();
		$form.find( '.elementor-error' ).removeClass( 'elementor-error' );

		$form
			.find( 'div.elementor-field-group' )
			.removeClass( 'error' )
			.find( 'span.elementor-form-help-inline' )
			.remove()
			.end()
			.find( ':input' ).attr( 'aria-invalid', 'false' )
		;
		this.elements.$submitButton
			.attr( 'disabled', 'disabled' )
			.find( '> span' )
			.prepend( '<span class="elementor-button-text elementor-form-spinner"><i class="fa fa-spinner fa-spin"></i>&nbsp;</span>' )
		;
	},

	getFormData: function() {
		var formData = new FormData( this.elements.$form[0] );
		formData.append(
			this.elements.$submitButton[0].name,
			this.elements.$submitButton[0].value
		);
		return formData;
	},

	onSuccess: function( response, status ) {
		var $form = this.elements.$form,
			insertMethod = $form.data( 'msg' ) === 'before' ? 'prepend' : 'append';

		this.elements.$submitButton
			.removeAttr( 'disabled' )
			.find( '.elementor-form-spinner' )
			.remove()
		;
		$form
			.animate( { opacity: '1' }, 100 )
			.removeClass( 'elementor-form-waiting' )
		;

		if ( response.success ) {
			var message = $form.data( 'success' ) || response.success;

			$form.trigger( 'submit_success', response );
			$form.trigger( 'form_destruct', response );
			$form.trigger( 'reset' );

			$form[insertMethod]( '<div class="elementor-message elementor-message-success" role="alert">' + message + '</div>' );
		} else {
			var message = $form.data( 'error' ) || response.errors && response.errors.join( '<br>' ) || 'Unknown error';

			$form[insertMethod]( '<div class="elementor-message elementor-message-danger" role="alert">' + message + '</div>' );
		}
	},

	onError: function( xhr, desc ) {
		var $form = this.elements.$form;

		$form.append( '<div class="elementor-message elementor-message-danger" role="alert">' + desc + '</div>' );

		this.elements.$submitButton
			.html( this.elements.$submitButton.text() )
			.removeAttr( 'disabled' )
		;
		$form
			.animate( {
				opacity: '1'
			}, 100 )
			.removeClass( 'elementor-form-waiting' )
		;
		$form.trigger( 'error' );
	},

	handleSubmit: function( event ) {
		var $form = this.elements.$form;

		event.preventDefault();

		if ( $form.hasClass( 'elementor-form-waiting' ) ) {
			return false;
		}

		this.beforeSend();

		$.ajax( {
			url: $form.attr('action'),
			type: 'POST',
			dataType: 'json',
			data: this.getFormData(),
			processData: false,
			contentType: false,
			success: $.proxy( this, 'onSuccess' ),
			error: $.proxy( this, 'onError' )
		} );
	}
});

module.exports = function( $scope, $ ) {
	new WidgetAjaxForm( $scope );
};

/***/ }),

/***/ 201:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = elementorModules.frontend.handlers.Base.extend({

	getDefaultSettings: function getDefaultSettings() {
		return {
			selectors: {
				mainSwiper: '.elementor-main-swiper',
				swiperSlide: '.swiper-slide'
			},
			zoom: {
				enabled: true,
				toggle: false
			},
			slidesPerView: {
				desktop: 3,
				tablet: 2,
				mobile: 1
			}
		};
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors');

		var elements = {
			$mainSwiper: this.$element.find(selectors.mainSwiper)
		};

		elements.$mainSwiperSlides = elements.$mainSwiper.find(selectors.swiperSlide);

		return elements;
	},

	getSlidesCount: function getSlidesCount() {
		return this.elements.$mainSwiperSlides.length;
	},

	getInitialSlide: function getInitialSlide() {
		var editSettings = this.getEditSettings();

		return editSettings.activeItemIndex ? editSettings.activeItemIndex - 1 : 0;
	},

	getEffect: function getEffect() {
		return this.getElementSettings('effect');
	},

	getDeviceSlidesPerView: function getDeviceSlidesPerView(device) {
		var slidesPerViewKey = 'slides_per_view' + ('desktop' === device ? '' : '_' + device);

		return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesPerViewKey) || this.getSettings('slidesPerView')[device]);
	},

	getSlidesPerView: function getSlidesPerView(device) {
		if ('slide' === this.getEffect()) {
			return this.getDeviceSlidesPerView(device);
		}

		return 1;
	},

	getDesktopSlidesPerView: function getDesktopSlidesPerView() {
		return this.getSlidesPerView('desktop');
	},

	getTabletSlidesPerView: function getTabletSlidesPerView() {
		return this.getSlidesPerView('tablet');
	},

	getMobileSlidesPerView: function getMobileSlidesPerView() {
		return this.getSlidesPerView('mobile');
	},

	getDeviceSlidesToScroll: function getDeviceSlidesToScroll(device) {
		var slidesToScrollKey = 'slides_to_scroll' + ('desktop' === device ? '' : '_' + device);

		return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesToScrollKey) || 1);
	},

	getSlidesToScroll: function getSlidesToScroll(device) {
		if ('slide' === this.getEffect()) {
			return this.getDeviceSlidesToScroll(device);
		}

		return 1;
	},

	getDesktopSlidesToScroll: function getDesktopSlidesToScroll() {
		return this.getSlidesToScroll('desktop');
	},

	getTabletSlidesToScroll: function getTabletSlidesToScroll() {
		return this.getSlidesToScroll('tablet');
	},

	getMobileSlidesToScroll: function getMobileSlidesToScroll() {
		return this.getSlidesToScroll('mobile');
	},

	getSpaceBetween: function getSpaceBetween(device) {
		var propertyName = 'space_between';

		if (device && 'desktop' !== device) {
			propertyName += '_' + device;
		}
		var property = this.getElementSettings(propertyName);

		return property && property.size || 0;
	},

	getSwiperOptions: function getSwiperOptions() {
		var elementSettings = this.getElementSettings();

		// TODO: Temp migration for old saved values since 2.2.0
		if ('progress' === elementSettings.pagination) {
			elementSettings.pagination = 'progressbar';
		}

		var swiperOptions = {
			grabCursor: true,
			initialSlide: this.getInitialSlide(),
			centeredSlides: elementSettings.centered_slides,
			slidesPerView: this.getDesktopSlidesPerView(),
			slidesPerGroup: this.getDesktopSlidesToScroll(),
			spaceBetween: this.getSpaceBetween(),
			loop: 'yes' === elementSettings.loop,
			speed: elementSettings.speed,
			effect: this.getEffect()
		};

		if (elementSettings.show_arrows) {
			swiperOptions.navigation = {
				prevEl: '.elementor-swiper-button-prev',
				nextEl: '.elementor-swiper-button-next'
			};
		}

		if (elementSettings.pagination) {
			swiperOptions.pagination = {
				el: '.swiper-pagination',
				type: elementSettings.pagination,
				clickable: true
			};
		}

		if ('cube' !== this.getEffect()) {
			var breakpointsSettings = {},
				breakpoints = ceFrontend.config.breakpoints;

			breakpointsSettings[breakpoints.lg - 1] = {
				slidesPerView: this.getTabletSlidesPerView(),
				slidesPerGroup: this.getTabletSlidesToScroll(),
				spaceBetween: this.getSpaceBetween('tablet')
			};

			breakpointsSettings[breakpoints.md - 1] = {
				slidesPerView: this.getMobileSlidesPerView(),
				slidesPerGroup: this.getMobileSlidesToScroll(),
				spaceBetween: this.getSpaceBetween('mobile')
			};

			swiperOptions.breakpoints = breakpointsSettings;
		}

		if (!this.isEdit && elementSettings.autoplay) {
			swiperOptions.autoplay = {
				delay: elementSettings.autoplay_speed,
				disableOnInteraction: !!elementSettings.pause_on_interaction
			};
		}

		return swiperOptions;
	},

	updateSpaceBetween: function updateSpaceBetween(swiper, propertyName) {
		var deviceMatch = propertyName.match('space_between_(.*)'),
			device = deviceMatch ? deviceMatch[1] : 'desktop',
			newSpaceBetween = this.getSpaceBetween(device),
			breakpoints = ceFrontend.config.breakpoints;

		if ('desktop' !== device) {
			var breakpointDictionary = {
				tablet: breakpoints.lg - 1,
				mobile: breakpoints.md - 1
			};

			swiper.params.breakpoints[breakpointDictionary[device]].spaceBetween = newSpaceBetween;
		} else {
			swiper.originalParams.spaceBetween = newSpaceBetween;
		}

		swiper.params.spaceBetween = newSpaceBetween;

		swiper.update();
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.swipers = {};

		if (1 >= this.getSlidesCount()) {
			return;
		}

		this.swipers.main = new Swiper(this.elements.$mainSwiper, this.getSwiperOptions());
	},

	onElementChange: function onElementChange(propertyName) {
		if (1 >= this.getSlidesCount()) {
			return;
		}

		if (0 === propertyName.indexOf('width')) {
			this.swipers.main.update();
		}

		if (0 === propertyName.indexOf('space_between')) {
			this.updateSpaceBetween(this.swipers.main, propertyName);
		}
	},

	onEditSettingsChange: function onEditSettingsChange(propertyName) {
		if (1 >= this.getSlidesCount()) {
			return;
		}

		if ('activeItemIndex' === propertyName) {
			this.swipers.main.slideToLoop(this.getEditSettings('activeItemIndex') - 1);
		}
	}
});

/***/ }),

/***/ 202:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var ProductImages, Base = __webpack_require__(201);

ProductImages = Base.extend({

	slideshowSpecialElementSettings: ['slides_per_view', 'slides_per_view_tablet', 'slides_per_view_mobile'],

	isSlideshow: function isSlideshow() {
		return 'slideshow' === this.getElementSettings('skin');
	},

	getDefaultSettings: function getDefaultSettings() {
		var defaultSettings = Base.prototype.getDefaultSettings.apply(this, arguments);

		if (this.isSlideshow()) {
			defaultSettings.selectors.thumbsSwiper = '.elementor-thumbnails-swiper';

			defaultSettings.slidesPerView = {
				desktop: 5,
				tablet: 4,
				mobile: 3
			};
		}

		return defaultSettings;
	},

	getElementSettings: function getElementSettings(setting) {
		if (-1 !== this.slideshowSpecialElementSettings.indexOf(setting) && this.isSlideshow()) {
			setting = 'slideshow_' + setting;
		}

		return Base.prototype.getElementSettings.call(this, setting);
	},

	getDefaultElements: function getDefaultElements() {
		var selectors = this.getSettings('selectors'),
			defaultElements = Base.prototype.getDefaultElements.apply(this, arguments);

		if (this.isSlideshow()) {
			defaultElements.$thumbsSwiper = this.$element.find(selectors.thumbsSwiper);
		}

		return defaultElements;
	},

	getSlidesPerView: function getSlidesPerView(device) {
		if (this.isSlideshow()) {
			return 1;
		}

		if ('coverflow' === this.getEffect()) {
			return this.getDeviceSlidesPerView(device);
		}

		return Base.prototype.getSlidesPerView.apply(this, arguments);
	},

	getThumbSpaceBetween: function getThumbSpaceBetween(device) {
		var propertyName = 'thumb_space_between';

		if (device && 'desktop' !== device) {
			propertyName += '_' + device;
		}

		return this.getElementSettings(propertyName).size || 0;
	},

	getSwiperOptions: function getSwiperOptions() {
		var options = Base.prototype.getSwiperOptions.apply(this, arguments);

		if (this.isSlideshow()) {
			options.loopedSlides = this.getSlidesCount();

			delete options.pagination;
			delete options.breakpoints;
		}

		return options;
	},

	onInit: function onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

		this.swipers = {};

		var slidesCount = this.getSlidesCount();

		if (!slidesCount) {
			return;
		}

		var mainSliderOptions = this.getSwiperOptions();

		if (this.isSlideshow()) {
			var elementSettings = this.getElementSettings(),
				breakpointsSettings = {},
				breakpoints = ceFrontend.config.breakpoints,
				slidesPerView = this.getSettings('slidesPerView');

			breakpointsSettings[breakpoints.lg - 1] = {
				slidesPerView: +elementSettings.slides_per_view_tablet || slidesPerView.tablet,
				spaceBetween: this.getThumbSpaceBetween('tablet')
			};

			breakpointsSettings[breakpoints.md - 1] = {
				slidesPerView: +elementSettings.slides_per_view_mobile || slidesPerView.mobile,
				spaceBetween: this.getThumbSpaceBetween('mobile')
			};

			var thumbsSliderOptions = {
				slidesPerView: +elementSettings.slides_per_view || slidesPerView.desktop,
				initialSlide: this.getInitialSlide(),
				slideToClickedSlide: true,
				spaceBetween: this.getThumbSpaceBetween(),
				threshold: 2,
				watchSlidesVisibility: true,
				watchSlidesProgress: true,
				breakpoints: breakpointsSettings,
				direction: 'bottom' === elementSettings.position ? 'horizontal' : 'vertical'
			};

			var thumbs = this.swipers.thumbs = new Swiper(this.elements.$thumbsSwiper, thumbsSliderOptions);

			mainSliderOptions.thumbs = {
				swiper: this.swipers.thumbs,
				slideThumbActiveClass: 'swiper-slide-active'
			};
			mainSliderOptions.on = {
				slideChange: function () {
					setTimeout(function () {
						var $active = $(thumbs.slides).filter('.swiper-slide-active');

						thumbs.slides.removeClass('swiper-slide-prev swiper-slide-next');

						$active.prevAll().addClass('swiper-slide-prev');
						$active.nextAll().addClass('swiper-slide-next');
					});
				},
				sliderFirstMove: function () {
					this.zoom.out();

					this.$el.addClass('ce-swiper-dragging');
				},
				touchEnd: function () {
					this.$el.removeClass('ce-swiper-dragging');
				}
			};

			this.elements.$mainSwiper
				.on('mouseenter.ceZoom', '.swiper-zoom-container', this.onZoomIn.bind(this))
				.on('mouseleave.ceZoom', '.swiper-zoom-container', this.onZoomOut.bind(this))
			;
		}

		this.swipers.main = new Swiper(this.elements.$mainSwiper, mainSliderOptions);
		this.swipers.thumbs && (this.swipers.thumbs.main = this.swipers.main);
	},

	onZoomIn: function onZoomIn() {
		var data = this.swipers.main.touchEventsData;

		if (data.isMoved || Date.now() - data.touchStartTime < 200) {
			return;
		}

		this.swipers.main.zoom.in();

		this.elements.$mainSwiper.on('mousemove.ceZoom', '.swiper-zoom-container img', function (e) {
			var r = this.parentNode.getBoundingClientRect(),
				x = (100 * (e.clientX - r.left) / r.width).toFixed(3),
				y = (100 * (e.clientY - r.top) / r.height).toFixed(3);

			this.style.transformOrigin = x + '% ' + y + '%';
			this.style.transitionDuration = '0s';
		});
	},

	onZoomOut: function onZoomOut() {
		this.swipers.main.zoom.out();

		this.elements.$mainSwiper.off('mousemove.ceZoom')
	},

	onElementChange: function onElementChange(propertyName) {
		if (1 >= this.getSlidesCount()) {
			return;
		}

		if (!this.isSlideshow()) {
			Base.prototype.onElementChange.apply(this, arguments);

			return;
		}

		if (0 === propertyName.indexOf('width')) {
			this.swipers.main.update();
			this.swipers.thumbs.update();
		}

		if (0 === propertyName.indexOf('space_between')) {
			this.updateSpaceBetween(this.swipers.thumbs, propertyName);
		}
	}
});

module.exports = function ($scope) {
	new ProductImages({ $element: $scope });
};

/***/ })

/******/ });

prestashop.on('updateCart', function onUpdateCart(data) {
	if (data.resp && data.resp.hasError) {
		return window.WishlistEventBus && WishlistEventBus.$emit('showToast', {
			detail: {
				type: 'error',
				message: data.resp.errors.join(' '),
			},
		}) || alert(data.resp.errors.join("\n"));
	}
	if (data.resp && data.resp.success) {
		var input = $('#add-to-cart-or-refresh > [name=id_product][value=' + data.resp.id_product + ']')[0];

		input && ceFrontend.refreshProduct(input.form);
	}
});

ceFrontend.refreshProduct = function (form, quickview) {
	var formData = new FormData(form);
	formData.set('refresh', 'product');
	quickview && formData.set('quickview', quickview);
	formData.set('quantity_wanted', formData.get('qty'));
	formData.delete('qty');

	this.refreshProduct.xhr && this.refreshProduct.xhr.readyState !== 4 && this.refreshProduct.xhr.abort();

	this.refreshProduct.xhr = $.ajax(window.elementor && elementor.config.document.urls.permalink || prestashop.urls.pages.product, {
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		dataType: 'json',
		success: function (data) {
			var $content = $(data.product_content),
				exclude = [
					'.elementor-widget-product-quantity',
					'.elementor-widget-product-description',
					'.elementor-widget-product-description-short',
					'.elementor-widget-product-carousel',
					'.elementor-widget-product-grid',
					'.elementor-widget-product-box',
				].join();

			// Refresh Widgets
			$content.find('.elementor-widget:not(' + exclude + ') > .elementor-widget-container').each(function () {
				var id = $(this.parentNode).data('id'),
					widgetContainer = $('.elementor-element-' + id + ' > .elementor-widget-container')[0];
				if (widgetContainer) {
					$(widgetContainer).replaceWith(this);
					ceFrontend.elementsHandler.runReadyTrigger(this.parentNode);
				}
			});

			// Refresh Quantity
			$(form.elements.qty).attr('min', data.product_minimal_quantity).each(function () {
				if (this.value < data.product_minimal_quantity) {
					this.value = data.product_minimal_quantity;
				}
			});

			+data.is_quick_view || prestashop.emit('updatedProduct', data);
		}
	});
};

$('html').on('click.ce', '.elementor-nav-tabs a', function onClickNavTab(e) {
	e.preventDefault();

	if (~this.className.indexOf('elementor-item-active')) {
		return;
	}
	var index = $(this.parentNode).index(),
		$col = $(this).closest('.elementor-container').find('> .elementor-row > .elementor-column').eq(index),
		editMode = ceFrontend.isEditMode();

	$(this).closest('.elementor-nav').find('.elementor-item-active').removeClass('elementor-item-active');
	$(this).addClass('elementor-item-active');
	$col.addClass('elementor-active').siblings().removeClass('elementor-active');

	$col.find('.animated').addBack('.animated').each(function () {
		var $this = $(this),
			settings = editMode ? elementor.helpers.getModelById($this.data('id')).get('settings').attributes : $this.data('settings') || {},
			animation = $this.hasClass('elementor-widget') ? '_animation' : 'animation';

		$this.addClass('elementor-invisible').removeClass(ceFrontend.getCurrentDeviceSetting(settings, animation));

		setTimeout(function () {
			$this.removeClass([
				settings[animation + '_mobile'] || '',
				settings[animation + '_tablet'] || '',
				settings[animation] || ''
			].join(' '));
		});
		setTimeout(function () {
			$this.removeClass('elementor-invisible').addClass(ceFrontend.getCurrentDeviceSetting(settings, animation));
		}, settings[animation + '_delay'] || 0)
	});
}).on('keydown.ce', '.elementor-field[name=qty]', function onEnterDownQuantity(e) {
	if (13 === e.keyCode) {
		if (parseInt(this.value, 10) >= parseInt(this.min, 10)) {
			return;
		}
		e.preventDefault();
	}
}).on('keyup.ce', '.elementor-field[name=qty]', function onEnterUpQuantity(e) {
	if (13 === e.keyCode) {
		if (parseInt(this.value, 10) >= parseInt(this.min, 10)) {
			this.blur();

			ceFrontend.modules.linkActions.actions.closeLightbox();
		}
	}
}).on('click.ce', '.ce-add-to-wishlist', function onClickAddToWishlist(e) {
	e.preventDefault();

	if (!window.WishlistEventBus) {
		return alert('Please install & enable the Wishlist module!');
	}
	if (!prestashop.customer.is_logged) {
		return WishlistEventBus.$emit('showLogin');
	}
	var $this = $(this);

	if (!$this.hasClass('elementor-active')) {
		WishlistEventBus.$emit('showAddToWishList', {
			detail: {
				forceOpen: true,
				productId: $this.data('productId'),
				productAttributeId: $this.data('productAttributeId'),
			},
		});
	} else {
		var product = productsAlreadyTagged.find(function (tagged) {
			return tagged.id_product == $this.data('productId')
				&& tagged.id_product_attribute == $this.data('productAttributeId');
		});
		product && $.post(this.href, {
			action: 'deleteProductFromWishlist',
			params: {
				idWishList: product.id_wishlist,
				id_product: product.id_product,
				id_product_attribute: product.id_product_attribute,
			},
		}, function onSuccessDeleteProductFromWishlist(response) {
			$('.ce-add-to-wishlist' +
				'[data-product-id=' + product.id_product + ']' +
				'[data-product-attribute-id=' + product.id_product_attribute + ']'
			).removeClass('elementor-active').find('i').attr('class', 'fa fa-heart-o');

			productsAlreadyTagged = productsAlreadyTagged.filter(function (tagged) {
				return tagged.id_product != product.id_product
					&& tagged.id_product_attribute != product.id_product_attribute;
			});
			WishlistEventBus.$emit('showToast', {
				detail: {
					type: response.success ? 'success' : 'error',
					message: response.message,
				},
			});
		}, 'json');
	}
}).on('click.ce', '[data-link-action=quickview]', function (e) {
	// Quick View
	e.preventDefault();
	e.stopPropagation();

	ceFrontend.modules.linkActions.actions.quickview({});
}).on('click.ce-comments', 'a[href="#product-comments-list-header"]', function (e) {
	var $comments = $('#product-comments-list-header'),
		$section = $comments.closest('.elementor-section-tabbed');
	if ($section.length) {
		var column = $section.find('> .elementor-container > .elementor-row > .elementor-column').toArray().find(function (el) {
			return $(el).find($comments).length;
		});
		$section.find('> .elementor-container > .elementor-nav-tabs a').eq($(column).index()).click();
	}
	$('html, body').animate({
		scrollTop: $($section[0] || $comments[0]).offset().top
	}, 500, 'swing', $(this).hasClass('elementor-button--post-comment') ? function() {
		$('.post-product-comment').click();
	} : void 0);
	e.preventDefault();
}).on('change.ce', '[form="add-to-cart-or-refresh"]', function (e) {
	// Refresh Product on change
	ceFrontend.refreshProduct(this.form, $(this).closest('#ce-product-quick-view').length);
}).on('input.ce', '[form="add-to-cart-or-refresh"][name=qty]', function () {
	// Update Product on input
	clearTimeout(ceFrontend.refreshProduct.timeout);

	if ('' !== this.value) ceFrontend.refreshProduct.timeout = setTimeout(function () {
		ceFrontend.refreshProduct(this.form, $(this).closest('#ce-product-quick-view').length);
	}.bind(this), 200);
});

$(function ceReady() {
	// Fix for category description
	$('#js-product-list-header').attr('id', 'product-list-header');

	// Init product quick view
	if (ceFrontend.config.productQuickView) {
		delete prestashop._events.clickQuickView;

		prestashop.on('clickQuickView', function onClickQuickView(e) {
			$.post(prestashop.urls.pages.product, {
				ajax: 1,
				action: 'quickview',
				id_product: e.dataset.idProduct,
				id_product_attribute: e.dataset.idProductAttribute,
				id_ce_theme: ceFrontend.config.productQuickView
			}, null, 'json').then(function onSuccessQuickView(resp) {
				var lightbox = ceFrontend.utils.lightbox,
					$html = $(resp.quickview_html),
					settings = $html.filter('.elementor').data('elementorSettings'),
					modal = lightbox.getModal(),
					elem = modal.getElements();

				elem.message.removeClass([
					'zoomIn',
					settings.entrance_animation || '',
					settings.entrance_animation_tablet || '',
					settings.entrance_animation_mobile || ''
				].join(' ')).addClass(
					ceFrontend.getCurrentDeviceSetting(settings, 'entrance_animation')
				);

				$('[form="add-to-cart-or-refresh"]').attr('form', 'ce-add-to-cart-or-refresh');
				$('#add-to-cart-or-refresh').attr('id', 'ce-add-to-cart-or-refresh');

				lightbox.showModal({
					modalOptions: {id: 'ce-product-quick-view'},
					html: $html
				});

				modal.off('hide').on('hide', function onHideQuickView() {
					$('[form="ce-add-to-cart-or-refresh"]').attr('form', 'add-to-cart-or-refresh');
					$('#ce-add-to-cart-or-refresh').attr('id', 'add-to-cart-or-refresh');

					setTimeout(function () {
						elem.closeButton.prependTo(elem.widgetContent);
						elem.message.removeClass([
							settings.entrance_animation || '',
							settings.entrance_animation_tablet || '',
							settings.entrance_animation_mobile || ''
						].join(' '));

						modal.setMessage('');
					}, 400);
				});

				elem.message.addClass('elementor-lightbox-prevent-close')
					.prepend('outside' === settings.close_button_position ? null : elem.closeButton)
					.find('.elementor-widget').each(function () {
						ceFrontend.elementsHandler.runReadyTrigger(this);
					})
				;
			}).fail(function (resp) {
				prestashop.emit('handleError', {eventType: 'clickQuickView', resp: resp});
			});
		});
	}
	// handle Added to Wishlist
	window.WishlistEventBus && WishlistEventBus.$on('addedToWishlist', function onAddedToWishlist(e) {
		var product = productsAlreadyTagged[productsAlreadyTagged.length - 1];
		$('.ce-add-to-wishlist' +
			'[data-product-id=' + product.id_product + ']' +
			'[data-product-attribute-id=' + product.id_product_attribute + ']'
		).addClass('elementor-active').find('i').attr('class', 'fa fa-heart');
	});
});
