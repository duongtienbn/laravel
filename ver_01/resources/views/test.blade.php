@extends('layout')
@section('content')
    <button class="btn-add btn btn-primary" value="value1">Button 1</button>
    <button class="btn-add" value="value2">Button 2</button>
    <button class="btn-add" value="value3">Button 3</button>

    <div id="result"></div>
    <!-- Dropdown menu -->
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
            aria-expanded="false">
            Chọn một lựa chọn
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">Lựa chọn 1</a></li>
            <li><a class="dropdown-item" href="#">Lựa chọn 2</a></li>
            <li><a class="dropdown-item" href="#">Lựa chọn 3</a></li>
        </ul>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.btn-add', function() {
            var value = $(this).val();
            var p = $('<p>' + value + ' <button class="btn-delete">Delete</button></p>');
            $('#result').append(p);
        });

        $(document).on('click', '.btn-delete', function() {
            $(this).closest('p').remove();
        });
    </script>
@endsection
