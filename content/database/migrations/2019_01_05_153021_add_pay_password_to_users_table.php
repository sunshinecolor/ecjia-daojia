<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddPayPasswordToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('users', function (Blueprint $table) {
            $table->string('pay_password', 32)->nullable()->comment('支付密码')->after('passwd_answer');
            $table->string('account_status', 30)->nullable()->default('normal')->comment('账户状态（normal正常，wait_delete已申请了账号注销待删除账号）')->after('pay_password');
            $table->integer('delete_time')->unsigned()->default('0')->comment('账号申请注销时间')->after('account_status');
            $table->integer('activate_time')->unsigned()->default('0')->comment('账号申请激活时间')->after('delete_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pay_password');
            $table->dropColumn('account_status');
            $table->dropColumn('delete_time');
            $table->dropColumn('activate_time');
        });
    }
}
