<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
        .html_input_field{display: none;}
        .each_description_input{display: none;}.each_description_content {margin-bottom: 15px;}
        .rightIconBar i {cursor: pointer;}
        .each_description_input .input-group {margin-bottom: 15px;}
    </style>
</head>
<body class="m-3">
<div calss="head">
    <div class="rounded-circle text-center mt-5">
        <img src="{{asset($job->getJobPostLogo())}}" alt="">
    </div>
</div>
@if($jobPost = $job->getJobPost)
    {!! $jobPost->content !!}
@else
    <div class="body mt-2">
        <h2 class="text-center">{{ $job->job_title }}</h2>
        <h5 class="text-secondary text-center">{{ $job->job_name }} - {{ $job->location_address }}</h5>
        <h5 class="text-center text-primary location">
            <span class="jobLocation html_content">Job type-Location</span>
        </h5>
        <h2>About Job</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry
            standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
            a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
            Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions
            of Lorem Ipsum</p>
        <h2>About Employee</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry
            standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
            a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
            Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions
            of Lorem Ipsum</p>
        <h2>About requirement</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry
            standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
            a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
            Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions
            of Lorem Ipsum</p>
        <h2>Extended Heading</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry
            standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
            a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
            Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions
            of Lorem Ipsum</p>
    </div>
@endif
<div class="footer bg-light p-5 mb-5">
    <span style="font-size:25px">Apply for the post Job Title</span>
    <a href="{{ route('jobpost.apply', encrypted_key($job->id, 'encrypt')) }}" class="btn btn-outline-primary btn-sm rounded-pill float-right">Apply Now</a>
</div>
</body>
</html>
