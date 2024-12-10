<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use App\Models\Project;
use App\Models\ProjectPhase;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getDataLeaves()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $all_data_for_leaves = [];
            $all_data_for_leaves['leave_types'] = LeaveType::get();
            $all_data_for_leaves['supervisors'] = getSupervisor();
            $all_data_for_leaves['projects'] = Project::get();
            $all_data_for_leaves['project_phases'] = ProjectPhase::get();

            return response()->json(['success' => true, 'data' => $all_data_for_leaves], 201);
        }
    }
}
