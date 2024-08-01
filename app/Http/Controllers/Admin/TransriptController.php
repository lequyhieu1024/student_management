<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TransriptRepository;

class TransriptController extends Controller
{
    protected $transcriptRepository;
    public function __construct(TransriptRepository $transcriptRepository)
    {
        $this->transcriptRepository = $transcriptRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transcripts = $this->transcriptRepository->getAllStudentHasSubject();
        dd($transcripts);
        return view('admin.transcripts.index',compact('transcripts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
