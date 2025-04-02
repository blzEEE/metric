<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;
use App\Models\User;
use App\Models\MetricCategory;
use App\Models\InputDocumentStatus;
use App\Models\MetricPeriod;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(MetricCategory::class)->constrained();
            $table->foreignIdFor(InputDocumentStatus::class)->constrained();
            $table->foreignIdFor(MetricPeriod::class)->constrained();
            $table->integer('year');
            $table->integer('quarter')->default(0);
            $table->integer('month')->default(0);
            $table->timestamps();

            $table->unique(['company_id', 'metric_category_id', 'metric_period_id', 'year', 'quarter', 'month'], 'unique_documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_documents');
    }
};
