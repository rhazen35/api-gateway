<?php

declare(strict_types=1);

namespace App\DataFixtures\User;

use App\Entity\User\User;
use App\Repository\User\GroupRepository;
use App\Repository\User\GroupRepositoryInterface;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /** ar UserPasswordEncoderInterface*/
    private $userPasswordEncoder;

    /** @var GroupRepositoryInterface */
    private $groupRepository;

    public function __construct(
        UserPasswordEncoderInterface $userPasswordEncoder,
        GroupRepositoryInterface $groupRepository
    )
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->groupRepository = $groupRepository;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstName('System');
        $user->setLastName('Administrator');
        $user->setUsername('system.administrator');
        $user->setEmail('admin@skeme-planning.com');
        $user->setPassword(
            $this->userPasswordEncoder->encodePassword($user, 'admin')
        );
        $user->eraseCredentials();
        $user->setCreatedAt(new DateTime());
        $user->setUpdatedAt(new DateTime());

        $user->setEnabled(true);

        $group = $this->groupRepository->findOneBy(['role' => 'ROLE_SUPER_ADMIN']);
        $user->addGroup($group);

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            GroupFixtures::class,
        ];
    }
}