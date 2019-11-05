<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadProductsCommand extends Command
{
    protected static $defaultName = 'app:load-products';

	/**
	 * @var EntityManagerInterface
	 */
    private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		parent::__construct();

		$this->entityManager = $entityManager;
	}


	protected function configure()
    {
        $this
            ->setDescription('Load products from COMFY json')
            ->addArgument('url', InputArgument::REQUIRED, 'URL for parsing products')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');
        $content = file_get_contents($url);
        $data = json_decode($content, true);

	    /**
	     * @var ProductRepository $repo
	     */
        $repo = $this->entityManager->getRepository(Product::class);

	    foreach ($data as $item) {

		    $io->writeln($item['Name']);

		    $product = $repo->findOneBy(['comfyId' => $item['ItemId']]);

		    if (!$product) {
		    	$product = new Product();
		    	$product->setComfyId($item['ItemId']);
		    	$this->entityManager->persist($product);
		    }

		    $product->setName($item['Name']);
		    $product->setDescription($item['Description']);
		    $product->setPrice($item['Price'] * 100);
		    $this->processCategories($product, $item);

	    }

	    $this->entityManager->flush();

        $io->success('OK!');
    }

	private function processCategories(Product $product, array $item)
	{
		$categoryRepo = $this->entityManager->getRepository(Category::class);

		foreach ($item['CategoryIds'] as $index => $categoryId) {

			$category = $categoryRepo->findOneBy(['comfyId' => $categoryId]);

			if (!$category) {
				$category = new Category();
				$this->entityManager->persist($category);
				$category->setName($item['CategoryNames'][$index]);
				$category->setComfyId($item['CategoryIds'][$index]);
			}

			$product->addCategory($category);
		}
	}
}
