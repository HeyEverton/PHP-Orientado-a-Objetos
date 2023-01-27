<?php

namespace Code\Controller\Admin;

use Code\DB\Connection;
use Code\Entity\ProductImage;
use Code\Session\Flash;

class ImagesController
{
    public function remove($id)
    {
        try {
            $image = new ProductImage(Connection::getInstance());

            $imageData = $image->find($id);

            if(file_exists($file = UPLOAD_PATH . '/products/' . $imageData['image'])) {
                unlink($file);
            }
            $image->delete($id);

            Flash::add('success', 'Imagem removida com sucesso');
            return header('Location: ' . HOME . '/admin/products/edit/' . $imageData['product_id']);

        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/products/edit/' . $imageData['product_id']);
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/products/edit ' . $imageData['product_id']);
        }
    }
}
