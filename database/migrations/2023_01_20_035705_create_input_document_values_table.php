<?php

use App\Models\Metric;
use App\Models\InputDocument;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_document_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InputDocument::class)->constrained();
            $table->foreignIdFor(Metric::class)->constrained();
            $table->float('value', 10, 2)->nullable();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_document_values');
    }
};
