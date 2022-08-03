<p class="pagerows">
	{if $itemcount > 0}
	
		{foreach from=$items item=entry}
		<a href="{cms_action_url action='defaultadmin' active_tab='adherents' letter=$entry->letter}">{if $letter == $entry->letter}<strong>{$entry->letter}</strong>{else}{$entry->letter}{/if}</a>
		{/foreach}

	{/if}
</p>
