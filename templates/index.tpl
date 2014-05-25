{include file="header.tpl"}
<div id="index">
	<div class="search">
	</div>
	<div class="list">
		{if $cardList}
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
		{/if}
	</div>
</div>
{include file="footer.tpl"}