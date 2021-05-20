@extends('admin.master.master')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-search">Filtro</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('admin.contracts.index') }}">Contratos</a></li>
                </ul>
            </nav>

            <a href="{{ route('admin.contracts.create') }}" class="btn btn-orange icon-file-text ml-1">Criar Contrato</a>
            <button class="btn btn-green icon-search icon-notext ml-1 search_open"></button>
        </div>
    </header>

    @include('admin.contracts.filter')

    <div class="dash_content_app_box">
        <div class="dash_content_app_box_stage">
            <table id="dataTable" class="nowrap hover stripe" width="100" style="width: 100% !important;">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Locador</th>
                    <th>Locatário</th>
                    <th>Negócio</th>
                    <th>Início</th>
                    <th>Vigência</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contracts as $contract)
                <tr>
                    <td><a href="{{ route('admin.contracts.edit', ['contract' => $contract->id]) }}" class="text-orange">{{ $contract->id }}</a></td>
                    <td><a href="{{ route('admin.users.edit', ['user' => $contract->ownerObject->id ]) }}" class="text-orange">{{ $contract->ownerObject->name }}</a></td>
                    <td><a href="{{ route('admin.users.edit', ['user' => $contract->acquirerObject->id ]) }}" class="text-orange">{{ $contract->acquirerObject->name }}</a></td>
                    <td>{{ ($contract->sale == true ? 'Venda' : 'Locação') }}</td>
                    <td>{{ $contract->start_at }}</td>
                    <td>{{ $contract->deadline }} meses</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection