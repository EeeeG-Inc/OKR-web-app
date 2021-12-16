@extends('layouts.app')
@section('title', __('common/title.objective.index', ['name' => $user->name]))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.objective.index', ['name' => $user->name]) }}</div>
                    <div class="card-body">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div
                                    class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <!-- フラッシュメッセージ -->
                                    @if (session('success'))
                                        <div class="success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/objectives.fields.year') }}</th>
                                                <th>{{ __('models/quarters.fields.quarter') }}</th>
                                                <th>{{ __('models/objectives.fields.objective') }}</th>
                                                <th>{{ __('models/objectives.fields.score') }}</th>
                                                <th>{{ __('models/key-results.fields.key_result') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($objectives as $objective)
                                                <tr>
                                                    <td>{{ $objective->year }}</td>
                                                    <td>{{ $objective->quarters->quarter }}</td>
                                                    <td>{{ $objective->objective }}</td>
                                                    <td>{{ $objective->score }}</td>
                                                    <td>{{ link_to_route('key_result.index', __('common/action.detail'), ['objective_id' => $objective->id]) }}
                                                    </td>
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
