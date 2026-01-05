<?php
namespace Bigeweb\Authentication\Database\Migrations;
    use illuminate\Support\Database\Schema;

    class create_table_users_2026_01_02_113341
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
             Schema::create('users', function ($table){
                $table->id();
                $table->string('firstname')->nullable();
                $table->string('lastname')->nullable();
                $table->string('email')->nullable();
                $table->string('token')->nullable();
                $table->string('password')->nullable();
                $table->string('username')->nullable();
                $table->string('usertype')->nullable();
                $table->enum('banned', ['1', '0'])->default(1);
                $table->enum('status', ['active', 'inactive', 'suspended', 'pending', 'closed', 'banned'])->default('active');
                $table->string('language')->nullable();
                $table->string('email_verified_at')->nullable();
                $table->string('force_email_verify')->nullable();
                $table->string('force_password_change')->nullable();
                $table->string('avatar')->nullable();
                $table->string('uuid')->nullable();
                $table->string('expiry_date')->nullable();
                $table->string('remember_me')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->timestamps();
             });
 
        }
        
        
    /**
     * @return null
     *
     * Use to drop the database table
     * Reverse migration process
     */
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::drop('users');
        }
    }