<section class="featured-products clearfix" style="background:#eef1f3;margin-top: 0;" >
	<li class="hc-tab" data-id-category="-1" style="list-style: none;"> 
		<a class="homecat_image" href="{$link->getPageLink('new-products')}">
			<div class="hc_bg_desktop"> 
				<img src="{$bannerSrc}" alt="acc">
			</div> 
		</a>
		<div class="hc-tab-info">
			<a class="hc-cat parent-cat active" href="{$link->getPageLink('new-products')}" data-id-category="-1" data-id-parent="-1" data-id-feature="no">Nouveaux produits</a>
			<a class="hc-view-all" href="{$link->getPageLink('new-products')}">Voir tout</a>
			<div class="clearfix"></div>
		</div>
	</li>
  <div class="clearfix"></div>
  <div class="products" data-index="0">
	{foreach from=$products item="product"}
	  {include file="catalog/_partials/miniatures/product.tpl" product=$product}
	{/foreach}
  </div>
  
</section>
