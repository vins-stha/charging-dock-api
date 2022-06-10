<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::with('stations')->get();

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
            return response()->json($exception, 400);
        }
        return response()->json($company, 201);

    }

    public function findById(Request $request, $id)
    {
        $id = intval($id);
        try {
            $company = Company::with('stations')->find($id);

            if (!$company) {
                return response()->json(["data" => "Not found"], 404);
            }

        } catch (Exception $exception) {
            return response()->json($exception, 400);
        }

        return response()->json($company, 200);
    }

    public function updateById(Request $request, $id)
    {
        $id = intval($id);
        try {
            $company = Company::find($id);
            if (!$company) {
                return response()->json(["data" => "Not found"], 404);
            }

            $company->name = $request->get('name');
            $parent_company_name = $request->get('parent_company_name');

            if ($parent_company_name !== null) {
                $company->parent_company_id = Company::where('name', $parent_company_name)
                    ->value('id');
            }
            try {

                $company->save();

            } catch (Exception $exception) {
                return response()->json($exception, 400);
            }

        } catch (Exception $exception) {
            return response()->json($exception, 400);
        }
        return response()->json($company, 200);
    }

    public function destroy(Request $request, $id)
    {
        $id = intval($id);
        try {
            $company = Company::find($id);

            if (!$company) {
                return response()->json(["data" => "Not found"], 404);
            }
            $company->delete();

        } catch (Exception $exception) {
            return response()->json($exception, 400);
        }

        return response()->json(["data" => "Deleted successfully."], 204);
    }

}
