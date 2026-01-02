<?php
    namespace Database\Migrations;
    
    use illuminate\Support\Database\Schema;

    class create_table_migration_20250417_204906
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {

            Schema::create('migrations', function ($table){
                $table->id();
                $table->string('migration')->nullable();
                $table->timestamps();
            });
 
        }
        
        
    /**
     * @return null
     *
     * Use to drop the database table
     */
        public function down()
        {
            Schema::drop('migrations');
        }
    }