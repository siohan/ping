{if $itemcount > 0}
<aside id="sportspress-countdown-3" class="widget widget_sportspress widget_countdown widget_sp_countdown">
	<h4 class="sp-table-caption">A l'affiche</h4>
		<div class="sp-template sp-template-countdown">
			<div class="sp-countdown-wrapper">
				{foreach from=$items item=entry}
					<h3 class="event-name sp-event-name">
						<a href="#">{$entry->equa} vs {$entry->equb}</a>		</h3>
						<p class="countdown sp-countdown">
							<time datetime="{$entry->date_event|date_format:"%Y-%m-%d"} {$entry->horaire}:00" data-countdown="{$entry->date_event|date_format:"%Y/%m/%d"} {$entry->horaire}:00">
								<span>02 <small>jours</small></span>
								<span>03 <small>heures</small></span>
								<span>28 <small>mins</small></span>
								<span>13 <small>secs</small></span>
							</time>
						</p>
				{/foreach}
			</div>
		</div>
</aside>
{/if}