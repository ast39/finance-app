@php
    use App\Libs\Icons;
    use Illuminate\Support\Arr;
@endphp

@extends('layouts.app')

@section('title', __('Список расходов'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Мои расходы') }}</div>

                    <div class="card-body">

                        {{-- Фильтрация расходов --}}
                        <div class="card-title">
                            <form method="get" action="{{ route('spend.index') }}">
                                <legend>{{ __('Фильтрация') }}</legend>

                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="category" class="form-label">{!! Icons::get(Icons::CATEGORY) !!} {{ __('Категория') }}</label>
                                        <select name="category" id="category" class="form-select form-control">
                                            <option title="{{ __('Все') }}" {{ (request()->category ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Все') }}</option>
                                            @forelse($categories as $category)
                                                <option {{ (request()->category ?? 0) == $category->category_id ? 'selected' : '' }} value="{{ $category->category_id }}">{{ $category->title }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="mb-3 col-6">
                                        <label for="wallet" class="form-label">{!! Icons::get(Icons::WALLET) !!} {{ __('Кошелек') }}</label>
                                        <select name="wallet" id="wallet" class="form-select form-control">
                                            <option title="{{ __('Все') }}" {{ (request()->currency ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Все') }}</option>
                                            @forelse($wallets as $wallet)
                                                <option {{ (request()->wallet ?? 0) == $wallet['wallet_id'] ? 'selected' : '' }} value="{{ $wallet['wallet_id'] }}">{{ $wallet['title'] }} {{ $wallet['currency']['title'] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <button type="submit" class="btn btn-primary">{!! Icons::get(Icons::SEARCH) !!} {{ __('Показать') }}</button>
                                    <a href="{{ route('spend.index') }}" class="btn btn-secondary">{!! Icons::get(Icons::RESET) !!} {{ __('Сброс') }}</a>
                                </div>
                            </form>
                        </div>

                        {{-- Список расходов --}}
                        <table class="table table-striped admin-table__adapt admin-table__instrument caption-top">
                            <caption>{{ __('Найденные расходы') }}</caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дата') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::CATEGORY) !!} {{ __('Категория') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::WALLET) !!} {{ __('Кошелек') }}</th>
                                    <th>{!! Icons::get(Icons::NOTE) !!} {{ __('Комментарий') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Сумма') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} {{ __('Действия') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($spends as $spend)
                                    <tr class="align-middle">
                                        <td data-label="#"><b>{{ ($spends->currentpage() - 1) * $spends->perpage() + $loop->index + 1 }}</b></td>
                                        <td data-label="{{ __('Дата') }}">{{ date('d.m.Y', $spend->created_at) }}</td>
                                        <td class="text-center" data-label="{{ __('Категория') }}">{{ $spend->category->title ?? '' }}</td>
                                        <td class="text-center" data-label="{{ __('Кошелек') }}">{{ $spend->wallet->title ?? ' - ' }}</td>
                                        <td data-label="{{ __('Комментарий') }}">{{ $spend->note ?? '' }}</td>
                                        <td class="text-end" data-label="{{ __('Сумма') }}">{{ number_format($spend->amount ?? 0, 2, '.', ' ') }} {{ $spend->wallet->currency->abbr ?? '' }}</td>
                                        <td class="text-end" data-label="{{ __('Действия') }}">
                                            <form method="post" action="{{ route('spend.destroy', $spend->spend_id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <a title="{{ __('Изменить') }}" href="{{ route('spend.edit', $spend->spend_id) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square" style="font-size: 1rem"></i></a>
                                                <button type="submit" title="{{ __('Удалить') }}" onclick="return confirm('{{ __('Вы уверены, что хотите удалить запись?') }}')" class="btn btn-sm btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас не было расходов') }}</td>
                                    </tr>
                                @endforelse

                                <div>
                                    {{ $spends->links() }}
                                </div>
                            </tbody>
                        </table>

                        {{-- Кнопка добавления расхода --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('spend.create') }}" class="btn btn-primary">{!! Icons::get(Icons::WALLET) !!} {{ __('Добавить расход') }}</a>
                        </div>

                        {{-- Сальдо по расходам --}}
                        <table class="table table-striped mt-3 admin-table__adapt admin-table__instrument caption-top">
                            <caption>{{ __('Сальдо по категориям') }}</caption>
                            <thead>
                                <tr>
                                    <th class="text-start">{!! Icons::get(Icons::CATEGORY) !!} {{ __('Категория') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::TRANSACTIONS) !!} {{ __('Транзакций по категории') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Потрачено в категории') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $payed = ['RUB' => 0, 'USD' => 0, 'EUR' => 0];
                                    $ops   = ['RUB' => 0, 'USD' => 0, 'EUR' => 0];
                                @endphp
                                @forelse($spend_list as $category => $wallet)
                                    @forelse($wallet as $currency => $spends)
                                        <tr class="align-middle">
                                            <td data-label="{{ __('Категория') }}">{{ $category }}</td>
                                            <td data-label="{{ __('Валюта') }}" class="text-center">{{ $currency }}</td>
                                            <td data-label="{{ __('Транзакций по категории') }}" class="text-center">{{ array_sum(array_map(function($e) {return count($e);}, $wallet)) }}</td>
                                            <td data-label="{{ __('Потрачено в категории') }}" class="text-end">{{ number_format(array_sum(array_map(function($e) {return $e['amount'];}, $spends)), 2, '.', ' ') }} {{ $currency }}</td>
                                        </tr>
                                        @php
                                            $payed[$currency] += array_sum(array_map(function($e) {return $e['amount'];}, $spends));
                                            $ops[$currency]   += array_sum(array_map(function($e) {return count($e);}, $wallet));
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Расходов не найдено') }}</td>
                                        </tr>
                                    @endforelse
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Расходов не найдено') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <table class="table table-striped mt-3 admin-table__adapt admin-table__instrument caption-top">
                            <caption>{{ __('Сальдо по валютам') }}</caption>
                            <thead>
                                <tr>
                                    <th class="text-start">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::TRANSACTIONS) !!} {{ __('Кол-во операций') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::CATEGORY) !!} {{ __('Кол-во категорий') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::TRANSACTIONS) !!} {{ __('Сумма операций') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payed as $currency => $amount)
                                    <tr>
                                        <td class="text-start">{{ $currency }}</td>
                                        <td class="text-center">{{ $ops[$currency] }}</td>
                                        <td class="text-center">{{ count($spend_list) }}</td>
                                        <td class="text-end">{{ number_format($payed[$currency], 2, '.', ' ') }} {{ $currency }}</td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
