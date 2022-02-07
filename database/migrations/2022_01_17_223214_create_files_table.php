<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('creator_id');
            $table->string('name')->unique()->index();
            $table->string('original_name');
            $table->string('custom_name')->nullable();
            $table->string('downloaded_name')->nullable();
            $table->string('extension');
            $table->string('type');
            $table->unsignedInteger('size');
            $table->string('description')->nullable();
            $table->string('path')->unique();
            $table->string('url')->unique();
            $table->unsignedInteger('revision_id');
            $table->unsignedInteger('duplicated_from_revision_id')->nullable();
            $table->timestamp('replaced_at')->nullable();
            $table->timestamp('downloaded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
