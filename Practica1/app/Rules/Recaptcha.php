<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule; // Importar la interfaz correcta
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule // Implementar la interfaz correcta
{
    /**
     * Create a new rule instance
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure $fail
     * @return void
     */
    public function validate($attribute, $value, $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LejC-gpAAAAALNYN6yWZlVCrFc3x69pZ6u0syMt',
            'response' => $value
        ])->object();

        // Simular fallo
        /* $response->success = false;
        $response->score = 0.0; */

        if (!($response->success && $response->score >= 0.7)) {
            $fail("La verificación del ReCaptcha ha fallado.");
        }
    }
}
