<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends BaseController
{
    #[Route('/', name: 'order_index', methods: ['GET'])]
    public function index(): Response
    {
        $pdo = $this->getConnection();
        // Se une con products para obtener el nombre del producto
        $consulta = $pdo->query("SELECT o.*, p.name AS product_name FROM orders o JOIN products p ON o.product_id = p.id");
        $orders = $consulta->fetchAll();

        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/new', name: 'order_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $pdo = $this->getConnection();

        if ($request->isMethod('POST')) {
            $product_id = $request->request->get('product_id');
            $quantity   = $request->request->get('quantity');

            if (!empty($product_id) && is_numeric($quantity)) {
                $consulta = $pdo->prepare("INSERT INTO orders (product_id, quantity) VALUES (:product_id, :quantity)");
                $consulta->execute([
                    'product_id' => $product_id,
                    'quantity'   => $quantity,
                ]);
                return $this->redirectToRoute('order_index');
            }
        }

        // Para el formulario, obtenemos la lista de productos disponibles
        $consulta = $pdo->query("SELECT id, name FROM products");
        $products = $consulta->fetchAll();

        return $this->render('order/new.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/{id}', name: 'order_show', methods: ['GET'])]
    public function show($id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("SELECT o.*, p.name AS product_name FROM orders o JOIN products p ON o.product_id = p.id WHERE o.id = :id");
        $consulta->execute(['id' => $id]);
        $order = $consulta->fetch();

        if (!$order) {
            throw $this->createNotFoundException("Orden no encontrada");
        }

        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $consulta->execute(['id' => $id]);
        $order = $consulta->fetch();

        if (!$order) {
            throw $this->createNotFoundException("Orden no encontrada");
        }

        if ($request->isMethod('POST')) {
            $product_id = $request->request->get('product_id');
            $quantity   = $request->request->get('quantity');

            if (!empty($product_id) && is_numeric($quantity)) {
                $consulta = $pdo->prepare("UPDATE orders SET product_id = :product_id, quantity = :quantity WHERE id = :id");
                $consulta->execute([
                    'product_id' => $product_id,
                    'quantity'   => $quantity,
                    'id'         => $id,
                ]);
                return $this->redirectToRoute('order_index');
            }
        }

        // Obtener la lista de productos para el selector
        $consulta = $pdo->query("SELECT id, name FROM products");
        $products = $consulta->fetchAll();

        return $this->render('order/edit.html.twig', [
            'order'    => $order,
            'products' => $products,
        ]);
    }

    #[Route('/{id}/delete', name: 'order_delete', methods: ['POST'])]
    public function delete(Request $request, $id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("DELETE FROM orders WHERE id = :id");
        $consulta->execute(['id' => $id]);

        return $this->redirectToRoute('order_index');
    }
}
