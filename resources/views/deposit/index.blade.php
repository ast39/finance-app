@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Мои вклады'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ __('Мои вклады') }}</div>

                    <div class="card-body">

                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{!! Icons::get(Icons::TITLE) !!} Название</th>
                                <th>{!! Icons::get(Icons::BANK) !!} Банк</th>
                                <th class="text-center">{!! Icons::get(Icons::PERCENT) !!} Процент</th>
                                <th class="text-end">{!! Icons::get(Icons::PROFIT_UP) !!} Заработок</th>
                                <th class="text-end">{!! Icons::get(Icons::BALANCE) !!} Баланс</th>
                                <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($deposits as $deposit)
                                <tr>
                                    <td data-label="#"><b>{{ $loop->iteration }}</b></td>
                                    <td data-label="Название"><a class="text-decoration-none text-primary" href="{{ route('deposit.show', $deposit->deposit->deposit_id) }}">{{ $deposit->deposit->title ?? '' }}</a></td>
                                    <td data-label="Банк">{{ $deposit->deposit->depositor ?? '' }}</td>
                                    <td data-label="Процент" class="text-center">{{ $deposit->deposit->percent ?? 0 }}%</td>
                                    <td data-label="Заработок" class="text-end">{{ number_format($deposit->profit, 2, '.', ' ') }} {{ __('р.') }}</td>
                                    <td data-label="Баланс" class="text-end">{{ number_format($deposit->to_withdraw, 2, '.', ' ') }} {{ __('р.') }}</td>
                                    <td data-label="Действия" class="text-end">
                                        <form method="post" action="{{ route('manage.deposit.destroy', $deposit->deposit->deposit_id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <a title="Открыть" href="{{ route('manage.deposit.show', $deposit->deposit->deposit_id) }}" class="btn btn-primary"><i class="bi bi-text-center" style="font-size: 1rem"></i></a>
                                            <a title="Изменить" href="{{ route('manage.deposit.edit', $deposit->deposit->deposit_id) }}" class="btn btn-warning"><i class="bi bi-pencil-square" style="font-size: 1rem"></i></a>
                                            <button type="submit" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить вклад?')" class="btn btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас нет текущих вкладов') }}</div>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('deposit.create') }}" class="btn btn-primary">Добавить вклад</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
