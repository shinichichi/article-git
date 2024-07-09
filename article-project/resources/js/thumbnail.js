document.addEventListener('DOMContentLoaded', function() {
    const thumbnailInput = document.getElementById('thumbnail');
    const thumbnailPreview = document.getElementById('thumbnail_img_prv');
    const removeButton = document.getElementById('remove_thumbnail');
    const defaultThumbnail = window.defaultThumbnail;
    // アイコン画像プレビュー処理
    // 画像が選択されたときの処理
    thumbnailInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // このFileReaderが画像を読み込む上で大切
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailPreview.src = e.target.result;
                removeButton.style.display = 'block';
            }
            document.getElementById('not_image').value = 1;
            reader.readAsDataURL(file);
        }
    });
    // 「×」ボタンが押されたときの処理
    removeButton.addEventListener('click', function(event) {
        event.preventDefault();
        // thumbnailPreview.src = '{{ asset('
        // image / articledfimage.jpg ') }}';
        thumbnailPreview.src = defaultThumbnail;
        thumbnailInput.value = '';
        // notImage = document.getElementById('not_image').value;
        document.getElementById('not_image').value = 2;

        // console.log(notImage);
        removeButton.style.display = 'none';
    });

    // 初期表示時に「×」ボタンを表示するかどうかの処理
    // if (thumbnailPreview.src.includes('{{ asset('
    //         image / articledfimage.jpg ') }}')) {
    if (thumbnailPreview.scr.includes(defaultThumbnail)) {
        removeButton.style.display = 'none';
    } else {
        removeButton.style.display = 'block';
    }
});