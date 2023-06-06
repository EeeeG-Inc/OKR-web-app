@extends('layouts.app')
@section('title', __('common/title.objective.edit'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{ Form::open(['route' => ['objective.update', $objective->id], 'method' => 'put']) }}
                {{ Form::token() }}
                {{ Form::hidden('user_id', $user->id) }}

                <div class="card">
                    <div class="card-header">{{ __('common/title.objective.edit') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    <p>{{ link_to_route('objective.index', __('common/action.back'), ['user_id' => $user->id], ['class' => 'text-decoration-none']) }}</p>

                                    @include('flash::message')

                                    <div class="form">
                                        {{-- 年度 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('year', __('models/objectives.fields.year'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('year', $years, $year, ['class' => 'form-control', 'id' => 'year']) }}
                                            </div>
                                        </div>

                                        {{-- 四半期区分 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('quarter', __('models/quarters.fields.quarter'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', App\Enums\Quarter::FULL_YEAR_ID, $quarterChecked[0], ['id' => 'radioQuarter0']) }}
                                                    {{ Form::label('radioQuarter0', $quarterLabels[0]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[0]->id, $quarterChecked[1], ['id' => 'radioQuarter1']) }}
                                                    {{ Form::label('radioQuarter1', $quarterLabels[1]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[1]->id, $quarterChecked[2], ['id' => 'radioQuarter2']) }}
                                                    {{ Form::label('radioQuarter2', $quarterLabels[2]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[2]->id, $quarterChecked[3], ['id' => 'radioQuarter3']) }}
                                                    {{ Form::label('radioQuarter3', $quarterLabels[3]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[3]->id, $quarterChecked[4], ['id' => 'radioQuarter4']) }}
                                                    {{ Form::label('radioQuarter4', $quarterLabels[4]) }}
                                                </div>
                                            </div>
                                        </div>

                                        {{-- OKR --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective', __('models/objectives.fields.objective'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('objective', $objective->objective, ['class' => 'form-control', 'id' => 'objective', 'rows' => '3', 'placeholder' => __('models/objectives.fields.objective') ]) }}
                                            </div>
                                        </div>

                                        {{-- 優先度 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('priority', __('models/objectives.fields.priority')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('priority', $prioritys, $priority, ['class' => 'form-control', 'id' => 'priority']) }}
                                            </div>
                                        </div>

                                        {{-- 備考 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective_remarks', __('models/objectives.fields.remarks')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('objective_remarks', $objective->remarks, ['class' => 'form-control', 'id' => 'objective', 'rows' => '3', 'placeholder' => __('models/objectives.fields.remarks')]) }}
                                            </div>
                                        </div>

                                        {{-- 所感 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective_impression', __('models/objectives.fields.impression')) }}
                                            </div>
                                            <div class="col-md-10 mb-5">
                                                {{ Form::textarea('objective_impression', $objective->impression, ['class' => 'form-control', 'id' => 'objective', 'rows' => '3', 'placeholder' => __('models/objectives.fields.impression')]) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">{{ __('common/title.key_result.edit1') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{-- KeyResult1 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result1', __('models/key-results.fields.key_result') . '1', ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result1', $keyResult1->key_result, ['class' => 'form-control', 'id' => 'key_result1', 'rows' => '3', 'placeholder' => __('models/key-results.fields.key_result')]) }}
                                                {{ Form::hidden('key_result1_id', $keyResult1->id) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result1_score', __('models/key-results.fields.score')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('key_result1_score', $scores, $keyResult1->score, ['class' => 'form-control  w-25', 'id' => 'key_result1_score']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result1_remarks', __('models/key-results.fields.remarks')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result1_remarks', $keyResult1->remarks, ['class' => 'form-control', 'id' => 'key_result1_remarks', 'rows' => '3', 'placeholder' => __('models/key-results.fields.remarks')]) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result1_impression', __('models/key-results.fields.impression')) }}
                                            </div>
                                            <div class="col-md-10 mb-5">
                                                {{ Form::textarea('key_result1_impression', $keyResult1->impression, ['class' => 'form-control', 'id' => 'key_result1_impression', 'rows' => '3', 'placeholder' => __('models/key-results.fields.impression')]) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">{{ __('common/title.key_result.edit2') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{-- KeyResult2 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result2', __('models/key-results.fields.key_result') . '2') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result2', $keyResult2->key_result ?? null, ['class' => 'form-control', 'id' => 'key_result2', 'rows' => '3', 'placeholder' => __('models/key-results.fields.key_result')]) }}
                                                {{ Form::hidden('key_result2_id', $keyResult2->id ?? null) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result2_score', __('models/key-results.fields.score')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('key_result2_score', $scores, $keyResult2->score ?? null, ['class' => 'form-control w-25', 'id' => 'key_result2_score']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result2_remarks', __('models/key-results.fields.remarks')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result2_remarks', $keyResult2->remarks ?? null, ['class' => 'form-control', 'id' => 'key_result2_remarks', 'rows' => '3', 'placeholder' => __('models/key-results.fields.remarks')]) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result2_impression', __('models/key-results.fields.impression')) }}
                                            </div>
                                            <div class="col-md-10 mb-5">
                                                {{ Form::textarea('key_result2_impression', $keyResult2->impression ?? null, ['class' => 'form-control', 'id' => 'key_result2_impression', 'rows' => '3', 'placeholder' => __('models/key-results.fields.impression')]) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">{{ __('common/title.key_result.edit3') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{-- KeyResult3 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result3', __('models/key-results.fields.key_result') . '3') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result3', $keyResult3->key_result ?? null, ['class' => 'form-control', 'id' => 'key_result3', 'rows' => '3', 'placeholder' => __('models/key-results.fields.key_result')]) }}
                                                {{ Form::hidden('key_result3_id', $keyResult3->id ?? null) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result3_score', __('models/key-results.fields.score')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('key_result3_score', $scores, $keyResult3->score ?? null, ['class' => 'form-control w-25', 'id' => 'key_result3_score']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result3_remarks', __('models/key-results.fields.remarks')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result3_remarks', $keyResult3->remarks ?? null, ['class' => 'form-control', 'id' => 'key_result3_remarks', 'rows' => '3', 'placeholder' => __('models/key-results.fields.remarks')]) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result3_impression', __('models/key-results.fields.impression')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result3_impression', $keyResult3->impression ?? null, ['class' => 'form-control', 'id' => 'key_result3_impression', 'rows' => '3', 'placeholder' => __('models/key-results.fields.impression')]) }}
                                            </div>
                                        </div>

                                        {{-- 更新ボタン --}}
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.update'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection
