@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-md-2 text-center">
                            <img src="{{ \App\Http\Models\User::getAvatar() }}" alt="" class="profile-avatar">
                        </div>
                        <div class="col-md-10">
                            <p>Name: {{ Auth::user()->name }}</p>
                            <p>Email: {{ Auth::user()->email }}</p>
                            <p>Role: {{ Auth::user()->getRole() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $userFeed = \App\Http\Models\User::getUserFeed();
        foreach ($userFeed as $post) {
        ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= isset($post['story']) ? $post['story'] : '' ?>
                    </div>

                    <div class="panel-body text-center">
                        <?php
                        if(isset($post['attachments'])){
                        foreach ($post['attachments'] as $attachment) {
                        ?>
                        <img src="<?= $attachment['media']['image']['src'] ?>" alt="" class="feed-photo">
                        <?php
                        }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
@endsection
