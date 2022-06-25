@if($data->count() > 0)
@foreach($data as $book)
<style>
.pct-form-checkbox {
    float: left;
    margin-right: 10px;
}</style>
 <div class="mentor-widget">
                            <div class="user-info-left">
                               
                                <div class="user-info-cont">
                                    <h4 class="usr-name"><a href="program/details/{{encrypted_key($book->id,'encrypt')}}">{{ substr($book->title,0,20)}}</a></h4>
                                    <p class="mentor-type">  <i class="fa fa-tags"></i>
                                    
                                    <?php
                                    
                                    $programCategory = \App\ProgramCategory::find($book->category_id);
                                if($programCategory){
                                    echo  $programCategory->name;
                                }else{
                                    echo 'Not Available';
                                }  
                                    
                                    ?></p>
                                    <div class="mentor-details">
                                        <p class="user-location"><i class="fas fa-building"></i> 
                                    
                                        @php
                                         $users = $book->user->company;
                                        if($users == null){
                                            echo "not available";
                                        }
                                        else{
                                            echo $users;
                                        }
                                       @endphp

                                    
                                    
                                    </p>
                                    </div>
                                </div>
                            </div>
     
                                     
                            <div class="user-info-right">
                                
                                <div class="user-infos">
                                    <p class="mentor-type">  
                                     </p>
                                    <p class="mentor-type">  <i class="fa fa-question-circle"></i>
                                         Program Questions: {{!empty($book->data) ? "Yes":"No"}}
                                     </p>
                                    <p class="mentor-type">  <i class="fa fa-list"></i>
                                         Audit Report: {{!empty($book->audit_report) ? "Yes":"No"}}
                                     </p>
                                </div>
                            </div>
                            <div class="user-info-right">
                                
                                <div class="user-infos">
                                    <ul>
                                    <div class="field pct-form-field  ">
                                        <div class="pct-form-checkbox ">
                                            <input type="checkbox" id="addToCompare-{{ $book->id}}" name="addToCompare-{{ $book->id}}" value="{{ $book->id}}"  class="filter_result_chk">
                                            <input type="hidden" data-id="{{ $book->id}}"  data-title="{{ $book->title}}"  data-category=" <?php   $programCategory = \App\ProgramCategory::find($book->category_id);
                                if($programCategory){
                                    echo  $programCategory->name;
                                }else{
                                    echo 'Not Available';
                                }    ?>" class="filterhidden" >
                                        </div>
                                        <div class="pct-form-label"><label for="addToCompare-{{ $book->id}}">Compare</label>
                                        </div>
                                    </div>
                                      
                                    </ul>
                                </div>
                                <div class="mentor-booking">
                                    <a class="apt-btn" href="program/details/{{encrypted_key($book->id,'encrypt')}}">Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class=" col-md-12 d-flex justify-content-center paginationCss">
                                {{ $data->appends(request()->except('page'))->links() }}

                            </div>

                        @else
                        <div class="text-center errorSection">
                            <span>No Data Found</span>
                        </div>
                        @endif

                        <script>
$( document ).ready(function() {

    $( '.pct-compare-form' ).on( 'click', '.pct-remove-column', function () { 

        var $checkboxes = $('.filter_result_chk');
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        //alert(countCheckedCheckboxes);
        if(countCheckedCheckboxes == 1){
            $('.pct-compare').hide();
         }
         var $checkboxes = $('.filter_result_chk');
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
       // alert(countCheckedCheckboxes);
        if(countCheckedCheckboxes >3){
            $('input.filter_result_chk:not(:checked)').attr('disabled', 'disabled');
         }
         else{
            $('input.filter_result_chk').removeAttr('disabled');
          }
         var removeid = $(this).data('id');
        console.log( $(".filter_result_chk:checkbox[value="+removeid+"]"));
        $("#addToCompare-"+removeid).prop("checked",false);

        $('#card_'+removeid).parent('.compare-field').removeClass('active');
        $('#card_'+removeid).parent('.compare-field').html('<div class="pct-form-label-grey">Program </div>');
                    return false;
    });

    $('#data-holder').find('.filter_result_chk').change(function(){
       var id =  $(this).siblings('.filterhidden').data('id');
       var title =  $(this).siblings('.filterhidden').data('title');
       var category =  $(this).siblings('.filterhidden').data('category');
//alert(title);
if ($(this).prop('checked')==true){ 
    var $checkboxes = $('.filter_result_chk');
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        if(countCheckedCheckboxes >0){
            $(".compare-field").each(function(index, value) {
                index++;
              // alert($(this).children().hasClass('pct-form-label-grey'));
                if($(this).children().hasClass('pct-form-label-grey')){
                    $(this).addClass('active');
                    $(this).html('<div id="card_'+ id +'" class="pct-form-label"><input type="hidden" name="id'+ index +'" value="'+ id +'"><label for=""><span class="pct-degree-name"><span class="pct-degree-name">'+ title +'<br><span class="pct-degree-type">'+ category +'</span></span></span></label></div><a href="javascript:void(0)" data-id="'+ id +'" class="closer pct-remove-column"><span aria-hidden="true">×</span></a>');
                    return false;
                }
                else{


                }
        });
          $('.pct-compare').show();
         }
         else{
          
            $('.pct-compare').hide();
         }


        if(countCheckedCheckboxes >2){
            $('input.filter_result_chk:not(:checked)').attr('disabled', 'disabled');
         }
         else{
            
            $('input.filter_result_chk').removeAttr('disabled');

         }
    }else{
        // not checked
        var $checkboxes = $('.filter_result_chk');
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        if(countCheckedCheckboxes >2){
            $('input.filter_result_chk:not(:checked)').attr('disabled', 'disabled');
         }
         else{
            $('input.filter_result_chk').removeAttr('disabled');
          }
        
        $(".compare-field").each(function(index, value) {
          
              // alert($(this).children().hasClass('pct-form-label-grey'));
                if(!$(this).children().hasClass('pct-form-label-grey')){
                    $('#card_'+id).parent('.compare-field').removeClass('active');
                    $('#card_'+id).parent('.compare-field').html('<div class="pct-form-label-grey">Program </div>');
                    return false;
                }
               

        });
     }

})
});
</script>