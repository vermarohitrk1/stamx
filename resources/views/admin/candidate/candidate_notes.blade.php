<?php
/**
 * @var App\Candidate $data;
 */
?>
@if(!empty($data))
    @foreach($jobpostNotes as $notes)
        <div class="card shadow border-0 mt-3 notes-listing">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatars-w-40">
                            <div class="no-img rounded-circle avatar-bordered">
                                {{ $data->getCandidateNameLabel($data->id) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <h6 class="mb-1">{{ $data->getCandidateName($data->id) }}</h6>
                            <p class="text-muted font-size-90 mb-0">
                                {{ jobDateFormat($notes->updated_at, true) }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-start">
                        <a href="javascript:void(0)" id="" class="edit-icon" data-notes-id="{{encrypted_key($notes->id, 'encrypt')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit size-18">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                        <a href="javascript:void(0)" class="ml-2 delete-icon"  data-notes-id="{{encrypted_key($notes->id, 'encrypt')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 size-18">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="summary-ckeditor-data{{encrypted_key($notes->id, 'encrypt')}}" style="display:block;">
                    {!! $notes->notes !!}
                </div>
                <div class="summary-ckeditor{{encrypted_key($notes->id, 'encrypt')}}" style="display: none">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-control-label"></label>
                                <textarea id="summary-ckeditor{{encrypted_key($notes->id, 'encrypt')}}"  class="form-control editor1"  name="notes-editor{{encrypted_key($notes->id, 'encrypt')}}" placeholder="Notes....." rows="10" minlength="30" maxlength="500" required="" >{{!empty($notes->notes) ? $notes->notes :''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-secondary mr-2 cancel-update" data-notes-id="{{encrypted_key($notes->id, 'encrypt')}}">
                            Cancel
                        </button>
                        <a href="javascript:void(0)" data-id="{{ encrypted_key($notes->id, 'encrypt') }}" class="btn btn-primary notes-update-btn">
                            Update
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
@endif
