<p class="pagerows">
	{if $itemcount > 0}
	
		{foreach from=$items item=entry}
		<a href="{cms_action_url action='admin_poules_tab3'  record_id=$entry->record_id}">{if $record_id == $entry->record_id}<strong>{$entry->libequipe}</strong>{else}{$entry->libequipe}{/if}</a>
		{/foreach}

	{/if}
</p>

