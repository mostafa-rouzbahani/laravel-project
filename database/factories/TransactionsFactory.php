<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
//        'id'=>
        'advertisement_id'=>App\Advertisement::all(['id'])->random(),
        'transaction_id'=>$faker->text,

        's_user_id'=>App\User::all(['id'])->random(),
        's_currency_id'=>App\Currency::all(['id'])->random(),
        's_country_id'=>App\Country::all(['id'])->random(),
        's_accept_flag'=>$faker->randomDigit,
        's_accept_date'=>$faker->dateTime,
        's_amount'=>$faker->randomDigit,
        's_bank_name'=>$faker->text,
        's_account_number'=>$faker->text,
        's_account_name'=>$faker->text,
        's_description'=>$faker->text,

        'b_user_id'=>App\User::all(['id'])->random(),
        'b_currency_id'=>App\Currency::all(['id'])->random(),
        'b_country_id'=>App\Country::all(['id'])->random(),
        'b_amount'=>$faker->randomDigit,
        'b_bank_name'=>$faker->text,
        'b_account_number'=>$faker->text,
        'b_account_name'=>$faker->text,
        'b_description'=>$faker->text,

        'admin_money_flag'=>$faker->randomDigit,
        'admin_money_date'=>$faker->dateTime,
        'b_money_flag'=>$faker->randomDigit,
        'b_money_date'=>$faker->dateTime,
        's_money_flag'=>$faker->randomDigit,
        's_money_date'=>$faker->dateTime,
        'transLevel_id'=>App\TransLevel::all(['id'])->random(),
        'transState_id'=>App\TransState::all(['id'])->random()
    ];
});
