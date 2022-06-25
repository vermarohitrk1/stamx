  @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
    <div class="card">
        @if(Auth::user()->id !='')
        <div class="list-group list-group-flush" id="tabs">
                    @if(in_array("manage_surveys",$permissions) || $user->type =="admin")  
            <div data-href="#form_create" class="list-group-item @if(empty($id)) text-primary @endif">
                <div class="media">
                    <i class="fas fa-font pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessment.create')}}" class="stretched-link h6 mb-1">{{__('Create Assessment Form')}}</a>
                        <p class="mb-0 text-sm">{{__('Create new assessment form...')}}</p>
                    </div>
                </div>
            </div>             
             @endif 
            @if(!empty($id))
            @if(!empty($form->user_id) && $form->user_id==Auth::user()->id)
            <div data-href="#form_edit" class="list-group-item @if($sidebar=='form_edit') text-primary @endif">
                <div class="media">
                    <i class="fas fa-edit pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessment.edit',encrypted_key($id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Edit Assessment Form')}}</a>
                        <p class="mb-0 text-sm">{{__('Edit assessment form...')}}</p>
                    </div>
                </div>
            </div>
            <div data-href="#form_question_add" class="list-group-item @if($sidebar=='form_question_add') text-primary @endif">
                <div class="media">
                    <i class="fas fa-question pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentQuestion.create',encrypted_key($id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Add / Edit Form Question')}}</a>
                        <p class="mb-0 text-sm">{{__('Add / Edit assessment form question...')}}</p>
                    </div>
                </div>
            </div>            
            <div data-href="#form_assign" class="list-group-item @if($sidebar=='form_assign') text-primary @endif">
                <div class="media">
                    <i class="fas fa-user-plus pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentForm.assign',encrypted_key($id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Assign Form')}}</a>
                        <p class="mb-0 text-sm">{{__('Assign assessment form to users...')}}</p>
                    </div>
                </div>
            </div>            
            <div data-href="#form_questions" class="list-group-item @if($sidebar=='form_questions') text-primary @endif">
                <div class="media">
                    <i class="fas fa-list pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentQuestion',encrypted_key($id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Form Questions List')}}</a>
                        <p class="mb-0 text-sm">{{__('Manage assessment form questions...')}}</p>
                    </div>
                </div>
            </div> 
            @endif
            @if((!empty($form->user_id) && $form->user_id==Auth::user()->id) ||   (in_array("manage_surveys",$permissions) || $user->type =="admin"))  
            <div data-href="#form_users_responses" class="list-group-item @if($sidebar=='form_users_responses') text-primary @endif">
                <div class="media">
                    <i class="fas fa-users pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentForm.responseUsers',encrypted_key($id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Form Users Responses')}}</a>
                        <p class="mb-0 text-sm">{{__('Manage assessment form users responses...')}}</p>
                    </div>
                </div>
            </div>            
            <div data-href="#form_questions_preview" class="list-group-item @if($sidebar=='form_questions_preview') text-primary @endif">
                <div class="media">
                    <i class="fas fa-eye pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentForm',encrypted_key($id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Preview Form')}}</a>
                        <p class="mb-0 text-sm">{{__('Preview assessment form with questions...')}}</p>
                    </div>
                </div>
            </div>            
            @endif
            
            @endif
        </div>
        @endif
        @if(!empty($form->id) && !empty($form_response->user_id))      
        @if(!empty($form_response->status))
        <div data-href="#form_questions_preview" class="list-group-item @if($sidebar=='form_questions_preview') text-primary @endif">
                <div class="media">
                    <i class="fas fa-database pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentForm',encrypted_key($form->id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Retake Assessment')}}</a>
                        <p class="mb-0 text-sm">{{__('Retake assessment form...')}}</p>
                    </div>
                </div>
            </div> 
        @else
        <div data-href="#form_questions_preview" class="list-group-item @if($sidebar=='form_questions_preview') text-primary @endif">
                <div class="media">
                    <i class="fas fa-database pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentForm',encrypted_key($form->id,'encrypt'))}}" class="stretched-link h6 mb-1">{{__('Fill Assessment Form')}}</a>
                        <p class="mb-0 text-sm">{{__('Fill assessment form...')}}</p>
                    </div>
                </div>
            </div> 
        @endif
        <div data-href="#form_response" class="list-group-item @if($sidebar=='form_response') text-primary @endif">
                <div class="media">
                    <i class="fas fa-database pt-1"></i>
                    <div class="media-body ml-3">
                        <a href="{{route('assessmentFormshow.response',['id' => encrypted_key($form->id,'encrypt'),'user_id'=>encrypted_key($form_response->user_id,'encrypt')])}}" class="stretched-link h6 mb-1">{{__('Form Response')}}</a>
                        <p class="mb-0 text-sm">{{__('Assessment form response...')}}</p>
                    </div>
                </div>
            </div> 
        
        @endif
    </div>