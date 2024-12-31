<?php

namespace App\IdentityAndAccess\Presentation\Command;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User;
use App\IdentityAndAccess\Presentation\Service\Manager\ManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Creer un utilisateur avec le rôle super admin',
)]
class CreateAdminCommand extends Command
{
    private SymfonyStyle $io;

    public function __construct(
        private readonly ManagerInterface            $manager,
        private readonly UserPasswordHasherInterface $hasher
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email')
            ->addArgument('name', InputArgument::OPTIONAL, 'Nom & Prénoms')
            ->addArgument('password', InputArgument::OPTIONAL, 'Mot de passe');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (
            null !== $input->getArgument('email') &&
            null !== $input->getArgument('name') &&
            null !== $input->getArgument('password')
        ) {
            return;
        }

        $this->io->text("Processus d'ajout d'un nouvel super admin");
        $this->askArgument($input, 'email');
        $this->askArgument($input, 'name');
        $this->askArgument($input, 'password', true);
    }

    private function askArgument(InputInterface $input, string $name, bool $hidden = false): void
    {
        $value = strval($input->getArgument($name));

        if ('' !== $value) {
            $this->io->text((sprintf('> <info>%s</info>: %s', $name, $value)));
        } else {
            $value = match ($hidden) {
                false => $this->io->ask($name),
                default => $this->io->askHidden($name)
            };

            $input->setArgument($name, $value);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $user->setEmail(strval($input->getArgument('email')));
        $user->setName(strval($input->getArgument('name')));
        $user->setPassword($this->hasher->hashPassword($user, strval($input->getArgument('password'))));
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setEnabled(true);
        $this->manager->setEntity($user, 'new');

        $this->io->success("Super administrateur créé avec success");
        return Command::SUCCESS;
    }
}
