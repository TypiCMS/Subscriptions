<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMollieColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mollie_customer_id')->nullable();
            $table->string('mollie_mandate_id')->nullable();
            $table->decimal('tax_percentage', 6, 4)->default(0); // optional
            $table->dateTime('trial_ends_at')->nullable(); // optional
            $table->text('extra_billing_information')->nullable(); // optional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mollie_customer_id');
            $table->dropColumn('mollie_mandate_id');
            $table->dropColumn('tax_percentage');
            $table->dropColumn('trial_ends_at');
            $table->dropColumn('extra_billing_information');
        });
    }
}
