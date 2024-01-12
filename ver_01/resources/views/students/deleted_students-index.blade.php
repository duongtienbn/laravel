@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h3>Student List</h3><br>
                    </div>
                    <div class="col-md-2">
                        <div class="dropdown float-end">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Menu
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('students.index') }}">Home <i
                                            class="fa-solid fa-house"></i></a></li>
                                <li><a href="{{ route('student.create') }}" class="addNewSt dropdown-item">Add
                                        New <i class="fa-solid fa-plus"></i></a></li>
                                <li><a class="dropdown-item" href="{{ route('deleted_student.index') }}">Deleted Student <i
                                            class="fa-solid fa-trash"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <form action="{{ route('deleted_student.index') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong>Type: </strong>
                                        <select name="type" id="type" class="form-select">
                                            <option value="name">Name
                                            </option>
                                            <option value="age">Age
                                            </option>
                                            <option value="skill_se">Skill
                                            </option>
                                            <option value="phone">Phone
                                            </option>
                                            <option value="email">Email
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div id="search-input">
                                            <br><input type="text" name="value" id="value" class="form-control"
                                                autocomplete="off" placeholder="Enter Text...">
                                        </div>
                                        <div id="search-select">
                                            <br><select name="skill_se[]" id="skill_se" multiple>
                                                @foreach ($skills as $skill)
                                                    <option value="{{ $skill->name }}"
                                                        {{ is_array($selectVal) && in_array($skill->name, $selectVal) ? 'selected' : '' }}>
                                                        {{ $skill->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <strong></strong><br>
                                    <button type="submit" class="btn btn-light">Search <i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div><br>
                        </form>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @if (Session::has('information'))
                    <div class="alert alert-success">
                        {{ Session::get('information') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="list-style-type:decimal;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>氏名</th>
                        <th>氏名（カタカナ）</th>
                        <th>性別（男/女）</th>
                        <th>生年月日</th>
                        <th>出身国</th>
                        <th>電話番号</th>
                        <th>メールアドレス</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->name_kana }}</td>
                            <td>
                                @php
                                    if ($student->sex === 0) {
                                        echo '不明';
                                    } elseif ($student->sex === 1) {
                                        echo '男';
                                    } elseif ($student->sex === 2) {
                                        echo '女';
                                    }
                                @endphp
                            </td>
                            <td>{{ $student->birthday }}</td>
                            <td>{{ $student->country }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <form action="{{ route('student.restore', $student->id) }}" method="POST">
                                    @csrf
                                    <a href="{{ route('student.show', $student->id) }}" class="btn btn-info">View <i
                                            class="fa-solid fa-user"></i></a>
                                    <button type="submit" class="btn btn-warning"
                                        onclick="return confirm('Restoreしてもよろしいですか？')">Restore <i
                                            class="fa-solid fa-rotate-right"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{ $students->links() }}
            </table>
        </div>
        <a href="{{ route('students.index') }}" class="reloadAll btn btn-primary float-end">Reload <i
                class="fa-solid fa-rotate-right"></i></a>
    </div>
@endsection
@section('scripts')
    <script>
        new MultiSelectTag('skill_se') // id
    </script>
    <script>
        $(document).ready(function() {
            var arrType = []
            $('#type').change(function() {
                var selectedOption = $(this).val();
                sessionStorage.setItem("type_value", selectedOption);
                changeOptions();
            });

            function changeOptions() {
                var typeVal = sessionStorage.getItem("type_value");
                if (typeVal === 'skill_se') {
                    $('#search-input').hide();
                    $('#search-select').show();
                } else if (typeVal === 'deleted') {
                    $('#search-select').hide();
                    $('#search-input').hide();
                } else {
                    $('#search-select').hide();
                    $('#search-input').show();
                }
            };
            changeOptions();
            var ValueVal = sessionStorage.getItem("value_value");
            $("#value").val(ValueVal);
            $(document).on('click', '.addNewSt', function(e) {
                sessionStorage.clear();
            });
            $("#value").on("input", function() {
                sessionStorage.setItem("value_value", $(this).val());
            });
            $(document).on('click', '.reloadAll', function(e) {
                sessionStorage.clear();
            });
        });
        $(window).on("load", function() {
            var typeVal = sessionStorage.getItem("type_value");
            $('#type option[value="' + typeVal + '"]').prop('selected', true);
        });
    </script>
    <style>
        .dropdown-item:hover {
            background-color: rgb(11, 186, 240);
        }
    </style>
@endsection
