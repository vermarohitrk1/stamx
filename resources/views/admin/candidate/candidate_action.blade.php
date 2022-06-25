<!--  /Candidate EventDetails Modal -->
@push('script')
    <script type="text/javascript">
        $(document).on("click", ".delete_record_model", function(){
            $("#common_delete_form").attr('action',$(this).attr('data-url'));
            $('#common_delete_model').modal('show');
        });

        // Show Candidate Modal
        $(document).on("click", ".show-modal", function(){
            var modal=$('#candidate-details-modal');
            var id=$(this).attr('data-id');
            var jobpost_id=$(this).attr('data-job-post-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.details")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "jobpost_id": jobpost_id,
                },
                success:function(response){
                    modal.find('.modal-body').html(response.html);
                    modal.modal('show');
                    $('#view-timeline').trigger("click");
                    CKEDITOR.replace('notes-editor');
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }
            });
        });

        $(document).on("click", ".nav-item", function(){
            var id = $(this).attr('data-id');
            $('.show.active').removeClass('active');
            $('#'+id).addClass('active');
        });

        //show ckeditor for update notes
        $(document).on("click", ".edit-icon", function(){
            var id = $(this).attr('data-notes-id');
            var editorname = $('#summary-ckeditor'+id).attr('name');
            CKEDITOR.replace(editorname);
            $('.summary-ckeditor'+id).toggle();
            $('.summary-ckeditor-data'+id).toggle();
        });

        $(document).on("click", ".cancel-update", function () {
            var id = $(this).attr('data-notes-id');
            $('.summary-ckeditor'+id).toggle();
            $('.summary-ckeditor-data'+id).toggle();
        });

        //update notes
        $(document).on("click", '.notes-update-btn', function () {
            var id =  $(this).attr('data-id');
            var notes = CKEDITOR.instances["summary-ckeditor"+id].getData();
            $('.summary-ckeditor'+id).toggle();
            $('.summary-ckeditor-data'+id).toggle();
            $.ajax({
                type:"GET",
                url:'{{route("candidate.update.notes")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "notes": notes,
                },
                success:function(response){
                    if(response.success==true){
                        $('.notes-listing').remove();
                        $( "#candidate-notes" ).trigger( "click" );
                        show_toastr('Success: ', response.message, 'success');
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }
            });
        });

        //Delete notes
        $(document).on("click", ".delete-icon", function () {
            var id = $(this).attr("data-notes-id");
            $.ajax({
                type : "GET",
                url : "{{route('candidate.delete.notes')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success:function(response){
                    if(response.success==true){
                        $('.notes-listing').remove();
                        $( "#candidate-notes" ).trigger( "click" );
                        show_toastr('Success :', response.message, 'success');
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }
            });
        });

        // Get Notes
        $(document).on("click", "#candidate-notes", function(){
            var candidate_id = $('#candidate-notes').attr('data-candidate-id');
            var jobpost_id = $('#candidate-notes').attr('data-job-post-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.get.notes")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "candidate_id": candidate_id,
                    "jobpost_id": jobpost_id,
                },
                success:function(response){
                    if(response.success==true){
                        $('.notes-listing').remove();
                        $('.no-data-found-wrapper.text-center.p-primary.empty').remove();
                        $("#show-notes").append(response.html)
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }

            });
        });


        // Save Notes
        $(document).on("click", "#save-notes", function(){
            var notes = CKEDITOR.instances["summary-ckeditor"].getData();
            var totalcontentlength = notes.replace(/<[^>]*>/gi, '').length;
            if( !totalcontentlength ) {
                show_toastr('Error: ', 'Please enter Notes', 'error');
                return false;
            }

            var candidate_id = $(this).attr('data-id');
            var jobpost_id = $(this).attr('data-jobpost-id');

            $.ajax({
                type:"GET",
                url:'{{route("candidate.notes")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "candidate_id": candidate_id,
                    "notes": notes,
                    "candidate_job_status_id": jobpost_id,
                },
                success:function(response){
                    if(response.success==true){
                        CKEDITOR.instances["summary-ckeditor"].setData("");
                        show_toastr('Success: ', response.message, 'success');
                        $('.notes-listing').remove();
                        $( "#candidate-notes" ).trigger( "click" );
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }

            });
        });


        //Action Create Event, Compose Email, Disqualify
        $(document).on("click", ".action-button", function () {
            var action = $(this).attr('data-original-title');
            switch(action){
                case 'Create event' :
                    var modal=$('#candidate-event-modal');
                    var id = $(this).attr('data-id');
                    var jobpostId = $(this).attr('data-jobpost-id');
                    $.ajax({
                        type:"GET",
                        url:'{{route("event.form")}}',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            "candidateId": id,
                            "jobStatusId": jobpostId,
                        },
                        success:function(response){
                            if(response.success==true){
                                $("#candidate-event-modal .modal-title").html(response.title);
                                modal.find('.event-modal-body').html(response.html);
                                modal.modal('show');
                            }else{
                                show_toastr('Error: ', response.message, 'error');
                            }

                        },
                        error:function(error){
                            show_toastr('Error: ', error, 'error');
                        }
                    });
                    break
                case 'Compose mail' :
                    var candidate_id = $(this).attr('data-candidate-id');
                    var jobpost_id = $(this).attr('data-Jobpost-id');
                    $.ajax({
                        type:"GET",
                        url:'{{route("mail.form")}}',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            // "stage_id": stage_id,
                            "candidate_id": candidate_id,
                            "jobpost_id": jobpost_id,
                        },
                        success:function(response){
                            if(response.success==true){
                                $("#mailModal .mail-modal-body").html(response.html);
                                $('#mailModal .modal-title').html(response.title);
                                CKEDITOR.replace('mail-content');
                                $('#mailModal').modal('show');
                            }else{
                                show_toastr('Error: ', response.message, 'error');
                            }
                        },
                        error:function(error){
                            show_toastr('Error: ', error, 'error');
                        }
                    });
                    break
                case 'Disqualify' :
                    // var stage_id = $(this).attr('data-stage-id');
                    // $(this).addClass('text-primary');
                    // $('.stages').removeClass('text-primary')
                    var candidate_id = $(this).attr('data-candidate-id');
                    var jobpost_id = $(this).attr('data-Jobpost-id');
                    $.ajax({
                        type:"GET",
                        url:'{{route("disqualify.form")}}',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            // "stage_id": stage_id,
                            "candidate_id": candidate_id,
                            "jobpost_id": jobpost_id,
                        },
                        success:function(response){
                            if(response.success==true){
                                $("#disqualifyModal .disqualifyModal-body").html(response.html);
                                // modal.find('.event-modal-body').html(response.html);
                                $('#disqualifyModal').modal('show');
                            }else{
                                show_toastr('Error: ', response.message, 'error');
                            }
                        },
                        error:function(error){
                            show_toastr('Error: ', error, 'error');
                        }
                    });
                    break
            }
        });

        // Save Event
        $(document).on("click", "#save-event", function () {
            var hidden_id = $("input[name='id']").val();
            var candidate_id = $("input[name='candidate_id']").val();
            var candidate_job_status_id = $("input[name='candidate_job_status_id']").val();
            var event_type = $("#event_type").val();
            var event_start_datetime = $("input[name='event_start_datetime']").val();
            var event_end_datetime = $("input[name='event_end_datetime']").val();
            var location = $("input[name='location']").val();
            var attendees = $("#attendees").val();
            var description = $("#description").val();
            var isValid = true;

            if(event_type == ""){
                $('#event_type_error').html('Please select event type.');
                isValid = false;
            }else{
                $('#event_type_error').html('');
            }
            if(event_start_datetime == "" || event_end_datetime == ""){
                $('#event_date_error').html('Please select Event Date time.');
                isValid = false;
            }else if(event_start_datetime > event_end_datetime){
                $('#event_date_error').html('Please select Event Datetime in ascending order.');
                isValid = false;
            }else{
                $('#event_date_error').html('');
            }

            if(location == ""){
                $('#location_error').html('Please enter your location.');
                isValid = false;
            }else{
                $('#location_error').html('');
            }
            if(attendees == ""){
                $('#attendees_error').html('Please select atleast one attendees.');
                isValid = false;
            }else{
                $('#attendees_error').html('');
            }
            if(description == ""){
                $('#description_error').html('Enter the event description.');
                isValid = false;
            }else{
                $('#description_error').html('');
            }
            if(isValid == true){
                $.ajax({
                    type:"POST",
                    url:'{{route("candidate.event.save")}}',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id": hidden_id,
                        "candidate_id": candidate_id,
                        "candidate_job_status_id": candidate_job_status_id,
                        "event_type": event_type,
                        "event_start_datetime": event_start_datetime,
                        "event_end_datetime": event_end_datetime,
                        "location": location,
                        "attendees": attendees,
                        "description": description,
                    },
                    success:function(response){
                        if(response.success==true){
                            $('#candidate-event-modal').find('.event-modal-body').html('');
                            $('#candidate-event-modal').modal('hide');
                            show_toastr('Success :', response.message, 'success');
                            $('.event-listing').remove();
                            $( "#candidate-event" ).trigger( "click" );
                        }else{
                            show_toastr('Error: ', response.message, 'error');
                        }

                    },
                    error:function(error){
                        show_toastr('Error: ', error, 'error');
                    }
                });
            }

        });

        // Get Event
        $(document).on("click", "#candidate-event", function(){
            var candidate_id = $('#candidate-event').attr('data-candidate-id');
            var candidate_job_id = $('#candidate-event').attr('data-candidatejob-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.get.events")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "candidate_id": candidate_id,
                    "candidate_job_id": candidate_job_id,
                },
                success:function(response){
                    if(response.success==true){
                        $('.event-listing').remove();
                        $('.no-data-found-wrapper.text-center.p-primary.empty').remove();
                        $("#events").append(response.html);
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }

            });
        });

        // Open Edit Event Modal
        $(document).on("click", '.edit-event', function () {
            var event_id = $(this).attr('data-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.edit.events")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id": event_id
                },
                success:function(response){
                    if(response.success==true){
                        $("#candidate-event-modal .modal-title").html(response.title);
                        $('#candidate-event-modal').find('.event-modal-body').html(response.html);
                        $('#candidate-event-modal').modal('show');
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }

            });
        });

        //Delete Event
        $(document).on("click", ".delete-event", function () {
            var event_id = $(this).attr('data-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.delete.events")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id": event_id
                },
                success:function(response){
                    if(response.success==true){
                        show_toastr('Success: ', response.message, 'success');
                        $('.event-listing').remove();
                        $( "#candidate-event" ).trigger( "click" );
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }
            });
        });


        $(document).on("click", '.candidate-event-detail', function () {
            var event_id = $(this).attr('data-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.view.events")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id": event_id
                },
                success:function(response){
                    if(response.success==true){
                        $("#event-view-modal .modal-title").html(response.title);
                        $('#event-view-modal').find('.modal-body').html(response.html);
                        $('#event-view-modal').modal('show');
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }
            });
        });

        // save Jobpost stages
        $(document).on("click", ".stages", function () {
            var stage_id = $(this).attr('data-stage-id');
            $(this).addClass('text-primary');
            $('.stages').removeClass('text-primary')
            var candidate_id = $(this).attr('data-candidate-id');
            var jobpost_id = $(this).attr('data-Jobpost-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.stage.update")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "stage_id": stage_id,
                    "candidate_id": candidate_id,
                    "jobpost_id": jobpost_id,
                },
                success:function(response){
                    if(response.success==true){
                        $('#selected-stage').html(response.stage);
                        show_toastr('Success: ', response.message, 'success');
                        $('#disqualifyModal').modal('hide');
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }
            });
        });

        // Get Timeline
        $(document).on("click", "#view-timeline", function () {
            var candidate_id = $(this).attr('data-candidate-id');

            $.ajax({
                type : "GET",
                url : "{{route('candidate.get.timeline')}}",
                data : {
                    "_token": "{{ csrf_token() }}",
                    "id" : candidate_id
                },
                success:function(response) {
                    if(response.success==true){
                        $("#timeline").html(response.html);
                    }
                },
                error:function (error) {
                    show_toastr('Error: ', error , 'error');
                }
            });
        });

        // unassign each job
        $(document).on("click", "#view-timeline", function () {
            var candidate_id = $(this).attr('data-candidate-id');

            $.ajax({
                type : "GET",
                url : "{{route('candidate.get.timeline')}}",
                data : {
                    "_token": "{{ csrf_token() }}",
                    "id" : candidate_id
                },
                success:function(response) {
                    if(response.success==true){
                        $("#timeline").html(response.html);
                    }
                },
                error:function (error) {
                    show_toastr('Error: ', error , 'error');
                }
            });
        });

        // save review
        $(document).on("click", ".save-star", function () {
            var candidate_id = $(this).attr('data-candidate-id');
            var jobpost_id = $(this).attr('data-Jobpost-id');
            var review_points = $(this).attr('data-star-value');
            $(this).siblings().removeClass('active');
            for(var i = 1 ; i <= review_points; i++){
                $("li[data-star-value='" + i + "']").addClass('active');
            }
            $.ajax({
                type : "GET",
                url : "{{route('candidate.save.review')}}",
                data : {
                    "_token": "{{ csrf_token() }}",
                    "id" : candidate_id,
                    "jobpost_id" : jobpost_id,
                    "review_points" : review_points
                },
                success:function(response) {
                    if(response.success==true){
                        $("#timeline").html(response.html);
                        $('.rating-count').html(response.review);
                    }
                },
                error:function (error) {
                    show_toastr('Error: ', error , 'error');
                }
            });
        });

        // Get Questions
        $(document).on("click", "#candidate-questions", function(){
            var candidate_id = $(this).attr('data-candidate-id');
            var jobpost_id = $(this).attr('data-candidatejob-id');
            var slug = $(this).attr('data-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.questions")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "candidate_id": candidate_id,
                    "jobpost_id": jobpost_id,
                    "slug": slug,
                },
                success:function(response){
                    if(response.success==true){
                        $('#questions').html(response.html);
                        // $('.notes-listing').remove();
                        // $('.no-data-found-wrapper.text-center.p-primary.empty').remove();
                        // $("#show-notes").append(response.html)
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }

            });
        });

        // Get Attachment
        $(document).on("click", "#candidate-attachment", function(){
            var candidate_id = $(this).attr('data-candidate-id');
            var jobpost_id = $(this).attr('data-candidatejob-id');
            $.ajax({
                type:"GET",
                url:'{{route("candidate.attachment")}}',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "candidate_id": candidate_id,
                    "jobpost_id": jobpost_id,
                },
                success:function(response){
                    if(response.success==true){
                        $('#attachments').html(response.html);
                        // $('.notes-listing').remove();
                        // $('.no-data-found-wrapper.text-center.p-primary.empty').remove();
                        // $("#show-notes").append(response.html)
                    }
                    else{
                        show_toastr('Error: ', response.message, 'error');
                    }
                },
                error:function(error){
                    show_toastr('Error: ', error, 'error');
                }

            });
        });


        $(document).on("click", "#mail-send", function () {
            var candidate_id = $('#candidate_id').val();
            var jobpost_id = $('#jobpost_id').val();
            var subject = $('#subject').val();
            var content = CKEDITOR.instances["mail-content"].getData();
            var error = false;
            if(subject == ""){
                $('#subject-error').text('This field is required.');
                error = true;
                return false;
            }else{
                $('#subject-error').text('');
            }
            if(content == ""){
                $('#content-error').text('This field is required.');
                error = true;
                return false;
            }else{
                $('#content-error').text('');
            }
            if(error == false){
                $.ajax({
                    type:"GET",
                    url:'{{route("send.mail")}}',
                    data:{
                        '_token' : "{{ csrf_token() }}",
                        'candidate_id' : candidate_id,
                        'jobpost_id' : jobpost_id,
                        'subject' : subject,
                        'maildata' : content,
                    },
                    success:function(response){
                        if(response.success==true){
                            $('#mailModal').modal('hide');
                            show_toastr('Success : ', response.message, 'success');
                        }
                        else{
                            show_toastr('Error: ', response.message, 'error');
                        }
                    },
                    error:function(error){
                        show_toastr('Error: ', error, 'error');
                    }

                });
            }
        })

    </script>
@endpush
