<?php

use Illuminate\Database\Seeder;
use App\JobCareer;
class JobCareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $careerPagehtml = [];
        $html = '
        <div class="job_header">
            <h1 class="text-center mt-3 title" id="title">
                <div class="time-picker-input mb-4 html_input_field">
                    <div class="input-group">
                        <input type="text" class="form-control" value="Come join with us" name="title">
                        <div class="input-group-append">
                <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                </span>
                        </div>
                    </div>
                </div>
                <span class="jobtitle html_content">Come join with us </span>
            </h1>
            <h4 class="text-center text-secondary subtitle" >
                <div class="time-picker-input mb-4 html_input_field">
                    <div class="input-group">
                        <input type="text" class="form-control" value="A fast going software company build web apps" name="subtitle">
                        <div class="input-group-append">
                <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                </span>
                        </div>
                    </div>
                </div>
                <span class="jobSubtitle html_content">A fast going software company build web apps</span>
            </h4>
            <h5 class="text-center text-primary location">
                <div class="time-picker-input mb-4 html_input_field">
                    <div class="input-group">
                        <input type="text" class="form-control" value="Software company-Dhaka" name="details">
                        <div class="input-group-append">
                <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                </span>
                        </div>
                    </div>
                </div>
                <span class="jobLocation html_content">Software company-Dhaka</span>
            </h5>
        </div>
        <div class="rightIconBar float-right mt-3">
            <div class="icon">
                <i class="fas fa-plus appendDescription"></i>
                <i class="far fa-edit pl-2 pr-2 editButton"></i>
                <i class="fas fa-check updateDescription"></i>
            </div>
        </div>
        <div class="content mt-3 job_description job_content_body">
            <div class="each_description">
                <div class="each_description_input">
                    <div class="input-group">
                        <input type="text" value="About Us" class="form-control input_heading" name="descriptoin_header_1">
                        <div class="input-group-append bg-success pl-3 pr-3 p-2 ml-2 rounded">
                            <i class="fas fa-trash-alt mt-2"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea type="text" class="form-control rounded-0 textarea_content" name="descriptoin_content_1" rows="15" col="10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</textarea>
                    </div>
                </div>
                <div class="each_description_content">
                    <h2 class="description_heading">About Us</h2>
                    <p class="description_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                </div>
            </div>
            <div class="each_description">
                <div class="each_description_input">
                    <div class="input-group">
                        <input type="text" value="Service we provide" class="form-control input_heading" name="descriptoin_header_2">
                        <div class="input-group-append bg-success pl-3 pr-3 p-2 ml-2 rounded">
                            <i class="fas fa-trash-alt mt-2"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea type="text" class="form-control rounded-0 textarea_content" name="descriptoin_content_2" rows="15" col="10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</textarea>
                    </div>
                </div>
                <div class="each_description_content">
                    <h2 class="description_heading">Service we provide</h2>
                    <p class="description_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                </div>
            </div>
        </div>';
        $careerPagehtml['content'] = $html;

        JobCareer::create($careerPagehtml);
    }
}
