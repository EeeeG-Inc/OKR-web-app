@extends('layouts.app')
@section('title', __('common/title.objective.edit'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.objective.edit') }}</div>
                    <div class="card-body">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div
                                    class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{ Form::open(['route' => ['objective.update', $objective->id], 'method' => 'put']) }}
                                        {{ Form::token() }}
                                        {{ Form::hidden('user_id', $user->id) }}

                                        {{--年度--}}
                                        <div class="form-group pb-2">
                                            {{ Form::label('selectYear', __('models/objectives.fields.year')) }}
                                            {{ Form::select('year', $years, $year, ['class' => 'form-control', 'id' => 'year']) }}
                                        </div>

                                        {{--四半期区分--}}
                                        <div class="form-group row">
                                            <legend class="col-form-label col-md-2 mb-3">
                                                {{ __('models/quarters.fields.quarter') }}</legend>
                                            <div class="col-md-10">
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id',  App\Enums\Quarter::FULL_YEAR_ID, $quarterChecked[0], ['id' => 'radioQuarter0']) }}
                                                    {{ Form::label('raidoQuarter1', $quarterLabels[0]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[0]->id, $quarterChecked[1], ['id' => 'raidoQuarter1']) }}
                                                    {{ Form::label('raidoQuarter2', $quarterLabels[1]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[1]->id, $quarterChecked[2], ['id' => 'raidoQuarter2']) }}
                                                    {{ Form::label('raidoQuarter3', $quarterLabels[2]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[2]->id, $quarterChecked[3], ['id' => 'raidoQuarter3']) }}
                                                    {{ Form::label('raidoQuarter4', $quarterLabels[3]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[3]->id, $quarterChecked[4], ['id' => 'raidoQuarter4']) }}
                                                    {{ Form::label('raidoQuarter4', $quarterLabels[4]) }}
                                                </div>
                                            </div>
                                        </div>

                                        {{--OKR--}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective', __('models/objectives.fields.objective')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('objective', $objective->objective, ['class' => 'form-control', 'id' => 'objective', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        {{--KeyResult--}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result1', __('models/key-results.fields.key_result') . '1') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result1', $keyResult1->key_result, ['class' => 'form-control', 'id' => 'key_result1', 'rows' => '2']) }}
                                                {{ Form::hidden('key_result1_id', $keyResult1->id) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result2', __('models/key-results.fields.key_result') . '2') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result2', $keyResult2->key_result ?? null, ['class' => 'form-control', 'id' => 'key_result2', 'rows' => '2']) }}
                                                {{ Form::hidden('key_result2_id', $keyResult2->id ?? null) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result3', __('models/key-results.fields.key_result') . '3') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result3', $keyResult3->key_result ?? null, ['class' => 'form-control', 'id' => 'key_result3', 'rows' => '2']) }}
                                                {{ Form::hidden('key_result3_id', $keyResult3->id ?? null) }}
                                            </div>
                                        </div>

                                        {{--フラッシュメッセージ--}}
                                        @include('flash::message')

                                        {{--内容確認ボタン--}}
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.update'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
                                            </div>
                                        </div>

                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
