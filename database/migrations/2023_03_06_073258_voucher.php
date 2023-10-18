<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Voucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_customer',)->nullable();
            $table->bigInteger('id_promo',)->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('jumlah_nominal')->nullable();
            $table->integer('tanggal_mulai')->nullable();
            $table->integer('periode_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Generate deleted_at
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher');
    }
}
