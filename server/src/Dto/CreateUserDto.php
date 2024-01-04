<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Email;

class CreateUserDto{
    public function __construct(
        #[NotBlank(message: "el email no pueda estar vacio")]
        #[Type("string")]
        #[Email(message: "debes ingresar un email valido")]
        public readonly string $email,

        #[NotBlank(message: "el email no pueda estar vacio")]
        #[Type("string")]
        public readonly string $password,

        #[NotBlank(message: "lso roles no pueden estar vacios")]
        #[Type(type: "array", message: "los roles deben ser un array")]
        public readonly array $roles,
    ){
        
    }
}