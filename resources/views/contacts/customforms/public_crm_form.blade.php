
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

@php
    
     $logo =  \App\SiteSettings::logoSetting();
$logoTxt=\App\SiteSettings::logotext();
        if(!empty($logo)){
           $logo_favicon = json_decode($logo->value,true);
        }else{
            $logo_favicon = array();
        }
    @endphp
    @if (!empty($logo_favicon['favicon']))
        <link rel="shortcut icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
        <link rel="icon" href="{{ asset('storage/logo/'.$logo_favicon['favicon'])}}" type="image/x-icon">
    @endif
    <title>@yield('title') &mdash;
        @if(!empty($meta_data['meta_title'])) {{$meta_data['meta_title']}}   &mdash; @endif  {{config('app.name') }}</title>
    <link href="{{url('/public/public-page/style2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<!-- Contact us -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/css/intlTelInput.css" />
<link href="{{url('/public/public-page/simcify.min.css')}}" rel="stylesheet">
<link href="{{url('/public/public-page/style.css')}}" rel="stylesheet" type="text/css" />
<style>
.logos {
 
    margin-bottom: 0 !important;
   
}
p.p_radio {
 
    margin: auto;
}
.right-form {
   box-shadow: rgba(0, 0, 0, 0.08) 0px 2px 4px 0px, rgba(0, 0, 0, 0.1) 0px 11px 41px 8px;
    border-radius: 2px;
	    width: 100% !important;
		padding-left: 2rem;
    padding-right: 2rem;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.butn {
    padding: .5rem 1rem !important;
    font-size: 1.25rem !important;
    line-height: 1.5 !important;
    border-radius: .3rem !important;
}
.right-form ul {
   
    padding-left: 0 !important;
}
</style>
<style>
.main-class {
	background-image: url("#");
	background-size: cover;
	background-repeat: no-repeat;
	background-position: center center;
	background-attachment: fixed;
	position: relative;
	float: left;
	width: 100%;
	}
</style>
</head>
<body>
	<section class="main-class">
		<div class="#svg-fill">
			<div class="logos">
		<div class="top-logo">
		
		</div>
		
	</div>
     <div class="container">
		<div class="row">
			<div class="col-sm-2">			


			</div>
			<div class="col-sm-8">
				<div class="right-form">
                                    <h3 class="text-center centered">{{ucfirst($form->title)}}</h3>
                                    <p class="form-p text-center centered">{{$form->description}}</p>
                                     @if($form->status !="Published")
                                     <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">Nothing to fill on unpublished crm form </h6>
                    </div>
                                     @elseif(!empty($questions) && count($questions) > 0)
					{{ Form::open(['route' => 'crmcustomForm.store','id' => 'new_input_form', 'name' => 'new_input_form','enctype' => 'multipart/form-data']) }}
						<input type="hidden" name="id" value="{{!empty($form->id) ? encrypted_key($form->id,'encrypt') :0}}" />
                    <input type="hidden" name="csrf-token" value="<?= csrf_token(); ?>" />
                    
                    
						<ul>
                                                    
                                                    
                                                    
                     @foreach($questions as $i => $question)

                     <li>
                         
                         
                             @if($question->type == "checkbox")
                             <div class="form-group mt-2">
                    <label for="{{ encrypted_key($question->id,'encrypt') }}" class="font-weight-bold">{{ $question->question }}</label>                         
                             <div class="row no-gutters ">
                          <div class="col-sm-12">
                <ul class="list-unstyled mb-0">
                    @foreach(explode(",", $question->options) as $option)
                                   <li><label><input name="{{ encrypted_key($question->id,'encrypt') }}[]" type="checkbox" value="{{$option}}"> {{$option}}</label></li>
                                    @endforeach
                                      
                                  </ul>
              </div>
                       
                      </div>
                      </div>
                           
                             @elseif($question->type == "radio")
                           
                             <div class="label">
	                    <label for="{{ encrypted_key($question->id,'encrypt') }}">{{ $question->question }}</label>
	                </div>
                              @foreach(explode(",", $question->options) as $index=>$option)
                              @if($index==0)
                                        <p class="p_radio">
						<input type="radio" value="{{$option}}" name="{{ encrypted_key($question->id,'encrypt') }}" required="" > {{$option}}
					</p>
                                         @else
					<p>
						<input type="radio" value="{{$option}}" name="{{ encrypted_key($question->id,'encrypt') }}" required="" > {{$option}}
					</p>
                             @endif
                              @endforeach
                             
                                        
                             
                             @elseif($question->type == "textarea")
                             <div class="form-group">
                                 <div class="label">
	                    <label for="{{ encrypted_key($question->id,'encrypt') }}">{{ $question->question }}</label>
	                </div>
          <textarea class="form-control" placeholder="Please enter details" required="required" autocomplete="off" rows="4" name="{{ encrypted_key($question->id,'encrypt') }}" cols="50"></textarea>
        </div>
                             @elseif($question->type == "select")
                             <div class="label">
                             <label>{{ $question->question }}</label>
                         </div>
                         <div class="form-input">
                                <select class="form-control" name="{{ encrypted_key($question->id,'encrypt') }}">
                                    <option value="">Please Select</option>
                                    @foreach(explode(",", $question->options) as $option)
                                    <option @if(!empty($form_response->response) && !empty(json_decode($form_response->response, true)[$i]['question']) && json_decode($form_response->response, true)[$i]['question']==$question->question) selected @endif value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                              </div>
                             @elseif($question->type == "selectwith")
                             <div class="label">
                             <label>{{ $question->question }}</label>
                         </div>
                         <div class="form-input">
                                <select class="form-control" name="{{ encrypted_key($question->id,'encrypt') }}">
                                    <option value="">Please Select</option>
                                    @foreach(explode(",", $question->options) as $option)
                                    <option @if(!empty($form_response->response) && !empty(json_decode($form_response->response, true)[$i]['question']) && json_decode($form_response->response, true)[$i]['question']==$question->question) selected @endif value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                              </div>
                                @else
                                <div class="label">
                             <label>{{ $question->question }}</label>
                         </div>
                         <div class="form-input">
                                <input type="{{ $question->type }}" class="form-control" name="{{ encrypted_key($question->id,'encrypt') }}" placeholder="Please enter.." value="{{( !empty($form_response->response) && !empty(json_decode($form_response->response, true)[$i]['question']) && json_decode($form_response->response, true)[$i]['question']==$question->question) ? json_decode($form_response->response, true)[$i]['answer'] :''}}" required>
                                 </div>
                                @endif
                                
                        
                         
                     </li>

                    
                    @endforeach
                                                    
                            
                    
                    
                    <li class="mt-2">
					
					</li>
					<li>
                                            <input type="checkbox" name="i_agree" value="1"  > I understand & agree @if(!empty($form->agreements_url)) <a target="_Blank" href="{{$form->agreements_url}}"> read agreement</a> @endif
                                            <p class="form-p pull-right"><a href="mailto:?subject=I wanted you to see this form&amp;body=Check out this site {{route('crmshared.form',encrypted_key($form->id,'encrypt'))}}" 
                                                                                      title="Share by Email"> Share by Email</a></p>
					</li>
					<li>
                                            <button type="submit" class="butn">Submit Form 
						<a href=""><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></button>
					</li>
				</ul>
					 {{ Form::close() }}
                                     @else

                    <div class="empty-section">
                        <i class="fa fa-clipboard-text"></i>
                        <h6 class="text-danger">Nothing to fill on this crm form, no question exit! </h6>
                    </div>
                    @endif
				</div>
			</div>
                    <div class="col-sm-2">			


			</div>
		</div>
	  </div>
	</section>
	<footer class="footer">
		<div class="footer-class">
		
		
            <p class="copyright"> © Copyright {{date('Y')}} | StemX® </p>
            
		
		</div>
	</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


<!-- contact us -->
<script src="{{url('/public/public-page/bootstrap.min.js')}}"></script>
<script src="{{url('/public/public-page/simcify.min.js')}}"></script>
<script src="{{url('/public/public-page/blackdollar.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/intlTelInput.min.js"></script>
<script>
@if(Session::has('success'))
 toastr.success("{{ Session::get('success') }}", "Done!", {timeOut: null, closeButton: true});
@endif
@if(Session::has('error'))
 toastr.error("{{ Session::get('error') }}", "Oops!", {timeOut: null, closeButton: true});
@endif

  
</script>


</body>
</html>
