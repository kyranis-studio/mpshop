(function () {
    const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;
    function getDate(datetime){
      dateArray = datetime.split('/')
      date = dateArray[1]+"/"+dateArray[0]+"/"+dateArray[2]+" "+dateArray[3]
      console.log(date,new Date(date).getTime())
      return new Date(date).getTime()
    }
    try{
        period = document.querySelector("#mp-product > a > img").getAttribute("alt")
        dates = period.split("-")
        start = getDate(dates[0])
        end = getDate(dates[1])
    }catch(e){
		if(document.getElementById("sale-flash"))
			document.getElementById("sale-flash").style.display = "none";
        return
    }
    
    //I'm adding this section so I don't have to keep updating this pen every year :-)
    //remove this if you don't need it
    let today = new Date(),
        dd = String(today.getDate()).padStart(2, "0"),
        mm = String(today.getMonth() + 1).padStart(2, "0"),
        yyyy = today.getFullYear(),
        timeArray = period.split("/")
    today = mm + "/" + dd + "/" + yyyy;
    if (new Date().getTime() >= start && end > start) {
        countDownDate = end
    }else{
      document.getElementById("sale-flash").style.display = "none";
      return
    }
    //end
    const countDown = end
        x = setInterval(function () {
            const now = new Date().getTime(),
                distance = countDown - now ;
            document.getElementById("days").innerText = Math.floor(distance / (day)),
                document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
            //do something later when date is reached
            if (distance < 0) {
                document.getElementById("sale-flash").style.display = "none";
                clearInterval(x);
            }else{
				document.getElementById("sale-flash").style.display = "block";
			}
            //seconds
        }, 250)
}());