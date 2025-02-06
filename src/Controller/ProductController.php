<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends BaseController
{
    /*
      Listado de productos
     */
    #[Route('/product', name: 'product_index', methods: ['GET'])]
    public function index(): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->query("SELECT p.*, c.name AS category_name 
                             FROM products p 
                             LEFT JOIN categories c ON p.category_id = c.id");
        $products = $consulta->fetchAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /*
      Crear un nuevo producto
     */
    #[Route('/product/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $pdo = $this->getConnection();

        if ($request->isMethod('POST')) {
            $name        = trim($request->request->get('name'));
            $price       = $request->request->get('price');
            $category_id = $request->request->get('category_id');

            // Validacion simple
            if (!empty($name) && is_numeric($price)) {
                $consulta = $pdo->prepare("INSERT INTO products (name, price, category_id) 
                                       VALUES (:name, :price, :category_id)");
                $consulta->execute([
                    'name'        => $name,
                    'price'       => $price,
                    'category_id' => $category_id ? $category_id : null,
                ]);
                return $this->redirectToRoute('product_index');
            }
        }

        // Para el formulario, obtenemos las categorias para seleccionar
        $consulta = $pdo->query("SELECT * FROM categories");
        $categories = $consulta->fetchAll();

        return $this->render('product/new.html.twig', [
            'categories' => $categories,
        ]);
    }

    /*
      Mostrar detalles de un producto
     */
    #[Route('/product/{id}', name: 'product_show', methods: ['GET'])]
    public function show($id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("SELECT p.*, c.name AS category_name 
                               FROM products p 
                               LEFT JOIN categories c ON p.category_id = c.id 
                               WHERE p.id = :id");
        $consulta->execute(['id' => $id]);
        $product = $consulta->fetch();

        if (!$product) {
            throw $this->createNotFoundException("Producto no encontrado");
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /*
      Editar un producto
     */
    #[Route('/product/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $consulta->execute(['id' => $id]);
        $product = $consulta->fetch();

        if (!$product) {
            throw $this->createNotFoundException("Producto no encontrado");
        }

        if ($request->isMethod('POST')) {
            $name        = trim($request->request->get('name'));
            $price       = $request->request->get('price');
            $category_id = $request->request->get('category_id');

            if (!empty($name) && is_numeric($price)) {
                $consulta = $pdo->prepare("UPDATE products 
                                       SET name = :name, price = :price, category_id = :category_id 
                                       WHERE id = :id");
                $consulta->execute([
                    'name'        => $name,
                    'price'       => $price,
                    'category_id' => $category_id ? $category_id : null,
                    'id'          => $id,
                ]);
                return $this->redirectToRoute('product_index');
            }
        }

        // Obtener la lista de categorias para el formulario
        $consulta = $pdo->query("SELECT * FROM categories");
        $categories = $consulta->fetchAll();

        return $this->render('product/edit.html.twig', [
            'product'    => $product,
            'categories' => $categories,
        ]);
    }

    /*
      Eliminar un producto
     */
    #[Route('/product/{id}/delete', name: 'product_delete', methods: ['POST'])]
    public function delete(Request $request, $id): Response
    {
        $pdo = $this->getConnection();

        // Opcional: aqui se podria validar un token CSRF

        $consulta = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $consulta->execute(['id' => $id]);

        return $this->redirectToRoute('product_index');
    }
}
