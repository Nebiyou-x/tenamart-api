<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaitingList;
use App\Http\Resources\WaitingListResource;
use App\Http\Requests\StoreWaitingListRequest;
use App\Http\Requests\UpdateWaitingListRequest;


class WaitingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = WaitingList::query();

    if ($request->has('signup_source')) {
        $query->where('signup_source', $request->signup_source);
    }

    if ($request->has('date')) {
        $query->whereDate('created_at', $request->date);
    }

    return WaitingListResource::collection($query->paginate(10));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(StoreWaitingListRequest $request)
{
     \Log::info('StoreWaitingListRequest passed validation.');
    $data = $request->validated(); // uses rules from the FormRequest class

    $user = WaitingList::create($data);
    return response()->json($user, 201);
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWaitingListRequest $request, $id)
    {
    $user = WaitingList::findOrFail($id);

    $data = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:waiting_lists,email,' . $id,
        'signup_source' => 'sometimes|string'
    ]);

    $user->update($data);
    return response()->json($user);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $user = WaitingList::findOrFail($id);
    $user->delete();
    return response()->json(['message' => 'Deleted successfully']);
    }
}
