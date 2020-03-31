<?php

namespace spec\App\Entity\User;

use App\Entity\BaseEntity\AbstractBaseEntity;
use App\Entity\User\Group;
use App\Entity\User\Role;
use App\Entity\User\User;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\UserInterface;

class RoleSpec extends ObjectBehavior
{
    function let()
    {
        $this->setRole('ROLE_USER_CREATE');

        /** @var Group $group */
        $group = new Group();
        $group->setRole('ROLE_ADMIN');
        $this->addGroup($group);

        /** @var UserInterface $user */
        $user = new User();
        $this->addUser($user);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Role::class);
    }

    function is_should_extend_abstract_base_entity()
    {
        $this->shouldBeAnInstanceOf(AbstractBaseEntity::class);
    }

    function it_should_have_a_group()
    {
        $this->getGroups()[0]->shouldBeAnInstanceOf(Group::class);
    }

    function it_should_have_a_user()
    {
        $this->getUsers()[0]->shouldBeAnInstanceOf(UserInterface::class);
    }

    function it_should_have_a_role()
    {
        $this->getRole()->shouldBe("ROLE_USER_CREATE");
    }
}
