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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // ID column
            $table->string('name'); // Task name
            $table->text('detail')->nullable(); // Task details
            $table->boolean('is_completed')->default(false); // Whether user is done
            $table->unsignedBigInteger('workspace_id'); // Foreign key for workspaces
            
            // Foreign key constraint
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
            
            $table->timestamps(); // Created at and updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
