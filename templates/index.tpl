{include file="header.tpl"}
<script type="text/javascript">
	var typeList = JSON.parse('{$typeList->getAsArray()|json_encode}'),
		texts = {
			title: '{$translator->getTranslation('createType')}',
			parentType: '{$translator->getTranslation('parentType')}',
			typeKey: '{$translator->getTranslation('typeKey')}',
			typeNameDe: '{$translator->getTranslation('typeNameDe')}',
			typeNameEn: '{$translator->getTranslation('typeNameEn')}',
			createType: '{$translator->getTranslation('createType')}'
		};
</script>
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
			<div class="table">
				<div class="head">
					<div class="row">
						<div class="index"></div>
						<div class="nameDe nameEn">{$translator->getTranslation('card')}</div>
						<div class="type"></div>
						<div class="color"></div>
						<div class="rarity"></div>
						<div class="amount foiled">{$translator->getTranslation('amount')}</div>
					</div>
					<div class="row">
						<div class="index">
							<a class="sort" href="index.php?page=Index&amp;sort=cardId&amp;order={if $smarty.get.sort == 'cardId' && (!$smarty.get.order || $smarty.get.order == 'ASC')}DESC{else}ASC{/if}">#</a>
						</div>
						<div class="nameDe">
							<a class="sort" href="index.php?page=Index&amp;sort=nameDe&amp;order={if $smarty.get.sort == 'nameDe' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('german')}</a>
						</div>
						<div class="nameEn">
							<a class="sort" href="index.php?page=Index&amp;sort=nameEn&amp;order={if $smarty.get.sort == 'nameEn' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('english')}</a>
						</div>
						<div class="type">
							<a class="sort" href="index.php?page=Index&amp;sort=type&amp;order={if $smarty.get.sort == 'type' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('type')}</a>
						</div>
						<div class="color">
							<a class="sort" href="index.php?page=Index&amp;sort=color&amp;order={if $smarty.get.sort == 'color' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('color')}</a>
						</div>
						<div class="rarity">
							<a class="sort" href="index.php?page=Index&amp;sort=rarity&amp;order={if $smarty.get.sort == 'rarity' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('rarity')}</a>
						</div>
						<div class="amount">
							<a class="sort" href="index.php?page=Index&amp;sort=amount&amp;order={if $smarty.get.sort == 'amount' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('normal')}</a>
						</div>
						<div class="foiled">
							<a class="sort" href="index.php?page=Index&amp;sort=foiled&amp;order={if $smarty.get.sort == 'foiled' && $smarty.get.order == 'ASC'}DESC{else}ASC{/if}">{$translator->getTranslation('foiled')}</a>
						</div>
					</div>
				</div>
				<div class="body">
					{foreach from=$cardList->getCards() item="card"}
						<div class="row {cycle values="odd,even"}">
							<div class="index">{$card->getCardId()}</div>
							<div class="nameDe">{$card->getNameDe()}</div>
							<div class="nameEn">{$card->getNameEn()}</div>
							<div class="type" data-type="cardType" data-value='{$card->getTypeJson()}'>{$card->getType()}</div>
							<div class="color" data-value="{$card->getColorIds()}" data-values='{$colorList->getColorsJson()}' data-multiple="true">{$card->getColor()}</div>
							{$rarities.common = $translator->getTranslation('common')}
							{$rarities.uncommon = $translator->getTranslation('uncommon')}
							{$rarities.rare = $translator->getTranslation('rare')}
							{$rarities.mythicRare = $translator->getTranslation('mythicRare')}
							<div class="rarity" data-value="{$card->getRarity()}" data-values='{$rarities|json_encode}'>{$translator->getTranslation($card->getRarity())}</div>
							<div class="amount" data-type="number">{$card->getAmount()}</div>
							<div class="foiled" data-type="number">{$card->getFoiled()}</div>
						</div>
					{/foreach}
				</div>
			</div>
		{else}
			{$translator->getTranslation('noCardsFound')}
		{/if}
	</div>
</div>
{include file="footer.tpl"}