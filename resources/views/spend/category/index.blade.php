@php
    use App\Libs\Icons;
    use Illuminate\Support\Arr;
@endphp

@extends('layouts.app')

@section('title', __('Список категорий'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Мои категории') }}</div>

                    <div class="card-body">

                        {{-- Список категорий --}}
                        <table class="table table-striped admin-table__adapt admin-table__instrument caption-top">
                            <caption>{{ __('Найденные категории') }}</caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} {{ __('Действия') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="align-middle">
                                        <td data-label="#"><b>{{ ($categories->currentpage() - 1) * $categories->perpage() + $loop->index + 1 }}</b></td>
                                        <td class="text-start" data-label="{{ __('Название') }}">{{ $category->title ?? '' }}</td>
                                        <td class="text-end" data-label="{{ __('Действия') }}">
                                            <form method="post" action="{{ route('spend.category.destroy', $category->category_id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <a title="{{ __('Изменить') }}" href="{{ route('spend.category.edit', $category->category_id) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square" style="font-size: 1rem"></i></a>
                                                <button type="submit" title="{{ __('Удалить') }}" onclick="return confirm('{{ __('Вы уверены, что хотите удалить категорию?') }}')" class="btn btn-sm btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас нет категорий') }}</td>
                                    </tr>
                                @endforelse

                                <div>
                                    {{ $categories->links() }}
                                </div>
                            </tbody>
                        </table>

                        {{-- Кнопка добавления категории --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('spend.category.create') }}" class="btn btn-primary">{!! Icons::get(Icons::WALLET) !!} {{ __('Добавить категорию') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
