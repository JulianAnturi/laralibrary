<?php

namespace App\Services;

class TrieNode
{
    public $children = [];
    public $isEndOfWord = false;
    public $original = null; // Guarda el valor original (puede ser objeto completo)
}

class TrieService
{
    protected $tries = [];

    // Inserta una palabra en el Trie según el campo
    public function insert($field, $word, $originalData = null)
    {
        if (!isset($this->tries[$field])) {
            $this->tries[$field] = new TrieNode();
        }

        $word = $this->normalize($word); // 🔥 Normalización
        $node = $this->tries[$field];

        foreach ($this->mb_str_split($word) as $char) {
            if (!isset($node->children[$char])) {
                $node->children[$char] = new TrieNode();
            }
            $node = $node->children[$char];
        }

        $node->isEndOfWord = true;
        $node->original = $originalData ?? $word;
    }

    // Busca por prefijo en el Trie
    public function search($field, $prefix)
    {
        if (!isset($this->tries[$field])) {
            return [];
        }

        $prefix = $this->normalize($prefix); // 🔥 Normalización
        $node = $this->tries[$field];

        foreach ($this->mb_str_split($prefix) as $char) {
            if (!isset($node->children[$char])) {
                return [];
            }
            $node = $node->children[$char];
        }

        return $this->collect($prefix, $node);
    }

    // Recolecta resultados desde un nodo en adelante
    protected function collect($prefix, $node)
    {
        $results = [];

        if ($node->isEndOfWord) {
            $results[] = $node->original;
        }

        foreach ($node->children as $char => $child) {
            $results = array_merge($results, $this->collect($prefix . $char, $child));
        }

        return $results;
    }

    // Normaliza el texto (baja a minúsculas y quita espacios)
    protected function normalize($text)
    {
        return mb_strtolower(trim($text));
    }

    // Alternativa a str_split para caracteres multibyte
    protected function mb_str_split($string)
    {
        return preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
    }
}
