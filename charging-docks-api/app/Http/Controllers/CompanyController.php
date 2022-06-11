<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class CompanyController extends Controller
{
/**
* @OA\Get(
* path="/company",
* summary="Retrieve all companies",
* description="Get list of companies",
* operationId="listCompany",
* tags={"list"},

 * @OA\Response(
 *    response=200,
 *    description="Success",
 *    @OA\JsonContent(
 *       @OA\Property(type="object")
*        )
 *     ),
 * )
 */
    public function index(Request $request)
    {
        $companies = Company::with('stations')->get();

        return response()->json($companies, 200);

    }

    /**
     * @OA\Post(
     * path="/",
     * summary="Add new company",
     * description="Add new company",
     * tags={"newcompany"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass company details",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Created",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="object")
     *        )
     *     )
     * )
     */
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



