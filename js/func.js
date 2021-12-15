function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function removeCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

//=-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
// if( isMobile.any() ) alert('Mobile');
// if( isMobile.iOS() ) alert('iOS');

//=-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=
function isMobile() {      
    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

    if (isMobile) {
        return true;
    }
 }
 
//=-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=
function mobile(){
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) 
	{ return true; }
}
//jquery
//$.browser.device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));

//=-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-= =-=-=-=



// 	 .children().click(function(e) { // catch all children click
//     e.stopPropagation();
//  });