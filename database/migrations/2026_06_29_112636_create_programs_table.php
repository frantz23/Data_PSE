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
		Schema::create('programs', function (Blueprint $table) {
        	$table->id();
        	$table->string('name');
			$table->string('code')->unique();
			$table->text('description')->nullable();
			$table->decimal('budget',15,2);
			$table->string('donor')->nullable();
			$table->string('currency')->default('FCFA');
			$table->string('funding_partner')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->enum('status', ['draft', 'active', 'completed', 'suspended'])->default('draft');
        	$table->timestamps();
        });

		Schema::table('programs', function (Blueprint $table) {
                    $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
                });

        Schema::table('programs', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Organization::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
