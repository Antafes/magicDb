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
							{if $smarty.get.sort}
								<input type="hidden" name="sort" value="{$smarty.get.sort}" />
								<input type="hidden" name="order" value="{$smarty.get.order}" />
							{/if}
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
						<th rowspan="2">
							<a class="sort" href="index.php?page=Index&amp;sort=cardId&amp;order={if $smarty.get.sort == 'cardId' && (!$smarty.get.order || $smarty.get.order == 'ASC')}DESC{else}ASC{/if}">#</a>
						</th>
						<th colspan="2">{$translator->getTranslation('card')}</th>
						<th rowspan="2">
							<a class="sort" href="index.php?page=Index&amp;sort=type&amp;order={if $smarty.get.sort == 'type' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('type')}</a>
						</th>
						<th rowspan="2">
							<a class="sort" href="index.php?page=Index&amp;sort=color&amp;order={if $smarty.get.sort == 'color' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('color')}</a>
						</th>
						<th rowspan="2">
							<a class="sort" href="index.php?page=Index&amp;sort=rarity&amp;order={if $smarty.get.sort == 'rarity' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('rarity')}</a>
						</th>
						<th colspan="2">{$translator->getTranslation('amount')}</th>
					</tr>
					<tr>
						<th>
							<a class="sort" href="index.php?page=Index&amp;sort=nameDe&amp;order={if $smarty.get.sort == 'nameDe' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('german')}</a>
						</th>
						<th>
							<a class="sort" href="index.php?page=Index&amp;sort=nameEn&amp;order={if $smarty.get.sort == 'nameEn' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('english')}</a>
						</th>
						<th>
							<a class="sort" href="index.php?page=Index&amp;sort=amount&amp;order={if $smarty.get.sort == 'amount' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('normal')}</a>
						</th>
						<th>
							<a class="sort" href="index.php?page=Index&amp;sort=foiled&amp;order={if $smarty.get.sort == 'foiled' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('foiled')}</a>
						</th>
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