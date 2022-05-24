<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function changeStatus(Request $request){
        $table = $request->table;
        $is_active  = $request->status == 'true' ? 'Yes' : 'No';
        $tableRes = DB::table($table)->where('id', $request->id)->update(['is_active' => $is_active]);
        if ($tableRes) {
            $statuscode = 200;
        }
        $message = $request->status == 'true' ? 'Status Successfully Activated' : 'Status Successfully Deactivated';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function checkExist(Request $request)
    {
        $table = $request->table;
        $column = $request->column;
        $value = $request->value;
        $id = $request->id;
        $rel_col = $request->rel_col;
        $sec_rel_col = $request->sec_rel_col;

        $countRec = DB::table($table)
            ->when($id != null, function ($query) use ($request) {
                return $query->where('id', '!=', $request->id);
            })
            ->when($rel_col != null, function ($query) use ($request) {
                return $query->where($request->rel_col, '=', $request->rel_val);
            })
            ->when($sec_rel_col != null, function ($query) use ($request) {
                return $query->where($request->sec_rel_col, '=', $request->sec_rel_val);
            })
            ->where($column, $value)
            ->count();

        if ($countRec > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function getRole(Request $request)
    {
        //dd($request);

        $search = $request->get('search');

        $data = Role::where('name', 'like', '%' . $search . '%')
                ->orderBy('name', 'asc')
                ->get();

        return response()->json($data->toArray());
    }
}
