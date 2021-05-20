<?php

namespace LaraDev;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'sale',
        'rent',
        'owner',
        'owner_spouse',
        'owner_company',
        'acquirer',
        'acquirer_spouse',
        'acquirer_company',
        'property',
        'sale_price',
        'rent_price',
        'price',
        'tribute',
        'condominium',
        'due_date',
        'deadline',
        'start_at',
        'status'
    ];

    /**
     * Relacionamentos
     */

    public function ownerObject()
    {
        return $this->hasOne(User::class, 'id', 'owner');
    }

    public function ownerCompanyObject()
    {
        return $this->hasOne(Company::class, 'id', 'owner_company');
    }

    public function propertyObject()
    {
        return $this->hasOne(Property::class, 'id', 'property');
    }

    public function acquirerObject()
    {
        return $this->hasOne(User::class, 'id', 'acquirer');
    }

    public function acquirerCompanyObject()
    {
        return $this->hasOne(Company::class, 'id', 'acquirer_company');
    }

    /**
     * Scopes
     */

    public function scopePendent($query)
    {
        return $query->where('status', 'pendent');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }

    /**
     * Accerssors and Mutators
     */

    public function setSaleAttribute($value)
    {
        if($value === true || $value === 'on') {
            $this->attributes['sale'] = 1;
            $this->attributes['rent'] = 0;
        }
    }

    public function setRentAttribute($value)
    {
        if($value === true || $value === 'on') {
            $this->attributes['rent'] = 1;
            $this->attributes['sale'] = 0;
        }
    }

    public function setOwnerSpouseAttribute($value)
    {
        $this->attributes['owner_spouse'] = ($value === '1' ? 1 : 0);
    }

    public function setOwnerCompanyAttribute($value)
    {
        if($value == '0'){
            $this->attributes['owner_company'] = null;
        } else {
            $this->attributes['owner_company'] = $value;
        }
    }

    public function setAcquirerSpouseAttribute($value)
    {
        $this->attributes['acquirer_spouse'] = ($value === '1' ? 1 : 0);
    }

    public function setAcquirerCompanyAttribute($value)
    {
        if($value == '0'){
            $this->attributes['acquirer_company'] = null;
        } else {
            $this->attributes['acquirer_company'] = $value;
        }
    }

    public function getPriceAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setSalePriceAttribute($value)
    {
        $this->attributes['price'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setRentPriceAttribute($value)
    {
        $this->attributes['price'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getTributeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setTributeAttribute($value)
    {
        $this->attributes['tribute'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getCondominiumAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setCondominiumAttribute($value)
    {
        $this->attributes['condominium'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getStartAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return date('d/m/Y', strtotime($value));
    }

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function convertStringToDate($param)
    {
        if(empty($param)) {
            return null;
        }

        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }

    public function terms()
    {
        // Finalidade [Venda/Locação]
        if ($this->sale == true) {
            $parameters = [
                'purpouse' => 'VENDA',
                'part' => 'VENDEDOR',
                'part_opposite' => 'COMPRADOR',
            ];
        }

        if ($this->rent == true) {
            $parameters = [
                'purpouse' => 'LOCAÇÃO',
                'part' => 'LOCADOR',
                'part_opposite' => 'LOCATÁRIO',
            ];
        }

        $terms[] = "<p style='text-align: center;'>{$this->id} - CONTRATO DE {$parameters['purpouse']} DE IMÓVEL</p>";

        // OWNER
        if (!empty($this->owner_company)) { // Se tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->ownerCompanyObject->document_company} e I. E. nº {$this->ownerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->ownerCompanyObject->street}, nº {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyObject->neighborhood}, {$this->ownerCompanyObject->city}/{$this->ownerCompanyObject->state}, CEP {$this->ownerCompanyObject->zipcode} tendo como responsável legal {$this->ownerObject->name}, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->getCivilStatusTranslateAttribute($this->ownerObject->civil_status, $this->ownerObject->genre)}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, e cônjuge {$this->ownerObject->spouse_name}, natural de {$this->ownerObject->spouse_place_of_birth}, {$this->ownerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->spouse_document_secondary} {$this->ownerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->spouse_document}, residentes e domiciliados à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->ownerCompanyObject->document_company} e I. E. nº {$this->ownerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->ownerCompanyObject->street}, nº {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyObject->neighborhood}, {$this->ownerCompanyObject->city}/{$this->ownerCompanyObject->state}, CEP {$this->ownerCompanyObject->zipcode} tendo como responsável legal {$this->ownerObject->name}, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->getCivilStatusTranslateAttribute($this->ownerObject->civil_status, $this->ownerObject->genre)}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, residente e domiciliado à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            }
        } else { // Se não tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerObject->name}</b>, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->getCivilStatusTranslateAttribute($this->ownerObject->civil_status, $this->ownerObject->genre)}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, e cônjuge {$this->ownerObject->spouse_name}, natural de {$this->ownerObject->spouse_place_of_birth}, {$this->ownerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->spouse_document_secondary} {$this->ownerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->spouse_document}, residentes e domiciliados à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerObject->name}</b>, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->getCivilStatusTranslateAttribute($this->ownerObject->civil_status, $this->ownerObject->genre)}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerObject->document}, residente e domiciliado à {$this->ownerObject->street}, nº {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            }
        }

        // ACQUIRER
        // Se tem empresa
        if (!empty($this->acquirer_company)) { // Se tem empresa

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->acquirerCompanyObject->document_company} e I. E. nº {$this->acquirerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->acquirerCompanyObject->street}, nº {$this->acquirerCompanyObject->number}, {$this->acquirerCompanyObject->complement}, {$this->acquirerCompanyObject->neighborhood}, {$this->acquirerCompanyObject->city}/{$this->acquirerCompanyObject->state}, CEP {$this->acquirerCompanyObject->zipcode} tendo como responsável legal {$this->acquirerObject->name}, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->getCivilStatusTranslateAttribute($this->acquirerObject->civil_status, $this->acquirerObject->genre)}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, e cônjuge {$this->acquirerObject->spouse_name}, natural de {$this->acquirerObject->spouse_place_of_birth}, {$this->acquirerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->spouse_document_secondary} {$this->acquirerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->spouse_document}, residentes e domiciliados à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->acquirerCompanyObject->document_company} e I. E. nº {$this->acquirerCompanyObject->document_company_secondary} exercendo suas atividades no endereço {$this->acquirerCompanyObject->street}, nº {$this->acquirerCompanyObject->number}, {$this->acquirerCompanyObject->complement}, {$this->acquirerCompanyObject->neighborhood}, {$this->acquirerCompanyObject->city}/{$this->acquirerCompanyObject->state}, CEP {$this->acquirerCompanyObject->zipcode} tendo como responsável legal {$this->acquirerObject->name}, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->getCivilStatusTranslateAttribute($this->acquirerObject->civil_status, $this->acquirerObject->genre)}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, residente e domiciliado à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            }
        } else { // Se não tem empresa

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerObject->name}</b>, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->getCivilStatusTranslateAttribute($this->acquirerObject->civil_status, $this->acquirerObject->genre)}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, e cônjuge {$this->acquirerObject->spouse_name}, natural de {$this->acquirerObject->spouse_place_of_birth}, {$this->acquirerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->spouse_document_secondary} {$this->acquirerObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->spouse_document}, residentes e domiciliados à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerObject->name}</b>, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->getCivilStatusTranslateAttribute($this->acquirerObject->civil_status, $this->acquirerObject->genre)}, {$this->acquirerObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerObject->document}, residente e domiciliado à {$this->acquirerObject->street}, nº {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            }
        }

        $terms[] = "<p style='font-style: italic; font-size: 0.875em;'>A falsidade dessa declaração configura crime previsto no Código Penal Brasileiro, e passível de apuração na forma da Lei.</p>";

        $terms[] = "<p><b>5. IMÓVEL:</b> {$this->propertyObject->category}, {$this->propertyObject->type}, localizada no endereço {$this->propertyObject->street}, nº {$this->propertyObject->number}, {$this->propertyObject->complement}, {$this->propertyObject->neighborhood}, {$this->propertyObject->city}/{$this->propertyObject->state}, CEP {$this->propertyObject->zipcode}</p>";

        $terms[] = "<p><b>6. PERÍODO:</b> {$this->deadline} meses</p>";

        $terms[] = "<p><b>7. VIGÊNCIA:</b> O presente contrato tem como data de início {$this->start_at} e o término exatamente após a quantidade de meses descrito no item 6 deste.</p>";

        $terms[] = "<p><b>8. VENCIMENTO:</b> Fica estipulado o vencimento no dia {$this->due_date} do mês posterior ao do início de vigência do presente contrato.</p>";

        $terms[] = "<p>Florianópolis, " . date('d/m/Y') . ".</p>";

        $terms[] = "<table width='100%' style='margin-top: 50px;'>
                           <tr>
                                <td>_________________________</td>
                                " . ($this->owner_spouse ? "<td>_________________________</td>" : "") . "
                           </tr>
                           <tr>
                                <td>{$parameters['part']}: {$this->ownerObject->name}</td>
                                " . ($this->owner_spouse ? "<td>Conjuge: {$this->ownerObject->spouse_name}</td>" : "") . "
                           </tr>
                           <tr>
                                <td>Documento: {$this->ownerObject->document}</td>
                                " . ($this->owner_spouse ? "<td>Documento: {$this->ownerObject->spouse_document}</td>" : "") . "
                           </tr>
                           
                    </table>";


        $terms[] = "<table width='100%' style='margin-top: 50px;'>
                           <tr>
                                <td>_________________________</td>
                                " . ($this->acquirer_spouse ? "<td>_________________________</td>" : "") . "
                           </tr>
                           <tr>
                                <td>{$parameters['part_opposite']}: {$this->acquirerObject->name}</td>
                                " . ($this->acquirer_spouse ? "<td>Conjuge: {$this->acquirerObject->spouse_name}</td>" : "") . "
                           </tr>
                           <tr>
                                <td>Documento: {$this->acquirerObject->document}</td>
                                " . ($this->acquirer_spouse ? "<td>Documento: {$this->acquirerObject->spouse_document}</td>" : "") . "
                           </tr>
                           
                    </table>";

        $terms[] = "<table width='100%' style='margin-top: 50px;'>
                           <tr>
                                <td>_________________________</td>
                                <td>_________________________</td>
                           </tr>
                           <tr>
                                <td>1ª Testemunha: </td>
                                <td>2ª Testemunha: </td>
                           </tr>
                           <tr>
                                <td>Documento: </td>
                                <td>Documento: </td>
                           </tr>
                           
                    </table>";

        return implode('', $terms);
    }
}
