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
		Schema::create('indicator_value_files', function (Blueprint $table) {
        	$table->id();
        	$table->string('file_name');
			$table->string('file_path');
			$table->string('mime_type')->nullable();
			$table->unsignedbiginteger('file_size')->nullable();
        	$table->timestamps();
        });

		Schema::table('indicator_value_files', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
        });
        Schema::table('indicator_value_files', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\IndicatorValue::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicator_value_files');
    }
};
