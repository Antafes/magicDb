(function( $ ) {
	$._editRow = {};

	$._editRow.helper = {
		element: null,
		defaults: {
			target: 'tr',
			ajaxTarget: '',
			exclude: [],
			idColumn: '.id',
			startRow: 1,
			types: {},
			typesRemove: {},
			typesGetData: {}
		},
		settings: {},
		selectedRow: null,
		init: function(element, options) {
			this.element  = element;
			this.settings = $.extend(this.defaults, options);

			if (this.settings.ajaxTarget === '')
			{
				throw 'Missing ajax target!';
			}

			this.addStyles();
			this.addListener();
		},
		showFields: function(element) {
			var $element= $(element), options;

			if ($._editRow.helper.selectedRow !== null) {
				$._editRow.helper.hideFields();
			}

			$element.children().not(this.settings.exclude.join(' ')).each(function() {
				var $this = $(this);
				$this.css('position', 'relative');

				if (typeof $._editRow.helper.settings.types[$this.data('type')] !== 'undefined') {
					$._editRow.helper.settings.types[$this.data('type')]($this);
				} else if ($this.data('values')) {
					$._editRow.helper.addSelect($this);
				} else {
					$._editRow.helper.addInput($this);
				}
			});
			options = $('<div class="rowOptions"></div>');
			options.append('<button class="check"></button>');
			options.append('<button class="close"></button>');
			options.children('button').css({
				margin: 0,
				height: $element.outerHeight()
			});
			options.children('.check').button({
				icons: {
					primary: 'ui-icon-check'
				},
				text: false
			}).on('click', function(e) {
				e.stopPropagation();
				$._editRow.helper.sendData($(this).parents($._editRow.helper.settings.target));
			});
			options.children('.close').button({
				icons: {
					primary: 'ui-icon-close'
				},
				text: false
			}).on('click', function(e) {
				e.stopPropagation();
				$._editRow.helper.hideFields();
			});
			options.css({
				position: 'absolute',
				top: 0,
				right: -80,
				padding: 0
			});
			$element.append(options);
		},
		hideFields: function() {
			var $element= this.selectedRow;
			$element.children().not(this.settings.exclude.join(' ')).each(function() {
				var $this = $(this);

				if (typeof $._editRow.helper.settings.typesRemove[$this.data('type')] !== 'undefined') {
					$._editRow.helper.settings.typesRemove[$this.data('type')]($this);
				} else {
					$this.children(':input').remove();
				}
			});

			$element.children().removeAttr('style');
			$element.children('.rowOptions').remove();
			$element.click(function() {
				$(this).unbind('click');
				$._editRow.helper.showFields(this);
				$._editRow.helper.selectedRow = $(this);
			});
			$._editRow.helper.selectedRow = null;
		},
		addStyles: function() {
			this.element.find(this.settings.target).each(function(index) {
				if (index + 1 >= $._editRow.helper.settings.startRow) {
					$(this).css({
						cursor: 'pointer',
						position: 'relative'
					});
				}
			});
		},
		addListener: function() {
			this.element.find(this.settings.target).each(function(index) {
				if (index + 1 >= $._editRow.helper.settings.startRow) {
					$(this).click(function() {
						$(this).unbind('click');
						$._editRow.helper.showFields(this);
						$._editRow.helper.selectedRow = $(this);
					});
				}
			});
		},
		sendData: function(element) {
			var $element = $(element), data = {};
			data.id = $element.children(this.settings.idColumn).text();

			$element.children().not(this.settings.exclude.join(' ')).each(function() {
				var $this = $(this), $field;

				if (typeof $._editRow.helper.settings.typesGetData[$this.data('type')] !== 'undefined') {
					data = $._editRow.helper.settings.typesGetData[$this.data('type')]($this, data);
				} else {
					$field = $this.children(':input');

					if ($field.is('select'))
					{
						var title = '';

						if ($field.prop('multiple'))
						{
							$field.children('option:selected').each(function() {
								title += $(this).text() + ', ';
							});

							title = title.substr(0, title.length - 2);
						}
						else
						{
							title = $field.children('option:selected').text();
						}

						data[$field.attr('name')] = {
							value: $field.val(),
							title: title
						};
					}
					else
					{
						data[$field.attr('name')] = {
							value: $field.val(),
							title: $field.val()
						};
					}
				}
			});

			$.getJSON(this.settings.ajaxTarget, data, function(result) {
				if (result.ok) {
					$._editRow.helper.hideFields();
					$._editRow.helper.updateColumns(element, data);
				}
			});
		},
		addInput: function(element) {
			var $element = $(element), input, type = 'text', value = $element.text();

			if ($element.data('type'))
			{
				type = $element.data('type');
			}

			if ($element.data('value'))
			{
				value = $element.data('value');
			}

			input = $('<input />');
			input.attr({
				type: type,
				value: value,
				name: $element.attr('class')
			});
			input.css({
				width: $element.width(),
				height: $element.outerHeight() - 6,
				position: 'absolute',
				top: 0,
				left: $element.css('paddingLeft'),
				margin: 0
			});
			$element.append(input);
		},
		addSelect: function(element) {
			var $element = $(element),
				select,
				value = $element.data('value') + '',
				selectedValues = value.split('-'),
				multiple = $element.data('multiple') ? true : false;

			select = $('<select />');
			select.attr({
				name: $element.attr('class')
			});
			select.prop('multiple', multiple);
			select.css({
				width: $element.width(),
				height: $element.outerHeight(),
				position: 'absolute',
				top: 0,
				left: $element.css('paddingLeft'),
				margin: 0,
				size: multiple ? 4 : 1,
				zIndex: 200
			});

			$.each($element.data('values'), function(key, value) {
				var option = $('<option></option>');
				option.attr('value', key);
				option.text(value);
				option.css('height', $element.outerHeight());

				if ($.inArray(key, selectedValues) !== -1)
				{
					option.prop('selected', true);
				}

				select.append(option);
			});

			if (multiple)
			{
				select.mouseenter(function() {
					select.data('height', select.height());
					select.height('auto');
				});
				select.mouseleave(function() {
					select.height(select.data('height'));
				});
			}

			$element.append(select);
		},
		updateColumns: function(element, data) {
			var $element = $(element);

			$.each(data, function(key, content) {
				$element.children('.' + key).text(content.title);
			});
		}
	};

	$.fn.editFields = function (options) {
		$._editRow.helper.init($(this), options);
	};
})(jQuery);
