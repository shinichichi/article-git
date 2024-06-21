<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(User::class,'user_id')->nullable;
            $table->foreignIdFor(User::class)->nullable(true);
            $table->string('thumbnail',255)->nullable(true);
            $table->binary('imagedata')->nullable(true);
            $table->string('title',255)->nullable(false);
            $table->integer('article_type')->nullable(false);
            $table->string('markdown_text',255)->nullable(true);
            $table->integer('public_type')->nullable(false);
            $table->integer('draft')->nullable(false);
            $table->timestamps();
            $table->dateTime('is_delete')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
