<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
</head>
<body>
<div class="row">
		<div class="container">
			<div class="col-lg-8 mx-auto my-5">	
 
				<form action="{{asset('/proses')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
 
					<div class="form-group">
						<input type="file" name="import" id="import">
					</div>
 
					<input type="submit" value="Upload" class="btn btn-primary"> 
				</form>
			</div>

      <table class="table table-hover" id="data_file">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Time</th>
            <th scope="col">File Name</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($list_file as $file)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{$file->created_at}}<br>{{$file->created_at->diffForHumans()}}</td>
            <td>{{$file->file_name}}</td>
            <td>{{$file->status}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
		</div>
	</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function(){

      var interval = 10000;
      var table = $('#data_file').DataTable();
      function sendRequest(){
        $.ajax({
          url:"{{ asset('/upload') }}",
          dataType:'json',
          success: function(data){
              console.log(data);
              var table = $('#data_file').DataTable();
              var DataLeads = data;
              table.clear().draw()


              DataLeads.map((e, index)=>{ 
                  
                  if (typeof e.created_at === 'undefined') {
                  e.created_at = "";
                  }
                  if (typeof e.file_name === 'undefined') {
                  e.file_name = "";
                  }
                  
                  table.row.add([
                      index,
                      e.created_at,
                      e.file_name,
                      e.status,
                  
                  ]).draw()
              }) 
          },
          complete: function (data) {
                  // Schedule the next
                  setTimeout(sendRequest, interval);
          }
        });

      };

      setTimeout(sendRequest, interval);

    });
  </script>
</body>
</html>