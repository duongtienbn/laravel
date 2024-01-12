@extends('layout')

@section('content')
    {{-- //テイエン、CSS 言語を実行する。 --}}
    @include('modal.students-create-css')

    <div class="content" style="text-align: center;height: 47px;background-color:
    #4e8eb8">
        <h3 style="display: inline-block; margin: 7px;">修正画面</h3>
        <div style="float: right; margin: 5px">
            <a href="{{ route('students.index') }}" class="button-header" style="margin-right: 10px;">キャンセル</a>
            <button type="submit" id="updateBtn" class="submit">更新</button>
        </div>

    </div>
    <form id="my-form" action="{{ route('student.update', $student->id) }}" method="POST" style="width: 100%; margin: 50px 10px 0 10px;">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-3">
                <div class="form-group" style="position: relative">
                    <strong>氏名</strong>
                    <input type="text" id="name" name="name" value="{{ $student->name }}"
                        class="input_border form-control" autocomplete="off" onblur="validateName()" onfocus="whenInput()">
                    @error('name')
                        <span style="color:red;position: absolute;" id="php_err_mess">{{ $message }}</span>
                    @enderror
                    <span
                        style="color: red;position: absolute;
                    top: 70%;
                    left: 95%;
                    transform: translate(-50%, -50%);"
                        id="nameError" class="marks"></span>
                    <span style="color:red;position: absolute;" id="name-mess" class="mess-error"></span>
                </div><br>
                <div class="form-group">
                    <strong>氏名 (カタカナ)</strong>
                    <input type="text" name="name_kana" id="name_kana" value="{{ $student->name_kana }}"
                        class="form-control" autocomplete="off" onblur="validateNameKana()">
                    @error('name_kana')
                        <span style="color:red;">{{ $message }}</span>
                    @enderror
                </div><br>
                <div class="form-group">
                    <strong>性別</strong><br>
                    <input type="radio" name="sex" id="sex_1" value="1"
                        @if ($student->sex === 1) checked @endif>
                    <label for="sex_1">
                        男
                    </label>
                    <input type="radio" name="sex" id="sex_2" value="2"
                        @if ($student->sex === 2) checked @endif>
                    <label for="sex_2">
                        女
                    </label>
                    <input type="radio" name="sex" id="sex_3" value="0"
                        @if ($student->sex === 0) checked @endif>
                    <label for="sex_3">
                        不明
                    </label>
                </div><br>
                <div class="form-group">
                    <strong>生年月日</strong>
                    <input type="date" name="birthday" id="birthday" value="{{ $student->birthday }}"
                        class="form-control" max="{{ date('Y-m-d') }}">
                </div><br>
                <div class="form-group">
                    <strong>年齢</strong>
                    <input type="number" name="age" id="age" value="{{ $student->age }}" class="form-control"
                        autocomplete="off" readonly>
                </div><br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7" style="position: relative;">
                            <strong>出身国</strong>
                            <select name="country" id="country" class="form-select">
                                <option value=""></option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->name }}" @if ($country->name === $student->country) selected @endif>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" value="{{ $student->country }}" id="stdtCtrVal">
                            <div id="Crt_mess" style="position: absolute; z-index: 2;">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <span></span><br>
                            <button type="button" data-tooltip="空欄" class="reldCtr button">
                                <iconify-icon icon="flat-color-icons:delete-column" width="15" height="15"
                                    rotate="90deg"></iconify-icon>
                            </button>
                            @if (auth()->user()->role == 'admin')
                                <button type="button" data-tooltip="削除" class="delCtr button"><i
                                        class="fa-sharp fa-solid fa-trash-can" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"></i></button>
                            @endif
                            <button type="button" data-tooltip="追加" class="addCountry button" data-bs-toggle="modal"
                                data-bs-target="#addNewModal">
                                <iconify-icon icon="icon-park-twotone:add"></iconify-icon>
                            </button>

                        </div>
                    </div>
                </div><br>

                <div style="position:absolute;margin-top: 550px; text-align: center;">
                    <a href="{{ route('students.index') }}" class="button-header" style="margin-right: 10px;"><i
                            class="fa-solid fa-delete-left"></i></a>
                    <button type="submit" id="updateBtn" class="submit"><i
                            class="fa-solid fa-file-import"></i></button>
                </div>

            </div>
            <div class="col-md-3">
                <h3>1次面接</h3><br>
                <div class="form-group">
                    <strong>実施日</strong>
                    <input type="date" name="first_interv_date" value="{{ $student->first_interv_date }}"
                        class="form-control" max="{{ date('Y-m-d') }}">
                </div><br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <strong>対応者名</strong>
                            <select name="first_interv_staff[]" id="first_interv_staff" class="interv_staff form-select"
                                multiple style="width: 100%">
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->name }}"
                                        {{ in_array($staff->name, $student->first_interv_staff) ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="Stf_mess1" style="position: absolute; z-index: 2;">
                            </div><br>
                        </div>
                        <div class="col-md-5">
                            <span></span><br>
                            @if (auth()->user()->role == 'admin')
                                <button type="button" data-tooltip="削除" class="delStf1 button"><i
                                        class="fa-sharp fa-solid fa-trash-can" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"></i></button>
                            @endif
                            <button type="button" data-tooltip="追加" class="addStaff1 button" data-bs-toggle="modal"
                                data-bs-target="#addNewModal">
                                <iconify-icon icon="icon-park-twotone:add"></iconify-icon>
                            </button>

                        </div>
                    </div>
                </div><br>
                <div class="form-group">
                    <strong>合否</strong><br>
                    <input type="radio" name="first_interv_result" id="first_interv_result_1" value="1"
                        @if ($student->first_interv_result === 1) checked @endif>
                    <label for="first_interv_result_1">
                        合格
                    </label>
                    <input type="radio" name="first_interv_result" id="first_interv_result_2" value="2"
                        @if ($student->first_interv_result === 2) checked @endif>
                    <label for="first_interv_result_2">
                        不合格
                    </label>
                    <input type="radio" name="first_interv_result" id="first_interv_result_3" value="0"
                        @if ($student->first_interv_result === 0) checked @endif>
                    <label for="first_interv_result_3">
                        未定
                    </label>
                </div><br>
                <h3>2次面接</h3><br>
                <div class="form-group">
                    <strong>実施日</strong>
                    <input type="date" name="sec_interv_date" value="{{ $student->sec_interv_date }}"
                        class="form-control" max="{{ date('Y-m-d') }}">
                </div><br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <strong>対応者名</strong>
                            <select name="sec_interv_staff[]" id="sec_interv_staff" class="interv_staff form-select"
                                multiple style="width: 100%">
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->name }}"
                                        {{ in_array($staff->name, $student->sec_interv_staff) ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="Stf_mess2" style="position: absolute; z-index: 2;">
                            </div><br>
                        </div>
                        <div class="col-md-5">
                            <span></span><br>
                            @if (auth()->user()->role == 'admin')
                                <button type="button" data-tooltip="削除" class="delStf2 button"><i
                                        class="fa-sharp fa-solid fa-trash-can" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"></i></button>
                            @endif
                            <button type="button" data-tooltip="追加" class="addStaff2 button" data-bs-toggle="modal"
                                data-bs-target="#addNewModal">
                                <iconify-icon icon="icon-park-twotone:add"></iconify-icon>
                            </button>

                        </div>
                    </div>
                </div><br>
                <div class="form-group">
                    <strong>合否</strong><br>
                    <input type="radio" name="sec_interv_result"id="sec_interv_result_1" value="1"
                        @if ($student->sec_interv_result === 1) checked @endif>
                    <label for="sec_interv_result_1">
                        合格
                    </label>
                    <input type="radio" name="sec_interv_result" id="sec_interv_result_2" value="2"
                        @if ($student->sec_interv_result === 2) checked @endif>
                    <label for="sec_interv_result_2">
                        不合格
                    </label>
                    <input type="radio" name="sec_interv_result" id="sec_interv_result_3" value="0"
                        @if ($student->sec_interv_result === 0) checked @endif>
                    <label for="sec_interv_result_3">
                        未定
                    </label>
                </div><br>
                <h3>インターン</h3><br>
                <div class="form-group">
                    <strong>実施日</strong>
                    <input type="date" name="intern_interv_date" id="intern_interv_date"
                        value="{{ $student->intern_interv_date }}" class="form-control" max="{{ date('Y-m-d') }}">
                </div><br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <strong>対応部署名</strong>
                            <select name="intern_department" id="intern_department" class="form-select">
                                <option value=""></option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->name }}"
                                        @if ($department->name === $student->intern_department) selected @endif>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" value="{{ $student->intern_department }}" id="intnDpmt">
                            <div id="Dpmt_mess" style="position: absolute; z-index: 2;">
                            </div><br>
                        </div>
                        <div class="col-md-5">
                            <span></span><br>
                            <button type="button" data-tooltip="空欄" class="reldDpmt button">
                                <iconify-icon icon="flat-color-icons:delete-column" width="15" height="15"
                                    rotate="90deg"></iconify-icon>
                            </button>
                            @if (auth()->user()->role == 'admin')
                                <button type="button" data-tooltip="削除" class="reldDpmt button"><i
                                        class="fa-sharp fa-solid fa-trash-can" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"></i></button>
                            @endif
                            <button type="button" data-tooltip="追加" class="addDpmt button" data-bs-toggle="modal"
                                data-bs-target="#addNewModal">
                                <iconify-icon icon="icon-park-twotone:add"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div><br>
                <div class="form-group">
                    <strong>合否</strong><br>
                    <input type="radio" name="intern_result" id="intern_result_1" value="1"
                        @if ($student->intern_result === 1) checked @endif>
                    <label for="intern_result_1">
                        合格
                    </label>
                    <input type="radio" name="intern_result" id="intern_result_2" value="2"
                        @if ($student->intern_result === 2) checked @endif>
                    <label for="intern_result_2">
                        不合格
                    </label>
                    <input type="radio" name="intern_result" id="intern_result_3" value="0"
                        @if ($student->intern_result === 0) checked @endif>
                    <label for="intern_result_3">
                        未定
                    </label>
                </div><br>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>入職日</strong>
                    <input type="date" name="hire_date" value="{{ $student->hire_date }}" class="form-control">
                </div><br>
                <div class="form-group" style="position: relative">
                    <strong>電話番号</strong>
                    <input type="tel" name="phone" id="phone" value="{{ $student->phone }}"
                        class="input_border form-control" autocomplete="off" onblur="validatePhone()">
                    @error('phone')
                        <span style="color:red;">{{ $message }}</span>
                    @enderror
                    <span
                        style="color: red;position: absolute;
                    top: 70%;
                    left: 95%;
                    transform: translate(-50%, -50%);"
                        id="phoneError" class="marks"></span>
                    <span style="color:red;position: absolute;" id="phone-mess" class="mess-error"></span>
                </div><br>
                <div class="form-group" style="position: relative">
                    <strong>メールアドレス</strong>
                    <input type="text" name="email" id="email" value="{{ $student->email }}"
                        class="input_border form-control" autocomplete="off" onblur="validateEmail()">
                    @error('email')
                        <span style="color:red;position: absolute;">{{ $message }}</span>
                    @enderror
                    <span
                        style="color: red;position: absolute;
                    top: 70%;
                    left: 95%;
                    transform: translate(-50%, -50%);"
                        id="emailError" class="marks"></span>
                    <span style="color:red;position: absolute;" id="email-mess" class="mess-error"></span>
                </div><br>
                <div class="form-group">
                    <strong>日本語(JLPT)スキル</strong>
                    <select name="skill_jlpt" class="form-select">
                        <option selected></option>
                        <option value="1" @if ($student->skill_jlpt == '1') selected @endif>N1</option>
                        <option value="2" @if ($student->skill_jlpt == '2') selected @endif>N2</option>
                        <option value="3" @if ($student->skill_jlpt == '3') selected @endif>N3</option>
                        <option value="4" @if ($student->skill_jlpt == '4') selected @endif>N4</option>
                        <option value="5" @if ($student->skill_jlpt == '5') selected @endif>N5</option>
                        <option value="6" @if ($student->skill_jlpt == '6') selected @endif>未取得</option>
                    </select>
                </div><br>
                <div class="form-group">
                    <strong>ヒアリングスキル</strong>
                    <select name="skill_hearing" class="form-select">
                        <option selected></option>
                        <option value="1" @if ($student->skill_hearing == '1') selected @endif>N1</option>
                        <option value="2" @if ($student->skill_hearing == '2') selected @endif>N2</option>
                        <option value="3" @if ($student->skill_hearing == '3') selected @endif>N3</option>
                        <option value="4" @if ($student->skill_hearing == '4') selected @endif>N4</option>
                        <option value="5" @if ($student->skill_hearing == '5') selected @endif>N5</option>
                    </select>
                </div><br>
                <div class="form-group">
                    <strong>スピーキングスキル</strong>
                    <select name="skill_speaking" class="form-select">
                        <option selected></option>
                        <option value="1" @if ($student->skill_speaking == '1') selected @endif>N1</option>
                        <option value="2" @if ($student->skill_speaking == '2') selected @endif>N2</option>
                        <option value="3" @if ($student->skill_speaking == '3') selected @endif>N3</option>
                        <option value="4" @if ($student->skill_speaking == '4') selected @endif>N4</option>
                        <option value="5" @if ($student->skill_speaking == '5') selected @endif>N5</option>
                    </select>
                </div><br>
                <div class="form-group">
                    <strong>リーディングスキル</strong>
                    <select name="skill_reading" class="form-select">
                        <option selected></option>
                        <option value="1" @if ($student->skill_reading == '1') selected @endif>N1</option>
                        <option value="2" @if ($student->skill_reading == '2') selected @endif>N2</option>
                        <option value="3" @if ($student->skill_reading == '3') selected @endif>N3</option>
                        <option value="4" @if ($student->skill_reading == '4') selected @endif>N4</option>
                        <option value="5" @if ($student->skill_reading == '5') selected @endif>N5</option>
                    </select>
                </div><br>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>SEスキル</strong>
                    <select class="skill_se"id="skill_se" multiple="multiple" style="display:none;">
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                        @endforeach
                    </select>
                    <div class="text-nowrap">
                        <textarea class="form-control w-90" name="skill_se" id="skillText" rows="2" disabled>{{$student->skill_se}}</textarea>
                        <div id="skill_mess" style="position: absolute; z-index: 2;">
                        </div><br>
                        <button type="button" data-tooltip="追加" class="button" id="skillbtn" data-bs-toggle="modal"
                            data-bs-target="#skillModal">追加</button>
                        @if (auth()->user()->role == 'admin')
                            <input type="hidden" value="admin" id="getRole">
                        @endif
                        <button type="button" data-tooltip="新しいスキル追加" class="addSkill button" data-bs-toggle="modal"
                            data-bs-target="#addNewModal">
                            <iconify-icon icon="icon-park-twotone:add"></iconify-icon>
                        </button>
                    </div>
                </div><br>
                <div class="form-group">
                    <strong>学歴</strong><br>
                    <div>
                        <input type="checkbox" name="graduate_4" id="graduate_4" value="1"
                            {{ old('graduate_4', $student->graduate_4) == 1 ? 'checked' : '' }}>
                        <label for="graduate_4">4大</label>
                    </div>
                    <div>
                        <input type="checkbox" name="graduate_2" id="graduate_2" value="1"
                            {{ old('graduate_2', $student->graduate_2) == 1 ? 'checked' : '' }}>
                        <label for="graduate_2">専門</label>
                    </div>
                </div><br>
                <div class="form-group">
                    <strong>最終学歴</strong>
                    <input type="text" name="graduate_school" value="{{ $student->graduate_school }}"
                        class="form-control" autocomplete="off" placeholder="">
                </div><br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-7">
                            <strong>応募職種</strong>
                            <select name="apply_department[]" id="apply_department" class="form-select" multiple
                                style="width: 100%">
                                @foreach ($applies as $apply)
                                    <option value="{{ $apply->name }}"
                                        {{ in_array($apply->name, $student->apply_department) ? 'selected' : '' }}>
                                        {{ $apply->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="Apl_mess" style="position: absolute; z-index: 2;">
                            </div><br>
                        </div>

                        <div class="col-md-5">
                            <span></span><br>
                            @if (auth()->user()->role == 'admin')
                                <button type="button" data-tooltip="削除" class="delApl button"><i
                                        class="fa-sharp fa-solid fa-trash-can" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"></i></button>
                            @endif
                            <button type="button" data-tooltip="追加" class="addApl button" data-bs-toggle="modal"
                                data-bs-target="#addNewModal">
                                <iconify-icon icon="icon-park-twotone:add"></iconify-icon>
                            </button>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-7">
                                <strong>希望勤務地</strong>
                                <select name="working_place[]" id="working_place" class="form-select" multiple
                                    style="width:100%">
                                    @foreach ($places as $place)
                                        <option value="{{ $place->name }}"
                                            {{ in_array($place->name, $student->working_place) ? 'selected' : '' }}>
                                            {{ $place->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="plc_mess" style="position: absolute; z-index: 2;">
                                </div><br>
                            </div>
                            <div class="col-md-5">
                                <span></span><br>
                                @if (auth()->user()->role == 'admin')
                                    <button type="button" data-tooltip="削除" class="delPlc button"><i
                                            class="fa-sharp fa-solid fa-trash-can" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"></i></button>
                                @endif
                                <button type="button" data-tooltip="追加" class="addPlc button" data-bs-toggle="modal"
                                    data-bs-target="#addNewModal">
                                    <iconify-icon icon="icon-park-twotone:add"></iconify-icon>
                                </button>
                            </div>

                        </div>
                    </div><br>
                    <div class="form-group">
                        <strong>現在の状況</strong>
                        <input type="text" name="current_status" value="{{ $student->current_status }}"
                            class="form-control" autocomplete="off">
                    </div><br>
                    <div class="form-group">
                        <strong>自由項目</strong><br>
                        <textarea class="form-control" rows="8" name="note" autocomplete="off" style="border-radius: 10px;">{{ $student->note }}</textarea>
                    </div><br>
                </div>
            </div>
    </form>
    {{-- モダールを追加 --}}
    @include('add_new_modal')
    @include('delete_modal')
    @include('skill_modal')
    @include('delete_skill_modal')
@endsection

@section('scripts')
    @include('scripts.country-scripts')
    @include('scripts.staff-scripts')
    @include('scripts.department-scripts')
    @include('scripts.working_place-scripts')
    @include('scripts.apply_department-scripts')
    @include('scripts.skill-scripts')
    @include('scripts.validate-form')
    {{-- @include('scripts.session') --}}
    <script>
        $(document).ready(function() {
            $('#first_interv_staff').select2({
                placeholder: "select staffs",
                allowClear: true,
            });
            $('#sec_interv_staff').select2({
                placeholder: "select staffs",
                allowClear: true,
            });
            $('#apply_department').select2({
                placeholder: "select departments",
                allowClear: true,
            });
            $('#working_place').select2({
                placeholder: "select working place",
                allowClear: true,
            });
        })
    </script>
    <script>
        // ダブルクリックしてキャンセルします
        var prevSelectedValue = '';
        $('input[type="radio"]').click(function() {
            var currentValue = $(this).val();

            if (currentValue === prevSelectedValue) {
                $(this).prop('checked', false);
                prevSelectedValue = '';
            } else {
                prevSelectedValue = currentValue;
            }
        });
        //HEADERのボタン
        $(document).ready(function() {
            $("#updateBtn").click(function() {
                $("#my-form").submit();
            });
        });
    </script>
    <style>
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
    </style>
@endsection
