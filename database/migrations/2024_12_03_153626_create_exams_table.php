<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subset_id')->constrained('subsets')->onDelete('cascade');
            $table->decimal('score', 5, 2)->default(0);
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->integer('time_taken'); // Tiempo en segundos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
