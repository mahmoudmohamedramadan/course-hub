<?php

namespace App\Http\Controllers;

use App\Repositories\Dashboard as DashboardRepository;

class DashboardController
{
    /**
     * Dashboard repository.
     *
     * @var \App\Repositories\Dashboard
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Repositories\Dashboard  $repository
     * @return void
     */
    public function __construct(DashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display the dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        $courses = $this->repository->getEnrolledCourses($user);

        return view('dashboard', compact('courses'));
    }
}
