<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCategoriesTables
 */
class CreateArticlesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            \createDefaultTableFields($table);
            $table->string('author');
            $table->string('email');
        });

        Schema::create('article_translations', function (Blueprint $table) {
            \createDefaultTranslationsTableFields($table, 'article', 'articles');
            $table->string('name');
            $table->longText('description')->nullable();
        });

        Schema::create('article_revisions', function (Blueprint $table) {
            \createDefaultRevisionsTableFields($table, 'article', 'articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_translations');
        Schema::dropIfExists('articles');
    }
}
