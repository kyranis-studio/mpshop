{extends file="helpers/form/form.tpl"}
{block name="input"}  
    {if $input.type == 'time'}
		<div class="input-group" id="{$input.id}">
			<div style="display:flex">
				<div col-lg-2 style="width:100px;margin-right:20px">
				<label style="text-align:center;width: 100%;">De</label>
					<input
						id="star-{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
						style ="border-radius: 5px;"
						type="text"
						data-hex="true"
						class="timepicker star-{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
						value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" />
				</div>
				<div col-lg-2 style="width:100px;margin-right:20px">
				<label style="text-align:center;width: 100%;">A</label>
					<input
						id ="end-{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
						style ="border-radius: 5px;"
						type="text"
						data-hex="true"
						class="timepicker end-{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
						value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" />
				</div>
			</div>
			<input id="{$input.id}-time" type="hidden" name="{$input.name}">
		</div>
	{else}
		{$smarty.block.parent}	
 	{/if}
{/block}
{block name="script"}
	if ($(".timepicker").length > 0)
		$(".timepicker").timepicker({
		pickDate: false
	});
	afternoon = $('#afternoon').parent().parent()
	doubleSeance = '{$doubleSeance}'
	if(doubleSeance==""){
			$(afternoon).hide()
			$("#fieldset_1_1").hide()
		}else{
			$(afternoon).show()
			$("#fieldset_1_1").show()
	}
	$('input[name=MP_SHIFT_CLOCK_DOUBLE_SHIFT]').click(function(){
		if($(this).val()==""){
			$(afternoon).hide()
			$("#fieldset_1_1").hide()
		}else{
			$(afternoon).show()
			$("#fieldset_1_1").show()
		}
	})
	$("#star-morning").val("{$starMorning}")
	$("#end-morning").val("{$endMorning}")
	$("#morning-time").val("{$starMorning}-{$endMorning}")
	$("#star-afternoon").val("{$starAfternoon}")
	$("#end-afternoon").val("{$endAfternoon}")
	$("#afternoon-time").val("{$starAfternoon}-{$endAfternoon}")
	$("#star-saturday").val("{$starSaturday}")
	$("#end-saturday").val("{$endSaturday}")
	$("#saturday-time").val("{$starSaturday}-{$endSaturday}")
	$(".timepicker").change(function(){
		time = $(this).val()
		if($(this).hasClass('star-morning')){
			oldTime = $('#morning-time').val()
			timeRange = oldTime.split('-')
			if(timeRange.length == 2){
				$('#morning-time').val(time+'-'+timeRange[1])
			}else{
				$('#morning-time').val(time+'-')
			}
		}else if($(this).hasClass('end-morning')){
			oldTime = $('#morning-time').val()
			timeRange = oldTime.split('-')
			if(timeRange.length == 2){
				$('#morning-time').val(timeRange[0]+'-'+time)
			}else{
				$('#morning-time').val('-'+time)
			}
		}else if($(this).hasClass('star-afternoon')){
			oldTime = $('#afternoon-time').val()
			timeRange = oldTime.split('-')
			if(timeRange.length == 2){
				$('#afternoon-time').val(time+'-'+timeRange[1])
			}else{
				$('#afternoon-time').val(time+'-')
			}
		}else if($(this).hasClass('end-afternoon')){
			oldTime = $('#afternoon-time').val()
			timeRange = oldTime.split('-')
			if(timeRange.length == 2){
				$('#afternoon-time').val(timeRange[0]+'-'+time)
			}else{
				$('#afternoon-time').val('-'+time)
			}
		}else if($(this).hasClass('star-saturday')){
			oldTime = $('#saturday-time').val()
			timeRange = oldTime.split('-')
			if(timeRange.length == 2){
				$('#saturday-time').val(time+'-'+timeRange[1])
			}else{
				$('#saturday-time').val(time+'-')
			}
		}else if($(this).hasClass('end-saturday')){
			oldTime = $('#saturday-time').val()
			timeRange = oldTime.split('-')
			if(timeRange.length == 2){
				$('#saturday-time').val(timeRange[0]+'-'+time)
			}else{
				$('#saturday-time').val('-'+time)
			}
		}
	})
	</script>
{/block}
