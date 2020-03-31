<?php

namespace spec\App\Entity\ApiToken;

use App\Entity\ApiToken\ApiToken;
use DateTime;
use PhpSpec\ObjectBehavior;

class ApiTokenSpec extends ObjectBehavior
{
    function let()
    {
        $this->setToken('some token');
        $this->setValid(new DateTime());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ApiToken::class);
    }

    function it_should_have_a_token_that_is_a_string()
    {
        $this->getToken()->shouldBe('some token');
        $this->getToken()->shouldBeString();
    }

    function it_should_have_a_valid_that_is_a_datetime()
    {
        $this->getValid()->shouldBeAnInstanceOf(DateTime::class);
    }
}
