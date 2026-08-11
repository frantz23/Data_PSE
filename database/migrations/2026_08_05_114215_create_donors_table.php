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
		Schema::create('donors', function (Blueprint $table) {
        	$table->id();
        	$table->string('code')->unique();
			$table->string('name');
			$table->string('type')->nullable();
			$table->string('email')->nullable();
			$table->string('phone', 50)->nullable();
			$table->string('website')->nullable();
			$table->text('address')->nullable();
			$table->string('logo')->nullable();
			$table->boolean('isActive');
        	$table->timestamps();
            $table->softDeletes(); // Recommandé pour ne pas perdre l'historique financier
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
