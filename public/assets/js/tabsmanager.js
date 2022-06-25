/*!
 * Builder.js
 * Version 1.0 - built Sat, Oct 6th 2018, 01:12 pm
 * https://simcycreative.com
 * Simcy Creative - <hello@simcycreative.com>
 * Private License
 */


$(document).ready(function() {
	initSortable();
});


/*
 *  Initialize sortable 
 */
 function initSortable() {
 	$( ".tabs-holder, .fields-holder" ).sortable({
	  stop: function( event, ui ) {
	  	indexing();
	  }
	});
 }


/*
 *  When field type changes 
 */
$("#addfield, #updatefield").on("change", "select[name=type]", function(){
    var type = $(this).val()
    if(type === "select"){
        $(".select-options").show();
        $(".select-options input").attr("required", true);
    }else{
        $(".select-options").hide();
        $(".select-options input").removeAttr("required");
    }
})


/*
 *  tabs & field indexing
 */
function indexing() {
    if($(".add-question").length){
    $("input.field-indexing").each(function(index) { 
        $(this).val(index + 1);
    });
    }else{
        $(".panel.lecture").each(function(index) { 
          	$(this).find(".panel-title .indexing").text(index + 1 +".)");
          	$(this).find("input.tab-indexing").val(index + 1);
          	$(this).find(".input-field-item").each(function(i) {
          		$(this).find("input.field-indexing").val(i + 1);
          	});
        });
    }
    $(".indexing-form").submit();
}