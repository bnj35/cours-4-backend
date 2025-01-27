<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Personne;
use App\Entity\Batiment;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;

#[AsCommand(
    name: 'AppCommandAddDataCommand',
    description: 'Add a short description for your command',
)]
class AppCommandAddDataCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $batiment = new Batiment();
            $batiment->setNom($faker->company);
            $batiment->setAdresse($faker->address);
            $batiment->setId($faker->randomDigitNotNull);
            $personne = new Personne();
            $personne->setNom($faker->lastName);
            $personne->setPrenom($faker->firstName);
            $personne->setBatimentId($batiment->getId());
            $this->entityManager->persist($batiment);
            $this->entityManager->persist($personne);

            $this->entityManager->flush();
        }

        $io->success('Data has been added to the database.');
        return Command::SUCCESS;
    }
}
