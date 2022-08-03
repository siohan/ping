{form_start}
<input type="text" name="eq_id" value="{$eq_id}">
<div class="form-group">
    <label for="exampleInputEmail1">N° rencontre</label>
    <input type="text" name="renc_id" value="{$renc_id}" readonly>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Equipe du club</label>
    <select name="club">{cms_yesno selected=$club}</select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Tour N°</label>
    <input type="text" name="tour" value="{$tour}">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Date</label>
    <input type="date" name="date_event" value="{$date_event}">
    {html_select_time time=$horaire prefix='debut_' display_seconds=false minute_interval=15}
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Affiché sur le site ?</label>
    <select name="affiche">{cms_yesno selected=$affiche}</select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Résultat téléchargé ?</label>
    <select name="uploaded">{cms_yesno selected=$uploaded}</select>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Equipe A</label>
    <input type="text" name="equa" value="{$equa}" readonly>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Equipe B</label>
    <input type="text" name="equb" value="{$equb}" readonly>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Score equipe A</label>
    <input type="text" name="scorea" value="{$scorea}">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Score Equipe B</label>
    <input type="text" name="scoreb" value="{$scoreb}">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Epreuve N°</label>
    <input type="text" name="idepreuve" value="{$idepreuve}" readonly>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Compte à rebours</label>
    <select name="countdown">{cms_yesno selected=$countdown}</select>
</div>
<input type="submit" name="submit" value="Envoyer">
{form_end}
