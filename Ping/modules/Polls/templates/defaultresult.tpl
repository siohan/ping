<div class="pollresultlist">
	<h3>{$pollname}</h3>
	<div class="pollresults">	
		{foreach from=$options item=option}
		<div class="pollresult">
		  <span class="resultlabel">
	       {$option->label}
	     </span>
	     <span class="resultvotes">
	       {$option->percent} ({$option->votes} {if $option->votes==1}{$votetext}{else}{$votestext}{/if})
	     </span>
		</div>
		{/foreach}
		{$totalvotestext}: {$totalvotes}
		
		{if $voteform neq ""}
		<br/>
		{$voteform}		
		{/if}
	</div>
</div>
