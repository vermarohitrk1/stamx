
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>
        @if(!empty($detail->public_title))
            {!! $detail->public_title !!}
        @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- add icon link -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/public-page/KmiU0OY1hoopxKxTVmmEhhiNOPlmW7eh.png')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Contact us -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link href="{{asset('public/assets/css/donation_public.css')}}" rel="stylesheet" type="text/css" />
    <style>
      .logos{margin-bottom:0!important}p.p_radio{margin:auto}.right-form{box-shadow:rgba(0,0,0,.08) 0 2px 4px 0,rgba(0,0,0,.1) 0 11px 41px 8px;border-radius:2px;width:100%;padding-left:2rem;padding-right:2rem;padding-top:1rem;padding-bottom:1rem}.butn{padding:.5rem 1rem!important;font-size:1.25rem!important;line-height:1.5!important;border-radius:.3rem!important}.right-form ul{padding-left:0!important}.donationform li{display:inline-block;width:32%;text-align:center}.donationform li label{background:orange;display:block;color:#fff;font-size:20px;font-weight:500;border-radius:13px;padding:5px 0}.donationform input[type=radio]:checked+label{background:0 0;display:block;color:#000;font-size:20px;font-weight:500;padding:5px 0}.donationform input[type=radio]{display:none}.donation-level-user-entered input[type=text]{width:95%;padding:5px;margin-left:2%;border:2px solid;border-radius:3px}h4.monthly{margin-top:20px}form h4{margin-top:20px}form input[type=text]{width:100%;padding:5px;margin-left:0;border:2px solid;border-radius:3px;margin-top:10px}.cc_form select{width:32%;margin-top:10px;border:2px solid;border-radius:3px;padding:5px}#responsive_payment_typecc_cvvname{width:33%}#billing_addr_cityname,#billing_addr_country,#billing_first_namename{width:49%;float:left;clear:both}#billing_addr_state,#billing_addr_zipname,#billing_last_namename{width:49%;float:right}button.step-button{background:#ffb81c;color:#fff;border:0;font-size:20px;font-weight:700;padding:10px;border-radius:30px}.footer-navigation{display:flex}.footer-nav a{display:block}.footer-nav{width:50%}.copyright{font-size:16px;text-align:center}#error-message{margin:0 0 10px 0;padding:5px 25px;border-radius:4px;line-height:25px;font-size:.9em;color:#ca3e3e;border:#ca3e3e 1px solid;display:none;width:300px}
    </style>
       <style>
        .main-class {
            @if(!empty($detail->bgimage))
                    background-image: url("{{url('storage/details/'.$detail->bgimage)}}");
            @endif
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
            <div class="logo">
                @if(!empty($detail->image))
                    <img src="{{url('storage/details/'.$detail->image)}}" />
                @endif

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <div class="content">

                        <h1>  @if(!empty($detail->public_title))
                                {!! $detail->public_title !!}
                            @endif</h1>



                        <p>@if(!empty($detail->public_subtitle))

                            <p>{!!$detail->public_subtitle!!}</p>
                            @endif</p>
                    </div>


                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="right-form">
                        <div id="error-message"></div>
                        <form id="frmStripePayment" action="" method="POST">
                            <input type="hidden" name="_token" value="<?=csrf_token();?>" />
                            <p>
                                @if(!empty($donation_form_data->section_1))
                                    {{$donation_form_data->section_1}}
                                @endif

                            </p>

                            <ul class="donationform">
                                <li>
                                    <input type="radio" id="ten" name="donation" checked class="hidecheckbox donation_sec" value="10" onclick="valueremove('hello');">
                                    <label for="ten">$10</label>
                                </li>
                                <li>
                                    <input type="radio" id="twentyfive" name="donation" class="hidecheckbox donation_sec" value="25" onclick="valueremove('hello');">
                                    <label for="twentyfive">$25</label>
                                </li>
                                <li>
                                    <input type="radio" id="thirtyfive" name="donation" class="hidecheckbox donation_sec" value="35" onclick="valueremove('hello');">
                                    <label for="thirtyfive">$35</label>
                                </li>
                                <li>
                                    <input type="radio" id="onetwenty" name="donation" class="hidecheckbox donation_sec" value="120" onclick="valueremove('hello');">
                                    <label for="onetwenty">$120</label>
                                </li>
                                <li>
                                    <input type="radio" id="twofifty" name="donation" class="hidecheckbox donation_sec" value="250" onclick="valueremove('hello');">
                                    <label for="twofifty">$250</label>
                                </li>
                            </ul>

                            <div class="donation-level-user-entered">

                                $<input type="text" maxlength="20" class="numbers amount" placeholder="Enter Amount" id="amount" name="amount">
                            </div>
                            <h4 class="monthly">
                                @if(!empty($donation_form_data->heading_section_2))
                                    {{$donation_form_data->heading_section_2}}
                                @endif


                            </h4>
                            <p>

                                @if(!empty($donation_form_data->description_section_2))
                                    {{$donation_form_data->description_section_2}}
                                @endif

                            </p>
                            <label><input type="checkbox" id="monthlygift" name="monthlygift" value="monthlygift">
                                @if(!empty($donation_form_data->checkbox_section_2))
                                    {{$donation_form_data->checkbox_section_2}}
                                @endif					</label>
                            <hr/>

                            <div class="cc_form">
                                <h3>Credit Card Information</h3>
                                <table class="payment-type-cc">
                                    <tbody><tr>
                                        <td>
                                            <table class="payment-type-cc">
                                                <tbody><tr>
                                                    <td style="padding-right:5px;">
                                                        <img style="height: 25px;" src="{{asset('public/img/mastercard_small.png')}}" alt="MasterCard" border="0">
                                                    </td><td style="padding-right:5px;">
                                                        <img style="height: 25px;" src="{{asset('public/img/visa_small.png')}}" alt="Visa" border="0">
                                                    </td>
                                                    <td style="padding-right:5px;">
                                                        <img style="height: 25px;" src="{{asset('public/img/amex_smallsc.png')}}" alt="American Express" border="0">
                                                    </td>
                                                    <td>
                                                        <img style="height: 25px;" src="{{asset('public/img/discovercard_sm.png')}}" alt="Discover" border="0">
                                                    </td>
                                                </tr>
                                                </tbody></table>

                                        </td>
                                    </tr>
                                    </tbody></table>
                                <input type='text' class="numbers" name="card-number" maxlength="16" id="card-number" placeholder="Credit Card Number" />


                                <select name="responsive_payment_typecc_exp_date_MONTH" id="responsive_payment_typecc_exp_date_MONTH" placeholder="Expiration Date:Select month of credit card">
                                    <option value="1" @if(date('m') =="01") selected="selected" @endif>01</option>
                                    <option value="2"  @if(date('m') =="02") selected="selected" @endif>02</option>
                                    <option value="3"  @if(date('m') =="03") selected="selected" @endif>03</option>
                                    <option value="4"  @if(date('m') =="04") selected="selected" @endif>04</option>
                                    <option value="5"  @if(date('m') =="05") selected="selected" @endif>05</option>
                                    <option value="6"  @if(date('m') =="06") selected="selected" @endif >06</option>
                                    <option value="7"  @if(date('m') =="07") selected="selected" @endif>07</option>
                                    <option value="8"  @if(date('m') =="08") selected="selected" @endif>08</option>
                                    <option value="9"  @if(date('m') =="09") selected="selected" @endif>09</option>
                                    <option value="10"  @if(date('m') =="10") selected="selected" @endif>10</option>
                                    <option value="11"  @if(date('m') =="11") selected="selected" @endif>11</option>
                                    <option value="12"  @if(date('m') =="12") selected="selected" @endif>12</option>
                                </select>

                                <select name="responsive_payment_typecc_exp_date_YEAR" id="responsive_payment_typecc_exp_date_YEAR" placeholder="Select Expiration Year">
                                    @for ($i = date('Y'); $i <= date('Y')+20; $i++) {
                                    <option @if($i == date('Y')) selected="selected" @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                <input type="text" name="responsive_payment_typecc_cvvname" id="responsive_payment_typecc_cvvname" value="" maxlength="4" autocomplete="off" placeholder="CVV Number">

                                <h4>Your Information</h4>
                                <input type="text" name="billing_first_namename" id="billing_first_namename" value="" maxlength="50" placeholder="First Name" class="">
                                <input type="text" name="billing_last_namename" id="billing_last_namename" value="" maxlength="50" placeholder="Last Name">
                                <input type="text" name="billing_addr_street1name" id="billing_addr_street1name" value="" maxlength="50" placeholder="Billing Address">
                                <input type="text" name="billing_addr_cityname" id="billing_addr_cityname" value="" maxlength="50" placeholder="City">
                                <select name="billing_addr_state" id="billing_addr_state" size="1" placeholder="State/Province:">
                                    <option disabled>--Seletect State--</option>
                                    @foreach($state as $states)
                                        <option value="{{$states->id}}">{{$states->state}}</option>
                                    @endforeach

                                </select>


                                <select name="billing_addr_country" id="billing_addr_country" size="1" placeholder="Country:">
                                <option disabled>--Seletect Country--</option>
                                    <option selected="selected" value="United States">United States</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Aland Islands">Aland Islands</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antarctica">Antarctica</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivarian Republic of Venezuela">Bolivarian Republic of Venezuela</option>
                                    <option value="Bonaire, Sint Eustatios and Saba">Bonaire, Sint Eustatios and Saba</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curacao">Curacao</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Democratic People's Republic of Korea">Democratic People's Republic of Korea</option>
                                    <option value="The Democratic Republic of the Congo">The Democratic Republic of the Congo</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Federated States of Micronesia">Federated States of Micronesia</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="The Former Yugoslav Republic of Macedonia">The Former Yugoslav Republic of Macedonia</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Territories">French Southern Territories</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guernsey">Guernsey</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Islamic Republic of Iran">Islamic Republic of Iran</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jersey">Jersey</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macao">Macao</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Plurinational State of Bolivia">Plurinational State of Bolivia</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Republic of Korea">Republic of Korea</option>
                                    <option value="Republic of Moldova">Republic of Moldova</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russian Federation">Russian Federation</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Barthelemy">Saint Barthelemy</option>
                                    <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Martin (French)">Saint Martin (French)</option>
                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="S. Georgia &amp; S. Sandwich Isls.">S. Georgia &amp; S. Sandwich Isls.</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Sint Maarten (Dutch)">Sint Maarten (Dutch)</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-Leste">Timor-Leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United Republic of Tanzania">United Republic of Tanzania</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="USA Minor Outlying Islands">USA Minor Outlying Islands</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Viet Nam">Viet Nam</option>
                                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                    <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>

                                </select>

                                <input type="text" name="billing_addr_zipname" id="billing_addr_zipname" value="" maxlength="50" placeholder="ZIP/Postal Code">
                            

                                <input type="text" name="donor_email_addressname" id="donor_email_addressname" value="{{Auth::check() ? Auth::user()->email : ''}}" maxlength="50" placeholder="Email Address" class="" {{Auth::check() ? 'readonly' : ''}}>

                                <label style="margin-top:30px;" class="w-auto">
                                    <input type="checkbox" name="donor_email_opt_inname" id="donor_email_opt_inname" checked="checked" >
                                    @if(!empty($donation_form_data->checkbox_section_3))
                                        {{$donation_form_data->checkbox_section_3}}
                                    @endif

                                </label>
                                <p>

                                    @if(!empty($donation_form_data->checkbox_section_4))
                                        {{$donation_form_data->checkbox_section_4}}
                                    @endif


                                </p>
                                <input type="hidden" name="success_message" id="success_message" value="{{$donation_form_data->success_message}} ">
                                <input type="hidden" name="error_message" id="error_message" value="{{$donation_form_data->error_message}}">

                                <p style="text-align:center;">
                                    <button class="step-button action-button finish-step btnAction px-5" type="button" id="submit-btn" name="pay_now" value="Give Now" onClick="stripePay(event);">Donate</button>

                                </p>
                                <hr/>
                                <h4 style="text-align: center;"><a style="color: #000000;" href="{{$donation_form_data->continue_to_full_site}}">Continue to Site <span class="fa fa-chevron-right"></span></a></h4>
                                <hr/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
<footer class="footer">
    <div class="footer-class">


        <p class="copyright"> © Copyright {{ date("Y") }} | {{ env("APP_NAME") }} </p>


    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


<!-- contact us -->
<script src="{{asset('public/assets_admin/js/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/intlTelInput.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>

        Stripe.setPublishableKey('{{$payment['STRIPE_KEY']}}');
function button_loader($this, hook=false){
    if(hook == true){
    $this.text("Loading..");
    $this.prop('disabled',true);
    }else{
    $this.text("Donate");
    $this.prop('disabled',false);
    }
}
    function cardValidation () {

        var valid = true;
        var name = $('#billing_first_namename').val();
        var email = $('#donor_email_addressname').val();
        var cardNumber = $('#card-number').val();
        var month = $('#responsive_payment_typecc_exp_date_MONTH').val();
        var year = $('#responsive_payment_typecc_exp_date_YEAR').val();
        var cvc = $('#responsive_payment_typecc_cvvname').val();
        var lastname = $('#billing_last_namename').val();
        var address = $('#billing_addr_street1name').val();
        var city = $('#billing_addr_cityname').val();
        var state = $('#billing_addr_state').val();
        var country = $('#billing_addr_country').val();
        var zip = $('#billing_addr_zipname').val();

        $("#error-message").html("").hide();

        if (name.trim() == "") {
            valid = false;
        }
        if (lastname.trim() == "") {
            valid = false;
        }
        if (address.trim() == "") {
            valid = false;
        }
        if (city.trim() == "") {
            valid = false;
        }
        if (zip.trim() == "") {
            valid = false;
        }
        if (state.trim() == "") {
            valid = false;
        }
        if (country.trim() == "") {
            valid = false;
        }
        if (email.trim() == "") {
            valid = false;
        }
        if (cardNumber.trim() == "") {
            valid = false;
        }

        if (month.trim() == "") {
            valid = false;
        }
        if (year.trim() == "") {
            valid = false;
        }
        if (cvc.trim() == "") {
            valid = false;
        }

        if(valid == false) {
            toastr.clear();
            toastr.error("All Fields are required", "Oops!", {
                closeButton: true
            });
        }
        return valid;
    }


    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {

        if (response.error) {
            //enable the submit button
            $("#submit-btn").show();
            //display the errors on the form
            toastr.clear();
            toastr.error(response.error.message, "Oops!", {
                closeButton: true
            });
            return false;
        } else {
            //get token id
            var token = response['id'];
            //insert the token into the form
            $("#frmStripePayment").append("<input type='hidden' name='token' value='" + token + "' />");
            //submit form to the server

            var data=$('#frmStripePayment').serialize();
            $(function() {
                $.ajax({
                    type: "POST",
                    url: "{{url('/donation/insert')}}",
                    data: data,
                    success: function(data){
                        button_loader($("#submit-btn"), false);
                        if(data.success == true){
                            swal({
                                title: "Alright!",
                                text: data.message,
                                showCancelButton: false,
                                type: "success"
                            }).then(function() {
                                window.location.reload();
                            });

                        }else{
                            console.log(data);
                            swal({
                                title: "Oops!",
                                text: data.message,
                                type: "error",
                                showCancelButton: false
                            });
                        }
                    },
                    error: function(e){
                        button_loader($("#submit-btn"), false);
                    }
                });
            });
            //$("#frmStripePayment").submit();

        }
    }
    function stripePay(e) {
        e.preventDefault();
        var valid = cardValidation();

        if(valid == true) {
            
            <!-- $("#submit-btn").hide(); -->
            button_loader($("#submit-btn"), true);
            Stripe.createToken({
                number: $('#card-number').val(),
                cvc: $('#responsive_payment_typecc_cvvname').val(),
                exp_month: $('#responsive_payment_typecc_exp_date_MONTH').val(),
                exp_year: $('#responsive_payment_typecc_exp_date_YEAR').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;
        }
    }
    $(document).ready(function () {
        //called when key is pressed in textbox
        $(".numbers").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                // $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });

    });
</script>
<script>

    $(".phone-input").intlTelInput({

        autoPlaceholder: "polite",

        placeholderNumberType: "FIXED_LINE",

        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.3/js/utils.js"

    });
    $(".phone-input").blur(function() {
        if ($.trim($(this).val())) {
            if (!$(this).intlTelInput("isValidNumber")) {
                $(this).val('');
                toastr.error("Invalid phone number.", "Oops!", {timeOut: null, closeButton: true});
            }else{
                toastr.clear();
            }
        }
    })
    $(".phone-input").change(function(){
        $(this).closest(".intl-tel-input").siblings(".hidden-phone").val($(this).intlTelInput("getNumber"));
    });
    $("#amount").click(function(){
        $('.hidecheckbox').prop('checked', false);
    });
    function valueremove(val){
        if ($('.hidecheckbox').is(":checked")){
            $('#amount').val('');
        }
    }


    $( ".donation_sec" ).click(function() {
        var text = $( this ).val();

        $( ".amount" ).val( text );
    });
</script>


</body>
</html>
