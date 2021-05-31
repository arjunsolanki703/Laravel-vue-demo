<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('engineer_user_id')->unsigned()->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('county');
            $table->string('project_name');
            $table->string('client_po')->nullable();
            $table->string('project_number')->nullable();
            $table->string('project_notes')->nullable();
            $table->string('type');//['iebc_letter','full_structural','electrical','stamp','electrical_fault_study']
            $table->string('status');//['in_process','assigned_to_engineer','archived','completed']
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
        Schema::dropIfExists('projects');
    }
}
