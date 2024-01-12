<div class="modal fade" id="deleteSkillModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">データを削除します。</h5>
                <button type="button" class="btn-close" data-bs-toggle="modal"
                data-bs-target="#skillModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delInputVal" value="123">
                <div>
                    <b>よろしいですか?</b>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel" class="btn btn-secondary" data-bs-toggle="modal"
                data-bs-target="#skillModal">キャンセル</button>
                <button type="submit" id="fake_delete" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#skillModal">削除</button>
            </div>
        </div>
    </div>
</div>
