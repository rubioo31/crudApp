<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends BaseController
{
    #[Route('/', name: 'category_index', methods: ['GET'])]
    public function index(): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->query("SELECT * FROM categories");
        $categories = $consulta->fetchAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'category_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $pdo = $this->getConnection();

        if ($request->isMethod('POST')) {
            $name = trim($request->request->get('name'));

            if (!empty($name)) {
                $consulta = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
                $consulta->execute([
                    'name' => $name,
                ]);
                return $this->redirectToRoute('category_index');
            }
        }

        return $this->render('category/new.html.twig');
    }

    #[Route('/{id}', name: 'category_show', methods: ['GET'])]
    public function show($id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $consulta->execute(['id' => $id]);
        $category = $consulta->fetch();

        if (!$category) {
            throw $this->createNotFoundException("Categoria no encontrada");
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $consulta->execute(['id' => $id]);
        $category = $consulta->fetch();

        if (!$category) {
            throw $this->createNotFoundException("Categoria no encontrada");
        }

        if ($request->isMethod('POST')) {
            $name = trim($request->request->get('name'));

            if (!empty($name)) {
                $consulta = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
                $consulta->execute([
                    'name' => $name,
                    'id'   => $id,
                ]);
                return $this->redirectToRoute('category_index');
            }
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/delete', name: 'category_delete', methods: ['POST'])]
    public function delete(Request $request, $id): Response
    {
        $pdo = $this->getConnection();
        $consulta = $pdo->prepare("DELETE FROM categories WHERE id = :id");
        $consulta->execute(['id' => $id]);

        return $this->redirectToRoute('category_index');
    }
}
