	var min = 13;
	var max = 25;
	var width = 13;
	var b = 0;
	
	function expand(){

			
		if(b != 2){
			b = 1;
			exp = document.getElementById("sidebar").style.width=width+'%';
			if(width < max)
			{	
				width = width + 1;
				setTimeout('expand()', 10);
			} else {
				b = 0;
			}
		}
		
	}
	
	function reset_check(){
	
		if (!e) var e = window.event;
		var tg = (window.event) ? e.srcElement : e.target;
		if (tg.id != 'sidebar') return;
		var reltg = (e.relatedTarget) ? e.relatedTarget : e.toElement;
		while (reltg != tg && reltg.nodeName != 'BODY')
			reltg= reltg.parentNode;
			
		if (reltg == tg) return;
		
		reset();
	
	}
	
	function reset(){
		
		if(b != 1){
			b = 2;
			exp = document.getElementById("sidebar").style.width=width+'%';
			if(width > min)
			{
				width = width - 1;
				setTimeout('reset()', 10);
			} else {
				b = 0;
			}
		}
		

		

	}
	
	function stopBubble(){
			if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();
	}
	
	var max_h = 340;
	var min_h = 130;
	var h = 130;
	var t;
	
	function collapse (id) {
        div = document.getElementById(id);
		div.style.height = h+'px';
		
		if(id == "1") {
			div2 = document.getElementById('2');
		
			if(div2 != null)
			{
				t = parseInt(div2.style.top);
				
			}
		}
		
		var col = function()
		{
			collapse(id);
		}
		
		if(h > min_h)
		{
			h = h - 10;
			t = t - 10;
			
			if(id == "1" && div2 != null)
				div2.style.top = t+"px";
				
			setTimeout(col, 10);
			
		}
		
        btn = div.getElementsByTagName('a')[0];
        btn.href = "javascript:expand_tab('"+id+"');";
        btn.innerHTML = 'Expand';
    }

    function expand_tab (id) {
	
        div = document.getElementById(id);
		div.style.height = h+'px';
		
		/*if(div != null)
			alert('This is what an alert message looks like.');	*/
			
		

		
		if(id == "1"){
			div2 = document.getElementById('2');
					
			if(div2 != null){
				t = parseInt(div2.style.top);
			}
			
		}
		
		var exp = function()
		{
			expand_tab(id);
		}
		
		if(h < max_h)
		{
			h = h + 10;
			
			if(id == "1" && div2 != null){
				t = t + 10;
				div2.style.top = t+"px";
				//alert('This is what an alert message looks like: '+t);
			}
			setTimeout(exp, 10);
		}
		
        btn = div.getElementsByTagName('a')[0];
        btn.href = "javascript:collapse('"+id+"');";
        btn.innerHTML = 'Collapse';
    }