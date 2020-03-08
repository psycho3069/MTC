<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use DB;
use PDF;
use Auth;
use Session;
use Exception;


class AccountsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    // ----- METHODS FOR LEDGER-ACCOUNT ----- //
    //ledger-account
    public function ledger_account(){
        $account_head_types = DB::table('account_head_types')
        					->orderBy('id', 'asc')
                          	->get();
        $all = DB::table('account_heads')
                  ->get();
        $assets = DB::table('account_heads')
        					->where('parent_id', '=', 2)
        					->where('parent_code', '=', 1000)
        					->get();
            $asset_fixed = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 1100)
                      ->get();
                $fixed_land_and_building = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1150)
                          ->get();
                $fixed_furniture_and_fixture = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1200)
                          ->get();
                $fixed_office_equipments = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1250)
                          ->get();
                $fixed_vehicles = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1300)
                          ->get();
                $fixed_electronic_equipments = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1350)
                          ->get();
                $fixed_other_fixed_assets = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1400)
                          ->get();
            $asset_current = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 1500)
                      ->get();
                $current_loan_with_members = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1900)
                          ->get();
                $current_others_loan = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 2000)
                          ->get();
                $current_advance = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 2100)
                          ->get();
                $current_others_investment = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 2300)
                          ->get();
                $current_cash_and_bank = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1700)
                          ->get();
                    $cash_and_bank_cash_in_hand = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 1750)
                              ->get();
                    $cash_and_bank_cash_at_bank = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 1800)
                              ->get();
                $current_loan_to_project = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1510)
                          ->get();
                $current_other_current_asset = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1550)
                          ->get();
                $current_fund_with_branch = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 1600)
                          ->get();

       	$liability = DB::table('account_heads')
        					->where('parent_id', '=', 2)
        					->where('parent_code', '=', 3000)
        					->get();
            $current_liability_member_savings = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 3100)
                      ->get();
                $general_savings = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3120)
                          ->get();
                    $jagaron = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.1)
                              ->get();
                    $agrashor = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.2)
                              ->get();
                    $buniad = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.3)
                              ->get();
                    $mfmsf = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.4)
                              ->get();
                    $sufalon = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.5)
                              ->get();
                    $efrrap = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.6)
                              ->get();
                    $fsp = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.7)
                              ->get();
                    $enrich_iga = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.8)
                              ->get();
                    $enrich_lil = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.9)
                              ->get();
                    $enrich_acl = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.10)
                              ->get();
                    $education = DB::table('account_heads')
                              ->where('parent_id', '=', 5)
                              ->where('parent_code', '=', 3120.11)
                              ->get();
                $special_savings = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3140)
                          ->get();
                $monthly_savings = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3150)
                          ->get();
                $emergency_fund = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3160)
                          ->get();
                $health_savings = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3180)
                          ->get();
                $fixed_general_savings = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3190)
                          ->get();
            $other_savings = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 3200)
                      ->get();
                $other_special_savings = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3201)
                          ->get();
                $other_staff_welfare = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3206)
                          ->get();
            $long_term_liability = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 3300)
                      ->get();
                $long_fund = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3350)
                          ->get();
            $current_account_principal = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 3400)
                      ->get();
                $current_inter_transaction = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3420)
                          ->get();
            $others_liability = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 3500)
                      ->get();
                $other_reserve_and_provision = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3520)
                          ->get();
                $other_other_fund = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3550)
                          ->get();
            $capital_fund = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 3600)
                      ->get();
                $capital_retained_surplus = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3620)
                          ->get();
                $capital_capital_fund = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3601)
                          ->get();
            $loan_with_others = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 3700)
                      ->get();
                $loan_loan_with_others = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 3710)
                          ->get();

        $income = DB::table('account_heads')
        					->where('parent_id', '=', 2)
        					->where('parent_code', '=', 4000)
        					->get();
            $income_general = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 4100)
                      ->get();
                $general_service_charge_member = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 4150)
                          ->get();
                $general_service_charge_branch = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 4400)
                          ->get();
            $income_other = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 4200)
                      ->get();
                $other = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 4250)
                          ->get();
                $bank = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 4300)
                          ->get();
            $income_reimburse = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 7700)
                      ->get();
            $income_training = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 4500)
                      ->get();

       	$expense = DB::table('account_heads')
        					->where('parent_id', '=', 2)
        					->where('parent_code', '=', 5000)
        					->get();
            $expense_financial = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 5100)
                      ->get();
                $financial_service_charge = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 5130)
                          ->get();
                $financial_interest_group_savings = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 5120)
                          ->get();
            $expense_current = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 5200)
                      ->get();
                $current_service_charge_ho = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 5220)
                          ->get();
            $expense_salary = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 5300)
                      ->get();
                $salary_and_allowance = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 5310)
                          ->get();
            $expense_operating = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 5400)
                      ->get();
                $operating_cost = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 5450)
                          ->get();
                $bank_charge = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 5500)
                          ->get();
            $expense_non_operating = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 5600)
                      ->get();
                $non_operating_cost = DB::table('account_heads')
                          ->where('parent_id', '=', 4)
                          ->where('parent_code', '=', 5650)
                          ->get();
            $expense_training_centre = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 5700)
                      ->get();
            $expense_loss_on_sale_of_land = DB::table('account_heads')
                      ->where('parent_id', '=', 3)
                      ->where('parent_code', '=', 5001)
                      ->get();

        $equity = DB::table('account_heads')
        					->where('parent_id', '=', 2)
        					->where('parent_code', '=', 6000)
        					->get();

        $manage_ledger_accounts = view('admin.account.ledger_account.ledger_accounts')
                        ->with('account_head_types',$account_head_types)
                        ->with('all',$all)
                          	->with('assets',$assets)
                                ->with('asset_fixed',$asset_fixed)
                                    ->with('fixed_land_and_building',$fixed_land_and_building)
                                    ->with('fixed_furniture_and_fixture',$fixed_furniture_and_fixture)
                                    ->with('fixed_office_equipments',$fixed_office_equipments)
                                    ->with('fixed_vehicles',$fixed_vehicles)
                                    ->with('fixed_electronic_equipments',$fixed_electronic_equipments)
                                    ->with('fixed_other_fixed_assets',$fixed_other_fixed_assets)
                                ->with('asset_current',$asset_current)
                                    ->with('current_loan_with_members',$current_loan_with_members)
                                    ->with('current_others_loan',$current_others_loan)
                                    ->with('current_advance',$current_advance)
                                    ->with('current_others_investment',$current_others_investment)
                                    ->with('current_cash_and_bank',$current_cash_and_bank)
                                        ->with('cash_and_bank_cash_in_hand',$cash_and_bank_cash_in_hand)
                                        ->with('cash_and_bank_cash_at_bank',$cash_and_bank_cash_at_bank)
                                    ->with('current_loan_to_project',$current_loan_to_project)
                                    ->with('current_other_current_asset',$current_other_current_asset)
                                    ->with('current_fund_with_branch',$current_fund_with_branch)
                          	->with('liability',$liability)
                                ->with('current_liability_member_savings',$current_liability_member_savings)
                                    ->with('general_savings',$general_savings)
                                        ->with('jagaron',$jagaron)
                                        ->with('agrashor',$agrashor)
                                        ->with('buniad',$buniad)
                                        ->with('mfmsf',$mfmsf)
                                        ->with('sufalon',$sufalon)
                                        ->with('efrrap',$efrrap)
                                        ->with('fsp',$fsp)
                                        ->with('enrich_iga',$enrich_iga)
                                        ->with('enrich_lil',$enrich_lil)
                                        ->with('enrich_acl',$enrich_acl)
                                        ->with('education',$education)
                                    ->with('special_savings',$special_savings)
                                    ->with('monthly_savings',$monthly_savings)
                                    ->with('emergency_fund',$emergency_fund)
                                    ->with('health_savings',$health_savings)
                                    ->with('fixed_general_savings',$fixed_general_savings)
                                ->with('other_savings',$other_savings)
                                    ->with('other_special_savings',$other_special_savings)
                                    ->with('other_staff_welfare',$other_staff_welfare)
                                ->with('long_term_liability',$long_term_liability)
                                    ->with('long_fund',$long_fund)
                                ->with('current_account_principal',$current_account_principal)
                                    ->with('current_inter_transaction',$current_inter_transaction)
                                ->with('others_liability',$others_liability)
                                    ->with('other_reserve_and_provision',$other_reserve_and_provision)
                                    ->with('other_other_fund',$other_other_fund)
                                ->with('capital_fund',$capital_fund)
                                    ->with('capital_retained_surplus',$capital_retained_surplus)
                                    ->with('capital_capital_fund',$capital_capital_fund)
                                ->with('loan_with_others',$loan_with_others)
                                    ->with('loan_loan_with_others',$loan_loan_with_others)
                          	->with('income',$income)
                                ->with('income_general',$income_general)
                                    ->with('general_service_charge_member',$general_service_charge_member)
                                    ->with('general_service_charge_branch',$general_service_charge_branch)
                                ->with('income_other',$income_other)
                                    ->with('other',$other)
                                    ->with('bank',$bank)
                                ->with('income_reimburse',$income_reimburse)
                                ->with('income_training',$income_training)
                          	->with('expense',$expense)
                                ->with('expense_financial',$expense_financial)
                                    ->with('financial_service_charge',$financial_service_charge)
                                    ->with('financial_interest_group_savings',$financial_interest_group_savings)
                                ->with('expense_current',$expense_current)
                                    ->with('current_service_charge_ho',$current_service_charge_ho)
                                ->with('expense_salary',$expense_salary)
                                    ->with('salary_and_allowance',$salary_and_allowance)
                                ->with('expense_operating',$expense_operating)
                                    ->with('operating_cost',$operating_cost)
                                    ->with('bank_charge',$bank_charge)
                                ->with('expense_non_operating',$expense_non_operating)
                                    ->with('non_operating_cost',$non_operating_cost)
                                ->with('expense_training_centre',$expense_training_centre)
                                ->with('expense_loss_on_sale_of_land',$expense_loss_on_sale_of_land)
                          	->with('equity',$equity);
        return view('admin.master')
                          	->with('admin.account.ledger_account.ledger_accounts',$manage_ledger_accounts);
    }

    // ----- METHODS FOR VOUCHER ----- //
    //Vouchers
    public function voucher(){
        $voucher_info=DB::table('vouchers')
                            ->orderBy('id', 'desc')
                            ->get();
        $voucher_type_info=DB::table('vouchers')
                            ->orderBy('id', 'desc')
                            ->get();
        $manage_vouchers=view('admin.account.voucher.vouchers')
                            ->with('voucher_info',$voucher_info)
                            ->with('voucher_type_info',$voucher_type_info);
        return view('admin.master')
                            ->with('admin.account.voucher.vouchers',$manage_vouchers);
    }
    //Debit-Manual
    public function debit_manual(){
        $account_heads = DB::table('account_heads')
                            ->get();
        $voucher_type_info = DB::table('vouchers')
                            ->orderBy('id', 'desc')
                            ->get();
        return view('admin.account.voucher.debit_voucher_manual')
                            ->with('voucher_type_info',$voucher_type_info);
    }
    //Credit-Manual
    public function credit_manual(){
        $account_heads = DB::table('account_heads')
                            ->get();
        $voucher_type_info = DB::table('vouchers')
                            ->orderBy('id', 'desc')
                            ->get();
        return view('admin.account.voucher.credit_voucher_manual')
                            ->with('voucher_type_info',$voucher_type_info);
    }


    // Accounts (Reyajul)
    public function accounts()
    {
        return view('admin.account.accounts');
    }

    // //SAVE GROCERY TO DATABASE
    // public function save_grocery(Request $request)
    // {
    //     $this->validate($request, [
    //       'name'  => ['required', 'string', 'max:100','unique:groceries'],
    //       'grocery_category_id'  => ['required', 'integer'],
    //       'description'  => ['max:255'],

    //     ]);
    //     $data = array();
    //     $data['name'] = $request->name;
    //     $data['grocery_category_id'] = $request->grocery_category_id;
    //     $data['description'] = $request->description;
    //     $data['created_at'] = now();

    //     DB::table('groceries')->insert($data);
    //     Session::put('message','Grocery is Added Successfully');
    //     return Redirect::to('/restaurant/grocery/add_grocery');
    // }
    // //EDIT GROCERY
    // public function edit_grocery($id)
    // {
    //     $grocery=DB::table('groceries')
    //                        ->where('id',$id)
    //                        ->first();
    //     $grocery_category_info=DB::table('grocery_categories')
    //                         ->orderBy('id', 'desc')
    //                         ->get();
    //     $manage_grocery=view('admin.restaurant.grocery.edit_grocery')
    //                      ->with('grocery',$grocery)
    //                      ->with('grocery_category_info',$grocery_category_info);
    //     return view('admin.master')
    //                      ->with('admin.restaurant.grocery.edit_grocery',$manage_grocery);
    // }
    // //UPDATE GROCERY
    // public function update_grocery(Request $request, $id)
    // {
    //     $this->validate($request, [
    //       'name'  => ['required', 'string', 'max:100'],
    //       'grocery_category_id'  => ['required', 'integer'],
    //       'description'  => ['max:255']
    //     ]);

    //     $data = array();
    //     $data['name'] = $request->name;
    //     $data['grocery_category_id'] = $request->grocery_category_id;
    //     $data['description'] = $request->description;

    //     DB::table('groceries')
    //          ->where('id',$id)
    //          ->update($data);
    //     Session::put('message','Grocery has been updated Successfully');
    //     return Redirect::to('/restaurant/grocery/groceries');
    // }
    // //DELETE GROCERY FROM DATABASE
    // public function delete_grocery($id)
    // {
    //     DB::table('groceries')
    //             ->where('id',$id)
    //             ->delete();
    //     Session::put('message', 'Grocery has been deleted Successfully');
    //     return Redirect::to('/restaurant/grocery/groceries');
    // }
}
