<?php
    namespace Bigeweb\App\Http\Controllers;
    use illuminate\Support\Requests\Response;
    use illuminate\Support\Requests\Request;
    
    class DashboardController extends Controller
    {
    
         public function __construct()
        {
            parent::__construct();
        }
    
        /**
         * Display a listing of the resource (GET /posts).
         */
        public function index()
        {
            return view('dashboard');
        }
    
        /**
         * Show the form for creating a new resource (GET /posts/create).
         */
        public function create()
        {
            //
        }
    
        /**
         * Store a newly created resource in storage (POST /posts).
         */
        public function store(Request $request)
        {
            //
        }
    
        /**
         * Display the specified resource (GET /posts/{id}).
         */
        public function show(Request $request)
        {
            //
        }
    
        /**
         * Show the form for editing the specified resource (GET /posts/{id}/edit).
         */
        public function edit(Request $request)
        {
            //
        }
    
        /**
         * Update the specified resource in storage (PUT/PATCH /posts/{id}).
         */
        public function update(Request $request)
        {
           //
        }
    
        /**
         * Remove the specified resource from storage (DELETE /posts/{id}).
         */
        public function destroy(Request $request)
        {
            //
        }
    
        /**
         * Search posts by title or body (GET /posts/search?query=...).
         */
        public function search(Request $request)
        {
            //
        }
    
        /**
         * Restore a soft-deleted post (POST /posts/{id}/restore).
         */
        public function restore(Request $request)
        {
           //
        }
    
        /**
         * Permanently delete a soft-deleted post (DELETE /posts/{id}/force).
         */
        public function forceDelete(Request $request)
        {
           //
        }
    
    }