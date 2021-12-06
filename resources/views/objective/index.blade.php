@extends('layouts.app')
@section('title', __('common/title.objective.index', ['name' => $okr->users->name, 'okr' => $okr->okr]))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.objective.index', ['name' => $okr->users->name, 'okr' => $okr->okr]) }}</div>
                <div class="card-body">
                    <div class="pt-4 bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                <p>{{ link_to_route('okr.index', __('common/action.back'), ['user_id' => $okr->users->id]); }}</p>

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/objectives.fields.objective') }}</th>
                                            <th>{{ __('models/objectives.fields.score') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($objectives as $objective)
                                            <tr>
                                                <td>{{ $objective->objective }}</td>
                                                <td>{{ $objective->score }}</td>
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
