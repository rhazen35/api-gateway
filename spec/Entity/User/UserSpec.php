<?php

namespace spec\App\Entity\User;

use App\Entity\BaseEntity\AbstractBaseEntity;
use App\Entity\User\Group;
use App\Entity\User\Role;
use App\Entity\User\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;

class UserSpec extends ObjectBehavior
{
    function let() {
        $this->setFirstName('System');
        $this->setLastName('Administrator');
        $this->setUserName('system.administrator');
        $this->setEmail('system.administrator@admin.com');
        $this->setPlainPassword('1234');
        $this->setPassword('1234');
        $this->setLastLogin(new DateTime());
        $this->setCurrentLogin(new DateTime());

        /** @var Group$group */
        $group = new Group();
        $group->setRole('ROLE_ADMIN');
        $this->addGroup($group);

        /** @var Role $role */
        $role = new Role();
        $role->setRole('ROLE_USER_CREATE');
        $this->addSecurityRole($role);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    function it_should_implement_user_interface()
    {
        $this->shouldImplement(UserInterface::class);
    }

    function is_should_extend_abstract_base_entity()
    {
        $this->shouldBeAnInstanceOf(AbstractBaseEntity::class);
    }

    function it_should_implement_serializer_interface()
    {
        $this->shouldImplement(Serializable::class);
    }

    function it_should_have_a_first_name_that_is_a_string()
    {
        $this->getFirstName()->shouldBeString();
    }

    function it_should_have_a_last_name_that_is_a_string()
    {
        $this->getFirstName()->shouldBeString();
    }

    function it_should_have_a_username_that_is_a_string()
    {
        $this->getUsername()->shouldBeString();
    }

    function it_should_have_an_email_that_is_a_string()
    {
        $this->getEmail()->shouldBeString();
    }

    function it_should_have_a_plain_password_that_is_a_string()
    {
        $this->getPlainPassword()->shouldBeString();
    }

    function it_should_have_a_password_that_is_a_string()
    {
        $this->getPassword()->shouldBeString();
    }

    function it_should_have_a_last_login_that_is_a_datetime_object()
    {
        $this->getLastLogin()->shouldBeAnInstanceOf(DateTime::class);
    }

    function it_should_have_a_current_login_that_is_a_datetime_object()
    {
        $this->getCurrentLogin()->shouldBeAnInstanceOf(DateTime::class);
    }

    function it_should_have_groups_that_is_an_instance_of_array_collection()
    {
        $this->getGroups()->shouldBeAnInstanceOf(ArrayCollection::class);
    }

    function it_should_have_security_roles_s_an_instance_of_array_collection()
    {
        $this->getSecurityRoles()->shouldBeAnInstanceOf(ArrayCollection::class);
    }

    function it_should_have_roles_that_is_an_array()
    {
        $this->getRoles()->shouldBeArray();
    }

    function it_should_have_two_roles()
    {
        $this->getRoles()->shouldHaveCount(2);
        $this->getGroups()->shouldHaveCount(1);
        $this->getSecurityRoles()->shouldHaveCount(1);
    }

    function it_should_have_one_role_instance()
    {
        $this->getSecurityRoles()[0]->shouldBeAnInstanceOf(Role::class);
    }

    function it_should_have_one_group_instance()
    {
        $this->getGroups()[0]->shouldBeAnInstanceOf(Group::class);
    }

    function it_should_e_able_to_erase_credentials()
    {
        $this->eraseCredentials();
        $this->getPlainPassword()->shouldBeNull();
    }

    function it_should_contain_role_create_user_in_roles()
    {
        $this->getRoles()->shouldStartIteratingAs(new \ArrayIterator(['ROLE_USER_CREATE']));
        $this->getRoles()->shouldStartYielding(new \ArrayIterator(['ROLE_USER_CREATE']));
    }
}
