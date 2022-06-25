 @foreach($childs as $child)
 <li><a class="dropdown-item {{ count($child->childs) ? 'dropdown-toggle' :'' }}" href="{{$child->url}}">{{ $child->title }}</a>
       @if(count($child->childs))
          <ul class="dropdown-menu">
              <li>
                 <a class="dropdown-item" href="{{$child->url}}" style="position: absolute;">
                     @include('layout.stemx.menusub',['childs' => $child->childs])
                  </a>
                </li>
            </ul>
        @endif
   </li>
 @endforeach