<div id="mp-footer">
	<div id="shift-plan-fr" >
		<h1 style="text-align:center;font-size:32px">Horaires de travaille</h1>
		<div>
			<h1 style="text-align:center">Lundi - {if !$doubleShift}Samedi{else}Vendredi{/if}</h1>
		</div>
		<div>
			<h3 style="text-align:center">
			<span class="first-shift" style="color:#009fe3"> {$firstShift} </span><br> 
			{if $doubleShift}
			<span class="pause-shift" style="color:#be1622"> {$pause} </span><br>
			<span class="second-shift" style="color:#009fe3"> {$secondShift} </span>
			{/if}
			
			</h3>
		</div>
		{if $doubleShift}
		<div>
			<h1 style="text-align:center">Samedi</h1>
		</div>
		<div>
			<h3 class="saturday-shift" style="text-align:center;color:#009fe3">{$saturdayShift}</h3>
		</div>
		{/if}
	</div>
	<div id="mp-shift" >
		<div >
			<h1 id="mp-open"  style="text-align:center;margin-bottom: 30px"><i class="fa fa-clock-o" style="color:#009fe3"></i> La boutique est ouvert</h1>
			<h1 id="mp-close" style="text-align:center;margin-bottom: 30px"><i class="fa fa-clock-o" style="color:#be1622"></i> La boutique est fermée</h1>
		</div>
		<ul id="clock" class="clock-bg {if $doubleShift && ! $saturday && !$sunday}double-seance{else} one-seance {if $sunday}sunday{/if} {/if}" style="--fs-start-deg:{$fsStartDeg};--pause-start-deg:{$pauseStartDeg};--ss-start-deg:{$ssStartDeg};--pause-start-prog:{$pauseStartProg};--pause-end-prog:{$pauseEndProg};--ss-end-prog:{$ssEndShiftProg};">	
			<li><img src="/modules/mp_shift_clock/views/img/clock.png" class="pause" style="z-index: 1;position: absolute;" width="300px" height="300px"></li>
			<li id="sec"></li>
			<li id="hour"><span class="time-marker"></span> <div class="pointer"><i class="icon icon-arrow-up-solid" style="margin-left: -9.3px;margin-top: -10px;position: absolute;"></i></div></li>
			<li id="min"></li>
		</ul>
		<h3 id="mp-message" style="text-align:center;margin-top:20px"></h3>
		<div style="text-align:center;background:#009fe3;margin:auto;color:white;width:100%;padding:10px;">Temps de travaille - أوقات العمل</div>
		<div style="text-align:center;background:#be1622;margin:auto;color:white;width:100%;padding:10px;margin-bottom: 10px;">Pause - راحة</div>
	</div>
	<div id="shift-plan-ar" >
		<h1 style="text-align:center;font-size:36px">أوقات العمل</h1>
		<div>
			<h1 style="text-align:center">الإثنين-{if !$doubleShift}السبت{else}الجمعة{/if}</h1>
		</div>
		<div>
			<h3 style="text-align:center">
			<span class="first-shift" style="color:#009fe3"> {$firstShift} </span><br>
			{if $doubleShift}
			<span class="pause-shift" style="color:#be1622"> {$pause} </span><br>
			<span class="second-shift" style="color:#009fe3"> {$secondShift} </span>
			{/if}
			
			</h3>
		</div>
		{if $doubleShift}
		<div>
			<h1 style="text-align:center">السبت</h1>
		</div>
		<div >
			<h3 class="saturday-shift" style="text-align:center;color:#009fe3">{$saturdayShift}</h3>
		</div>
		{/if}
				
	</div>
</div>