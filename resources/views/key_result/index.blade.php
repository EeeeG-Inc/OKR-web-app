@extends('layouts.app')
@section('title', __('common/title.key_result.index'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card mb-4">
                    @if ($isArchive)
                        <div class="card-header card-header-archive">{{ __('common/title.key_result.archive') }}</div>
                    @else
                        <div class="card-header">{{ __('common/title.key_result.index') }}</div>
                    @endif

                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    @if ($isArchive)
                                        <p>{{ link_to_route('objective.archived_list', __('common/action.back'), ['user_id' => $objective->user->id], ['class' => 'text-decoration-none']) }}</p>
                                    @else
                                        <p>{{ link_to_route('objective.index', __('common/action.back'), ['user_id' => $objective->user->id], ['class' => 'text-decoration-none']) }}</p>
                                    @endif

                                    @include('flash::message')

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/users.fields.name') }}</th>
                                                <th>{{ __('models/objectives.fields.objective') }}</th>
                                                <th>{{ __('models/objectives.fields.year') }}</th>
                                                <th>{{ __('models/quarters.fields.quarter') }}</th>
                                                <th>{{ __('models/objectives.fields.priority') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td width="20%" class="align-middle">
                                                        <img class="border border-secondary rounded-circle mx-2" src="{{ $objective->user->profile_image_path }}" alt="プロフィール画像">
                                                        {{ $objective->user->name }}
                                                    </td>
                                                    <td width="50%" class="align-middle">{!! nl2br($objective->linked_objective) !!}</td>
                                                    <td width="10%" class="align-middle">{{ $objective->year }}</td>
                                                    <td width="10%" class="align-middle">
                                                        {{ App\Enums\Quarter::getDescription($objective->quarter) }}
                                                    </td>
                                                    <td width="10%" class="align-middle">
                                                        {!! App\Enums\Priority::getFontAwesome($objective->priority) !!}
                                                        {{ App\Enums\Priority::getDescription($objective->priority) }}
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/objectives.fields.score') }}</th>
                                                <th>{{ __('models/objectives.fields.remarks') }}</th>
                                                <th>{{ __('models/objectives.fields.impression') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if ($objective->score == 0)
                                                    <td width="10%" class="align-middle text-center score">{{ $objective->score }}</td>
                                                @elseif ($objective->score <= 0.6)
                                                    <td width="10%" class="align-middle bg-danger text-white text-center score">{{ $objective->score }}</td>
                                                @else
                                                    <td width="10%" class="align-middle bg-success text-white text-center score">{{ $objective->score }}</td>
                                                @endif

                                                <td width="45%" class="align-middle">{!! nl2br($objective->linked_remarks) !!}</td>
                                                <td width="45%" class="align-middle">{!! nl2br($objective->linked_impression) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/key-results.fields.key_result') }}</th>
                                                <th>{{ __('models/key-results.fields.remarks') }}</th>
                                                <th>{{ __('models/key-results.fields.impression') }}</th>
                                                <th>{{ __('models/key-results.fields.score') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($keyResults as $keyResult)
                                                <tr>
                                                    <td width="30%" class="align-middle">{!! nl2br($keyResult->linked_keyResult) !!}</td>
                                                    <td width="30%" class="align-middle">{!! nl2br($keyResult->linked_remarks) !!}</td>
                                                    <td width="30%" class="align-middle">{!! nl2br($keyResult->linked_impression) !!}</td>
                                                    <td width="10%" class="align-middle">{{ $keyResult->score }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- コメント欄 --}}
                <div class="card">
                    <div class="card-header">
                        {{ __('common/title.key_result.comment') }}
                    </div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    @if(count($comments) > 0)
                                        @foreach($comments as $comment)
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="20%" class="align-middle">
                                                        <img class="border border-secondary rounded-circle mx-2" src="{{ $comment->user->profile_image_path }}" alt="プロフィール画像">
                                                        {{ $comment->user->name }}
                                                    </td>
                                                    <td width="60c%" class="align-middle">{!! nl2br($comment->linked_comment) !!}</td>
                                                    <td width="5%" class="align-middle">
                                                        @if (!$CommentLikeUser->isLikedBy($comment,Auth::id()))
                                                        <span class="likes">
                                                            <i class="fas fa-music like-toggle" data-comment-id="{{ $comment->id }}" data-like-remove=false id="like"></i>
                                                            <span class="like-counter">{{$CommentLikeUser->likeCount($comment)}}</span>
                                                        </span>
                                                      @else
                                                        <span class="likes">
                                                            <i class="fas fa-music heart like-toggle liked" data-comment-id="{{ $comment->id }}" data-like-remove=ture id="like"></i>
                                                            <span class="like-counter">{{$CommentLikeUser->likeCount($comment)}}</span>
                                                        </span>
                                                      @endif
                                                    </td>
                                                    <td width="10%" class="align-middle">{{ $comment->created_at }}</td>
                                                    <td width="5%" class="align-middle">
                                                        @if($comment->user_id === Auth::id())
                                                            {{ Form::open(['route' => ['key_result.destroy_comment', [$comment->id, $objective->id]], 'method' => 'delete', 'class' => 'd-inline-block']) }}
                                                            {{ Form::submit(__('common/action.delete'), [
                                                                'class' => 'btn btn-danger',
                                                                'onclick' => "return confirm('" . __('common/message.key_result.delete_comment_confirm')  . "')"
                                                            ])}}
                                                            {{ Form::close() }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        @endforeach
                                    @else
                                        <p>まだコメントがありません</p>
                                    @endif

                                    <div class="form">
                                        {{ Form::open(['route' => ['key_result.comment'], 'method' => 'post']) }}
                                        {{ Form::hidden('objective_id', $objective->id) }}

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('comment', __('models/comments.fields.comment')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'objective', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.comment'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {

            let likeOperation = $('.like-toggle'); //like-toggleのついたiタグを取得し代入。
            let likeCommentId;
            let detail;
            let route;
            let count;
            let likeRemoveChange;

            likeOperation.on('click', function () { //onはイベントハンドラー
                let $this = $(this); //this=イベントの発火した要素＝iタグを代入
                likeCommentId = $this.data('comment-id'); //iタグに仕込んだdata-comment-idの値を取得
                userId = "{{Auth::user()->id}}";//ユーザーIdを取得

                 //いいねの追加か取り消し化を判別
                var likeId = document.getElementById("like");
                var likeRemove = likeId.getAttribute("data-like-remove");
                if(likeRemove == 'true'){
                    route = '{{ route('remove') }}';
                    count = -1;
                    likeRemoveChange = false;
                }else{
                    route= '{{ route('like') }}';
                    count = 1;
                    likeRemoveChange = true;
                }

                //ajax処理スタート
                var jqXHR = $.ajax({
                    headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
                    url: route, //通信先アドレスで、このURLをあとでルートで設定します
                    method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
                    data: { //サーバーに送信するデータ
                        'comment_id': likeCommentId,//いいねされた投稿のid
                        'user_id' : userId
                    },
                })
                //通信成功した時の処理
                .done(function (data) {
                    $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
                    var likeCounter = Number($('.like-counter').text());
                    $('.like-counter').text(likeCounter + count);//いいねのカウントを追加または減らす。
                    likeId.setAttribute("data-like-remove",likeRemoveChange);//data-like-removeへ今回の判定をセット
                })
                //通信失敗した時の処理
                .fail(function () {
                    alert('失敗してるで');

                });
            });
        });
    </script>

@endsection
