<?php

namespace App\Command;

use App\Entity\Order\Orders;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'temp',
    description: 'Add a short description for your command',
)]
class TempCommand extends Command
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var Orders $order */
        $order = $this->em->getRepository(Orders::class)->find(2);

        $order->setDeadDrop([
            'x' => -500,
            'y' => -50,
            'z' => -500
        ]);

        $this->em->persist($order);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
