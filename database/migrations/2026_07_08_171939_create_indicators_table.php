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
		Schema::create('indicators', function (Blueprint $table) {
        	$table->id();
        	$table->string('name');
			$table->string('code');
			$table->text('description')->nullable();
			$table->enum('result_level',['output','outcome','impact'])->default('output');
			$table->string('data_type');
			$table->string('unit');
			$table->decimal('baseline',15,2)->nullable();
			$table->decimal('target',15,2)->nullable();
			$table->decimal('current_value',15,2)->nullable();
			$table->string('frequency');
			$table->enum('status',['draft','active','archived'])->default('draft');
        	$table->timestamps();
        });

		Schema::table('indicators', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Organization::class)->constrained()->onDelete('cascade');
    	});
        Schema::table('indicators', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Project::class)->constrained()->onDelete('cascade');
        });
        Schema::table('indicators', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
