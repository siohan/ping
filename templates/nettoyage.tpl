<a href="{cms_action_url action=advanced_params}">{admin_icon icon="back.gif"} Revenir</a><br />
<p class="red">{admin_icon icon="warning.gif"} Attention, la suppression des données peut altérer les pages en frontal contenant ces données...</p><br />
<p class="green">Le formulaire ci-dessous indique les saisons présentes dans le système</p>
<br />
{form_start}
<label>De quelle saison souhaites-tu supprimer les données ?</label>
<select name="saison">{html_options options=$saisondropdown}</select>
<input type="submit" name="submit" value="Envoyer">
{form_end}
