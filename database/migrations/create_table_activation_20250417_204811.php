<?php
    namespace Database\Migrations;
    
    use illuminate\Support\Database\Schema;

    class create_table_activation_20250417_204811
    {
    
     /**
     * @return void
     *
     * Use to load the  migration
     */
 
 
        public function up()
        {
            Schema::create('activations', function ($table){
                $table->id();
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
            Schema::drop('activations');
        }
    }