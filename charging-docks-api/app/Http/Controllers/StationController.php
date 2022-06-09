<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Company;

use Mockery\Exception;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $stations = Station::all();//ompany::with('station')->get()->all();

        return response()->json($stations, 200);

    }

    public function create(Request $request)
    {
        $station['name'] = $request->get('name');
        $station['latitude'] = $request->get('latitude');
        $station['longitude'] = $request->get('longitude');
        $station['address'] = $request->get('address');

        $parent_company_name = $request->get('parent_company_name');

        if ($parent_company_name === null) {
            return response()->json(["data" => "Parent company required!"], 500);
        }

        if ($parent_company_name !== null) {
            $station['company_id'] = Company::query()
                ->where('name', $parent_company_name)
                ->value('id');
        }

        try {
            $station = new Station($station);
            $station->save();

        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
        return response()->json($station, 201);

    }

    public function findById(Request $request, $id)
    {
        $id = intval($id);
        try {
            $station = Station::find($id);

            if (!$station) {
                return response()->json(["data" => "Not found"], 404);
            }

        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }

        return response()->json($station, 200);
    }

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
                return response()->json($exception, 500);
            }

        } catch (Exception $exception) {
            return response()->json($exception, 500);
        }
        return response()->json($station, 200);
    }

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
            return response()->json($exception, 500);
        }

        return response()->json(["data" => "Deleted successfully."], 200);
    }

}
