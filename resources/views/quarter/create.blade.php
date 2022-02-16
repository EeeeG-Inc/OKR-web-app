@extends('layouts.app')
@section('title', __('common/title.quarter.create'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.quarter.create') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    <p>{{ link_to_route('dashboard.index', __('common/action.back'), null, ['class' => 'text-decoration-none']) }}</p>

                                    @include('flash::message')

                                    <div class="form">
                                        {{ Form::open(['url' => route('quarter.store')]) }}
                                        {{ Form::token() }}

                                        <div class="form-group pb-2">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('1q_from', __('models/quarters.create'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('1q_from', $from, 4, ['class' => 'form-control', 'id' => '1q_from']) }}
                                            </div>
                                        </div>

                                        {{ Form::hidden('1q_to', 6, ['id' => '1q_to']) }}
                                        {{ Form::hidden('2q_from', 7, ['id' => '2q_from']) }}
                                        {{ Form::hidden('2q_to', 9, ['id' => '2q_to']) }}
                                        {{ Form::hidden('3q_from', 10, ['id' => '3q_from']) }}
                                        {{ Form::hidden('3q_to', 12, ['id' => '3q_to']) }}
                                        {{ Form::hidden('4q_from', 1, ['id' => '4q_from']) }}
                                        {{ Form::hidden('4q_to', 3, ['id' => '4q_to']) }}

                                        {{--内容確認ボタン--}}
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.create'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
                                            </div>
                                        </div>

                                        {{ Form::close() }}
                                    </div>
                                </div>

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/quarters.fields.quarter') }}</th>
                                            <th>{{ __('models/quarters.fields.from') }}</th>
                                            <th>{{ __('models/quarters.fields.to') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">{{ __('models/quarters.quarter.first_quarter') }}</td>
                                            <td class="align-middle" id="preview_1q_from">4</td>
                                            <td class="align-middle" id="preview_1q_to">6</td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">{{ __('models/quarters.quarter.second_quarter') }}</td>
                                            <td class="align-middle" id="preview_2q_from">7</td>
                                            <td class="align-middle" id="preview_2q_to">9</td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">{{ __('models/quarters.quarter.third_quarter') }}</td>
                                            <td class="align-middle" id="preview_3q_from">10</td>
                                            <td class="align-middle" id="preview_3q_to">12</td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">{{ __('models/quarters.quarter.fourth_quarter') }}</td>
                                            <td class="align-middle" id="preview_4q_from">1</td>
                                            <td class="align-middle" id="preview_4q_to">3</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                var checkMonth = function(month) {
                    if (month > 12) {
                        return month - 12
                    }
                    return month
                }

                $('#1q_from').change(function() {
                    from1q = Number($('#1q_from').val());
                    to1q = checkMonth(from1q + 2)
                    from2q = checkMonth(to1q + 1)
                    to2q = checkMonth(from2q + 2)
                    from3q = checkMonth(to2q + 1)
                    to3q = checkMonth(from3q + 2)
                    from4q = checkMonth(to3q + 1)
                    to4q = checkMonth(from4q + 2)

                    $('#1q_to').val(to1q)
                    $('#2q_from').val(from2q)
                    $('#2q_to').val(to2q)
                    $('#3q_from').val(from3q)
                    $('#3q_to').val(to3q)
                    $('#4q_from').val(from4q)
                    $('#4q_to').val(to4q)

                    $('#preview_1q_from').text(from1q)
                    $('#preview_1q_to').text(to1q)
                    $('#preview_2q_from').text(from2q)
                    $('#preview_2q_to').text(to2q)
                    $('#preview_3q_from').text(from3q)
                    $('#preview_3q_to').text(to3q)
                    $('#preview_4q_from').text(from4q)
                    $('#preview_4q_to').text(to4q)
                });
            })
        </script>
    @endpush
@endsection
