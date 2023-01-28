<div id="sale-flash">
  <div id="countdown">
    <div id="product-thumbnail">
		<img src="{$bannerSrc}" />
    </div>
    <ul>
      <li><span id="days"></span>Joures</li>
      <li><span id="hours"></span>Heures</li>
      <li><span id="minutes"></span>Minutes</li>
      <li><span id="seconds"></span>Secondes</li>
    </ul>
  </div>
  <div id="mp-product">
		<a href="{$url}">
			<img src="{$afficheSrc}" alt="{$start|date_format:'%d/%m/%Y/%H:%M'}-{$end|date_format:'%d/%m/%Y/%H:%M'}" style="width: 100%;"/>
		</a>	
  </div>
</div>