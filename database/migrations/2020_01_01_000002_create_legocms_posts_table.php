<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LegoCMS\Support\Database\Migrations\DefaultTableColumns;

/**
 * Class CreateLegocmsPostsTable
 */
class CreateLegocmsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            DefaultTableColumns::publishableDates(true)
                ->apply($table);

            $table->string("title");
            $table->text("description");
            $table->longText("content");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
