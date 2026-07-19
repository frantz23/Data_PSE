
		Schema::create('users', function (Blueprint $table) {
        	$table->id();
        
        	$table->timestamps();
        });

		Schema::table('organizations', function (Blueprint $table) {
                    $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
                
