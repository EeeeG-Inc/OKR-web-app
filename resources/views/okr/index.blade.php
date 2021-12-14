@extends('layouts.app')
@section('title', __('common/title.okr.index'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.okr.index') }}</div>
                <div class="card-body">
                    <div class="pt-4 bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                <div class="form" style="text-align: center">
                                    <!-- フラッシュメッセージ -->
                                    @if (session('success'))
                                        <div class="success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    {{ Form::open(['url' => route('okr.search'), 'files' => true]) }}
                                    {{-- CSRF トークン --}}
                                    {{ Form::token() }}
                                    {{-- OKR --}}
                                    {{ Form::label('okr', __('models/okrs.fields.okr')) }}
                                    {{ Form::text('okr', null, ['placeholder' => __('models/okrs.fields.okr')]) }}
                                    @if ($errors->has('okr'))
                                        <p>{{$errors->first('okr')}}</p>
                                    @endif
                                    {{-- 送信ボタン --}}
                                    {{ Form::submit(__('common/action.search'), ['class'=>'px-2 py-1 bg-green-400 text-white font-semibold rounded hover:bg-green-500;']) }}
                                    {{ Form::close() }}
                                    <p class="d-flex justify-content-center">
                                    {{ $okrs->links() }}
                                    </p>
                                </div>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>YEAR</th>
                                            <th>OKR</th>
                                            <th>UserName</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($okrs as $okr)
                                            <tr>
                                                <td>{{ $okr->year }}</td>
                                                <td>{{ $okr->okr }}</td>
                                                <td>{{ $okr->users->name }}</td>
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
