@extends('layouts.app')
@section('title', __('common/title.okr.index', ['name' => $user->name]))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.okr.index', ['name' => $user->name]) }}</div>
                <div class="card-body">
                    <div class="pt-4 bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/okrs.fields.year') }}</th>
                                            <th>{{ __('models/quarters.fields.quarter') }}</th>
                                            <th>{{ __('models/okrs.fields.okr') }}</th>
                                            <th>{{ __('models/okrs.fields.score') }}</th>
                                            <th>{{ __('models/objectives.fields.detail') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($okrs as $okr)
                                            <tr>
                                                <td>{{ $okr->year }}</td>
                                                <td>{{ $okr->quarters->quarter }}</td>
                                                <td>{{ $okr->okr }}</td>
                                                <td>{{ $okr->score }}</td>
                                                <td>{{ link_to_route('objective.index', __('common/action.detail'), ['okr_id' => $okr->id]); }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
