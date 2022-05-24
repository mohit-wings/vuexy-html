<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\DatatablTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use DatatablTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function dataList(Request $request){
        
        $user_id = Auth::user()->id;
        // Listing colomns to show
        $columns = array(
            0 => 'id',
            1 => 'first_name',
            2 => 'mobile',
            3 => 'gender',
            4 => 'user_type',
            5 => 'is_active',
            6 => 'action',
        );

        $totalData = User::whereNotIn('id',[$user_id])->count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = User::when($search, function ($query, $search) {
            return $query->where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('id', 'LIKE', "%{$search}%");
        })->whereNotIn('id',[$user_id]);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {
            
            $row['id'] = $item->id;
            $row['first_name'] =  $item->full_name;
            $row['mobile'] =  $item->mobile;
            $row['gender'] =  $item->gender;
            $row['user_type'] =  $item->user_type;
            $row['is_active'] = $this->status($item->is_active, $item->id, route('change-status', ['id' => $item->id]), 'users');
            $row['action'] = $this->action([
                collect([
                    'text' => 'Show',
                    'id' => $item->id,
                    'action' => route('user.show', $item->id),
                    'icon' => 'fas fa-eye text-orange-red',
                ]),
                collect([
                    'text' => 'Edit',
                    'id' => $item->id,
                    'action' => route('user.edit', $item->id),
                    'icon' => 'fas fa-edit text-dark-pastel-green',
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'action' => route('user.destroy', $item->id),
                    'icon' => 'fas fa-times text-orange-red',
                    'class' => 'delete-confrim',
                ])
            ]);;

            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = User::findOrFail($id);
        return view('admin.user.view',$this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['user'] = User::findOrFail($id);
        return view('admin.user.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        $delete = User::findOrFail($id);
        $delete->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User Deleted Successfully',
        ], 200);
    }
}
