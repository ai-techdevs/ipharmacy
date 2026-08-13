@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Review & Edit Synced CDC Post
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.temp-cdc-posts.index') }}">Synced CDC Posts</a></li>
                        <li class="breadcrumb-item active">Review</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <form action="{{ route('admin.temp-cdc-posts.update',  $post->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <!-- Title Field -->
                        <div class="form-group col-sm-12">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ $post->title ?? old('title') }}" class="form-control" id="title" required>
                            @error('title')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Author Field -->
                        <div class="form-group col-sm-6">
                            <label for="author">Author<span class="text-danger">*</span></label>
                            <input type="text" name="author" value="{{ $post->author ?? old('author', 'CDC') }}" class="form-control" id="author" required>
                            @error('author')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status Field -->
                        <div class="form-group col-sm-6">
                            <label for="status">Status (Publish to Main Blog?)</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="0" @if($post->status == 0) selected @endif>Disabled (Do not publish)</option>
                                <option value="1" @if($post->status == 1) selected @endif>Active (Publish/Approve)</option>
                            </select>
                            @error('status')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Source URL info (Read-only) -->
                        <div class="form-group col-sm-12">
                            <label>CDC Source URL</label>
                            <div class="form-control-plaintext">
                                <a href="{{ $post->source_url }}" target="_blank">{{ $post->source_url }}</a>
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="form-group col-sm-12">
                            <label for="description">Description (HTML Content)<span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control tinymce-editor" id="description" rows="15">{{ $post->description ?? old('description') }}</textarea>
                            @error('description')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Save & Sync</button>
                    <a href="{{ route('admin.temp-cdc-posts.index') }}" class="btn btn-default"> Cancel </a>
                </div>
            </form>
        </div>
    </div>
@endsection
