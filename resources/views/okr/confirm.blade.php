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
                                        {{ Form::open(['url' => route('okr.finish'), 'files' => true]) }}
                                        <!--CSRFトークン-->
                                        {{ Form::token() }}

                                        <!--登録内容確認-->
                                        {{ Form::hidden('selectYear', $year) }}
                                        {{ Form::hidden('raidoQuater', $quater) }}
                                        {{ Form::hidden('selectType', $type) }}
                                        {{ Form::hidden('inputOkr', $okr) }}
                                        {{ Form::hidden('inputObjective', $objective) }}
                                        {{ Form::hidden('selectForOkr', $forOkr) }}

                                        <!--年度-->
                                        <div class="row">
                                            {{ Form::label('selectYear', __('models/okrs.fields.year')) }}
                                            <div class="col-sm-8">{{ $year }}</div>
                                        </div>

                                        <!--四半期区分-->
                                        <div class="row">
                                            {{ Form::label('raidoQuater', __('models/quarters.fields.quater')) }}
                                            <div class="col-sm-8">{{ $quater }}</div>
                                        </div>

                                        <!--登録区分-->
                                        <!--TODO: 登録区分によって、OKR と Objective の show/hidden を制御する-->
                                        <div class="row">
                                            {{ Form::label('selectType', __('common/title.okr.type')) }}
                                            <div class="col-sm-8">{{ $type }}</div>
                                        </div>

                                        <!--OKR-->
                                        <div class="row">
                                            {{ Form::label('inputOkr', __('models/okrs.fields.okr')) }}
                                            <div class="col-sm-8">{{ $okr }}</div>
                                        </div>

                                        <!--Objective-->
                                        <div class="row">
                                            {{ Form::label('inputObjective', __('models/objectives.fields.detail')) }}
                                            <div class="col-sm-8">{{ $objective }}</div>
                                        </div>

                                        <!--Objective に紐付くOKR-->
                                        <div class="row">
                                            {{ Form::label('selectForOkr', __('common/title.objective.forOkr')) }}
                                            <div class="col-sm-8">{{ $forOkr }}</div>
                                        </div>

                                        <!--送信ボタン-->
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                {{ Form::submit(__('common/action.submit'), ['class' => 'btn btn-primary btn-block']) }}
                                            </div>
                                        </div>

                                        {{ Form::close() }}
                                        <!--</form>-->
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
