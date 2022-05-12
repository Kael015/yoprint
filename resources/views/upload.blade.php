<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

      <table class="table table-hover">
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
</body>
</html>