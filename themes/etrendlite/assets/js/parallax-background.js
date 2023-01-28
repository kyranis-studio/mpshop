/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
(function($){
    var methods = {
        init : function( options ) {

            var settings = {
                offset: true
            ,   bgfixed: true
            ,   invert: true
            }

            return this.each(function(){
                if ( options ){
                    $.extend(settings, options);
                } 
                
                var 
                    $this = $(this)
                ,   windowSelector = $(window)
                ,   documentSelector = $(document)
                ,   thisHeight = 0
                ,   thisOffsetTop
                ,   image_url = ''
                ,   image_width = ''
                ,   image_height = ''
                ,   msie8 = Boolean(navigator.userAgent.match(/MSIE ([8]+)\./))
                ;
                
                _constructor();
                function _constructor(){
                    image_url = $this.data("source-url");
                    image_width = parseFloat($this.data("source-width"));
                    image_height = parseFloat($this.data("source-height"));

                    $this.css({'background-image': 'url('+image_url+')'});
                 /*   if(settings.bgfixed){
                        $this.css({'background-attachment': 'fixed'});
                    }*/

                    addEventsFunction();                    
                }
                
                function addEventsFunction(){
                    //------------------ window scroll event -------------//
                    windowSelector.on('scroll',
                        function(){
                            if(settings.offset){
                                mainScrollFunction();
                            }
                        }
                    ).trigger('scroll');
                    //------------------ window resize event -------------//
                    windowSelector.on("resize",
                        function(){
                            $this.width(windowSelector.width());
                            $this.css({'width' : 'auto' /*,'margin-left' : Math.floor(windowSelector.width()*-0.5), 'left' : '50%' */ });

                            if(settings.offset){
                                mainResizeFunction();
                            }
                        }
                    ).trigger('resize');
                }
                //------------------ window scroll function -------------//
                function mainScrollFunction(){
                    parallaxEffect();
                }
                //------------------ window resize function -------------//
                function mainResizeFunction(){                    
                    parallaxEffect();
                }
                
                function parallaxEffect(){
                    var 
                        documentScrollTop
                    ,   startScrollTop
                    ,   endScrollTop
                    ,   visibleScrollValue
                    ;

                    thisHeight = $this.outerHeight();
                    windowHeight = windowSelector.height();
                    thisOffsetTop = $this.offset().top;
                    documentScrollTop = documentSelector.scrollTop();
                    startScrollTop = documentScrollTop + windowHeight;
                    endScrollTop = documentScrollTop - thisHeight;

                    if( ( startScrollTop > thisOffsetTop ) && ( endScrollTop < thisOffsetTop ) ){
                        visibleScrollValue = startScrollTop - endScrollTop;
                        pixelScrolled = documentScrollTop - (thisOffsetTop - windowHeight);
                        percentScrolled = pixelScrolled / visibleScrollValue;

                        if(settings.invert){
                            deltaTopScrollVal = percentScrolled * 100;
                            $this.css({'background-position': '50% '+deltaTopScrollVal+'%'});
                        }else{
                            deltaTopScrollVal = (1-percentScrolled) * 100;
                            $this.css({'background-position': '50% '+deltaTopScrollVal+'%'});
                        }
                    }
                }

            });
        },
        destroy    : function( ) { },
        reposition : function( ) { },
        update     : function( content ) { }
    };

    $.fn.ParallaxBackground = function( method ){ 
        
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method with name ' +  method + ' is not exist for jQuery' );
        }
         
        
    }//end plugin
	let index = 1
	if(document.querySelectorAll(".btn-help-switch")){
		document.querySelectorAll(".btn-help-switch").forEach(btn=>{
			btn.addEventListener("click",function(event){
				document.querySelectorAll(".btn-help-switch").forEach(btn=>{
					btn.classList.remove("active")
				})
				event.target.classList.add("active")
				if(event.target.getAttribute("id") == "btn-switch-fr"){
					document.querySelector("#mp-help-form-fr").classList.add("show")
					document.querySelector("#mp-help-form-ar").classList.remove("show")
				}else{
					document.querySelector("#mp-help-form-fr").classList.remove("show")
					document.querySelector("#mp-help-form-ar").classList.add("show")
				}
				document.querySelectorAll(".lang").forEach(element =>{
					element.classList.toggle("active");
				})
			})
		})
	}
	if(document.querySelector("#mp-help-form-ar")){
		document.querySelector("#mp-help-form-ar").innerHTML = `
		<select name="ar-question" id="mp-help-menu-ar" >
			<option value="command" dir="rtl">كيفاش نعدي كموند على السيت</option>
			<option value="paiment" dir="rtl">كيفاش ناخو سلعتي و نخلص</option>
			<option value="contact" dir="rtl">كيفاش نتصل بيكم</option>
			<option value="command-fb" dir="rtl">كيفاش نعدي كموند عالفايسبوك</option>
		</select>`
	}
	if(document.querySelector("#mp-help-form-fr")){
		document.querySelector("#mp-help-form-fr").innerHTML = `
		<select name="fr-question" id="mp-help-menu-fr" >
			<option value="command">passer une commande sur le site</option>
			<option value="paiment">payer et recevoir vos produits</option>
			<option value="contact">contactez nous</option>
			<option value="command-fb">commander sur facebook</option>
		</select>`
	}
	function next(index){
		document.querySelector(".f"+index).classList.add("show")
		setTimeout(()=>{
			document.querySelector(".frame.show").classList.remove("show")
			index++
			if(index > 4) index = 1
			next(index)
		},3000)
	}
	if(document.querySelector(".frame.show")) next(index)
	function mpActiveTab(event){
		if(event.target.classList.contains('command')){
			activeClass = "command"
		}else if(event.target.classList.contains('paiment')){
			activeClass = "paiment"
		}else if(event.target.classList.contains('contact')){
			activeClass = "contact"
		}else if(event.target.classList.contains('command-fb')){
			activeClass = "command-fb"
		}
		document.querySelector("button.help-step.active").classList.remove("active")
		event.target.classList.add("active")
		document.querySelector(".mp-tab.active").classList.remove("active")
		document.querySelector(".mp-tab."+activeClass).classList.add("active")
	}
	function mobileSelect(event){
		activeClass = event.target.value 
		console.log(activeClass)
		if(event.target.classList.contains('command')){
			activeClass = "command"
		}else if(event.target.classList.contains('paiment')){
			activeClass = "paiment"
		}else if(event.target.classList.contains('contact')){
			activeClass = "contact"
		}else if(event.target.classList.contains('command-fb')){
			activeClass = "command-fb"
		}
		document.querySelector(".mp-tab.active").classList.remove("active")
		document.querySelector(".mp-tab."+activeClass).classList.add("active")
		document.querySelector(".card.active").classList.remove("active")
		document.querySelector(".card."+activeClass).classList.add("active")
	}
	if(document.querySelector("#mp-help-menu-ar")){
		document.querySelector("#mp-help-menu-ar").addEventListener("change",mobileSelect)
		document.querySelector("#mp-help-menu-fr").addEventListener("change",mobileSelect)
	}
	document.querySelectorAll(".help-step").forEach(btn =>{
		btn.addEventListener("click",mpActiveTab)
	})
	document.querySelectorAll(".hc-products-container").forEach(container=>{
		container.addEventListener("touchstart", function(e){
			initialX = e.touches[0].clientX;
			initialY = e.touches[0].clientY;
			
		}, false);
	})
	document.querySelectorAll(".hc-products-container").forEach(container=>{
		container.addEventListener("touchmove", function(e){
			if (initialX === null) {
			return;
		}
		if (initialY === null) {
			return;
		}
		leftBtn = this.querySelector('.mp-mobile-control .mp-left')
		rightBtn = this.querySelector('.mp-mobile-control .mp-right')
		if (initialX === null) {
			return;
		}
		if (initialY === null) {
			return;
		}
		var currentX = e.touches[0].clientX;
		var currentY = e.touches[0].clientY;
		var diffX = initialX - currentX;
		var diffY = initialY - currentY;
		if (Math.abs(diffX) > Math.abs(diffY)) {
			if (diffX > 0) {					
				rightBtn.click()
			} else {
				leftBtn.click()
			}  
		}
		initialX = null;
		initialY = null;
		e.preventDefault();
			
		}, false);
	})
	
	document.querySelectorAll('.mp-left').forEach(btn => {
		btn.setAttribute("disabled",true)
		btn.style.opacity = 0.5
	})
	
	document.querySelectorAll('.mp-left').forEach(function(btnLeft){
		btnLeft.addEventListener("click",function(event){
			this.parentElement.querySelector('.mp-right').removeAttribute("disabled")
			this.parentElement.querySelector('.mp-right').style.opacity = 1
			var products = this.parentElement.parentElement.children[0]
			productWidth = document.querySelector(".hc-products-container").clientWidth - 20
			index = products.getAttribute("data-index")
			index = parseInt(index) - 1
			if(index <0){
				index = 0
			}
			if(index == 0){
				this.setAttribute("disabled",true)
				this.style.opacity = 0.5
			}
			products.style.transform = "translateX("+ index*productWidth*-1 +"px)"
			products.setAttribute("data-index",index)
		})
	})
	
	document.querySelectorAll('.mp-right').forEach( function(btnRight){
		btnRight.addEventListener("click",function(event){
			this.parentElement.querySelector('.mp-left').removeAttribute("disabled")
			this.parentElement.querySelector('.mp-left').style.opacity = 1
			index = null
			var products = this.parentElement.parentElement.children[0]
			productWidth = document.querySelector(".hc-products-container").clientWidth - 20
			index = products.getAttribute("data-index")
			index = parseInt(index) + 1
			if(index > products.children.length-1){
				index = products.children.length -1
			}
			if(index == products.children.length-1){
				this.setAttribute("disabled",true)
				this.style.opacity = 0.5
			}
			products.setAttribute("data-index",index)
			products.style.transform = "translateX("+ index*productWidth*-1 +"px)"
		})
	})
	var resizeId;
	function setMoblieControl(){
		clearTimeout(resizeId);
		resizeId = setTimeout(()=>{
			const isMobile = window.matchMedia("only screen and (max-width: 640px)").matches;
			if (isMobile && document.querySelector(".hc-products-container")) {
				productWidth = document.querySelector(".hc-products-container").clientWidth - 20
				document.querySelectorAll(".hc-products-list.has-products").forEach(productList => {
					index = productList.getAttribute("data-index")
					productList.parentElement.style.width = productWidth  + "px"
					itemCount = productList.children.length 
					if(itemCount > 0){
						for(i=0; i<itemCount ;i++){
							productList.children[i].style.width = productWidth + "px"
						}
						productList.style.transform = "translateX("+ index*productWidth*-1 +"px)"
						productList.style.width = itemCount * productWidth + 20 + "px"
					}
				})
				document.querySelectorAll(".mp-mobile-control").forEach(control =>{
					control.style.width = productWidth + 20 + "px"
				})
			}else{
				document.querySelectorAll(".hc-products-list.has-products").forEach(productList => {
					productList.setAttribute("data-index","0")
					for(i=0;i<productList.children.length;i++){
						productList.children[i].style = null
					}
					productList.style = null
					productList.parentElement.style = null
				})
			}
		}, 100);
	}
	setMoblieControl()
	window.addEventListener('resize', setMoblieControl);
	document.querySelector(".mm_menus_ul").addEventListener("touchstart", startTouch, false);
	document.querySelector(".mm_menus_ul").addEventListener("touchmove", moveTouch, false);
	function startTouch(e) {
		initialX = e.touches[0].clientX;
		initialY = e.touches[0].clientY;
	};
	
	function moveTouch(e) {
		if (initialX === null) {
			return;
		}
		if (initialY === null) {
			return;
		}
		var currentX = e.touches[0].clientX;
		var currentY = e.touches[0].clientY;
		var diffX = initialX - currentX;
		var diffY = initialY - currentY;
		if (Math.abs(diffX) > Math.abs(diffY)) {
			if (diffX > 0) {
				document.querySelector(".pull-right").click()
			}   
		}
		initialX = null;
		initialY = null;
		e.preventDefault();
	};
	document.querySelectorAll("#main .product-item").forEach(item => {
		item.style.position = "relative"
		articleUrl = "https://www.facebook.com/sharer.php?u=" + encodeURI(item.querySelector(".product-image-block > a"))
		icon = `<a href="${articleUrl}" style="z-index: 10;position:absolute;left:10px;border-radius: 50%;" class="text-hide" title="Partager" target="_blank">
			<li class="fab fa-facebook" style="font-size:32px;color:#3b5998;z-index:10;background-color: white;border-radius:50%">
				<span class="share-label">Partager</span>
			</li>
		</a>`
		content = icon + item.innerHTML
		item.innerHTML =  content 
	})
	prestashop.on("updateCart",(event)=>{
		function removePopup(id){
			
			setTimeout(function(){ 
				if(! document.querySelector("#id-"+id)) return
				document.querySelector("#id-"+id).classList.remove("hide")
			}, 100);
			setTimeout(function(){ 
				if(! document.querySelector("#id-"+id)) return
				document.querySelector("#id-"+id).classList.add('hide')
			}, 2800);
			setTimeout(function(){ 
				if(! document.querySelector("#id-"+id)) return
				document.querySelector("#id-"+id).classList.remove("hide")
				document.querySelector("#id-"+id).remove()
			}, 3000);
		}
		var eventDatas = {};
		if (event && event.reason) {
			idProduct = event.reason.idProduct
			document.querySelectorAll('.loading-btn').forEach(activeBtn=>{
				popupId = activeBtn.getAttribute("data-popup-id")
				if(idProduct == popupId){
					activeBtn.classList.remove('loading-btn')
					if(activeBtn.classList.contains('btn-primary')){
						activeBtn.removeAttribute("disabled")
						activeBtn.style.position = "relative"
						height = activeBtn.clientHeight + 10
						popup = document.createElement("div")
						popup.setAttribute("id","id-"+popupId)
						popup.classList.add('popup')
						popup.classList.add('hide')
						popup.style.position = "absolute"
						popup.style.top = -1*height+5+"px"
						popup.style.left = "0"
						popup.style.width = "100%"
						popup.style.padding = "10px"
						popup.style.background = "#43a047"
						popup.innerHTML = "&#10004; Produit Ajouter"
						activeBtn.appendChild(popup)
						new removePopup(popupId)
					}
				}
			})
		}
		
		setTimeout(function(){ 
			document.querySelectorAll('.remove-from-cart').forEach(btn =>{
				btn.addEventListener('click',function(event){
					console.log("remove")
					this.classList.add("loading-btn")
					document.querySelectorAll('.remove-from-cart:not(.loading-btn)').forEach(btn=>{
						btn.style.pointerEvents = "none"
						btn.style.opacity = 0.5
					})
				})
			})
		}, 1000);
	}) 
	
	function setLoadingState(btn,popupId){
		btn.addEventListener('click',function(event){
			this.classList.add("loading-btn")
			this.setAttribute("data-popup-id",popupId)
			self = this
			setTimeout(function(){ 
				self.setAttribute("disabled","")
			}, 100);
		})
	}
	document.querySelectorAll('.cart-form-url .btn.btn-primary').forEach(btn =>{
		popupId = btn.parentElement.querySelector("input[name=id_product]").value
		setLoadingState(btn,popupId)
	})
	document.querySelectorAll('.btn.btn-primary.add-to-cart').forEach(btn =>{
		popupId = btn.parentElement.parentElement.parentElement.parentElement.querySelector("input[name=id_product]").value
		setLoadingState(btn,popupId)
	})
	if(document.querySelectorAll(".js-qv-mask ul li").length>3){
		document.querySelector(".img-control.up").style.display = "block"
		document.querySelector(".img-control.down").style.display = "block"
	}
	if(document.querySelector(".img-control.up")){
		document.querySelector(".img-control.up").addEventListener("click",event=>{
			index = parseInt(document.querySelector(".js-qv-mask").getAttribute("data-index"))
			index--
			thumbnail = document.querySelectorAll(".js-qv-mask ul li").length
			thumbnail>3?offset = thumbnail - 3 : offset = 0
			if(index >= 0){
				document.querySelector(".js-qv-mask ul").style.transform = "translateY("+ -139*index+"px)"
				document.querySelector(".js-qv-mask").setAttribute("data-index",index)
			}
		})
	}
	if(document.querySelector(".img-control.down")){
		document.querySelector(".img-control.down").addEventListener("click",event=>{
			index = parseInt(document.querySelector(".js-qv-mask").getAttribute("data-index"))
			index++
			thumbnail = document.querySelectorAll(".js-qv-mask ul li").length
			thumbnail>3?offset = thumbnail - 3 : offset = 0
			if(index <= offset){
				document.querySelector(".js-qv-mask ul").style.transform = "translateY("+ -139*index+"px)"
				document.querySelector(".js-qv-mask").setAttribute("data-index",index)
			}
		})
	}
	document.querySelectorAll(".thumb.js-thumb").forEach(img=>{
		img.addEventListener("mouseover",event=>{
			src = img.getAttribute("data-image-large-src")
			document.querySelector(".js-qv-product-cover").setAttribute("src",src)
		})
	})	
	window.onscroll = function() {stickyNav()};

	// Get the navbar
	var navbar = document.querySelector(".header-navfullwidth")
	var header = document.querySelector("#header")
	var offre = document.querySelector("#mp_offre")
	
	// Get the offset position of the navbar
	var sticky = navbar.offsetTop;
	stickyNav()
	// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
	function stickyNav() {
	  var jolisearch = document.querySelector(".ui-jolisearch")
	  if (window.pageYOffset >= sticky) {
		header.classList.add("sticky")
		if(jolisearch){
			jolisearch.classList.add("sticky")
			jolisearch.style.top = "73px"
		}
		if(offre) offre.style.display = "none"
	  } else {
		header.classList.remove("sticky")
		if(jolisearch){
			jolisearch.classList.remove("sticky")
			jolisearch.style.top = "128px"
		}
		if(offre)  offre.style.display = "block"
	  }
	}
	document.querySelector(".search-bnt").addEventListener("click",function(event){
		event.preventDefault()
		document.querySelector("#search_widget").classList.toggle("show-search")
		this.classList.toggle("open")
		this.classList.toggle("hide")
	})
	document.querySelectorAll("a").forEach(link => {
		link.addEventListener("click",function(event){
			href = this.getAttribute("href")
			hostname = window.location.protocol+"//"+window.location.hostname+"/"
			pathname = href.replace(hostname,"")
			if(pathname == "#"){
				event.preventDefault()
			}
		})
	})
	
})(jQuery);