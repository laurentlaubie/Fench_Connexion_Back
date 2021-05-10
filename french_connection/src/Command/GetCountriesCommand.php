<?php

namespace App\Command;

use App\Entity\Country;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCountriesCommand extends Command
{
    protected static $defaultName = 'app:get-countries';
    protected static $defaultDescription = 'Get all countries using REST countries api';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }


    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
       
        $apiRequestUrl = 'https://restcountries.eu/rest/v2/all';
        $apiResponse = file_get_contents($apiRequestUrl);
        $apiCountries = Json_decode($apiResponse);

        foreach ($apiCountries as $apiCountry) {
            $country = new Country();
            $country->setName($apiCountry->name);
            $country->setCountryCode($apiCountry->alpha2Code);
            $country->setFlag($apiCountry->flag);
            $this->entityManager->persist($country);
        }

        $this->entityManager->flush();

        $io->success('All countries are save in database');

        return Command::SUCCESS;
    }
}
