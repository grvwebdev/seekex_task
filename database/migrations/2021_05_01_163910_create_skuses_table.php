<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->char('name', 2)->unique();
            $table->unsignedDecimal('volumetric_size', $precision = 4, $scale = 2);
            $table->timestamps();
        });

        $insertData = [
            ['name' => 'A', 'volumetric_size' => 1],
            ['name' => 'B', 'volumetric_size' => 2],
            ['name' => 'C', 'volumetric_size' => 0.5],
            ['name' => 'D', 'volumetric_size' => 0.8],
            ['name' => 'E', 'volumetric_size' => 2.5],
        ];
        DB::table('skus')->insert($insertData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skus');
    }
}
