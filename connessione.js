
var conn = function(){
	var base = '<input type="hidden" id="idx" value="0"/><input type="hidden" id="msg" value=""/>';
		
	function addZero(n){
		if(n<10) return '0'+n;
		else return ''+n;
	}

	function getRead() {
		var idx = document.getElementById('idx').value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200 && flag.sema==0) {
				flag.sema=1;
				var arr;
				try{
					arr = JSON.parse(this.responseText);
				}catch(e){
					console.info(e);
				}
				var i=0;
				if(arr.length>1 && document.getElementById('idx').value != parseInt(arr[arr.length-1][1])-1){
					document.getElementById('idx').value = parseInt(arr[arr.length-1][1])-1 ;
					while(i<arr.length-1){
						try{
							var msgg = crypton.decripta(arr[i][1],acc.pass).split('#::#');
							var msgg1 = parseInt(msgg[1].substring(0,13));
							var m = addZero((new Date(msgg1)).getMinutes());
							var h = addZero((new Date(msgg1)).getHours());
							document.getElementById('demo').innerHTML += '<div class="sMsg"><div class="talk-bubble '+(arr[i][0]==acc.abc? "tri-right-top":"tri-left-top")+'"><div class="accChat">'+arr[i][0]+'</div><div class="messaggio talktext">'+msgg[0]+'<div class="time">'+h+':'+m+'</div></div></div></div>';
						}catch(e){}
						i++;
					}
					$i('demo').scrollTop = $i('demo').scrollHeight;
				}
				setTimeout(function(){flag.sema=0; getRead();},1000);
				
			}
		};
		xhttp.open('POST', 'serverChat.php', true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhttp.send('ACTION=r&INDEX='+(idx));
	}

	function sendMsg(msg) {
		if($i("texto").value=="") return;
		document.getElementById('btnSend').disabled = true;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			try{
				var arr = JSON.parse(this.responseText);
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById('texto').value='';
					document.getElementById('btnSend').disabled = false;
					if(arr.length>1 && arr[1]==2) $i("demo").innerHTML = base;
				}
			}catch(e){}
		};
		xhttp.open('POST', 'serverChat.php', true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		if($i("texto").value==("/reset"))
			xhttp.send('ACTION=rst');
		else
			xhttp.send('ACTION=w&ACCOUNT='+acc.abc+'&MESSAGGIO='+crypton.cripta(msg+'#::#'+(new Date).getTime()+(Math.random()*Math.log(Math.random())),acc.pass));
		
	}
	return{
		getRead:getRead,
		sendMsg:sendMsg,
		flag:flag,
		crypton:crypton
	}
}();