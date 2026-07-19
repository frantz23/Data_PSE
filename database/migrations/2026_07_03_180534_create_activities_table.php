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
    Schema::create('activities', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description')->nullable();
      $table->decimal('budget',15,2)->nullable();
      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');
      $table->unsignedTinyInteger('completion_rate')->default(0);
      $table->foreignId('user_id')
        ->constrained('users')
        ->onDelete('cascade');
      $table->foreignId('assigned_to')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();
      $table->foreignId('parent_activity_id')
        ->nullable()
        ->constrained('activities')
        ->nullOnDelete();
      $table->timestamps();
    });

    Schema::table('activities', function (Blueprint $table) {
      $table->foreignIdFor(\App\Models\Project::class)->constrained()->onDelete('cascade');
    });

    Schema::table('activities', function (Blueprint $table) {
      $table->foreignIdFor(\App\Models\Organization::class)->constrained()->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('activities');
  }
};
