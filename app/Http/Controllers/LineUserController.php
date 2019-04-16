<?php

namespace App\Http\Controllers;

use App\LineUser;
use App\Repositories\LineUserRepository;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LineUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LineUserRepository $lineUserRepository)
    {
        if (Route::currentRouteName() == 'get_line_users_from_line_auth') {
            $decoded = JWT::decode($request->line_token, env('LINE_CLIENT_SECRET'), ['HS256']);
            return $lineUserRepository->indexByLineID($decoded->sub);
        }

        return $lineUserRepository->index();
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

    /**
     * Display the specified resource.
     *
     * @param  \App\LineUser  $lineUser
     * @return \Illuminate\Http\Response
     */
    public function show(LineUser $lineUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LineUser  $lineUser
     * @return \Illuminate\Http\Response
     */
    public function edit(LineUser $lineUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LineUser  $lineUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineUser $lineUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LineUser  $lineUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineUser $lineUser)
    {
        //
    }
}
