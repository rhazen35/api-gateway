<?php

namespace spec\App\Entity\User;

use App\Entity\BaseEntity\AbstractBaseEntity;
use App\Entity\User\Group;
use App\Entity\User\Role;
use App\Entity\User\User;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\UserInterface;

class GroupSpec extends ObjectBehavior
{
    function let()
    {
        $this->setRole('ROLE_SUPER_ADMIN');

        /** @var Group $group */
        $group = new Group();
        $group->setRole('ROLE_ADMIN');
        $this->addChildGroup($group);

        /** @var UserInterface $user */
        $user = new User();
        $this->addUser($user);

        /** @var Role $role */
        $role = new Role();
        $role->setRole('ROLE_USER_CREATE');
        $this->addSecurityRole($role);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Group::class);
    }

    function is_should_extend_abstract_base_entity()
    {
        $this->shouldBeAnInstanceOf(AbstractBaseEntity::class);
    }

    function it_should_have_a_child_group()
    {
        $this->getChildGroups()[0]->shouldBeAnInstanceOf(Group::class);
    }

    function it_should_have_a_child_group_that_is_an_admin()
    {
        $this->getChildGroups()[0]->getRole()->shouldBe("ROLE_ADMIN");
    }

    function it_should_have_a_user()
    {
        $this->getUsers()[0]->shouldBeAnInstanceOf(UserInterface::class);
    }

    function it_should_have_a_security_role()
    {
        $this->getSecurityRoles()[0]->shouldBeAnInstanceOf(Role::class);
    }

    function it_should_have_a_role()
    {
        $this->getRoles()[0]->shouldBe("ROLE_USER_CREATE");
    }
}
