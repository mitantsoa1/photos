<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class StringToFileTransformer implements DataTransformerInterface
{
    private $uploadPath;

    public function __construct($uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        return new File($this->uploadPath . '/' . $value);
    }

    public function reverseTransform($value)
    {
        // On laisse passer la valeur telle quelle pour l'enregistrement
        return $value;
    }
}