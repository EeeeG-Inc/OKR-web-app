<?php

namespace App\Http\Controllers;

use App\Http\UseCase\Department\StoreData;
use App\Http\Requests\DepartmentStoreRequest;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
     */
    public function store(DepartmentStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.create');
        }
        return redirect()->route('dashboard.index');
    }

    /**
     * @param Request $request
     * @param int $companyId
     * @return RedirectResponse
     */
    public function fetch(Request $request, int $companyId): JsonResponse
    {
        $requestCompanyId = $request->companyId;

        if (Company::find($companyId)->company_group_id !== Company::find($requestCompanyId)->company_group_id) {
            return response()->json([
                'message' => __('validation.invalid_company_id'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $departments = Department::select(['id', 'name'])->where('company_id', '=', $requestCompanyId)->get()->toArray();

        return response()->json([
            'departments' => $departments,
        ], Response::HTTP_OK);
    }
}
