<?php

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_edit_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable(true);
            $table->foreignIdFor(Article::class)->nullable(false);
            $table->string('diff_text')->nullable(false);
            $table->string('comment')->nullable(true);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_edit_histories');
    }
};
