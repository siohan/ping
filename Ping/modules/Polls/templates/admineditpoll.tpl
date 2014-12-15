<h3>{$module->Lang("editpoll")}</h3>

<fieldset>
  <legend>{$module->Lang("pollsettings")}</legend>
{$formstart}
  {$nameinput}
  {$idinput}
  <br/>{$submit}
{$formend}
</fieldset>


<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th>{$module->Lang("optionname")}</th>
<th class="pagepos">{$module->Lang("votes")}</th>
      <th class="pagepos">{$module->Lang("votepercent")}</th>
      <th class='pageicon'>{$module->Lang("edit")}</th>
      <th class='pageicon'>{$module->Lang("delete")}</th>
    </tr>
  </thead>
  <tbody>

{foreach from=$options item=option}
{cycle values="row1,row2" assign=rowclass}
    <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
      <td>{$option.name}</td>
      <td style="text-align:center;">{$option.count}</td>
      <td style="text-align:center;">{$option.percent}</td>      
      <td style="text-align:center;width:1%;">{$option.edit}</td>
      <td style="text-align:center;width:1%;">{$option.delete}</td>
    </tr>
{/foreach}

  </tbody>
</table>

<table><tr><td>
{$addformstart}

{$addformsubmit}
{$formend}

</td><td>

{$resetformstart}

{$resetformsubmit}
{$formend}
</td><td>

{$returnformstart}

{$returnformsubmit}
{$formend}


</td></tr></table>
