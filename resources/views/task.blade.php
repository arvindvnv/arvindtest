      @if(count($task)>0)
      @foreach($task as $row)
     <tr>
       <td>{{$loop->iteration}}</td>
       <td>{{ $row->name }}</td>
       <td>{{ $row->task_name }}</td>
      <td>{{ $row->datetime }}</td>
      <td align="center">
        @if($row->status==1)
          <a href="{{route('tasks.show',$row->id)}}" class="btn btn-default" role="button" onclick="return confirm('Are you sure comolete?')">Complete</a>
        @else
         <a class="btn btn-success" role="button">Complete</a>
        @endif  
           <a href="{{route('tasks.edit',$row->id)}}" class="btn btn-primary" role="button">Edit</a>
            <a href="{{route('taskdelete',$row->id)}}" class="btn btn-danger" role="button" onclick="return confirm('Are you sure to delete?')">Delete</a>
      </td>
   </tr>
  @endforeach
  @endif