<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateLegocmsUsersTable
 */
class CreateLegocmsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $legocmsUsersTable = config('legocms.users_table', 'legocms_users');

        if (!Schema::hasTable($legocmsUsersTable)) {
            Schema::create($legocmsUsersTable, function (Blueprint $table) {
                createDefaultTableFields($table);
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 60)->nullable()->default(null);
                $table->string('role', 100);
                $table->rememberToken();
            });
        }

        $legocmsPasswordResetsTable = config('legocms.password_resets_table', 'legocms_password_resets');

        if (!Schema::hasTable($legocmsPasswordResetsTable)) {
            Schema::create($legocmsPasswordResetsTable, function (Blueprint $table) {
                $table->string('email')->index();
                $table->string('token')->index();
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('legocms.password_resets_table', 'legocms_password_resets'));
        Schema::dropIfExists(config('legocms.users_table', 'legocms_users'));
    }
}
