<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Article;
use App\Models\User;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            //1 通常表示
            [
                'title' => 'わたしがいつも通うお気に入りのごはんやを紹介します。',
                'user_id' => 1,
                'thumbnail' => 'test1.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-08 16:19:17',
                'updated_at' => '2024-05-08 16:19:17',
            ],
            //2
            [
                'title' => 'お気に入りのお店',
                'user_id' => 2,
                'thumbnail' => 'test2.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-10 16:19:17',
                'updated_at' => '2024-05-10 16:19:17',
            ],
            //3
            [
                'title' => '大阪の難波の心斎橋の〇〇〇〇〇〇〇〇ビル5階に入って右にあるいつも行列のお店にはじめていってみたのでレビュー',
                'user_id' => 3,
                'thumbnail' => 'test3.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-11 16:19:17',
                'updated_at' => '2024-05-11 16:19:17',
            ],
            //4
            [
                'title' => Str::random(50),
                'user_id' => 4,
                'thumbnail' => null,
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-12 16:19:17',
                'updated_at' => '2024-05-12 16:19:17',
            ],
            //5
            [
                'title' => Str::random(50),
                'user_id' => 5,
                'thumbnail' => 'test5.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-13 16:19:17',
                'updated_at' => '2024-05-13 16:19:17',
            ],
            //6
            [
                'title' => Str::random(50),
                'user_id' => 6,
                'thumbnail' => 'test1.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-14 16:19:17',
                'updated_at' => '2024-05-14 16:19:17',
            ],
            //7
            [
                'title' => Str::random(50),
                'user_id' => 7,
                'thumbnail' => 'test2.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-15 16:19:17',
                'updated_at' => '2024-05-15 16:19:17',
            ],
            //8
            [
                'title' => Str::random(50),
                'user_id' => 8,
                'thumbnail' => null,
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-16 16:19:17',
                'updated_at' => '2024-05-16 16:19:17',
            ],
            //9
            [
                'title' => Str::random(50),
                'user_id' => 9,
                'thumbnail' => 'test4.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-17 16:19:17',
                'updated_at' => '2024-05-17 16:19:17',
            ],
            //10
            [
                'title' => Str::random(50),
                'user_id' => 10,
                'thumbnail' => 'test5.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //11
            [
                'title' => Str::random(50),
                'user_id' => 1,
                'thumbnail' => 'test5.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //12
            [
                'title' => Str::random(50),
                'user_id' => 2,
                'thumbnail' => 'test1.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //12
            [
                'title' => Str::random(50),
                'user_id' => 3,
                'thumbnail' => 'test3.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],

            //13
            [
                'title' => Str::random(50),
                'user_id' => 4,
                'thumbnail' => 'test4.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //14
            [
                'title' => Str::random(50),
                'user_id' => 5,
                'thumbnail' => 'test5.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //15
            [
                'title' => Str::random(50),
                'user_id' => 6,
                'thumbnail' => 'test5.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //16
            [
                'title' => Str::random(50),
                'user_id' => 1,
                'thumbnail' => 'test1.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //17
            [
                'title' => Str::random(50),
                'user_id' => 2,
                'thumbnail' => 'test2.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //18
            [
                'title' => Str::random(50),
                'user_id' => 3,
                'thumbnail' => 'test3.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //19
            [
                'title' => Str::random(50),
                'user_id' => 4,
                'thumbnail' => 'test5.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
            //20
            [
                'title' => Str::random(50),
                'user_id' => 10,
                'thumbnail' => 'test5.jpg',
                'article_type' => 0, // 0:記事 1:Q&A 2:意見交換
                'markdown_text'  => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaa
                 aaaaa
                 aaaaaaaaaaaaaaaa
                 <pre><code class="php">$a = 8;
                 count($a);
                 </code></pre>

                 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                 aaaaaaaaaaaaaaaaaaa
                 ',
                'public_type' => 0, // 0:全体に公開 1:限定公開,下書きが0の時はエラーを出したい 2:公開停止
                'draft' => 0, // 0:下書き状態でない 1:下書き状態
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],
        ]);
    }
}
