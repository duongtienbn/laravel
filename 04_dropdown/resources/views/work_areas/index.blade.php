<!-- ドロップダウンリスト -->
<select>
    @foreach ($workAreas as $workArea)
        <option value="{{ $workArea->name }}">{{ $workArea->name }}</option>
    @endforeach
</select>

<!-- 登録フォーム -->
<form method="POST" action="{{ route('work_area.store') }}">
    @csrf
    <input type="text" name="name" required>
    <button type="submit">登録
