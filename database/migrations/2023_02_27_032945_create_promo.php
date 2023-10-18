<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->id();
            $table->char('nama', 255)->nullable();
            $table->enum('type', ['diskon', 'voucher'])->default('diskon');
            $table->double('diskon')->nullable();
            $table->double('nominal')->nullable();
            $table->integer('kadaluarsa')->nullable();
            $table->text('syarat_ketentuan')->nullable();
            $table->char('foto', 255)->nullable();
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
        Schema::dropIfExists('promo');
    }
}
