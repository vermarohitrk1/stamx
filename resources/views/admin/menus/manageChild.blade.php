<ul>
	@foreach($childs as $child)
	   <li>
		<span class="spantag">{{ $child->title }} </span> <a onclick="edituserFunction({{$child->id}})"><i class="fas fa-edit"></i></a> <a onclick="deleteuserFunction({{$child->id}})"><i class="fas fa-trash"></i></a>
	   @if(count($child->childs))
				@include('admin.menus.manageChild',['childs' => $child->childs])
			@endif
	   </li>
	@endforeach
</ul>
