@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.okr.create') }}</div>
                    <div class="card-body">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div
                                    class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{ Form::open(['url' => route('okr.store'), 'files' => true]) }}
                                        <!--CSRFトークン-->
                                        {{ Form::token() }}
                                        {{ Form::hidden('user_id', $userId) }}

                                        <!--年度-->
                                        <div class="form-group pb-2">
                                            {{ Form::label('selectYear', __('models/okrs.fields.year')) }}
                                            {{ Form::select(
                                                'year',
                                                $years,
                                                'ordinarily',
                                                ['class' => 'form-control', 'id' => 'year'],
                                            ) }}
                                        </div>

                                        <!--四半期区分-->
                                        <div class="form-group row">
                                            <legend class="col-form-label col-md-2 mb-3">
                                                {{ __('models/quarters.fields.quarter') }}</legend>
                                            <div class="col-md-10">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('quarter', $quarters[0]->id, true, ['class' => 'custom-control-input', 'id' => 'radioQuarter1']) }}
                                                    {{ Form::label('raidoQuarter1', $quarterLabels[0], ['class' => 'custom-control-label']) }}
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('quarter', $quarters[1]->id, false, ['class' => 'custom-control-input', 'id' => 'raidoQuarter2']) }}
                                                    {{ Form::label('raidoQuarter2', $quarterLabels[1], ['class' => 'custom-control-label']) }}
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('quarter', $quarters[2]->id, false, ['class' => 'custom-control-input', 'id' => 'raidoQuarter3']) }}
                                                    {{ Form::label('raidoQuarter3', $quarterLabels[2], ['class' => 'custom-control-label']) }}
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('quarter', $quarters[3]->id, false, ['class' => 'custom-control-input', 'id' => 'raidoQuarter4']) }}
                                                    {{ Form::label('raidoQuarter4', $quarterLabels[3], ['class' => 'custom-control-label']) }}
                                                </div>
                                            </div>
                                        </div>

                                        <!--OKR-->
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('okr', __('models/okrs.fields.okr')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('okr', null, ['class' => 'form-control', 'id' => 'okr', 'placeholder' => __('models/okrs.fields.okr'), 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <!--Objective-->
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective1', __('models/objectives.fields.objective') . '1') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('objective1', null, ['class' => 'form-control', 'id' => 'objective1', 'placeholder' => __('models/objectives.fields.objective') . '1', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective2', __('models/objectives.fields.objective') . '2') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('objective2', null, ['class' => 'form-control', 'id' => 'objective2', 'placeholder' => __('models/objectives.fields.objective') . '2', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective3', __('models/objectives.fields.objective') . '3') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('objective3', null, ['class' => 'form-control', 'id' => 'objective3', 'placeholder' => __('models/objectives.fields.objective') . '3', 'rows' => '2']) }}
                                            </div>
                                        </div>
                                        @if (count($errors) > 0)
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <!-- フラッシュメッセージ -->
                                        @if (session('error'))
                                            <div class="error">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        <!--内容確認ボタン-->
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                {{ Form::submit(__('common/action.create'), ['class' => 'btn btn-primary btn-block']) }}
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
