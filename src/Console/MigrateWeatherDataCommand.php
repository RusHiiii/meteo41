<?php

namespace App\Console;

use App\Repository\Doctrine\WeatherDataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateWeatherDataCommand extends Command
{
    private WeatherDataRepository $weatherDataRepository;

    private EntityManagerInterface $entityManager;

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new user.');
    }

    /**
     * MigrateWeatherDataCommand constructor.
     * @param WeatherDataRepository $weatherDataRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        WeatherDataRepository $weatherDataRepository,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct('app:migrate:weather_data');
        $this->weatherDataRepository = $weatherDataRepository;
        $this->entityManager = $entityManager;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $qb = $this->weatherDataRepository->findWeatherDatas();

        $result = $this->weatherDataRepository->findCountWeatherDatas();

        $progressBar = new ProgressBar($output, $result['numberOfResult']);
        $progressBar->setFormat(
            ' %current%/%max% [%bar%] <info>%percent:3s%%</info>
         <fg=white;bg=blue> %elapsed:6s%/%estimated:-6s%</> <fg=white;bg=cyan>(memory usage: %memory%)</>'
        );

        foreach ($qb->iterate() as $key => $row) {
            $weatherData = $row[0];

            $createdAt = $weatherData->getCreatedAt();

            $progressBar->advance();

            $weatherData->setDate($createdAt);


            if (($key % 1000) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        return 0;
    }
}
