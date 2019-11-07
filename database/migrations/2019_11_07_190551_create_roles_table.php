<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRolesTable
 */
class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('roles', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->unique();
            $table->boolean('full_access')->default(false);
            $table->longText('accessible_routes');
            $table->text('description')->nullable();
        });

        Schema::create('admin_role', function(Blueprint $table) {
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('role_id');

            $table->unique(['admin_id', 'role_id'], 'admin_id_role_id_unique');
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('admin_role');
        Schema::dropIfExists('roles');
    }
}
