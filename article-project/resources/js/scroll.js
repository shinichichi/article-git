    document.addEventListener('DOMContentLoaded', function() {
                // 現在の画面幅
                let isWidthScreen = window.matchMedia("(min-width: 751px)").matches;
                // 取ってくる記事の初期値
                let offset = 5;
                // 追加する記事のか数値
                let offsetAdd = 5;
                let isFetching = false;

                // デスクトップ画面のタグ
                const desktopLoadMoreTrigger = document.getElementById('desktop-load-more-trigger');
                const desktopContainer = document.getElementById('desktop_container');
                const desktopLoadingIndicator = document.getElementById('desktop-loading');
                // スマホ画面のタグ
                const smartphoneLoadMoreTrigger = document.getElementById('smartphone-load-more-trigger');
                const smartphoneContainer = document.getElementById('smartphone_container');
                const smartphoneLoadingIndicator = document.getElementById('smartphone-loading');
                // 全画面
                const scrollArea = document;
                // fetchするURLを指定する関数
                function fetchURL(value) {
                    let url = `http://localhost:8000/article/load-more?offset=${value}`;
                    return url
                }

                // date型のフォーマット関数
                function formatDate(dateString) {
                    const date = new Date(dateString);
                    const year = date.getFullYear();
                    const month = ('0' + (date.getMonth() + 1)).slice(-2);
                    const day = ('0' + date.getDate()).slice(-2);
                    const hours = ('0' + date.getHours()).slice(-2);
                    const minutes = ('0' + date.getMinutes()).slice(-2);
                    const seconds = ('0' + date.getSeconds()).slice(-2);
                    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                }

                // デスクトップ画面の処理
                const desktopLoadMoreArticles = async() => {
                        if (isFetching) return;
                        isFetching = true;
                        desktopLoadingIndicator.style.display = 'block';
                        try {
                            // 非同期処理でリクエスト送信
                            const response = await fetch(fetchURL(offset));
                            // const response = await fetch(`http://localhost:8000/article/load-more?offset=${offset}`);
                            if (!response.ok) {
                                // サーバー側で記事を取得しレスポンスできなければエラー文表示
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            // 取得した値をHTMLに代入
                            const data = await response.json();
                            if (window.matchMedia("(min-width:751px)").matches) {
                                if (data.articles.length > 0) {
                                    data.articles.forEach(article => {
                                                const articleDiv = document.createElement('div');
                                                articleDiv.classList.add('form-group');
                                                articleDiv.innerHTML = `
                            <div class="form-inline">
                                <div class="col">
                                    <div class="max-w-4xl mx-auto sm:px-20 lg:px-30 mb-1">
                                        <a class="a mt-2" href="/index/show/${article.id}" id="article-list">
                                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-10">
                                                <div class="flex">
                                                    ${article.thumbnail !== null ?
                                                    `<img class="bora imagk100" src="${article.thumbnail}" alt="サムネイル画像">` :
                                                    `<img class=" imagk100" src="/image/articledfimage200.jpg" alt="">`
                                                    }
                                                    <div class="wi col- mx-3 my-2">
                                                        <p class="lo text-xl text-gray-500 pt-2">${article.title}</p>
                                                        <div class="sp pt-2">
                                                            <span class="lo text-xs text-gray-400">
                                                                <div class="flex">
                                                                    ${article.user && article.user.icon !== null ?
                                                                    `<img class="spimgs" src="${article.user.icon}" alt="">
                                                                    <div class="down pl-2">${article.user.user_name} (${article.user.account_name})</div>`:
                                                                    article.user ?
                                                                    `<img class="" src="/image/df40icon.jpg" alt="">
                                                                    <div class="down pl-2">${article.user.user_name} (${article.user.account_name})</div>`:
                                                                    `<img class="" src="/image/df40icon.jpg" alt="">
                                                                            <div class="down pl-2"><p>名無し</p></div>`
                                                                }
                                                                </div>
                                                            </span>
                                                            <span class="text-xs text-right down">${formatDate(article.updated_at)}</span><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        desktopContainer.appendChild(articleDiv);
                    });
                    offset += offsetAdd;
                }
                // 取得した件数終了後読み込み中の文言を表示時
                desktopLoadingIndicator.style.display = 'none';
            }
        } catch (error) {
            // エラー表示
            console.error('Error loading more articles:', error);
            desktopLoadingIndicator.style.display = 'none';
        }
        isFetching = false;
    };
    // スマホ画面の処理
    const smartphoneLoadMoreArticles = async () => {
        if (isFetching) return;
        isFetching = true;
        smartphoneLoadingIndicator.style.display = 'block';
        try {
            // 非同期処理でリクエスト送信
            const response = await fetch(fetchURL(offset));
            if (!response.ok) {
                // サーバー側で記事を取得しレスポンスできなければエラー文表示
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            // 取得した値をHTMLに代入
            const data = await response.json();
                // 取得した値をを使ってHTMLをforeach当てはめる
                if (data.articles.length > 0) {
                    data.articles.forEach(article => {
                        const articleDiv = document.createElement('div');
                        articleDiv.classList.add('form-group');
                        articleDiv.innerHTML = `
                                <div class="form-inline" id="article-list_a">
                                    <div class="col pl-0 pr-0">
                                        <div class="max-w-4xl mx-auto sm:px-20 lg:px-30 mb-1">
                                            <a class="a mt-2" href="/index/show/${article.id}" id="article-list">
                                                <div class="bg-white overflow-hidden shadow-sm bora10 sm:rounded-lg">
                                                    <div class="">
                                                        ${article.thumbnail !== null ?
                                                            `<img class="bora imagk400" src="${article.thumbnail}" alt="サムネイル画像">` :
                                                            `<img class=" imagk400" src="/image/articledfimage200.jpg" alt="">`
                                                        }
                                                        <div class="wi col mx-1 my-2">
                                                            <p class="lo text-xl text-gray-500 pt-2">${article.title}</p>
                                                            <div class="sp pt-2">
                                                                <span class="lo text-xs text-gray-400">
                                                                    <div class="flex">
                                                                        ${article.user && article.user.icon !== null ?
                                                                            `<img class="spimgs" src="${article.user.icon}" alt="">
                                                                            <div class="down pl-2">${article.user.user_name} (${article.user.account_name})</div>` :
                                                                            article.user ?
                                                                            `<img class="" src="/image/df40icon.jpg" alt="">
                                                                            <div class="down pl-2">${article.user.user_name} (${article.user.account_name})</div>` :
                                                                            `<img class="" src="/image/df40icon.jpg" alt="">
                                                                            <div class="down pl-2"><p>名無し</p></div>`
                                                                        }
                                                                    </div>
                                                                </span>
                                                                <span class="text-xs text-right down">${formatDate(article.updated_at)}</span><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        `;
                        smartphoneContainer.appendChild(articleDiv);
                    });
                    offset += offsetAdd;
                }
                // 取得した件数終了後読み込み中の文言を表示時
                smartphoneLoadingIndicator.style.display = 'none';

        } catch (error) {
            // エラー
            console.error('Error loading more articles:', error);
            smartphoneLoadingIndicator.style.display = 'none';
        }
        isFetching = false;
    };
    // 画面サイズを変更の関数
    function checkScreenWidth() {
        let currentIsWidthScreen = window.matchMedia("(min-width: 751px)").matches;
        if(currentIsWidthScreen !== isWidthScreen) {
            // リロード
            location.reload();
        }
    }

    // 画面サイズ変更に反応
    window.addEventListener('resize', checkScreenWidth);
    // デスクトップ画面かスマホ画面かで記事を追加
    // デスクトップ処理
    if(window.matchMedia("(min-width:751px)").matches){
        const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            desktopLoadMoreArticles();
            }
        });
        observer.observe(desktopLoadMoreTrigger);
    // スマフォ処理
    }else if(window.matchMedia("(max-width: 750px)").matches){
        const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            smartphoneLoadMoreArticles();
            }
        });
        observer.observe(smartphoneLoadMoreTrigger);
    }
});