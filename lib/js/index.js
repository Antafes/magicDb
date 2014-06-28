$(function() {
	$('.list').children('.table').editFields({
		target: '.row',
		exclude: ['.index'],
		idColumn: '.index',
		ajaxTarget: 'ajax/editCard.php',
		startRow: 3,
		types: {
			cardType: function(element) {
				var $element = $(element),
					div = $('<div id="sortableTypes"></div>'),
					values = $element.data('value'),
					subTypeSelector;

				div.css({
					position: 'absolute',
					top: 0,
					left: 0,
					backgroundColor: 'white',
					width: $element.width(),
					height: $element.height(),
					overflow: 'hidden',
					padding: $element.css('padding'),
					zIndex: 200
				});
				div.mouseenter(function() {
					var $this = $(this);
					$this.data('height', $this.height());
					$this.height('auto');
					$this.css('overflow', 'auto');
				});
				div.mouseleave(function() {
					var $this = $(this);
					$this.height($this.data('height'));
					$this.css('overflow', 'hidden');
				});
				$element.append(div.clone(true));
				$('#sortableTypes').sortableTypes({
					types: typeList,
					texts: texts
				});

				if (values.mainType)
				{
					$('.mainTypeSelector').children('select').val(values.mainType);
					$('.mainTypeSelector').children('select').change();
					subTypeSelector = $('.mainTypeSelector').children('select').children(':selected').data('key');

					if (values.subTypes.length > 0)
					{
						for (var i = 0; i < values.subTypes.length; i++)
						{
							$('#' + subTypeSelector).val(values.subTypes[i]);
							$('#' + subTypeSelector).change();
						}

						$('#' + subTypeSelector).val(0);
					}
				}
			}
		},
		typesRemove: {
			cardType: function(element) {
				$(element).children('#sortableTypes').sortableTypes('destroy');
				$(element).children('#sortableTypes').remove();
			}
		},
		typesGetData: {
			cardType: function(element, data) {
				var $element = $(element),
					$input = $element.children('#sortableTypes').children('input');

				data['type'] = $input.val();

				return data;
			}
		}
	});
});