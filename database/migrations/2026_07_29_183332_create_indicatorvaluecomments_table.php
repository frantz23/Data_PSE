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
        Schema::create('indicatorvaluecomments', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->foreignIdFor(\App\Models\IndicatorValue::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            //  AJOUT DE ->nullable() : Indispensable pour créer un commentaire principal sans parent
            $table->foreignIdFor(\App\Models\IndicatorValueComment::class)
                ->nullable()
                ->constrained('indicatorvaluecomments')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicatorvaluecomments');
    }
};
