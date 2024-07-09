// simpleMDEとcodemirrorをインポート
import SimpleMDE from "simplemde";
import {
    marked
} from "marked";
import 'simplemde/dist/simplemde.min.css';
import 'codemirror/addon/edit/continuelist.js';
import 'codemirror/addon/display/fullscreen.js';
import 'codemirror/mode/markdown/markdown.js';
import 'codemirror/addon/mode/overlay.js';
import 'codemirror/addon/display/placeholder.js';
import 'codemirror/addon/selection/mark-selection.js';
import 'codemirror/mode/gfm/gfm.js';
import 'codemirror/mode/xml/xml.js';

// editorの設定
var simplemde = new SimpleMDE({
    //     // 反映するタグを選択
    element: document.getElementById("markdown-editor"),
    autosave: {
        enabled: true,
        uniqueId: "editorContent",
        delay: 1000,
    },
    toolbar: [
        "bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", {
            name: "image",
            action: function customImageInsert(editor) {
                var url = prompt("画像のURLを入力してください");
                if (url) {
                    editor.codemirror.replaceSelection("![alt text](" + url + ")");
                }
            },
            className: "fa fa-picture-o",
            title: "画像を挿入"
        },
        "|", "preview", "side-by-side", "fullscreen", "|", "guide"
    ],
    // プレビュー画面の設定
    previewRender: function(plainText) {
        const html = marked(plainText);
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        doc.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
        return doc.body.innerHTML;
    },
    imageUploadFunction: function(file, onSuccess, onError) {
        let formData = new FormData();
        formData.append('image', file);

        axios.post('/imageUpload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            onSuccess(response.data.url);
        }).catch(error => {
            onError("Image upload failed");
        });
    },

});

// function customMarkdownParser(text) {
//     // カスタムMarkdownのパーサー処理
//     return text;
// }
// const markdown_editor = document.getElementById('markdown-editor').value
if (localStorage.getItem('action') === 'create') {
    const text = '';
    simplemde.value(text);
    document.getElementById('title').value = localStorage.getItem('title');
    // simplemde.value();
    localStorage.removeItem('action');
} else if (localStorage.getItem('action') === 'edit') {
    console.log(document.getElementById('markdown-editor').value !== null);
    if (document.getElementById('markdown-editor').value !== null) {
        simplemde.value(document.getElementById('markdown-editor').value);
        localStorage.setItem('content', simplemde.value());
    }
    localStorage.removeItem('action')
} else {
    if (localStorage.getItem('content') !== null) {
        simplemde.value(localStorage.getItem('content'));
    }
    if (localStorage.getItem('title') !== null) {
        document.getElementById('title').value = localStorage.getItem('title');
    }
}

// // ページロード時にエディタの内容を設定
// document.addEventListener("DOMContentLoaded", function() {
//     if (localStorage.getItem('title')) {
//         document.getElementById('title').value = localStorage.getItem('title');
//     }
//     // console.log(document.getElementById('markdown-editor'));t
//     if (localStorage.getItem('content') !== null) {
//         // console.log(document.getElementById('markdown-editor').value = localStorage.getItem('content'));
//         // document.getElementById('markdown-editor').value = localStorage.ge('content');
//         if (localStorage.getItem('action') !== 'create') {
//             // simplemde.value(localStorage.getItem('content'));
//         } else {
//             simplemde.value();
//         }
//     }
// });

// document.addEventListener("DOMContentLoaded", function() {
//     const title = localStorage.getItem('title');
//     const content = localStorage.getItem('content');
//     console.log(title);
//     console.log(content);
//     if (title) {
//         document.getElementById('title').value = title;
//     }
//     if (content) {
//         simplemde.value(content);
//         console.log('ok')
//     }
// });
// フォームの入力値をローカルストレージに保存
document.getElementById('title').addEventListener('input', function() {
    localStorage.setItem('title', this.value);
});
simplemde.codemirror.on('change', function() {
    localStorage.setItem('content', simplemde.value());
});

// フォームの入力値をローカルストレージに保存
document.getElementById('title').addEventListener('input', function() {
    localStorage.setItem('title', this.value);
});
simplemde.codemirror.on('change', function() {
    localStorage.setItem('content', simplemde.value());
});

// // フォームが送信されたらローカルストレージとエディタの内容をクリア
// document.getElementById('articleForm').addEventListener('submit', function(event) {
//     // フォーム送信を一時停止
//     event.preventDefault();

//     // ローカルストレージをクリア
//     localStorage.removeItem('title');
//     localStorage.removeItem('content');

//     // SimpleMDEの入力値をリセット
//     document.getElementById('title').value = '';
//     simplemde.value('');

//     // フォームを再送信
//     this.submit();
// });

// // ドラッグ＆ドロップによる画像アップロード
// simplemde.codemirror.on("drop", function(editor, e) {
//     e.preventDefault();
//     var files = e.dataTransfer.files;
//     if (files.length > 0) {
//         var formData = new FormData();
//         formData.append("image", files[0]);

//         fetch("api/upload", { // ここに画像アップロードAPIのエンドポイントを記入
//                 method: "POST",
//                 body: formData
//             })
//             .then(response => response.json())
//             .then(data => {
//                 var url = data.url; // サーバーから返された画像のURL
//                 if (url) {
//                     simplemde.codemirror.replaceSelection("![alt text](" + url + ")");
//                 }
//             })
//             .catch(error => {
//                 console.error("Error uploading image:", error);
//             });
//     }
// });

// ドラッグ＆ドロップによる画像アップロード
simplemde.codemirror.on("drop", function(editor, event) {
    let files = event.dataTransfer.files;
    if (files.length > 0) {
        let file = files[0];
        simplemde.options.imageUploadFunction(file, (url) => {
            let cm = simplemde.codemirror;
            let doc = cm.getDoc();
            let cursor = doc.getCursor();
            doc.replaceRange(`![image](${url})`, cursor);
        }, (error) => {
            console.error(error);
        });
    }
});