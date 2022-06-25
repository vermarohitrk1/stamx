var zoom=0;
var stripePrice=1500
const mobileBreakpoint = window.matchMedia("(max-width: 991px )");
var tWidth=100
var editorInstance
var libraryData=""
var splideCount=0
var curDim="square";
var libLoaded=0;
var stickersInEditor=0;
var Neditor1
var Neditor2
function buildLibrary(dimensions,skip){
	if (!skip){
		buildLibraryHTML(libraryData.stickers,'/console/images/library/stickers/','stickers')
		
	}
	buildLibraryHTML(libraryData.frames[dimensions],'/console/images/library/frames/'+dimensions+'/','frames')
	buildLibraryHTML(libraryData.screens[dimensions],'/console/images/library/screens/'+dimensions+'/','screens')
	buildLibraryHTML(libraryData.backgrounds[dimensions],'/console/images/library/backgrounds/'+dimensions,'backgrounds')
	
	buildSliders()
}
function buildLibraryHTML(data,path,type){
//	path=path.replace("/console/images/library/","https://d1drf7or05gb91.cloudfront.net/")
	
	if(type!="backgrounds"){
		var html=""
		for (const folder in data) {
			html += frmtFolder(folder);
			splideCount=0;
			var files=data[folder];
			for (const file in files) {	
				html += frmtFile(path+folder,file,type);
				splideCount++;
			}
			html += '</ul></div></div>';
			html = html.replace('data-num=""', 'data-num="'+splideCount+'"');
			$('#'+type+'-holder').html(html); 
		}
	}
	else{
		html='<div class=""><div class="" data-num=""><ul class="background-list" style="padding-left:5px;width:325px;display:flex;flex-wrap: wrap;">';
		splideCount=0;
		for (const file in data) {	
			html += frmtFile2(path,file,type);
			splideCount++;
		}
		html += '</ul></div></div>';
		html = html.replace('data-num=""', 'data-num="'+splideCount+'"');
		$('#backgrounds-holder').html(html); 
		 observer.observe(); 
	}
	
		
} 

function frmtFolder(Entity){
 return '<span class="lib-label">'+Entity+'</span><div class="splide"><div class="splide__track" data-num=""><ul class="splide__list">';
}

function frmtFile(dEntry, fEntry, type){
	return '<li class="splide__slide"><div class="lib-item splide__slide__container" data-src="' + dEntry + '/' + fEntry + '" data-type="'+type+'"><img  data-splide-lazy="' + dEntry + '/' + fEntry + '" data-src="' + dEntry + '/' + fEntry + '" data-bgsrc="' + dEntry + '/' + fEntry + '"></div>';
}
function frmtFile2(dEntry, fEntry, type){ 
	return '<li class="lib2" style="height: 148px;position: relative;margin-bottom: 8px;overflow: hidden;border-radius: 4px;list-style: none;position: relative;margin-bottom: 8px;overflow: hidden;border-radius: 4px; margin-right: 7px;"><div class="lib-item lozad"><img height=148 class="lozad background-item" data-needsedit="yes" data-type="'+type+'" data-src="' + dEntry + '/' + fEntry + '" ></div>';
}
var lastSplideClicked=""
function buildSliders(){
	var params={
		perPage    : 3,
		arrows:true,
		fixedWidth : 80,
		height     : 80,
		width		: 300,		
		gap        : 16,
		cover      : true,
		pagination: false,
		lazyLoad: 'nearby',
		padding: {
			left : 20
		}	
	}
	var foo = [] ;
	var splideClicked=""
	$('.splide').each(function(i,obj) {
		foo[ "slider" + i  ] = [ new Splide( obj, params ).on( 'mounted moved', function(k,s) {
			splideLength=$("#"+splideClicked).find(".splide__track").data('num');
			
			if ( k >1 ) {
				$("#"+splideClicked).find(".splide__arrow--prev").find("svg").css('opacity','1')
			}
			else{
				$("#"+splideClicked).find(".splide__arrow--prev").find("svg").css('opacity','.65')
			}
			if ( k+3 >= splideLength  ) {
				$("#"+splideClicked).find(".splide__arrow--next").find("svg").css('opacity','.65')
			}
			else{
				$("#"+splideClicked).find(".splide__arrow--next").find("svg").css('opacity','1')
			}
			
		}).on('click',function(e){
			if (e.slide != lastSplideClicked){
				lastSplideClicked=e.slide
				
				var src=$('#'+e.slide.id).find('.lib-item').data('src');
				
				var type=$('#'+e.slide.id).find('.lib-item').data('type');
				var name=$('#'+e.slide.id).find('.lib-item').data('name');
				
				
				if(type=="stickers"){
					var filename = src.replace(/^.*[\\\/]/, '');
					
					$('a[href="#standard"]').click();
					
					$('.process .nav-tabs a').removeClass('active');
					$('.process .tab-content .tab-pane').removeClass('active');
					$('.process .nav-tabs button').removeClass('btn-primary');
					$('.process .nav-tabs button').addClass('btn-default');
					$('a[href="#standard"]').find('button').removeClass('btn-default');
					$('a[href="#standard"]').find('button').addClass('btn-primary');
					//$('a[href="#standard"]').closest('li').addClass('active');
					$('a[href="#standard"]').addClass('active');
					$('#standard').addClass('active');
					$('.nav nav-tabs a[href="#standard"]').tab('show');

		
		
					var isVisible = $('#collapse-stickers').is( ":visible" );
					if(!isVisible){
						$(".collapse").collapse("hide");
						$("#accordian-"+type).click();
					}
					
					type="dz-"+type;
					if (stickersInEditor==0){
						previewThumbailFromUrl({
						  selector: type,
						  fileName: filename,
						  imageURL: src
						});
					}
					else{
						pixie.openFile(src,'png');
					}
					
				}
				else if(type=="frames"){
					$(".frames-menu").show();
					$(".backgrounds-menu").hide();
					$(".screens-menu li").data('src',src)	
					$(".screens-menu").finish().toggle(100).
					css({
						top: zoom*(event.screenY+$('.modal').scrollTop())-150 + "px",
						left: zoom*(event.screenX)+10 + "px"
					});	
				}
				else if(type=="screens"){
					$(".frames-menu").hide();
					$(".backgrounds-menu").hide();
					$(".screens-menu li").data('src',src)
					$(".screens-menu").finish().toggle(100).
					css({
						top: zoom*(event.screenY+$('.modal').scrollTop())-150 + "px",
						left: zoom*(event.screenX)+10 + "px"
					});	
				}
				else if(type=="cat"){
					$('.background-list').html("");
					if (src=="curated"){
						$('.js-search-input').val('')
						var dimensions=$(':radio[name="photoType"]:checked').val()
						buildLibraryHTML(libraryData.backgrounds[dimensions],'/console/images/library/backgrounds/'+dimensions,'backgrounds')
						buildSliders();
						$(".js-next").hide();
					}
					else{
						$('.js-search-input').val(name)
						searchQuery=name;
						$('.background-list').html("");
						currentPage=1
						fetchResults(src);
						
					}
				}
				else if(type=="cat2"){
					$('.stickers-list').html("");
					$('#stickers-holder').html("");
					if (src=="curated"){
						$('.stickers-list').html(""); 
						$('.js-search-inputStickers').val('')
						buildLibraryHTML(libraryData.stickers,'/console/images/library/stickers/','stickers')
						buildSliders();
						$(".js-nextStickers").hide();
					}
					else{
						$('.js-search-inputStickers').val(name)
						searchQueryStickers=name;
						$('#stickers-holder').html('<div class=""><div class="" data-num=""><ul class="stickers-list" style="padding-left:2px;width:325px;display:flex;flex-wrap: wrap;"></ul></div></div>');
						currentPageStickers=1
						fetchResultsStickers(src);
					}
				}
				else if(type=="cat3"){
					$('.gifs-list').html("");
					$('#gifs-holder').html("");
					if (src=="curated"){
						$('.gifs-list').html(""); 
						$('.js-search-inputGifs').val('')
						//buildLibraryHTML(libraryData.stickers,'/console/images/library/stickers/','stickers')
						//buildSliders();
						$(".js-nextGifs").hide();
					}
					else{
						$('.js-search-inputGifs').val(name)
						searchQueryGifs=name;
						$('#gifs-holder').html('<div class=""><div class="" data-num=""><ul class="gif-list" style="padding-left:2px;width:325px;display:flex;flex-wrap: wrap;"></ul></div></div>');
						currentPageGifs=1
						fetchResultsGifs(src);
					}
				}
			}
			
		}).mount()]
		if ( foo[ "slider"+i][0].length<=3  ) {
			$(this).find(".splide__arrow--next").find("svg").css('opacity','.65')
		}
			
	})	

	$('.splide__arrow').on('click',function(){
		splideClicked=$(this).parent().parent().attr("id");
		
	})
}



$("#gifSettingsButton").click(function(){
	$("#gifSettingsMenu").toggle(100)
})
$("#boomerangSettingsButton").click(function(){
	$("#boomerangSettingsMenu").toggle(100)
})

$(document).click(function(event) { 
  var $target = $(event.target);
  if(!$target.closest('#gifSettingsButton').length  &&
  $('#gifSettingsButton').is(":visible")) {
   setTimeout(function(){$("#gifSettingsMenu").finish().hide(100)},200)
  }  
  if(!$target.closest('#boomerangSettingsButton').length  &&
  $('#boomerangSettingsButton').is(":visible")) {
   setTimeout(function(){$("#boomerangSettingsMenu").finish().hide(100)},200)
  }  
});

$(".screens-menu li").click(function(){
	var src=$(this).data('src');
	var bgsrc=$(this).data('bgsrc');
	var filename = src.replace(/^.*[\\\/]/, '')
	var type=$(this).attr("data-action");
	var needsEdit=$(this).attr("data-needsedit");
	var stateUID=""
	$.ajax({
			type: "POST",
			url: "app.php",
			data: { eventAction: "addState", uid:$("#accountUID").val(), file:src},
			success: function(response){
				var jsonData = JSON.parse(response);
				stateUID=jsonData.uid;
				
				switch(type) {
					case "frames": 
						if(plan=="Virtual Booth Solo"){
							buildDropzoneSingle("frame",src,needsEdit,stateUID)
						}else{
							type="dz-"+type;
							previewThumbailFromUrl({
							  selector: type,
							  fileName: filename,
							  imageURL: src,
							  needsEdit: needsEdit,
							  stateUID : stateUID
							});
						}
						break;
					case "backgrounds": 
						 
						type="dz-"+type;
						previewThumbailFromUrl({
						  selector: type,
						  fileName: filename,
						  imageURL: src,
						  stateUID : stateUID
						});
						var link=$(this).data('link');
						$.ajax({
							type: "POST",
							url: "app.php",
							data: { eventAction: "registerPhoto", url:link},
							success: function(response){
								var jsonData = JSON.parse(response);
							}
						})
						break;
					case "pagebackground": 
						
						buildDropzoneSingle("bgImage",bgsrc,0,stateUID)
						$('#bgImage').val(bgsrc);
						$('#previewFrame').contents().find('body').css('background','url("'+bgsrc+'")');
						$('#previewFrame').contents().find('body').css('background-size','cover!important');
						$('#previewFrame').contents().find('body').css('background-position','50% 50%!important');
						var isVisible = $('#collapseFourI').is( ":visible" );
						if(!isVisible){
							$("#accordian-background").click();
						}
						
						break;
					case "start": 
						buildDropzoneSingle("splash",src,0,stateUID)
						$('#startImage').val(src);
						$('#previewFrame').contents().find('#splashImg').attr("src",src);
						$('#previewFrame').contents().find('#splashImg').show();
						$('#previewFrame').contents().find('#splash').show();
						$('#previewFrame').contents().find('#thanks').hide();
						break;
					case "thanks": 
						buildDropzoneSingle("thanks",src,0,stateUID)
						$('#thanksImage').val(src);
						$('#previewFrame').contents().find('#thanksImg').attr("src",src); 
						$('#previewFrame').contents().find('#thanksImg').show();
						$('#previewFrame').contents().find('#splash').hide();
						$('#previewFrame').contents().find('#thanks').show();
						break;
					case "both": 
						buildDropzoneSingle("splash",src,0,stateUID)
						$('#startImage').val(src);
						$('#previewFrame').contents().find('#splashImg').attr("src",src);
						$('#previewFrame').contents().find('#splashImg').show();
						$('#previewFrame').contents().find('#thanksImg').show();
						
						buildDropzoneSingle("thanks",src,0,stateUID)
						$('#thanksImage').val(src);
						$('#previewFrame').contents().find('#thanksImg').attr("src",src); 
						$('#previewFrame').contents().find('#thanksImg').show();
						$('#previewFrame').contents().find('#splashImg').show();
						
						break;
				}
	if(type=="dz-frames"){
		$('a[href="#standard"]').click();
		
		$('.process .nav-tabs a').removeClass('active');
		$('.process .tab-content .tab-pane').removeClass('active');
		$('.process .nav-tabs button').removeClass('btn-primary');
		$('.process .nav-tabs button').addClass('btn-default');
		$('a[href="#standard"]').find('button').removeClass('btn-default');
		$('a[href="#standard"]').find('button').addClass('btn-primary');
		//$('a[href="#standard"]').closest('li').addClass('active');
		$('a[href="#standard"]').addClass('active');
		$('#standard').addClass('active');
		$('.nav nav-tabs a[href="#standard"]').tab('show');
		
		var isVisible = $('#collapse-frames').is( ":visible" );
		if(!isVisible){
			$("#accordian-frames").click();
		}
	}
	else if(type=="dz-backgrounds"){
		$('a[href="#standard"]').click();
		
		$('.process .nav-tabs a').removeClass('active');
		$('.process .tab-content .tab-pane').removeClass('active');
		$('.process .nav-tabs button').removeClass('btn-primary');
		$('.process .nav-tabs button').addClass('btn-default');
		$('a[href="#standard"]').find('button').removeClass('btn-default');
		$('a[href="#standard"]').find('button').addClass('btn-primary');
		//$('a[href="#standard"]').closest('li').addClass('active');
		$('a[href="#standard"]').addClass('active');
		$('#standard').addClass('active');
		$('.nav nav-tabs a[href="#standard"]').tab('show');
		
		var isVisible = $('#collapse-backgrounds').is( ":visible" );
		if(!isVisible){
			$("#accordian-backgrounds").click();
		}
	}
	
	else if(type!="frames"){
		menuStylesClick(type)
		
	}
	
    $(".screens-menu").hide(100);
			}
	  })
    
  });
  
$('body').on("click", ".background-item", function (e) {
	var src=$(this).data('src');
	var bgsrc=$(this).data('bgsrc');
	var link=$(this).attr("data-link");
	var needsEdit=$(this).attr("data-needsedit");
			
	$(".frames-menu").show();
	$(".backgrounds-menu").show();
	$(".screens-menu li").data('src',src);
	$(".screens-menu li").data('bgsrc',bgsrc);
	$(".screens-menu li").data('link',link);
	if(needsEdit=="yes"){
		$(".frames-menu").data('needsedit',"yes");
	}
//console.log(event.screenX)
	$(".screens-menu").finish().toggle(100).
	css({
	top: parseInt(zoom*(event.screenY)+$('.modal').scrollTop()-150) + "px",
	left: parseInt(zoom*(event.clientX)+10) + "px" 
	});	

	//var src=$(this).data('src');
//	var filename = src.replace(/^.*[\\\/]/, '')
//	var type=$(this).data('type');
//	type="dz-"+type;
//	previewThumbailFromUrl({
//	  selector: type,
//	  fileName: filename,
//	  imageURL: src
//});
})
 

$('body').on("click", ".gif-item", function (e) {
	var src=$(this).data('src');
	var link=$(this).attr("data-link");
	var needsEdit=0;
			
	//$(".frames-menu").hide();
	$(".backgrounds-menu").hide();
	$(".frames-menu").hide();
	$(".screens-menu li").data('src',src);
	$(".screens-menu li").data('link',link);
	if(needsEdit=="yes"){
		$(".frames-menu").data('needsedit',"yes");
	}
//console.log(event.screenX)
	$(".screens-menu").finish().toggle(100).
	css({
	top: parseInt(zoom*(event.screenY)+$('.modal').scrollTop()-150) + "px",
	left: parseInt(zoom*(event.clientX)+10) + "px" 
	});	

})
$('body').on("click", ".stickers-item", function (e) {
	var type="stickers";
	var src=$(this).data('src');
	var link=$(this).attr("data-link");
	var filename = src.replace(/^.*[\\\/]/, '');
	var isVisible = $('#collapse-stickers').is( ":visible" );
	if(!isVisible){
		$(".collapse").collapse("hide");
		$("#accordian-"+type).click();
	}
	
	type="dz-"+type;
	
	if (stickersInEditor==0){
		previewThumbailFromUrl({
		  selector: type,
		  fileName: filename,
		  imageURL: src
		});
	}
	else{
		toDataURL(src, function(base64) {
		  pixie.openFile(base64,'png');
		})
		

		
	}
	 
			
	

})
$("#stickers-btn").on('click', function (e) {
	var isVisible = $('#collapse-stickers').is( ":visible" );
	if(!isVisible){
		//$(".collapse").collapse("hide");
		//$("#accordian-stickers").click();
	}
	$('.frames-menu').attr('data-needsedit','no');
})
$("#frames-btn").on('click', function (e) {
	var isVisible = $('#collapse-frames').is( ":visible" );
	if(!isVisible){
		//$(".collapse").collapse("hide");
		//$("#accordian-frames").click();
	}
	$('.frames-menu').attr('data-needsedit','no');
})
$("#backgrounds-btn").on('click', function (e) {
	var isVisible = $('#collapse-backgrounds').is( ":visible" );
	if(!isVisible){
		//$(".collapse").collapse("hide");
		//setTimeout(function(){ $("#accordian-backgrounds").click();}, 500);
	}
	$('.frames-menu').attr('data-needsedit','yes');
	
	//var isVisible = $('#collapse-frames').is( ":visible" );
	//if(!isVisible){
		
	//	setTimeout(function(){ $("#accordian-frames").click();}, 500);
//}
	//$('.frames-menu').attr('data-needsedit','yes');
})

function menuStylesClick(type){
	$('a[href="#styles"]').click();
		
	$('.process .nav-tabs a').removeClass('active');
	$('.process .tab-content .tab-pane').removeClass('active');
	$('.process .nav-tabs button').removeClass('btn-primary');
	$('.process .nav-tabs button').addClass('btn-default');
	$('a[href="#styles"]').find('button').removeClass('btn-default');
	$('a[href="#styles"]').find('button').addClass('btn-primary');
	$('a[href="#styles"]').addClass('active');
	$('#styles').addClass('active');
	$('.nav nav-tabs a[href="#styles"]').tab('show');
	
	var isVisible = $('#collapse-'+type).is( ":visible" );
	if(!isVisible){
		$('#accordian-'+type).click();
	}
}
$(document).bind("mousedown", function (e) {
    
    if (!$(e.target).parents(".screens-menu").length > 0) {
        $(".screens-menu").hide(100);
    }
});  

function buildDropzoneSingle(type,img,needsEdit,stateUID){
	var imgC=img;
	if(img!=""){
		if(img.indexOf('upload/')!=-1){
			img=removeVersion(img);
			var substr = '/upload';
			var attachment = '/f_auto,fl_lossy,q_auto,w_150';
			var imgC = img.replace(substr, substr+attachment);
			
		}
	}
	if(img.indexOf('.gif')==-1){
		var htmlPreview = '<img width="150" src="' + imgC + '" /><div class="dz-single-edit"><a class="dz-single-edit-btn" id="single-edit-'+type+'" href="#" data-path="'+img+'" data-uid="'+stateUID+'"><i class="fa fa-edit"></i></a></div> <div class="dz-single-download"><a class="dz-single-download-btn" href="'+img+'"  target="_new" download><i class="fa fa-download"></i></a></div>'
	} 
	else{
		var htmlPreview = '<img width="150" src="' + imgC + '" />'
		//var htmlPreview = '<img width="150" src="' + imgC + '" /><div class="dz-single-edit"><a class="dz-single-edit-btn-gif" id="single-edit-'+type+'" href="#" data-path="'+img+'" data-uid="'+stateUID+'"><i class="fa fa-edit"></i></a></div> <div class="dz-single-download" ><a class="dz-single-download-btn" style="right:45	%!important;" href="'+img+'"  target="_new" download><i class="fa fa-download"></i></a></div>'
	}
	var wrapperZone = $('.dropzone-wrapper.'+type);
	var previewZone = $('.preview-zone.'+type);
	var removeZone = $('.box-header.'+type);

	var boxZone = $('.box-body.'+type);

	$('.dropzone-wrapper.'+type).css('display','none');
	wrapperZone.removeClass('dragover');
	previewZone.removeClass('hidden');
	removeZone.css('display','block');
	boxZone.empty();
	boxZone.append(htmlPreview);
	
	if(needsEdit=="yes"){
		$(".cropper").show();
		$("#single-edit-"+type).click();	
	}
}
let observer;
$(document).ready(function(){
	
		$(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
		return false;
    });
    
    if ($(".filter-button").removeClass("active")) {
		$(this).removeClass("active");
	}else{
		$(this).addClass("active");
	}

	var inOneYear = new Date(new Date().getTime() + 525600 * 60 * 1000);
	observer = lozad();
	observer.observe();
	isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	isDuplicate=0;
	var tourZoom=window.devicePixelRatio;
	if(!isMobile){
		var zoomB = `${1 / window.devicePixelRatio * 100}%`;
		if (navigator.appVersion.indexOf("Mac") == -1) {
			//document.querySelector('body').style.zoom = zoomB;
			//zoom=1
			//tourZoom=window.devicePixelRatio;
		}
		else{
			var zoomB = `${1.5 / window.devicePixelRatio * 100}%`;
			//document.querySelector('body').style.zoom = zoomB;
			//zoom=window.devicePixelRatio;
			//tourZoom=window.devicePixelRatio/1.5;
		}

		//$('body').chardinJs();
	if($("#no-events").css('display')=="block"){
		//startTour();
	}
		function startTour(){
			var visited = jQuery.cookie('visited');
			if (visited != 'yes') {
				guiders.createGuider({
					buttons: [{name: "Next"}],
					  description: '<div class="pt-4">Let us guide you through a quick overview of how things work.<br>When we\'re done, you\'ll have created your first event.</div><div class="guide-callout">&#11088 You\'ve got full access! Explore all of the features of Virtual Booth Complete while in trial mode.</div>',
					  id: "0",
					  next: "1",	 
					  overlay: true,
					  title: "Welcome to Virtual Booth",
					  xButton:true,
					  width: 550,
					  zoom:tourZoom,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
				}).show();
				
				 

				guiders.createGuider({
					 attachTo: "#dash-new",
					buttons:  [{name: "Next", onclick: function(){guiders.next(); $('#newEvent-btn').click()}}],
					  description: "Start by clicking here to start a new event.",
					  id: "1",
					   next: "2",
					  overlay: true,
					   position: 3,
					  title: "Create an Event",
					  xButton:true,
					  width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
				}) 
				guiders.createGuider({
					attachTo: "#dash-view",
					position: 9,
					offset: {
					  top: 80,
					  left: -450
					},
					buttons:  [{name: "Next", onclick: function(){guiders.hideAll(); guiders.destroy(); jQuery.cookie('showEditTour', 'yes', {expires: inOneYear});$('[data-event="valentines"]').click()}}],
					description: 'Start with a blank template or select a pre-made event from the event library.', 
					id: "2",
					   
					overlay: true,
					xButton:true,
					title: "Select an Event",
					width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
				})

				
				jQuery.cookie('visited', 'yes', {
					 expires: inOneYear 
				});
				jQuery.cookie('showLibraryTour', 'yes', {expires: inOneYear});


			}
		}
		function continueTourEdit(){
			guiders.createGuider({
				buttons: [{name: "Next"}], 
				  description: '<div class="pt-4">Every event contains 3 basic items:</div><div class="row"><div class="col-sm-12 col-lg-4"><div class="u-text-center pt-4"><img class="u-mb-small" src="images/intro3.png" width=100><h4 class="u-h6 u-text-bold u-mb-small">Frames</h4></div></div><div class="col-sm-12 col-lg-4"><div class="pt-4 u-text-center"><img class="u-mb-small" src="images/intro1.png" width=100><h4 class="u-h6 u-text-bold u-mb-small">Start Screen</h4></div></div><div class="col-sm-12 col-lg-4"><div class="u-text-center pt-4"><img class="u-mb-small" src="images/intro2.png" width=100><h4 class="u-h6 u-text-bold u-mb-small">Thanks Screen</h4></div></div></div>',
				  id: "3",
				  next: "4",	 
				  overlay: true,
				  title: "The Basics",
				  xButton:true,
				  width: 550,
				   zoom:tourZoom,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			}).show();
			guiders.createGuider({
				attachTo: "#dash-view",
				position: 3,
				offset: {
				  top: 150,
				  left: 150
				},
				buttons:  [{name: "Next", onclick: function(){menuStylesClick('start');guiders.next(); }}],
				description: "Frames are transparent images that are placed on top of the photo. You can select frames from the library or upload your own.<div class='guide-callout'>Frames should be 1600x1600 px @ 72DPI or 1200x1800 px @72DPI with a transparent area for the photo to show through.</div>",
				id: "4",
				next: "5",
				overlay: true,
				xButton:true,
				title: "Frames",
				width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			})
			
			guiders.createGuider({
				attachTo: "#dash-new",
				position: 9,
				offset: {
				  top: -20,
				  left: -100
				},
				buttons:  [{name: "Next", onclick: function(){$('.modal').animate({scrollTop : '400px'}, 0);$('#accordian-thanks').click();$('#preview-thanks').click();guiders.next(); }}],
				description: "The Start screen is the first thing the user sees when they open your event.<div class='guide-callout'>The Start Screen should be 600x600 px @ 72DPI or 400x600 px @72DPI. It can be solid or transparent.</div>",
				id: "5",
				next: "7",
				overlay: true,
				xButton:true,
				title: "Start Screen",
				width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			})
			guiders.createGuider({
				attachTo: "#dash-new",
				position: 3,
				offset: {
				  top: -20,
				  left: 375
				},
				buttons:  [{name: "Next", onclick: function(){$('.modal').animate({scrollTop : '400px'}, 0);$('#accordian-thanks').click();$('#preview-thanks').click();guiders.next(); }}],
				description: "In this event, the Start button is hidden and the extra text, 'Touch to Start' is used. You can edit the text content and style here.",
				id: "6",
				next: "7",
				overlay: true,
				xButton:true,
				title: "Edit Start Screen Text",
				width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			})
			guiders.createGuider({
				attachTo: "#dash-new",
				position: 9,
				offset: {
				  top: 20,
				  left: -100
				},
				buttons:  [{name: "Next", onclick: function(){$('#newEventSave').click();$('#dash-view').click();guiders.next(); }}],
				description: "The Thanks screen is shown after the user has completed the photo session.",
				id: "7",
				next: "8",
				overlay: true,
				xButton:true,
				title: "Edit Thanks Screen ",
				width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			})
			guiders.createGuider({
				
				buttons: [{name: "Next"}], 
				  description: '<div class="pt-4">You\'ve created your first event. Now let\'s show you how to launch your new event.</div><div class="u-text-center pt-4"><img class="u-mb-small" src="images/intro0.png" width=100></div>',
				  id: "8",
				  next: "9",	 
				  overlay: true,
				  title: "Congratulations!",
				  xButton:true,
				  width: 550,
				   zoom:tourZoom, 
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			});
			guiders.createGuider({
				attachTo: ".activate",
				position: 6,
				offset: {
				  top: 0,
				  left: 0
				},
				buttons: [{name: "Next", onclick: function(){guiders.hideAll(); guiders.destroy();jQuery.cookie('showLaunchTour', 'yes', {expires: inOneYear}); $('.activate').click();$('.activate').click(); }}],
				  description: 'New events are paused when they are first created, so click on the Start icon to activate it.</div>',
				  id: "9",
					 
				  overlay: true,
				  title: "Actions",
				  xButton:true,
				  width: 450,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			});
		}
		function continueTourLaunch(){
			 
			$('.swal2-confirm').click();
			$("body").on('chardinJs:start', function(){
					$("#chardin-close").show();
					$("#chardin-close-btn").on('click',function(){$('body').chardinJs('stop')})
			})
			$("body").on('chardinJs:stop', function(){
				$("#chardin-close").hide();
			  $("body").removeClass("chardinjs-no-fixed");
			  $("#startBooth .close").click();
			   
				guiders.createGuider({
					attachTo: "#tour-tab",
					position: 3,
					offset: {
					  top: 0,
					  left: 0
					},
					buttons: [{name: "Next", onclick: function(){guiders.hideAll(); guiders.destroy();}}],
					  description: '<div class="pt-4">That should be enough to get you started. You can replay this tour at any time.</div>',
					  id: "17",
					  overlay: true,
					  title: "Have Fun!",
					  xButton:true,
					  width: 375,
						  onClose: function(){guiders.hideAll(); guiders.destroy();}
				}).show();
			
			})
			guiders.createGuider({
				attachTo: ".start",
				position: 6,
				offset: {
				  top: 0,
				  left: 0
				},
			buttons: [{name: "Next", onclick: function(){$('.start')[0].click();guiders.hideAll(); guiders.destroy(); setTimeout(function(){ $('body').chardinJs('start');}, 1000); }}],
				  description: '<div class="pt-4">Now that the event has been activated, click here for the Launch options.</div>',
				  id: "10",
				 
				  overlay: true,
				  title: "Launch Event",
				  xButton:true,
				  width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			}).show();
			guiders.createGuider({
				attachTo: "#events",  
				position: 9,
				offset: {
				  top: 20,
				  left: 0
				},
				buttons: [{name: "Done", onclick: function(){guiders.hideAll(); guiders.destroy(); }}],
				  description: '<div class="pt-4">Click the Live URL button to view the event you just created.</div>',
				  id: "11", 
				  overlay: true,
				  title: "Launch Event",
				  xButton:true,
				  width: 375 ,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			}); 
		}
		function continueTourLibrary(){
			 
			guiders.createGuider({
				attachTo: ".head",
				position: 3,
				offset: {
				  top: 120,
				  left: 0
				},
				buttons: [{name: "Next", onclick: function(){$('.nav-link').eq(1).click();$('.sideslider').css('transform','translateY(160px)');guiders.next(); }}],
				  description: '<div class="pt-4">Choose from a selection of pre-made transparent frames</div><div class="guide-callout">Frames can also be used for Start and Thanks screens. Just add text.</div>',
				  id: "12",
				  next: "13",	 
				  overlay: true,
				  title: "Select a Frame",
				  xButton:true,
				  width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			}).show();
			guiders.createGuider({
				attachTo: ".head",
				position: 3,
				offset: {
				  top: 200,
				  left: 0
				},
				buttons: [{name: "Next", onclick: function(){$('.nav-link').eq(2).click();$('.sideslider').css('transform','translateY(240px)');guiders.next(); }}],
				  description: '<div class="pt-4">Photos can be used for Start and Thanks screens, as well as backgrounds for AI Background Removal.</div> <div class="guide-callout">Photos can also be used to create frames. Just make sure to edit them to add a transparent area for the user\'s photo to show through</div>',
				  id: "13",
				  next: "14",	 
				  overlay: true,
				  title: "Select a Photo",
				  xButton:true,
				  width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			});
			guiders.createGuider({
				attachTo: ".lib-container",
				position: 3,
				offset: {
				  top: 290,
				  left: 405
				},
				buttons: [{name: "Done", onclick: function(){guiders.hideAll(); guiders.destroy(); }}],
				  description: '<div class="pt-4">Users can decorate their photos with stickers. Click to add them to your event.</div>',
				  id: "14",	 
				  overlay: true,
				  title: "Add Stickers",
				  xButton:true,
				  width: 375,
					  onClose: function(){guiders.hideAll(); guiders.destroy();}
			});
			
		}
	}
	$('#disclaimerText').trumbowyg({
		btns: [
			['strong', 'em'],
			['justifyLeft', 'justifyCenter'],
			['link']
		]
	});
	
	//Interface
	$(".dash-nav-dropdown-toggle").click(function(){
        $(this).closest(".dash-nav-dropdown")
            .toggleClass("show")
            .find(".dash-nav-dropdown")
            .removeClass("show");
        $(this).parent()
            .siblings()
            .removeClass("show");
    });

    $(".menu-toggle").click(function(){
        if (mobileBreakpoint.matches) {
            $(".dash-nav").toggleClass("mobile-show");
        } else {
            $(".dash").toggleClass("dash-compact");
        }
    });
	
	$('#background-tab').on('click',function(){
		$.getScript("https://js.stripe.com/v3/", function(){
		   $.getScript("js/charge.js")
		 });
		
	})
	$('#tour-tab').on('click',function(){
		jQuery.removeCookie('visited');
		jQuery.removeCookie('showEditTour');
		jQuery.removeCookie('showLaunchTour');
		jQuery.removeCookie('showLibraryTour');
		$('#dashboard-tab').click();
		startTour();
		
	})
	$('.dash-nav-item').on('click',function(){
		if(isMobile){
			$('.dash-nav').hide();
		}
	})
	$('.menu-toggle').on('click',function(){
		if(isMobile){
			$('.dash-nav').toggle();
		}
	})
	$("[data-toggle='tooltip']").tooltip();
	$('[data-tooltip="tooltip"]').tooltip({trigger : 'hover'}); 
	
	$("[data-toggle='tooltip2']").tooltip();
	$('[data-tooltip="tooltip2"]').tooltip({trigger : 'click'}); 
	
	$('#dash-view').on('click', function(){
		  $('#events-tab').click()
	});
	$('#dash-new').on('click', function(){
		  $('#events-tab').click();
		  
		  setTimeout(function(){ $('#newEvent-btn').click();}, 100);
	});  
	$(".upgrade").on('click',function() {
		$('#pricing-tab').trigger('click');
	})
	$('body').on("click", ".dropdown-menu", function (e) {
		$(this).parent().is(".show") && e.stopPropagation();
	});
	$("#buymore").click(function() {
		$('#background-tab').trigger('click');
		$('[data-dismiss="modal"]').trigger('click');
	})
	$(".sub-basic").click(function() {
		$('#account-tab').trigger('click');
		
		setTimeout(function(){ window.Outseta.profile.setTab('planChange'); }, 2000);
	})
	$("#account-tab").click(function() {
		setTimeout(function(){ window.Outseta.profile.setTab('profile'); }, 2000);
	})
	
	//var elms = document.getElementsByClassName( 'splide' );
	var scrollbar = Scrollbar.init(document.getElementById('LeftSideNav'))
	/*scrollbar.infiniteScroll(function (status) {
		if ($("#LeftSideNav").css("visibility") === "visible") {
			if ($("#v-pills-stickers").hasClass("show")) {
				$('.js-nextStickers').click()
			}
			else if ($("#v-pills-backgrounds").css("visibility") === "visible") {
				$('.js-next').click()
			}
		}
	}, 100);
	*/
	//Dropbox + Google Link
	$('#btn-dropbox').on('click', function(){
		myWidth=600;
		myHeight=500;
		myURL="includes/DropPHP/dropbox.php?uid="+$("#accountUID").val();
		title="Dropbox";
		var left = (screen.width - myWidth) / 2;
		var top = (screen.height - myHeight) / 4;
		var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
	});  
		
	$('#btn-dropbox-unlink').on('click', function(){
		  $.ajax({
				type: "POST",
				url: "includes/DropPHP/dropbox.php",
				data: { eventAction: "unlink",uid:$("#accountUID").val()},
				success: function(response){
					$('#btn-dropbox-unlink').hide();
					$('#btn-dropbox').show();
					$('#dropboxAlert2').show();
					$('#dropboxAlert').hide();
				}
		  })
	});  
		
		
	$('#btn-google').on('click', function(){
		myWidth=600;
		myHeight=700;
		myURL="includes/Google/google.php?uid="+$("#accountUID").val();
		title="Google Drive";
		var left = (screen.width - myWidth) / 2;
		var top = (screen.height - myHeight) / 4;
		var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
	});  
		
	$('#btn-google-unlink').on('click', function(){
	  $.ajax({
			type: "POST",
			url: "includes/Google/google.php",
			data: { eventAction: "unlink",uid:$("#accountUID").val()},
			success: function(response){
				$('#btn-google-unlink').hide();
				$('#btn-google').show();
				$('#googleAlert2').show();
				$('#googleAlert').hide();
			}
	  })

	});  
	
	//Preview
	$(':checkbox[name="frameStartText"]').click (function () {
	  if($(this).prop( "checked")){
		$('#previewFrame').contents().find('.splashMessage').addClass('frameText');
	  }
	  else{
		$('#previewFrame').contents().find('.splashMessage').removeClass('frameText');
	  }
	})
	$(':checkbox[name="frameThanksText"]').click (function () {
	  if($(this).prop( "checked")){
		$('#previewFrame').contents().find('.thanksMessage').addClass('frameText');
	  }
	  else{
		$('#previewFrame').contents().find('.thanksMessage').removeClass('frameText');
	  }
	})
	$(".design-tab").on('click',function(){
		$(".preview").show();
		if($('.bgAnimation option:selected').val()=="balloons"){
			var iFrame = document.getElementById('previewFrame');
			setTimeout(function(){iFrame.contentWindow.postMessage("balloons");},1000)
		}
		if($('.bgAnimation option:selected').val()=="fog"){
			var iFrame = document.getElementById('previewFrame');
			setTimeout(function(){iFrame.contentWindow.postMessage("fog");},1000)
		}
	})
	$(".not-design-tab").on('click',function(){
		$(".preview").hide();
	})
	$('#closePreview').on('click',function(){
		 $(".preview").css({ 'display': 'none' });
	})
	$('#newEvent').on('hidden.bs.modal', function () {
		$(".preview").css({ 'display': 'none' });
	});
	$('#previewFrame').on('load',function(){
		let iframe = document.getElementById('previewFrame');
		let contents = $(iframe).contents();
	})
	$('#preview-start').on('click',function(){
		$('#preview-start').addClass('active');
		$('#preview-thanks').removeClass('active');
		$('#previewFrame').contents().find('#splash').show();
		$('#previewFrame').contents().find('#thanks').hide();
	})
	$('#preview-thanks').on('click',function(){
		$('#preview-thanks').addClass('active');
		$('#preview-start').removeClass('active');
		$('#previewFrame').contents().find('#splash').hide();
		$('#previewFrame').contents().find('#thanks').show();
	})
	function openpreview() {
		$(".preview").css({ 'display': 'block' });
		$("#openpreviewbtn").css({ 'display': 'none' });
	}
	$('#startButtonText').on('keyup',function(){
		$('#previewFrame').contents().find('.start-text').html($('#startButtonText').val());
	})
	$('#thanksButtonText').on('keyup',function(){
		$('#previewFrame').contents().find('.thanks-text').html($('#thanksButtonText').val());
	})
	$('#thanksAccordian').on('click',function(){
		$('#preview-thanks').addClass('active');
		$('#preview-start').removeClass('active');
		$('#previewFrame').contents().find('#splash').hide();
		$('#previewFrame').contents().find('#thanks').show();
	})
	$('#startAccordian').on('click',function(){
		$('#preview-start').addClass('active');
		$('#preview-thanks').removeClass('active');
		$('#previewFrame').contents().find('#splash').show();
		$('#previewFrame').contents().find('#thanks').hide();
	})
	
	$(':checkbox[name="showButtonIcon"]').click (function () {
	  if($(this).prop( "checked")){
		$('#previewFrame').contents().find('button').find('i').show();
	  }
	  else{
		$('#previewFrame').contents().find('button').find('i').hide();
	  }
	})
	
	$(':checkbox[name="hideStart"]').click (function () {
	  if($(this).prop( "checked")){
		
		$('#previewFrame').contents().find('#splash .buttons-top').hide();
		$('#previewFrame').contents().find('#splash .buttons-mid').hide();
		$('#previewFrame').contents().find('#splash .buttons-bottom').hide();
		
	  }
	  else{
		var pos=$("select[name='buttonPosition']").val();
		if(pos=="image-top"){
			$('#previewFrame').contents().find('#splash .buttons-top').show();
		}
		if(pos=="image-mid"){
			$('#previewFrame').contents().find('#splash .buttons-mid').show();
		}
		if(pos=="image-bottom"){
			$('#previewFrame').contents().find('#splash .buttons-mid').show();
		}
		if(pos=="bottom"){
			$('#previewFrame').contents().find('#splash .buttons-bottom').show();
		}
		if(pos=="page-bottom"){
			$('#previewFrame').contents().find('#splash .buttons-bottom').show();
		}
	  }
	})
	//ColorPickers
	// $('#bgColor').minicolors({
		// change: function(value, opacity) {
			// $('#previewFrame').contents().find('body').css('background-color',value);
		 // }
	// });
	
	
 //Color
		$('#bgColor-tmp').coloringPick({
			'show_input':false,
			'inline': false,
			'picker': '',
			'picker_changeable': true,
			'swatches':presets,
			'theme': 'light',
			'picker_text': '',
			'destroy': false,
			'change': function(val){
				$('#previewFrame').contents().find('html').css('background',val);
				$('#bgColor').val(val);
			}
		});	
		
		$('._col_pick_tool').on('click',function(){
			$(".minicolors-swatches").hide()
		})
	$(".col-colorbtn").hide();
	
	$('#bgOverlayColor').minicolors({
		opacity:true,
		format:'rgb',
		change: function(value, opacity) {
			tColor=$('#previewFrame').contents().find('body').css('background-image')
			//console.log(tColor+" "+value)
			$('#previewFrame').contents().find('body').css('background',tColor+" "+value );
			//$('#previewFrame').contents().find('.btn-action').find('span').css('color',value);
			//$('#previewFrame').contents().find('.btn-action:hover').find('span').css('color',value);
			//$('.button-style').trigger("change");
		 },
		 changeDelay: 50
	});
	$('#textColor').minicolors({
		change: function(value, opacity) {
			$('#previewFrame').contents().find('.btn-action').find('span').css('color',value);
			$('#previewFrame').contents().find('.btn-action:hover').find('span').css('color',value);
			$('.button-style').trigger("change");
		 },
		 changeDelay: 50
	});
	$('#buttonColor').minicolors({
		change: function(value, opacity) {
			$('#previewFrame').contents().find('#buttons-bottom').find('button').attr('data-bgColor',value);
			$('#previewFrame').contents().find('.btn-action').css('background-color',value);
			$('#previewFrame').contents().find('.btn-action:hover').css('background-color',value);
			$('.button-style').trigger("change");
		 },
		 changeDelay: 50
	});

	//Positioning Selects
	$('.logo-position').change(function() { 
		$(this).selectpicker('toggle')
		val=$(this).val();
		dim=$("input[name='photoType']:checked").val();
		if(val=="bottom"){
			$('#previewFrame').contents().find('.logo-top').hide();
			$('#previewFrame').contents().find('.logo-mid').show();
			$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.logo-mid').css('position','unset');
			$('#previewFrame').contents().find('.logo-mid').css('top','unset');			
			$('#previewFrame').contents().find('.logo-mid').css('height','unset');			
		}
		else if(val=="top"){
			$('#previewFrame').contents().find('.logo-top').show();
			$('#previewFrame').contents().find('.logo-mid').hide();
			
			$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});	
			$('#previewFrame').contents().find('.logo-mid').css('display','none!important');
		}
		else if(val=="image-mid"){
			$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.logo-top').hide();
			$('#previewFrame').contents().find('.logo-mid').show();
			$('#previewFrame').contents().find('.logo-mid').addClass('align-items-center');
			$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
			$('#previewFrame').contents().find('.logo-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('.logo-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.logo-mid').css('height','600px');
			}

		}
		else if(val=="image-top"){
			$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.logo-top').hide();
			$('#previewFrame').contents().find('.logo-mid').show();
			$('#previewFrame').contents().find('.logo-mid').addClass('align-items-start');
			$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
			$('#previewFrame').contents().find('.logo-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('.logo-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.logo-mid').css('height','600px');
			}
		}
		else if(val=="image-bottom"){
			$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.logo-top').hide();
			$('#previewFrame').contents().find('.logo-mid').show();
			$('#previewFrame').contents().find('.logo-mid').addClass('align-items-end');
			$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
			$('#previewFrame').contents().find('.logo-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('.logo-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.logo-mid').css('height','600px');
			}
		}
		else if(val=="page-bottom"){
			$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.logo-top').hide();
			$('#previewFrame').contents().find('.logo-mid').show();
			$('#previewFrame').contents().find('.logo-mid').addClass('align-items-end');
			$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
			$('#previewFrame').contents().find('.logo-mid').css('bottom','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('.logo-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.logo-mid').css('height','600px');
			}
		}
		else{
			$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.logo-top').hide();
			$('#previewFrame').contents().find('.logo-mid').show();
			$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
			$('#previewFrame').contents().find('.logo-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('.logo-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.logo-mid').css('height','600px');
			}
		}
	});

	$('.splash-position').change(function() { 
		$(this).selectpicker('toggle')
		val=$(this).val();
		dim=$("input[name='photoType']:checked").val();
		if(val=="bottom"){
			$('#previewFrame').contents().find('#splash-top').hide();
			$('#previewFrame').contents().find('#splash-mid').show();
			$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
		//	$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
			$('#previewFrame').contents().find('#splash-mid').css('top','unset');			
		}
		else if(val=="top"){
			$('#previewFrame').contents().find('#splash-top').show();
			$('#previewFrame').contents().find('#splash-mid').hide();
			$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
		}
		else if(val=="image-mid"){
			$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#splash-top').hide();
			$('#previewFrame').contents().find('#splash-mid').show();
			$('#previewFrame').contents().find('#splash-mid').addClass('align-items-center');
			$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
			$('#previewFrame').contents().find('#splash-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#splash-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#splash-mid').css('height','600px');
			}
		}
		else if(val=="image-top"){
			$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#splash-top').hide();
			$('#previewFrame').contents().find('#splash-mid').show();
			$('#previewFrame').contents().find('#splash-mid').addClass('align-items-start');
			$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
			$('#previewFrame').contents().find('#splash-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#splash-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#splash-mid').css('height','600px');
			}
		}
		else if(val=="image-bottom"){
			$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#splash-top').hide();
			$('#previewFrame').contents().find('#splash-mid').show();
			$('#previewFrame').contents().find('#splash-mid').addClass('align-items-end');
			$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
			$('#previewFrame').contents().find('#splash-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#splash-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#splash-mid').css('height','600px');
			}
		}
		else{
			$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#splash-top').hide();
			$('#previewFrame').contents().find('#splash-mid').show();
			$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
			$('#previewFrame').contents().find('#splash-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#splash-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#splash-mid').css('height','600px');
			}
		}
	});
	
	$('.thanks-position').change(function() { 
		$(this).selectpicker('toggle')
		val=$(this).val();
		dim=$("input[name='photoType']:checked").val();
		if(val=="bottom"){
			$('#previewFrame').contents().find('#thanks-top').hide();
			$('#previewFrame').contents().find('#thanks-mid').show();
			$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
			$('#previewFrame').contents().find('#thanks-mid').css('top','unset');			
		}
		else if(val=="top"){
			$('#previewFrame').contents().find('#thanks-top').show();
			$('#previewFrame').contents().find('#thanks-mid').hide();
			$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
		}
		else if(val=="image-mid"){
			$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#thanks-top').hide();
			$('#previewFrame').contents().find('#thanks-mid').show();
			$('#previewFrame').contents().find('#thanks-mid').addClass('align-items-center');
			$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
			$('#previewFrame').contents().find('#thanks-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
			}
		}
		else if(val=="image-top"){
			$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#thanks-top').hide();
			$('#previewFrame').contents().find('#thanks-mid').show();
			$('#previewFrame').contents().find('#thanks-mid').addClass('align-items-start');
			$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
			$('#previewFrame').contents().find('#thanks-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
			}
		}
		else if(val=="image-bottom"){
			$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#thanks-top').hide();
			$('#previewFrame').contents().find('#thanks-mid').show();
			$('#previewFrame').contents().find('#thanks-mid').addClass('align-items-end');
			$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
			$('#previewFrame').contents().find('#thanks-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
			}
		}
		else{
			$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('#thanks-top').hide();
			$('#previewFrame').contents().find('#thanks-mid').show();
			$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
			$('#previewFrame').contents().find('#thanks-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
			}
		}
	}); 
	
	$('.button-position').change(function() { 
		$(this).selectpicker('toggle')
		val=$(this).val();
		dim=$("input[name='photoType']:checked").val();
		if(val=="bottom"){
			
			$('#previewFrame').contents().find('.buttons-mid').hide();
			$('#previewFrame').contents().find('.buttons-bottom').show();
			
			$('#previewFrame').contents().find('.buttons-mid').css('display','none!important');
			$('#previewFrame').contents().find('.buttons-top').hide();
			$('#previewFrame').contents().find('.buttons-mid').css('height','0px');
			$('#previewFrame').contents().find('.buttons-bottom').css('position','absolute');
			$('#previewFrame').contents().find('.buttons-bottom').css('bottom','unset');
		}
		else if(val=="top"){
			$('#previewFrame').contents().find('.buttons-bottom').hide();
			$('#previewFrame').contents().find('.buttons-top').show();
			$('#previewFrame').contents().find('.buttons-mid').hide();
			
		}
		else if(val=="image-mid"){
			$('#previewFrame').contents().find('.buttons-bottom').hide();
			$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.buttons-top').hide();
			$('#previewFrame').contents().find('.buttons-mid').show();
			$('#previewFrame').contents().find('.buttons-mid').addClass('align-items-center');
			$('#previewFrame').contents().find('.buttons-mid').css('position','absolute');
			$('#previewFrame').contents().find('.buttons-mid').css('top','0');
			$('#previewFrame').contents().find('.buttons-mid').css('display','flex');
			if(dim=="square"){
				$('#previewFrame').contents().find('.buttons-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.buttons-mid').css('height','600px');
			}
		}
		else if(val=="image-top"){
			$('#previewFrame').contents().find('.buttons-bottom').hide();
			$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.buttons-top').hide();
			$('#previewFrame').contents().find('.buttons-mid').show();
			$('#previewFrame').contents().find('.buttons-mid').addClass('align-items-start');
			$('#previewFrame').contents().find('.buttons-mid').css('position','absolute');
			$('#previewFrame').contents().find('.buttons-mid').css('top','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('.buttons-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.buttons-mid').css('height','600px');
			}
		}
		else if(val=="image-bottom"){
			$('#previewFrame').contents().find('.buttons-bottom').hide();
			$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.buttons-top').hide();
			$('#previewFrame').contents().find('.buttons-mid').show();
			$('#previewFrame').contents().find('.buttons-mid').addClass('align-items-end');
			$('#previewFrame').contents().find('.buttons-mid').css('position','absolute');
			$('#previewFrame').contents().find('.buttons-mid').css('bottom','0');
			if(dim=="square"){
				$('#previewFrame').contents().find('.buttons-mid').css('height','400px');
			}
			else{
				$('#previewFrame').contents().find('.buttons-mid').css('height','600px');
			}
		}
		else if(val=="page-bottom"){
			$('#previewFrame').contents().find('.buttons-mid').hide();
			$('#previewFrame').contents().find('.buttons-bottom').show();
			
			$('#previewFrame').contents().find('.buttons-mid').css('display','none!important');
			$('#previewFrame').contents().find('.buttons-top').hide();
			$('#previewFrame').contents().find('.buttons-mid').css('height','0px');
			$('#previewFrame').contents().find('.buttons-bottom').css('position','fixed');
			$('#previewFrame').contents().find('.buttons-bottom').css('bottom','0');
			
		}
		else{
			
			$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
				return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
			});
			$('#previewFrame').contents().find('.buttons-top').hide();
			$('#previewFrame').contents().find('.buttons-mid').hide();

			if(dim=="square"){
				$('#previewFrame').contents().find('.buttons-mid').hide();
			}
			else{
				$('#previewFrame').contents().find('.buttons-mid').hide();
			}
		}
		
		if($(':checkbox[name="hideStart"]').prop( "checked")){
			$('#previewFrame').contents().find('#splash .buttons-top').hide();
			$('#previewFrame').contents().find('#splash .buttons-mid').hide();
			$('#previewFrame').contents().find('#splash .buttons-bottom').hide();
		}
	});
	
	$('.bgAnimation').change(function() { 
		$(this).selectpicker('toggle')
		val=$(this).val();
		var iFrame = document.getElementById('previewFrame');
		if(val=="none"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".champagne").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			if ($("#bgImage").val()==""){
				iFrame.contentWindow.postMessage('clear');
			}
		}
		else if(val=="snow"){
			$('#previewFrame').contents().find("#particles-js").show();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="stars"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find("#stars").show();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			//iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="fireworks"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find(".fireworks").show();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			//iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="clouds"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").show();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			//iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="confetti"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").show();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			//iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="fireworks2"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").show();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			//iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="waves"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").show();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
		//	iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="balloons"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").show();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			var iFrame = document.getElementById('previewFrame');
			iFrame.contentWindow.postMessage("balloons");
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			//iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="spotlight"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").show();
			//iFrame.contentWindow.postMessage('clear');
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".champagne").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="gradient"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('gradient');
			$('#previewFrame').contents().find(".gradient").show()
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="bokeh"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").show();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('bokeh');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="beer"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").show();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('beer');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="drip"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").show();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('drip');
			$('#previewFrame').contents().find(".champagne").hide();
			
		}else if(val=="lava"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").show();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('lava');
			$('#previewFrame').contents().find(".champagne").hide();
			
		}else if(val=="mario"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").show();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('mario');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="nightsky"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").show();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('nightsky');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="searchlights"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").show();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			//iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('searchlights');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="bubbles"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").show();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
		//	iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('bubbles');
			$('#previewFrame').contents().find(".champagne").hide();
			if ($("#bgImage").val()!=""){
				$('#previewFrame').contents().find('body').css('background-image','url('+$("#bgImage").val()+')');
			}
		}else if(val=="fireflies"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").show();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
		//	iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('fireflies');
			$('#previewFrame').contents().find(".champagne").hide();

		}else if(val=="diagonals"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").show();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
		//	iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('diagonals');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="plasma"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").show();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('plasma');
			$('#previewFrame').contents().find(".champagne").hide();
		}else if(val=="champagne"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('champagne');
			$('#previewFrame').contents().find(".champagne").show();
		}else if(val=="fog"){
			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
			iFrame.contentWindow.postMessage('fog');			
			$('#previewFrame').contents().find("#fog").show();
		}
	});

	//Button Style Select
	
$('#buttonStyle').on('change',function() { 
		
		val=$(this).val();
		$('#buttonStyle').selectpicker('close');
		$('#previewFrame').contents().find('.buttons-mid').find('button').removeClass (function (index, className) {
			return (className.match (/(^|\s)button-cust\S+/g) || []).join(' ');
		});
		$('#previewFrame').contents().find('.buttons-top').find('button').removeClass (function (index, className) {
			return (className.match (/(^|\s)button-cust\S+/g) || []).join(' ');
		}); 
		$('#previewFrame').contents().find('.buttons-bottom').find('button').removeClass (function (index, className) {
			return (className.match (/(^|\s)button-cust\S+/g) || []).join(' ');
		});
		
		
		$('#previewFrame').contents().find('.buttons-mid').find('button').addClass(val);
		$('#previewFrame').contents().find('.buttons-mid').find('button').removeClass('btn-secondary');
		$('#previewFrame').contents().find('.buttons-mid').find('button').removeClass('btn-lg');
		$('#previewFrame').contents().find('.buttons-top').find('button').addClass(val);
		$('#previewFrame').contents().find('.buttons-top').find('button').removeClass('btn-secondary');
		$('#previewFrame').contents().find('.buttons-top').find('button').removeClass('btn-lg');
		$('#previewFrame').contents().find('.buttons-bottom').find('button').addClass(val);
		$('#previewFrame').contents().find('.buttons-bottom').find('button').removeClass('btn-secondary');
		$('#previewFrame').contents().find('.buttons-bottom').find('button').removeClass('btn-lg');
		
		
		if (val=='button-cust-nice') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-bgColor');
			tColor="1px solid "+tColor;
			$('#previewFrame').contents().find('.buttons-top').find('button').css('--border',tColor)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('--border',tColor)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('--border',tColor)
			
		}
		
		if (val=='button-cust-3d') {
			$("#showButtonIcon" ).prop( "checked", false );
			if ($('#button-cust-3d').contents().find('.buttons-bottom').find('button').css('border-bottom') != '') {
				var tColor=rgb2hex($('#previewFrame').contents().find('.buttons-bottom').find('button').css('background-color'));
				tColor=LightenDarkenColor(tColor,-10)
				
				$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tColor)
				$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tColor)
				$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tColor)
			} 
		}
		
		if (val=='button-cust-flat') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=rgb2hex($('#previewFrame').contents().find('.buttons-bottom').find('button').css('background-color'));
			tColor=LightenDarkenColor(tColor,10)
			tColor="0px 4px 0px "+tColor+"!important";
			$('#previewFrame').contents().find('.buttons-top').find('button').css('box-shadow',tColor)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('box-shadow',tColor)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('box-shadow',tColor)
		}
		if (val=='button-cust-press') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=rgb2hex($('#previewFrame').contents().find('.buttons-bottom').find('button').css('background-color'));
			tBorder=LightenDarkenColor(tColor,-90)
			$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tBorder)
			
			tBG=LightenDarkenColor(tColor,-50)
			$('#previewFrame').contents().find('.buttons-top').find('button').css('--background',tBG);
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('--background',tBG);
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('--background',tBG);
							
			tShadow=LightenDarkenColor(tColor,-90)
			tShadow="0 0 0 1px "+tBorder;
			$('#previewFrame').contents().find('.buttons-top').find('button').css('--shadow',tShadow)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('--shadow',tShadow)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('--shadow',tShadow)
		}
		
		if (val=='button-cust-outline') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-bgColor');
			tBorder=tColor;
			$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tBorder)
			
			tShadow="4px 4px 0px 0px "+tColor;
			$('#previewFrame').contents().find('.buttons-top').find('button').css('--shadow',tShadow)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('--shadow',tShadow)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('--shadow',tShadow)
		}
		if (val=='button-cust-outline2') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-bgColor');
			tBorder=tColor;
			$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tBorder)
			
			
		}
		if (val=='button-cust-3d2') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=rgb2hex($('#previewFrame').contents().find('.buttons-bottom').find('button').css('background-color'));
			tBorder=LightenDarkenColor(tColor,-90)
			tShadow=LightenDarkenColor(tColor,-50)
			
			tShadow="0 0 0 1px "+tBorder+" inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 "+tShadow+", 0 8px 0 1px rgba(0,0,0,0.4), 0 8px 8px 1px rgba(0,0,0,0.5)";
			$('#previewFrame').contents().find('.buttons-top').find('button').css('--shadow',tShadow)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('--shadow',tShadow)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('--shadow',tShadow)
		}
		if (val=='button-cust-tear') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').css('background-color');
			if (tColor.length>7){	
				 tColor=rgb2hex(tColor);
			}
			tColor2=LightenDarkenColor(tColor,-90)

			tBackground="linear-gradient(45deg, "+tColor2+" 40%, "+tColor+" 100%)";
			$('#previewFrame').contents().find('.buttons-top').find('button').css('--background',tBackground)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('--background',tBackground)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('--background',tBackground)
		}
		if (val=='button-cust-real') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=rgb2hex($('#previewFrame').contents().find('.buttons-bottom').find('button').css('background-color'));
			tColor2=LightenDarkenColor(tColor,-90)

			tBackground="linear-gradient(45deg, "+tColor2+" 40%, "+tColor+" 100%)";
			$('#previewFrame').contents().find('.buttons-top').find('button').attr('data-content',$("#startButtonText").val())
			$('#previewFrame').contents().find('.buttons-mid').find('button').attr('data-content',$("#startButtonText").val())
			$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-content',$("#startButtonText").val())
		}
		if (val=='button-cust-hand-thick') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-bgColor');
			tBorder=tColor
			$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tBorder)		
		}
		if (val=='button-cust-hand-thin') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-bgColor');
			tBorder=tColor
			$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tBorder)
		}
		if (val=='button-cust-hand-dotted') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-bgColor');
			tBorder=tColor
			$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tBorder)
		}
		if (val=='button-cust-hand-dashed') {
			$("#showButtonIcon" ).prop( "checked", false );
			var tColor=$('#previewFrame').contents().find('.buttons-bottom').find('button').attr('data-bgColor');
			tBorder=tColor
			$('#previewFrame').contents().find('.buttons-top').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-mid').find('button').css('border-color',tBorder)
			$('#previewFrame').contents().find('.buttons-bottom').find('button').css('border-color',tBorder)
		}
		
		
	});
	//Settings
	$("#bgSettings").click(function(){
       $('.process-row a[href="#backgroundsTab"]').trigger('click');
	   $('.process-row').find('.btn-primary').addClass('btn-default');
       $('.process-row').find('.btn-primary').removeClass('btn-primary');
       $('a[href="#backgroundsTab"]').find('.btn').removeClass('btn-default');
       $('a[href="#backgroundsTab"]').find('.btn').addClass('btn-primary');
    });
	$("#photoSettings").click(function(){
		$('.process-row a[href="#framesTab"]').trigger('click');
		$('.process-row').find('.btn-primary').addClass('btn-default');
		$('.process-row').find('.btn-primary').removeClass('btn-primary');
		$('a[href="#framesTab"]').find('.btn').removeClass('btn-default');
		$('a[href="#framesTab"]').find('button').addClass('btn-primary');
    });
	$("#stickersSettings").click(function(){
		$('.process-row a[href="#stickersTab"]').trigger('click');
		$('.process-row').find('.btn-primary').addClass('btn-default');
		$('.process-row').find('.btn-primary').removeClass('btn-primary');
		$('a[href="#stickersTab"]').find('.btn').removeClass('btn-default');
		$('a[href="#stickersTab"]').find('button').addClass('btn-primary');

    });
	//Event Clicks
	$("#v-pills-frames").click(function(){
		$('.js-search-input').val("") 
	})
	$("#v-pills-stickers").click(function(){
		$('.js-search-input').val("")
	})
	$(':radio[name="photoType"]').click (function () {
	
		  if($(this).val()=="portrait"){
			$('.dropzone-wrapper.photo').css('width','160px');
			$('.dropzone-wrapper.photo').css('height','240px');
			$('.dimDisplay.photo').html('1200px x 1800px');
			$('.dimDisplay.photo.photo-s').html('400px x 600px');

			$('#previewFrame').contents().find('.logo-top').css('height','600px');
			$('#previewFrame').contents().find('.logo-mid').css('height','600px');
			$('#previewFrame').contents().find('.logo-bottom').css('height','600px');
			
			$('#previewFrame').contents().find('.buttons-top').css('height','600px');
			$('#previewFrame').contents().find('.buttons-mid').css('height','600px');
			$('#previewFrame').contents().find('.buttons-bottom').css('height','600px');
			
			$('#previewFrame').contents().find('#splash-mid').css('height','600px');
			$('#previewFrame').contents().find('.splashImg').css('height','600px');
			//$('#previewFrame').contents().find('#splashImg').css('height','600px');
		
			if(curDim!="portrait"){
				curDim="portrait"
				
				tCat=$('.js-search-input').val()
				if(tCat!=""){
					$('.background-list').html("");
					currentPage=1;
					fetchResults(tCat);
				}
				else{
					setTimeout(function() { buildLibrary('portrait',1);}, 200); 
				}
			}
		  } 
		  else{
			$('.dropzone-wrapper.photo').css('width','200px');
			$('.dropzone-wrapper.photo').css('height','200px');
			$('.dimDisplay.photo').html('1600px x 1600px');
			$('.dimDisplay.photo.photo-s').html('600px x 600px');
			 
			$('#previewFrame').contents().find('.logo-top').css('height','400px');
			//$('#previewFrame').contents().find('.logo-mid').css('height','400px');
			$('#previewFrame').contents().find('.logo-bottom').css('height','400px');
			
			$('#previewFrame').contents().find('.buttons-top').css('height','400px');
			$('#previewFrame').contents().find('.buttons-mid').css('height','400px');
			$('#previewFrame').contents().find('.buttons-bottom').css('height','400px');
			
						
			$('#previewFrame').contents().find('#splash-mid').css('height','400px');
			$('#previewFrame').contents().find('.splashImg').css('height','400px');
		//	$('#previewFrame').contents().find('#splashImg').css('height','400px');
			
			if(curDim!="square"){
				curDim="square"
				tCat=$('.js-search-input').val()
				if(tCat!=""){
					$('.background-list').html("");
					currentPage=1;
					fetchResults(tCat);
				}
				else{
					setTimeout(function() { buildLibrary('square',1);}, 200);
				}
			}
		  }
		  
		  
	})
	
	$('#togglePause').on('click', function(){
		 if($(this).prop( "checked")){	
			
			$('.bg-light').css('display','none');
		}
		else{
			$('.bg-light').css('display','');
		}
	})
	
	//White Label
	$('#whitelabel-brand').focus(function(){
		$('input[name="whitelabelurl"][value="default"]').prop( "checked", true )
	})
	$('#whitelabel-subdomain').focus(function(){
		$('input[name="whitelabelurl"][value="custom"]').prop( "checked", true )
	})
	$('#whitelabel-domain').focus(function(){
		$('input[name="whitelabelurl"][value="custom"]').prop( "checked", true )
	})
	$('#whitelabel-defaultemail').focus(function(){
		$('input[name="whitelabelemail"][value="default"]').prop( "checked", true )
	})
	$('#whitelabel-customemail').focus(function(){
		$('input[name="whitelabelemail"][value="custom"]').prop( "checked", true )
	})
	//Verify Domain
	$("#verifyDomain").on("click",  function() {
		
		var fullDomain=$('#whitelabel-subdomain').val()+"."+$('#whitelabel-domain').val();
		$('#urlToValidate').html(fullDomain);
		if ($(':radio[name="whitelabelurl"]:checked').val()=='custom' && fullDomain!=""){
			$.ajax({
				type: "POST",
				url: "app.php",
				data: { eventAction: "verifyDomain",domain: fullDomain },
				success: function(response)
				{
					var jsonData = JSON.parse(response);
					if (jsonData.success == "1"){
						$('#domainDomainCheck').show();
						$('#domainDomainX').hide();
					}
					else{
						$('#domainDomainCheck').hide();
						$('#domainDomainX').show();
					}
					$('#verifyDomain').popover('show');
				},
				error: function() {
					$('#domainDomainCheck').hide();
					$('#domainDomainX').show();
				}
			});
		}
		
	   return false;
	});

	 $('#verifyDomain').popover({
		html: true,
		placement: 'left',	
		sanitize: false,
		trigger: 'click',
		title: function() {
		  return $('#popover_title_url').html();
		},
		content: function() {
		  return $('#popover_content_url').html();
		},
		template: '<div class="popover" style="width: 800px!important;max-width: 800px!important;" role="tooltip"><div class="arrow"></div><h3 class="popover-header bg-dark text-white"><span class="close-popover float-right text-danger "><i class="fas fa-times"></i></span></h3><div class="popover-body"></div></div>'
	});
	
	
	
	//Verify Email Domain
	$("#verifyEmail").on("click",  function() {
		
		var customemail=$('#whitelabel-customemail').val()
		var a = customemail.split('@');
		$('.emailToValidate').html(customemail);
		$('#emailToValidate1').html("boothyyz."+a[1]);
		$('#emailToValidate2').html("s1._domainkey."+a[1]);
		$('#emailToValidate3').html("s2._domainkey."+a[1]);
		if ($(':radio[name="whitelabelemail"]:checked').val()=='custom' && customemail!=""){
			$.ajax({
				type: "POST",
				url: "app.php",
				data: { eventAction: "verifyEmail",customemail: customemail, uid: $('#accountUID').val() },
				success: function(response)
				{
					var jsonData = JSON.parse(response);
					if (jsonData.success == "1"){
						if(jsonData.dns==true){
							$('#emailDomainCheck1').show();
							$('#emailDomainX1').hide();
						}
						else{
							$('#emailDomainCheck1').hide();
							$('#emailDomainX1').show();
						}
						if(jsonData.dkim1==true){
							$('#emailDomainCheck2').show();
							$('#emailDomainX2').hide();
						}
						else{
							$('#emailDomainCheck2').hide();
							$('#emailDomainX2').show();
						}
						if(jsonData.dkim2==true){
							$('#emailDomainCheck3').show();
							$('#emailDomainX3').hide();
						}
						else{
							$('#emailDomainCheck3').hide();
							$('#emailDomainX3').show();
						}
						if(jsonData.email==true){
							$('#emailDomainCheck').show();
							$('#emailDomainX').hide();
						}
						else{
							$('#emailDomainCheck').hide();
							$('#emailDomainX').show();
						}
					}
					else{
						//alert('Invalid');
						$('#emailDomainCheck').hide();
						$('#emailDomainX').show();
					}
					$('#verifyEmail').popover('show');
				},
				error: function() {
					//alert('Error');
					$('#emailDomainCheck').hide();
					$('#emailDomainX').show();
				}
			});
		}
	   return false;
	});
	
	 $('#verifyEmail').popover({
		html: true,
		placement: 'left',	
		sanitize: false,
		trigger: 'click',
		title: function() {
		  return $('#popover_title_email').html();
		},
		content: function() {
		  return $('#popover_content_email').html();
		},
		template: '<div class="popover" style="width: 800px!important;max-width: 800px!important;" role="tooltip"><div class="arrow"></div><h3 class="popover-header bg-dark text-white"><span class="close-popover float-right text-danger "><i class="fas fa-times"></i></span></h3><div class="popover-body"></div></div>'
	});
	
	
	$('#newEvent').on('hidden.bs.modal', function () {
		$("#assetNav").hide();
	});
	//Event Library
	$(".useTemplate").on("click",  function() {
		if ( $(this).data('event')=="blank"){
			$('[data-dismiss="modal"]').trigger('click');
			setTimeout(function() { 
				$('#blankEvent').trigger('click');
				$("#assetNav").show();
			}, 1000); 
			
		}
		else{
				$.ajax({
					type: "POST",
					url: "app.php",
					data: { eventAction: "loadTemplate",event: $(this).data('event'), uid: $('#accountUID').val() },
					success: function(response)
					{
						var jsonData = JSON.parse(response);
						if (jsonData.success == "1"){
						$("#event-table tbody").append('<tr class="bg-light"><td><span class="eventName" data-url="' + jsonData.url + '">New Event</span><span class="pausedBadge"><span class="badge badge-pill badge-secondary">Paused</span></span></td><td class="text-center mobile-hide">0 <a href="#" class="gallery" data-tooltip="tooltip" data-placement="top" title="Gallery" data-url="' + jsonData.url + '"><i class="far far fa-images px-1"></i></a></td><td class="text-center mobile-hide">0 <a href="#" class="emails" data-tooltip="tooltip" data-placement="top" title="Download Emails" data-url="' + jsonData.url + '"><i class="far fa-envelope px-1"></i></a></td><td class="text-center mobile-hide">0</td><td class="text-center mobile-hide">0</td><td class="text-center mobile-sm"><a style="width:28.6px;"  href="#" data-toggle="modal" data-target="#startBooth" class="start"  data-url="' + jsonData.url + '" data-name="New Event" data-whiteLabelURL="" data-whiteLabelEmail="" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Launch Booth"><i style="width:28.6px;" class="far fa-share-square " ></i></a><a style="width:28.6px;"  href="#" class="edit" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Edit Event" data-toggle="modal" data-target="#newEvent" data-url="' + jsonData.url + '"><i style="width:28.6px;" class="far fa-edit " ></i></a><a href="#" class="duplicate edit" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Duplicate Event" data-url="' + jsonData.url + '"><i class="far fa-clone "></i></a><a href="#" class="activate start" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Start Event" data-url="' + jsonData.url + '"><i class="far fa-play-circle "></i></a><a style="width:28.6px;"  href="#" class="delete" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Delete Event" data-url="' + jsonData.url + '"><i style="width:28.6px;" class="far fa-trash-alt px-1"></i></a></td></tr>');

							
								//$('.edit[data-url="'+jsonData.url+'"]')[0].click();
								//$('#librarySelect').hide();
  
								
								//  $('#eventLibrary .modal-content').css('height', '350px'); 
								 // $('#eventLibrary .modal-content').css('width', '500px'); 
								   
								   // $('#eventLibrary .modal-dialog').css('max-height', '350px');
									// $('#eventLibrary .modal-dialog').css('max-width', '500px'); 
									 
									var url="https://"+site+"/booth/"+jsonData.url;
									var urlP="https://"+site+"/preview/"+jsonData.url;
									
									Swal.fire({
										title:'Event Created!',
										showCancelButton: true,
										text:'Scan to preview your event or click the button below',
										imageUrl: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='+url,
										imageAlt: 'Loading...',
										confirmButtonText: 'Preview Event',
										cancelButtonText: 'Close & Edit',
										preConfirm: (login) => {
											window.open(urlP);
											return false		 
										  }
										
										}).then((result) => {
										  if (result.isDismissed) {
											$('.edit[data-url="'+jsonData.url+'"]')[0].click();
										  }
									})
									//$("#QRhref-w").attr('href','https://api.qrserver.com/v1/create-qr-code/?size=600x600&data='+url);
									//$("#QRsrc-w").attr('src','https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='+url);
									//$("#launchHrefprevieww").attr('href',urlP);
									
								    //$('#eventLibrary .modal-dialog').addClass('modal-dialog-centered'); 
								//$('#libraryEdit').show();
							
					
						} 
						else{
							//alert('Invalid');
							
						}
						$('[data-dismiss="modal"]').trigger('click');
						
						
					},
					error: function() {
						//alert('Error');
						$('[data-dismiss="modal"]').trigger('click');
					}
				});
		   return false;
		}
	});
	//New Event
	$(".newEvent-btn").on('click',function() {
		if(libLoaded !=1){
			$.ajax({
				type: "POST",
				url: "app.php",
				data: { eventAction: "getLibrary",dir: "images/library" },
				success: function(response){
					libraryData = JSON.parse(response).res;	
					libLoaded=1;
					curDim="square"
					setTimeout(function() { buildLibrary('square',0);}, 1000); 
				}
			 })
		}
		
		else if(curDim!="square"){
			curDim="square"
			setTimeout(function() { buildLibrary('square',0);}, 1000); 
		}

		if($('#splashMessage')[0]['data-froala.editor']){
			$('#splashMessage')[0]['data-froala.editor'].html.set("")
		}
		if($('#thanksMessage')[0]['data-froala.editor']){
			$('#thanksMessage')[0]['data-froala.editor'].html.set("")
		}
		$('#bgColor').val("#343a40");
					
		$('.logo-position').selectpicker('val', 'bottom');					
		$('.splash-position').selectpicker('val', 'image-mid');					
		$('.thanks-position').selectpicker('val', 'image-mid');
		$('.button-position').selectpicker('val', 'bottom');
		$('.bgAnimation').selectpicker('val', 'none');

		$('#previewFrame').contents().find(':root').css("background","unset");
		$('#previewFrame').contents().find('#splashImg').attr("src","images/blank-square.png");
	//	$('#previewFrame').contents().find('#splashImg').css("height","400px");
		//$('#previewFrame').contents().find('#splashImg').attr("height","400");
		$('#previewFrame').contents().find('#thanksImg').attr("src","images/blank-square.png");
		//$('#previewFrame').contents().find('#thanksImg').css("height","400px");
		//$('#previewFrame').contents().find('#thanksImg').attr("height","400px");
		$('#previewFrame').contents().find('.splashMessage').html("");
		$('#previewFrame').contents().find('.thanksMessage').html("");
		$('#previewFrame').contents().find('html').css('background-color',"#343a40");

		$('#previewFrame').contents().find('.logo-top').hide();
		$('#previewFrame').contents().find('.logo-mid').show();
		$('#previewFrame').contents().find('.splash-top').hide();
		$('#previewFrame').contents().find('.splash-mid').show();
		$('#previewFrame').contents().find('.thanks-top').hide();
		$('#previewFrame').contents().find('.thanks-mid').show();
		$('#previewFrame').contents().find('.buttons-top').hide();
		$('#previewFrame').contents().find('.buttons-mid').hide();
		$('#previewFrame').contents().find('.buttons-bottom').show();
		
		setTimeout(function(){
		$('.button-style').selectpicker('val', 'button-cust-normal');
		$('.button-style').trigger('change');
		$('.button-style').selectpicker('toggle');
		
		$('.bgAnimation').selectpicker('val', 'none');
		$('.bgAnimation').trigger('change');
		$('.bgAnimation').selectpicker('toggle');
		
		$('.col-colorbox').css('background','#212529');
		$('#bgColor').val('#212529');
		
		},500)
		var iFrame = document.getElementById('previewFrame');

			$('#previewFrame').contents().find("#particles-js").hide();
			$('#previewFrame').contents().find("#stars").hide();
			$('#previewFrame').contents().find(".clouds").hide();
			$('#previewFrame').contents().find(".fireworks").hide();
			$('#previewFrame').contents().find("#fireworks2").hide();
			$('#previewFrame').contents().find("#confetti").hide();
			$('#previewFrame').contents().find("#balloons").hide();
			$('#previewFrame').contents().find("#fog").hide();
			$('#previewFrame').contents().find("#waves").hide();
			$('#previewFrame').contents().find(".spotlight").hide();
			$('#previewFrame').contents().find(".bokeh").hide();
			$('#previewFrame').contents().find(".beer").hide();
			$('#previewFrame').contents().find(".drip-wrapper").hide();
			$('#previewFrame').contents().find(".lamp").hide();
			$('#previewFrame').contents().find(".mario").hide();
			$('#previewFrame').contents().find(".champagne").hide();
			$('#previewFrame').contents().find(".nightsky").hide();
			$('#previewFrame').contents().find(".searchlights").hide();
			$('#previewFrame').contents().find(".bubbles").hide();
			$('#previewFrame').contents().find(".fireflies").hide();
			$('#previewFrame').contents().find(".diagonals").hide();
			$('#previewFrame').contents().find(".plasma").hide();
			$('#previewFrame').contents().find(".gradient").hide();
			iFrame.contentWindow.postMessage('clear');
		

		
		//clorReset('bgColor');
		$("#event-name").val("New Event");
		$("#emailMessage").val("Here's your photo.");
		$("#sharingMessage").val("Check out my photo.");
		$("#splashMessage").val("");
		$("#thanksMessage").val("");
		//$("#logoPosition1" ).prop( "checked", true );
		//$("#splashMessagePosition1" ).prop( "checked", true );
		//$("#thanksMessagePosition1" ).prop( "checked", true );
		$("#startButtonText").val("Start Booth");
		$("#CTAButtonText").val("Visit My Site");
		$("#BuyButtonText").val("Buy Prints");
		$("#photoButtonText").val("Photo");
		$("#cameraButtonText").val("Camera");
		$("#libraryButtonText").val("Select");
		$("#likeButtonText").val("I Like it");
		$("#retakeButtonText").val("Retake");
		$("#nextButtonText").val("Next");
		$("#sendButtonText").val("Send");
		$("#doneButtonText").val("Done");
		$("#disclaimerText").val("");
		$("#userInputText").val("Enter your name");
		$("#CTAButtonURL").val("https://www.virtualbooth.me");
		$("#frameText").val("Select a Frame");
		$("#bgText").val("Select a Background");
		$("#stickerText").val("Add Stickers");
		$("#filterText").val("Select a Filter");
		$("#optionsFilters" ).prop( "checked", false );
		$("#optionsStickers" ).prop( "checked", false );
		$("#optionsBg" ).prop( "checked", false );
		$("#experiencePhoto" ).prop( "checked", true );
		$("#flipImage" ).prop( "checked", true );
		$("#allowLibrarySelect" ).prop( "checked", false );
		$("#enableDisclaimer" ).prop( "checked", false );
		$("#enableUserInput" ).prop( "checked", false );
		$("#autoBG" ).prop( "autoBG", false );
		$("#enableCTA" ).prop( "enableCTA", false );
		$("#enableBuy" ).prop( "enableBuy", true );
		$("#experienceGif" ).prop( "checked", false );
		$("#experienceBoomerang" ).prop( "checked", false );
		$("#requireEmail" ).prop( "checked", true );
		$("#askToShare" ).prop( "checked", false );
		$("#askToShareText").val("Can we add your photo to our online gallery?");
		$("#sharingFacebook" ).prop( "checked", true );
		$("#sharingEmail" ).prop( "checked", true );
		$("#sharingDownload" ).prop( "checked", true );
		$("#sharingTwitter" ).prop( "checked", true );
		$("#sharingGallery" ).prop( "checked", false );
		$("#sharingDropbox" ).prop( "checked", false );
		$("#sharingGoogle" ).prop( "checked", false );
		$("#frameThanksText" ).prop( "checked", false );
		$("#frameStartText" ).prop( "checked", false );
		$("#hideGalleryButton" ).prop( "checked", false );
		//$("#hidePhotoButton" ).prop( "checked", false );
		$("#gifSpeed2" ).prop( "checked", true );
		$("#boomerangSpeed2" ).prop( "checked", true );
		$("#event-url").val("");
		$("#eventAction").val("new");
		$("#photoType1" ).prop( "checked", true );
		$(".remove-preview").click();
		$('#bgOverlayColor').minicolors('value',{color: 'rgba(0, 0, 0, 0.4)'});
		$('#bgColor').val('');
		$('#textColor').minicolors('value',{color: '#FFFFFF'});
		$('#buttonColor').minicolors('value',{color: '#6c757d'}); 
		$('.dropzone-wrapper.bgImage').css('width','266px');
		$('.dropzone-wrapper.bgImage').css('height','150px');
		$('.dropzone-desc.bgImage').css('top','30px');
		$('.dimDisplay.bgImage').html('1920px x 1080px');
		$("#hideStart" ).prop( "checked", false );
		$("#showButtonIcon" ).prop( "checked", true );
		$('#btn-standard').click();
		if(plan=="Virtual Booth Complete" || plan=="Virtual Booth Professional" || plan=="Virtual Booth Trial"){
			Dropzone.forElement('#dz-frames').removeAllFiles(true);
		}
		if(plan=="Virtual Booth Complete" || plan=="Virtual Booth Trial"){
			Dropzone.forElement('#dz-backgrounds').removeAllFiles(true);
			Dropzone.forElement('#dz-stickers').removeAllFiles(true);
		}
		tWidth=100
		
	//stickers="\/console\/images\/stickers\/01.png|\/console\/images\/stickers\/02.png|\/console\/images\/stickers\/03.png|\/console\/images\/stickers\/04.png|\/console\/images\/stickers\/05.png|\/console\/images\/stickers\/06.png|\/console\/images\/stickers\/07.png|\/console\/images\/stickers\/08.png|\/console\/images\/stickers\/09.png|\/console\/images\/stickers\/10.png|\/console\/images\/stickers\/11.png|\/console\/images\/stickers\/12.png|\/console\/images\/stickers\/13.png|\/console\/images\/stickers\/14.png|\/console\/images\/stickers\/15.png|\/console\/images\/stickers\/16.png|\/console\/images\/stickers\/17.png|\/console\/images\/stickers\/18.png|\/console\/images\/stickers\/19.png|\/console\/images\/stickers\/20.png|\/console\/images\/stickers\/21.png|\/console\/images\/stickers\/22.png|\/console\/images\/stickers\/23.png|\/console\/images\/stickers\/24.png|\/console\/images\/stickers\/25.png";
		
		
		if(plan=="Virtual Booth Complete" || plan=="Virtual Booth Professional" || plan=="Virtual Booth Trial"){
			InitializeDropzones({stickers:"",frames:"",backgrounds:""});
		}
	
	

	});

	//Pause
	$("#event-table").on("click", ".activate", function() {
		
		$('.tooltip').hide();
		var activeCounter=parseInt($('#ac').val());
		var numEvents=parseInt($('#ne').val());
		var e="event";
		if(parseInt($('#ne').val()>1)){
			e="events";
		}
		if (activeCounter<numEvents || !$(this).hasClass('start')){
		   $.ajax({
				type: "POST",
				url: "app.php",
				data: { eventAction: "activate",url: $(this).attr("data-url"),user: $("#accountUID").val() },
				success: function(response)
				{
					var jsonData = JSON.parse(response);
					if (jsonData.success == "1"){
						if(jsonData.active == "1"){
							$('.activate[data-url="'+jsonData.url+'"]').find('i').addClass('fa-pause-circle');
							$('.activate[data-url="'+jsonData.url+'"]').find('i').removeClass('fa-play-circle');
							$('.activate[data-url="'+jsonData.url+'"]').removeClass('pause');
							$('.activate[data-url="'+jsonData.url+'"]').addClass('play');
							$('.activate[data-url="'+jsonData.url+'"][data-tooltip="tooltip"]').attr("title","Pause Event");
							$('.activate[data-url="'+jsonData.url+'"]').tooltip('dispose').tooltip({'title': 'Pause Event'}).tooltip('show');
							$('.activate[data-url="'+jsonData.url+'"]').parents("tr:first").removeClass('bg-light');
							$('.activate[data-url="'+jsonData.url+'"]').parents("tr:first").find(".pausedBadge").html('');
							$('#ac').val(parseInt($('#ac').val())+1);
							$('.tooltip').hide()
							Swal.fire({
							  title:'Event Started!',
							  html:'Click on the <i class="far fa-share-square px-1" ></i> button for launch options for your booth.',
							  icon: 'success'
							})
						}
						else{
							$('.activate[data-url="'+jsonData.url+'"]').find('i').removeClass('fa-pause-circle');
							$('.activate[data-url="'+jsonData.url+'"]').find('i').addClass('fa-play-circle');
							$('.activate[data-url="'+jsonData.url+'"]').addClass('pause');
							$('.activate[data-url="'+jsonData.url+'"]').removeClass('play');
							$('.activate[data-url="'+jsonData.url+'"][data-tooltip="tooltip"]').attr("title","Start Event");
							$('.activate[data-url="'+jsonData.url+'"]').tooltip('dispose').tooltip({'title': 'Start Event'}).tooltip('show')
							$('.activate[data-url="'+jsonData.url+'"]').parents("tr:first").addClass('bg-light');	
							$('.activate[data-url="'+jsonData.url+'"]').parents("tr:first").find(".pausedBadge").html('<span class="badge badge-pill badge-secondary">Paused</span>');
							$('#ac').val(parseInt($('#ac').val())-1);
						}
						//$('#ac')
						//Tour - Edit2
						var show = jQuery.cookie('showLaunchTour');
						if(show=="yes"){
							jQuery.cookie('showLaunchTour', 'no', {expires: inOneYear});
							setTimeout(function(){continueTourLaunch();},2000)
						}
					}
					else{
						alert('Error');
					}
				},
				error: function() {
					alert('Error');
				}
			});
		}
		else{
			Swal.fire({
  			icon: 'warning',
  			title: 'Active Event Maximum',
			  html: 'Your plan includes '+parseInt($('#ne').val())+' active event.<br>Please pause <i class="far fa-pause-circle px-1" ></i> an event, or upgrade your plan.'
			})		
		}
		   return false;
	});
	
	//Delete
	$("#event-table").on("click", ".delete", function() {
		$('.tooltip').hide()
		Swal.fire({
		  title: 'Delete Event?',
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.value) {
			  if(!$(this).parents("tr:first").hasClass("bg-light")){
				$('#ac').val(parseInt($('#ac').val())-1);
			  }
			  $(this).closest("tr").remove();
				$.ajax({
				type: "POST",
				url: "app.php",
				data: { eventAction: "delete",url: $(this).attr("data-url"),user: $("#accountUID").val() },
				success: function(response)
				{
					var jsonData = JSON.parse(response);
					if (jsonData.success == "1"){
						if(jsonData.eventCount==0){
							$('#event-table').hide();
							$('#no-events').show();
						}
					}
					else{
						alert('Error');
					}
				},
				error: function() {
					alert('Error');
				}
			});
		   return false;
			
		  }
		})
	   
	});
	
	
	
	//Download Emails
	$("#event-table").on("click", ".emails", function(e) {
		e.preventDefault();
		var numEvents=parseInt($('#ne').val());
		if(numEvents==1){
			Swal.fire({
				  title:'Upgrade Required',
				  html:'This feature is not available with your plan.',
				  icon: 'warning'
						})
			return false;
		}
		var form = $('#emailExport');
		$('#url').val($(this).attr("data-url"));
		$('#eventAction-e').val("emailReport");
		form.submit();

	});
	
	//Gallery
	$("#gallery-download").click(function(e) {
		e.preventDefault();
		var form = $('#galleryDownload');
		$('#url-g').val($(this).attr("data-url"));
		$('#eventAction-g').val("galleryDownload");
		form.submit();

	});
	
	$("#event-table").on("click", ".gallery", function() {
		$('#galleria').html("");
		$('#gallery-tab').trigger('click');
		$('#gallery-download').attr('data-url',$(this).attr("data-url"));
		
		$(".gallery-name").html($(this).parent().parent().find("td").first().html());
		var myGallery=$(this);
		$.ajax({
			type: "POST",
			url: "app.php",
			data: { eventAction: "gallery",url: $(this).attr("data-url"),accountUID: $("#accountUID").val() },
			success: function(response)
			{
				 var jsonData = JSON.parse(response);
				 Galleria.loadTheme('js/galleria/themes/folio/galleria.folio.js');
				 Galleria.configure({ wait: true }); 
				 Galleria.run( '#galleria', {dataSource: jsonData});

				 Galleria.ready(function(){
					var galleria = this;
					this.lazyLoadChunks( 10 );
					this.bind('thumbnail',function(e){
						
						this.addElement('btn-delete');
						this.$('btn-delete').append("<i class='btn-delete icon-remove fa fa-times' data-origurl='"+e.galleriaData['origURL']+"' data-id='"+e.galleriaData['public_id']+"'></i>");
						var thumb = e.thumbTarget, index = e.index; 
						
						this.$('btn-delete').click(function(f){
							f.stopPropagation(); 
							
							var result = confirm("Delete Image?");
							if (result) {							
								var img = $(this).closest(".galleria-image").find("img");
								$.ajax({
									type: "POST",
									url: "app.php",
									data: { eventAction: "deleteImage",img: $(this).find("i").attr("data-id"),url: $(img).attr("src"),origURL: $(this).find("i").attr("data-origurl") },
									success: function(response)
									{
										var jsonData = JSON.parse(response);
										if (jsonData.success == "1"){
											galleria.destroy();
											myGallery.click();
										}
										else{
											alert("Error deleting image")
										}
									},
									error: function() {
										alert('Error');
									}
								});
							}
							return false;
						})
						.insertAfter(thumb);
					});
				})
			},
			error: function() {
				alert('Error');
			}
		});
		
	   return false;

	});
	
	$('.btn-circle').on('click',function(){
	   $('.btn-circle.btn-primary').removeClass('btn-primary').addClass('btn-default');
	   $(this).addClass('btn-primary').removeClass('btn-default').blur();
	});

	$("#gallery-back").click(function(){
		$("#dashboard-tab").click();
	})
	

	
	
	$("#numCredits").on('change', function(eventData) {
		$("#dispCredits").text(eventData.value.newValue);
		$("#price").text('$'+eventData.value.newValue*.15);
		//$("#sale").text('$'+eventData.value.newValue*.10);
		//$("#price").css('text-decoration','line-through');
		stripePrice=eventData.value.newValue*15;
	})

	//Start
	$("#event-table").on("click", ".start", function() {
		var url="https://"+site+"/booth/"+$(this).attr("data-url");
		var urlP="https://"+site+"/preview/"+$(this).attr("data-url");
		var urlG="https://"+site+"/gallery/"+$(this).attr("data-url");
		var cURL=$(this).attr("data-whiteLabelURL");
		if (cURL){
		if (site=="go.virtualbooth.me"){
			cURL=cURL+"/go";
		}
			url="https://"+cURL+'/booth/'+$(this).attr("data-url");
			urlP="https://"+cURL+'/preview/'+$(this).attr("data-url");
			urlG="https://"+cURL+'/gallery/'+$(this).attr("data-url");
		}
		$("#QRhref").attr('href','https://api.qrserver.com/v1/create-qr-code/?size=600x600&data='+url);
		$("#QRsrc").attr('src','https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='+url);
		$("#launchHref").attr('href',url);
		$("#launchHref-preview").attr('href',urlP);
		
		$("#copyURL").val(url);
		var numEvents=parseInt($('#ne').val());
		if(numEvents>1){
			$("#launchGallery").attr('href',urlG+"?fs=0");
			$("#launchSlideshow").attr('href',urlG+"?fs=1");
			$("#copyEmbed").val('<div id="vb-'+$(this).attr("data-url")+'"  style="height: 800px"></div><script src="https://'+site+'/embed/'+$(this).attr("data-url")+'"></script><script>PhotoBooth.initWidget("vb-'+$(this).attr("data-url")+'", "'+$(this).attr("data-url")+'");</script>');
			$("#startTitle").html($(this).attr("data-name")+ ' Launch Options');
		}
		else{
			$("#copyEmbedIcon").hide();
		}
	})
	
	$(".copyURL").click(function (e) {
		$(this).attr("title","Copied");
		$(this).tooltip('dispose').tooltip({'title': 'Copied'}).tooltip('show')

		navigator.clipboard.writeText($('#copyURL').val());
		setTimeout(function(){ $("#copyURLIcon").tooltip('hide');$("#copyURLIcon").attr("title","Copy URL");$("#copyURLIcon").tooltip('dispose').tooltip({'title': 'Copy URL'}) }, 1000);
	});
	
	
	$(".copyEmbed").click(function (e) {
		var numEvents=parseInt($('#ne').val());
		if(parseInt($('#ne').val())>1){
			e="events";
			$(this).attr("title","Copied");
			$(this).tooltip('dispose').tooltip({'title': 'Copied'}).tooltip('show')

			navigator.clipboard.writeText($('#copyEmbed').val());
			setTimeout(function(){ $("#copyEmbedIcon").tooltip('hide');$("#copyEmbedIcon").attr("title","Copy Embed");$("#copyEmbedIcon").tooltip('dispose').tooltip({'title': 'Copy Embed'}) }, 1000);
		}
		else{
			Swal.fire({
  			icon: 'warning',
  			title: 'Upgrade Required',
			  html: 'This feature requires a Pro account.'
			})		
		}
	});
	//Edit Event


	$("#event-table").on("click", ".edit", function() {
	
		if(libLoaded !=1){
			$.ajax({
				type: "POST",
				url: "app.php",
				data: { eventAction: "getLibrary",dir: "images/library" },
				success: function(response){
					libraryData = JSON.parse(response).res;
					setTimeout(function() { buildLibrary('square',0);}, 500);
					libLoaded=1;
				}
			 })
		} 
		$("#frames-btn").click();
		openNav('left',1);
		$("#optionsFilters" ).prop( "checked", false );
		$("#showButtonIcon" ).prop( "checked", true );
		$("#optionsStickers" ).prop( "checked", false );
		$("#optionsBg" ).prop( "checked", false );
		$("#experiencePhoto" ).prop( "checked", false );
		$("#flipImage" ).prop( "checked", false );
		$("#allowLibrarySelect" ).prop( "checked", false );
		$("#enableDisclaimer" ).prop( "checked", false );
		$("#enableUserInput" ).prop( "checked", false );
		$("#autoBG" ).prop( "checked", false );
		$("#enableCTA" ).prop( "checked", false );
		$("#enableBuy" ).prop( "checked", false );
		$("#experienceGif" ).prop( "checked", false );
		$("#experienceBoomerang" ).prop( "checked", false );
		$("#requireEmail" ).prop( "checked", false );
		$("#askToShare" ).prop( "checked", false );
		$("#sharingFacebook" ).prop( "checked", false );
		$("#sharingEmail" ).prop( "checked", false );
		$("#sharingDownload" ).prop( "checked", false );
		$("#sharingTwitter" ).prop( "checked", false );
		$("#sharingGallery" ).prop( "checked", false );
		$("#sharingDropbox" ).prop( "checked", false );
		$('#eventAction').val("edit");
		
		$('.remove-preview').click();
		$('#btn-standard').trigger('click');
		
		
		isDuplicate=0;
		if(	$(this).hasClass( "duplicate" )){
			
			isDuplicate=1;
			$.ajax({
			type: "POST",
			url: "app.php",
			data: { eventAction: "duplicate",url: $(this).attr("data-url") },
			success: function(response)
			{
				var jsonData = JSON.parse(response);
				if (jsonData.success == 1){
					newURL=jsonData.url
					if(plan=="Virtual Booth Complete" || plan=="Virtual Booth Professional" || plan=="Virtual Booth Trial"){
						Dropzone.forElement('#dz-frames').removeAllFiles(true);
					}
					if(plan=="Virtual Booth Complete" || plan=="Virtual Booth Trial"){
						Dropzone.forElement('#dz-backgrounds').removeAllFiles(true);
						Dropzone.forElement('#dz-stickers').removeAllFiles(true);
					}
				}
			}
			})
		}
	   $.ajax({
			type: "POST",
			url: "app.php",
			data: { eventAction: "load",url: $(this).attr("data-url") },
			success: function(response)
			{
				var jsonData = JSON.parse(response);
				if (jsonData.success == 1){
					
					$('#event-name').val(jsonData.name);
					
					$('#thanksImage').val(jsonData.thanksImage);
					$('#logoImage').val(jsonData.logoImage);
					$('#event-url').val(jsonData.url);
					if (isDuplicate==1){
						$('#event-url').val(newURL);
						$('#event-name').val(jsonData.name+" Copy");
					}
					
					$('#emailMessage').val(jsonData.emailMessage);
					$('#sharingMessage').val(jsonData.sharingMessage);
					if(jsonData.splashMessage!=""){
						try {
							$('#splashMessage')[0]['data-froala.editor'].html.set(decodeURI(jsonData.splashMessage))	
						}
						catch(err){
							
						} 
					}
					else{
						try {
							$('#splashMessage')[0]['data-froala.editor'].html.set("")	
						}
						catch(err){
							
						} 
					}
					if(jsonData.thanksMessage!=""){
						try {
							$('#thanksMessage')[0]['data-froala.editor'].html.set(decodeURI(jsonData.thanksMessage))
						}
						catch(err){
							
						}
					}
					else{
						try {
							$('#thanksMessage')[0]['data-froala.editor'].html.set("")
						}
						catch(err){
							
						}
					}
					$('#emailSubject').val(jsonData.emailSubject);
					$('#startImage').val(jsonData.startImage);
					$('#splash-width').val(jsonData.splashWidth);
					$('#splash-height').val(jsonData.splashHeight);
					$('#thanks-width').val(jsonData.thanksWidth);
					$('#thanks-height').val(jsonData.thanksHeight);
					$('#bgImage-width').val(jsonData.bgImageWidth);
					$('#bgImage-height').val(jsonData.bgImageHeight);
					$('#bgOverlayColor').minicolors('value',{color: jsonData.bgOverlayColor});
				
					$('#bgColor').val(jsonData.bgColor);
					$('.col-colorbox').css('background',jsonData.bgColor);
					
					//console.log(jsonData.bgColor)
					$('#textColor').minicolors('value',{color: jsonData.textColor});
					$('#buttonColor').minicolors('value',{color: jsonData.buttonColor});
					
					$('#whitelabel-fromname').val(jsonData.fromName);
					$('#bgImage').val(jsonData.bgImage);
					$('#startButtonText').val(jsonData.startButtonText);
					$('#CTAButtonText').val(jsonData.CTAButtonText);
					$('#BuyButtonText').val(jsonData.BuyButtonText);
					$('#photoButtonText').val(jsonData.photoButtonText);
					$('#retakeButtonText').val(jsonData.retakeButtonText);
					$('#likeButtonText').val(jsonData.likeButtonText);
					$("#startButtonText").val(jsonData.startButtonText);
					$("#cameraButtonText").val(jsonData.cameraButtonText);
					$("#libraryButtonText").val(jsonData.libraryButtonText);
					$("#retakeButtonText").val(jsonData.retakeButtonText);
					$("#nextButtonText").val(jsonData.nextButtonText);
					$("#sendButtonText").val(jsonData.sendButtonText);
					$("#doneButtonText").val(jsonData.doneButtonText);
					$("#disclaimerText").val(jsonData.disclaimerText);
					$("#userInputText").val(jsonData.userInputText);
					$("#CTAButtonURL").val(jsonData.CTAButtonURL);
					$("#askToShareText").val(jsonData.askToShareText);
					$("#frameText").val(jsonData.frameText);
					$("#bgText").val(jsonData.bgText);
					$("#stickerText").val(jsonData.stickerText);
					$("#filterText").val(jsonData.filterText);
					
					
					
					if(jsonData.whiteLabelURLType=="none"){
						$('#whitelabel-subdomain').val('');
						$('#whitelabel-domain').val('');
						$('#whitelabel-brand').val('');
						$('input[name="whitelabelurl"][value="none"]').prop( "checked", true )
					}
					else{
						a=jsonData.whiteLabelURL.split('.');
						if(jsonData.whiteLabelURLType=="default"){
							brand=a[0];
							$('#whitelabel-brand').val(brand);
							$('#whitelabel-subdomain').val('');
							$('#whitelabel-domain').val('');
							$('input[name="whitelabelurl"][value="default"]').prop( "checked", true )
						}
						else if(jsonData.whiteLabelURLType=="custom"){
							subdomain=a[0];
							
							n = jsonData.whiteLabelURL.indexOf(".");
							domain=jsonData.whiteLabelURL.substring(n+1)
							$('#whitelabel-subdomain').val(subdomain);
							$('#whitelabel-domain').val(domain);
							$('input[name="whitelabelurl"][value="custom"]').prop( "checked", true )
						}
					}
					
					if(jsonData.whiteLabelURLType=="none"){
						$('#whitelabel-customemail').val('');
						$('input[name="whitelabelemail"][value="none"]').prop( "checked", true )
					}
					else{
						a=jsonData.whiteLabelEmail.split('@');
						
						if(jsonData.whiteLabelEmailType=="default"){
							subdomain=a[0];
							$('#whitelabel-defaultemail').val(subdomain);
							$('#whitelabel-customemail').val('');
							$('input[name="whitelabelemail"][value="default"]').prop( "checked", true )
						}
						else if(jsonData.whiteLabelEmailType=="custom"){
							$('#whitelabel-customemail').val(jsonData.whiteLabelEmail);
							$('input[name="whitelabelemail"][value="custom"]').prop( "checked", true )
						}
					}
					
			
					$('#whiteLabelURL').val(jsonData.whiteLabelURL);
					$('#whiteLabelEmail').val(jsonData.whiteLabelEmail);
					
					if(jsonData.experienceGif=="1"){
						$( "#experienceGif" ).prop( "checked", true );
					}
					
					if(jsonData.experiencePhoto=="1"){
						$( "#experiencePhoto" ).prop( "checked", true );
					}
					if(jsonData.flipImage=="1"){
						$( "#flipImage" ).prop( "checked", true );
					}
					if(jsonData.allowLibrarySelect=="1"){
						$( "#allowLibrarySelect" ).prop( "checked", true );
					}
					if(jsonData.enableDisclaimer=="1"){
						$( "#enableDisclaimer" ).prop( "checked", true );
					}
					if(jsonData.enableUserInput=="1"){
						$( "#enableUserInput" ).prop( "checked", true );
					}
					if(jsonData.autoBG=="1"){
						$( "#autoBG" ).prop( "checked", true );
					}
					if(jsonData.enableCTA=="1"){
						$( "#enableCTA" ).prop( "checked", true );
					} 
					if(jsonData.enableBuy=="1"){
						$( "#enableBuy" ).prop( "checked", true );
					}
					if(jsonData.experienceBoomerang=="1"){
						$( "#experienceBoomerang" ).prop( "checked", true );
					}
					if(jsonData.optionsFilters=="1"){
						$( "#optionsFilters" ).prop( "checked", true );
					}
					if(jsonData.optionsBg=="1"){
						$( "#optionsBg" ).prop( "checked", true );
					}
					if(jsonData.optionsStickers=="1"){
						$( "#optionsStickers" ).prop( "checked", true );
					}
					if(jsonData.showButtonIcon=="0"){
						$( "#showButtonIcon" ).prop( "checked", false );
					}
					
					if(jsonData.requireEmail=="1"){
						$( "#requireEmail" ).prop( "checked", true );
					}
					if(jsonData.askToShare=="1"){
						$( "#askToShare" ).prop( "checked", true );
					}
					if(jsonData.sharingFacebook=="1"){
						$( "#sharingFacebook" ).prop( "checked", true );
					}
					if(jsonData.sharingEmail=="1"){ 
						$( "#sharingEmail" ).prop( "checked", true );
					}
					if(jsonData.sharingDownload=="1"){
						$( "#sharingDownload" ).prop( "checked", true );
					}
					if(jsonData.sharingTwitter=="1"){
						$( "#sharingTwitter" ).prop( "checked", true );
					}
					if(jsonData.sharingGallery=="1"){
						$( "#sharingGallery" ).prop( "checked", true );
					}
					if(jsonData.sharingDropbox=="1"){
						$( "#sharingDropbox" ).prop( "checked", true );
					}
					if(jsonData.sharingGoogle=="1"){
						$( "#sharingGoogle" ).prop( "checked", true );
					}
					//if(jsonData.hidePhotoButton=="1"){
					//	$( "#hidePhotoButton" ).prop( "checked", true );
					//} 
					if(jsonData.hideGalleryButton=="1"){
						$( "#hideGalleryButton" ).prop( "checked", true );
					}
					else{
						$( "#hideGalleryButton" ).prop( "checked", false );
					}
					if(jsonData.frameThanksText=="1"){
						$( "#frameThanksText" ).prop( "checked", true );
						$('#previewFrame').contents().find('.thanksMessage').addClass('frameText');
					}
					if(jsonData.frameStartText=="1"){
						$( "#frameStartText" ).prop( "checked", true ); 
						$('#previewFrame').contents().find('.splashMessage').addClass('frameText');
					}
					if(jsonData.hideStart=="1"){
						$( "#hideStart" ).prop( "checked", true );
					}
					else{
						$( "#hideStart" ).prop( "checked", false );
					} 
					if(jsonData.gifSpeed=="slow"){
						$( "#gifSpeed1" ).prop( "checked", true );
					}
					else if(jsonData.gifSpeed=="medium"){
						$( "#gifSpeed2" ).prop( "checked", true );
					}
					else if(jsonData.gifSpeed=="fast"){
						$( "#gifSpeed3" ).prop( "checked", true );
					}
					
					if(jsonData.boomerangSpeed=="slow"){
						$( "#boomerangSpeed1" ).prop( "checked", true );
					}
					else if(jsonData.boomerangSpeed=="medium"){
						$( "#boomerangSpeed2" ).prop( "checked", true );
					}
					else if(jsonData.boomerangSpeed=="fast"){
						$( "#boomerangSpeed3" ).prop( "checked", true );
					} 
					
					$('.logo-position').selectpicker('val', jsonData.logoPosition);					
					$('.splash-position').selectpicker('val', jsonData.splashMessagePosition);					
					$('.thanks-position').selectpicker('val', jsonData.thanksMessagePosition);
					$('.button-position').selectpicker('val', jsonData.buttonPosition);
					$('.button-style').selectpicker('val', jsonData.buttonStyle);
					$('.button-style').trigger('change');
					$('.button-style').selectpicker('toggle');

					$('.bgAnimation').selectpicker('val', jsonData.bgAnimation);
					//$('.bgAnimation').trigger('change');
					//$('.bgAnimation').selectpicker('toggle');
					
					if(jsonData.dimensions=="portrait"){
						$( "#photoType2" ).prop( "checked", true );
							tWidth=75;
							 
					}
					else{
						$( "#photoType1" ).prop( "checked", true );
						tWidth=100;
					}
					 
					if(curDim!=jsonData.dimensions){
						setTimeout(function() { buildLibrary(jsonData.dimensions,0);}, 1000);
						curDim=jsonData.dimensions
					}
					
					if(jsonData.thanksImage=="" || jsonData.thanksImage==" "){
						$('.remove-thanks').click();
					}
					else{
						buildDropzoneSingle('thanks',jsonData.thanksImage,0);
						
					}
					if(jsonData.startImage=="" || jsonData.startImage==" "){
						$('.remove-splash').click();
					}
					else{
						buildDropzoneSingle('splash',jsonData.startImage,0);
					}
					
					if(jsonData.logoImage=="" || jsonData.logoImage==" "){
						$('.remove-logo').click();
					}
					else{
						buildDropzoneSingle('logo',jsonData.logoImage,0);
					}
					
					if(jsonData.bgImage=="" || jsonData.bgImage==" "){
						$('.remove-bgImage').click();
					}
					else{
						buildDropzoneSingle('bgImage',jsonData.bgImage,0);
					}
					  
					if (isDuplicate){
						$('#newEventSave').click();
					}
					if(plan=="Virtual Booth Complete" || plan=="Virtual Booth Professional" || plan=="Virtual Booth Trial"){
						Dropzone.forElement('#dz-frames').removeAllFiles(true);
					}
					if(plan=="Virtual Booth Complete" || plan=="Virtual Booth Trial"){
						Dropzone.forElement('#dz-backgrounds').removeAllFiles(true);
						Dropzone.forElement('#dz-stickers').removeAllFiles(true);
					}
					if ((jsonData.frames || jsonData.backgrounds || jsonData.stickers)&&(plan=="Virtual Booth Professional" || plan=="Virtual Booth Complete" || plan=="Virtual Booth Trial")){
						var existingFiles = {frames:jsonData.frames,backgrounds:jsonData.backgrounds,stickers:jsonData.stickers};
						InitializeDropzones(existingFiles);
						
					}
				
					else {
						if (plan=="Virtual Booth Professional" || plan=="Virtual Booth Complete" || plan=="Virtual Booth Trial"){
							if (jsonData.frame!=""){
								InitializeDropzones({frames:jsonData.frame});
							}
						}
						else{
							var addFrame=0;
							if(jsonData.frame=="" || jsonData.frame==" "){
								var frames=jsonData.frames;
								if (frames!=""){
									addFrame=1;
									if(frames.indexOf("|")>0){
										frames = frames.split("|");
										frame=frames[0];
									}
									else{
										frame = frames;
									}
								}
								else{
									$('.remove-frame').click();
								}
							}
							//if(addFrame!=1){
							else{	
								frame=jsonData.frame;
								
							}
							frameOrig=frame;
							$('#frame').val(frame);
							if(frame!=""){
								if(frame.indexOf('upload/')!=-1){
									//frame=removeVersion(frame);
									var substr = '/upload';
									var attachment = '/f_auto,fl_lossy,q_auto,w_150';
									var frame = frame.replace(substr, substr+attachment);
								}
							}
							var htmlPreview = '<img width="150" src="' + frame + '" /><div class="dz-single-edit"><a class="dz-single-edit-btn" href="#" data-path="'+frame+'"><i class="fa fa-edit"></i></a></div> <div class="dz-single-download"><a class="dz-single-download-btn" href="'+frameOrig+'"  target="_new"  download><i class="fa fa-download"></i></a></div>'

							var wrapperZone = $('.dropzone-wrapper.frame');
							var previewZone = $('.preview-zone.frame');
							var removeZone = $('.box-header.frame');

							var boxZone = $('.box-body.frame');

							$(".dropzone-wrapper.frame").css('display','none');
							wrapperZone.removeClass('dragover');
							previewZone.removeClass('hidden');
							removeZone.css('display','block');
							boxZone.empty();
							boxZone.append(htmlPreview);
						//}
						}
					}
					 
					//Edit Event - Show Preview
					
					if(jsonData.showButtonIcon==0){
						$('#previewFrame').contents().find('button').find('i').hide();
					}
					if(jsonData.showButtonIcon==0){
						$('#previewFrame').contents().find('button').find('i').hide();
					}
				 
					$('#previewFrame').contents().find('#thanks').hide();
					$('#previewFrame').contents().find("#splash").show();
					$('#previewFrame').contents().find('html').css('background',jsonData.bgColor);
					$('#previewFrame').contents().find('body').css('background-color','transparent');
					$('#previewFrame').contents().find('.btn-action').css('color',jsonData.textColor);
					$('#previewFrame').contents().find('.btn-action:hover').css('color',jsonData.textColor);
					$('#previewFrame').contents().find('.btn-action').css('background-color',jsonData.buttonColor);
					$('#previewFrame').contents().find('.btn-action:hover').css('background-color',jsonData.buttonColor);
					$('#previewFrame').contents().find('.start-text').html(jsonData.startButtonText);
					$('#previewFrame').contents().find('.thanks-text').html(jsonData.doneButtonText);
					if(jsonData.bgImage==''){
						$('#previewFrame').contents().find('body').css('background-image','unset');
						$('#previewFrame').contents().find('body').css('background','transparent!important');
					}
					else{
						$('#previewFrame').contents().find('body').css('background','url("'+jsonData.bgImage+'") '+jsonData.bgOverlayColor);
						$('#previewFrame').contents().find('body').css('background-size','cover!important');
						$('#previewFrame').contents().find('body').css('background-position','50% 50%!important');
						$('#previewFrame').contents().find('.clouds').css('z-index','0');
					}
					val=jsonData.bgAnimation
					var iFrame = document.getElementById('previewFrame');
					if(val=="none"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".champagne").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
					}
					else if(val=="snow"){
						iFrame.contentWindow.postMessage('clear');
						$('#previewFrame').contents().find("#particles-js").show();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						
						
						
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="stars"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find("#stars").show();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="fireworks"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find(".fireworks").show();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="clouds"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").show();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="confetti"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").show();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="fireworks2"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").show();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="waves"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#fog").hide();
						iFrame.contentWindow.postMessage('clear');
						$('#previewFrame').contents().find("#waves").show();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						
							
					
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="balloons"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").show();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						var iFrame = document.getElementById('previewFrame');
						iFrame.contentWindow.postMessage("balloons");
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="spotlight"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").show();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".champagne").hide();
						$('#previewFrame').contents().find(".gradient").hide();
					}else if(val=="gradient"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('gradient');
						$('#previewFrame').contents().find(".gradient").show()
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="bokeh"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").show();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('bokeh');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="beer"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").show();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('beer');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="drip"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").show();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('drip');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="lava"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").show();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('lava');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="mario"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").show();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('mario');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="nightsky"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").show();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						iFrame.contentWindow.postMessage('nightsky');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="searchlights"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").show();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						iFrame.contentWindow.postMessage('searchlights');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="bubbles"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").show();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						iFrame.contentWindow.postMessage('bubbles');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="fireflies"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").show();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						if (jsonData.bgImage==''){
							iFrame.contentWindow.postMessage('clear');
						}
						iFrame.contentWindow.postMessage('fireflies');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="diagonals"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").show();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('diagonals');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="plasma"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").show();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('plasma');
						$('#previewFrame').contents().find(".champagne").hide();
					}else if(val=="champagne"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#fog").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('champagne');
						$('#previewFrame').contents().find(".champagne").show();
					}else if(val=="fog"){
						$('#previewFrame').contents().find("#particles-js").hide();
						$('#previewFrame').contents().find("#stars").hide();
						$('#previewFrame').contents().find(".fireworks").hide();
						$('#previewFrame').contents().find("#fireworks2").hide();
						$('#previewFrame').contents().find(".clouds").hide();
						$('#previewFrame').contents().find("#confetti").hide();
						$('#previewFrame').contents().find("#balloons").hide();
						$('#previewFrame').contents().find("#waves").hide();
						$('#previewFrame').contents().find(".spotlight").hide();
						$('#previewFrame').contents().find(".bokeh").hide();
						$('#previewFrame').contents().find(".beer").hide();
						$('#previewFrame').contents().find(".drip-wrapper").hide();
						$('#previewFrame').contents().find(".lamp").hide();
						$('#previewFrame').contents().find(".mario").hide();
						$('#previewFrame').contents().find(".nightsky").hide();
						$('#previewFrame').contents().find(".searchlights").hide();
						$('#previewFrame').contents().find(".bubbles").hide();
						$('#previewFrame').contents().find(".fireflies").hide();
						$('#previewFrame').contents().find(".diagonals").hide();
						$('#previewFrame').contents().find(".plasma").hide();
						$('#previewFrame').contents().find(".gradient").hide();
						iFrame.contentWindow.postMessage('clear');
						iFrame.contentWindow.postMessage('fog');
						$('#previewFrame').contents().find("#fog").show(); 
					} 
					if(val!="none" && jsonData.bgImage==''){
						$('#previewFrame').contents().find('body').css('background-image','unset');
					// $('#previewFrame').contents().find('body').css('background','linear-gradient(to bottom, rgba(117, 114, 113, 0.8) 10%, rgba(40, 49, 77, 0.8) 30%, rgba(29, 35, 71, 0.8) 50%, rgba(19, 25, 28, 0.8) 80%, rgba(15, 14, 14, .8) 100%), url(/console/images/xmas/assets/tumblr_m00c3czJkM1qbukryo1_500.gif)')
					}
					$('#previewFrame').contents().find('#splash-top').hide();
					$('#previewFrame').contents().find('#splash-mid').hide();
					$('#previewFrame').contents().find('#thanks-top').hide();
					$('#previewFrame').contents().find('#thanks-mid').hide();
					$('#previewFrame').contents().find('#buttons-top').hide();
					$('#previewFrame').contents().find('#buttons-mid').hide();
					$('#previewFrame').contents().find('#buttons-bottom').hide();
					if(jsonData.dimensions=="square"){
						//$('#previewFrame').contents().find('#splashImg').css("height",400);
						//$('#previewFrame').contents().find('#thanksImg').css("height",400);
						$('#previewFrame').contents().find('.splashImg').css("height",400);
						$('#previewFrame').contents().find('.thanksImg').css("height",400);
						$('#previewFrame').contents().find('#logo').css("height",400);
						//$('#previewFrame').contents().find('#splashImg').css("max-width",400);
						//$('#previewFrame').contents().find('#thanksImg').css("max-width",400);
						$('#previewFrame').contents().find('#logo').css("width",400);
					} 
					else{
						//$('#previewFrame').contents().find('#splashImg').css("height",600);
					//	$('#previewFrame').contents().find('#thanksImg').css("height",600);
						$('#previewFrame').contents().find('.splashImg').css("height",600);
						$('#previewFrame').contents().find('.thanksImg').css("height",600);
						$('#previewFrame').contents().find('#logo').css("height",600);
						//$('#previewFrame').contents().find('#splashImg').css("max-width",400);
						//$('#previewFrame').contents().find('#thanksImg').css("max-width",400);
						$('#previewFrame').contents().find('#logo').css("width",400);
					}
					$('#previewFrame').contents().find('#splashImg').attr("src",removeVersion(jsonData.startImage));
					$('#previewFrame').contents().find('#thanksImg').attr("src",removeVersion(jsonData.thanksImage));
					if(jsonData.startImage==''){
						$('#previewFrame').contents().find('#splashImg').show()
						$('#previewFrame').contents().find('#splashImg').attr('src','/console/images/blank-'+jsonData.dimensions+".png");
						
					}
					else{
						$('#previewFrame').contents().find('#splashImg').show()
					}
					if(jsonData.thanksImage==''){
						$('#previewFrame').contents().find('#thanksImg').show()
						$('#previewFrame').contents().find('#thanksImg').attr('src','/console/images/blank-'+jsonData.dimensions+".png");
					}
					else{
						$('#previewFrame').contents().find('#thanksImg').show()
					}
					if(jsonData.logoImage==''){
						$('#previewFrame').contents().find('.logo').hide()
					}
					else{
						$('#previewFrame').contents().find('.logo').show()
					}
					$('#previewFrame').contents().find('.logo').attr("src",removeVersion(jsonData.logoImage));
					$('#previewFrame').contents().find('.splashMessage').html(jsonData.splashMessage);
					$('#previewFrame').contents().find('.thanksMessage').html(jsonData.thanksMessage);
					
					if(jsonData.splashMessagePosition=="bottom"){
						$('#previewFrame').contents().find('#splash-top').hide();
						$('#previewFrame').contents().find('#splash-mid').show(); 
						$('#previewFrame').contents().find('#splash-mid').css('position','relative');
						$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						
					} 
					else if(jsonData.splashMessagePosition=="top"){
						$('#previewFrame').contents().find('#splash-top').show();
						$('#previewFrame').contents().find('#splash-mid').hide();
						$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
					}
					else if(jsonData.splashMessagePosition=="image-mid"){
						$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#splash-top').css('display','none!important');
						$('#previewFrame').contents().find('#splash-mid').show();
						$('#previewFrame').contents().find('#splash-mid').addClass('align-items-center');
						$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
						$('#previewFrame').contents().find('#splash-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#splash-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#splash-mid').css('height','600px');
						}
					}
					else if(jsonData.splashMessagePosition=="image-top"){
						$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#splash-top').hide();
						$('#previewFrame').contents().find('#splash-mid').show();
						$('#previewFrame').contents().find('#splash-mid').addClass('align-items-start');
						$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
						$('#previewFrame').contents().find('#splash-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#splash-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#splash-mid').css('height','600px');
						}
					}
					else if(jsonData.splashMessagePosition=="image-bottom"){
						$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#splash-top').hide();
						$('#previewFrame').contents().find('#splash-mid').show();
						$('#previewFrame').contents().find('#splash-mid').addClass('align-items-end');
						$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
						$('#previewFrame').contents().find('#splash-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#splash-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#splash-mid').css('height','600px');
						}
					}
					else{
						$('#previewFrame').contents().find('#splash-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#splash-top').hide();
						$('#previewFrame').contents().find('#splash-mid').show();
						$('#previewFrame').contents().find('#splash-mid').css('position','absolute');
						$('#previewFrame').contents().find('#splash-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#splash-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#splash-mid').css('height','600px');
						}
					}
					
					if(jsonData.thanksMessagePosition=="bottom"){
						$('#previewFrame').contents().find('#thanks-top').hide();
						$('#previewFrame').contents().find('#thanks-mid').show(); 
						$('#previewFrame').contents().find('#thanks-mid').css('position','relative');
						$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
					} 
					else if(jsonData.thanksMessagePosition=="top"){
						$('#previewFrame').contents().find('#thanks-top').show();
						$('#previewFrame').contents().find('#thanks-mid').hide();
						$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
					}
					else if(jsonData.thanksMessagePosition=="image-mid"){
						$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#thanks-top').css('display','none!important');
						$('#previewFrame').contents().find('#thanks-mid').show();
						$('#previewFrame').contents().find('#thanks-mid').addClass('align-items-center');
						$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
						$('#previewFrame').contents().find('#thanks-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
						}
					}
					else if(jsonData.thanksMessagePosition=="image-top"){
						$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#thanks-top').hide();
						$('#previewFrame').contents().find('#thanks-mid').show();
						$('#previewFrame').contents().find('#thanks-mid').addClass('align-items-start');
						$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
						$('#previewFrame').contents().find('#thanks-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
						}
					}
					else if(jsonData.thanksMessagePosition=="image-bottom"){
						$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#thanks-top').hide();
						$('#previewFrame').contents().find('#thanks-mid').show();
						$('#previewFrame').contents().find('#thanks-mid').addClass('align-items-end');
						$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
						$('#previewFrame').contents().find('#thanks-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
						}
					}
					else{
						$('#previewFrame').contents().find('#thanks-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('#thanks-top').hide();
						$('#previewFrame').contents().find('#thanks-mid').show();
						$('#previewFrame').contents().find('#thanks-mid').css('position','absolute');
						$('#previewFrame').contents().find('#thanks-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('#thanks-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('#thanks-mid').css('height','600px');
						}
					}
					if(jsonData.logoPosition=="bottom"){
						$('#previewFrame').contents().find('.logo-top').hide();
						$('#previewFrame').contents().find('.logo-mid').show(); 
						$('#previewFrame').contents().find('.logo-mid').css('position','relative');
						$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						if(jsonData.dimensions=="square"){
					//		$('#previewFrame').contents().find('.logo-mid').css('height','400px');
						}
						else{
						//	$('#previewFrame').contents().find('.logo-mid').css('height','600px');
						}
					} 
					else if(jsonData.logoPosition=="top"){
						$('#previewFrame').contents().find('.logo-top').show();
						$('#previewFrame').contents().find('.logo-mid').hide();
						$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						if(jsonData.dimensions=="square"){
					//		$('#previewFrame').contents().find('.logo-mid').css('height','400px');
						}
						else{
					//		$('#previewFrame').contents().find('.logo-mid').css('height','600px');
						}
					}
					else if(jsonData.logoPosition=="image-mid"){
						$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						}); 
						$('#previewFrame').contents().find('.logo-top').css('display','none!important');
						$('#previewFrame').contents().find('.logo-mid').show();
						$('#previewFrame').contents().find('.logo-mid').addClass('align-items-center');
						$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
						$('#previewFrame').contents().find('.logo-mid').css('top','0');
						if(jsonData.dimensions=="square"){
						//	$('#previewFrame').contents().find('.logo-mid').css('height','400px');
						}
						else{
					//		$('#previewFrame').contents().find('.logo-mid').css('height','600px');
						}
						
					}
					else if(jsonData.logoPosition=="image-top"){
						$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.logo-top').hide();
						$('#previewFrame').contents().find('.logo-mid').show();
						$('#previewFrame').contents().find('.logo-mid').addClass('align-items-start');
						$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
						$('#previewFrame').contents().find('.logo-mid').css('top','0');
						if(jsonData.dimensions=="square"){
						//	$('#previewFrame').contents().find('.logo-mid').css('height','400px');
						}
						else{
						//	$('#previewFrame').contents().find('.logo-mid').css('height','600px');
						}
						
					}
					else if(jsonData.logoPosition=="image-bottom"){
						$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.logo-top').hide();
						$('#previewFrame').contents().find('.logo-mid').show();
						$('#previewFrame').contents().find('.logo-mid').addClass('align-items-end');
						$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
						$('#previewFrame').contents().find('.logo-mid').css('top','0');
						if(jsonData.dimensions=="square"){
					//		$('#previewFrame').contents().find('.logo-mid').css('height','400px');
						}
						else{
						//	$('#previewFrame').contents().find('.logo-mid').css('height','600px');
						}
						
					}
					else if(jsonData.logoPosition=="page-bottom"){
						$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.logo-top').hide();
						$('#previewFrame').contents().find('.logo-mid').show();
						$('#previewFrame').contents().find('.logo-mid').addClass('align-items-end');
						$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
						$('#previewFrame').contents().find('.logo-mid').css('bottom','0');
						if(jsonData.dimensions=="square"){
					//		$('#previewFrame').contents().find('.logo-mid').css('height','400px');
						}
						else{
						//	$('#previewFrame').contents().find('.logo-mid').css('height','600px');
						}
						
					}
					else{
						$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.logo-top').hide();
						$('#previewFrame').contents().find('.logo-mid').show();
						$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
						$('#previewFrame').contents().find('.logo-mid').css('top','0');	
						if(jsonData.dimensions=="square"){
						//	$('#previewFrame').contents().find('.logo-mid').css('height','400px');
						}
						else{
					//		$('#previewFrame').contents().find('.logo-mid').css('height','600px');
						}
					}
					
				
					if(jsonData.buttonPosition=="bottom"){
						
						$('#previewFrame').contents().find('.buttons-mid').hide();
						$('#previewFrame').contents().find('.buttons-bottom').show();
						$('#previewFrame').contents().find('.buttons-top').hide();
						$('#previewFrame').contents().find('.buttons-mid').css('display','none!important');
						$('#previewFrame').contents().find('.buttons-top').css('display','none!important');
						
						$('#previewFrame').contents().find('.buttons-mid').css('height','0px');
					}
					else if(jsonData.buttonPosition=="top"){
						$('#previewFrame').contents().find('.buttons-bottom').hide();
						$('#previewFrame').contents().find('.buttons-top').show();
						$('#previewFrame').contents().find('.buttons-mid').hide();
						
					}
					else if(jsonData.buttonPosition=="image-mid"){
						$('#previewFrame').contents().find('.buttons-bottom').hide();
						$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.buttons-top').hide();
						$('#previewFrame').contents().find('.buttons-mid').show();
						$('#previewFrame').contents().find('.buttons-mid').addClass('align-items-center');
						$('#previewFrame').contents().find('.buttons-mid').css('position','absolute');
						$('#previewFrame').contents().find('.buttons-mid').css('top','0');
						$('#previewFrame').contents().find('.buttons-mid').css('display','flex');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('.buttons-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('.buttons-mid').css('height','600px');
						}
					}
					else if(jsonData.buttonPosition=="image-top"){
						$('#previewFrame').contents().find('.buttons-bottom').hide();
						$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.buttons-top').hide();
						$('#previewFrame').contents().find('.buttons-mid').show();
						$('#previewFrame').contents().find('.buttons-mid').addClass('align-items-start');
						$('#previewFrame').contents().find('.buttons-mid').css('position','absolute');
						$('#previewFrame').contents().find('.buttons-mid').css('top','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('.buttons-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('.buttons-mid').css('height','600px');
						}
					}
					else if(jsonData.buttonPosition=="image-bottom"){
						$('#previewFrame').contents().find('.buttons-bottom').hide();
						$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.buttons-top').hide();
						$('#previewFrame').contents().find('.buttons-mid').show();
						$('#previewFrame').contents().find('.buttons-mid').addClass('align-items-end');
						$('#previewFrame').contents().find('.buttons-mid').css('position','absolute');
						$('#previewFrame').contents().find('.buttons-mid').css('bottom','0');
						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('.buttons-mid').css('height','400px');
						}
						else{
							$('#previewFrame').contents().find('.buttons-mid').css('height','600px');
						}
					}
					else if(jsonData.buttonPosition=="page-bottom"){
						$('#previewFrame').contents().find('.buttons-mid').hide();
						$('#previewFrame').contents().find('.buttons-bottom').show();
						$('#previewFrame').contents().find('.buttons-top').hide();
						$('#previewFrame').contents().find('.buttons-mid').css('display','none!important');
						$('#previewFrame').contents().find('.buttons-top').css('display','none!important');
						
						$('#previewFrame').contents().find('.buttons-mid').css('height','0px');
						$('#previewFrame').contents().find('.buttons-bottom').css('position','fixed');
						$('#previewFrame').contents().find('.buttons-bottom').css('bottom','0');
						
					}
					else{
						
						$('#previewFrame').contents().find('.buttons-mid').removeClass (function (index, className) {
							return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
						});
						$('#previewFrame').contents().find('.buttons-top').hide();
						$('#previewFrame').contents().find('.buttons-mid').hide();

						if(jsonData.dimensions=="square"){
							$('#previewFrame').contents().find('.buttons-mid').hide();
						}
						else{
							$('#previewFrame').contents().find('.buttons-mid').hide();
						}
					}
					
					if(jsonData.hideStart==1){
						$('#previewFrame').contents().find('#splash .buttons-top').hide();
						$('#previewFrame').contents().find('#splash .buttons-mid').hide();
						$('#previewFrame').contents().find('#splash .buttons-bottom').hide();
					}
					
					if(jsonData.logoImage==""){
						$('#previewFrame').contents().find('#splash .logo-top').hide();
						$('#previewFrame').contents().find('#splash .logo-mid').hide();
						$('#previewFrame').contents().find('#splash .logo-bottom').hide();
					}
				 //pushba r.open('mypushbar1');	
					//Tour - Edit
					var show = jQuery.cookie('showEditTour');
					if(show=="yes"){
						jQuery.cookie('showEditTour', 'no', {expires: inOneYear});
						continueTourEdit()
					} else{
						var show = jQuery.cookie('showLibraryTour');
						if(show=="yes"){
							jQuery.cookie('showLibraryTour', 'no', {expires: inOneYear});
							//continueTourLibrary() 
						} 
					}

				}
				else{
					alert('Error');
				}
			},
			error: function() {
				alert('Error');
			}
		});
		if (isDuplicate){
			return false;
		}
		
		$("#assetNav").show();

	});
	
	//Save
	$('#newEventSave').on('click', function(e) {
		var form=$('#newEventForm'); 
		if (form[0].checkValidity() === false) {
			form.addClass('was-validated');
		  e.preventDefault();
		  e.stopPropagation();
		}
		else{
			 Dropzone.instances.forEach(function(item,index){
				var myID=$($(item)[0].element).attr('id').trim();
				if (myID=="dz-frames"){
					var files=$(item)[0].files;
					tFrames="";
					files.forEach(function(file,findex){
						if (file.href){
							tFrames+=file.href+"|";
						}
						else{
							tFrames+=file.previewElement.href+"|";
						}
					});
					tFrames = tFrames.substring(0, tFrames.length - 1);
					$('#frames').val(tFrames);
				}
				if (myID=="dz-backgrounds"){
					var files=$(item)[0].files;
					tBackgrounds="";
					files.forEach(function(file,findex){
						if (file.href){
							tBackgrounds+=file.href+"|";
						}
						else{
							tBackgrounds+=file.previewElement.href+"|";
						}
					});
					tBackgrounds = tBackgrounds.substring(0, tBackgrounds.length - 1);
					$('#backgrounds').val(tBackgrounds);
				}
				if (myID=="dz-stickers"){
					var files=$(item)[0].files;
					tStickers="";
					files.forEach(function(file,findex){
						if (file.href){
							tStickers+=file.href+"|";
						}
						else{
							tStickers+=file.previewElement.href+"|";
						}
					});
					tStickers = tStickers.substring(0, tStickers.length - 1);
					$('#stickers').val(tStickers);
				}
			});

			if ($(':radio[name="whitelabelurl"]:checked').val()=='default'){
				var whitelabelurl=$('#whitelabel-brand').val()+'.vbooth.me';
			}
			else if ($(':radio[name="whitelabelurl"]:checked').val()=='custom'){
				var whitelabelurl=$('#whitelabel-subdomain').val()+'.'+$('#whitelabel-domain').val();
			}
			else{
				var whitelabelurl="";
			}
			if ($(':radio[name="whitelabelemail"]:checked').val()=='default'){
				var whitelabelemail=$('#whitelabel-defaultemail').val()+'@vbooth.me';
			}
			else if($(':radio[name="whitelabelemail"]:checked').val()=='custom'){
				var whitelabelemail=$('#whitelabel-customemail').val();
			}
			else{
				var whitelabelemail="";
			}
			
			var data = form.serializeArray();
			data.push({name: 'whitelabelURL', value: whitelabelurl});
			data.push({name: 'whitelabelEmail', value: whitelabelemail});
			
			str=$('#splashMessage')[0]['data-froala.editor'].html.get();
		data.push({name: 'splashMessage', value: str});
			str=$('#thanksMessage')[0]['data-froala.editor'].html.get();
		data.push({name: 'thanksMessage', value: str});
			
			 
			 
			
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "app.php",
				data: $.param(data),
				success: function(response)
				{
					var jsonData = JSON.parse(response);
					if (jsonData.success == 1 || isDuplicate==1){
						var boothURL='/booth/' + jsonData.url;

						$("#event-table tbody").append('<tr class="bg-light"><td><span class="eventName" data-url="' + jsonData.url + '">' + jsonData.name + ' </span><span class="pausedBadge"><span class="badge badge-pill badge-secondary">Paused</span></span></td><td class="text-center mobile-hide">0 <a href="#" class="gallery" data-tooltip="tooltip" data-placement="top" title="Gallery" data-url="' + jsonData.url + '"><i class="far far fa-images px-1"></i></a></td><td class="text-center mobile-hide">0 <a href="#" class="emails" data-tooltip="tooltip" data-placement="top" title="Download Emails" data-url="' + jsonData.url + '"><i class="far fa-envelope px-1"></i></a></td><td class="text-center mobile-hide">0</td><td class="text-center mobile-hide">0</td><td class="text-center mobile-sm"><a style="width:28.6px;"  href="#" data-toggle="modal" data-target="#startBooth" class="start"  data-url="' + jsonData.url + '" data-name="' + jsonData.name + '" data-whiteLabelURL="' + jsonData.whiteLabelURL + '" data-whiteLabelEmail="' + jsonData.whiteLabelEmail + '" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Launch Booth"><i style="width:28.6px;" class="far fa-share-square " ></i></a><a style="width:28.6px;"  href="#" class="edit" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Edit Event" data-toggle="modal" data-target="#newEvent" data-url="' + jsonData.url + '"><i style="width:28.6px;" class="far fa-edit " ></i></a><a href="#" class="duplicate edit" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Duplicate Event" data-url="' + jsonData.url + '"><i class="far fa-clone "></i></a><a href="#" class="activate start" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Start Event" data-url="' + jsonData.url + '"><i class="far fa-play-circle "></i></a><a style="width:28.6px;"  href="#" class="delete" data-tooltip="tooltip" data-placement="top" data-offset="-10, 0" title="Delete Event" data-url="' + jsonData.url + '"><i style="width:28.6px;" class="far fa-trash-alt px-1"></i></a></td></tr>');
						$('[data-dismiss="modal"]').trigger('click');
						$('#no-events').hide();
						$('#event-table').show();

						$('[data-tooltip="tooltip"]').tooltip({trigger : 'hover'});
						Swal.fire({
							  title:'Event Created!',
							  html:'Click on the <i class="far fa-play-circle px-1" ></i> button to start your event.',
							  icon: 'success'
						})
					}
					else if (jsonData.success == 2){
					
						$('.eventName[data-url="'+jsonData.url+'"]').html(jsonData.name);
						var elem = $('[data-url="'+jsonData.url+'"]');
						 $(elem).each(function(e,v){
						 if($(this).data('target')=="#startBooth"){
							$(this).attr('data-whiteLabelURL',jsonData.whiteLabelURL);
						 }
						
						$('[data-dismiss="modal"]').trigger('click');
						})
					}
					else{
						alert('Error');
					}
					isDuplicate=0;
					$("#no-events").hide();
					$("#event-table").show();
					
				},
				error: function() {
					alert('Error');
					isDuplicate=0;
				}
				
			});
		}
		 
		return false;
	});
	
	//Froala
	var options = {
		key: "AV:4~?3xROKLJKYHROLDXDR@d2YYGR_Bc1A8@5@4:1B2D2F2F1?1?2A3@1C1",
		fontFamilySelection: true,
		fontFamilyDefaultSelection: 'Font',
		fontFamilySelection: true,
		  theme: 'gray',
		attribution: false,
		pluginsEnabled: ['colors','link','fontFamily','fontSize','paragraphStyle','align','paragraphFormat'], 
		paragraphMultipleStyles: false,
		paragraphStyles: {
			
			'normal':'Normal',
			'three-d':'3D',
			'ambient-light':'3D2',
			'smooth':'3D3',
			'artificial-light':'Art Deco',
			'cartoon':'Cartoon Animated',
			'cartoon2':'Cartoon Static',
			'citylights':'City Lights',
			'dropshadow':'Drop Shadow',
			'dropshadow2':'Drop Shadow2',
			'retro':'Drop Shadow 3',
			'burning':'Fire',
			'glow':'Glow',
			'neonf':'Neon Sign Animated',
			'flux':'Neon Sign Static',
			'neon-blue':'Neon Blue',
			'neon-green':'Neon Green',
			'neon-orange':'Neon Orange',
			'neon-purple':'Neon Purple',
			'neon-red':'Neon Red',
			'neon-yellow':'Neon Yellow',
			'tactile':'Slightly Raised'

			
		
		},
		paragraphFormat: {
			N: 'None',
			H4: 'XXL',
			H5: 'XL',
			H6: 'L',
			H7: 'M',
			H8: 'S'
			
		},
        toolbarButtons: ['fontFamily', 'paragraphFormat', 'paragraphStyle', 'textColor','insertLink', 'bold',  'align'],
		events: {
			'initialized': function (event, editor) {
				loadUsedGoogleFonts();
  
			
			
				// Lazy download of font previews
			//	$('[data-cmd="fontFamily"][role="option"]').visibility({
			//		context: $('#dropdown-menu-fontFamily-1 .fr-dropdown-content'),
			//		onTopVisible: function(calculations) {
			//			var font_family = getFirstFontFamily($(this).data('param1'));
			//			loadGoogleFontPreview(font_family);
			//		}
			//	}); 
			},
			'commands.after': function (cmd, param1, param2) {
		
		
				if (cmd == 'fontFamily') {
					var font_family = getFirstFontFamily(param1);
					loadGoogleFont(font_family);
				}
				if (cmd == 'paragraphStyle') {
					var paragraph_style = param1;
					if(paragraph_style=="popart"){
						//var tText=$('#splashMessage')[0]['data-froala.editor'].html.get()
						var tColor=$('#previewFrame').contents().find('.splashMessage').find('span').css('color')
						var tShadow='4px 4px '+tColor+',10px 10px #000000';
						$('#previewFrame').contents().find('.splashMessage').css("textShadow",tShadow)
					}
				}
			},
			'keyup': function(){
				$('#previewFrame').contents().find('.splashMessage').html($('#splashMessage')[0]['data-froala.editor'].html.get());
				$('#previewFrame').contents().find('.thanksMessage').html($('#thanksMessage')[0]['data-froala.editor'].html.get());
			},
			'mouseup': function(){
				$('#previewFrame').contents().find('.splashMessage').html($('#splashMessage')[0]['data-froala.editor'].html.get());
				$('#previewFrame').contents().find('.thanksMessage').html($('#thanksMessage')[0]['data-froala.editor'].html.get());
			},
			'contentChanged': function(){
				$('#previewFrame').contents().find('.splashMessage').html($('#splashMessage')[0]['data-froala.editor'].html.get());
				$('#previewFrame').contents().find('.thanksMessage').html($('#thanksMessage')[0]['data-froala.editor'].html.get());
			}
		}
	}
		// Fetch all the google web fonts (regular weight) to load in
		var webfonts_address = 'https://pagecdn.io/lib/easyfonts/info/fonts.json';
		var fetch_web_fonts = $.getJSON(webfonts_address).then(function(data) { 
			
			return data 
		});

		var collect_font_families = fetch_web_fonts.then(function(google_fonts) {
			var fonts = {
	      'Arial,Helvetica,sans-serif': 'Arial',
	      'Arial Black,Arial Bold,Gadget, sans-serif': 'Arial Black',
	      'Arial Narrow,Arial,sans-serif': 'Arial Narrow',
	      'Georgia,serif': 'Georgia',
	      'Impact,Charcoal,sans-serif': 'Impact',
	      'Tahoma,Geneva,sans-serif': 'Tahoma',
	      'Times New Roman,Times,serif,-webkit-standard': 'Times New Roman',
	      'Verdana,Geneva,sans-serif': 'Verdana',
	      'Palatino Linotype,Book Antiqua,Palatino,serif': 'Palatino Linotype',
	      'Lucida Sans Unicode,Lucida Grande,sans-serif': 'Lucida Sans Unicode',
	      'Lucida Console,Monaco,monospace': 'Lucida Console',
	      'Gill Sans,Gill Sans MT,Calibri,sans-serif': 'Gill Sans',
	      'Century Gothic,CenturyGothic,AppleGothic,sans-serif': 'Century Gothic',
	      'Copperplate,Copperplate Gothic Light,fantasy': 'Copperplate',
	      'Gill Sans,Gill Sans MT,Calibri,sans-serif': 'Gill Sans',
	      'Trebuchet MS,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Tahoma,sans-serif': 'Trebuchet MS',
	      'Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace': 'Courier New',
	      'Garamond,Baskerville,Baskerville Old Face,Hoefler Text,Times New Roman,serif': 'Garamond',
	      'Helvetica Neue,Helvetica,Arial,sans-serif': 'Helvetica Neue'
	    };
			var i = 1;
			
			$.each(google_fonts, function(index, font) {
				//if ($.inArray('regular', font.font_variants) > -1) {
				if(i==3){
					fonts["'" + font.font_family + "'," + font.font_family] = font.font_family;
					i=1;	
				}
				i++
			//	}
			});

			return fonts;
		});
 
		collect_font_families.then(function(font_families) {
			options.fontFamily = font_families;
			 Neditor1 = new FroalaEditor('#splashMessage',options);
			 Neditor2 = new FroalaEditor('#thanksMessage',options);
			//editor_selector.froalaEditor(options);
		});

		

		function getFirstFontFamily(declaration) {
			return declaration.split(',')[0].replace(/['"]+/g, '').trim();
		}

		function loadUsedGoogleFonts() {
			// Download fonts already in the editor
			var $font_nodes = $('.fr-view [style*="font-family"]');
			$font_nodes.each(function() {
				var font_family = getFirstFontFamily($(this).css('font-family'));
				loadGoogleFont(font_family);
			});
		}

		function isGoogleFont(font_family) {
			return fetch_web_fonts.then(function(google_fonts) {
				is = false;

		    $.each(google_fonts, function(index, font) {
					if (font.family === font_family) {
						is = true;
						return false;
					}
				});

				return is;
		  });
		}

		function loadGoogleFontPreview(font_family) {
	    isGoogleFont(font_family).then(function(is) {
				if (is) {
					WebFont.load({ google: { families: [font_family], text: font_family } });
				}
			});
	  }

		function loadGoogleFont(font_family) {
			isGoogleFont(font_family).then(function(is) {
				if (is) {
					WebFont.load({ google: { families: [font_family + ':regular,italic,700,700italic:latin-ext'] } });
				}
			});
		}
		
		
});
 
// Dropzone
Dropzone.autoDiscover = false;
init=""
InitializeDropzones(false);

function InitializeDropzones(list) {
	$(".remove-preview-dz").click(); 

    Array.prototype.slice.call(document.querySelectorAll('.dropzone'))
        .forEach(element => {

        if (element.dropzone) {
			element.dropzone.emit("resetFiles");	
			element.dropzone.destroy();			

			
        } 

        var myDropzone = new Dropzone(element, {
            url: "/console/app.php",
			params: {
                "imageType": element.id
            },
            previewTemplate: document.querySelector('#preview-template').innerHTML,
			parallelUploads: 2,
			maxFiles: 50,
			 thumbnailHeight: 100,
			 thumbnailWidth: tWidth,
			 thumbnailMethod: 'contain',
			maxFilesize: 5,
			filesizeBase: 1000,
			addRemoveLinks: true,
			dictCancelUpload:"",
			dictRemoveFile:"",
			init: function() {
				this.on("success", function(file, serverResponse) {
					obj=JSON.parse(serverResponse);
					var id=this.element.attributes.id;
					if(id.value=="dz-frames"){
						tFrames="";
						if($("#frames").val()!=""){
							tFrames=$("#frames").val()+"|"
						}
						$("#frames").val(tFrames+obj.secure_url);
					}
					else if(id.value=="dz-backgrounds"){
						tBackgrounds="";
						if($("#backgrounds").val()!=""){
							tBackgrounds=$("#backgrounds").val()+"|"
						}
						$("#backgrounds").val(tBackgrounds+obj.secure_url);
					}
					else if(id.value=="dz-stickers"){
						tStickers="";
						if($("#stickers").val()!=""){
							tStickers=$("#stickers").val()+"|"
						}
						$("#stickers").val(tStickers+obj.secure_url);
					}
				//	console.log(curDim);
				//	console.log(obj.height);
					file.previewElement.href = obj.secure_url
					file.href = obj.secure_url;
					uid=obj.uid;
					
					img=obj.secure_url;
					var substr = '/upload';
					var attachment = '/f_auto,fl_lossy,q_auto,h_100';
					var imgC = img.replace(substr, substr+attachment);
					 $(file.previewElement).find(".dz-image img").attr('src',imgC);
					 $(file.previewElement).find(".dz-edit").html('<a class="dz-edit-btn" href="#" data-uid="'+uid+'" data-path="'+file.href+'"><i class="fa fa-edit"></i></a>');
					 $(file.previewElement).find(".dz-download").html('<a class="dz-download-btn" href="'+file.href+'" data-path="'+file.href+'" download><i class="fa fa-download"></i></a>');
					
					if(id.value=="dz-frames" && obj.hasTransparency==0){
						$("#dz-frames").find(".dz-edit-btn").last().click();
					}
				 
				});
				this.on("successmultiple", function(files, response) {
					//for( var i = 0; i < files.length; i++){
					//	files[i].id = response[i].id;
				//}
				});
				this.on('removedfile', function(file) {
					//var filename = file.previewElement.href;
					});
				this.on('addedfile', function(file) {
						var needsEdit=file.needsEdit
						if(needsEdit=="yes"){
							$("#"+id.value +" .dz-preview:last-child").find(".dz-edit").html('<a class="dz-edit-btn lastEdit" href="#" data-path="'+file.orig+'"  data-uid="'+file.stateUID+'"><i class="fa fa-edit"></i></a>');
							setTimeout(function() { 
								$(".lastEdit").last().click();	
								
							  }, 1000); 
						/*	setTimeout(function() { guiders.createGuider({
								buttons: [{name: "Close",onclick:function(){guiders.hideAll(); guiders.destroy()}}], 
								description: '<div class="pt-4">Set the size and position for the user\'s photo.</div>',
								id: "30",
								position: 3,
								attachTo: "#pixie-edit", 
								overlay: true,
								title: "Edit Image",
								xButton:true,
								width: 550,
								zoom:window.devicePixelRatio,
								onClose: function(){guiders.hideAll(); guiders.destroy();}
							}).show();},1000)*/
						}
						else{
							$("#"+id.value +" .dz-preview:last-child").find(".dz-edit").html('<a class="dz-edit-btn" href="#" data-path="'+file.orig+'"  data-uid="'+file.stateUID+'"><i class="fa fa-edit"></i></a>');
						}
						$("#"+id.value +" .dz-preview:last-child").find(".dz-download").html('<a class="dz-download-btn" href="'+file.orig+'" data-path="'+file.orig+'" download><i class="fa fa-download"></i></a>');
						
				});
				this.on("complete", function(file) {
					var filename = file.href;
					//$(".dz-preview:last-child .dz-preview .dz-filename [data-dz-name]").html(file.name)
					$('.global-spinner').css('display','none');
					$(".dz-remove").html('<i class="fa fa-times"></i>');
					
				});
				this.on("sending", function(file, xhr, form) {
					$('.global-spinner').css('display','flex');
					form.append('eventAction', "assetsMulti");
					form.append('curDim', curDim);
					form.append('accountUID', $("#accountUID").val());
					form.append('eventURL', $("#event-url").val());
				  });
				  this.on('resetFiles', function() {
					  $("#frames").val('')
					  $("#backgrounds").val('')
					  $("#stickers").val('')
					if(this.files.length != 0){
						for(i=0; i<this.files.length; i++){
							this.files[i].previewElement.remove();
						}
						this.files.length = 0;
					}
				});
				  if(list){
					
					var id=this.element.attributes.id;
					if(id.value=="dz-frames"){
						var dz=this;
						
						var callback = null; 
						var crossOrigin = true; 
						var resizeThumbnail = true; 
						if(list.frames){
							if(list.frames.indexOf("|")>0){
								var frames = list.frames.split("|");
							}
							else{
								var frames = list.frames;
							}
							
						}
						else{
							if (typeof frames === 'string'){
							frames=list;
							}
						}

						if (Array.isArray(frames)){
							frames.forEach(function(frame,index){
								//iold = 's3.amazonaws.com/virtualbooth.me';
								//inew = 'virtualbooth.imgix.net';
								//frame=frame.replace(iold,inew);
								//frame=removeVersion(frame);
								frameOrig=frame;
								//console.log(frame)
								var filename = frame.replace(/^.*[\\\/]/, '')
								if(frame.indexOf('upload/')!=-1){
									var substr = '/upload';
									var attachment = '/f_auto,fl_lossy,q_auto,h_100';
									var frame = frame.replace(substr, substr+attachment);
								}	 
								var mockFile = { name: filename, size: 12345, href: frameOrig, id:index, orig: frameOrig};
								dz.displayExistingFile(mockFile, frame, callback, "anonymous", resizeThumbnail);
								//dz.emit("addedfile", mockFile);
								dz.files.push(mockFile);
							})
						}
						else{
							if(frames){
								frame=frames;
								//frame=removeVersion(frame);
								frameOrig=frame;
								if(frame.indexOf('upload/')!=-1){
									var substr = '/upload';
									var attachment = '/f_auto,fl_lossy,q_auto,h_100';
									var frame = frame.replace(substr, substr+attachment);
								}	
								var filename = frame.replace(/^.*[\\\/]/, '')
								var mockFile = { name: filename, size: 12345, href: frameOrig,  url: frameOrig, orig: frameOrig };
								dz.displayExistingFile(mockFile, frame, callback, "anonymous", resizeThumbnail);
									dz.files.push(mockFile);
							}
						}
						
					}
					if(id.value=="dz-backgrounds"){
						var dz=this;
						
						var callback = null;
						var crossOrigin = true;
						var resizeThumbnail = true;
						if(list.backgrounds){
							if(list.backgrounds.indexOf("|")>0){
								var backgrounds = list.backgrounds.split("|");
							}
							else{
								var backgrounds = list.backgrounds;
							}

							if (Array.isArray(backgrounds)){
								backgrounds.forEach(function(background,index){//frame=frame.replace(iold,inew);
								//background=removeVersion(background);
								backgroundOrig=background
								var filename = background.replace(/^.*[\\\/]/, '')
								if(background.indexOf('upload/')!=-1){
									var substr = '/upload';
									var attachment = '/f_auto,fl_lossy,q_auto,h_100';
									var background = background.replace(substr, substr+attachment);
								}	
								var mockFile = { name: filename, size: 12345, href: backgroundOrig, orig: backgroundOrig };
									dz.displayExistingFile(mockFile, background, callback, "anonymous", resizeThumbnail);
									dz.files.push(mockFile);
								//	dz.emit("addedfile", mockFile);
								})
							}
							else{
								background=backgrounds;
								//background=removeVersion(background);
								backgroundOrig=background
								var filename = background.replace(/^.*[\\\/]/, '')
								if(background.indexOf('upload/')!=-1){
									var substr = '/upload';
									var attachment = '/f_auto,fl_lossy,q_auto,h_100';
									var background = background.replace(substr, substr+attachment);
								}	
								var mockFile = { name: filename, size: 12345, href: backgroundOrig,  url: backgroundOrig, orig: backgroundOrig };
								dz.files.push(mockFile);
								dz.displayExistingFile(mockFile, background, callback, "anonymous", resizeThumbnail);
								//dz.emit("addedfile", mockFile);
							}
						}
					}
					if(id.value=="dz-stickers"){
						var dz=this;
						
						var callback = null;
						var crossOrigin = true; 
						var resizeThumbnail = true; 
						if(list.stickers){
							if(list.stickers.indexOf("|")>0){
								var stickers = list.stickers.split("|");
							}
							else{
								var stickers = list.stickers;
							}

							if (Array.isArray(stickers)){
								stickers.forEach(function(sticker,index){
									//sticker=removeVersion(sticker);
									stickerOrig=sticker
									var filename = sticker.replace(/^.*[\\\/]/, '')
									if(sticker.indexOf('upload/')!=-1){
										var substr = '/upload';
										var attachment = '/f_auto,fl_lossy,q_auto,h_100';
										var sticker = sticker.replace(substr, substr+attachment);
									}	
									var mockFile = { name: filename, size: 12345, href: stickerOrig, orig: stickerOrig };
									dz.displayExistingFile(mockFile, sticker, callback, "anonymous", resizeThumbnail);
									dz.files.push(mockFile);
								//	dz.emit("addedfile", mockFile);
								})
							} 
							else{
								sticker=stickers;
								//sticker=removeVersion(sticker);
								stickerOrig=sticker
								var filename = sticker.replace(/^.*[\\\/]/, '')
								if(sticker.indexOf('upload/')!=-1){
									var substr = '/upload';
									var attachment = '/f_auto,fl_lossy,q_auto,h_100';
									var sticker = sticker.replace(substr, substr+attachment);
								}	
								var mockFile = { name: filename, size: 12345, href: stickerOrig,  url: stickerOrig, orig: stickerOrig };
								dz.files.push(mockFile);
								dz.displayExistingFile(mockFile, sticker, callback, "anonymous", resizeThumbnail);
								//dz.emit("addedfile", mockFile);
							}
						}
					}
				}
			}
        });
    }) 
}

function previewThumbailFromUrl(opts) {  
	var dz = Dropzone.forElement("#" + opts.selector);
	var callback = null;
	var crossOrigin = true; 
	var resizeThumbnail = true; 
	var needsEdit = "no";
	
	if (opts.needsEdit=="yes"){
		needsEdit="yes"
		$(".cropper").show();
	}
	var mockFile = { name: opts.fileName, size: 12345, href: opts.imageURL,  url: opts.imageURL, orig: opts.imageURL,needsEdit: needsEdit,stateUID:opts.stateUID };
	dz.files.push(mockFile);
	dz.displayExistingFile(mockFile, opts.imageURL, callback, "anonymous", resizeThumbnail);
 // imgDropzone.emit("addedfile", mockFile);
 // imgDropzone.files.push(mockFile);
 // imgDropzone.createThumbnailFromUrl(mockFile, opts.imageURL, function() {
   // imgDropzone.emit("complete", mockFile);
 // }, "anonymous");
}
$(".dropzone").each(function () {
	$(this).sortable({
		items:'.dz-preview',
		cursor: 'move',
		opacity: 0.5,
		containment: $(this),
		distance: 20,
		tolerance: 'pointer',
		start: function(e, ui) { 
			$(this).removeClass('dz-clickable'); 
			ui.item.removeClass('dz-success') 
			
		}, 
		update: function(e, ui) { 
			//console.log('Item reordered!', ui.item); 
		},
		stop: function (evt, ui) {
			$(this).addClass('dz-clickable');
			var dropzone = $(this).get(0).dropzone;
			var queue = dropzone.files;
			//console.log(queue)
			newQueue=[];
			newFiles=[];
			$(this).find('.dz-preview .dz-filename [data-dz-name]').each(function (count, el) {           
				var name = el.innerHTML;
				//console.log(name)
			
				queue.forEach(function(file) {
				//console.log(file)
					if (file.name === name) {
						newQueue.push(file);
						
						//inew = 's3.amazonaws.com/virtualbooth.me';
						//iold = 'virtualbooth.imgix.net';
						filename=file.href
						//filename=filename.replace(iold,inew);
						newFiles.push(filename);
				   }
				})	
			})
			dropzone.files = newQueue;
			var str = newFiles.join("|");
			$("#frames").val(str);


		}	
	});
});
var whichEditor="";
var whichImage="";
var whichEvent="";
var whichClick=0;
var editStep=0;
var whichStateUID="";
var showPlaceholder=1; 
$(".dropzone").on("click", ".dz-edit-btn", function(event){
	whichEvent=$('#event-url').val();
	whichImage=$(this).data("path");
	whichStateUID=""
	whichStateUID=$(this).data("uid") 
	whichEditor=$(this).parent().parent().parent().attr("id")
	whichClick=$(this).index(".dz-edit-btn");
	editStep=1;
	showPlaceholder=1
	$.ajax({
			type: "POST",
			url: "app.php",
			data: { eventAction: "getState", uid:$("#accountUID").val(), url:whichImage, stateUID:whichStateUID},
			success: function(response){
				var jsonData = JSON.parse(response);
				if (jsonData.success == 1){
				pixie.resetEditor()
					if(jsonData.state=="" && jsonData.hasTransparency==0){
						if(whichEditor=="dz-frames"){
							showPlaceholder=1
							var iFrame = document.getElementById('cropperFrame');
							iFrame.contentWindow.postMessage({whichImage: whichImage, whichEvent: whichEvent,whichEditor: whichEditor, whichClick: whichClick, whichStateUID: whichStateUID, curDim: curDim, accountUID: $("#accountUID").val()});
							$('.cropper').show(); 
							$('.modal-backdrop').css('z-index','9999')
						}
						else{
							showPlaceholder=0
							pixie.openEditorWithImage(whichImage,true);
						}
						 
						//setTimeout(function() { 
						//	$('.global-spinner').hide();
						//	  }, 1000); 
						//pixie.openEditorWithImage(whichImage,true); 
					}
					else{
						showPlaceholder=0
						pixie.openEditorWithImage(whichImage,true);
						if(jsonData.state!=""){
							setTimeout(function() { 
								pixie.loadState(jsonData.state);
							  }, 500); 
						}
					}
				}
			}
	  })
      
})
$(".box").on("click", ".dz-single-edit-btn-gif", function(event){
	Swal.fire({
		  title:'User Input',
		  html:'Don\'t edit this text.<br><b><%Placeholder%></b> will be replaced<br>with the user\'s input',
		  icon:'warning'
	})
})
$(".box").on("click", ".dz-single-edit-btn", function(event){
	whichEvent=$('#event-url').val();
	whichImage=$(this).data("path")
	whichUID=$(this).data("uid") 
	whichEditor=$(this).parent().parent().attr("id")
	whichClick=$(this).index();
	editStep=1; 
	showPlaceholder=1
	whichStateUID=$(this).data("uid") 
	$.ajax({
			type: "POST",
			url: "app.php",
			data: { eventAction: "getState", uid:$("#accountUID").val(), url:whichImage, stateUID:whichUID},
			success: function(response){
				var jsonData = JSON.parse(response);
				if (jsonData.success == 1){
					pixie.resetEditor()
					if(jsonData.state=="" && jsonData.hasTransparency==0){
						if(whichEditor=="pz-frame"){
							showPlaceholder=1
							var iFrame = document.getElementById('cropperFrame');
							iFrame.contentWindow.postMessage({whichImage: whichImage, whichEvent: whichEvent,whichEditor: whichEditor, whichClick: whichClick, whichStateUID: whichStateUID, curDim: curDim, accountUID: $("#accountUID").val()});
							$('.cropper').show(); 
							$('.modal-backdrop').css('z-index','9999')
						}
						else{
							showPlaceholder=0
							pixie.openEditorWithImage(whichImage,true);
						}
						
					}
					else{
						showPlaceholder=0
						pixie.openEditorWithImage(whichImage,true);
						if(jsonData.state!=""){
							setTimeout(function() { 
								pixie.loadState(jsonData.state);	
							  }, 500); 
						}
					}
				}
			}
	  })
})
function reset(e) {
	var wrapperZone = e.parent();
    var removeZone = e.parent().parent().find('.box-header');
    var boxZone = e.parent().parent().find('.preview-zone').find('.box').find('.box-body');
	var fileField = e.parent().find('.fileField');
	
	wrapperZone.css('display','block');
	removeZone.css('display','none');
	fileField.val("");
	e.wrap('<form>').closest('form').get(0).reset();
	e.unwrap();
}
$('.dropzone-wrapper').click(function(){
	//$(this).dropzone({ url: "/file/post" });
})
 
$(".dropzoneSingle").change(function() {
  readFile(this);
});
 
$('.dropzone-wrapper').on('dragover', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).addClass('dragover');
});
 
$('.dropzone-wrapper').on('dragleave', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function() {
   var boxZone = $(this).parents('.preview-zone').find('.box-body');
   var previewZone = $(this).parents('.preview-zone');
   var drop = $(this).parents('.preview-zone').parent().find('.dropzoneSingle');
 
   boxZone.empty();
   previewZone.addClass('hidden');
   reset(drop);
   
   if ($(this).hasClass('remove-splash')){
		//$('#previewFrame').contents().find('#splashImg').attr('src','');
		$('#previewFrame').contents().find('#splashImg').attr("src","images/blank-square.png");
		//$('#previewFrame').contents().find('#splashImg').hide()
   }
   
   if ($(this).hasClass('remove-thanks')){
		//$('#previewFrame').contents().find('#thanksImg').attr('src','');
		$('#previewFrame').contents().find('#thanksImg').attr("src","images/blank-square.png");
		//$('#previewFrame').contents().find('#thanksImg').hide()
   }
  
  if ($(this).hasClass('remove-logo')){
		$('#previewFrame').contents().find('.logo').attr('src','');
		$('#previewFrame').contents().find('.logo').hide()
   }
  if ($(this).hasClass('remove-bgImage')){
		$('#previewFrame').contents().find('body').css('background-image','unset');

   }
});

function readFile(input) {
  var files   = input.files;
  var fileNames = "";
  function readAndPreview(file) {


    if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
      var reader = new FileReader();
		$('.global-spinner').css('display','flex');
      reader.addEventListener("load", function () {
       
      var htmlPreview =
        '<img width="150" src="' + this.result + '" />'

      var wrapperZone = $(input).parent();
      var previewZone = $(input).parent().parent().find('.preview-zone');
      var removeZone = $(input).parent().parent().find('.box-header');
	  
      var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');
	  if (boxZone.hasClass('bgImage')){
		  var imageType="bgImage";
	  }
	  else if (boxZone.hasClass('splash')){
		  var imageType="splash";
	  }
	  else if (boxZone.hasClass('thanks')){
		  var imageType="thanks";
	  }
	  else if (boxZone.hasClass('logo')){
		  var imageType="logo";
	  }
	  else if (boxZone.hasClass('frame')){
		  var imageType="frame";
	  }
	  var fileField = $(input).parent().find('.fileField');
      wrapperZone.removeClass('dragover');
      previewZone.removeClass('hidden');
	  removeZone.css('display','block');
	  boxZone.empty();
      boxZone.append(htmlPreview);
	  wrapperZone.css('display','none');
	
    var form = new FormData();
    form.append("file",this.result);
    form.append("curDim",curDim);
	form.append('eventAction', "assets");
	form.append('accountUID', $("#accountUID").val());
	form.append('imageType', imageType);
	form.append('eventURL', $("#event-url").val());

    var currentRequest = $.ajax({
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
		//xhr.setRequestHeader('Accept', 'multipart/form-data')
        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            var progress = parseInt(evt.loaded / evt.total * 100, 10);
            console.log(progress)
          }
        }, false);
        return xhr;
      },
      async: true,
      crossDomain: true,
      url: 'https://'+site+'/console/app.php',
      type: "POST",
      headers: {
        "cache-control": "no-cache"
      }, 
      processData: false,
      contentType: false,
      mimeType: "multipart/form-data",
      data: form,
      beforeSend: function () {
        if (currentRequest != null) {
          currentRequest.abort();
        }
      },
      success: function (data) {
        data=JSON.parse(data)
		fileField.val(data['secure_url']);
		$('#'+imageType+'-width').val(data['width']);
		$('#'+imageType+'-height').val(data['height']);
		var tButtons='<div class="dz-single-edit"><a class="dz-single-edit-btn" href="#" data-path="'+data['secure_url']+'" data-uid="'+data['uid']+'"><i class="fa fa-edit"></i></a></div> <div class="dz-single-download"><a class="dz-single-download-btn" href="'+data['secure_url']+'" target="_new" download><i class="fa fa-download"></i></a></div>'
		boxZone.append(tButtons);
		$('.global-spinner').css('display','none');
		if(data['secure_url'].indexOf('upload/')!=-1){ 
			var substr = '/upload';
			var attachment = '/f_auto,fl_lossy,q_auto,w_400';
			var attachment2 = '/f_auto,fl_lossy,q_auto,h_150';
			var tImg = data['secure_url'].replace(substr, substr+attachment);
			var tImg2 = data['secure_url'].replace(substr, substr+attachment2);
		}
		if(imageType=="frame" && data['hasTransparency']==0){
			$(".frame .dz-single-edit .dz-single-edit-btn").last().click();
		}
		
		if(imageType=="splash"){
			$("#pz-startImage").find('img').attr('src',tImg2)
		}
		else if(imageType=="thanks"){
			$("#pz-thanksImage").find('img').attr('src',tImg2)
		}
		if(imageType=="splash" || imageType=="thanks"){
			$('#previewFrame').contents().find('#'+imageType+"Img").attr("src",tImg);  
			$('#previewFrame').contents().find('#'+imageType+"Img").show();
			$('#previewFrame').contents().find('.splashImg').css('height','unset');
			$('#previewFrame').contents().find('.thanksImg').css('height','unset');
		}
		else if(imageType=="logo"){
			$('#previewFrame').contents().find('.logo').attr("src",tImg);  
			$('#previewFrame').contents().find('.logo').show();
			var pos= $('.logo-position').val();		
			if(pos=="bottom"){
				$('#previewFrame').contents().find('.logo-top').hide();
				$('#previewFrame').contents().find('.logo-mid').show(); 
				$('#previewFrame').contents().find('.logo-mid').css('position','relative');
				$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
					return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
				});
			} 
			else if(pos=="top"){
				$('#previewFrame').contents().find('.logo-top').show();
				$('#previewFrame').contents().find('.logo-mid').hide();
				$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
					return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
				});
				
			}
			else if(pos=="image-mid"){
				$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
					return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
				}); 
				$('#previewFrame').contents().find('.logo-top').css('display','none!important');
				$('#previewFrame').contents().find('.logo-mid').show();
				$('#previewFrame').contents().find('.logo-mid').addClass('align-items-center');
				$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
				$('#previewFrame').contents().find('.logo-mid').css('top','0');
				
				
			}
			else if(pos=="image-top"){
				$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
					return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
				});
				$('#previewFrame').contents().find('.logo-top').hide();
				$('#previewFrame').contents().find('.logo-mid').show();
				$('#previewFrame').contents().find('.logo-mid').addClass('align-items-start');
				$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
				$('#previewFrame').contents().find('.logo-mid').css('top','0');
				
				
			}
			else if(pos=="image-bottom"){
				$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
					return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
				});
				$('#previewFrame').contents().find('.logo-top').hide();
				$('#previewFrame').contents().find('.logo-mid').show();
				$('#previewFrame').contents().find('.logo-mid').addClass('align-items-end');
				$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
				$('#previewFrame').contents().find('.logo-mid').css('top','0');
				
				
			}
			else if(pos=="page-bottom"){
				$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
					return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
				});
				$('#previewFrame').contents().find('.logo-top').hide();
				$('#previewFrame').contents().find('.logo-mid').show();
				$('#previewFrame').contents().find('.logo-mid').addClass('align-items-end');
				$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
				$('#previewFrame').contents().find('.logo-mid').css('bottom','0');
				
				
			}
			else{
				$('#previewFrame').contents().find('.logo-mid').removeClass (function (index, className) {
					return (className.match (/(^|\s)align-\S+/g) || []).join(' ');
				});
				$('#previewFrame').contents().find('.logo-top').hide();
				$('#previewFrame').contents().find('.logo-mid').show();
				$('#previewFrame').contents().find('.logo-mid').css('position','absolute');
				$('#previewFrame').contents().find('.logo-mid').css('top','0');	
				
			}
			//$('.logo-position').trigger('change');
		//	$('.logo-position').selectpicker('toggle');
		}
		else if (imageType!="frame"){
			$("#pz-frame").find('img').attr('src',tImg2)
			$('#previewFrame').contents().find('body').css('background-image','url('+tImg+')');
		}
      },
      error: function (jqXHR, textStatus) {
       // console.log(jqXHR)
      }
    });
      }, false);

      reader.readAsDataURL(file);
    }

  }

  if (files) {
    [].forEach.call(files, readAndPreview);
  }

}

//Dropbox + Google

function dropboxConnected(t){
	$("#dropboxAlert").show();
	$("#dropboxAlert2").hide();
	$('#btn-dropbox').hide();
	$('#btn-dropbox-unlink').show();
	
	$.ajax({
			type: "POST",
			url: "includes/DropPHP/dropbox.php",
			data: { eventAction: "save", uid:$("#accountUID").val(), token:t},
			success: function(response){
				
			}
	  })
}

function googleConnected(t){
	$("#googleAlert").show();
	$("#googleAlert2").hide();
	$('#btn-google').hide();
	$('#btn-google-unlink').show();
	
	$.ajax({
			type: "POST",
			url: "includes/Google/google.php",
			data: { eventAction: "save", uid:$("#accountUID").val(), token:t},
			success: function(response){
				
			}
	  })
}

//Drag Frame
interact('.drag')
	.draggable({
		onmove: window.dragMoveListener
	})
	
	.on('resizemove', function (event) {
		var target = event.target,
			x = (parseFloat(target.getAttribute('data-x')) || 0),
			y = (parseFloat(target.getAttribute('data-y')) || 0);

		target.style.width = event.rect.width + 'px';
		target.style.height = event.rect.height + 'px';

		x += event.deltaRect.left;
		y += event.deltaRect.top;

		target.style.webkitTransform = target.style.transform ='translate(' + x + 'px,' + y + 'px)';

		target.setAttribute('data-x', x);
		target.setAttribute('data-y', y);
	});

function dragMoveListener(event) {
	var target = event.target,
	x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
	y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

	target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';

	target.setAttribute('data-x', x);
	target.setAttribute('data-y', y);
}

//// this is used later in the resizing and gesture demos
window.dragMoveListener = dragMoveListener;

function LightenDarkenColor(col, amt) {
  if (!col) { return }
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
	if (!rgb) { return }
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function removeVersion(url){
	//var uid=$("#accountUID").val();
	//var uidPos=url.indexOf(uid);
	//var uploadPos=url.indexOf("upload/");
	//if(uploadPos==-1){
	//	return url;
//}else{
	//var version = url.substring(uploadPos+7, uidPos);
	//var url = url.replace(version, "v1/");
	return url;
	//}
}


const jsform = document.querySelector('.js-form');
jsform.addEventListener('submit', handleSubmit);
const nextBtn = document.querySelector('.js-next');
const prevBtn = document.querySelector('.js-prev');
//let resultStats = document.querySelector('.js-result-stats');
//const spinner = document.querySelector('.js-spinner');
let totalResults;
let currentPage = 1;
let searchQuery;


nextBtn.addEventListener('click', () => {
	currentPage += 1;
	fetchResults(searchQuery);
});

prevBtn.addEventListener('click', () => {
	currentPage -= 1;
	fetchResults(searchQuery);
});

function pagination(totalPages) {
	//nextBtn.classList.remove('hidden');
	$(".js-next").show();
	if (currentPage >= totalPages) {
	$(".js-next").hide();
	//	nextBtn.classList.add('hidden');
	}

	prevBtn.classList.add('hidden');
	if (currentPage !== 1) {
		prevBtn.classList.remove('hidden');
	}
}

function fetchResults(searchQuery) {
	//spinner.classList.remove('hidden');
	//try {
	dim="portrait";
	if(curDim=="square"){
		dim="squarish";
	}
	$.ajax({
		type: "POST",
		url: "app.php",
		data: { eventAction: "searchPhotos", query:searchQuery, page:currentPage, per_page:50, orientation: dim},
		success: function(response){
			var jsonData = JSON.parse(response);
			if (jsonData.success == 1){
				var photos=JSON.parse(jsonData.photos);
				pagination(photos.total_pages);
				displayResults(photos);
			}
		}
	})
		
//} catch(err) {
	//	console.log(err);
		//alert('Failed to search Unsplash');
	//}
//	spinner.classList.add('hidden');
} 

function handleSubmit(event) {
$('.background-list').html("");
	event.preventDefault();
	currentPage = 1;
	const inputValue = document.querySelector('.js-search-input').value;
	searchQuery = inputValue.trim();
//	console.log(searchQuery);
	fetchResults(searchQuery);
} 


 
function displayResults(json) { 
	const searchResults = document.querySelector('.background-list');
	txt='';
	if(json.results){
		res=json.results;
	}
	else{
		res=json;
	}
	res.forEach(result => {
		var thumb = result.urls.raw + "&w=148&h=148&fit=crop"
		var bgURL = result.urls.raw + "&w=1920&h=1080&fit=crop"
		if(curDim=="portrait"){
			thumb = result.urls.raw + "&w=99&h=148&fit=crop"
}
		var url = result.urls.raw + "&w=1600&h=1600&fit=crop"
		if(curDim=="portrait"){
			url = result.urls.raw + "&w=1200&h=1800&fit=crop"
}
		const unsplashLink = result.links.download_location;
		const photographer = result.user.name;
		const photographerPage = result.user.links.html; 
		 
		txt+='<li class="lib2" style="height: 148px;position: relative;margin-bottom: 8px;overflow: hidden;border-radius: 4px;list-style: none;position: relative;margin-bottom: 8px;overflow: hidden;border-radius: 4px; margin-right: 7px;"><div class="lib-item" ><img height=148  class="lozad background-item" src="'+thumb+'" data-src="'+url+'" data-bgsrc="'+bgURL+'" data-type="backgrounds" data-link="'+unsplashLink+'"></div>';
});
	
	$('.background-list').append(txt);
	totalResults = json.total;

/*	
	<div>
				<a href="${unsplashLink}" target="_blank">
					<div class="result-item" style="width: 250px;height: 250px;padding: 5px;border-radius: 4px;background-image: url(${url});"></div>
				</a>
				<p class="photographer-name">
					<a href="${photographerPage}" target="_blank" style="color: black; text-decoration: none;">Photo by ${photographer}</a>
				</p>
			</div>
*/
};

const formStickers = document.querySelector('.js-formStickers');
formStickers.addEventListener('submit', handleSubmitStickers);
const nextBtnStickers = document.querySelector('.js-nextStickers');
const prevBtnStickers = document.querySelector('.js-prevStickers');

let totalResultsStickers;
let currentPageStickers = 1;
let searchQueryStickers;


nextBtnStickers.addEventListener('click', () => {
	currentPageStickers += 1;
	fetchResultsStickers(searchQueryStickers);
});

prevBtnStickers.addEventListener('click', () => {
	currentPageStickers -= 1;
	fetchResultsStickers(searchQueryStickers);
});

function paginationStickers(totalPagesStickers) {
	//nextBtnStickers.classList.remove('hidden');
	$(".js-nextStickers").show();
	if (currentPageStickers >= totalPagesStickers) {
	$(".js-nextStickers").hide();
	//	nextBtnStickers.classList.add('hidden');
	}

	prevBtnStickers.classList.add('hidden');
	if (currentPageStickers !== 1) {
		prevBtnStickers.classList.remove('hidden');
	} 
}
function fetchResultsStickers(searchQueryStickers) {	
	$.ajax({
		type: "POST",
		url: "app.php",
		data: { eventAction: "searchStickers", query:searchQueryStickers, page:currentPageStickers, per_page:24},
		success: function(response){
			var jsonData = JSON.parse(response);
			if (jsonData.success == 1){
			var photos=JSON.parse(jsonData.photos);
				if(photos.data.files_count>0){
				paginationStickers(photos.data.total_results/photos.data.files_count);
				}
				displayResultsStickers(photos);
			}
		}
	})
}  

function displayResultsStickers(json) { 
	const searchResults = document.querySelector('.stickers-list');
	txt='';
	if(json.data.files){
		res=json.data.files;
	}
	else{
		res=json;
	}
	res.forEach(result => {
		var thumb = result.thumbnails.small
		var img = result.thumbnails.medium
		txt+='<li class="lib2" style="height: 105px;position: relative;margin-bottom: 8px;overflow: hidden;list-style: none;position: relative;overflow: hidden;margin-right: 8px;"><div class="lib-item text-center" style="width:80px;margin-right:10px;margin-bottom:25px;" ><img  style="max-height:70px;max-width:80px;" class="lozad stickers-item" src="'+thumb+'" data-src="'+img+'" data-type="stickers" data-link=""></div>';
	});
	$('.stickers-list').append(txt); 
	//totalResultsStickers = json.total;
}
function handleSubmitStickers(event) {
$('#stickers-holder').html('<div class=""><div class="" data-num=""><ul class="stickers-list" style="padding-left:15px;width:325px;display:flex;flex-wrap: wrap;"></ul></div></div>');
	event.preventDefault();
	currentPageStickers = 1;
	const inputValue = document.querySelector('.js-search-inputStickers').value;
	searchQueryStickers = inputValue.trim();
//	console.log(searchQuery);
	fetchResultsStickers(searchQueryStickers);
} 


const formGifs = document.querySelector('.js-formGifs');
formGifs.addEventListener('submit', handleSubmitGifs);
const nextBtnGifs = document.querySelector('.js-nextGifs');
const prevBtnGifs = document.querySelector('.js-prevGifs');

let totalResultsGifs;
let currentPageGifs = 1;
let searchQueryGifs;


nextBtnGifs.addEventListener('click', () => {
	currentPageGifs += 1;
	fetchResultsGifs(searchQueryGifs);
});

prevBtnGifs.addEventListener('click', () => {
	currentPageGifs -= 1;
	fetchResultsGifs(searchQueryGifs);
});

function paginationGifs(totalPagesGifs) {
	//nextBtnGifs.classList.remove('hidden');
	$(".js-nextGifs").show();
	if (currentPageGifs >= totalPagesGifs) {
	$(".js-nextGifs").hide();
	//	nextBtnGifs.classList.add('hidden');
	}

	prevBtnGifs.classList.add('hidden');
	if (currentPageGifs !== 1) {
		prevBtnGifs.classList.remove('hidden');
	}
}
function fetchResultsGifs(searchQueryGifs) {	
	$.ajax({
		type: "POST",
		url: "app.php",
		data: { eventAction: "searchGifs", query:searchQueryGifs, page:currentPageGifs, per_page:24},
		success: function(response){
			var jsonData = JSON.parse(response);
			if (jsonData.success == 1){
			var photos=JSON.parse(jsonData.photos);
			if(photos.pagination){
				if(photos.pagination.count>0){
					paginationGifs(photos.pagination.total_count/photos.pagination.count);
				}
			}
				displayResultsGifs(photos);
			}
		}
	})
}  

function displayResultsGifs(json) { 
	const searchResults = document.querySelector('.gif-list');
	txt='';

	res=json.data;
	if(res.length){
		res.forEach(result => {
			var thumb = result.images.fixed_height.url;
			var img = result.images.original.url
			
			
			txt+='<li class="lib2" style="height: 105px;position: relative;margin-bottom: 8px;overflow: hidden;list-style: none;position: relative;overflow: hidden;margin-right: 8px;"><div class="lib-item text-center" style="width:80px;margin-right:10px;margin-bottom:25px;" ><img  style="max-height:70px;max-width:80px;" class="lozad gif-item" src="'+thumb+'" data-src="'+img+'" data-type="gif" data-link=""></div>';
		});
	}
	else{
		var thumb = res.images.fixed_height.url;
		var img = res.images.original.url
		
		
		txt+='<li class="lib2" style="height: 105px;position: relative;margin-bottom: 8px;overflow: hidden;list-style: none;position: relative;overflow: hidden;margin-right: 8px;"><div class="lib-item text-center" style="width:80px;margin-right:10px;margin-bottom:25px;" ><img  style="max-height:70px;max-width:80px;" class="lozad gif-item" src="'+thumb+'" data-src="'+img+'" data-type="gif" data-link=""></div>';

	}
	$('.gif-list').append(txt); 
	//totalResultsGifs = json.total;

}
function handleSubmitGifs(event) {
$('#gifs-holder').html('<div class=""><div class="" data-num=""><ul class="gif-list" style="padding-left:15px;width:325px;display:flex;flex-wrap: wrap;"></ul></div></div>');
	event.preventDefault();
	currentPageGifs = 1;
	const inputValue = document.querySelector('.js-search-inputGifs').value;
	searchQueryGifs = inputValue.trim();
//	console.log(searchQuery);
	fetchResultsGifs(searchQueryGifs);
} 
var oldControls
function resetControls(){
	$(".text-styles").remove()
}
function showTextStyles(){
oldControls=$("editor-controls").html();
$("editor-controls").append('<div class="text-styles tool-panel-container ng-tns-c122-2 ng-star-inserted"><a href="#" onClick="resetControls()"><button type="button" mat-raised-button="" trans="" class="mat-focus-indicator cancel-button ng-tns-c122-2 mat-raised-button mat-button-base"><span class="mat-button-wrapper"><span trans="" class="ng-tns-c122-2 ng-star-inserted">Close</span><!----><!----></span><div matripple="" class="mat-ripple mat-button-ripple"></div><div class="mat-button-focus-overlay"></div></button></a><div customscrollbar="" style="z-index:9;" class="drawer-wrapper ng-tns-c122-2 scroll-container-x"><!----><!----><!----><!----><!----><!----><!----><stickers-drawer class="controls-drawer ng-tns-c122-2 ng-trigger ng-trigger-controlsAnimation ng-star-inserted" style=""><div style="background: #FFFFFF;" class="tool-panel-content ng-star-inserted" style=""><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(1)"><img src="/console/images/font1.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(2)"><img src="/console/images/font2.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(3)"><img src="/console/images/font3.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(4)"><img src="/console/images/font4.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(5)"><img src="/console/images/font5.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(6)"><img src="/console/images/font6.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(7)"><img src="/console/images/font7.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(8)"><img src="/console/images/font8.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(9)"><img src="/console/images/font9.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(10)"><img src="/console/images/font10.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(11)"><img src="/console/images/font11.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(12)"><img src="/console/images/font12.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(13)"><img src="/console/images/font13.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(14)"><img src="/console/images/font14.png" style="width:80px;height:80px;"></a></div><div class="category button-with-image ng-star-inserted"><a href="#" onClick="fontCombo(15)"><img src="/console/images/font15.png" style="width:80px;height:80px;"></a></div><!----></div><!----><!----></stickers-drawer><!----><!----><!----><!----><!----><!----></div><a href="#" onClick="resetControls()"><button type="button" mat-raised-button="" color="accent" trans="" class="mat-focus-indicator apply-button ng-tns-c122-2 mat-raised-button mat-button-base mat-accent"><span class="mat-button-wrapper">Apply</span><div matripple="" class="mat-ripple mat-button-ripple"></div><div class="mat-button-focus-overlay"></div></button></a></div>')
}
  
 
var pixieFileName
    var pixie = new Pixie({
		crossOrigin: true,
		baseUrl: 'https://app.virtualbooth.me/console/includes/Editor',
		googleFontsApiKey: 'AIzaSyAcZ7-GSoJKH5bAlL07hzCS4ZKYGhmi7sk',
		objectControls: {
			shape: {
				unlockAspectRatio: true
			}
		},
		ui: {
			visible: false, 
			mode: 'overlay',
			defaultTheme: 'light',
			 toolbar: {
			 replaceDefaultLeftItems: true,
			 replaceDefaultRightItems: true,
				leftItems: [
				   
					{
						type: 'button',
						icon: 'file-download',
						text: 'Save',
						action: 'exportImage',
					}
				],
				rightItems: [
					{
						type: 'undoWidget'
					},
					{
						type: 'button',
						icon: 'history',
						action: 'toggleHistory',
						marginLeft: '40px',
					},
					{
						type: 'button',
						icon: 'layers',
						action: 'toggleObjects',
					},
					{
						type: 'button',
						icon: 'close',
						action: 'closeEditor',
						marginLeft: '25px',
						condition: {'ui.mode': 'overlay'},
					}
				]
			},
 
			nav: {
				position: 'top',
				replaceDefault: true,
				
				items: [ 	
				 	
					{name: 'text', icon: 'text-box-custom', action: 'text'},	
					{name: 'font combos', icon: '/console/images/font-combo.png', type: 'button', action: function() {showTextStyles();}},	
					{name: 'User Input', icon: '/console/images/usertext.png', type: 'button', action: function() {
                     pixie.getTool('text').add('<%Placeholder%>');Swal.fire({
							  title:'User Input',
							  html:'Don\'t edit this text.<br><b><%Placeholder%></b> will be replaced<br>with the user\'s input',
							  icon:'warning'
					 });$('.swal2-container').css('z-index','99999')}},	
					{name: 'elements', icon: '/console/images/elements.png', action: 'stickers'},
					{name: 'shapes', icon: 'text-box-custom', action: 'shapes'},
					{name: 'uploads',  icon: '/console/images/add_picture.png', type: 'button', action: function() {
                    pixie.getTool('import').openUploadDialog();}},
					{name: 'stickers',  icon: '/console/includes/Editor/assets/images/ui/smilie.png', type: 'button', action: function() {
						if(parseInt($("#assetNav").css('z-index'))!=99999){
                    $(".iconbar").hide();$("#closeStickers").show();$("#LeftSideNav").css('top','185px');$("#LeftSideNav").css('left','20px');$("#nb_mm .closebtn").hide();$("#v-pills-frames").removeClass('active');$("#v-pills-frames").removeClass('show');$("#v-pills-backgrounds").removeClass('active');$("#v-pills-backgrounds").removeClass('show');$("#v-pills-gifs").removeClass('active');$("#v-pills-gifs").removeClass('show');$("#v-pills-stickers").addClass('active');$("#v-pills-stickers").addClass('show');stickersInEditor=1;setTimeout(function(){$("#assetNav").css('z-index','99999')},500)}else{$("#assetNav").css('z-index','9999')}}}
					]
			}
		},
		
		tools: {
			
			 
			 stickers: {
				replaceDefault: true,
				items: [ 
					{
						name: 'placeholders',
						items: 1, 
						type: 'png',
						thumbnailUrl: 'images/ui/arrows.svg'
					},
					{
						name: 'arrows',
						items: 20, 
						type: 'svg',
						thumbnailUrl: 'images/ui/arrows.svg'
					},
					{
						name: 'bubbles',
						items: 105, 
						type: 'png',
						thumbnailUrl: 'images/ui/bubbles.png'
					},
					
					{
						name: 'dividers',
						items: 70, 
						type: 'svg',
						thumbnailUrl: 'images/ui/dividers.svg'
					},
					{
						name: 'flourishes',
						items: 63,  
						type: 'svg',
						thumbnailUrl: 'images/ui/flourishes.svg'
					},
					{
						name: 'ribbons',
						items: 18, 
						type: 'svg',
						thumbnailUrl: 'images/ui/ribbons.svg'
					},
					
					{
						name: 'valentines', 
						items: 42,  
						type: 'svg',
						thumbnailUrl: 'images/ui/valentines.svg'
					},
					{ 
						name: 'wedding',
						items: 31, 
						type: 'svg',
						thumbnailUrl: 'images/ui/wedding.svg'
					}
				]
			},
			text: {
				replaceDefault: false,
				defaultCategory: 'display',
				items: [
					{
						family: 'Playlist',
						category: 'handwriting',
						filePath: 'Playlist-Script.ttf', 
						type: 'custom' 
					},{
						family: 'Hussar Ekologiczny',
						category: 'display',
						filePath: 'hussar-ekologiczne-1.otf', 
						type: 'custom' 
					},{
						family: 'Nickainley',
						category: 'handwriting',
						filePath: 'Nickainley-Normal.otf', 
						type: 'custom' 
					},{
						family: 'Barlow Bold',
						category: 'sans-serif',
						filePath: 'Barlow-Bold.ttf', 
						type: 'custom' 
					},{
						family: 'Sensei',
						category: 'display',
						filePath: 'Sensei-Medium.ttf', 
						type: 'custom' 
					},{
						family: 'Amatic SC Bold',
						category: 'display',
						filePath: 'AmaticSC-Bold.ttf', 
						type: 'custom' 
					},{
						family: 'Brusher',
						category: 'handwriting',
						filePath: 'Brusher.ttf', 
						type: 'custom' 
					},{
						family: 'Bukhari Script',
						category: 'handwriting',
						filePath: 'Bukhari Script.ttf', 
						type: 'custom' 
					},{
						family: 'Moontime',
						category: 'handwriting',
						filePath: 'MoonTime-Regular.ttf', 
						type: 'custom' 
					},{
						family: 'League Spartan',
						category: 'sans-serif',
						filePath: 'LeagueSpartan-Bold.otf',  
						type: 'custom' 
					}
				]
			}
		},
 
        onClose: function(data, name) { 
		   $("#v-pills-stickers").removeClass('active');$("#v-pills-stickers").removeClass('show');$("#closeStickers").hide();$(".iconbar").show();$("#LeftSideNav").css('top','0');$("#LeftSideNav").css('left','72px');$("#nb_mm .closebtn").show();setTimeout(function(){$("#assetNav").css('z-index','9999')},500);stickersInEditor=0;
		   if(whichEditor=="dz-frames"){
				$("#frames-btn").click(); 
			}
		},
		
		onSave: function(data, name) {
		
		var state = pixie.getState();
		var action="editAsset";
		if (editStep==2 || showPlaceholder==0){
			action="editAssetOrig";
		}
			$.ajax({
				type: "POST",
				url: '/console/app.php',
				data: { file: data, eventAction: action,accountUID: $("#accountUID").val(), name: whichImage, whichEditor: whichEditor, whichEvent: whichEvent,state:state,editStep:editStep,whichStateUID:whichStateUID,curDim:curDim },
				success: function(response){
					var jsonData = JSON.parse(response);
					if (jsonData.success == 1){
						if(jsonData.editStep==1){
							editStep=2;
							whichStateUID=jsonData.uid;
							 pixie.loadState(jsonData.state).then(function(){
								$(".mat-button").click();
							 })  
							 
							// setTimeout(function() { $(".mat-button").click();},1000)
							//setTimeout(function() { pixie.get(â€˜exportâ€™).export();},2000)
						}
						else{
							pixie.close();
							var newURL=jsonData.secure_url;
							whichStateUID=jsonData.uid;
							var filename=removeVersion(newURL)
							var newThumb=removeVersion(newURL)
							filename = newThumb.replace(/^.*[\\\/]/, '')
							var substr = '/upload';
							var attachment = '/f_auto,fl_lossy,q_auto,h_100';
							var newThumb = newThumb.replace(substr, substr+attachment);
							var rnd=Math.floor(Math.random() * 100000) + 1;
							$('img[alt="'+filename+'"]').attr('src',newThumb+"?q="+rnd)
							
							if(whichEditor.indexOf('pz-')!=-1){
								$("#"+whichEditor).find('img').attr('src',newURL);
								$("#"+whichEditor).find('.dz-single-edit-btn').data("path",newURL);
								$("#"+whichEditor).find('.dz-single-edit-btn').data("uid",whichStateUID);
								whichEditor=whichEditor.substring(3);
								$("#"+whichEditor).val(newURL);
								
								if(whichEditor=="startImage"){	
									$('#previewFrame').contents().find('#splashImg').attr("src",newURL);  
									$('#previewFrame').contents().find('#splashImg').show();
									$('#previewFrame').contents().find('.splashImg').css('height','unset');
								}
								else if(whichEditor=="thanksImage"){	
									$('#previewFrame').contents().find('#thanksImg').attr("src",newURL);  
									$('#previewFrame').contents().find('#thanksImg').show();
									$('#previewFrame').contents().find('.thanksImg').css('height','unset');
									$('#previewFrame').contents().find('.thanksImg').css('height','unset');
								}
								else if(whichEditor=="logoImage"){
									$('#previewFrame').contents().find('.logo').attr("src",newURL);  
									$('#previewFrame').contents().find('.logo').show();
									//$('.logo-position').selectpicker('val', 'image-mid');		
									//$('.logo-position').trigger('change');
								//	$('.logo-position').selectpicker('toggle');
								}
								else{
									
									$('#previewFrame').contents().find('body').css('background-image','url('+newURL+')');
								}
							}
							else{
								Dropzone.instances.forEach(function(item,index){
									var myID=$($(item)[0].element).attr('id').trim();
									if (myID==whichEditor){
										var files=$(item)[0].files;
										files.forEach(function(file,findex){
											if (file.href==whichImage){
												file.previewElement.href = newURL;
												file.href =newURL;
												var substr = '/upload';
												var attachment = '/f_auto,fl_lossy,q_auto,h_100';
												var newSrc = newURL.replace(substr, substr+attachment);
												$('.dz-edit').eq(whichClick).parent().find('img').attr('src',newSrc)
												$('.dz-edit-btn').eq(whichClick).data("path",newURL)
												$('.dz-edit-btn').eq(whichClick).data("uid",whichStateUID)
												$('.dz-download-btn').eq(whichClick).attr("href",newURL)
												$('.dz-download-btn').eq(whichClick).data("path",newURL)
												
												
											}
										});
									}
								})
							}
						}
					}	
				}
			
			})
			
			
                  $("#v-pills-frames").addClass('active');$("#v-pills-frames").addClass('show'); $("#v-pills-stickers").removeClass('active');$("#v-pills-stickers").removeClass('show');$("#closeStickers").hide();$(".iconbar").show();$("#LeftSideNav").css('top','0');$("#LeftSideNav").css('left','72px');$("#nb_mm .closebtn").show();$("#frames-btn").click();setTimeout(function(){$("#assetNav").css('z-index','9999')},500);stickersInEditor=0;
		}, 
		onMainImageLoaded: function(file){
			pixieFileName=whichImage;
			if(editStep==1 && showPlaceholder==1){
				
				var mainImage = file; 
				//pixie.getTool('shapes').addBasicShape('rectangle');
				pixie.getTool('shapes').addSticker('placeholders', 0);
				var activeObject = pixie.get('activeObject');
				  
				var x=(mainImage.width-1000)/2;
				var y=(mainImage.height-1000)/2;
				setTimeout(function(){activeObject.setValues({
					// fill: '#000000',
					opacity: 1,
					width: 1000,
					height:1000,
					scaleX:1,
					scaleY:1,
					left:x,
					top:y,
					lockUniScaling: false,
					hasRotatingPoint: false,
					name:'placeholder'
				});},500)
			}
			setTimeout(function(){$('.name:contains("text")').css("padding-left:5px;");$('.name:contains("elements")').css("padding-left:5px;");$('.name:contains("upload")').css("padding-left:5px;")},500);$('.bottom-label:contains("Placeholders")').parent().hide();
			if (whichEditor!="dz-frames"){
				setTimeout(function(){$('.name:contains("User Input")').parent().hide();},500);
				 
			}
			else{
				$('.name:contains("User Input")').parent().show();
			}
			
			
// Select the node that will be observed for mutations
const targetNode = document.querySelector('editor-controls');

// Options for the observer (which mutations to observe)
const config = { attributes: true, childList: true, subtree: true };

// Callback function to execute when mutations are observed
const callback = function(mutationsList, observer2) {

   setTimeout(function(){$('.bottom-label:contains("Texture")').parent().hide();$('.bottom-label:contains("Gradient")').parent().hide();$('.bottom-label:contains("Background")').parent().hide();$('.bottom-label:contains("placeholders")').parent().hide();$('.bottom-label:contains("arrows")').parent().css("margin-left","auto")},1);
};

// Create an observer instance linked to the callback function
const observer2 = new MutationObserver(callback);

// Start observing the target node for configured mutations
observer2.observe(targetNode, config); 
		},
		onLoad: function() {
			pixie.get('canvas').on('object:selected', function(e) {
			resetControls();
			var activeObject = pixie.get('activeObject');
				 if(activeObject.getValue('name')=="placeholder"){
					setTimeout(function(){ $('.bottom-label:contains("Texture")').parent().hide();$('.bottom-label:contains("Gradient")').parent().hide();$('.bottom-label:contains("Background")').parent().hide();$('.bottom-label:contains("Opacity")').parent().hide();$('.bottom-label:contains("Replace")').parent().hide();$('.bottom-label:contains("Shadow")').parent().hide();$('.bottom-label:contains("Color")').parent().hide();$('floating-object-controls').hide();$('.bottom-label:contains("Outline")').parent().css('margin-right','auto');$('.bottom-label:contains("Outline")').parent().css('margin-left','auto');}, 500);	 
				 }
				 else {
					setTimeout(function(){ $('.bottom-label:contains("Texture")').parent().hide();$('.bottom-label:contains("Gradient")').parent().hide();$('.bottom-label:contains("Background")').parent().hide();$('floating-object-controls').show();}, 500);	 
				 }
			
				$('.mat-button-wrapper:contains("Apply")').parent().on('click',function(){
					setTimeout(function(){ $('.bottom-label:contains("Texture")').parent().hide();$('.bottom-label:contains("Gradient")').parent().hide();$('.bottom-label:contains("Background")').parent().hide();}, 500);	
				})
				
				
			})
			
		}
        
    });
	window.addEventListener("message", (event) => {
		if (event.data.pAction=="close"){
			setTimeout(function(){$('.cropper').hide();$('.modal-backdrop').css('z-index','1')},500)
			if(event.data.pShowSpinner){
				$('.global-spinner').css('display','flex');
			}
		}
		else if (event.data.pAction=="load"){
			$('.global-spinner').css('display','none');
			newURL=event.data.pURL;
			var filename=removeVersion(newURL)
			var newThumb=filename
			
			filename = newThumb.replace(/^.*[\\\/]/, '')
			var substr = '/upload';
			var attachment = '/f_auto,fl_lossy,q_auto,h_100';
			var newThumb = newThumb.replace(substr, substr+attachment);
			var rnd=Math.floor(Math.random() * 100000) + 1;
			
			$('img[alt="'+filename+'"]').attr('src',newThumb+"?q="+rnd)
								
			if(whichEditor.indexOf('pz-')!=-1){
				$("#"+whichEditor).find('img').attr('src',newURL);
				$("#"+whichEditor).find('.dz-single-edit-btn').data("path",newURL);
				whichEditor=whichEditor.substring(3);
				$("#"+whichEditor).val(newURL);
				
				if(whichEditor=="startImage"){	
					$('#previewFrame').contents().find('#splashImg').attr("src",newURL);  
					$('#previewFrame').contents().find('#splashImg').show();
					$('#previewFrame').contents().find('.splashImg').css('height','unset');
				}
				else if(whichEditor=="thanksImage"){	
					$('#previewFrame').contents().find('#thanksImg').attr("src",newURL);  
					$('#previewFrame').contents().find('#thanksImg').show();
					$('#previewFrame').contents().find('.thanksImg').css('height','unset');
					$('#previewFrame').contents().find('.thanksImg').css('height','unset');
				}
				else if(whichEditor=="logoImage"){
					$('#previewFrame').contents().find('.logo').attr("src",newURL);  
					$('#previewFrame').contents().find('.logo').show();
					//$('.logo-position').selectpicker('val', 'image-mid');		
					//$('.logo-position').trigger('change');
				//	$('.logo-position').selectpicker('toggle');
				}
				else{
					
					$('#previewFrame').contents().find('body').css('background-image','url('+newURL+')');
				}
			}
			else{
				Dropzone.instances.forEach(function(item,index){
					var myID=$($(item)[0].element).attr('id').trim();
					if (myID==whichEditor){
						var files=$(item)[0].files;
						files.forEach(function(file,findex){
							if (file.href==whichImage){
								file.previewElement.href = newURL;
								file.href =newURL;
								var substr = '/upload';
								var attachment = '/f_auto,fl_lossy,q_auto,h_100';
								var newSrc = newURL.replace(substr, substr+attachment);
								$('.dz-edit').eq(whichClick).parent().find('img').attr('src',newSrc)
								$('.dz-edit-btn').eq(whichClick).data("path",newURL)
								$('.dz-download-btn').eq(whichClick).attr("href",newURL)
								$('.dz-download-btn').eq(whichClick).data("path",newURL)
								
								
							}
						});
					}
				}) 
			}
		}
	})
	
	
function openNav(para,y) {
	if (para == 'left' && screen.width <= 767) {
		$(".sidenav").css('width',"83%");
	}
   else if(para == 'left'){
      $(".sidenav").css('width',"340px");
    }
	$('.sideslider').css('transform','translateY('+y*80+'px)');
	 setTimeout(function(){ $(".closebtn").show();}, 500);
	 $('.scroll-content').css('transform', 'translate3d(0px, 0px, 0px)');
	 
	 if (y==4){
		 $("#gifSearch").click();
	 }
}

function closeNav(para) {
	$(".sidenav").css('width',"0px");
    $(".closebtn").hide();
}

$("#v-pills-home-tab, #v-pills-profile-tab, #v-pills-messages-tab, #v-pills-settings-tab, #v-pills-Services-tab, #v-pills-Contact-tab").on("click",function(){
   $(".text-bar").removeClass("d-none");
	document.getElementById("LeftSideNav").style.width = "330px";
   setTimeout(function(){ $(".closebtn").show();}, 500);
   
});


var presets=['linear-gradient(135deg, rgb(30, 87, 153) 0%, rgb(41, 137, 216) 50%, rgb(32, 124, 202) 51%, rgb(125, 185, 232) 100%)',
'linear-gradient(135deg, rgb(76, 76, 76) 0%, rgb(89, 89, 89) 12%, rgb(102, 102, 102) 25%, rgb(71, 71, 71) 39%, rgb(44, 44, 44) 50%, rgb(0, 0, 0) 51%, rgb(17, 17, 17) 60%, rgb(43, 43, 43) 76%, rgb(28, 28, 28) 91%, rgb(19, 19, 19) 100%)',
'linear-gradient(135deg, rgb(135, 224, 253) 0%, rgb(83, 203, 241) 40%, rgb(5, 171, 224) 100%)',
'linear-gradient(135deg, rgb(240, 249, 255) 0%, rgb(203, 235, 255) 47%, rgb(161, 219, 255) 100%)',
'linear-gradient(135deg, rgb(122, 188, 255) 0%, rgb(96, 171, 248) 44%, rgb(64, 150, 238) 100%)',
'linear-gradient(135deg, rgb(30, 87, 153) 0%, rgba(125, 185, 232, 0) 100%)',
'linear-gradient(135deg, rgb(30, 87, 153) 0%, rgb(89, 148, 202) 62%, rgba(95, 154, 207, 0.7) 68%, rgba(125, 185, 232, 0) 100%)',
'linear-gradient(135deg, rgba(30, 87, 153, 0) 0%, rgba(30, 87, 153, 0.8) 15%, rgb(30, 87, 153) 19%, rgb(30, 87, 153) 20%, rgb(41, 137, 216) 50%, rgb(30, 87, 153) 80%, rgb(30, 87, 153) 81%, rgba(30, 87, 153, 0.8) 85%, rgba(30, 87, 153, 0) 100%)',
'linear-gradient(135deg, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 100%)',
'linear-gradient(135deg, rgb(255, 255, 255) 0%, rgba(255, 255, 255, 0) 100%)',
'linear-gradient(135deg, rgb(0, 183, 234) 0%, rgb(0, 158, 195) 100%)',
'linear-gradient(135deg, rgb(136, 191, 232) 0%, rgb(112, 176, 224) 100%)',
'linear-gradient(135deg, rgb(254, 255, 255) 0%, rgb(221, 241, 249) 35%, rgb(160, 216, 239) 100%)',
'linear-gradient(135deg, rgb(37, 141, 200) 0%, rgb(37, 141, 200) 100%)',
'linear-gradient(135deg, rgb(64, 150, 238) 0%, rgb(64, 150, 238) 100%)',
'linear-gradient(135deg, rgb(184, 225, 252) 0%, rgb(169, 210, 243) 10%, rgb(144, 186, 228) 25%, rgb(144, 188, 234) 37%, rgb(144, 191, 240) 50%, rgb(107, 168, 229) 51%, rgb(162, 218, 245) 83%, rgb(189, 243, 253) 100%)',
'linear-gradient(135deg, rgb(59, 103, 158) 0%, rgb(43, 136, 217) 50%, rgb(32, 124, 202) 51%, rgb(125, 185, 232) 100%)',
'linear-gradient(135deg, rgb(109, 179, 242) 0%, rgb(84, 163, 238) 50%, rgb(54, 144, 240) 51%, rgb(30, 105, 222) 100%)',
'linear-gradient(135deg, rgb(235, 241, 246) 0%, rgb(171, 211, 238) 50%, rgb(137, 195, 235) 51%, rgb(213, 235, 251) 100%)',
'linear-gradient(135deg, rgb(228, 245, 252) 0%, rgb(191, 232, 249) 50%, rgb(159, 216, 239) 51%, rgb(42, 176, 237) 100%)',
'linear-gradient(135deg, rgb(206, 219, 233) 0%, rgb(170, 197, 222) 17%, rgb(97, 153, 199) 50%, rgb(58, 132, 195) 51%, rgb(65, 154, 214) 59%, rgb(75, 184, 240) 71%, rgb(58, 139, 194) 84%, rgb(38, 85, 139) 100%)',
'linear-gradient(135deg, rgb(167, 199, 220) 0%, rgb(133, 178, 211) 100%)',
'linear-gradient(135deg, rgb(63, 76, 107) 0%, rgb(63, 76, 107) 100%)',
'linear-gradient(135deg, rgb(208, 228, 247) 0%, rgb(115, 177, 231) 24%, rgb(10, 119, 213) 50%, rgb(83, 159, 225) 79%, rgb(135, 188, 234) 100%)',
'linear-gradient(135deg, rgb(225, 255, 255) 0%, rgb(225, 255, 255) 7%, rgb(253, 255, 255) 12%, rgb(230, 248, 253) 30%, rgb(200, 238, 251) 54%, rgb(190, 228, 248) 75%, rgb(177, 216, 245) 100%)',
'linear-gradient(135deg, rgb(179, 220, 237) 0%, rgb(41, 184, 229) 50%, rgb(188, 224, 238) 100%)',
'linear-gradient(135deg, rgb(213, 206, 166) 0%, rgb(201, 193, 144) 40%, rgb(183, 173, 112) 100%)',
'linear-gradient(135deg, rgb(240, 183, 161) 0%, rgb(140, 51, 16) 50%, rgb(117, 34, 1) 51%, rgb(191, 110, 78) 100%)',
'linear-gradient(135deg, rgb(169, 3, 41) 0%, rgb(143, 2, 34) 44%, rgb(109, 0, 25) 100%)',
'linear-gradient(135deg, rgb(254, 252, 234) 0%, rgb(241, 218, 54) 100%)',
'linear-gradient(135deg, rgb(180, 221, 180) 0%, rgb(131, 199, 131) 17%, rgb(82, 177, 82) 33%, rgb(0, 138, 0) 67%, rgb(0, 87, 0) 83%, rgb(0, 36, 0) 100%)',
'linear-gradient(135deg, rgb(205, 235, 142) 0%, rgb(165, 201, 86) 100%)',
'linear-gradient(135deg, rgb(201, 222, 150) 0%, rgb(138, 182, 107) 44%, rgb(57, 130, 53) 100%)',
'linear-gradient(135deg, rgb(248, 255, 232) 0%, rgb(227, 245, 171) 33%, rgb(183, 223, 45) 100%)',
'linear-gradient(135deg, rgb(169, 219, 128) 0%, rgb(150, 197, 111) 100%)',
'linear-gradient(135deg, rgb(180, 227, 145) 0%, rgb(97, 196, 25) 50%, rgb(180, 227, 145) 100%)',
'linear-gradient(135deg, rgb(41, 154, 11) 0%, rgb(41, 154, 11) 100%)',
'linear-gradient(135deg, rgb(143, 200, 0) 0%, rgb(143, 200, 0) 100%)',
'linear-gradient(135deg, rgb(0, 110, 46) 0%, rgb(0, 110, 46) 100%)',
'linear-gradient(135deg, rgb(107, 186, 112) 0%, rgb(107, 186, 112) 100%)',
'linear-gradient(135deg, rgb(205, 235, 139) 0%, rgb(205, 235, 139) 100%)',
'linear-gradient(135deg, rgb(143, 196, 0) 0%, rgb(143, 196, 0) 100%)',
'linear-gradient(135deg, rgb(182, 224, 38) 0%, rgb(171, 220, 40) 100%)',
'linear-gradient(135deg, rgb(157, 213, 58) 0%, rgb(161, 213, 79) 50%, rgb(128, 194, 23) 51%, rgb(124, 188, 10) 100%)',
'linear-gradient(135deg, rgb(230, 240, 163) 0%, rgb(210, 230, 56) 50%, rgb(195, 216, 37) 51%, rgb(219, 240, 67) 100%)',
'linear-gradient(135deg, rgb(191, 210, 85) 0%, rgb(142, 185, 42) 50%, rgb(114, 170, 0) 51%, rgb(158, 203, 45) 100%)',
'linear-gradient(135deg, rgb(180, 223, 91) 0%, rgb(180, 223, 91) 100%)',
'linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(204, 204, 204) 100%)',
'linear-gradient(135deg, rgb(206, 220, 231) 0%, rgb(89, 106, 114) 100%)',
'linear-gradient(135deg, rgb(96, 108, 136) 0%, rgb(63, 76, 107) 100%)',
'linear-gradient(135deg, rgb(176, 212, 227) 0%, rgb(136, 186, 207) 100%)',
'linear-gradient(135deg, rgb(242, 245, 246) 0%, rgb(227, 234, 237) 37%, rgb(200, 215, 220) 100%)',
'linear-gradient(135deg, rgb(216, 224, 222) 0%, rgb(174, 191, 188) 22%, rgb(153, 175, 171) 33%, rgb(142, 166, 162) 50%, rgb(130, 157, 152) 67%, rgb(78, 92, 90) 82%, rgb(14, 14, 14) 100%)',
'linear-gradient(135deg, rgb(181, 189, 200) 0%, rgb(130, 140, 149) 36%, rgb(40, 52, 59) 100%)',
'linear-gradient(135deg, rgb(184, 198, 223) 0%, rgb(109, 136, 183) 100%)',
'linear-gradient(135deg, rgb(207, 231, 250) 0%, rgb(99, 147, 193) 100%)',
'linear-gradient(135deg, rgb(210, 223, 237) 0%, rgb(200, 215, 235) 26%, rgb(166, 192, 227) 51%, rgb(175, 199, 232) 62%, rgb(186, 208, 239) 75%, rgb(153, 181, 219) 88%, rgb(121, 155, 200) 100%)',
'linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(238, 238, 238) 100%)',
'linear-gradient(135deg, rgb(226, 226, 226) 0%, rgb(219, 219, 219) 50%, rgb(209, 209, 209) 51%, rgb(254, 254, 254) 100%)',
'linear-gradient(135deg, rgb(242, 246, 248) 0%, rgb(216, 225, 231) 50%, rgb(181, 198, 208) 51%, rgb(224, 239, 249) 100%)',
'linear-gradient(135deg, rgb(212, 228, 239) 0%, rgb(134, 174, 204) 100%)',
'linear-gradient(135deg, rgb(245, 246, 246) 0%, rgb(219, 220, 226) 21%, rgb(184, 186, 198) 49%, rgb(221, 223, 227) 80%, rgb(245, 246, 246) 100%)',
'linear-gradient(135deg, rgb(243, 226, 199) 0%, rgb(193, 158, 103) 50%, rgb(182, 141, 76) 51%, rgb(233, 212, 179) 100%)',
'linear-gradient(135deg, rgb(249, 252, 247) 0%, rgb(245, 249, 240) 100%)',
'linear-gradient(135deg, rgb(195, 217, 255) 0%, rgb(177, 200, 239) 41%, rgb(152, 176, 217) 100%)',
'linear-gradient(135deg, rgb(210, 255, 82) 0%, rgb(145, 232, 66) 100%)',
'linear-gradient(135deg, rgb(254, 254, 253) 0%, rgb(220, 227, 196) 42%, rgb(174, 191, 118) 100%)',
'linear-gradient(135deg, rgb(228, 239, 192) 0%, rgb(171, 189, 115) 100%)',
'linear-gradient(135deg, rgb(164, 179, 87) 0%, rgb(117, 137, 12) 100%)',
'linear-gradient(135deg, rgb(98, 125, 77) 0%, rgb(31, 59, 8) 100%)',
'linear-gradient(135deg, rgb(115, 136, 10) 0%, rgb(115, 136, 10) 100%)',
'linear-gradient(135deg, rgb(255, 175, 75) 0%, rgb(255, 146, 10) 100%)',
'linear-gradient(135deg, rgb(250, 198, 149) 0%, rgb(245, 171, 102) 47%, rgb(239, 141, 49) 100%)',
'linear-gradient(135deg, rgb(255, 197, 120) 0%, rgb(251, 157, 35) 100%)',
'linear-gradient(135deg, rgb(249, 198, 103) 0%, rgb(247, 150, 33) 100%)',
'linear-gradient(135deg, rgb(252, 234, 187) 0%, rgb(252, 205, 77) 50%, rgb(248, 181, 0) 51%, rgb(251, 223, 147) 100%)',
'linear-gradient(135deg, rgb(255, 168, 76) 0%, rgb(255, 123, 13) 100%)',
'linear-gradient(135deg, rgb(255, 103, 15) 0%, rgb(255, 103, 15) 100%)',
'linear-gradient(135deg, rgb(255, 116, 0) 0%, rgb(255, 116, 0) 100%)',
'linear-gradient(135deg, rgb(255, 183, 107) 0%, rgb(255, 167, 61) 50%, rgb(255, 124, 0) 51%, rgb(255, 127, 4) 100%)',
'linear-gradient(135deg, rgb(255, 93, 177) 0%, rgb(239, 1, 124) 100%)',
'linear-gradient(135deg, rgb(251, 131, 250) 0%, rgb(233, 60, 236) 100%)',
'linear-gradient(135deg, rgb(229, 112, 231) 0%, rgb(200, 94, 199) 47%, rgb(168, 73, 163) 100%)',
'linear-gradient(135deg, rgb(203, 96, 179) 0%, rgb(173, 18, 131) 50%, rgb(222, 71, 172) 100%)',
'linear-gradient(135deg, rgb(255, 0, 132) 0%, rgb(255, 0, 132) 100%)',
'linear-gradient(135deg, rgb(252, 236, 252) 0%, rgb(251, 166, 225) 50%, rgb(253, 137, 215) 51%, rgb(255, 124, 216) 100%)',
'linear-gradient(135deg, rgb(203, 96, 179) 0%, rgb(193, 70, 161) 50%, rgb(168, 0, 119) 51%, rgb(219, 54, 164) 100%)',
'linear-gradient(135deg, rgb(235, 233, 249) 0%, rgb(216, 208, 239) 50%, rgb(206, 199, 236) 51%, rgb(193, 191, 234) 100%)',
'linear-gradient(135deg, rgb(137, 137, 186) 0%, rgb(137, 137, 186) 100%)',
'linear-gradient(135deg, rgb(254, 187, 187) 0%, rgb(254, 144, 144) 45%, rgb(255, 92, 92) 100%)',
'linear-gradient(135deg, rgb(242, 130, 91) 0%, rgb(229, 91, 43) 50%, rgb(240, 113, 70) 100%)',
'linear-gradient(135deg, rgb(255, 48, 25) 0%, rgb(207, 4, 4) 100%)',
'linear-gradient(135deg, rgb(255, 26, 0) 0%, rgb(255, 26, 0) 100%)',
'linear-gradient(135deg, rgb(204, 0, 0) 0%, rgb(204, 0, 0) 100%)',
'linear-gradient(135deg, rgb(248, 80, 50) 0%, rgb(241, 111, 92) 50%, rgb(246, 41, 12) 51%, rgb(240, 47, 23) 71%, rgb(231, 56, 39) 100%)',
'linear-gradient(135deg, rgb(254, 204, 177) 0%, rgb(241, 116, 50) 50%, rgb(234, 85, 7) 51%, rgb(251, 149, 94) 100%)',
'linear-gradient(135deg, rgb(239, 197, 202) 0%, rgb(210, 75, 90) 50%, rgb(186, 39, 55) 51%, rgb(241, 142, 153) 100%)',
'linear-gradient(135deg, rgb(243, 197, 189) 0%, rgb(232, 108, 87) 50%, rgb(234, 40, 3) 51%, rgb(255, 102, 0) 75%, rgb(199, 34, 0) 100%)',
'linear-gradient(135deg, rgb(183, 222, 237) 0%, rgb(113, 206, 239) 50%, rgb(33, 180, 226) 51%, rgb(183, 222, 237) 100%)',
'linear-gradient(135deg, rgb(224, 243, 250) 0%, rgb(216, 240, 252) 50%, rgb(184, 226, 246) 51%, rgb(182, 223, 253) 100%)',
'linear-gradient(135deg, rgb(254, 255, 232) 0%, rgb(214, 219, 191) 100%)',
'linear-gradient(135deg, rgb(252, 255, 244) 0%, rgb(233, 233, 206) 100%)',
'linear-gradient(135deg, rgb(252, 255, 244) 0%, rgb(223, 229, 215) 40%, rgb(179, 190, 173) 100%)',
'linear-gradient(135deg, rgb(229, 230, 150) 0%, rgb(209, 211, 96) 100%)',
'linear-gradient(135deg, rgb(234, 239, 181) 0%, rgb(225, 233, 160) 100%)',
'linear-gradient(135deg, rgb(69, 72, 77) 0%, rgb(0, 0, 0) 100%)',
'linear-gradient(135deg, rgb(125, 126, 125) 0%, rgb(14, 14, 14) 100%)',
'linear-gradient(135deg, rgb(149, 149, 149) 0%, rgb(13, 13, 13) 46%, rgb(1, 1, 1) 50%, rgb(10, 10, 10) 53%, rgb(78, 78, 78) 76%, rgb(56, 56, 56) 87%, rgb(27, 27, 27) 100%)',
'linear-gradient(135deg, rgb(174, 188, 191) 0%, rgb(110, 119, 116) 50%, rgb(10, 14, 10) 51%, rgb(10, 8, 9) 100%)',
'linear-gradient(135deg, rgb(197, 222, 234) 0%, rgb(138, 187, 215) 31%, rgb(6, 109, 171) 100%)',
'linear-gradient(135deg, rgb(247, 251, 252) 0%, rgb(217, 237, 242) 40%, rgb(173, 217, 228) 100%)',
'linear-gradient(135deg, rgb(214, 249, 255) 0%, rgb(158, 232, 250) 100%)',
'linear-gradient(135deg, rgb(233, 246, 253) 0%, rgb(211, 238, 251) 100%)',
'linear-gradient(135deg, rgb(99, 182, 219) 0%, rgb(48, 157, 207) 100%)',
'linear-gradient(135deg, rgb(44, 83, 158) 0%, rgb(44, 83, 158) 100%)',
'linear-gradient(135deg, rgb(169, 228, 247) 0%, rgb(15, 180, 231) 100%)',
'linear-gradient(135deg, rgb(147, 206, 222) 0%, rgb(117, 189, 209) 41%, rgb(73, 165, 191) 100%)',
'linear-gradient(135deg, rgb(178, 225, 255) 0%, rgb(102, 182, 252) 100%)',
'linear-gradient(135deg, rgb(79, 133, 187) 0%, rgb(79, 133, 187) 100%)',
'linear-gradient(135deg, rgb(222, 239, 255) 0%, rgb(152, 190, 222) 100%)',
'linear-gradient(135deg, rgb(73, 192, 240) 0%, rgb(44, 175, 227) 100%)',
'linear-gradient(135deg, rgb(254, 255, 255) 0%, rgb(210, 235, 249) 100%)',
'linear-gradient(135deg, rgb(167, 207, 223) 0%, rgb(35, 83, 138) 100%)',
'linear-gradient(135deg, rgb(73, 155, 234) 0%, rgb(32, 124, 229) 100%)',
'linear-gradient(135deg, rgb(53, 106, 160) 0%, rgb(53, 106, 160) 100%)',
'linear-gradient(135deg, rgb(255, 255, 255) 0%, rgb(246, 246, 246) 47%, rgb(237, 237, 237) 100%)',
'linear-gradient(135deg, rgb(242, 249, 254) 0%, rgb(214, 240, 253) 100%)',
'linear-gradient(135deg, rgb(255, 255, 255) 0%, rgb(229, 229, 229) 100%)',
'linear-gradient(135deg, rgb(255, 255, 255) 0%, rgb(241, 241, 241) 50%, rgb(225, 225, 225) 51%, rgb(246, 246, 246) 100%)',
'linear-gradient(135deg, rgb(255, 255, 255) 0%, rgb(243, 243, 243) 50%, rgb(237, 237, 237) 51%, rgb(255, 255, 255) 100%)',
'linear-gradient(135deg, rgb(246, 248, 249) 0%, rgb(229, 235, 238) 50%, rgb(215, 222, 227) 51%, rgb(245, 247, 249) 100%)',
'linear-gradient(135deg, rgb(246, 230, 180) 0%, rgb(237, 144, 23) 100%)',
'linear-gradient(135deg, rgb(234, 185, 45) 0%, rgb(199, 152, 16) 100%)',
'linear-gradient(135deg, rgb(255, 214, 94) 0%, rgb(254, 191, 4) 100%)',
'linear-gradient(135deg, rgb(241, 231, 103) 0%, rgb(254, 182, 69) 100%)',
'linear-gradient(135deg, rgb(255, 255, 136) 0%, rgb(255, 255, 136) 100%)',
'radial-gradient(ellipse at center, rgba(241,231,103,1) 5%,rgba(241,231,103,1) 39%,rgba(241,231,103,1) 87%,rgba(254,182,69,1) 100%)'
];

function fontCombo(whichItem){
			json=pixie.getTool('history').getCurrentCanvasState();
			var num=json.canvas.objects.length
			resetControls();
			switch(whichItem){
				case 1: 
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":802.5,"top":430,"width":388.28,"height":148.03,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.28,"scaleY":1.28,"angle":-7.28,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Touch to","fontSize":131,"fontWeight":400,"fontFamily":"Playlist","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"fEmAc2oY7W"},"activeFont":{"family":"Playlist","category":"handwriting","filePath":"Playlist-Script.ttf","type":"custom"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":780,"top":656.25,"width":559.65,"height":169.5,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.28,"scaleY":1.28,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"START","fontSize":150,"fontWeight":400,"fontFamily":"Hussar Ekologiczny","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"jFzGUzZ32O"},"activeFont":{"family":"Hussar Ekologiczny","category":"display","filePath":"hussar-ekologiczne-1.otf","type":"custom"},"styles":{}}
					
					json.editor.fonts=[{"family":"Hussar Ekologiczny","category":"display","filePath":"hussar-ekologiczne-1.otf","type":"custom"},{"family":"Playlist","category":"handwriting","filePath":"Playlist-Script.ttf","type":"custom"}]
					break;
				case 2:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":801.25,"top":476.25,"width":334.76,"height":114.13,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.65,"scaleY":1.65,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Welcome","fontSize":101,"fontWeight":400,"fontFamily":"Chewy","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"BxGXEUahCg"},"activeFont":{"family":"Chewy","category":"display","type":"google"},"styles":{"0":{"0":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"1":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"2":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"3":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"4":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"5":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"6":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"7":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101}}}}
					 
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":798.75,"top":771.25,"width":270,"height":45.2,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.84,"scaleY":1.84,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Virtual Photo Booth","fontSize":40,"fontWeight":400,"fontFamily":"Bebas Neue","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"7S8NO4xKWz"},"activeFont":{"family":"Bebas Neue","category":"display","type":"google"},"styles":{}}
					
					json.canvas.objects[num+2]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":792.5,"top":626.25,"width":241.75,"height":114.13,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.65,"scaleY":1.65,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"to the","fontSize":101,"fontWeight":400,"fontFamily":"Chewy","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"kG9Ci3b39g"},"styles":{"0":{"0":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"1":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"2":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"3":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"4":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"5":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101},"9":{"fill":"rgb(0,0,0)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"italic","fontFamily":"Chewy","fontWeight":400,"fontSize":101}}}}
					
					json.editor.fonts=[{"family":"Chewy","category":"display","type":"google"},{"family":"Bebas Neue","category":"display","type":"google"},{"family":"Chewy","category":"display","type":"google"}]
					break;
					
				case 3:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":793.75,"top":640,"width":428.53,"height":327.07,"fill":"rgba(239,71,187,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.85,"scaleY":1.85,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":{"color":"rgba(224,159,229,1)","blur":3,"offsetX":4,"offsetY":4,"affectStroke":false,"nonScaling":false},"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Happy\nBirthday","fontSize":134,"fontWeight":400,"fontFamily":"Nickainley","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"sjYlDAKpuh"},"activeFont":{"family":"Nickainley","category":"handwriting","filePath":"Nickainley-Normal.otf","type":"custom"},"styles":{}}					
					
					json.editor.fonts=[{"family":"Nickainley","category":"handwriting","filePath":"Nickainley-Normal.otf","type":"custom"}]
					break;
					
				case 4:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":815,"top":441.25,"width":516.24,"height":102.83,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.72,"scaleY":1.72,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Happy Birthday","fontSize":91,"fontWeight":400,"fontFamily":"Mr Dafoe","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"ZDu7KyGvOW"},"activeFont":{"family":"Mr Dafoe","category":"handwriting","type":"google"},"styles":{}}	
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":805,"top":651.25,"width":626.47,"height":137.86,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.51,"scaleY":1.51,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"CHRISTINE!","fontSize":122,"fontWeight":400,"fontFamily":"Barlow Bold","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"Fn6uE3sdcY"},"activeFont":{"family":"Barlow Bold","category":"sans-serif","filePath":"Barlow-Bold.ttf","type":"custom"},"styles":{}}
					
					json.editor.fonts=[{"family":"Barlow Bold","category":"sans-serif","filePath":"Barlow-Bold.ttf","type":"custom"},{"family":"Mr Dafoe","category":"handwriting","type":"google"}]
					break;
				
				case 5:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":776.25,"top":618.75,"width":220.25,"height":92.66,"fill":"rgb(0,0,0)","stroke":"rgb(242,+38,+19)","strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":2.66,"scaleY":2.66,"angle":-15.94,"flipX":false,"flipY":false,"opacity":1,"shadow":{"color":"rgba(97,90,90,1)","blur":5,"offsetX":4,"offsetY":4,"affectStroke":false,"nonScaling":false},"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Thank","fontSize":82,"fontWeight":400,"fontFamily":"Pacifico","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"Cnk2wHdldS"},"activeFont":{"family":"Pacifico","category":"handwriting","type":"google"},"styles":{}}	
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":868.75,"top":808.75,"width":143.5,"height":92.66,"fill":"rgb(0,0,0)","stroke":"rgb(242,+38,+19)","strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":2.66,"scaleY":2.66,"angle":-15.94,"flipX":false,"flipY":false,"opacity":1,"shadow":{"color":"rgba(97,90,90,1)","blur":5,"offsetX":4,"offsetY":4,"affectStroke":false,"nonScaling":false},"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"you!","fontSize":82,"fontWeight":400,"fontFamily":"Pacifico","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"9f7Ir1ZkLd"},"styles":{}}
					
					json.editor.fonts=[{"family":"Pacifico","category":"handwriting","type":"google"},{"family":"Pacifico","category":"handwriting","type":"google"}]
					break;
					
				case 6:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":626.25,"top":755,"width":349.26,"height":323.18,"fill":"rgba(182,34,180,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.11,"scaleY":1.11,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"16","fontSize":286,"fontWeight":400,"fontFamily":"Ultra","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"pfjaRFpBsy"},"activeFont":{"family":"Ultra","category":"serif","type":"google"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":596.25,"top":488.75,"width":282.24,"height":166.11,"fill":"rgb(142,+68,+173)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.85,"scaleY":1.85,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Sweet","fontSize":147,"fontWeight":400,"fontFamily":"Nickainley","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"8ic50z52uf"},"activeFont":{"family":"Nickainley","category":"handwriting","filePath":"Nickainley-Normal.otf","type":"custom"},"styles":{"0":{"0":{"fill":"rgba(182,34,180,1)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"normal","fontFamily":"Nickainley","fontWeight":400,"fontSize":147},"1":{"fill":"rgba(182,34,180,1)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"normal","fontFamily":"Nickainley","fontWeight":400,"fontSize":147},"2":{"fill":"rgba(182,34,180,1)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"normal","fontFamily":"Nickainley","fontWeight":400,"fontSize":147},"3":{"fill":"rgba(182,34,180,1)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"normal","fontFamily":"Nickainley","fontWeight":400,"fontSize":147},"4":{"fill":"rgba(182,34,180,1)","backgroundColor":null,"stroke":"#000","strokeWidth":0.05,"opacity":1,"textAlign":"center","underline":false,"linethrough":false,"fontStyle":"normal","fontFamily":"Nickainley","fontWeight":400,"fontSize":147}}}}
					
					json.editor.fonts=[{"family":"Nickainley","category":"handwriting","filePath":"Nickainley-Normal.otf","type":"custom"},{"family":"Ultra","category":"serif","type":"google"}]
					break;
					
				case 7:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":803,"top":654,"width":398.67,"height":284.76,"fill":"rgba(255,153,0,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.62,"scaleY":1.62,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":{"color":"#000","blur":3,"offsetX":6,"offsetY":0,"affectStroke":false,"nonScaling":false},"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"BOO!","fontSize":252,"fontWeight":400,"fontFamily":"Creepster","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"1TFLEfrOg4"},"activeFont":{"family":"Creepster","category":"display","type":"google"},"styles":{}}

					json.editor.fonts=[{"family":"Creepster","category":"display","type":"google"}]
					break;
					
				case 8:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":838,"top":562,"width":795.6,"height":176.28,"fill":"rgba(237,48,255,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.25,"scaleY":1.25,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"DANCE!","fontSize":156,"fontWeight":400,"fontFamily":"Rubik Mono One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"xhA68fz6FW"},"activeFont":{"family":"Rubik Mono One","category":"sans-serif","type":"google"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":839,"top":704,"width":795.6,"height":176.28,"fill":"rgba(255,36,183,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.25,"scaleY":1.25,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"DANCE!","fontSize":156,"fontWeight":400,"fontFamily":"Rubik Mono One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"hlyrx4oIAI"},"styles":{}}
					
					json.canvas.objects[num+2]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":842,"top":847,"width":795.6,"height":176.28,"fill":"rgba(211,255,0,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.25,"scaleY":1.25,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"DANCE!","fontSize":156,"fontWeight":400,"fontFamily":"Rubik Mono One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"UTE2CfJ2p2"},"styles":{}}
					
					json.editor.fonts=[{"family":"Rubik Mono One","category":"sans-serif","type":"google"},{"family":"Rubik Mono One","category":"sans-serif","type":"google"},{"family":"Rubik Mono One","category":"sans-serif","type":"google"}]
					break;
				
				case 9:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":817,"top":284,"width":493.77,"height":205.66,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.87,"scaleY":1.87,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Welcome","fontSize":182,"fontWeight":400,"fontFamily":"Amatic SC Bold","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"FdUwKtrQWt"},"activeFont":{"family":"Amatic SC Bold","category":"display","filePath":"AmaticSC-Bold.ttf","type":"custom"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":818,"top":474,"width":288.84,"height":117.52,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.33,"scaleY":1.33,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"to the","fontSize":104,"fontWeight":400,"fontFamily":"Cedarville Cursive","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"0yy1IcoIp5"},"activeFont":{"family":"Cedarville Cursive","category":"handwriting","type":"google"},"styles":{}}
					
					json.canvas.objects[num+2]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":795,"top":812,"width":373.24,"height":64.41,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.3,"scaleY":1.3,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Touch to Start","fontSize":57,"fontWeight":400,"fontFamily":"Sensei","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"1fEKBFyAup"},"activeFont":{"family":"Sensei","category":"display","filePath":"Sensei-Medium.ttf","type":"custom"},"styles":{}}
					
					json.canvas.objects[num+3]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":814,"top":656,"width":648.25,"height":129.95,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.87,"scaleY":1.87,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Virtual Photo Booth","fontSize":115,"fontWeight":400,"fontFamily":"Amatic SC Bold","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"lLyCRCpVll"},"styles":{}}
					
					json.editor.fonts=[{"family":"Amatic SC Bold","category":"display","filePath":"AmaticSC-Bold.ttf","type":"custom"},{"family":"Sensei","category":"display","filePath":"Sensei-Medium.ttf","type":"custom"},{"family":"Cedarville Cursive","category":"handwriting","type":"google"},{"family":"Amatic SC Bold","category":"display","filePath":"AmaticSC-Bold.ttf","type":"custom"}]
					break;
					
				case 10:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":508,"top":562,"width":402.58,"height":110.74,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":2.04,"scaleY":2.04,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"virtual","fontSize":98,"fontWeight":400,"fontFamily":"Fredoka One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"left","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"Du6A3SKMas"},"activeFont":{"family":"Fredoka One","category":"display","type":"google"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":421,"top":904,"width":212.58,"height":31.64,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":2.15,"scaleY":2.15,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"TOUCH TO START","fontSize":28,"fontWeight":400,"fontFamily":"Barlow Bold","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"rtFoadeDqB"},"activeFont":{"family":"Barlow Bold","category":"sans-serif","filePath":"Barlow-Bold.ttf","type":"custom"},"styles":{}}
					
					json.canvas.objects[num+2]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":774,"top":738,"width":578.69,"height":110.74,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":2.04,"scaleY":2.04,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"photo booth","fontSize":98,"fontWeight":400,"fontFamily":"Fredoka One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"left","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"gySbX782VT"},"styles":{}}
					
					json.editor.fonts=[{"family":"Fredoka One","category":"display","type":"google"},{"family":"Barlow Bold","category":"sans-serif","filePath":"Barlow-Bold.ttf","type":"custom"},{"family":"Fredoka One","category":"display","type":"google"}] 
					break;
					
				case 11:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":829,"top":403,"width":478.95,"height":266.05,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.51,"scaleY":1.51,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Merry\nChristmas!","fontSize":109,"fontWeight":400,"fontFamily":"Brusher","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"IfC8Egrcb8"},"activeFont":{"family":"Brusher","category":"handwriting","filePath":"Brusher.ttf","type":"custom"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":799,"top":677,"width":215.16,"height":33.9,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.3,"scaleY":1.3,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"touch to start","fontSize":30,"fontWeight":400,"fontFamily":"Comfortaa","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"UoGIQ9mASO"},"activeFont":{"family":"Comfortaa","category":"display","type":"google"},"styles":{}}
					
					json.editor.fonts=[{"family":"Comfortaa","category":"display","type":"google"},{"family":"Brusher","category":"handwriting","filePath":"Brusher.ttf","type":"custom"}]
					break;
					
				case 12:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":848,"top":670,"width":202.01,"height":91.53,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":2.75,"scaleY":2.75,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Merry","fontSize":81,"fontWeight":400,"fontFamily":"Great Vibes","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"cLHtu7MQRL"},"activeFont":{"family":"Great Vibes","category":"handwriting","type":"google"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":836,"top":870,"width":246.64,"height":91.53,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":2.75,"scaleY":2.75,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Christmas","fontSize":81,"fontWeight":400,"fontFamily":"Great Vibes","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"Dra7pzNclD"},"styles":{}}
					
					json.canvas.objects[num+2]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":956,"top":517,"width":183.42,"height":22.6,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.93,"scaleY":1.93,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"WISHING YOU A","fontSize":20,"fontWeight":400,"fontFamily":"Libre Baskerville","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"jiBeoQMpzC"},"activeFont":{"family":"Libre Baskerville","category":"serif","type":"google"},"styles":{}}
					
					json.editor.fonts=[{"family":"Libre Baskerville","category":"serif","type":"google"},{"family":"Great Vibes","category":"handwriting","type":"google"},{"family":"Great Vibes","category":"handwriting","type":"google"}]
					break;
					
				case 13:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":746,"top":467,"width":383.34,"height":251.99,"fill":"rgba(126,255,224,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.33,"scaleY":1.33,"angle":-13.6,"flipX":false,"flipY":false,"opacity":1,"shadow":{"color":"rgba(22,137,109,1)","blur":1,"offsetX":5,"offsetY":5,"affectStroke":false,"nonScaling":false},"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"let's","fontSize":223,"fontWeight":400,"fontFamily":"Bukhari Script","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"vOgDkU9bh8"},"activeFont":{"family":"Bukhari Script","category":"handwriting","filePath":"Bukhari Script.ttf","type":"custom"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":769,"top":723,"width":524.94,"height":251.99,"fill":"rgba(126,255,224,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.33,"scaleY":1.33,"angle":-13.6,"flipX":false,"flipY":false,"opacity":1,"shadow":{"color":"rgba(22,137,109,1)","blur":1,"offsetX":5,"offsetY":5,"affectStroke":false,"nonScaling":false},"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"party","fontSize":223,"fontWeight":400,"fontFamily":"Bukhari Script","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"DvCh9KtILh"},"styles":{}}
					
					json.editor.fonts=[{"family":"Bukhari Script","category":"handwriting","filePath":"Bukhari Script.ttf","type":"custom"},{"family":"Bukhari Script","category":"handwriting","filePath":"Bukhari Script.ttf","type":"custom"}]
					break;
					
				case 14:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":797,"top":628,"width":718.37,"height":133.34,"fill":"rgba(142,173,230,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":0.87,"scaleY":0.87,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"ONLINE","fontSize":118,"fontWeight":400,"fontFamily":"Seymour One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"IXFXbPRa5k"},"activeFont":{"family":"Seymour One","category":"sans-serif","type":"google"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":803,"top":738,"width":678.9,"height":133.34,"fill":"rgba(142,173,230,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":0.87,"scaleY":0.87,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"PHOTO","fontSize":118,"fontWeight":400,"fontFamily":"Seymour One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"rv07pmLt7d"},"styles":{}}
					
					json.canvas.objects[num+2]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":798,"top":848,"width":684.95,"height":133.34,"fill":"rgba(142,173,230,1)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":0.87,"scaleY":0.87,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"BOOTH","fontSize":118,"fontWeight":400,"fontFamily":"Seymour One","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"N2T6qOqBXC"},"styles":{}}
					
					json.canvas.objects[num+3]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":809,"top":769,"width":268.8,"height":54.24,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.57,"scaleY":1.57,"angle":-6.37,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"Touch to Start","fontSize":48,"fontWeight":400,"fontFamily":"Brusher","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"ZJTF68JVin"},"activeFont":{"family":"Brusher","category":"handwriting","filePath":"Brusher.ttf","type":"custom"},"styles":{}}
					 
					json.editor.fonts=[{"family":"Brusher","category":"handwriting","filePath":"Brusher.ttf","type":"custom"},{"family":"Seymour One","category":"sans-serif","type":"google"},{"family":"Seymour One","category":"sans-serif","type":"google"},{"family":"Seymour One","category":"sans-serif","type":"google"}]
					break
				
				case 15:
					json.canvas.objects[num]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":804,"top":473,"width":366.72,"height":135.6,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.19,"scaleY":1.19,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"photo","fontSize":120,"fontWeight":400,"fontFamily":"League Spartan","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"tir8zweN12"},"styles":{}}
					
					json.canvas.objects[num+1]={"type":"i-text","version":"4.3.1","originX":"center","originY":"center","left":804,"top":613,"width":366.72,"height":135.6,"fill":"rgb(0,0,0)","stroke":"#000","strokeWidth":0.05,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeUniform":false,"strokeMiterLimit":4,"scaleX":1.19,"scaleY":1.19,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"backgroundColor":null,"fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"text":"booth","fontSize":120,"fontWeight":400,"fontFamily":"League Spartan","fontStyle":"normal","lineHeight":1.16,"underline":false,"overline":false,"linethrough":false,"textAlign":"initial","textBackgroundColor":"","charSpacing":0,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"lockRotation":false,"lockScalingX":false,"lockScalingY":false,"lockUniScaling":false,"hasControls":true,"hasBorders":true,"name":"text","data":{"id":"61UkoRSjD5"},"styles":{}}
					
					json.editor.fonts=[{"family":"League Spartan","category":"sans-serif","filePath":"LeagueSpartan-Bold.otf","type":"custom"},{"family":"League Spartan","category":"sans-serif","filePath":"LeagueSpartan-Bold.otf","type":"custom"}]
					break;

			}
			
			pixie.loadState(json);
			
		}

function toDataURL(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.onload = function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      callback(reader.result);
    }
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
}