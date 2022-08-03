{if $itemcount >0}
<div class="sp-widget-align-right">
	<aside id="sportspress-event-blocks-3" class="widget widget_sportspress widget_sp_event_blocks">
		<h4 class="sp-table-caption">Prochainement</h4>
			<div class="sp-template sp-template-event-blocks">
				<div class="sp-table-wrapper">
					<table class="sp-event-blocks sp-data-table sp-paginated-table" data-sp-rows="{$itemcount}">
						<thead>
							<tr>
								<th></th>
							</tr>
						</thead>
						<tbody>
							{foreach from=$items item=entry}
							<tr class="sp-row sp-post alternate" itemscope itemtype="http://schema.org/SportsEvent">
								<td>
									<span class="team-logo logo-odd" title="Rams" itemprop="competitor" itemscope itemtype="http://schema.org/SportsTeam"><meta itemprop="name" content="Rams"><a href="#"><!--http://demo.themeboy.com/rookie-soccer/team/rams/" itemprop="url" content="http://demo.themeboy.com/rookie-soccer/team/rams/"><img width="128" height="128" src="http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/rams-128x128.png" class="attachment-sportspress-fit-icon size-sportspress-fit-icon wp-post-image" alt="" itemprop="logo" srcset="http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/rams-128x128.png 128w, http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/rams-150x150.png 150w, http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/rams-300x298.png 300w, http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/rams-32x32.png 32w, http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/rams.png 397w" sizes="(max-width: 128px) 100vw, 128px" />--></a></span>
									<span class="team-logo logo-even" title="Bulls" itemprop="competitor" itemscope itemtype="http://schema.org/SportsTeam"><meta itemprop="name" content="Bulls"><a href="#"><!--http://demo.themeboy.com/rookie-soccer/team/bulls/" itemprop="url" content="http://demo.themeboy.com/rookie-soccer/team/bulls/"><img width="98" height="128" src="http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/bulls-98x128.png" class="attachment-sportspress-fit-icon size-sportspress-fit-icon wp-post-image" alt="" itemprop="logo" srcset="http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/bulls-98x128.png 98w, http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/bulls-230x300.png 230w, http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/bulls-25x32.png 25w, http://demo.themeboy.com/rookie-soccer/wp-content/uploads/sites/63/bulls.png 341w" sizes="(max-width: 98px) 100vw, 98px" />--></a></span>
									<time class="sp-event-date" datetime="2020-09-07 17:00:00" itemprop="startDate" content="2020-09-07T17:00+10:00">
									<a href="#" itemprop="url" content="#">{$entry->date_event|date_format}</a>							</time>
									<h5 class="sp-event-results">
									<a href="#" itemprop="url" content="#"><span class="sp-result ">{*$entry->horaire*}</span> </a>							</h5>
										<div style="display:none;" class="sp-event-venue" itemprop="location" itemscope itemtype="http://schema.org/Place">
											<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">N/A</div>
										</div>
										<h4 class="sp-event-title" itemprop="name">
										<a href="#" itemprop="url" content="#">{$entry->equa} - {$entry->equb}</a>
										</h4>
							
								</td>
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</aside>
	</div>
{/if}	