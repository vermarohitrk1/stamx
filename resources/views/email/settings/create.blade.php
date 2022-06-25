 {{ Form::open(['route' => ['site.settings.store'],'id' => 'update_setting']) }}
                                 @csrf  
                                 <input type="hidden" name="mailer_id" id="mailer_id" value="{{$id??0}}" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('mail_default', __('Mail Default'),['class' => 'form-control-label']) }}
                                    {{ Form::select('mail_default',array('Yes' => 'Yes', 'No' => 'No'), $mailer_settings['MAIL_DEFAULT']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Default')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_driver', __('Mail Driver'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_driver', $mailer_settings['MAIL_DRIVER']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Driver')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_host', __('Mail Host'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_host',  $mailer_settings['MAIL_HOST']??'' , ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Host')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_port', __('Mail Port'),['class' => 'form-control-label']) }}
                                    {{ Form::number('mail_port', $mailer_settings['MAIL_PORT']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Port'),'min' => '0']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_username', __('Mail Username'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_username', $mailer_settings['MAIL_USERNAME']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Username')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_password', __('Mail Password'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_password', $mailer_settings['MAIL_PASSWORD']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Password')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_encryption', __('Mail Encryption'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_encryption', $mailer_settings['MAIL_ENCRYPTION']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Encryption')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_from_address', __('Mail From Address'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_from_address', $mailer_settings['MAIL_FROM_ADDRESS']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail From Address')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_from_name', __('Mail From Name'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_from_name', $mailer_settings['MAIL_FROM_NAME']??'', ['class' => 'form-control','required'=>'required','placeholder' => __('Mail From Name')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="text-left">
                                    <button type="button" class="btn btn-sm btn-warning rounded-pill send_email" data-title="{{__('Send Test Mail')}}" data-url="{{route('test.email')}}">{{__('Send Test Mail')}}</button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-right">
                                    {{ Form::hidden('from','mailer') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}