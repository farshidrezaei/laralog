<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaralogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        if ( config( 'laralog.db_driver' ) ) {
            Schema::create( 'laralogs', function ( Blueprint $table ) {
                $table->bigIncrements( 'id' );
                $table->timestamp( 'created_at' )->useCurrent();
                $table->string( 'level' )->default( 'info' );
                $table->string( 'subject' )->nullable();
                $table->text( 'message' )->nullable();
                $table->unsignedBigInteger( 'user_id' )->nullable();
            } );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'laralogs' );
    }
}