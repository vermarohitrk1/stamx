$(document).ready(function(){
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

   
	if ($( window ).height()<700 && !isMobile){
		newheight=$( window ).height()-100;
		
		ratio=dH/dW;
		newwidth=parseInt(newheight/ratio);

		//$('#photo').css('height',newheight+'px');
		//$('#photo').attr('height',newheight);
		//$('body').css('max-width',newwidth+30);
		
	}
	if(!isMobile){
	//var zoomB = `${1 / window.devicePixelRatio * 100}%`;
	//	document.querySelector('body').style.zoom = zoomB;
	}
	$('input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea').focus(function (element, i) {
		if (($(this).value !== undefined && $(this).value.length > 0) || $(this).attr('placeholder') !== null) {
			$(this).siblings('label').addClass('active');
		}
		else {
			$(this).siblings('label').removeClass('active');
		}
	})
	.blur(function (element, i) {
		if (($(this).value !== undefined && $(this).value.length > 0) || $(this).attr('placeholder') !== null) {
			//$(this).siblings('label').removeClass('active');
		}
		else {
			$(this).siblings('label').removeClass('active');
		}
	});


	$('#sendEmail').on('click', function(e) {
		if ($('#email').val() == "") {
		  e.preventDefault();
		  e.stopPropagation();
		}
		else{
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "https://"+site+"/console/app.php",
				data: $('#emailForm').serialize(),
				success: function(response)
				{
					var jsonData = JSON.parse(response);
					$('#modalEmailForm').modal('hide');
				},
				error: function() {
					alert('Error');
				}
			});
		}
		return false;
	});
	
	$('[data-action="track"]').on('click', function(e) {
		
			$.ajax({
				type: "POST",
				url: "https://"+site+"/console/app.php",
				data: { eventAction: "track",type: $(this).attr("data-type"),url: $('#event-url').val() },
				success: function(response)
				{
					var jsonData = JSON.parse(response);
					
				},
				error: function() {
					alert('Error');
				}
			});
		})
});
 
function styleButtons(val,color) { 
	$(".btn-action").removeClass (function (index, className) {
		return (className.match (/(^|\s)button-cust\S+/g) || []).join(' ');
	});
	
	
	
	$(".btn-action").addClass(val);
	$(".btn-action").removeClass('btn-secondary');
	$(".btn-action").removeClass('btn-lg');
	
	
	if (val=='button-cust-nice') {
		
		var tColor=color;
		tColor="1px solid "+tColor;
		$(".btn-action").css('--border',tColor)	
	}
	
	if (val=='button-cust-3d') {
		
		if ($('#button-cust-3d').contents().find('#buttons-bottom').find('button').css('border-bottom') != '') {
			var tColor=rgb2hex(color);
			tColor=LightenDarkenColor(tColor,-10)
			$(".btn-action").css('border-color',tColor)
		} 
	}
	
	if (val=='button-cust-flat') {
		
		var tColor=rgb2hex(color);
		tColor=LightenDarkenColor(tColor,10)
		tColor="0px 4px 0px "+tColor+"!important";
		$(".btn-action").css('box-shadow',tColor)
	}
	if (val=='button-cust-press') {		
		var tColor=rgb2hex(color);
		tBorder=LightenDarkenColor(tColor,-90)
		$(".btn-action").css('border-color',tBorder)
		
		tBG=LightenDarkenColor(tColor,-50)
		$(".btn-action").css('--background',tBG);
						
		tShadow=LightenDarkenColor(tColor,-90)
		tShadow="0 0 0 1px "+tBorder;
		$(".btn-action").css('--shadow',tShadow)
	}
	
	if (val=='button-cust-outline') {
		
		var tColor=color
		tBorder=tColor;
		$(".btn-action").css('border-color',tBorder)
		
		tShadow="4px 4px 0px 0px "+tColor;
		$(".btn-action").css('--shadow',tShadow)
	}
	if (val=='button-cust-outline2') {
		
		var tColor=color
		tBorder=tColor;
		$(".btn-action").css('border-color',tBorder)
		
		
	}
	if (val=='button-cust-3d2') {
		
		var tColor=color;
		tBorder=LightenDarkenColor(tColor,-90)
		tShadow=LightenDarkenColor(tColor,-50)
		
		tShadow="0 0 0 1px "+tBorder+" inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 "+tShadow+", 0 8px 0 1px rgba(0,0,0,0.4), 0 8px 8px 1px rgba(0,0,0,0.5)";
		$(":root").css("--shadow", tShadow);
		$(".btn-action").css('--shadow',tShadow)
	}
	if (val=='button-cust-tear') {
		
		var tColor=color;
		if (tColor.length>7){	
			 tColor=rgb2hex(tColor);
		}
		tColor2=LightenDarkenColor(tColor,-90)

		tBackground="linear-gradient(45deg, "+tColor2+" 40%, "+tColor+" 100%)";
		$(".btn-action").css('--background',tBackground)
	}
	if (val=='button-cust-real') {
		
		var tColor=rgb2hex(color);
		tColor2=LightenDarkenColor(tColor,-90)

		tBackground="linear-gradient(45deg, "+tColor2+" 40%, "+tColor+" 100%)";
		$(".btn-action").attr('data-content',$(".btn-action").attr("data-content"))
	}
	if (val=='button-cust-hand-thick') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	if (val=='button-cust-hand-thin') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	if (val=='button-cust-hand-dotted') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	if (val=='button-cust-hand-dashed') {
		
		var tColor=color;
		tBorder=tColor
		$(".btn-action").css('border-color',tBorder)
	}
	
	
};

function LightenDarkenColor(col, amt) {
  
    var usePound = false;
  
    if (col[0] == "#") {
        col = col.slice(1);
        usePound = true;
    }
 
    var num = parseInt(col,16);
 
    var r = (num >> 16) + amt;
 
    if (r > 255) r = 255;
    else if  (r < 0) r = 0;
 
    var b = ((num >> 8) & 0x00FF) + amt;
 
    if (b > 255) b = 255;
    else if  (b < 0) b = 0;
 
    var g = (num & 0x0000FF) + amt;
 
    if (g > 255) g = 255;
    else if (g < 0) g = 0;
 
    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
  
}

function rgb2hex(rgb) {
    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;

    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}