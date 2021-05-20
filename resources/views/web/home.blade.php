@extends('web.master.master')

@section('content')
    <div class="main_slide d-none d-sm-block">
        <div class="container" style="height: 100%;">
            <div class="row align-items-center" style="height: 100%;">
                <div class="col-lg-8">
                    <p class="main_slide_content text-white">Encontre o <b>Imóvel ideal</b> para você e <b>sua
                            família</b>
                        morar na praia!</p>
                    <a href="{{ route('web.rent') }}" class="btn btn-front btn-lg text-white">Quero <b>Alugar</b>!</a>
                    <a href="{{ route('web.buy') }}" class="btn btn-front btn-lg text-white">Quero <b>Comprar</b>!</a>
                </div>
            </div>
        </div>
    </div>

    <div class="main_filter">
        <div class="container my-5">
            <div class="row">
                <form action="{{ route('web.filter') }}" method="post" class="form-inline w-100">
                    @csrf
                    <div class="form-group col-12 col-sm-6 col-lg-3">
                        <label for="search" class="mb-2"><b>Comprar ou Alugar?</b></label>
                        <select class="selectpicker" id="search" name="filter_search" title="Escolha..." data-index="1" data-action="{{ route('component.main-filter.search') }}">
                            <option value="buy">Comprar</option>
                            <option value="rent">Alugar</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-sm-6 col-lg-3">
                        <label for="category" class="mb-2"><b>O que você quer?</b></label>
                        <select class="selectpicker" id="category" name="filter_category" title="Escolha..." data-index="2" data-action="{{ route('component.main-filter.category') }}">
                            <option disabled>Selecione o filtro anterior</option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-sm-6 mt-sm-2 mt col-lg-3 mt-lg-0">
                        <label for="type" class="mb-2 d-block"><b>Qual o tipo do imóvel?</b></label>
                        <select class="selectpicker input-large" id="type" name="filter_type" multiple data-actions-box="true" title="Escolha..." data-index="3" data-action="{{ route('component.main-filter.type') }}">
                            <option disabled>Selecione o filtro anterior</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                        <label for="search_locale" class="mb-2"><b>Onde você quer?</b></label>
                        <select class="selectpicker" name="filter_neighborhood" id="neighborhood" title="Escolha..." data-index="4" data-action="{{ route('component.main-filter.neighborhood') }}" multiple
                                data-actions-box="true">
                            <option disabled>Selecione o filtro anterior</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3 form_advanced" style="display: none;">

                        <div class="row">
                            <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                                <label for="bedrooms" class="mb-2"><b>Quartos</b></label>
                                <select class="selectpicker" name="filter_bedrooms" data-index="5" data-action="{{ route('component.main-filter.bedrooms') }}" id="bedrooms" title="Escolha...">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                                <label for="bedrooms" class="mb-2"><b>Suítes</b></label>
                                <select class="selectpicker" name="filter_suites" id="suites" title="Escolha..." data-index="6" data-action="{{ route('component.main-filter.suites') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                                <label for="bedrooms" class="mb-2"><b>Banheiros</b></label>
                                <select class="selectpicker" name="filter_bathrooms" id="bathrooms" title="Escolha..." data-index="7" data-action="{{ route('component.main-filter.bathrooms') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-3 mt-lg-0">
                                <label for="bedrooms" class="mb-2"><b>Garagem</b></label>
                                <select class="selectpicker" name="filter_garage" id="garage" title="Escolha..." data-index="8" data-action="{{ route('component.main-filter.garage') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-6 mt-lg-0">
                                <label for="bedrooms" class="mb-2"><b>Preço Base</b></label>
                                <select class="selectpicker" name="filter_base" id="base" title="Escolha..." data-index="9" data-action="{{ route('component.main-filter.priceBase') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-sm-6 mt-sm-2 col-lg-6 mt-lg-0">
                                <label for="bedrooms" class="mb-2"><b>Preço Limite</b></label>
                                <select class="selectpicker" name="filter_limit" id="limit" title="Escolha..." data-index="10" data-action="{{ route('component.main-filter.priceLimit') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 mt-3">
                        <a href="" class="text-front open_filter">Filtro avançado &downarrow;</a>
                    </div>

                    <div class="col-6 text-right mt-3 button_search">
                        <button class="btn btn-front icon-search">Pesquisar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="main_list_group py-5 bg-light">
        <div class="container">
            <div class="p-4 border-bottom border-front">
                <h1 class="text-center">Ambiente no seu <span class="text-front"><b>estilo</b></span></h1>
                <p class="text-center text-muted mb-0 h4">Encontre o imóvel com a experiência que você quer viver</p>
            </div>

            <div class="main_list_group_item row mt-5 d-flex justify-content-around">
                <article class="main_list_group_items_item col-12 col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('web.experienceCategory', ['category' => 'cobertura']) }}">
                        <div class="d-flex align-items-center justify-content-center"
                             style="background: url('frontend/assets/images/home/cobertura_oto_1.jpg') no-repeat; background-size: cover;">
                            <h2>Cobertura</h2>
                        </div>
                    </a>
                </article>

                <article class="main_list_group_items_item col-12 col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('web.experienceCategory', ['category' => 'alto-padrao']) }}">
                        <div class="d-flex align-items-center justify-content-center"
                             style="background: url('frontend/assets/images/home/alto_padrao_1.jpg') no-repeat; background-size: cover;">
                            <h2>Alto Padrão</h2>
                        </div>
                    </a>
                </article>

                <article class="main_list_group_items_item col-12 col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('web.experienceCategory', ['category' => 'de-frente-para-o-mar']) }}">
                        <div class="d-flex align-items-center justify-content-center"
                             style="background: url('frontend/assets/images/home/de_frente_pro_mar_original.jpg') no-repeat; background-size: cover;">
                            <h2>De frente para o Mar</h2>
                        </div>
                    </a>
                </article>

                <article class="main_list_group_items_item col-12 col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('web.experienceCategory', ['category' => 'condominio-fechado']) }}">
                        <div class="d-flex align-items-center justify-content-center"
                             style="background: url('frontend/assets/images/home/condominio_fechado_1.jpg') no-repeat; background-size: cover;">
                            <h2>Condomínio Fechado</h2>
                        </div>
                    </a>
                </article>

                <article class="main_list_group_items_item col-12 col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('web.experienceCategory', ['category' => 'compacto']) }}">
                        <div class="d-flex align-items-center justify-content-center"
                             style="background: url('frontend/assets/images/home/compacto_1.jpg') no-repeat; background-size: cover;">
                            <h2>Compacto</h2>
                        </div>
                    </a>
                </article>

                <article class="main_list_group_items_item col-12 col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('web.experienceCategory', ['category' => 'lojas-e-salas']) }}">
                        <div class="d-flex align-items-center justify-content-center"
                             style="background: url('frontend/assets/images/home/sala_comercial_original.jpg') no-repeat; background-size: cover;">
                            <h2>Lojas e Salas</h2>
                        </div>
                    </a>
                </article>
            </div>
        </div>
    </section>

    <section class="main_properties py-5">
        <div class="container">
            <header class="d-flex justify-content-between align-items-center border-bottom border-front mb-5">
                <h1 class="text-front">À Venda</h1>
                <a href="{{ route('web.buy') }}" class="text-front">Ver mais</a>
            </header>

            <div class="row">

                @if($propertiesForSale->count())
                    @foreach($propertiesForSale as $property)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <article class="card main_properties_item">
                                <div class="img-responsive-16by9">
                                    <a href="{{ route('web.buyProperty', ['property' => $property->slug]) }}">
                                        <img src="{{ $property->cover() }}" class="card-img-top"
                                             alt="">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h2><a href="{{ route('web.buyProperty', ['property' => $property->slug]) }}"
                                           class="text-front">{{ $property->title }}</a>
                                    </h2>
                                    <p class="main_properties_item_category">{{ $property->category }}</p>
                                    <p class="main_properties_item_type">{{ $property->type }}
                                        - {{ $property->neighborhood }} <i
                                                class="icon-location-arrow icon-notext"></i></p>
                                    <p class="main_properties_price text-front">R$ {{ $property->sale_price }}</p>
                                    <a href="{{ route('web.buyProperty', ['property' => $property->slug]) }}"
                                       class="btn btn-front btn-block">Ver Imóvel</a>
                                </div>
                                <div class="card-footer d-flex">
                                    <div class="main_properties_features col-4 text-center">
                                        <img src="frontend/assets/images/icons/bed.png" class="img-fluid" alt="">
                                        <p class="text-muted">{{ $property->bedrooms }}</p>
                                    </div>

                                    <div class="main_properties_features col-4 text-center">
                                        <img src="frontend/assets/images/icons/garage.png" class="img-fluid" alt="">
                                        <p class="text-muted">{{ $property->garage + $property->garage_covered }}</p>
                                    </div>

                                    <div class="main_properties_features col-4 text-center">
                                        <img src="frontend/assets/images/icons/util-area.png" class="img-fluid" alt="">
                                        <p class="text-muted">{{ $property->area_util }} m&sup2;</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <section class="main_properties py-5 bg-light">
        <div class="container">
            <header class="d-flex justify-content-between align-items-center border-bottom border-front mb-5">
                <h1 class="text-front">Para Alugar</h1>
                <a href="{{ route('web.rent') }}" class="text-front">Ver mais</a>
            </header>

            <div class="row">

                @if($propertiesForRent->count())
                    @foreach($propertiesForSale as $property)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <article class="card main_properties_item">
                                <div class="img-responsive-16by9">
                                    <a href="{{ route('web.rentProperty', ['property' => $property->slug]) }}">
                                        <img src="{{ $property->cover() }}" class="card-img-top"
                                             alt="">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h2><a href="{{ route('web.rentProperty', ['property' => $property->slug]) }}"
                                           class="text-front">{{ $property->title }}</a>
                                    </h2>
                                    <p class="main_properties_item_category">{{ $property->category }}</p>
                                    <p class="main_properties_item_type">{{ $property->type }}
                                        - {{ $property->neighborhood }} <i
                                                class="icon-location-arrow icon-notext"></i></p>
                                    <p class="main_properties_price text-front">R$ {{ $property->rent_price }}/mês</p>
                                    <a href="{{ route('web.rentProperty', ['property' => $property->slug]) }}"
                                       class="btn btn-front btn-block">Ver Imóvel</a>
                                </div>
                                <div class="card-footer d-flex">
                                    <div class="main_properties_features col-4 text-center">
                                        <img src="frontend/assets/images/icons/bed.png" class="img-fluid" alt="">
                                        <p class="text-muted">{{ $property->bedrooms }}</p>
                                    </div>

                                    <div class="main_properties_features col-4 text-center">
                                        <img src="frontend/assets/images/icons/garage.png" class="img-fluid" alt="">
                                        <p class="text-muted">{{ $property->garage + $property->garage_covered }}</p>
                                    </div>

                                    <div class="main_properties_features col-4 text-center">
                                        <img src="frontend/assets/images/icons/util-area.png" class="img-fluid" alt="">
                                        <p class="text-muted">{{ $property->area_util }} m&sup2;</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
@endsection
