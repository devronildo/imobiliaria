@extends('admin.master.master')

@section('content')
    <div style="flex-basis: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Dashboard</h2>
            </header>

            <div class="dash_content_app_box">
                <section class="app_dash_home_stats">
                    <article class="control radius">
                        <h4 class="icon-users">Clientes</h4>
                        <p><b>Locadores:</b> {{ $lessors }}</p>
                        <p><b>Locatários:</b> {{ $lessees }}</p>
                        <p><b>Time:</b> {{ $team }}</p>
                    </article>

                    <article class="blog radius">
                        <h4 class="icon-home">Imóveis</h4>
                        <p><b>Disponíveis:</b> {{ $propertiesAvailable }}</p>
                        <p><b>Locados:</b> {{ $propertiesUnavailable }}</p>
                        <p><b>Total:</b> {{ $propertiesTotal }}</p>
                    </article>

                    <article class="users radius">
                        <h4 class="icon-file-text">Contratos</h4>
                        <p><b>Pendentes:</b> {{ $contractsPendent }}</p>
                        <p><b>Ativos:</b> {{ $contractsActive }}</p>
                        <p><b>Cancelados:</b> {{ $contractsCanceled }}</p>
                        <p><b>Total:</b> {{ $contractsTotal }}</p>
                    </article>
                </section>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Últimos Contratos Cadastrados</h2>
            </header>

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

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Últimos Imóveis Cadastrados</h2>
            </header>

            <div class="dash_content_app_box">
                <div class="dash_content_app_box_stage">
                    <div class="realty_list">
                        @if(!empty($properties))
                            @foreach($properties as $property)
                                <div class="realty_list_item mb-2">
                                    <div class="realty_list_item_actions_stats">
                                        <img src="{{ $property->cover() }}" alt="">
                                        <ul>
                                            @if($property->sale == true && !empty($property->sale_price))
                                                <li>Venda: R$ {{ $property->sale_price }}</li>
                                            @endif

                                            @if($property->rent == true && !empty($property->rent_price))
                                                <li>Aluguel: R$ {{ $property->rent_price }}</li>
                                            @endif
                                        </ul>
                                    </div>

                                    <div class="realty_list_item_content">
                                        <h4>#{{ $property->id }} {{ $property->category }} - {{ $property->type }}</h4>

                                        <div class="realty_list_item_card">
                                            <div class="realty_list_item_card_image">
                                                <span class="icon-realty-location"></span>
                                            </div>
                                            <div class="realty_list_item_card_content">
                                                <span class="realty_list_item_description_title">Bairro:</span>
                                                <span class="realty_list_item_description_content">{{ $property->neighborhood }}</span>
                                            </div>
                                        </div>

                                        <div class="realty_list_item_card">
                                            <div class="realty_list_item_card_image">
                                                <span class="icon-realty-util-area"></span>
                                            </div>
                                            <div class="realty_list_item_card_content">
                                                <span class="realty_list_item_description_title">Área Útil:</span>
                                                <span class="realty_list_item_description_content">{{ $property->area_util }}m&sup2;</span>
                                            </div>
                                        </div>

                                        <div class="realty_list_item_card">
                                            <div class="realty_list_item_card_image">
                                                <span class="icon-realty-bed"></span>
                                            </div>
                                            <div class="realty_list_item_card_content">
                                                <span class="realty_list_item_description_title">Domitórios:</span>
                                                <span class="realty_list_item_description_content">{{ $property->bedrooms + $property->suites }} Quartos<br><span>Sendo {{ $property->suites }} suítes</span></span>
                                            </div>
                                        </div>

                                        <div class="realty_list_item_card">
                                            <div class="realty_list_item_card_image">
                                                <span class="icon-realty-garage"></span>
                                            </div>
                                            <div class="realty_list_item_card_content">
                                                <span class="realty_list_item_description_title">Garagem:</span>
                                                <span class="realty_list_item_description_content">{{ $property->garage + $property->garage_covered }} Vagas<br><span>Sendo {{ $property->garage_covered }} cobertas</span></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="realty_list_item_actions">
                                        <ul>
                                            <li class="icon-eye">{{ $property->views }} Visualizações</li>
                                        </ul>
                                        <div>
                                            @if($property->sale == true && !empty($property->sale_price))
                                                <a href="{{ route('web.buyProperty', ['property' => $property->slug]) }}"
                                                   class="btn btn-blue icon-eye" target="_blank">Visualizar
                                                    Imóvel (Compra)</a>
                                            @endif

                                            @if($property->rent == true && !empty($property->rent_price))
                                                <a href="{{ route('web.rentProperty', ['property' => $property->slug]) }}"
                                                   class="btn btn-blue icon-eye" target="_blank">Visualizar
                                                    Imóvel (Locação)</a>
                                            @endif
                                            <a href="{{ route('admin.properties.edit', ['property' => $property->id]) }}" class="btn btn-green icon-pencil-square-o">Editar
                                                Imóvel</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-content">Não foram encontrados registros!</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection