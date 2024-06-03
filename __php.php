<?php 

Schema::create('users', function
(Blueprint $table) {
$table->id();
$table->string('username')->unique();
$table->string('password');
$table->enum('role', ['admin', 'manager', 'employee']);
$table->timestamps();
});

Schema::create('clients', function (Blueprint $table) {
$table->id();
$table->string('name');
$table->string('email')->unique();
$table->string('phone')->nullable();
$table->string('address')->nullable();
$table->date('last_contact_date')->nullable();
$table->timestamps();
});

Schema::create('orders', function (Blueprint $table) {
$table->id();
$table->foreignId('client_id')->constrained();
$table->date('order_date');
$table->enum('status', ['pending', 'processed', 'shipped', 'delivered', 'canceled']);
$table->decimal('total', 10, 2);
$table->timestamps();
});

Schema::create('inventory', function (Blueprint $table) {
$table->id();
$table->string('item_name');
$table->text('description')->nullable();
$table->integer('quantity');
$table->decimal('price', 10, 2);
$table->integer('alert_threshold');
$table->timestamps();
});

Schema::create('order_items', function (Blueprint $table) {
$table->id();
$table->foreignId('order_id')->constrained();
$table->foreignId('item_id')->constrained('inventory');
$table->integer('quantity');
$table->timestamps();
});

Schema::create('finances', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained();
$table->foreignId('order_id')->nullable()->constrained();
$table->date('transaction_date');
$table->enum('type', ['income', 'expense']);
$table->decimal('amount', 10, 2);
$table->text('description')->nullable();
$table->timestamps();
});

Schema::create('notifications', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained();
$table->foreignId('client_id')->nullable()->constrained();
$table->foreignId('order_id')->nullable()->constrained();
$table->text('message');
$table->timestamp('sent_at')->useCurrent();
$table->timestamps();
});
