@extends('web.master.master')

@section('content')
    <section class="main_property">
        <div class="main_property_header py-5 bg-light">
            <div class="container">
                <h1 class="text-front">{{ $property->title }}</h1>
                <p class="mb-0">{{ $property->category }} - {{ $property->type }} - {{ $property->neighborhood }}</p>
            </div>
        </div>
        <div class="main_property_content py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div id="carouselProperty" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">

                                @if($property->images()->get()->count())
                                    @foreach($property->images()->get() as $image)
                                        <li data-target="#carouselProperty" data-slide-to="{{ $loop->iteration }}" {!! ($loop->iteration == 1 ? 'class="active"' : '') !!}></li>
                                    @endforeach
                                @endif

                            </ol>

                            <div class="carousel-inner">

                                @if($property->images()->get()->count())
                                    @foreach($property->images()->get() as $image)

                                        <div class="carousel-item {{ ($loop->iteration == 1 ? 'active' : '') }}">
                                            <a href="{{ $image->getUrlCroppedAttribute() }}" data-toggle="lightbox"
                                               data-gallery="property-gallery" data-type="image">
                                                <img src="{{ $image->getUrlCroppedAttribute() }}"
                                                     class="d-block w-100"
                                                     alt="{{ $property->title }}">
                                            </a>
                                        </div>

                                    @endforeach
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#carouselProperty" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselProperty" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Próximo</span>
                            </a>
                        </div>

                        <div class="main_property_price pt-4 text-muted">
                            <p class="main_property_price_small">IPTU: R$ {{ $property->tribute }} {{ ($property->condominium != '0,00' ? '| Condomínio: R$' . $property->condominium : '') }}</p>

                            @if(!empty($type) && $type == 'sale')
                                <p class="main_property_price_big">Valor do Imóvel: R$ {{ $property->sale_price }}</p>
                            @elseif(!empty($type) && $type == 'rent')
                                <p class="main_property_price_big">Valor do Aluguel: R$ {{ $property->rent_price }}/mês</p>
                            @else

                                @if($property->sale == true && !empty($property->sale_price) && $property->rent == true && !empty($property->rent_price))
                                    <p class="main_property_price_big">Valor do Imóvel: R$ {{ $property->sale_price }} <br>
                                    ou Valor do Aluguel: R$ {{ $property->rent_price }}/mês</p>
                                @elseif($property->sale == true && !empty($property->sale_price))
                                    <p class="main_property_price_big">Valor do Imóvel: R$ {{ $property->sale_price }}</p>
                                @elseif($property->rent == true && !empty($property->rent_price))
                                    <p class="main_property_price_big">Valor do Aluguel: R$ {{ $property->rent_price }}/mês</p>
                                @else
                                    <p class="main_properties_price text-front">Entre em contato com a nossa equipe comercial!</p>
                                @endif
                            @endif
                        </div>

                        <div class="main_property_content_description">
                            <h2 class="text-front">Conheça mais o imóvel</h2>
                            {!! $property->description !!}
                        </div>

                        <div class="main_property_content_features">
                            <h2 class="text-front">Características</h2>
                            <table class="table table-striped" style="margin-bottom: 40px;">
                                <tbody>
                                <tr>
                                    <td>Domitórios</td>
                                    <td>{{ $property->bedrooms }}</td>
                                </tr>
                                <tr>
                                    <td>Suítes</td>
                                    <td>{{ $property->suites }}</td>
                                </tr>
                                <tr>
                                    <td>Banheiros</td>
                                    <td>{{ $property->bathrooms }}</td>
                                </tr>
                                <tr>
                                    <td>Salas</td>
                                    <td>{{ $property->rooms }}</td>
                                </tr>
                                <tr>
                                    <td>Garagem</td>
                                    <td>{{ $property->garage }}</td>
                                </tr>
                                <tr>
                                    <td>Garagem Coberta</td>
                                    <td>{{ $property->garage_covered }}</td>
                                </tr>
                                <tr>
                                    <td>Área Total</td>
                                    <td>{{ $property->area_total }} m&sup2;</td>
                                </tr>
                                <tr>
                                    <td>Área Útil</td>
                                    <td>{{ $property->area_util }} m&sup2;</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="main_property_structure">
                            <h2 class="text-front">Estrutura</h2>

                            <div class="row">
                                @if($property->air_conditioning == true)
                                    <span class="main_property_structure_item icon-check">Ar Condicionado</span>
                                @endif

                                @if($property->bar == true)
                                    <span class="main_property_structure_item icon-check">Bar</span>
                                @endif

                                @if($property->library == true)
                                    <span class="main_property_structure_item icon-check">Biblioteca</span>
                                @endif

                                @if($property->barbecue_grill == true)
                                    <span class="main_property_structure_item icon-check">Churrasqueira</span>
                                @endif

                                @if($property->american_kitchen == true)
                                    <span class="main_property_structure_item icon-check">Cozinha Americana</span>
                                @endif

                                @if($property->fitted_kitchen == true)
                                    <span class="main_property_structure_item icon-check">Cozinha Planejada</span>
                                @endif

                                @if($property->pantry == true)
                                    <span class="main_property_structure_item icon-check">Despensa</span>
                                @endif

                                @if($property->edicule == true)
                                    <span class="main_property_structure_item icon-check">Edicula</span>
                                @endif

                                @if($property->office == true)
                                    <span class="main_property_structure_item icon-check">Escritório</span>
                                @endif

                                @if($property->bathtub == true)
                                    <span class="main_property_structure_item icon-check">Banheira</span>
                                @endif

                                @if($property->fireplace == true)
                                    <span class="main_property_structure_item icon-check">Lareira</span>
                                @endif

                                @if($property->lavatory == true)
                                    <span class="main_property_structure_item icon-check">Lavabo</span>
                                @endif

                                @if($property->furnished == true)
                                    <span class="main_property_structure_item icon-check">Mobiliado</span>
                                @endif

                                @if($property->pool == true)
                                    <span class="main_property_structure_item icon-check">Piscina</span>
                                @endif

                                @if($property->steam_room == true)
                                    <span class="main_property_structure_item icon-check">Sauna</span>
                                @endif

                                @if($property->view_of_the_sea == true)
                                    <span class="main_property_structure_item icon-check">Vista para o Mar</span>
                                @endif
                            </div>
                        </div>

                        <div class="main_property_location">
                            <h2 class="text-front">Localização</h2>
                            <div id="map" style="width: 100%; min-height: 400px;"></div>
                        </div>

                    </div>

                    <div class="col-12 col-lg-4">
                        <a href="https://api.whatsapp.com/send?phone=DDI+DDD+TELEFONE&text=Olá, preciso de ajuda com o login." class="btn btn-outline-success btn-lg btn-block icon-whatsapp mb-3">Converse com o Corretor!
                        </a>

                        <div class="main_property_contact">
                            <h2 class="bg-front text-white">Entre em contato</h2>

                            <form action="{{ route('web.sendEmail') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Seu nome:</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Informe seu nome completo">
                                </div>

                                <div class="form-group">
                                    <label for="telephone">Seu telefone:</label>
                                    <input type="tel" name="cell" class="form-control"
                                           placeholder="Informe seu telefone com DDD">
                                </div>

                                <div class="form-group">
                                    <label for="email">Seu e-mail:</label>
                                    <input type="email" name="email" class="form-control"
                                           placeholder="Informe seu melhor e-mail">
                                </div>

                                <div class="form-group">
                                    <label for="message">Sua Mensagem:</label>
                                    <textarea name="message" id="message" cols="30" rows="5" class="form-control">Quero ter mais informações sobre esse imóvel. Imóvel Residencial, Casa, Campeche, Florianópolis! (#01)</textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-block btn-front">Enviar</button>
                                    <p class="text-center text-front mb-0 mt-4 font-weight-bold">(48) 3322-1234</p>
                                </div>
                            </form>
                        </div>

                        <div class="main_property_share py-3 text-right d-flex justify-content-center">
                            <div class="fb-share-button mr-2" data-href="{{ url()->current() }}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" data-text="{{ $property->title }}" data-url="{{ url()->current() }}" data-hashtags="laradev" data-related="guuweb" data-lang="pt" data-show-count="false">Tweet</a>
                            <a style="padding: 0 10px; margin: 0; font-size: 0.875em; padding-top: 2px;" href="https://instagram.com/guhweb/" target="_blank" class="btn btn-front icon-instagram ml-2">Instagram</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>

        function markMap() {

            var locationJson = $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address={{ $property->street }},+{{ $property->number }}+{{ $property->city }}+{{ $property->neighborhood }}&key=AIzaSyCYSFkpHgtfdOA9WNnUOVjt2PLlBfC9xvU', function(response){

                lat = response.results[0].geometry.location.lat;
                lng = response.results[0].geometry.location.lng;

                var citymap = {
                    property: {
                        center: {lat: lat, lng: lng},
                        population: 100
                    }
                };

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 14,
                    center: {lat: lat, lng: lng},
                    mapTypeId: 'terrain'
                });

                for (var city in citymap) {
                    var cityCircle = new google.maps.Circle({
                        strokeColor: '#FF0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#FF0000',
                        fillOpacity: 0.35,
                        map: map,
                        center: citymap[city].center,
                        radius: Math.sqrt(citymap[city].population) * 100
                    });
                }
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYSFkpHgtfdOA9WNnUOVjt2PLlBfC9xvU&callback=markMap"></script>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.3&appId=1981931985380360&autoLogAppEvents=1"></script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection
