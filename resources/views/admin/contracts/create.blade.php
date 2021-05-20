@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-search">Cadastrar Novo Contrato</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.contracts.index') }}">Contratos</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.contracts.create') }}" class="text-orange">Cadastrar Contrato</a></li>
                    </ul>
                </nav>

                <button class="btn btn-green icon-search icon-notext ml-1 search_open"></button>
            </div>
        </header>

        @include('admin.contracts.filter')

        <div class="dash_content_app_box">

            @if($errors->all())
                @foreach($errors->all() as $error)
                    @message(['color' => 'orange'])
                    <p class="icon-asterisk">{{ $error }}</p>
                    @endmessage
                @endforeach
            @endif

            <div class="nav">
                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#parts" class="nav_tabs_item_link active">Das Partes</a>
                    </li>
                    <li class="nav_tabs_item">
                        <a href="#terms" class="nav_tabs_item_link">Termos</a>
                    </li>
                </ul>

                <div class="nav_tabs_content">
                    <div id="parts">
                        <form action="{{ route('admin.contracts.store') }}" method="post" class="app_form">
                            @csrf

                            <input type="hidden" name="owner_spouse_persist" value="{{ old('owner_spouse') }}">
                            <input type="hidden" name="owner_company_persist" value="{{ old('owner_company') }}">
                            <input type="hidden" name="acquirer_spouse_persist" value="{{ old('acquirer_spouse') }}">
                            <input type="hidden" name="acquirer_company_persist" value="{{ old('acquirer_company') }}">
                            <input type="hidden" name="property_persist" value="{{ old('property') }}">

                            <div class="label_gc">
                                <span class="legend">Finalidade:</span>
                                <label class="label">
                                    <input type="checkbox" name="sale"
                                            {{ (old('sale') == 'on' ? 'checked' : '') }}><span>Venda</span>
                                </label>

                                <label class="label">
                                    <input type="checkbox" name="rent"
                                            {{ (old('rent') == 'on' ? 'checked' : '') }}><span>Locação</span>
                                </label>
                            </div>

                            <label class="label">
                                <span class="legend">Status do Contrato:</span>
                                <select name="status" class="select2">
                                    <option value="pending" {{ (old('status') === 'pending' ? 'selected' : '') }}>Pendente</option>
                                    <option value="active" {{ (old('status') === 'active' ? 'selected' : '') }}>Ativo</option>
                                    <option value="canceled" {{ (old('status') === 'canceled' ? 'selected' : '') }}>Cancelado</option>
                                </select>
                            </label>

                            <div class="app_collapse">
                                <div class="app_collapse_header mt-2 collapse">
                                    <h3>Proprietário</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Proprietário:</span>
                                            <select class="select2" name="owner"
                                                    data-action="{{ route('admin.contracts.getDataOwner') }}">
                                                <option value="">Informe um Cliente</option>
                                                @foreach($lessors->get() as $lessor)
                                                    <option value="{{ $lessor->id }}" {{ (old('owner') == $lessor->id ? 'selected' : '') }}>{{ $lessor->name }}
                                                        ({{ $lessor->document }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Conjuge Proprietário:</span>
                                            <select class="select2" name="owner_spouse">
                                                <option value="" selected>Não informado</option>
                                            </select>
                                        </label>
                                    </div>

                                    <label class="label">
                                        <span class="legend">Empresa:</span>
                                        <select class="select2" name="owner_company">
                                            <option value="" selected>Não informado</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="app_collapse">
                                <div class="app_collapse_header mt-2 collapse">
                                    <h3>Adquirente</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Adquirente:</span>
                                            <select name="acquirer" class="select2"
                                                    data-action="{{ route('admin.contracts.getDataAcquirer') }}">
                                                <option value="" selected>Informe um Cliente</option>
                                                @foreach($lessees->get() as $lessee)
                                                    <option value="{{ $lessee->id }}" {{ (old('acquirer') == $lessee->id ? 'selected' : '') }}>{{ $lessee->name }}
                                                        ({{ $lessee->document }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Conjuge Adquirente:</span>
                                            <select class="select2" name="acquirer_spouse">
                                                <option value="" selected>Não informado</option>
                                            </select>
                                        </label>
                                    </div>

                                    <label class="label">
                                        <span class="legend">Empresa:</span>
                                        <select name="acquirer_company" class="select2">
                                            <option value="" selected>Não informado</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="app_collapse">
                                <div class="app_collapse_header mt-2 collapse">
                                    <h3>Parâmetros do Contrato</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <label class="label">
                                        <span class="legend">Imóvel:</span>
                                        <select name="property" class="select2"
                                                data-action="{{ route('admin.contracts.getDataProperty') }}">
                                            <option value="">Não informado</option>
                                        </select>
                                    </label>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Valor de Venda:</span>
                                            <input type="tel" name="sale_price" class="mask-money"
                                                   placeholder="Valor de Venda" {{ (old('sale') != 'on' ? 'disabled' : '') }}/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Valor de Locação:</span>
                                            <input type="text" name="rent_price" class="mask-money"
                                                   placeholder="Valor de Locação" {{ (old('rent') != 'on' ? 'disabled' : '') }}/>
                                        </label>
                                    </div>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">IPTU:</span>
                                            <input type="text" name="tribute" class="mask-money" placeholder="IPTU"
                                                   value=""/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Condomínio:</span>
                                            <input type="text" name="condominium" class="mask-money"
                                                   placeholder="Valor do Condomínio" value=""/>
                                        </label>
                                    </div>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Dia de Vencimento:</span>
                                            <select name="due_date" class="select2">
                                                <option value="1" {{ (old('due_date') == 1 ? 'selected' : '') }}>1º
                                                </option>
                                                <option value="2" {{ (old('due_date') == 2 ? 'selected' : '') }}>2/mês
                                                </option>
                                                <option value="3" {{ (old('due_date') == 3 ? 'selected' : '') }}>3/mês
                                                </option>
                                                <option value="4" {{ (old('due_date') == 4 ? 'selected' : '') }}>4/mês
                                                </option>
                                                <option value="5" {{ (old('due_date') == 5 ? 'selected' : '') }}>5/mês
                                                </option>
                                                <option value="6" {{ (old('due_date') == 6 ? 'selected' : '') }}>6/mês
                                                </option>
                                                <option value="7" {{ (old('due_date') == 7 ? 'selected' : '') }}>7/mês
                                                </option>
                                                <option value="8" {{ (old('due_date') == 8 ? 'selected' : '') }}>8/mês
                                                </option>
                                                <option value="9" {{ (old('due_date') == 9 ? 'selected' : '') }}>9/mês
                                                </option>
                                                <option value="10" {{ (old('due_date') == 10 ? 'selected' : '') }}>
                                                    10/mês
                                                </option>
                                                <option value="11" {{ (old('due_date') == 11 ? 'selected' : '') }}>
                                                    11/mês
                                                </option>
                                                <option value="12" {{ (old('due_date') == 12 ? 'selected' : '') }}>
                                                    12/mês
                                                </option>
                                                <option value="13" {{ (old('due_date') == 13 ? 'selected' : '') }}>
                                                    13/mês
                                                </option>
                                                <option value="14" {{ (old('due_date') == 14 ? 'selected' : '') }}>
                                                    14/mês
                                                </option>
                                                <option value="15" {{ (old('due_date') == 15 ? 'selected' : '') }}>
                                                    15/mês
                                                </option>
                                                <option value="16" {{ (old('due_date') == 16 ? 'selected' : '') }}>
                                                    16/mês
                                                </option>
                                                <option value="17" {{ (old('due_date') == 17 ? 'selected' : '') }}>
                                                    17/mês
                                                </option>
                                                <option value="18" {{ (old('due_date') == 18 ? 'selected' : '') }}>
                                                    18/mês
                                                </option>
                                                <option value="19" {{ (old('due_date') == 19 ? 'selected' : '') }}>
                                                    19/mês
                                                </option>
                                                <option value="20" {{ (old('due_date') == 20 ? 'selected' : '') }}>
                                                    20/mês
                                                </option>
                                                <option value="21" {{ (old('due_date') == 21 ? 'selected' : '') }}>
                                                    21/mês
                                                </option>
                                                <option value="22" {{ (old('due_date') == 22 ? 'selected' : '') }}>
                                                    22/mês
                                                </option>
                                                <option value="23" {{ (old('due_date') == 23 ? 'selected' : '') }}>
                                                    23/mês
                                                </option>
                                                <option value="24" {{ (old('due_date') == 24 ? 'selected' : '') }}>
                                                    24/mês
                                                </option>
                                                <option value="25" {{ (old('due_date') == 25 ? 'selected' : '') }}>
                                                    25/mês
                                                </option>
                                                <option value="26" {{ (old('due_date') == 26 ? 'selected' : '') }}>
                                                    26/mês
                                                </option>
                                                <option value="27" {{ (old('due_date') == 27 ? 'selected' : '') }}>
                                                    27/mês
                                                </option>
                                                <option value="28" {{ (old('due_date') == 28 ? 'selected' : '') }}>
                                                    28/mês
                                                </option>
                                            </select>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Prazo do Contrato (Em meses)</span>
                                            <select name="deadline" class="select2">
                                                <option value="12" {{ (old('deadline') == 12 ? 'selected' : '') }}>12
                                                    meses
                                                </option>
                                                <option value="24" {{ (old('deadline') == 24 ? 'selected' : '') }}>24
                                                    meses
                                                </option>
                                                <option value="36" {{ (old('deadline') == 36 ? 'selected' : '') }}>36
                                                    meses
                                                </option>
                                                <option value="48" {{ (old('deadline') == 48 ? 'selected' : '') }}>48
                                                    meses
                                                </option>
                                            </select>
                                        </label>
                                    </div>

                                    <label class="label">
                                        <span class="legend">Data de Início:</span>
                                        <input type="tel" name="start_at" class="mask-date" placeholder="Data de Início"
                                               value="{{ old('start_at') }}"/>
                                    </label>
                                </div>
                            </div>

                            <div class="text-right mt-2">
                                <button class="btn btn-large btn-green icon-check-square-o">Salvar Contrato</button>
                            </div>
                        </form>
                    </div>

                    <div id="terms" class="d-none">
                        <h3 class="mb-2">Termos</h3>

                        <textarea name="terms" cols="30" rows="10" class="mce"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>

        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function setFieldOwner(response) {
                // Spouse
                $('select[name="owner_spouse"]').html('');
                if (response.spouse) {
                    $('select[name="owner_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'Não informar'
                    }));

                    $('select[name="owner_spouse"]').append($('<option>', {
                        value: 1,
                        text: response.spouse.spouse_name + '(' + response.spouse.spouse_document + ')',
                        selected: ($('input[name="owner_spouse_persist"]').val() != 0 ? 'selected' : false)
                    }));
                } else {
                    $('select[name="owner_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'Não informado'
                    }));
                }

                // Companies
                $('select[name="owner_company"]').html('');
                if (response.companies != null && response.companies.length) {
                    $('select[name="owner_company"]').append($('<option>', {
                        value: 0,
                        text: 'Não informar'
                    }));

                    $.each(response.companies, function (key, value) {
                        $('select[name="owner_company"]').append($('<option>', {
                            value: value.id,
                            text: value.alias_name + '(' + value.document_company + ')',
                            selected: ($('input[name="owner_company_persist"]').val() != 0 && $('input[name="owner_company_persist"]').val() == value.id ? 'selected' : false)
                        }));
                    });

                } else {
                    $('select[name="owner_company"]').append($('<option>', {
                        value: 0,
                        text: 'Não informado'
                    }));
                }

                // Properties
                $('select[name="property"]').html('');
                if (response.properties != null && response.properties.length) {
                    $('select[name="property"]').append($('<option>', {
                        value: 0,
                        text: 'Não informar'
                    }));

                    $.each(response.properties, function (key, value) {
                        $('select[name="property"]').append($('<option>', {
                            value: value.id,
                            text: value.description,
                            selected: ($('input[name="property_persist"]').val() != 0 && $('input[name="property_persist"]').val() == value.id ? 'selected' : false)
                        }));
                    });

                } else {
                    $('select[name="property"]').append($('<option>', {
                        value: 0,
                        text: 'Não informado'
                    }));
                }
            }

            function setFieldAcquirer(response) {
                // Spouse
                $('select[name="acquirer_spouse"]').html('');
                if (response.spouse) {
                    $('select[name="acquirer_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'Não informar'
                    }));

                    $('select[name="acquirer_spouse"]').append($('<option>', {
                        value: 1,
                        text: response.spouse.spouse_name + '(' + response.spouse.spouse_document + ')',
                        selected: ($('input[name="acquirer_spouse_persist"]').val() != 0 ? 'selected' : false)
                    }));
                } else {
                    $('select[name="acquirer_spouse"]').append($('<option>', {
                        value: 0,
                        text: 'Não informado'
                    }));
                }

                // Companies
                $('select[name="acquirer_company"]').html('');
                if (response.companies != null && response.companies.length) {
                    $('select[name="acquirer_company"]').append($('<option>', {
                        value: 0,
                        text: 'Não informar'
                    }));

                    $.each(response.companies, function (key, value) {
                        $('select[name="acquirer_company"]').append($('<option>', {
                            value: value.id,
                            text: value.alias_name + '(' + value.document_company + ')',
                            selected: ($('input[name="acquirer_company_persist"]').val() != 0 && $('input[name="acquirer_company_persist"]').val() == value.id ? 'selected' : false)
                        }));
                    });

                } else {
                    $('select[name="acquirer_company"]').append($('<option>', {
                        value: 0,
                        text: 'Não informado'
                    }));
                }
            }

            function setFieldProperty(response) {
                if (response.property != null) {
                    $('input[name="sale_price"]').val(response.property.sale_price);
                    $('input[name="rent_price"]').val(response.property.rent_price);
                    $('input[name="tribute"]').val(response.property.tribute);
                    $('input[name="condominium"]').val(response.property.condominium);
                } else {
                    $('input[name="sale_price"]').val('0,00');
                    $('input[name="rent_price"]').val('0,00');
                    $('input[name="tribute"]').val('0,00');
                    $('input[name="condominium"]').val('0,00');
                }
            }


            $('select[name="owner"]').change(function () {
                var owner = $(this);
                $.post(owner.data('action'), {user: owner.val()}, function (response) {
                    setFieldOwner(response);
                }, 'json');
            });

            if($('select[name="owner"]').val() != 0) {
                var owner = $('select[name="owner"]');
                $.post(owner.data('action'), {user: owner.val()}, function (response) {
                    setFieldOwner(response);
                }, 'json');
            }

            $('select[name="acquirer"]').change(function () {
                var acquirer = $(this);
                $.post(acquirer.data('action'), {user: acquirer.val()}, function (response) {
                    setFieldAcquirer(response)
                }, 'json');
            });

            if($('select[name="acquirer"]').val() != 0) {
                var acquirer = $('select[name="acquirer"]');
                $.post(acquirer.data('action'), {user: acquirer.val()}, function (response) {
                    setFieldAcquirer(response);
                }, 'json');
            }

            $('select[name="property"]').change(function () {
                var property = $(this);
                $.post(property.data('action'), {property: property.val()}, function (response) {
                    setFieldProperty(response);
                }, 'json');
            });

            if($('input[name="property_persist"]').val() > 0) {
                var property = $('select[name="property"]');
                $.post(property.data('action'), {property: $('input[name="property_persist"]').val()}, function (response) {
                    setFieldProperty(response);
                }, 'json');
            }
        });
    </script>
@endsection