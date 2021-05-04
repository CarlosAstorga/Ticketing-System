<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->foreignId('submitter_id')->constrained('users', 'id');
            $table->foreignId('priority_id')->default('1')->constrained();
            $table->foreignId('status_id')->default('1')->constrained('status', 'id');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('project_id')->nullable()->constrained();
            $table->foreignId('developer_id')->nullable()->constrained('users', 'id');
            $table->timestamp('due_date')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
