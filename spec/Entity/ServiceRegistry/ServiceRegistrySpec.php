<?php

namespace spec\App\Entity\ServiceRegistry;

use App\Entity\ApiToken\ApiToken;
use App\Entity\ApiToken\ApiTokenHolderInterface;
use App\Entity\BaseEntity\AbstractBaseEntity;
use App\Entity\ServiceRegistry\ServiceRegistry;
use App\Entity\ServiceRegistry\ServiceRegistryInterface;
use PhpSpec\ObjectBehavior;

class ServiceRegistrySpec extends ObjectBehavior
{
    function let()
    {
        $this->setService('some service');
        $this->setHost('some host');
        $this->setPort(1234);
        $this->setActive(true);
        $this->addApiToken(new ApiToken());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ServiceRegistry::class);
    }

    function is_should_extend_abstract_base_entity()
    {
        $this->shouldBeAnInstanceOf(AbstractBaseEntity::class);
    }

    function it_should_implement_service_registry_interface()
    {
        $this->shouldImplement(ServiceRegistryInterface::class);
    }

    function it_should_implement_api_token_holder_interface()
    {
        $this->shouldImplement(ApiTokenHolderInterface::class);
    }

    function it_should_have_a_service_that_is_a_string()
    {
        $this->getService()->shouldBe('some service');
        $this->getService()->shouldBeString();
    }

    function it_should_have_a_host_that_is_a_string()
    {
        $this->getHost()->shouldBe('some host');
        $this->getHost()->shouldBeString();
    }

    function it_should_have_a_port_that_is_am_integer()
    {
        $this->getPort()->shouldBe(1234);
        $this->getPort()->shouldBeInt();
    }

    function it_should_be_active_and_is_a_boolean()
    {
        $this->isActive()->shouldBe(true);
        $this->isActive()->shouldBeBool();
    }

    function is_should_have_an_api_token()
    {
        $this->getApiTokens()[0]->shouldBeAnInstanceOf(ApiToken::class);
    }
}
