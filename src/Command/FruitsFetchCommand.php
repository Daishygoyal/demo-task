<?php

namespace App\Command;

use App\Entity\Fruits;
use App\Services\EmailService;
use App\Services\HttpClientService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fruits:fetch',
    description: 'Add a short description for your command',
)]
class FruitsFetchCommand extends Command
{

    public function __construct(private HttpClientService $httpClient, private EntityManagerInterface $entityManager, private  EmailService $emailService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $fruits = $this->httpClient->fetchGitHubInformation();

        foreach ($fruits as $fruit) {
            $newFruit = new Fruits();
            $newFruit->setName($fruit['name']);
            $newFruit->setFamily($fruit['family']);
            $newFruit->setGenus($fruit['genus']);
            $newFruit->setNutritions($fruit['nutritions']);
            $newFruit->setIsFavourite(false);
            $newFruit->setOrderBy($fruit['order']);

            $this->entityManager->persist($newFruit);
            $this->entityManager->flush();

        }

        $email = "fruits-admin-test@yopmail.com";

        $io->note(sprintf("Imported Fruits"));

        $this->emailService->send($email, "Fruits imported successfully", "emails/fruitsFetch.html.twig", []);

        $io->note(sprintf("Email sent to Admin at email: %s", $email));

        $io->success('Fruits fetched successfully');

        return Command::SUCCESS;
    }
}
