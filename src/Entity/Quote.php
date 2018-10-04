<?php

namespace App\Entity;

class Quote
{
    /**
     * @var string
     */
    private $id = null;

    /**
     * @var string
     */
    private $quote = "";

    /**
     * @var string
     */
    private $meta = "";

    public function getId()
    {
        return $this->id;
    }

    public function setQuote($q)
    {
        $this->quote = $q;
    }

    public function getQuote()
    {
        return $this->quote;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setmeta($m)
    {
        $this->meta = $m;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
