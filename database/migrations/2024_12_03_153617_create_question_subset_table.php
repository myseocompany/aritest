<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSubsetTable extends Migration
{
    public function up()
    {
        Schema::create('question_subset', function (Blueprint $table) {
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('subset_id')->constrained('subsets')->onDelete('cascade');
            $table->primary(['question_id', 'subset_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('question_subset');
    }
}