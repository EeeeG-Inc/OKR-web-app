@extends('layouts.app')
@section('title', __('common/title.key_result.index', ['name' => $objective->users->name, 'objective' => $objective->objective]))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('common/title.key_result.index', ['name' => $objective->users->name, 'objective' => $objective->objective]) }}
                    </div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div
                                    class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <p>{{ link_to_route('objective.index', __('common/action.back'), ['user_id' => $objective->users->id]) }}</p>

                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/objectives.fields.year') }}</th>
                                                <th>{{ __('models/quarters.fields.quarter') }}</th>
                                                <th>{{ __('models/objectives.fields.priority') }}</th>
                                                <th>{{ __('models/objectives.fields.objective') }}</th>
                                                <th>{{ __('models/objectives.fields.score') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td class="align-middle">{{ $objective->year }}</td>
                                                    <td class="align-middle">
                                                        {{ App\Enums\Quarter::getDescription($objective->quarter) }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {!! App\Enums\Priority::getFontAwesome($objective->priority) !!}
                                                        {{ App\Enums\Priority::getDescription($objective->priority) }}
                                                    </td>
                                                    <td class="align-middle">{!! nl2br($objective->objective) !!}</td>
                                                    <td class="align-middle">{{ $objective->score }}</td>
                                                </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/key-results.fields.key_result') }}</th>
                                                <th>{{ __('models/key-results.fields.score') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($keyResults as $keyResult)
                                                <tr>
                                                    <td class="align-middle">{!! nl2br($keyResult->key_result) !!}</td>
                                                    <td class="align-middle">{{ $keyResult->score }}</td>
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
