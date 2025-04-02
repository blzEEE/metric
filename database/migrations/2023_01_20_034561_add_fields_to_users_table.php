<?php

use App\Models\Company;
use App\Models\UserRole;
use App\Models\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Company::class)->after('id')->nullable()->constrained();
            $table->foreignIdFor(UserRole::class)->after('company_id')->constrained();
            $table->foreignIdFor(UserStatus::class)->after('user_role_id')->constrained();
            $table->string('surname', 50)->after('user_status_id')->nullable();
            $table->string('secname', 50)->after('name')->nullable();
            $table->string('position', 50)->after('secname')->nullable();
            $table->string('contacts', 50)->after('position')->nullable();
        });

        DB::table('users')->insert([
            'email' => 'admin@example.com',
            'surname' => 'Администратор',
            'name' => 'Системы',
            'password' => Hash::make('password'),
            'company_id' => null,
            'user_role_id' => 1,
            'user_status_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_id');
            $table->dropConstrainedForeignId('user_role_id');
            $table->dropConstrainedForeignId('user_status_id');
            $table->dropColumn('surname');
            $table->dropColumn('secname');
        });
    }
};
