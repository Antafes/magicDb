{include file="header.tpl"}
<div id="index">
	<div class="search">
		<form method="get" action="index.php?page=Index">
			<table>
				<tbody>
					<tr>
						<td>{$translator->getTranslation('card')}</td>
						<td>
							<input type="text" name="card" value="{$smarty.get.card}" />
						</td>
						<td>{$translator->getTranslation('type')}</td>
						<td>
							<select name="types[]" multiple="true" size="6">
								{foreach from=$typeList->getTypeList() item='type'}
									<option value="{$type->getTypeId()}"{if $smarty.get.types && in_array($type->getTypeId(), $smarty.get.types)} selected="true"{/if}>{$translator->getTranslation($type->getName())}</option>
								{/foreach}
							</select>
						</td>
						<td>{$translator->getTranslation('color')}</td>
						<td>
							<select name="colors[]" multiple="true" size="6">
								{foreach from=$colorList->getColors() item='color'}
									<option value="{$color->getColorId()}"{if $smarty.get.colors && in_array($color->getColorId(), $smarty.get.colors)} selected="true"{/if}>{$translator->getTranslation($color->getColor())}</option>
								{/foreach}
							</select>
						</td>
						<td>{$translator->getTranslation('rarity')}</td>
						<td>
							<select name="rarities[]" multiple="true">
								<option value="common"{if $smarty.get.rarities && in_array('common', $smarty.get.rarities)} selected="true"{/if}>{$translator->getTranslation('common')}</option>
								<option value="uncommon"{if $smarty.get.rarities && in_array('uncommon', $smarty.get.rarities)} selected="true"{/if}>{$translator->getTranslation('uncommon')}</option>
								<option value="rare"{if $smarty.get.rarities && in_array('rare', $smarty.get.rarities)} selected="true"{/if}>{$translator->getTranslation('rare')}</option>
								<option value="mythicRare"{if $smarty.get.rarities && in_array('mythicRare', $smarty.get.rarities)} selected="true"{/if}>{$translator->getTranslation('mythicRare')}</option>
							</select>
						</td>
						<td>
							<input type="submit" name="search" value="{$translator->getTranslation('search')}" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div class="list">
		{if $cardList->getCards()}
			<table class="collapse">
				<colgroup>
					<col class="index">
					<col class="name">
					<col class="name">
					<col class="type">
					<col class="rarity">
					<col class="amount">
					<col class="amount">
				</colgroup>
				<thead>
					<tr>
						<th rowspan="2">&nbsp;</th>
						<th colspan="2">{$translator->getTranslation('card')}</th>
						<th rowspan="2">{$translator->getTranslation('type')}</th>
						<th rowspan="2">{$translator->getTranslation('color')}</th>
						<th rowspan="2">{$translator->getTranslation('rarity')}</th>
						<th colspan="2">{$translator->getTranslation('amount')}</th>
					</tr>
					<tr>
						<th>{$translator->getTranslation('german')}</th>
						<th>{$translator->getTranslation('english')}</th>
						<th>{$translator->getTranslation('normal')}</th>
						<th>{$translator->getTranslation('foiled')}</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$cardList->getCards() item="card"}
						<tr class="{cycle values="odd,even"}">
							<td>{$card->getCardId()}</td>
							<td>{$card->getNameDe()}</td>
							<td>{$card->getNameEn()}</td>
							<td>{$card->getType()}</td>
							<td>{$card->getColor()}</td>
							<td>{$translator->getTranslation($card->getRarity())}</td>
							<td>{$card->getAmount()}</td>
							<td>{$card->getFoiled()}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		{else}
			{$translator->getTranslation('noCardsFound')}
		{/if}
	</div>
</div>
{include file="footer.tpl"}