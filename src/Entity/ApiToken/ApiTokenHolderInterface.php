<?php

namespace App\Entity\ApiToken;

use Doctrine\Common\Collections\Collection;

interface ApiTokenHolderInterface
{
    /**
     * @return Collection|ApiTokenInterface[]
     */
    public function getApiTokens(): Collection;

    public function addApiToken(ApiTokenInterface $token): void;

    public function removeApiToken(ApiTokenInterface $token): void;
}