/*!
 * Creative Elements - live Theme & Page Builder
 * Copyright 2019-2022 WebshopWorks.com
 */

$(window).on('elementor:init', function onElementorInit() {
	if ('product-miniature' === elementor.config.document.type) {
		var pageModel = elementor.settings.page.model;

		$('#elementor-preview-responsive-wrapper').css({
			height: '100%',
			margin: '0 auto',
			padding: 0,
			transitionDuration: '0s',
		});
		elementor.on('preview:loaded', function () {
			var minWidth = pageModel.getControl('preview_width').min,
				controlView;
			$(elementor.$previewContents[0].body).css({
				width: pageModel.get('preview_width'),
				minWidth: minWidth,
			}).resizable({
				handles: 'e, w',
				start: function () {
					var pageView = elementor.getPanelView().getCurrentPageView(),
						device = ceFrontend.getCurrentDeviceMode();
					controlView = 'preview_settings' !== pageView.activeSection ? null : pageView.getControlViewByName(
						'desktop' === device ? 'preview_width' : 'preview_width_' + device
					);
					elementor.$previewContents[0].documentElement.style.cursor = 'ew-resize';
				},
				resize: function (e, ui) {
					var device = ceFrontend.getCurrentDeviceMode(),
						width = 2 * (ui.size.width - ui.originalSize.width) + ui.originalSize.width;
					if (width < minWidth) {
						width = minWidth;
					}
					this.style.width = width + 'px';
					this.style.left = '';
					this.style.right = '';

					pageModel.set('desktop' === device ? 'preview_width' : 'preview_width_' + device, width);

					controlView && controlView.render();
				},
				stop: function () {
					elementor.$previewContents[0].documentElement.style.cursor = '';
					elementor.$previewContents.children().on('click.ce-resize', function (e) {
						e.stopPropagation();
					});
					setTimeout(function () {
						elementor.$previewContents.children().off('click.ce-resize');
					});
				},
			});
		});
		elementor.settings.page.model.on('change', function onChangePreviewWidth() {
            var device = ceFrontend.getCurrentDeviceMode(),
                preview_width = 'desktop' === device ? 'preview_width' : 'preview_width_' + device;
			if (preview_width in this.changed) {
				elementor.$previewContents[0].body.style.width = this.changed[preview_width] + 'px';
			}
		});
		elementor.channels.deviceMode.on('change', function onChangeDeviceMode() {
			var width = ceFrontend.getCurrentDeviceSetting(pageModel.attributes, 'preview_width');

			elementor.$previewContents[0].body.style.width = width + 'px';
		});
	}

	elementor.channels.editor.on('section:activated', function onSectionActivated(sectionName, editor) {
		var editedElement = editor.getOption('editedElementView'),
			widgetType = editedElement.model.get('widgetType');

		if ('flip-box' === widgetType) {
			// init flip box back
			var isSideB = ['section_b', 'section_style_b', 'section_style_button'].indexOf(sectionName) > -1,
				$backLayer = editedElement.$el.find('.elementor-flip-box-back');

			editedElement.$el.toggleClass('elementor-flip-box--flipped', isSideB);

			if (isSideB) {
				$backLayer.css('transition', 'none');
			} else {
				setTimeout(function () {
					$backLayer.css('transition', '');
				}, 10);
			}
		} else if ('ajax-search' === widgetType) {
			// init search results
			editedElement.$el.find('.elementor-search__products').css({
				display: ['section_results_style', 'section_products_style'].indexOf(sectionName) < 0 ? 'none' : ''
			});
		}
	});

	var tabNumber = '<span class="ce-tab-num"></span>';
	// Refresh Tabbed Section
	elementor.hooks.addAction('panel/open_editor/column', function (panel, model, column) {
		if (column._parent.model.get('settings').get('tabs')) {
			var index = column.$el.index(),
				$items = column.$el.parent().prev().find('a');

			ceFrontend.elements.window.jQuery($items[index]).click();

			elementor.$previewContents[0].activeElement && elementor.$previewContents[0].activeElement.blur();
		}
	});
	function addTabbedColumn(event, attributes) {
		var $column = elementor.$previewElementorEl.find('[data-id=' + attributes.id + ']'),
			$litems = $column.parent().prev().find('li'),
			index = $column.index(),
			settings = attributes.settings || attributes,
			isNew = $.isEmptyObject(settings);

		isNew || 'history:after:add' === event ? index-- : $litems.find('a').removeClass('elementor-item-active');

		var $a = $litems.eq(0).clone().insertAfter($litems[index])
			.find('a').html(settings._title || tabNumber);

		isNew || 'history:after:add' === event ? $a.removeClass('elementor-item-active').click() : $a.addClass('elementor-item-active');
	}
	elementor.channels.data.on('element:after:add', function (model) {
		if (!model) return;

		var attributes = model.attributes || model;

		'column' === attributes.elType && addTabbedColumn('element:after:add', attributes);
	});
	elementor.channels.data.on('history:after:add', function (model) {
		if (!model) return;

		var attributes = model.attributes || model;

		'column' === attributes.elType && addTabbedColumn('history:after:add', attributes);
	});
	elementor.channels.data.on('element:before:remove history:before:remove', function (model) {
		var attributes = model.attributes || model;

		if ('column' === attributes.elType) {
			var $column = elementor.$previewElementorEl.find('[data-id=' + attributes.id + ']');
				$items = $column.parent().prev().find('a');

			$items.eq($column.index()).parent().remove();
			$items.eq(0).click();
		}
	});
	// Sort Tabs
	elementor.channels.data.on('drag:after:update', function (model) {
		var attributes = model.attributes || model;

		if ('column' === attributes.elType) {
			var view = elementor.channels.data.request('dragging:parent:view');
			if (view.model.get('settings').get('tabs')) {
				var columns = view.model.get('elements').models;

				view.$el.find('> .elementor-container > .elementor-nav-tabs a').each(function (i) {
					$(this).html(columns[i].get('settings').get('_title') || tabNumber);
				});
			}
		}
	});
	// Change Tab Title
	elementor.channels.editor.on('change:column:_title', function (control, column) {
		var index = column.$el.index();

		column.$el.parent().prev().find('a').eq(index).html(
			control.options.elementSettingsModel.get('_title') || tabNumber
		);
	});
	elementor.channels.data.on('history:after:change', function (model, changed, isRedo) {
		var attributes = model.attributes || model;

		if ('column' === attributes.elType && changed._title) {
			var $column = elementor.$previewElementorEl.find('[data-id=' + attributes.id + ']');
				$items = $column.parent().prev().find('a'),
				index = $column.index();

			$items.eq(index).html(changed._title[isRedo ? 'new' : 'old'] || tabNumber);
		}
	});
	elementor.channels.editor.on('enter:column:_title', function (model) {
		var $column = elementor.$previewElementorEl.find('.elementor-element-editable'),
			$items = $column.parent().prev().find('a'),
			index = $column.index();

		$items.eq(index).html(model.get('_title') || '<span class="ce-tab-num"></span>');
		$('.elementor-control-_title input[data-setting="_title"]').val(model.get('_title'));
	});
});

$(function () {elementor.on('preview:loaded', function () {
	// init widgets
	ceFrontend.hooks.addAction('frontend/element_ready/widget', function ($widget, $) {
		// remote render fix
		if ($widget.find('.ce-remote-render').length) {
			var render = elementor.helpers.renderWidgets,
				widget = elementor.helpers.getModelById('' + $widget.data('id')),
				data = widget.toJSON();

			if (Date.now() - render.timestamp > render.delay) {
				render.actions = {};
			}
			render.actions['render_' + data.id] = {
				action: 'render_' + data.id,
				data: data
			};
			clearTimeout(render.timeout);
			render.timeout = setTimeout(function() {
				render.xhr = $.post(elementor.config.document.urls.preview, {
					render: 'widget',
					editor_post_id: elementor.config.document.id,
					actions: JSON.stringify(render.actions),
				}, null, 'json').always(function (arg, status) {
					var data = 'success' === status ? arg : arg.responseJSON || {};
					for (var action in data) {
						elementor.helpers.getModelById(action.split('_')[1]).onRemoteGetHtml(data);
					}
				});
			}, render.delay);
			render.timestamp = Date.now();
		}
	});
	// Auto open Library for Theme Builder
	if (elementor.config.post_id.substr(-6, 2) == 17 && !elementor.config.data.length) {
		elementor.templates.startModal()
	}
	// Theme Builder
	elementor.channels.editor.on('elementorThemeBuilder:ApplyPreview', function saveAndReload() {
		elementor.saver.saveAutoSave({
			onSuccess: function onSuccess() {
				elementor.saver.setFlagEditorChange(false);
				location.reload();
			}
		});
	});
	// Play entrance animations for tabs in editor
	elementor.$previewElementorEl.on('mouseup.ce', '.elementor-nav-tabs a', function () {
		if (~this.className.indexOf('elementor-item-active')) {
			return;
		}
		var index = $(this.parentNode).index(),
			$col = $(this).closest('.elementor-container').find('> .elementor-row > .elementor-column').eq(index),
			$animated = $col.find('.animated').addBack('.animated');

		$animated.each(function () {
			var id = $(this).data('id'),
				settings = elementor.helpers.getModelById(id).get('settings').attributes;
			$(this).removeClass(settings.animation || settings._animation);
		});
		$animated.length && setTimeout(function() {
			$animated.each(function () {
				var id = $(this).data('id'),
					settings = elementor.helpers.getModelById(id).get('settings').attributes;
				$(this).addClass(settings.animation || settings._animation);
			});
		});
	});
})});

$(function onReady() {
	// init page custom CSS
	var addPageCustomCss = function() {
		var customCSS = elementor.settings.page.model.get('custom_css');

		if (customCSS) {
			customCSS = customCSS.replace(/selector/g, elementor.config.settings.page.cssWrapperSelector);

			elementor.settings.page.getControlsCSS().elements.$stylesheetElement.append(customCSS);
		}
	};
	elementor.on('preview:loaded', addPageCustomCss);
	elementor.settings.page.model.on('change', function () {
		if ('custom_css' in this.changed) {
			addPageCustomCss();
		}
	});

	// init element custom CSS
	elementor.hooks.addFilter('editor/style/styleText', function addCustomCss(css, view) {
		var model = view.getEditModel(),
			customCSS = model.get('settings').get('custom_css');

		if (customCSS) {
			css += customCSS.replace(/selector/g, '.elementor-element.elementor-element-' + view.model.id);
		}

		return css;
	});

	// init Products Cache
	elementor.productsCache = {};
	elementor.getProductName = function (id) {
		return this.productsCache[id] ? this.productsCache[id].name : '';
	};
	elementor.getProductImage = function (id) {
		return this.productsCache[id] ? this.productsCache[id].image : '';
	};

	// init File Manager
	elementor.fileManager = elementor.dialogsManager.createWidget('lightbox', {
		id: 'ce-file-manager-modal',
		closeButton: true,
		headerMessage: window.tinyMCE ? tinyMCE.i18n.translate('File manager') : 'File manager',

		onReady: function() {
			var $message = this.getElements('message').html(
				'<iframe id="ce-file-manager" width="100%" height="750"></iframe>'
			);
			this.iframe = $message.children()[0];
			this.url = baseAdminDir + 'filemanager/dialog.php?type=1&field_id=3';

			this.open = function(fieldId) {
				this.fieldId = fieldId;

				if (this.iframe.contentWindow) {
					this.initFrame();
					this.getElements('widget').appendTo = function() {
						return this;
					};
					this.show();
				} else {
					$message.prepend(
						$('#tmpl-elementor-template-library-loading').html()
					);
					this.iframe.src = this.url + '&fldr=' + (localStorage.ceImgFldr || '');
					this.show(0);
				}
			};
			this.initFrame = function() {
				var $doc = $(this.iframe).contents();

				localStorage.ceImgFldr = $doc.find('#fldr_value').val();

				$doc.find('a.link').attr('data-field_id', this.fieldId);

				this.iframe.contentWindow.close_window = this.hide.bind(this);

				// WEBP
				$doc.find('li[data-name$=".webp"], li[data-name$=".WEBP"]').each(function () {
					$(this).find('.img-container img').attr({
						src: $(this).find('a.preview').data('url'),
					}).css({
						height: '100%',
						objectFit: 'cover',
					});
					$(this).find('.filetype').css('background', 'rgba(0,0,0,0.2)');
					$(this).find('.cover').remove();

					var $form = $(this).find('.download-form').attr('onsubmit', 'event.preventDefault()');
					$form.find('a[onclick*=submit]').attr({
						href: $form.find('.preview').data('url'),
						download: $form[0].elements.name.value,
					});
					$form.find('.rename-file, .delete-file').attr('data-path', '');
				});
			};
			this.iframe.onload = this.initFrame.bind(this);
		},

		onHide: function() {
			var $input = $('#' + this.fieldId);

			$input.val(
				$input.val().replace(location.origin, '')
			).trigger('input');
		},
	});

	// helper for get model by id
	elementor.helpers.getModelById = function(id, models) {
		models = models || elementor.elements.models;

		for (var i = models.length; i--;) {
			if (models[i].id === id) {
				return models[i];
			}
			if (models[i].attributes.elements.models.length) {
				var model = this.getModelById(id, models[i].attributes.elements.models);

				if (model) {
					return model;
				}
			}
		}
	};

	elementor.helpers.renderWidgets = {
		delay: 100,
		timestamp: 0,
		timeout: null,
		actions: {},
	};

	elementor.helpers.getParentSectionModel = function(id, sections) {
		sections = sections || elementor.elements.models;

		for (var i = sections.length; i--;) {
			if ('section' !== sections[i].attributes.elType) {
				continue;
			}
			var sectionModel = sections[i].attributes.settings;

			if (sections[i].attributes.elements.models.length) {
				var columns = sections[i].attributes.elements.models;

				for (var j = columns.length; j--;) {
					if (columns[j].id === id) {
						return sectionModel;
					}
					if (columns[j].attributes.settings.cid === id) {
						return sectionModel;
					}
					if (columns[j].attributes.elements.models.length) {
						var result = this.getParentSectionModel(id, columns[j].attributes.elements.models);
						if (result) {
							return result;
						}
					}
				}
			}
		}
	};

	// fix: add home_url to relative image path
	elementor.imagesManager.getImageUrl = function(image) {
		var url = image.url;

		if (url && url.indexOf('://') < 0) {
			url = elementor.config.home_url + url;
		}
		return url;
	};

	elementor.on('preview:loaded', function onPreviewLoaded() {
		// fix for View Page in force edit mode
		var href = elementor.$preview[0].contentWindow.location.href;

		if (~href.indexOf('&force=1&')) {
			elementor.config.post_permalink = href.replace(/&force=1&.*/, '');
		}

		// scroll to content area
		var contentTop = elementor.$previewContents.find('#elementor .elementor-section-wrap').offset().top;
		if (contentTop > $(window).height() * 0.66) {
			elementor.$previewContents.find('html, body').animate({
				scrollTop: contentTop - 30
			}, 400);
		}

		// fix for multiple Global colors / fonts
		elementor.$previewContents.find('#elementor-global-css, link[href*="css/ce/global-"]').remove();

		// init Edit with CE buttons
		elementor.$previewContents.find('.ce-edit-btn').on('click.ce', function() {
			location.href = this.href;
		});

		// init Read More link
		elementor.$previewContents.find('.ce-read-more').on('click.ce', function() {
			window.open(this.href);
		});

		// fix for redirecting preview
		elementor.$previewContents.find('a[href]').on('click.ce', function(e) {
			e.preventDefault();
		});
	});
});

$(window).on('load.ce', function onLoadWindow() {
	// init language switcher
	var $context = $('#ce-context'),
		$langs = $('#ce-langs'),
		$languages = $langs.children().remove(),
		built = $langs.data('built'),
		lang = $langs.data('lang');

	elementor.shopContext = $context.length
		? $context.val()
		: 's-' + parseInt(elementor.config.post_id.slice(-2))
	;
	if ('s' !== elementor.shopContext[0]) {
		var showToast = elementor.notifications.showToast.bind(elementor.notifications, {
				message: elementor.translate('multistore_notification'),
				buttons: [{
					name: 'view_languages',
					text: $context.find(':selected').html().split('★')[0],
					callback: function callback() {
						$('#elementor-panel-footer-lang').click();
					}
				}]
			}),
			toast = elementor.notifications.getToast();
		if (toast.isVisible()) {
			toast.on('hide', function onHideToast() {
				toast.off('hide', onHideToast);
				setTimeout(showToast, 350);
			});
		} else {
			showToast();
		}
	}
	elementor.helpers.filterLangs = function() {
		var ctx = $context.length ? $context.val() : elementor.shopContext,
			id_group = 'g' === ctx[0] ? parseInt(ctx.substr(2)) : 0,
			id_shop = 's' === ctx[0] ? parseInt(ctx.substr(2)) : 0,
			dirty = elementor.shopContext != ctx;

		$langs.empty();

		var id_shops = id_group ? $context.find(':selected').nextUntil('[value^=g]').map(function() {
			return parseInt(this.value.substr(2));
		}).get() : [id_shop];

		$languages.each(function() {
			if (!ctx || $(this).data('shops').filter(function(id) { return ~id_shops.indexOf(id) }).length) {
				var $lang = $(this).clone().appendTo($langs),
					id_lang = $lang.data('lang'),
					active = !dirty && lang == id_lang;

				var uid = elementor.config.post_id.replace(/\d\d(\d\d)$/, function(m, shop) {
					return ('0' + id_lang).slice(-2) + ('0' + id_shop).slice(-2);
				});
				$lang.attr('data-uid', uid).data('uid', uid);

				active && $lang.addClass('active');

				if (active || !id_shop || !built[id_shop] || !built[id_shop][id_lang]) {
					$lang.find('.elementor-button').remove();
				}
			}
		});
	};
	elementor.helpers.filterLangs();
	$context.on('click.ce-ctx', function onClickContext(e) {
		// prevent closing languages
		e.stopPropagation();
	}).on('change.ce-ctx', elementor.helpers.filterLangs);

	$langs.on('click.ce-lang', '.ce-lang', function onChangeLanguage() {
		var uid = $(this).data('uid'),
			href = location.href.replace(/uid=\d+/, 'uid=' + uid);

		if ($context.length && $context.val() != elementor.shopContext) {
			document.context.action = href;
			document.context.submit();
		} else if (uid != elementor.config.post_id) {
			location = href;
		}
	}).on('click.ce-lang-get', '.elementor-button', function onGetLanguageContent(e) {
		e.stopImmediatePropagation();
		var $icon = $('i', this);

		if ($icon.hasClass('fa-spin')) {
			return;
		}
		$icon.attr('class', 'fa fa-spin fa-circle-o-notch');

		elementorCommon.ajax.addRequest('get_language_content', {
			data: {
				uid: $(this).closest('[data-uid]').data('uid')
			},
			success: function(data) {
				$icon.attr('class', 'eicon-file-download');

				elementor.getRegion('sections').currentView.addChildModel(data);
			},
			error: function(data) {
				elementor.templates.showErrorDialog(data);
			}
		});
	});

	// handle permission errors for AJAX requests
	$(document).ajaxSuccess(function onAjaxSuccess(e, xhr, conf, res) {
		if (false === res.success && res.data && res.data.permission) {
			NProgress.done();
			$('.elementor-button-state').removeClass('elementor-button-state');

			try {
				elementor.templates.showTemplates();
			} catch (ex) {}

			elementor.templates.getErrorDialog()
				.setMessage('<center>' + res.data.permission + '</center>')
				.show()
			;
		}
	});
});

// init layerslider widget
$('#elementor-panel').on('change.ls', '.ls-selector select', function onChangeSlider() {
	var $ = elementor.$previewContents[0].defaultView.jQuery;

	$('.elementor-element-' + elementor.panel.currentView.content.currentView.model.id)
		.addClass('elementor-widget-empty')
		.append('<i class="elementor-widget-empty-icon eicon-insert-image">')
		.find('.ls-container').layerSlider('destroy').remove()
	;
}).on('click.ls-new', '.elementor-control-ls-new button', function addSlider(e) {
	var title = prompt(ls.NameYourSlider);

	null === title || $.post(ls.url, {
		'ls-add-new-slider': 1,
		'title': title
	}, function onSuccessNewSlider(data) {
		var id = (data.match(/name="slider_id" value="(\d+)"/) || []).pop();
		if (id) {
			var option = '#' + id + ' - ' + title;
			elementor.config.widgets['ps-widget-LayerSlider'].controls.slider.options[id] = option;
			$('.ls-selector select')
				.append('<option value="' + id + '">' + option + '</option>')
				.val(id)
				.change()
			;
			$('.elementor-control-ls-edit button').trigger('click.ls-edit');
		}
	});
}).on('click.ls-edit', '.elementor-control-ls-edit button', function editSlider(e) {
	var lsUpdate,
		lsId = $('.ls-selector select').val();

	$.fancybox({
		width: '100%',
		height: '100%',
		padding: 0,
		href: ls.url + '&action=edit&id=' + lsId,
		type: 'iframe',
		afterLoad: function onAfterLoadSlider() {
			var win = $('.fancybox-iframe').contents()[0].defaultView;

			win.jQuery(win.document).ajaxSuccess(function(e, xhr, args, res) {
				if (args.data && args.data.indexOf('action=ls_save_slider') === 0 && '{"status":"ok"}' === res) {
					lsUpdate = true;
				}
			});
			$(win.document.head).append('<style>\
				#header, #nav-sidebar, .add-new-h2, .ls-save-shortcode { display: none; }\
				#main { padding-top: 0; }\
				#main #content { margin-left: 0; }\
			</style>');
		},
		beforeClose: function onBeforeCloseSlider() {
			var win = $('.fancybox-iframe').contents()[0].defaultView,
				close = win.LS_editorIsDirty ? confirm(ls.ChangesYouMadeMayNotBeSaved) : true;

			if (close && win.LS_editorIsDirty) {
				win.LS_editorIsDirty = false;
			}
			return close;
		},
		afterClose: function onAfterCloseSlider() {
			lsUpdate && $('.ls-selector select')
				.val(0).change()
				.val(lsId).change()
			;
		}
	});
});
