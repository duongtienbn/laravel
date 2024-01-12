@extends('layout')
@section('content')
<div class="row">
  <div class="col-md-8">
    <iframe src="{{ asset('storage/user.pdf') }}" width="100%" height="820"></iframe>
  </div>
  <div class="col-md-4">
    <form id="my-form" action="{{ route('student.store') }}" method="POST">
      @csrf
      <input type="hidden" name="source" value="pdf">
      <input type="hidden" name="fileName" value="{{$fileName}}">
      <div class="form-group">
        <strong>氏名</strong>
        <input type="text" name='name' id='name' onblur="validateName()" autocomplete="off" value="{{ (isset($data['name']) ? $data['name'] : '') }}" class="form-control">
        @error('name')
          <span style="color:red;position: absolute;" id="php_err_mess">{{ $message }}</span>
        @enderror
      </div><br>
      <div class="form-group">
        <strong>氏名(カタカナ)</strong>
        <input type="text" name='name_kana' id='name_kana' onblur="validateName()" autocomplete="off" value="{{ (isset($data['name_kana']) ? $data['name_kana'] : '') }}" class="form-control">
        @error('name_kana')
          <span style="color:red;position: absolute;" id="php_err_mess">{{ $message }}</span>
        @enderror
      </div><br>
      <div class="form-group">
        <strong>メール</strong>
        <input type="text" name='email' id='email' onblur="validateEmail()" autocomplete="off" value="{{ isset($data['email']) ? $data['email'] : '' }}" class="form-control">
        @error('email')
          <span style="color:red;position: absolute;" id="php_err_mess">{{ $message }}</span>
        @enderror
      </div><br>
      <div class="form-group">
        <strong>性別</strong>
        <input type="text" name='sex' id='sex' autocomplete="off" value="{{ isset($data['sex']) ? $data['sex'] : '' }}" class="form-control">
      </div><br>
      <div class="form-group">
        <strong>生年月日</strong>
        <input type="text" name="birthday" id="birthday" value="{{ isset($data['birthday']) ? $data['birthday'] : '' }}" class="form-control">
      </div><br>
      <div class="form-group">
        <strong>国籍</strong>
        <input type="text" name='country' id='country' value="{{ isset($data['country']) ? $data['country'] : '' }}" class="form-control">
      </div><br>
      <div class="form-group">
        <strong>電話番号</strong>
        <input type="text" name='phone' id='phone' onblur="validatePhone()" autocomplete="off" value="{{ isset($data['phone']) ? $data['phone'] : '' }}" class="form-control">
        @error('phone')
          <span style="color:red;">{{ $message }}</span>
        @enderror
      </div><br>
      <div>
        <button type="submit" class="btn btn-info">登録</button>
        <a href="{{ route('students.index') }}" onclick="return confirm('戻ったら、データを保存しません');" class="btn btn-secondary">戻る</a><br>
      </div>
    </form>
  </div>
</div>
@endsection
@section('scripts')
    @include('scripts.validate-form')
    @include('scripts.session_pdf')
    <script id="mult_selct">
        new MultiSelectTag('skill_se') // id
    </script>
@endsection