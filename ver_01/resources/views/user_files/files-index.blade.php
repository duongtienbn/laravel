@extends('layout')

@section('content')
	<div class="container">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6">
					<h3></h3>
				</div>
				<div class="currentUrl col-md-6">
					<a href="{{ url()->previous() }}" class="btn btn-primary float-end">Back</a>
				</div>
			</div>
		</div>
		{{-- Разделение кнопок и отображения списка файлов --}}
		<div class="row">
			<div class="col-md-2">
				<form method="POST" action="{{ route('file.upload', ['id' => $id]) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="file" class="btn btn-primary">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload"
								viewBox="0 0 16 16">
								<path
									d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
								<path
									d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
							</svg> Upload file
						</label>
						<input type="file" class="file-input" id="file" name="file" onchange="this.form.submit()">
					</div>
					<style>
						.file-input {
							display: none;
						}
					</style>
				</form>
			</div>

			{{-- FILES LIST --}}
			<div class="col-md-10">
				<table class="table">
					{{-- TABLE HEAD --}}
					<thead>
						<tr>
							<td scope="col">#</td>
							<td scope="col">file name</td>
							<td scope="col">size</td>
							<td scope="col">type</td>

						</tr>
					</thead>
					{{-- TABLE BODY --}}
					<tbody>
						@foreach ($files as $file)
							<tr>
								<td>{{ $loop->iteration }}</td>
								{{-- file link for open in new window --}}
								<td><a href="{{ route('file.show', ['id' => $id, 'fileName' => $file['name']]) }}" target="_blank"
										class="text-decoration-none">{{ $file['name'] }}</a></td>
								<td>{{ $file['size'] }} Bytes</td>
								<td>{{ $file['extension'] }}</td>

								{{-- FILE DOWNLOAD --}}
								<td>
									<a href="{{ route('file.download', ['id' => $id, 'fileName' => $file['name']]) }}">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
											class="bi bi-download" viewBox="0 0 16 16">
											<path
												d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
											<path
												d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
										</svg>
									</a>
								</td>

								{{-- FILE DELETE --}}
								<td class="px-2">
									<a href="{{ route('file.delete', ['id' => $id, 'fileName' => $file['name']]) }}">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
											viewBox="0 0 16 16">
											<path
												d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
											<path
												d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
										</svg>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        var currentUrl = sessionStorage.getItem("currentUrl");
        if(currentUrl) {
            $('.currentUrl').find('a').attr("href", currentUrl);
        }
    })
</script>
@endsection
