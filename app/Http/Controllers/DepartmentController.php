<?php

namespace App\Http\Controllers;

use App\Http\UseCase\Department\StoreData;
use App\Http\UseCase\Department\UpdateData;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    /** @var DepartmentRepositoryInterface */
    private $departmentRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo = null, DepartmentRepositoryInterface $departmentRepo = null)
    {
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
        $this->departmentRepo = $departmentRepo ?? new DepartmentRepository();
    }

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
     * Update the specified resource in storage.
     *
     * @param DepartmentUpdateRequest $request
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(DepartmentUpdateRequest $request, UpdateData $case): RedirectResponse
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.edit', $input['user_id']);
        }
        return redirect()->route('dashboard.index');
    }

    /**
     * @param Request $request
     * @param int $companyId
     * @return JsonResponse
     */
    public function fetch(Request $request, int $companyId): JsonResponse
    {
        $requestCompanyId = $request->company_id;

        // ログインユーザの関連会社じゃなければエラー
        if ($this->companyRepo->find($companyId)->company_group_id !== $this->companyRepo->find($requestCompanyId)->company_group_id) {
            return response()->json([
                'message' => __('validation.invalid_company_id'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $departments = $this->departmentRepo->getByCompanyId($requestCompanyId)->toArray();

        return response()->json([
            'departments' => $departments,
        ], Response::HTTP_OK);
    }
}
