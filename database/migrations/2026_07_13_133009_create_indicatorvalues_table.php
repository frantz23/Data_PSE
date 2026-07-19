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
		Schema::create('indicatorvalues', function (Blueprint $table) {
        	$table->id();
        	$table->decimal('value_numeric',15,2)->nullable();
			$table->text('value_text')->nullable();
			$table->date('reporting_date');
			$table->text('comment')->nullable();
            $table->boolean('validated')->default(false);
        	$table->timestamps();
        });

		Schema::table('indicatorvalues', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Indicator::class)->constrained()->onDelete('cascade');
        });
        Schema::table('indicatorvalues', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Organization::class)->constrained()->onDelete('cascade');
        });
        Schema::table('indicatorvalues', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicatorvalues');
    }
};
