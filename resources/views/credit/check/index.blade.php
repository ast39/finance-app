@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('История проверки кредитов'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Мои проверки кредитов') }}</div>

                    <div class="card-body">

                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-start">{!! Icons::get(Icons::TITLE) !!} Название</th>
                                    <th class="text-center">{!! Icons::get(Icons::CURRENCY) !!} Валюта</th>
                                    <th class="text-center">{!! Icons::get(Icons::BALANCE) !!} Сумма</th>
                                    <th class="text-center">{!! Icons::get(Icons::PERCENT) !!} Процент</th>
                                    <th class="text-center">{!! Icons::get(Icons::PERIOD) !!} Срок</th>
                                    <th class="text-center">{!! Icons::get(Icons::BALANCE_START) !!} Платеж</th>
                                    <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($credits as $credit)
                                    <tr>
                                        <td data-label="#"><b>{{ $loop->iteration }}</b></td>
                                        <td data-label="Название" class="text-start"><a class="text-decoration-none text-primary" href="{{ route('credit.check.show', $credit->calc_id) }}">{{ $credit->title ?? '' }}</a></td>
                                        <td data-label="Валюта" class="text-center">{{ $credit->currency ?? '' }}</td>
                                        <td data-label="Сумма" class="text-center">{{ $credit->amount ?? '' }}</td>
                                        <td data-label="Процент" class="text-center">{{ $credit->percent ?? '' }}%</td>
                                        <td data-label="Срок" class="text-center">{{ $credit->period ?? '' }} (в месяцах)</td>
                                        <td data-label="Платеж" class="text-center">{{ $credit->payment ?? '' }}</td>
                                        <td data-label="Действия" class="text-end">
                                            <form method="post" action="{{ route('credit.check.destroy', $credit->calc_id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <a title="Открыть" href="{{ route('credit.check.show', $credit->calc_id) }}" class="btn btn-sm btn-primary me-1"><i class="bi bi-text-center" style="font-size: 1rem"></i></a>
                                                <button type="submit" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить проверку?')" class="btn btn-sm btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас нет истории проверок') }}</div>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('credit.check.create') }}" class="btn btn-primary">{!! Icons::get(Icons::CREATE) !!} {{ __('Новая проверка') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
