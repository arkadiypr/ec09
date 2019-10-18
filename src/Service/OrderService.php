<?php
/**
 * Created by PhpStorm.
 * User: arkadiy
 * Date: 09.10.19
 * Time: 17:03
 */

namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
	const SESSION_KEY = 'currentOrder';

	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	/**
	 * @var SessionInterface
	 */
	private $sessions;

	/**
	 * @var OrderRepository
	 */
	private $orderRepo;

	public function __construct(EntityManagerInterface $entityManager, SessionInterface $sessions, OrderRepository $orderRepository)
	{
		$this->entityManager = $entityManager;
		$this->sessions = $sessions;
		$this->orderRepo = $orderRepository;
	}

	public function getOrder(): Order
	{
		$order = null;
		$orderId = $this->sessions->get(self::SESSION_KEY);

		if ($orderId) {
			$order = $this->orderRepo->find($orderId);
		}

		if (!$order) {
			$order = new Order();
		}

		return $order;
	}

	public function add(Product $product, int $count, ?User $user): Order
	{
		$order = $this->getOrder();

		$existingItem = null;

		foreach ($order->getItems() as $item) {
			if ($item->getProduct() === $product) {
				$existingItem = $item;
				break;
			}
		}

		if ($existingItem) {
			$newCount = $existingItem->getCount() + $count;
			$existingItem->setCount($newCount);
		} else {
			$existingItem = new OrderItem();
			$existingItem->setProduct($product);
			$existingItem->setCount($count);
			$order->addItem($existingItem);

		}

		$this->save($order, $user);

		return $order;

	}

	public function save(Order $order, ?User $user = null)
	{
		if ($user) {
			$order->setUser($user);
		}

		$this->entityManager->persist($order);
		$this->entityManager->flush();

		$this->sessions->set(self::SESSION_KEY, $order->getId());

	}

	public function deleteItem(OrderItem $item)
	{
		$order = $item->getCart();
		$order->removeItem($item);
		$this->entityManager->remove($item);
		$this->save($order);
		
	}

}