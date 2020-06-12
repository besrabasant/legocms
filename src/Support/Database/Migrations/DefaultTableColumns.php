<?php

namespace LegoCMS\Support\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;

/**
 * DefaultTableColumns
 *
 * @method  self  timestamps(bool $value, bool $softDeletes = true)
 * @method  self  softDeletes(bool $value)
 * @method  self  uuid(bool $value)
 * @method  self  publishable(bool $value)
 * @method  self  publishableDates(bool $value)
 * @method  self  visibility(bool $value)
 * @method  self  apply(Blueprint $table)
 */
class DefaultTableColumns extends AbstractMigrationHelper
{
    protected $timeStamps = true;

    protected $softDeletes = true;

    protected $uuid = false;

    protected $publishable = true;

    protected $publishableDates = false;

    protected $visibility = false;

    /**
     * Configure timestamps columns
     *
     * @param  bool $value
     * @param  bool $softDeletes
     *
     * @return $this
     */
    protected function timestamps(bool $value, bool $softDeletes = true)
    {
        $this->timeStamps = $value;

        $this->softDeletes($softDeletes);

        return $this;
    }

    /**
     * Configure Soft Deletes column.
     *
     * @param  bool $value
     *
     * @return $this
     */
    protected function softDeletes(bool $value)
    {
        $this->softDeletes = $value;

        return $this;
    }

    /**
     * Configure `uuid` column.
     *
     * @param  bool $value
     *
     * @return $this
     */
    protected function uuid(bool $value)
    {
        $this->uuid = $value;

        return $this;
    }

    /**
     * Configure `published` column
     *
     * @param  bool $value
     *
     * @return $this
     */
    protected function publishable(bool $value)
    {
        $this->publishable = $value;

        return $this;
    }

    /**
     * Configure `publish_start_date` & `publish_stop_date` column
     *
     * @param  bool $value
     *
     * @return $this
     */
    protected function publishableDates(bool $value)
    {
        $this->publishableDates = $value;

        return $this;
    }

    /**
     * Configure `public` column
     *
     * @param  bool $value
     *
     * @return $this
     */
    protected function visibility(bool $value)
    {
        $this->publishable = $value;

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

        if ($this->uuid) {
            $table->text("uuid")->unique();
        }

        if ($this->timeStamps) {
            $table->timestamps();

            if ($this->softDeletes) {
                $table->softDeletes();
            }
        }

        if ($this->publishable) {
            $table->boolean('published')->default(false);

            if ($this->publishableDates) {
                $table->timestamp('publish_start_date')->nullable();
                $table->timestamp('publish_end_date')->nullable();
            }
        }

        if ($this->visibility) {
            $table->boolean('public')->default(true);
        }
    }
}
