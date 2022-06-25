
<div class="schedule-header">

                        <div class="row">
                           
                            <div class="col-md-12">

                                <!-- Day Slot -->
                                <div class="day-slot">
                                    <ul>
                                        <li class="left-arrow">
                                            <a  onclick="filter('{{date('Y-m-d', strtotime($duration[0]['db_date'] . ' - 7 days'))}}')" href="JavaScript:void(0);">
                                                <i class="fa fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        @foreach($duration as $row)
                                        <li>
                                            <span>{{$row['day']}}</span>
                                            <span class="slot-date">{{$row['date']}} {{$row['month']}} <small class="slot-year">{{$row['year']}}</small></span>
                                        </li>
                                        @endforeach
                                        
                                        <li class="right-arrow">
                                            <a onclick="filter('{{date('Y-m-d', strtotime($duration[6]['db_date'] . ' + 1 days'))}}')" href="JavaScript:void(0);">
                                                <i class="fa fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /Day Slot -->

                            </div>
                        </div>
                    </div>
                    <!-- /Schedule Header -->

                    <!-- Schedule Content -->
                    <div class="schedule-cont">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Time Slot -->
                                <div class="time-slot">
                                    <ul class="clearfix">
                                         @foreach($duration as $row)
                                        <li>
                                           
                                            
                                            @if(!empty($data) && count($data)>0)
                                            @foreach($data as $slot)
                                           
                                            @if($slot->date==$row['db_date'])
                                             
                                              
                                            @php
                                            $checkslots=\App\MeetingScheduleSlot::where('user_id',NULL)->where('date',$slot->date)->where('start_time',$slot->start_time)->where('end_time',$slot->end_time)->first();
                                            @endphp
                                            <a data-price="{{format_price($slot->slot_price)}}" data-title="{{$slot->title}}" data-uid="{{$uid}}"  data-url="{{route('booking.checkout')}}" data-id="{{$slot->id}}" class="timing @if(empty($checkslots)) disabled bg-danger-light @else proceed_payment_model bg-success-light @endif" href="javascript:void(0)">
                                            <span class="timing @if(empty($checkslots)) disabled bg-danger-light @else    @if(empty($slot->slot_price)) bg-success-light @else bg-primary-light @endif @endif" >
                                                <span>{{date('h:i A', strtotime($slot->start_time))}}</span> - <span>{{date('h:i A', strtotime($slot->end_time))}}</span>
                                             
                                            </span>
                                             </a>
                                            @else
                                            <a class="timing" href="#">
                                                <span></span> <span></span>
                                            </a>
                                            @endif
                                            @endforeach
                                            @else
                                            <a class="timing" href="#">
                                                <span></span> <span></span>
                                            </a>
                                            @endif
                                            
                                            
                                        </li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                                <!-- /Time Slot -->
                            </div>
                        </div>
                        <hr>      
                        <span class="btn btn-lg bg-secondary-light"></span>  No Slot
                        &nbsp;&nbsp;<span class="btn btn-lg bg-danger-light"></span>  Booked
                       &nbsp;&nbsp; <span class="btn btn-lg bg-primary-light"></span> Paid Available
                       &nbsp;&nbsp; <span class="btn btn-lg bg-success-light"></span>  Free Available
                       <!--<a href="#" style="display: none" class="btn btn-lg btn-primary float-right pull-right proceed_payment_model " id="checkout_button"></a>-->
                    </div>
                    <!-- /Schedule Content -->
