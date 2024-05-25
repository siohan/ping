<p><a href="{cms_action_url action=defaultadmin __activetab=brulage}">{admin_icon icon="back.gif"} Revenir</a></p>
<p class="green">Désactive les épreuves qui n'ont plus cours dans l'onglet épreuves</p><br />
{form_start}
<label for="idepreuve">Choisi l'épreuve par équipe pour le brulage</label>
<select name="idepreuve">{html_options options=$liste_epreuves_equipes selected=$chpt_default}</select>
<input type="submit" name="Envoyer" value="Envoyer">
{form_end}
