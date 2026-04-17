Schema::create('users', function (Blueprint $table) {
    $table->id();

    $table->string('name');
    $table->string('username')->unique();
    $table->string('email')->unique();

    $table->string('password');

    $table->enum('role', ['admin', 'penghuni'])
          ->default('penghuni');

    $table->rememberToken();
    $table->timestamps();
});
