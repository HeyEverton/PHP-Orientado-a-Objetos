<?php

namespace Code\Controller\Admin;

use Code\DB\Connection;
use Code\Entity\Category;
use Code\Entity\Product;
use Code\Entity\ProductCategory;
use Code\Entity\ProductImage;
use Code\Security\Validator\Sanitizer;
use Code\Security\Validator\Validator;
use Code\Session\Flash;
use Code\Upload\Upload;
use Code\View\View;
use URLify;

class ProductsController
{
    public function index()
    {
        $view = new View('admin/products/index.phtml');
        $view->products = (new Product(Connection::getInstance()))->findAll();
        return $view->render();
    }

    public function new()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            try {
                $categories = $data['categories'];

                $images = $_FILES['images'];

                $data = Sanitizer::sanitizeData($data, Product::$filters);

                if (!Validator::validateRequiredFields($data)) {
                    Flash::add('warning', 'Preencha todos os campos.');
                    return header('Location: ' . HOME . '/admin/products/new');
                }

                $data['slug'] = (new URLify())->slug($data['name']);
                $data['price'] = str_replace('.', '', $data['price']);
                $data['price'] = str_replace(',', '.', $data['price']);

                $product = new Product(Connection::getInstance());

                $productId = $product->insert([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'content' => $data['content'],
                    'price' => $data['price'],
                    'slug' => $data['slug'],
                    'is_active' => $data['is_active'],
                ]);

                if (!$productId) {
                    Flash::add('danger', 'Erro ao criar produto!');
                    return header('Location: ' . HOME . '/admin/products/new');
                }

                if (isset($images['name'][0]) && $images['name'][0]) {

                    if (!Validator::validateImageFiles($images)) {
                        Flash::add('danger', 'O formato da imagem não é suportado.');
                        return header('Location: ' . HOME . '/admin/products/new');
                    }

                    $upload = new Upload();
                    $upload->setFolder(UPLOAD_PATH . '/products/');
                    $images = $upload->doUpload($images);

                    foreach ($images as $image) {
                        $imagesData = [];
                        $imagesData['product_id'] = (int)$productId;
                        $imagesData['image'] = $image;
                        $productImages = new ProductImage(Connection::getInstance());
                        $productImages->insert($imagesData);
                    }
                }

                if (count($categories)) {
                    foreach ($categories as $category) {
                        $productCategory = new ProductCategory(Connection::getInstance());
                        $productCategory->insert([
                            'products_id' => $productId,
                            'categories_id' => $category
                        ]);
                    }
                }

                Flash::add('success', 'Produto criado com sucesso!');
                return header('Location: ' . HOME . '/admin/products');
            } catch (\Exception $e) {
                if (APP_DEBUG) {
                    Flash::add('warning', $e->getMessage());
                    return header('Location: ' . HOME . '/admin/products/new');
                }

                Flash::add('danger', 'Erro ao salvar produto');
                return header('Location: ' . HOME . '/admin/products/new');
            }
        }

        $view = new View('admin/products/new.phtml');
        $view->categories = (new Category(Connection::getInstance()))->findAll();

        return $view->render();
    }

    public function edit($id = null)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            try {
                $images = $_FILES['images'];
                $categories = $data['categories'];
                // Sanitizer::sanitizeData($data, Product::$filters);

                if (!Validator::validateRequiredFields($data)) {
                    Flash::add('warning', 'Preencha todos os campos.');
                    return header('Location: ' . HOME . '/admin/products/edit/' . $id);
                }

                $data['id'] =  (int) $id;
                $data['slug'] = (new URLify())->slug($data['name']);
                $data['price'] = str_replace('.', '', $data['price']);
                $data['price'] = str_replace(',', '.', $data['price']);

                $product = new Product(Connection::getInstance());


                if (!$product->update([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'content' => $data['content'],
                    'price' => $data['price'],
                    'slug' => $data['slug'],
                    'is_active' => $data['is_active'],
                ])) {
                    Flash::add('danger', 'Erro ao criar produto!');
                    return header('Location: ' . HOME . '/admin/products/edit/' . $id);
                }

                $productCategory = new ProductCategory(Connection::getInstance());
                $productCategory->sync($id, $categories);

                if (isset($images['name'][0]) && $images['name'][0]) {

                    if (!Validator::validateImageFiles($images)) {
                        Flash::add('danger', 'O formato da imagem não é suportado.');
                        return header('Location: ' . HOME . '/admin/products/edit/' . $id);
                    }

                    $upload = new Upload();
                    $upload->setFolder(UPLOAD_PATH . '/products/');
                    $images = $upload->doUpload($images);

                    foreach ($images as $image) {
                        $imagesData = [];
                        $imagesData['product_id'] = $id;
                        $imagesData['image'] = $image;
                        $productImages = new ProductImage(Connection::getInstance());
                        $productImages->insert($imagesData);
                    }
                }

                Flash::add('success', 'Produto atualizado com sucesso!');
                return header('Location: ' . HOME . '/admin/products/edit/' . $id);
            } catch (\Exception $e) {
                if (APP_DEBUG) {
                    Flash::add('warning', $e->getMessage());
                    return header('Location: ' . HOME . '/admin/products/new');
                }

                Flash::add('danger', 'Erro ao salvar produto');
                return header('Location: ' . HOME . '/admin/products/new');
            }
        }

        $view = new View('admin/products/edit.phtml');
        $view->product = (new Product(Connection::getInstance()))->getProductWithImagesById($id);
        $view->productCategories = (new ProductCategory(Connection::getInstance()))->where(['products_id' => $id]);
        $view->productCategories = array_map(function ($line) {
            return $line['categories_id'];
        }, $view->productCategories);
        $view->categories = (new Category(Connection::getInstance()))->findAll();

        return $view->render();;
    }

    public function remove($id = null)
    {
        try {
            $product = new Product(Connection::getInstance());

            if (!$product->delete($id)) {
                Flash::add('danger', 'Erro ao remover produto!');
                return header('Location: ' . HOME . '/admin/products');
            }

            Flash::add('success', 'Produto removido com sucesso!');
            return header('Location: ' . HOME . '/admin/products');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/products');
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/products');
        }
    }
}
