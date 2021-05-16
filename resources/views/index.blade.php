@extends('layouts.test')

@section('content')
<div class="container">
  <h2>Dashboard</h2>
  <div class="row">
  <div class="col-md-4"></div>
    <div class="col-md-6">
      <h2>Create Task</h2>
          @if(!empty(Session::get('success')))
                   <div id="successMessage">
                        <p class="alert alert-success">{{ Session::get('success') }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                    </div>
                @endif
         @if(!empty(Session::get('error')))
                   <div id="successMessage">
                        <p class="alert alert-danger">{{ Session::get('error') }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                    </div>
                @endif        
      @if ($errors->any())
       <div class="alert alert-danger">
           <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
                </ul>
            </div>
        @endif

  <form action="{{route('tasks.store')}}" method="post">
    @csrf
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="{{old('name')}}">
    </div>
    <div class="form-group">
      <label for="taskname">Task Name:</label>
      <input type="taskname" class="form-control" id="task_name" placeholder="Enter Task Name" name="task_name" value="{{old('task_name')}}">
    </div>
    <div class="form-group">
      <label for="datetime">Date & Time:</label>
     <input type="text" class="form-control datetimepicker" name="datetime" value="{{old('datetime')}}"> 
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
    </div>
   </div>
  <table class="table">
    <thead>
      <tr>
        <th>#sno</th>
        <th>Name</th>
        <th>Task Name</th>
        <th>Date Time</th>
        <th class='text-center'>Action</th>
      </tr>
    </thead>
    <tbody>
     @include('task')
    </tbody>
  </table>  
</div>
</div>
@endsection
@push("scripts")
 <script type="text/javascript">
$(document).ready(function(){
    $(function () {
            $('.datetimepicker').datetimepicker();
        });
 $(document).on('click', '#reset', function(){
   location.reload(true);
  });  
     function clear_icon()
     {
      $('#id_icon').html('');
      $('#post_title_icon').html('');
     }

 function fetch_data(page, sort_type, sort_by, query,filtername='')
 {
      $.ajax({
       url:"/pagination/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query+"&filtername="+filtername,
       success:function(data)
       {
        $('tbody').html('');
        $('tbody').html(data);
       }
      })
 }

 $(document).on('click', '.filter', function(){
      var filtername = $('#filter_name').val();
      var query = $('#serach').val();
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();
      var page = $('#hidden_page').val();
      fetch_data(page, sort_type, column_name, query,filtername);
 });

 $(document).on('click', '.sorting', function(){
      var column_name = $(this).data('column_name');
      var order_type = $(this).data('sorting_type');
      var reverse_order = '';
      if(order_type == 'asc')
      {
       $(this).data('sorting_type', 'desc');
       reverse_order = 'desc';
       clear_icon();
       $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
      }
      if(order_type == 'desc')
      {
       $(this).data('sorting_type', 'asc');
       reverse_order = 'asc';
       clear_icon
       $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
      }
      $('#hidden_column_name').val(column_name);
      $('#hidden_sort_type').val(reverse_order);
      var page = $('#hidden_page').val();
      var query = $('#serach').val();
      fetch_data(page, reverse_order, column_name, query);
 });

 $(document).on('click', '.pagination a', function(event){
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      $('#hidden_page').val(page);
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();

      var query = $('#serach').val();

      $('li').removeClass('active');
            $(this).parent().addClass('active');
      fetch_data(page, sort_type, column_name, query);
 });
});
</script>    
 @endpush