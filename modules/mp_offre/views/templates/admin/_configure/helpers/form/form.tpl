{extends file="helpers/form/form.tpl"}
{block name="input"}  
    {if $input.type == 'image'}
		<input id="img_upload" type="file" name="{$input.name}" class="hide">
		<img src="{$input.image}" style="width: 100%;">
		<div class="dummyfile input-group">
			<span class="input-group-addon"><i class="icon-file"></i></span>
			<input id="MP_OFFRE_BANNER-name" type="text" name="{$input.name}" value="{$input.image}" readonly>
			<span class="input-group-btn">
				<button onclick="document.querySelector('#img_upload').click()" type="button" name="submitAddAttachments" class="btn btn-default">
					<i class="icon-folder-open"></i> Ajouter un fichie
				</button>
			</span>
		</div>
	{else}
		{$smarty.block.parent}	
 	{/if}
{/block}

