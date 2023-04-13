@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новая категория расхода'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить категорию расхода') }}</div>
                    <div class="card-body">

                        {{--Форма добавления категории --}}
                        <form method="post" action="{{ route('spend.category.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="title" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="{{ __('Новая категория') }}" value="{{ old('title') }}" aria-describedby="titleHelp">
                                <div id="titleHelp" class="form-text">{{ __('Название категории расхода') }}</div>
                                @error('title')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ route('spend.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!} {{ __('Назад') }}</a>
                                    <button type="submit" class="btn btn-primary">{!! Icons::get(Icons::CREATE) !!} {{ __('Добавить') }}</button>
                                </div>
                            </div>
                        </form>

                        {{-- Ошибки если есть --}}
                        @if(count($errors) > 0)
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
