{include file="header.tpl"}
<div id="addCard">
	<script type="text/javascript">
		var typeList = JSON.parse('{$typeList}'),
			texts = {
				title: '{$translator->getTranslation('createType')}',
				parentType: '{$translator->getTranslation('parentType')}',
				typeKey: '{$translator->getTranslation('typeKey')}',
				typeNameDe: '{$translator->getTranslation('typeNameDe')}',
				typeNameEn: '{$translator->getTranslation('typeNameEn')}',
				createType: '{$translator->getTranslation('createType')}'
			};
	</script>
	<h2>{$translator->getTranslation('addCard')}</h2>
	<form method="post" action="index.php?page=AddCard">
		<table>
			<colgroup>
				<col class="headings">
				<col class="values">
			</colgroup>
			<tbody>
				<tr>
					<td>{$translator->getTranslation('cardNameDe')}</td>
					<td>
						<input type="text" name="cardNameDe" />
					</td>
				</tr>
				<tr>
					<td>{$translator->getTranslation('cardNameEn')}</td>
					<td>
						<input type="text" name="cardNameEn" />
					</td>
				</tr>
				<tr>
					<td>{$translator->getTranslation('type')}</td>
					<td id="sortableTypes"></td>
				</tr>
				<tr>
					<td>{$translator->getTranslation('rarity')}</td>
					<td>
						<select name="rarity" size="4">
							<option value="common">{$translator->getTranslation('common')}</option>
							<option value="uncommon">{$translator->getTranslation('uncommon')}</option>
							<option value="rare">{$translator->getTranslation('rare')}</option>
							<option value="mythicRare">{$translator->getTranslation('mythicRare')}</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>{$translator->getTranslation('color')}</td>
					<td>
						<select name="colors[]" multiple="multiple" size="6">
							{foreach from=$colorList->getColors() item="color"}
								<option value="{$color->getColorId()}">{$translator->getTranslation({$color->getColor()})}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td>{$translator->getTranslation('amount')}</td>
					<td>
						<input type="text" name="amount" value="0" />
					</td>
				</tr>
				<tr>
					<td>{$translator->getTranslation('foiled')}</td>
					<td>
						<input type="text" name="foiled" value="0" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						{add_form_salt formName='createCard'}
						<input type="submit" value="{$translator->getTranslation('createCard')}" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
{include file="footer.tpl"}