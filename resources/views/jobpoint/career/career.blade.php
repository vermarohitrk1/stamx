<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="http://localhost/stemx/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="http://localhost/stemx/assets/plugins/fontawesome/css/all.min.css">
    <style type="text/css">
        .html_input_field{display: none;}
        .each_description_input{display: none;}.each_description_content {margin-bottom: 15px;}
        .rightIconBar i {cursor: pointer;}
        .each_description_input .input-group {margin-bottom: 15px;}

        .content.mt-3.job_description.job_content_body {
            min-height: fit-content !important;
        }
        .job-card {
            height: 100%;
            border-radius: .25rem;
            padding: 2rem;
            border-left: 3px solid #4466f2;
            background-color: rgba(68,102,242,.1);
        }
    </style>
</head>
<body class="m-3">
<div calss="head">
    <div class="rounded-circle text-center mt-5">
        <img src="{{asset($job->getJobPostLogo())}}" alt="">
    </div>
</div>
{!!  $JobCareer->content !!}

<h2>Job Openings</h2>
<div class="row jobopenings">
        <hr width="100%">
        @foreach($JobCareer->getActiveJobs() as $jobOpening)
            <div class="col-12 mb-primary col-md-6 col-xl-4 mb-5">
                <div class="job-card">
                    <a href="{{ route('job.preview',[encrypted_key($jobOpening->id ,'encrypt')]) }}">
                        <h5 class="text-primary">{{$jobOpening->job_title}}</h5>
                    </a>
                    <span>{{$jobOpening->job_name}}</span><br>
                    <span class="text-secondary">
                <i class="fa fa-map-marker pr-2" aria-hidden="true"></i>
                {{$jobOpening->location_address}}
                </span>
                </div>

            </div>
        @endforeach
</div>
<div class="footer p-5 mb-5">
    <div class="rounded-circle text-center mt-5">
        <img src="{{asset($job->getJobPostLogo())}}" alt="">
    </div>
    <div class="text-center mb-5 job_post_footer mt-5">
        <span>Copyright @ 2021 by Jobpoint</span>
    </div>
</div>
</body>
</html>
