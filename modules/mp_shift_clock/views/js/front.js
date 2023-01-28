/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

(()=>{
	var hours
	var mins
	var hrotate
	var firstShift = jQuery(".first-shift").text().split("-").map(shift =>{return parseInt(shift.split(":")[0])})
	var pauseShift = jQuery(".pause-shift").text().split("-").map(shift =>{return parseInt(shift.split(":")[0])})
	var secondShift = jQuery(".second-shift").text().split("-").map(shift =>{return parseInt(shift.split(":")[0])})
	if(jQuery(".saturday-shift").lenght){
		var saturdayShift = jQuery(".saturday-shift").text().split("-").map(shift =>{return parseInt(shift.split(":")[0])})
	}else{
		var saturdayShift = jQuery(".first-shift").text().split("-").map(shift =>{return parseInt(shift.split(":")[0])})
	}
	function formatTime(h,m){
		if(m == 60){
			m = 0
			h++
		}
		if(h < 10) h = "0"+h
		if(m < 10) m = "0"+m
		return h+":"+m
	}
	function setActiveShift(){
		var day = new Date().getDay()
		if(day > 0 && day < 6){
			  if(hours >= firstShift[0] && hours < firstShift[1]){
				  jQuery("#mp-open").css("display","block")
				  jQuery("#mp-close").css("display","none")
				  leftH = firstShift[1] - hours - 1
				  leftM = 60 - mins
				  timer = 1 - (leftH* 60 + leftM) / ((firstShift[1]-firstShift[0])*60)
				  jQuery("#clock").css("--timer",timer)
				  activeDeg = jQuery("#clock").css("--fs-start-deg")
				  activeProg = jQuery("#clock").css("--pause-start-prog")
				  jQuery("#clock").css("--active-start-deg",activeDeg)
				  jQuery("#clock").css("--active-prog",activeProg)
				  jQuery("#clock").css("--active-color","#009fe3")
				  jQuery("#mp-message").html("Temps restant avant la pause "+formatTime(leftH,leftM))
				  jQuery(".time-marker").html("مفتوح")
				  jQuery(".time-marker").css("color","#009fe3")
				  jQuery(".pointer").css("border","solid 1px #0b4fcd")
				  jQuery(".icon-arrow-up-solid").css("color","#0b4fcd")
				  jQuery(".icon-arrow-up-solid").css("display","inline")
			  }else if(hours >= secondShift[0]  && hours < secondShift[1]){
				  jQuery("#mp-open").css("display","block")
				  jQuery("#mp-close").css("display","none")
				  leftH = secondShift[1] - hours - 1
				  leftM = 60 - mins
				  timer = 1 - (leftH * 60 + leftM) / ((secondShift[1]-secondShift[0])*60)
				  jQuery("#clock").css("--timer",timer)
				  activeDeg = jQuery("#clock").css("--ss-start-deg")
				  activeProg = (secondShift[1] - secondShift[0])/12
				  jQuery("#clock").css("--active-start-deg",activeDeg)
				  jQuery("#clock").css("--active-prog",activeProg)
				  jQuery("#clock").css("--active-color","#009fe3")
				  jQuery("#mp-message").html("Temps restant avant la fermeture "+formatTime(leftH,leftM))
				  jQuery(".time-marker").html("مفتوح")
				  jQuery(".time-marker").css("color","#009fe3")
				  jQuery(".time-marker").css("transform","scale(-1) translateX(-15px)")
				  jQuery(".pointer").css("border","solid 1px #0b4fcd")
				  jQuery(".icon-arrow-up-solid").css("color","#0b4fcd")
				  jQuery(".icon-arrow-up-solid").css("display","inline")
			  }else if(hours >= pauseShift[0] && hours < pauseShift[1]){
				  jQuery("#mp-open").css("display","none")
				  jQuery("#mp-close").css("display","block")
				  leftH	= pauseShift[1] - hours - 1
				  leftM = 60 - mins
				  timer = 1 - (leftH * 60 + leftM) / ((pauseShift[1] - pauseShift[0])*60)
				  jQuery("#clock").css("--timer",timer)
				  activeDeg = jQuery("#clock").css("--pause-start-deg")
				  jQuery("#clock").css("--active-color","#be1622")
				  jQuery("#clock").css("--active-start-deg",activeDeg)
				  activeProg = (pauseShift[1] - pauseShift[0])/12
				  jQuery("#clock").css("--active-prog",activeProg)
				  jQuery("#mp-message").html("Temps restant avant l'ouverture "+formatTime(leftH,leftM))
				  jQuery(".time-marker").html("راحة")
				  jQuery(".time-marker").css("color","#cf000f")
				  jQuery(".pointer").css("border","solid 1px #cf000f")
				  jQuery(".icon-arrow-up-solid").css("color","#cf000f")
				  jQuery(".icon-arrow-up-solid").css("display","inline")
			  }else{
				  jQuery("#mp-open").css("display","none")
				  jQuery("#mp-close").css("display","block")
				  jQuery(".icon-arrow-up-solid").css("display","none")
				  jQuery("#mp-message").html("la boutique ouvre 09:00")
			  }
		  }else if(day == 6){
			  if(hours >= saturdayShift[0] && hours < saturdayShift[1]){
				jQuery("#mp-open").css("display","block")
				  jQuery("#mp-close").css("display","none")
				  leftH = saturdayShift[1] - hours - 1
				  leftM = 60 - mins
				  timer = 1 - (leftH* 60 + leftM) / ((saturdayShift[1]-saturdayShift[0])*60)
				  jQuery("#clock").css("--timer",timer)
				  activeDeg = jQuery("#clock").css("--fs-start-deg")
				  activeProg = jQuery("#clock").css("--pause-start-prog")
				  jQuery("#clock").css("--active-start-deg",activeDeg)
				  jQuery("#clock").css("--active-prog",activeProg)
				  jQuery("#clock").css("--active-color","#009fe3")
				  jQuery("#mp-message").html("Temps restant avant la pause "+formatTime(leftH,leftM))
				  jQuery(".time-marker").html("مفتوح")
				  jQuery(".time-marker").css("color","#009fe3")
				  jQuery(".pointer").css("border","solid 1px #0b4fcd")
				  jQuery(".icon-arrow-up-solid").css("color","#0b4fcd")
				  jQuery(".icon-arrow-up-solid").css("display","inline")
			  }else{
				  jQuery("#mp-open").css("display","none")
				  jQuery("#mp-close").css("display","block")
				  jQuery("#clock").removeClass("first-shift")
				  jQuery("#clock").removeClass("second-shift")
				  jQuery("#clock").removeClass("pause")
				  jQuery("#mp-message").html("la boutique ouvre lundi 09:00")
				  jQuery(".icon-arrow-up-solid").css("display","none")
			  }
		  }else{
			  jQuery("#clock").removeClass("first-shift")
			  jQuery("#clock").removeClass("second-shift")
			  jQuery("#clock").removeClass("pause")
			  jQuery("#mp-open").css("display","none")
			  jQuery("#mp-close").css("display","block")
			  jQuery(".icon-arrow-up-solid").css("display","none")
			  jQuery("#mp-message").html("la boutique est fermée le dimanche")
		  }
	}
	try{
	setInterval( function() {
		  var seconds = new Date().getSeconds();
		  var sdegree = seconds * 6;
		  var srotate = "rotate(" + sdegree + "deg)";
		  jQuery("#sec").css({"-moz-transform" : srotate, "-webkit-transform" : srotate,"transition":"0s"});
		  setActiveShift()
	  }, 1000 );
	  
 
	  setInterval( function() {
		  hours = new Date().getHours();
		  mins = new Date().getMinutes();
		  var hdegree = hours * 30 + (mins / 2);
		  hrotate = "rotate(" + hdegree + "deg)";
		  jQuery("#hour").css({"-moz-transform" : hrotate, "-webkit-transform" : hrotate,"transition":"0s"});
		  setActiveShift()
	  }, 1000 );


	  setInterval( function() {
		  var mins = new Date().getMinutes();
		  var mdegree = mins * 6;
		  var mrotate = "rotate(" + mdegree + "deg)";
		  jQuery("#min").css({"-moz-transform" : mrotate, "-webkit-transform" : mrotate,"transition":"0s"});
		  
	  }, 1000 );
	}catch(e){console.log(e)}
	  
})()
