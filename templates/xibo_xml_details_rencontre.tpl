{foreach from=$items item=entry}
  <item>
    <title>Derniers résultats</title>
    <description>{strip}
      {$entry->$equa}-{$entry->equb}
    {/strip}</description>
    <guid>{*$entry->detail_url*}</guid>
    <link>{*$entry->detail_url*}</link>
    <pubDate>{*$entry->postdate|rfc_date*}</pubDate>
  </item>
{/foreach}