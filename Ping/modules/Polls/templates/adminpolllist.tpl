{if count($polls) > 0}

<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th class="pageicon">{$module->Lang("pollid")}</th>
      <th class="">{$module->Lang("pollname")}</th>
      <th class="pagepos">{$module->Lang("pollstatus")}</th>

      <th class='pageicon'>{$module->Lang("defaultpoll")}</th>
      <th class='pageicon'>{$module->Lang("edit")}</th>
      <th class='pageicon'>{$module->Lang("delete")}</th>
      <th class="pagepos">{$module->Lang("pollstartdate")}</th>
      <th class="pagepos">{$module->Lang("pollclosedate")}</th>
      <th class="pagepos">{$module->Lang("pollinfo")}</th>
    </tr>
  </thead>
  <tbody>
{foreach from=$polls item=poll}
{cycle values="row1,row2" assign=rowclass}
		<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">      
      <td style="text-align:center;width:1%;">{$poll.id}</td>
      <td>{$poll.name}</td>
      <td style="text-align:center;">{$poll.status}</td>
      <td style="text-align:center;width:1%;">{$poll.default}</td>
      <td style="text-align:center;width:1%;">{$poll.edit}</td>
      <td style="text-align:center;width:1%;">{$poll.delete}</td>
      <td class="pagepos">{$poll.createtime}</td>
      <td class="pagepos">{$poll.closetime}</td>
      <td class="pagepos">{$poll.duration}</td>
		</tr>
{/foreach}

  </tbody>
</table>
{/if}

{$addlink}
