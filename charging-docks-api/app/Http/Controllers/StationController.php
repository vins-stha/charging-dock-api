<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Company;

use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class StationController extends Controller
{
    /**
     * @OA\Get(
     * path="/station",
     * summary="List all stations",
     * description="Get list of stations",
     * operationId="listStation",
     * tags={"List all stations"},
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
        $lat=13.20;
        $long = 14.20;
        $rad = 1.00;
        $stations = DB::table('station')->get()->all();

        $stationInRadius= [];
        foreach ($stations as $station)
        {
          if($this->isNearToThePoint($rad, $lat, $long, $station->latitude, $station->longitude))
              $stationInRadius[]=$station;
        }

        return response()->json($stationInRadius, 200);
    }

    /**
     * @OA\Post(
     * path="/station",
     * summary="Add new station",
     * description="Add new station",
     * tags={"Add new station"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass station details",
     *    @OA\JsonContent(
     *       required={"name", "parent_company_name", "address"},
     *       @OA\Property(property="name", type="string"),
     *     @OA\Property(property="parent_company_name", type="string"),
     *      @OA\Property(property="address", type="string"),
     *      @OA\Property(property="latitude", type="double"),
     *      @OA\Property(property="longitude", type="double"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Created",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="object")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Bad request",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="object")
     *        )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $station['name'] = $request->get('name');
        $station['latitude'] = $request->get('latitude');
        $station['longitude'] = $request->get('longitude');
        $station['address'] = $request->get('address');

        $parent_company_name = $request->get('parent_company_name');
        if ($parent_company_name === null) {
            return response()->json(["data" => "Parent company required!"], 400);
        }

        if ($parent_company_name !== null) {
            $station['company_id'] = Company::query()
                ->where('name', $parent_company_name)
                ->value('id');
        }
        if (!$station['company_id']) {
            return response()->json(["data" => "No such parent company"], 404);
        }

        try {
            $station = new Station($station);

            $station->save();

        } catch (Exception $exception) {
            return response()->json($exception, 400);
        }
        return response()->json($station, 201);

    }

    /**
     * @OA\Get(
     *      path="/station/{id}",
     *      operationId="getStationById",
     *      tags={"Find Station by id"},
     *      summary="Get station information",
     *      description="Returns station data",
     *      @OA\Parameter(
     *          name="id",
     *          description="station id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\Property(property="message", type="object")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     * )
     */
    public function findById(Request $request, $id)
    {
        $id = intval($id);
        try {
            $station = Station::find($id);

            if (!$station) {
                return response()->json(["data" => "Not found"], 404);
            }

        } catch (Exception $exception) {
            return response()->json($exception, 400);
        }

        return response()->json($station, 200);
    }

    /**
     * @OA\Get(
     *      path="/station/company/{id}",
     *      operationId="getAllStationsByCompanyId",
     *      tags={"Find Stations by company id"},
     *      summary="List all stations information by company",
     *      description="Returns station list for given company",
     *      @OA\Parameter(
     *          name="id",
     *          description="company id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\Property(property="message", type="object")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     * )
     */
    public function allStationsByParentCompanyId(Request $request, $id){

        $id = intval($id);

        $stations = Station::query()->where('company_id',$id)->get();

        return response()->json($stations, 200);
    }

    /**
     * @OA\Put(
     * path="/station/{id}",
     * operationId="UpdateStationById",
     * summary="Edit station information ",
     * description="Update station",
     * tags={"Update station by id"},
     *      @OA\Parameter(
     *          name="id",
     *          description="station id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass station details",
     *    @OA\JsonContent(
     *       required={"name", "parent_company_name", "address"},
     *       @OA\Property(property="name", type="string"),
     *     @OA\Property(property="parent_company_name", type="string"),
     *      @OA\Property(property="address", type="string"),
     *      @OA\Property(property="latitude", type="double"),
     *      @OA\Property(property="longitude", type="double"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Updated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="object")
     *        )
     *     )
     * )
     */
    public function updateById(Request $request, $id)
    {
        $id = intval($id);
        try {
            $station = Station::find($id);
            if (!$station) {
                return response()->json(["data" => "Not found"], 404);
            }

            $station->name = $request->get('name');
            $station->latitude = $request->get('latitude');
            $station->longitude = $request->get('longitude');
            $station->address = $request->get('address');
            $parent_company_name = $request->get('parent_company_name');

            if ($parent_company_name) {
                $station->company_id = Company::query()
                    ->where('name', $parent_company_name)
                    ->value('id');
                if (!$station->company_id) {
                    return response()->json(["data" => "No such parent company"], 404);
                }
            }

            try {

                $station->save();

            } catch (Exception $exception) {
                return response()->json($exception, 400);
            }

        } catch (Exception $exception) {
            return response()->json($exception, 400);
        }
        return response()->json($station, 200);
    }

    /**
     * @OA\Delete(
     * path="/station/{id}",
     * operationId="DeleteStationById",
     * summary="Delete station",
     * description="Delete station",
     * tags={"Delete station by id"},
     *      @OA\Parameter(
     *          name="id",
     *          description="station id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\Response(
     *    response=204,
     *    description="Deleted successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="object")
     *        )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     * )
     */
    public function destroy(Request $request, $id)
    {
        $id = intval($id);
        try {
            $station = Station::find($id);

            if (!$station) {
                return response()->json(["data" => "Not found"], 404);
            }
            $station->delete();

        } catch (Exception $exception) {
            return response()->json($exception, 400);
        }

        return response()->json(["data" => "Deleted successfully."], 204);
    }

    public function isNearToThePoint($radius, $startLat, $startLong, $stationLat, $stationong)
    {
        $lat = $startLat - $stationLat;
        $long = $startLong - $stationong;
        $val = (sin($lat / 2)) ** 2 + cos($startLat) * cos($stationLat) * (sin($long / 2)) ** 2;
        $res = 2 * asin(sqrt($val));

        $distance = $res;
        if ($distance <= $radius)
            return true;
        return false;
    }

}
