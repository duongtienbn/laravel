@extends('layout')
@section('content')
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a href="{{ route('students.index') }}"><img class="img-fluid" src="{{ asset('images/logo.png') }}"
                    alt="株式会社 リンクスタッフ"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('students.index') }}">ホーム</a>
                    </li>
                    <li class="nav-item dropdown">
                        @auth
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                        @else
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown link
                            </a>
                        @endauth
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('student.create') }}" id="addStdnt">Action</a></li>
                            @if (auth()->user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('deleted_student.index') }}">削除した学生 <i
                                            class="fa-solid fa-trash"></i></a></li>
                            @endif
                            @auth
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"
                                            onclick="return confirm('ログアウトしますか？')">ログアウト <i class=""></i></button>
                                    </form>
                                </li>
                            @endauth
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="" style="display:flex; justify-content:space-between; align-items:center">
            <h3>学生リスト</h3>
            <form id="exelForm" action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (auth()->user()->role == 'admin')
                    <input type="file" id="import" name="file" class="form-control" hidden>
                    <label for="import" class="btn btn-light" title="Import"><i class="fa-solid fa-file-import"></i> <span
                            class="hideClmn_2">インポート</span></label>
                @endif
                <a class="btn btn-light" href="{{ route('students.export') }}" title="Export"><i
                        class="fa-solid fa-file-export"></i>
                    <span class="hideClmn_2">エクスポート</span></a>
                <a href="{{ route('student.create') }}" class="New btn btn-light" title="Add New Student">
                    <i class="fa-solid fa-circle-plus"></i> <span
                        class="hideClmn_2">新規追加</span></a>
            </form>
            <form id="myForm" action="{{route('student.pdf')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div>
                    <input type="file" id="fileInput" name="file" style="display: none;">
                    <button type="button" id="selectAndSubmitButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0e75ed"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                    </button>
                </div>
            </form>
        </div>
        <form action="{{ route('students.index') }}" method="GET" id="search-form">
            @csrf
            <div class="row">

                <div class="col-md-3">
                    <div class="row">
                        {{--  --}}
                        <div class="col-md-6">
                            <div class="form-group">
                        <strong>タイプ </strong>
                        <select name="type" id="type" class="form-select">
                            <option value="name">氏名
                            </option>
                            <option value="age">年齢
                            </option>
                            <option value="skill_se">SEスキル
                            </option>
                            <option value="phone">電話番号
                            </option>
                            <option value="email">Eメール
                            </option>
                            <option value="country">出身国
                            </option>
                            <option value="interview_date">面接日
                            </option>
                        </select>
                    </div>
                        </div>
                        <div class="search_interview_date col-md-6">
                            <br>
                            <select class="form-select" id="date_type" name="date_type" style="">
                                <option value="first_interv_date">一次面接</option>
                                <option value="sec_interv_date">二次面接</option>
                                <option value="intern_interv_date">インターン</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div id="search-input">
                            <br>
                            <input type="text" name="value" id="value" class="form-control" autocomplete="off"
                                placeholder="Enter Text...">
                        </div>
                        {{-- スキルで検索 --}}
                        <div class="row" id="search-select">
                            <div class="col-md-1" style="none">
                                <br>
                                <button type="button" style="display:none;" class="btn btn-light" id="skillbtn"
                                    data-bs-toggle="modal" data-bs-target="#skillModal">
                                    <iconify-icon icon="game-icons:click"></iconify-icon>
                                </button>
                            </div>
                            <div class="col-md-11">
                                <div class="skillText">
                                    <br>
                                    <div class="col-12 text-nowrap">
                                        <textarea class="form-control" name="searchName" id="skillText" rows="3" style="height: 17px;" disabled>{{ $searchName ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- 国別で検索 --}}
                        <div id="search_country">
                            <br><select name="country_value[]" id="country_value" multiple>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->name }}">
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- 面接日で探す --}}
                        <div class="search_interview_date">
                            <div id="search-date" class="" style="display: flex;">
                                <div class="col-md-5">
                                    <strong>Start Day</strong>
                                    <input type="date" class="form-control" style="width:" name="start_day"
                                        id="startday_value">
                                </div>
                                <div class="col-md-2" style="padding:3.5%;font-size:1.5rem">~</div>
                                <div class="col-md-5">
                                    <strong>End Day</strong>
                                    <input type="date" class="form-control" style="width:" name="end_day"
                                        id="endday_value">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <strong></strong><br>
                    <button type="submit" class="btn btn-light">検索 <i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div><br>
        </form>
        <div class="table-responsive text-nowrap mt-3">
            <div class="col-md-12">
                <div id="alert-successByJQ"></div>
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
            <table class="table table-striped" id="mainTbl">
                <thead>
                    <tr>
                        <th>番目</th>
                        <th>氏名</th>
                        <th class="hideClmn">氏名（カタカナ）</th>
                        <th class="hideClmn">性別（男/女）</th>
                        <th class="hideClmn ">生年月日</th>
                        <th class="hideClmn ">出身国</th>
                        <th class="hideClmn_2">電話番号</th>
                        <th class="hideClmn_2">メールアドレス</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td><a href="{{ route('student.show', $student->id) }}" class="">{{ $student->name }}
                            </td>
                            <td class="hideClmn"><a href="{{ route('student.show', $student->id) }}"
                                    class="">{{ $student->name_kana }}</a></td>
                            <td class="hideClmn">
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
                            <td class="hideClmn ">{{ $student->birthday }}</td>
                            <td class="hideClmn ">{{ $student->country }}</td>
                            <td class="hideClmn_2">{{ $student->phone }}</td>
                            <td class="hideClmn_2">{{ $student->email }}</td>
                            <td>
                                <form action="{{ route('student.destroy', $student->id) }}" method="POST">
                                    @csrf
                                    @if (auth()->user()->role != 'user')
                                        <a href="{{ route('student.edit', $student->id) }}" id="EditBtn"
                                            class="btn btn-light" title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i></a>
                                    @endif
                                    @if (auth()->user()->role != 'user')
                                        <a href="{{ url('/student/' . $student->id . '/files') }}"
                                            class="fileBtn btn btn-light"><i class="fa-solid fa-gear"></i></a>
                                    @endif
                                    @if (auth()->user()->role == 'admin')
                                        @method('DELETE')
                                        <input type="hidden" name="confirmDel" id="confirmDel" value="">
                                        <button type="button" id="confirmDelBtn" class="btn btn-light"
                                            value="{{ $student->id }}" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" title="Delete">
                                            <i class="fa-regular fa-trash-can"></i></button>
                                        @include('delete_modal')
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $students->links() }}
        </div>
        <footer class="py-3 my-4">
            <div class="justify-content-center border-bottom pb-3 mb-3">
            </div>
            <p class="text-center text-gray-700">© 2023 Linkstaff Company, Inc</p>
        </footer>
    </div>
    @include('skill_modal')
    @include('scripts.skill-scripts')
@endsection
@section('scripts')
    <script>
        new MultiSelectTag('country_value');
    </script>
    <script>
        $(document).ready(function() {
            $('.skill_se').select2({
                placeholder: "Select skills",
                allowClear: true,
            });
            $(document).on('click', '#EditBtn', function() {
                sessionStorage.clear();
            });
            $(document).on('click', '.New', function() {
                sessionStorage.clear();
            });
            $(document).on('click', '.fileBtn', function() {
                var currentUrl = window.location.href;
                sessionStorage.setItem("currentUrl", currentUrl);
            });
            $('#search-form').submit(function() {
                $('#skillText').prop('disabled', false);
            })
            var arrType = []
            $('#type').change(function() {
                var selectedOption = $(this).val();
                sessionStorage.setItem("type_value", selectedOption);
                changeOptions();
            });
            $('.skillText').click(function() {
                console.log('asdas');
                $('#skillbtn').trigger("click");
            });
            $('#type').change(function() {
                if ($(this).val() === 'skill_se') {
                    $('#skillbtn').trigger("click");
                }
            });
            var showOrHide = sessionStorage.getItem("showOrHide");

            function changeOptions() {
                var typeVal = sessionStorage.getItem("type_value");
                if (typeVal === 'skill_se') {
                    $('#search-input').hide();
                    $('#search-select').show();
                    $('#search_country').hide();
                    $('.search_interview_date').hide();
                    $('#skill_add').hide();
                    $('#skill_add').hide();
                } else if (typeVal === 'deleted') {
                    $('#search-select').hide();
                    $('#search-input').hide();
                    $('#search_country').hide();
                    $('.search_interview_date').hide();
                } else if (typeVal === 'country') {
                    $('#search-select').hide();
                    $('#search-input').hide();
                    $('#search_country').show();
                    $('.search_interview_date').hide();
                } else if (typeVal === 'interview_date') {
                    $('#search-input').hide();
                    $('#search-select').hide();
                    $('#search_country').hide();
                    $('.search_interview_date').show();
                } else {
                    $('#search-input').show();
                    $('#search-select').hide();
                    $('#search_country').hide();
                    $('.search_interview_date').hide();
                }
            };
            changeOptions();
            var ValueVal = sessionStorage.getItem("value_value");
            $("#value").val(ValueVal);
            $(document).on('click', '.addNewSt', function(e) {
                sessionStorage.clear();
            });
            $(document).on('click', '#selectAndSubmitButton', function(e) {
                sessionStorage.clear();
            });
            $("#value").on("input", function() {
                sessionStorage.setItem("value_value", $(this).val());
            });
            $(document).on('click', '.reloadAll', function(e) {
                sessionStorage.clear();
            });
            //sessionstorage にキー「」で保存されている値を取得し
            var country_value = sessionStorage.getItem("country_value");
            $("#country_value").val(country_value);

            var startday_value = sessionStorage.getItem("startday_value");
            $("#startday_value").val(startday_value);

            var endday_value = sessionStorage.getItem("endday_value");
            $("#endday_value").val(endday_value);

            var date_type = sessionStorage.getItem("date_type");
            $("#date_type").val(date_type);

            var endday_value = sessionStorage.getItem("endday_value");
            $("#endday_value").val(endday_value);

        });

        $(document).on('click', '.img-fluid', function(e) {
            sessionStorage.clear();
        });
        $("#country_value").on("input", function() {
            sessionStorage.setItem("country_value", $(this).val());
        });
        $("#startday_value").on("input", function() {
            sessionStorage.setItem("startday_value", $(this).val());
        });
        $("#endday_value").on("input", function() {
            sessionStorage.setItem("endday_value", $(this).val());
        });
        $("#date_type").on("input", function() {
            sessionStorage.setItem("date_type", $(this).val());
        });

        $(document).on('click', '#confirmDelBtn', function() {
            $('#confirmDel').val($(this).val());
        });
        $(window).on("load", function() {
            var typeVal = sessionStorage.getItem("type_value");
            $('#type option[value="' + typeVal + '"]').prop('selected', true);
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#import").change(function() {
                var fileInput = $("input[name='file']").get(0);
                var file = fileInput.files[0];
                if (file) {
                    $('#exelForm').submit();
                }
            })
        });
    </script>
    <script>
        document.getElementById('selectAndSubmitButton').addEventListener('click', function() {
          document.getElementById('fileInput').click();
        });
      
        document.getElementById('fileInput').addEventListener('change', function() {
          var form = document.getElementById('myForm');
          form.submit();
        });
      </script>
    <style>
        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            cursor: pointer;
            color: black;
        }

        .yearSelect {
            padding: 15px 5px;
            color: gray;
            margin: 0 5px;
        }

        .activeSelect {
            color: white;
            background: blue;
        }

        .selectSkill {
            width: 15%;
            margin: 5px;
            color: white;
            background: linear-gradient(to right, #c1dee0, #98bcbe);
        }

        .xmark {
            outline: none;
            border: none;
            cursor: pointer;
            background: none;
        }

        .minus {
            cursor: pointer;
            margin-left: 15px;
        }

        @media (max-width: 1200px) {
            .hideClmn {
                display: none;
            }
        }

        .card-body {
            width: 107%;
        }


        @media (max-width: 550px) {
            .hideClmn_2 {
                display: none;
            }
        }
    </style>
@endsection