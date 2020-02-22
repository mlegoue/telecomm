<?php
namespace App\Entity;

class Search {

    /**
     * @var int|null
     */
    private $isOnline;

    /**
     * @return int|null
     */
    public function getIsOnline(): ?int
    {
        return $this->isOnline;
    }

    /**
     * @param int|null $isOnline
     */
    public function setIsOnline(int $isOnline): void
    {
        $this->isOnline = $isOnline;
    }


}