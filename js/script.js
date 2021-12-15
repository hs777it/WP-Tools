//Font Resizer
var jq = jQuery.noConflict();
jq(document).ready(function () {
	
	if(isMobile.any()) {jq(".font-manage").hide();}
	
	var pElmnt = jq(".entry-content p");
  	var pInitSize = parseInt(pElmnt.css("font-size")); 
	pElmnt.css("font-size",parseInt(getCookie('font_size')));
	var newSize = parseInt(pElmnt.css("font-size"));
	
  	jq(".font-manage a").on("click" ,function (e) {
	  e.preventDefault();
    
		if (this.className == "a-pluse" && newSize < 70 ) { newSize++; }
		else if (this.className == "a-minus" && newSize > 12) { newSize--; }
		else if (this.className == "a-init"){ newSize = pInitSize; }
		
	  pElmnt.css({ "font-size": newSize + "px" });
	  setCookie('font_size',newSize,7);

	if (this.className == "a-twitter") {
		pElmnt.css("font-size",newSize);	
			window.open(jq(this).attr('href'), "twitter","toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=550,resizable=1");
	  }  

	if (this.className == "a-wa") {
		
		var device = "web";
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) { device = "api"; }
		
		var url = "\/\/" + device + "." + jq(this).attr('href');
		
	  window.open(url, "whatsapp","toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=550,resizable=1");
	  } 

	  if(this.className == "a-print"){
		  window.print();
	  }

	  if(this.className == "a-copy"){
		console.log(jq(this).attr('href'));//window.location.href
		navigator.clipboard.writeText(jq(this).attr('href'));
		jq('.copy_msg').fadeIn(500).delay(500).fadeOut(500);
	  }
	if(this.className == "a-file"){
	 	if( isMobile.any() ) alert('Mobile');
		if( isMobile.iOS() ) alert('iOS');
	   }	
		
	  
  });
}); 