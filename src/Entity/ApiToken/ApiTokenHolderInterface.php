<?php

namespace App\Entity\ApiToken;

use Doctrine\Common\Collections\Collection;

interface ApiTokenHolderInterface
{
    /**
     * @return Collection|ApiTokenInterface[]
     */
    public function getTokens(): Collection;

    public function addToken(ApiTokenInterface $token): void;

    public function removeToken(ApiTokenInterface $token): void;
}