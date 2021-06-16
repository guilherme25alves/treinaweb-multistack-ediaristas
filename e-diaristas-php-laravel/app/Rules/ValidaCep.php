<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\ViaCEP;

class ValidaCep implements Rule
{
    protected ViaCEP $viaCEP;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(ViaCEP $viaCEP)
    {
        $this->viaCEP = $viaCEP;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cep = str_replace('-', '', $value);
        
        return !! $this->viaCEP->buscar($cep);

        /*
         !! -> força a ser um booleano, se vim o Array é TRUE, o false permance FALSE
        */
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CEP inválido!';
    }
}
