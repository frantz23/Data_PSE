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
		Schema::create('donorprograms', function (Blueprint $table) {
        	$table->id();
        	$table->decimal('amount_contributed',15,2)->nullable();
            $table->foreignIdFor(\App\Models\Program::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Donor::class)->constrained()->onDelete('cascade');
        	$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donorprograms');
    }
};
