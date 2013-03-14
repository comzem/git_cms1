//平滑滚动到顶部
toTop = {
	init:function(){
		document.getElementById("toTop").onclick=function(e){
			toTop.set();
			return false;
		}		
	},
	waitTimer:null,
	set:function(){
		var d_st=document.documentElement.scrollTop;
		if(window.navigator.userAgent.indexOf("MSIE")>=1){
			for (var i=d_st; i>10; i-=Math.floor(i/6)){
			window.scrollTo(0,i);
			}
			window.scrollTo(0,10);
		}
		else{
		window.scrollTo(0,Math.floor(d_st / 2));
		
		 if(d_st>10){
				 waitTimer=setTimeout("toTop.set()",40);
		  }
			else{
				  clearTimeout(waitTimer);
			}
		}
	}
}
window.onload = function(){toTop.init();}


lastScrollY=0;
function heartBeat(){ 
var diffY;
if (document.documentElement && document.documentElement.scrollTop)
    diffY = document.documentElement.scrollTop;
else if (document.body)
    diffY = document.body.scrollTop
else
    {/*Netscape stuff*/}

percent=.1*(diffY-lastScrollY); 
if(percent>0)percent=Math.ceil(percent); 
else percent=Math.floor(percent); 
document.getElementById("full").style.top=parseInt(document.getElementById("full").style.top)+percent+"px";

lastScrollY=lastScrollY+percent; 
}
function mClk(){ //自
event.srcElement.click();
} 
//去掉鼠标经过QQ时就点击功能 onmouseover='mClk()'


document.write(suspendcode);
window.setInterval("heartBeat()",1);