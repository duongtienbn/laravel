<div class="modal fade" id="skillModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">プログラミング言語経験</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="skill_mess_modal"></div>
                <div class="buttonSkill">
                    @foreach ($skills as $skill)
                        <button type="button" value="{{ $skill->name }}"
                            class="btn btn-light selectSkill">{{ $skill->name }}</button>
                    @endforeach
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">選択済み項目</th>
                            <th scope="col">実務経験</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                <button type="button" id="submitBtn" class="btn btn-primary" data-bs-dismiss="modal">登録</button>
            </div>
        </div>
    </div>
</div>
