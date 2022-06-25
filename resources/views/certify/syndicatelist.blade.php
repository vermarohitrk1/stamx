
<div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">

                        <thead class="thead-light">
                            @if($status == 'pending')
                            <br>
                            <p class="mb-0 h6 text-sm" style="margin-left: 24px;">List of pending approval syndicate courses.</p><br>
                            @else
                            <br>
                            <p class="mb-0 h6 text-sm" style="margin-left: 24px;">Select a course to promote and earn 40% of the sale.</p><br>
                            @endif
                            
                        <tr>
                            <th class="name mb-0 h6 text-sm"> {{__('Course Name')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Type')}}</th>
                            <th class="name mb-0 h6 text-sm"> {{__('Price')}}</th>
                            @if($status == 'pending')
                             <th class="name mb-0 h6 text-sm"> {{__('Status')}}</th>
                            @endif
                            <th class="text-right name mb-0 h6 text-sm"> {{__('Select')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($syndicate) > 0)
                        @foreach($syndicate as $index => $Certify)
                    <tr>
                        <th scope="row" class="text-sm">
                            <div class="media align-items-center">
                                <div class="media-body" style="color:black;">
                                    {{ $Certify->name }}
                                </div>
                            </div>
                        </th>
                        <td class="name mb-0 h6 text-sm">{{ $Certify->type }}</td>
                        <td class="name mb-0 h6 text-sm">${{ $Certify->price }}</td>
                        @if($status == 'pending')
                        <td class="name mb-0 h6 text-sm @if($Certify->syndicate_approval == 'APPROVE') text-green @else text-danger @endif"><i class="fas fa-circle"></i>{{ $Certify->syndicate_approval }}</td>
                        <td class="text-right text-green">

                            <a href="{{ url('certify/syndicate/approve?certifyId=')}}{{$Certify->id}}" data-id="{{ $Certify->type }}">
                                <i class="fas fa-check-circle"></i>
                            </a>
                        </td>
                        @else
                        <td class="text-right">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitches{{$Certify->id}}" value="{{$Certify->id}}">
                                <label class="custom-control-label" for="customSwitches{{$Certify->id}}"></label>
                            </div>
                        </td>
                        @endif
                    </tr>
                @endforeach
                @else
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center">{{__('No Course found')}}</h6></th>
                    </tr>
                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
