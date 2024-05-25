<div class="dashboard-box{if true==$last} last{/if}">
	<nav class="dashboard-inner cf">
		<h3 class="dashboard-icon groups">Photo</h3>
	{$photo}	
	<br />
		{form_start action=do_upload_image}
				{if $genid !=''}<input type="hidden" name="genid" value="{$genid}" />{/if}
				{if $idclub !=''}<input type="hidden" name="idclub" value="{$idclub}" />{/if}
		        <input name="fichier" type="file" id="fichier_a_uploader" />
		        <input type="submit" name="submit" value="Uploader" />
		{form_end}
	</nav>
</div>
