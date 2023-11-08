<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} | <a href="{cms_action_url action=brulage1}">{admin_icon icon="import.gif"}Rafraichir le brûlage</a></p></div>

{if $itemcount > 0}

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		{*<th>ID</th>*}
		<th>Joueur(clt)</th>	
		{for $foo=1 to $liste_equipes}
		<th>Eq{$foo}</th>	
	{/for}	
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	{*<td>{$entry->id}</td>*}
	<td>{$entry->genid}({$entry->clast})</td>
	{for $foo=1 to $liste_equipes}
		
			{if $entry->can_play{$foo} == 1}{*1 = ne peut pas jouer ds cette équipe*}
				<td style="background:red; color:white;">{$entry->eq{$foo}}
			{else}
			
				{if $entry->eq{$foo}==0}
					{if $entry->other_brulage{$foo}==1 || $entry->other_brulage{$foo} == 0}<td style="background:green;color:white">{$entry->eq{$foo}}{*({$entry->inner_brulage{$foo}})({$entry->other_brulage{$foo}})*}</td>{/if}			
					{if $entry->other_brulage{$foo}>=2}<td style="background:red;color:white">{$entry->eq{$foo}}{*({$entry->inner_brulage{$foo}})({$entry->other_brulage{$foo}})*}</td>{/if}
				
				{elseif $entry->eq{$foo}==1}
					{if $entry->other_brulage{$foo}==1 || $entry->other_brulage{$foo} == 0 }<td style="background:orange;color:white">{$entry->eq{$foo}}{*({$entry->inner_brulage{$foo}})({$entry->other_brulage{$foo}})*}</td>{/if}
					{if $entry->other_brulage{$foo}>=2}
						{if $entry->inner_brulage{$foo}==0}
							<td style="background:orange;color:white">{$entry->eq{$foo}}{*({$entry->inner_brulage{$foo}})({$entry->other_brulage{$foo}})*}</td>
						{else}
							<td style="background:red;color:white">{$entry->eq{$foo}}{*({$entry->inner_brulage{$foo}})({$entry->other_brulage{$foo}})*}</td>
						{/if}
					{/if}
				{elseif $entry->eq{$foo} >=2}
						<td style="background:red; color:white;">{$entry->eq{$foo}}{*({$entry->inner_brulage{$foo}})({$entry->other_brulage{$foo}})*}</td>
				{/if}
			{/if}
	{/for}
  </tr>
{/foreach}
 </tbody>
</table>
{/if}

