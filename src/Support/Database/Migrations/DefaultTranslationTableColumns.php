<?php

namespace LegoCMS\Support\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

/**
 * DefaultTranslationTableColumns
 *
 * @method  self  tableNames(string $tableNameSingular, string $tableNamePlural = "")
 * @method  self  apply(Blueprint $table)
 */
class DefaultTranslationTableColumns extends AbstractMigrationHelper
{
    /**
     * tableNames
     *
     * @param  string  $tableNameSingular
     * @param  string $tableNamePlural
     * @return void
     */
    protected function tableNames(string $tableNameSingular, string $tableNamePlural = "")
    {
        $this->tableNameSingular = $tableNameSingular;

        if ($tableNamePlural == "") {
            $tableNamePlural =  Str::plural($tableNameSingular);
        }

        $this->tableNamePlural = $tableNamePlural;

        return $this;
    }

    /**
     * Apply default Migration Columns
     *
     * @param  \Illuminate\Database\Schema\Blueprint $table
     *
     * @return void
     */
    protected function apply(Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->bigIncrements("{$this->tableNameSingular}_id")->unsigned();

        $table->timestamps();
        $table->softDeletes();
        $table->string('locale', 7)->index();
        $table->boolean('active')->default(false);

        $table->foreign(
            "{$this->tableNameSingular}_id",
            "fk_{$this->tableNameSingular}_translations_{$this->tableNameSingular}_id"
        )->references('id')
            ->on($this->tableNamePlural)
            ->onDelete('CASCADE');


        $table->unique(
            ["{$this->tableNameSingular}_id", 'locale'],
            "{$this->tableNameSingular}_id_locale_unique"
        );
    }
}
