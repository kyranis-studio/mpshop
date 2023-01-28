<style>
	#google-map:not(.active):after{
		content:"Cliquer pour naviguer";
		text-align:center;
		display:block;
		position:absolute;
		width:100%;
		height:100%;
		top:0;
		line-height:{$height + 65}px;
		font-weight:bold;
		font-size:18px;
		background:rgba(0,0,0,0.2);
		backdrop-filter: blur(2px);
		color: #0061b9;
	}
</style>
<div id="google-map" style="position:relative;">
	<div id="map-header" style="display: flex;width: 100%;height: 65px;position: absolute;background: #e5e1e1;top : 0;left: 0;border-top: solid 1px silver;border-bottom: solid 1px silver;align-items: center;z-index:10">
		<h2 style="text-align:center;width: 100%;margin: 0;"> {$title} </h2>
	</div>
	<iframe width="300" height="{$height}" style="width: 100%; border: solid 1px silver;" src="{$mapUrl}" async="" defer="defer"></iframe>
</div>
<script>
	document.querySelector("#google-map").addEventListener('click',function(){
		this.classList.add('active')
	})
	document.querySelector("#google-map").addEventListener('mouseleave',function(){
		this.classList.remove('active')
	})
</script>