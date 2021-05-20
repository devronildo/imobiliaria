<?php

namespace LaraDev\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use LaraDev\Http\Controllers\Controller;
use LaraDev\Mail\Web\Contact;
use LaraDev\Property;

class WebController extends Controller
{
    public function home()
    {
        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            'Encontre o imóvel dos seus sonhos na melhor e mais completa imobiliária do Sul da ilha de Florianópolis',
            route('web.home'),
            asset('frontend/assets/images/share.png'));

        $propertiesForSale = Property::sale()->available()->limit(3)->get();
        $propertiesForRent = Property::rent()->available()->limit(3)->get();

        return view('web.home', [
            'head' => $head,
            'propertiesForSale' => $propertiesForSale,
            'propertiesForRent' => $propertiesForRent,
        ]);
    }

    public function spotlight()
    {
        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            'Confira nossos maiores empreendimentos e lançamentos no Sul da Ilha de Florianópolis!',
            route('web.spotlight'),
            asset('frontend/assets/images/share.png'));

        return view('web.spotlight', [
            'head' => $head
        ]);
    }

    public function rent()
    {
        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            'Alugue o imóvel dos seus sonhos na melhor e mais completa imobiliária do Sul da ilha de Florianópolis',
            route('web.rent'),
            asset('frontend/assets/images/share.png'));

        $filter = new FilterController();
        $filter->clearAllData();

        $properties = Property::rent()->available()->get();

        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
            'type' => 'rent',
        ]);
    }

    public function rentProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();

        $property->views = $property->views + 1;
        $property->save();

        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            $property->headline ?? $property->title,
            route('web.rentProperty', ['property' => $property->slug]),
            $property->cover());

        return view('web.property', [
            'head' => $head,
            'property' => $property,
            'type' => 'rent',
        ]);
    }

    public function buy()
    {
        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            'Compre o imóvel dos seus sonhos na melhor e mais completa imobiliária do Sul da ilha de Florianópolis',
            route('web.buy'),
            asset('frontend/assets/images/share.png'));

        $filter = new FilterController();
        $filter->clearAllData();

        $properties = Property::sale()->available()->get();

        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
            'type' => 'sale',
        ]);
    }

    public function buyProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();

        $property->views = $property->views + 1;
        $property->save();

        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            $property->headline ?? $property->title,
            route('web.buyProperty', ['property' => $property->slug]),
            $property->cover());

        return view('web.property', [
            'head' => $head,
            'property' => $property,
            'type' => 'sale',
        ]);
    }

    public function filter()
    {
        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            'Filter o imóvel dos seus sonhos na melhor e mais completa imobiliária do Sul da ilha de Florianópolis',
            route('web.filter'),
            asset('frontend/assets/images/share.png'));

        $filter = new FilterController();
        $itemProperties = $filter->createQuery('id');

        foreach ($itemProperties as $property) {
            $properties[] = $property->id;
        }

        if (!empty($properties)) {
            $properties = Property::whereIn('id', $properties)->get();
        } else {
            $properties = Property::all();
        }

        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
        ]);
    }

    public function experience()
    {
        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            'Viva a experiência de encontrar o imóvel dos seus sonhos na melhor e mais completa imobiliária do Sul da ilha de Florianópolis',
            route('web.experience'),
            asset('frontend/assets/images/share.png'));

        $filter = new FilterController();
        $filter->clearAllData();

        $properties = Property::whereNotNull('experience')->get();

        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
        ]);
    }

    public function experienceCategory(Request $request)
    {

        $filter = new FilterController();
        $filter->clearAllData();

        if ($request->slug == 'cobertura') {
            $properties = Property::where('experience', 'Cobertura')->get();

            $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
                'Viva a experiência de morar na Cobertura...',
                route('web.experienceCategory', ['category' => 'cobertura']),
                asset('frontend/assets/images/share.png'));

        } elseif ($request->slug == 'alto-padrao') {
            $properties = Property::where('experience', 'Alto Padrão')->get();

            $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
                'Viva a experiência de morar num imóvel de alto padrão...',
                route('web.experienceCategory', ['category' => 'alto-padrao']),
                asset('frontend/assets/images/share.png'));
        } elseif ($request->slug == 'de-frente-para-o-mar') {
            $properties = Property::where('experience', 'De Frente para o Mar')->get();
        } elseif ($request->slug == 'condominio-fechado') {
            $properties = Property::where('experience', 'Condomínio Fechado')->get();
        } elseif ($request->slug == 'compacto') {
            $properties = Property::where('experience', 'Compacto')->get();
        } elseif ($request->slug == 'lojas-e-salas') {
            $properties = Property::where('experience', 'Lojas e Salas')->get();
        } else {
            $properties = Property::whereNotNull('experience')->get();
        }

        if(empty($head)){
            $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
                'Viva a experiência de morar na praia em uma das capitais mais bonitas do Brasil',
                route('web.experience'),
                asset('frontend/assets/images/share.png'));
        }

        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
        ]);
    }

    public function contact()
    {
        $head = $this->seo->render(env('APP_NAME') . ' - UpInside Treinamentos',
            'Quer conversar com um corretor exclusivo e ter o atendimento diferenciado em busca do seu imóvel dos sonhos? Entre em contato com a nossa equipe!',
            route('web.contact'),
            asset('frontend/assets/images/share.png'));

        return view('web.contact', [
            'head' => $head
        ]);
    }

    public function sendEmail(Request $request)
    {
        $data = [
            'reply_name' => $request->name,
            'reply_email' => $request->email,
            'cell' => $request->cell,
            'message' => $request->message
        ];

        Mail::send(new Contact($data));

        return redirect()->route('web.sendEmailSuccess');
    }

    public function sendEmailSuccess()
    {
        return view('web.contact_success');
    }
}
