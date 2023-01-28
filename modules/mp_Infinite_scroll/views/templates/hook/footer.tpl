<style>
.pagination .page-list {
    box-shadow: none;
    display: none;
}
.product-image-block img{
	min-height:calc(((100vw -6em -10px * 6)  / 6)*(157/223));
	
}
.product-description{
	min-height:138px;
}

</style>
{*
*  @author    Miguel Costa for emotionLoop
*  @copyright emotionLoop
*}
<script>
    (function(){
        let currentPage = 1
        let pageCount = 1
        let pageHeight = window.innerHeight
        let timer = null
        let productsDiv = document.querySelector("#js-product-list .products-grid .products")
        let baseUrl = null
        if(!document.querySelectorAll(".page-list li a")[0]){
			if(document.querySelector("#loading img"))
				document.querySelector("#loading img").style.display="none"
			return
		}
		baseUrl = document.querySelectorAll(".page-list li a")[0].getAttribute("href")
		if(baseUrl.indexOf('?') == -1){
			baseUrl = document.querySelectorAll(".page-list li a")[0].getAttribute("href")+"?page=" 
		}else{
			baseUrl = document.querySelectorAll(".page-list li a")[0].getAttribute("href")+"&page=" 
		}
        async function getContent(baseUrl){
            let response = await fetch(baseUrl);
            if (response.ok) { 
                let html = await response.text();
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");
                products = doc.querySelectorAll("#js-product-list .products-grid .products .product-item")
                products.forEach(product=>{
					product.style.position = "relative"
					articleUrl = "https://www.facebook.com/sharer.php?u=" + encodeURI(product.querySelector(".product-image-block > a"))
					icon = `<a href="`+articleUrl+`" style="z-index: 10;position:absolute;left:10px;border-radius: 50%;" class="text-hide" title="Partager" target="_blank">
						<li class="fab fa-facebook" style="font-size:32px;color:#3b5998;z-index:10;background-color: white;border-radius:50%">
							<span class="share-label">Partager</span>
						</li>
					</a>`
					content = icon + product.innerHTML
					product.innerHTML =  content 
					productsDiv.appendChild(product)
                })
            } else {
                console.log("HTTP-Error: " + response.status);
            }
        }
        document.querySelectorAll(".page-list li a").forEach((link, index, links)=>{
            if(links.length - 1 > index){
                pageCount = parseInt(link.innerHTML)
            }
        })
        window.addEventListener("scroll",function(){
            if(!document.querySelector(".page-list")) return
            pageListPos = document.querySelector(".page-list").getBoundingClientRect().top
            if(pageListPos-pageHeight <= 0 && currentPage < pageCount){
                if(timer !== null) {
                    clearTimeout(timer);        
                }
                timer = setTimeout(function() {
                    currentPage++
                    getContent(baseUrl + currentPage)
                }, 300);
            }else{
                document.querySelector("#loading img").style.display="none"
            }
        },{ passive: true })
    })()
</script>
