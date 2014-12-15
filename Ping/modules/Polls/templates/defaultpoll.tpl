{* valid and no tables *}
<div class="pollvoteform">
  <h3>{$pollname}</h3>
  {$formstart}
  <div class="polloptions">
     {foreach from=$options item=option}
     <div class="polloption">
	     <span class="polllabel">
	       <label for='{$option->uniqueid}'>{$option->label}</label>
	     </span>
	     <span class="pollinput">
	       <input id='{$option->uniqueid}' type='radio' name='pollvotingchoice_{$pollid}' value='{$option->value}' />
	     </span>
     </div>
     {/foreach}
  </div>
  {$formend}
  {$peekform}
</div>

