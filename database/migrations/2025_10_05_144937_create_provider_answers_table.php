<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provider_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('mcq_questions')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->string('attachment')->nullable();
            $table->integer('score')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->boolean('is_evaluated')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();

            $table->unique(['provider_id', 'question_id']);

            $table->index(['provider_id', 'is_evaluated']);
            $table->index(['question_id', 'is_evaluated']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_answers');
    }
};
