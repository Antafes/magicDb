(function( $ ) {
	$._sortableTypes = {};

	$._sortableTypes.helper = {
		element: null,
		mainSelect: null,
		typeList: null,
		input: null,
		defaults: {
			types: [],
			inputName: 'types',
			texts: {
				title: 'Create Type',
				parentType: 'Parent Type',
				typeKey: 'Type Key',
				typeNameDe: 'Type Name De',
				typeNameEn: 'Type Name En',
				createType: 'Create Type'
			},
			templates: {
				basic: $('<div class="selectors"><div class="typeSelectors"><div class="mainTypeSelector"></div><div class="subTypeSelectors"></div></div><a id="createType" href="#"><img src="images/black_plus.png" width="10" height="10" /></a></div><div class="typeList"><ul class="listNoStyle"></ul></div>'),
				listElement: $('<li><span></span><a class="removeItem" href="#">X</a></li>')
			}
		},
		settings: {},
		init: function(element, options) {
			this.element = element;
			this.settings = $.extend(this.defaults, options);
			this.element.append(this.settings.templates.basic.clone());
			this.typeList = this.element.children('.typeList');
			this.input = $('<input type="hidden" />');
			this.input.attr('name', this.settings.inputName);
			this.element.append(this.input);
			$._sortableTypes.helper._addSelects();
			$._sortableTypes.helper._addCreateTypeDialog();
			$('#createType').append(this.settings.texts.createType);
			$('#createType').click(this._createTypeClick);
		},
		updateInput: function() {
			var helper = $._sortableTypes.helper,
				typeList = '';

			helper.typeList.children('ul').children().each(function(index, elem) {
				typeList += $(elem).data('typeId') + '-';
			});
			helper.input.val(typeList.substr(0, typeList.length - 1));
		},
		_addSelects: function() {
			var self = this,
				subTypeSelectors = this.element.children('.selectors').children('.typeSelectors').children('.subTypeSelectors');
			this.mainSelect = $('<select><option value="0" disabled="true"></option></select>');

			for (var i = 0; i < this.settings.types.length; i++)
			{
				var type = this.settings.types[i],
					option = $('<option></option>');
				option.attr('value', type.main.id);
				option.text(type.main.name);
				option.data('key', type.main.key);

				if (type.sub)
				{
					var subSelect = $('<select><option value="0" disabled="true"></option></select>');
					subSelect.attr('id', type.main.key);
					subSelect.hide();

					for (var x = 0; x < type.sub.length; x++)
					{
						var subOption = $('<option></option>'), subType = type.sub[x];
						subOption.attr('value', subType.id);
						subOption.text(subType.name);
						subSelect.append(subOption);
					}

					subSelect.change(function() {
						self._addListElement($(this));
					});
					subTypeSelectors.append(subSelect);
				}

				this.mainSelect.append(option);
			}

			this.mainSelect.change(function() {
				$(this).hide();
				$(this).parent().next().children().hide();
				$('#' + $(this).children(':selected').data('key')).show();
				var listElement = $._sortableTypes.helper._addListElement($(this));
				listElement.data('isMain', true);
			});
			this.element.children('.selectors').children('.typeSelectors').children('.mainTypeSelector').append(this.mainSelect);
		},
		_addCreateTypeDialog: function() {
			var dialog = $('<div id="createTypeDialog" style="display: none;"></div>'),
				tbody, row, mainSelect;
			dialog.append('<form method="post" action="index.php?page=AddCard"></form>');
			dialog.children().append('<table><tbody></tbody></table>');
			tbody = dialog.children().children('table').children('tbody');
			row = $('<tr></tr>');
			row.append('<td>' + this.settings.texts.parentType + '</td>');
			mainSelect = this.mainSelect.clone();
			mainSelect.children(':first').prop('disabled', false);
			mainSelect.children(':first').prop('selected', true);
			mainSelect.attr('id', 'parentSelect');
			mainSelect.attr('name', 'parent');
			row.append(mainSelect.wrap('<td></td>'));
			tbody.append(row);
			row = $('<tr></tr>');
			row.append('<td>' + this.settings.texts.typeKey + '</td>');
			row.append('<td><input type="text" name="typeKey" /></td>');
			tbody.append(row);
			row = $('<tr></tr>');
			row.append('<td>' + this.settings.texts.typeNameDe + '</td>');
			row.append('<td><input type="text" name="typeNameDe" /></td>');
			tbody.append(row);
			row = $('<tr></tr>');
			row.append('<td>' + this.settings.texts.typeNameEn + '</td>');
			row.append('<td><input type="text" name="typeNameEn" /></td>');
			tbody.append(row);
			row = $('<tr></tr>');
			row.append('<td colspan="2"><input type="submit" value="' + this.settings.texts.createType + '" /></td>');
			tbody.append(row);
			$('body').append(dialog);
		},
		_addListElement: function(element) {
			var listElement = $._sortableTypes.helper.settings.templates.listElement.clone(),
				alreadyExists = null;
			$._sortableTypes.helper.typeList.children('ul').children().each(function(index, elem) {
				var elemTypeId = parseInt($(elem).data('typeId')), newTypeId = parseInt(element.val());

				if (elemTypeId === newTypeId)
				{
					alreadyExists = $(elem);
				}
			});

			if (alreadyExists !== null)
			{
				return alreadyExists;
			}

			listElement.children('span').text(element.children(':selected').text());
			listElement.data('typeId', element.val());
			listElement.children('.removeItem').click(function() {
				if ($(this).parent().data('isMain'))
				{
					$(this).parent().parent().children().remove();
					element.parent().next().children().hide();
					element.parent().next().children().children(':first').prop('selected', true);
					element.show();
					element.children(':first').prop('selected', true);
				}
				else
				{
					$(this).parent().remove();
				}

				$._sortableTypes.helper.updateInput();
			});
			$._sortableTypes.helper.typeList.children('ul').append(listElement);
			$._sortableTypes.helper.updateInput();

			return listElement;
		},
		_isNumber: function(n)
		{
			return !isNaN(parseFloat(n)) && isFinite(n);
		},
		_createTypeClick: function(e) {
			e.preventDefault();
			$('#createTypeDialog').dialog({
				title: $._sortableTypes.helper.settings.texts.title,
				modal: true,
				width: 400,
				create: function() {
					var dialog = $(this);

					dialog.children('form').submit(function(e) {
						e.preventDefault();
						var data = {}, rawData = $(this).serializeArray();

						for (var i = 0; i < rawData.length; i++)
						{
							if ($._sortableTypes.helper._isNumber(rawData[i].value))
							{
								data[rawData[i].name] = parseInt(rawData[i].value);
							}
							else
							{
								data[rawData[i].name] = rawData[i].value;
							}
						}

						$.getJSON('ajax/createType.php', data, function(response) {
							if (response.typeId)
							{
								var type = {};

								if (typeof response.key !== 'undefined')
								{
									type.main = {
										id: response.typeId,
										key: response.key
									};

									if (parseInt(response.language) === 1)
									{
										type.main.name = data.typeNameDe;
									}
									else
									{
										type.main.name = data.typeNameEn;
									}

									$._sortableTypes.helper.settings.types.push(type);
								}
								else
								{
									var type, i, subType;
									for (i = 0; i < $._sortableTypes.helper.settings.types.length; i++)
									{
										type = $._sortableTypes.helper.settings.types[i];

										if (parseInt(type.main.id) !== data.parent)
										{
											continue;
										}

										subType = {
											id: response.typeId,
											key: response.key
										};

										if (response.language === 1)
										{
											subType.name = data.typeNameDe;
										}
										else
										{
											subType.name = data.typeNameEn;
										}

										if (typeof type.sub === 'undefined')
										{
											type.sub = [];
										}

										type.sub.push(subType);
									}
								}

								$._sortableTypes.helper._redrawSelects();

								dialog.dialog('close');
							}
						});
					});
				},
				close: function() {
					$(this).dialog('destroy');
					$(this).find('input[type=text]').val('');
					$(this).find('select').val(0);
				}
			});
		},
		_redrawSelects: function() {
			var typeSelector = this.element.children('.selectors').children('.typeSelectors'),
				mainHidden = false, lastMainValue = '';
			if (typeSelector.children('.mainTypeSelector').children().is(':visible') === false)
			{
				mainHidden    = true;
				lastMainValue = typeSelector.children('.mainTypeSelector').children().val();
			}

			typeSelector.children('.mainTypeSelector').children().remove();
			typeSelector.children('.subTypeSelectors').children().remove();
			this._addSelects();

			if (mainHidden)
			{
				typeSelector.children('.mainTypeSelector').children().val(lastMainValue);
				typeSelector.children('.mainTypeSelector').children().change();
			}
		}
	};

	$.fn.sortableTypes = function (options) {
		if (typeof options === 'object') {
			$._sortableTypes.helper.init($(this), options);
			$._sortableTypes.helper.typeList.children().sortable({
				containment: 'parent',
				update: $._sortableTypes.helper.updateInput
			});
		} else if (typeof options === 'string') {
			if (options === 'destroy') {
				$._sortableTypes.helper.typeList.children().sortable('destroy');
				$._sortableTypes.helper.element = null;
				$._sortableTypes.helper.mainSelect = null;
				$._sortableTypes.helper.typeList = null;
				$._sortableTypes.helper.input.remove();
				$._sortableTypes.helper.input = null;
				$('.typeList').remove();
				$('.selectors').remove();
				$('#createTypeDialog').remove();
				this.settings = {};
			}
		}
	};
})(jQuery);
