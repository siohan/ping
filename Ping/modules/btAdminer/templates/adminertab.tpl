
{if $display == 'lightbox' } 
	<p><a href="{$url}" class="adminerframe" title="btAdminer">{$prompt_openinlightbox}</a></p>
{else}
	<iframe src="{$url}" name="btAdminer" scrolling="auto" marginheight="0" marginwidth="0" height="{$frameheight}" width="100%" border="0" frameborder="0"></iframe>
{/if}