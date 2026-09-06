<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
	public function up(): void
	{
		Schema::create('cities', function (Blueprint $table): void {
			$table->id();
			$table->string('name')->unique();
			$table->string('region')->nullable();
			$table->timestamps();
		});

		Schema::create('clubs', function (Blueprint $table): void {
			$table->id();
			$table->foreignId('city_id')->constrained()->restrictOnDelete();
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('contact_email')->nullable();
			$table->string('phone')->nullable();
			$table->timestamps();
		});

		Schema::create('venues', function (Blueprint $table): void {
			$table->id();
			$table->foreignId('city_id')->constrained()->restrictOnDelete();
			$table->string('name');
			$table->string('address')->nullable();
			$table->unsignedInteger('capacity')->nullable();
			$table->timestamps();
		});

		Schema::create('tournaments', function (Blueprint $table): void {
			$table->id();
			$table->foreignId('organizer_id')->constrained('users')->restrictOnDelete();
			$table->foreignId('club_id')->nullable()->constrained()->nullOnDelete();
			$table->foreignId('venue_id')->nullable()->constrained()->nullOnDelete();
			$table->foreignId('city_id')->constrained()->restrictOnDelete();
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('format');
			$table->string('status')->default('pending');
			$table->date('start_date');
			$table->date('end_date')->nullable();
			$table->date('registration_deadline')->nullable();
			$table->unsignedInteger('max_players')->nullable();
			$table->decimal('entry_fee', 10, 2)->default(0);
			$table->timestamps();
		});

		Schema::create('registrations', function (Blueprint $table): void {
			$table->id();
			$table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
			$table->foreignId('player_id')->constrained('users')->cascadeOnDelete();
			$table->string('status')->default('confirmed');
			$table->timestamp('registered_at');
			$table->text('notes')->nullable();
			$table->timestamps();
			$table->unique(['tournament_id', 'player_id']);
		});
	}

	public function down(): void
	{
		foreach (['registrations', 'tournaments', 'venues', 'clubs', 'cities'] as $table) {
			Schema::dropIfExists($table);
		}
	}
};
