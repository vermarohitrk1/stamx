<div class="card">
    <div class="card-body">
        <h5 class="card-title">Qualification & Job Details</h5>
        <div class="row">
            <div class="col-md-10 col-lg-8">
                <form method="post" name="page_form" action="{{route('update.profile.qualification')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row form-row">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif                        
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Current Job Title (Optional)</label>
                                <input required="" type="text" name="job_title" maxlength="100" placeholder="Software Engineer" class="form-control" value="{{$data->job_title??''}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Type of Degree</label>
                                <input required="" type="text" name="degree" maxlength="100" placeholder="B.Sc (Maths)" class="form-control" value="{{$data->degree??''}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Major</label>
                                <input required="" type="text" name="major" maxlength="100" placeholder="Mathematics" class="form-control" value="{{$data->major??''}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>College</label>
                                <input required="" type="text" name="college" maxlength="100" placeholder="Coimbatore University" class="form-control" value="{{$data->college??''}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Program</label>
                                <select name="program" class="form-control select">
                                    <option @if(!empty($data->program) && $data->program=="Graduate") selected @endif value="Graduate" >Graduate</option>
                                    <option @if(!empty($data->program) && $data->program=="Undergraduate") selected @endif value="Undergraduate" >Undergraduate</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>