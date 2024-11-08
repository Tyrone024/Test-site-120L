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
        Schema::create('userspaces', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Foreign key for users
            $table->unsignedBigInteger('workspace_id'); // Foreign key for workspaces
            
            // Add the is_admin boolean column
            $table->boolean('is_admin')->default(false); // Default to false
            $table->boolean('request')->default(false); // User request access
            
            // Set composite primary key
            $table->primary(['user_id', 'workspace_id']);
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
            
            $table->timestamps(); // Created at and updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userspaces');
    }
};
