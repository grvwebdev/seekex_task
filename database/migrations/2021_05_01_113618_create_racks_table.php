<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('racks', function (Blueprint $table) {
            $table->id();
            $table->char('name', 2)->unique();
            $table->decimal('capacity', $precision = 4, $scale = 2);
            $table->tinyInteger('capacity_rank');
            $table->tinyInteger('distance_rank');
            $table->unsignedDecimal('storage_coefficient_s', $precision = 4, $scale = 2);
            $table->boolean('loaded')->default(0);
            $table->timestamps();
        });

        $insertData = [
            ['name' => 'R1', 'capacity' => 10, 'capacity_rank' => 3, 'distance_rank' =>  3, 'storage_coefficient_s' => 3],
            ['name' => 'R2', 'capacity' => 20, 'capacity_rank' => 1, 'distance_rank' =>  4, 'storage_coefficient_s' => 3.1],
            ['name' => 'R3', 'capacity' => 12, 'capacity_rank' => 2, 'distance_rank' =>  1, 'storage_coefficient_s' => 1.3],
            ['name' => 'R4', 'capacity' => 8, 'capacity_rank' => 4, 'distance_rank' =>  2, 'storage_coefficient_s' => 2.6],
            ['name' => 'R5', 'capacity' => 20, 'capacity_rank' => 1, 'distance_rank' =>  5, 'storage_coefficient_s' => 3.8],
        ];
        DB::table('racks')->insert($insertData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('racks');
    }
}
