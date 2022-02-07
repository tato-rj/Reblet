<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->unsignedInteger('creator_id');
            $table->string('name');
            $table->string('tag');
            $table->string('description')->nullable();
            $table->unsignedInteger('project_id');
            $table->string('parent_type');
            $table->unsignedInteger('parent_id');
            $table->boolean('is_home')->default(false);
            $table->timestamp('approved_at')->nullable();
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
        Schema::dropIfExists('folders');
    }
}
