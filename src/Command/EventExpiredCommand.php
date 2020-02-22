<?php

namespace App\Command;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EventExpiredCommand extends Command
{
    protected static $defaultName = 'EventExpiredCommand';

    private $em;

    public function __construct(?string $name = null, EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Delete events who are expired')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $date = new \DateTime();
        $repo = $this->em->getRepository(Event::class);
        $events = $repo->findAll();
        for($i = 0; $i < count($events); ++$i) {
            if ($events[$i]->getEnd() < $date){
                $this->em->remove($events[$i]);
                $this->em->flush();
            }
        }


        $io->success('Tous les événements expirés ont été supprimé.');

    }
}
