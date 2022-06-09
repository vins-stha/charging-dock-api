<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::all();

        return response()->json($companies, 200);

    }

    public function create(Request $request)
    {
        $company['name'] = $request->get('name');
        $parent_company_name = $request->get('parent_company_name');

        if ($parent_company_name !== null) {
            $company['parent_company_id'] = DB::table('company')
                ->where('name', $parent_company_name)
                ->value('id');
        }
        try {
            $company = new Company($company);
            $company->save();
            if ($parent_company_name === null) {
                $company ['parent_company_id'] = $company->getAttribute('id');
                $company->save();
            }
        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
        return response()->json($company, 201);

    }


}
