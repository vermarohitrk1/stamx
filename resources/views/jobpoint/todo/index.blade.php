@php
/**
 * @var \App\JobToDo[] $toDoPendings
 * @var \App\JobToDo[] $toDoComplete
*/
@endphp

@if($toDoPendings->count()>0)
    <div class="pending_todo_wraper">
        <p class="status">You have {{$toDoPendings->count()}} pending item<span>s</span></p>
        @foreach($toDoPendings as $item)
            <div class="each_item">
                <div class="bg-light m-1 pending_item">
                    <input type="checkbox" name="checkbox" value="{{$item->id}}" id="pending_{{$item->id}}">
                    <label class="todo-title m-0" for="pending_{{$item->id}}">{{$item->name}}</label>
                    <a href="javascript:void(0)" class="todo_delete float-right" data-id="{{$item->id}}"> <i class="far fa-trash-alt"></i></a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="status free"><img src="{{asset('public/images/celebration.svg')}}" alt="No items">
        Chill out! You have no pending todos.
    </p>
@endif
@if($toDoComplete->count()>0)
    <div class="complete_todo_wraper mt-4">
        <p class="status">You have {{$toDoComplete->count()}} completed item<span>s</span></p>
        @foreach($toDoComplete as $item)
            <div class="each_item">
                <div class="completed_item m-1">
                    <input type="checkbox" name="checkbox" value="{{$item->id}}" checked id="complete_{{$item->id}}">
                    <label class="todo-title m-0" for="complete_{{$item->id}}">{{$item->name}}</label>
                    <a href="javascript:void(0)" class="todo_delete float-right" data-id="{{$item->id}}"> <i class="far fa-trash-alt"></i></a>
                </div>
            </div>
        @endforeach
    </div>
@endif
<div class="d-flex justify-content-end mt-4">
    @if($toDoComplete->count()>0)
        <button type="button" class="btn btn-sm btn-primary px-2 mr-1 show_completed">
            <span>Show</span> Complete
        </button>
    @endif
    @if($toDoComplete->count()>0 || $toDoPendings->count()>0)
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center px-2 clear_todo">
            <span>Clear all</span>
        </button>
    @endif
</div>
