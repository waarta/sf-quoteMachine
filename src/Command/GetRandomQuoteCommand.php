<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Quote;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetRandomQuoteCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $name = 'app:getRandomQuote';
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct(GetRandomQuoteCommand::$name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Get a random quote.')

        // the full command description shown when running the command with
        // the "--help" option
            ->setHelp('This command allows you to get a random quote...')
            ->addArgument('category', InputArgument::OPTIONAL, 'the category of the quote')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cat = $input->getArgument('category');
        $io = new SymfonyStyle($input, $output);
        $io->title('Random Quote');
        $quotes = [];
        if ($cat == null) {
            $quoteReposit = $this->em->getRepository(Quote::class);
            $quotes = $quoteReposit->findAll();
        } else {
            $catReposit = $this->em->getRepository(Category::class);
            $query = $catReposit->createQueryBuilder('c')
                ->where('c.libCatg = :cat')
                ->setParameter('cat', $cat)
                ->getQuery();
            $quotes = $query->getResult()[0]->getQuotes();
        }
        $io->section('Category');
        $io->text($cat);
        $io->text('nb quotes: ' . sizeof($quotes));
        $io->section('Quote');
        $io->text($quotes[rand(0, sizeof($quotes) - 1)]->getContent());
        $io->newLine();
    }
}
