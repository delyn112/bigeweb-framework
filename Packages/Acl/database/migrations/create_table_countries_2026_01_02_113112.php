<?php
namespace Bigeweb\Acl\Database\Migrations;
    use illuminate\Support\Database\Schema;

    class create_table_countries_2026_01_02_113112
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
             Schema::create('countries', function ($table){
                $table->id();
                $table->int('phone')->nullable();
                $table->string('code')->nullable();
                $table->string('name')->nullable();
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
            Schema::drop('countries');
        }
    }