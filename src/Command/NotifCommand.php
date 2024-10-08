<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\MailAll;
use App\Repository\ContratRepository;
use DateTime;

#[AsCommand(
    name: 'notif',
    description: 'Sends notifications to users if necessary',
)]
class NotifCommand extends Command
{
    public $mailusers;
    public $contrats;

    public function __construct(MailAll $mailer, ContratRepository $repo)
    {
        $this->mailusers = $mailer;
        $this->contrats = $repo->findAll();
        parent::__construct();
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
        foreach($this->contrats as $contrat){
            $today = new DateTime('today');
            $interval = $today->diff($contrat->getDateFin());
            if( ($interval->days)==90 || ($interval->days)==105 || ($interval->days)==120)
            $this->mailusers->NotifyUsers($contrat->getObjet(), $contrat->getDateFin(), $contrat->getSuivi(), $contrat->getRepetitive());
        }

        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        

        $io->success('This command is doing something...');

        return Command::SUCCESS;
    }
}
