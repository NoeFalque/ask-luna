<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\ImageUpload;
use \App\Models\PostsModel;
use \App\System\FormValidator;

class PostsController extends Controller {

    public function all() {
        $model = new PostsModel();
        $posts  = $model->all();

        $this->render('pages/index.twig', [
            'title'       => 'Welcome!',
            'description' => 'Welcom! - Just a simple inventory management system.',
            'page'        => 'products',
            'posts'    => $posts
        ]);
    }

    public function add() {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $category    = isset($_POST['category']) ? $_POST['category'] : '';
            $price       = isset($_POST['price']) ? (int) $_POST['price'] : '';
            $quantity    = isset($_POST['quantity']) ? (int) $_POST['quantity'] : '';
            $media       = isset($_FILES['media']) ? $_FILES['media'] : '';

            $validator = new FormValidator();
            $validator->notEmpty('title', $title, "Your title must not be empty");
            $validator->notEmpty('description', $description, "Your description must not be empty");
            $validator->isNumeric('price', $price, "Your price must be a number");
            $validator->isInteger('quantity', $quantity, "Your quantity must be a number");
            $validator->validImage('media', $media, "You didn't provided a media or it is invalid");

            if($validator->isValid()) {
                $upload    = new ImageUpload();
                $media_url = $upload->add($media);

                $model = new PostsModel();
                $model->create([
                    'title'       => $title,
                    'description' => $description,
                    'category'    => $category,
                    'price'       => $price,
                    'quantity'    => $quantity,
                    'media'       => $media_url
                ]);

                App::redirect('admin/products');
            }

            else {
                $this->render('pages/admin/products_add.twig', [
                    'title'       => 'Add product',
                    'description' => 'Products - Just a simple inventory management system.',
                    'page'        => 'products',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                        'description' => $description,
                        'price'       => $price,
                        'quantity'    => $quantity
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/admin/products_add.twig', [
                'title'       => 'Add product',
                'description' => 'Products - Just a simple inventory management system.',
                'page'        => 'products'
            ]);
        }
    }

    public function edit($id) {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $category    = isset($_POST['category']) ? $_POST['category'] : '';
            $price       = isset($_POST['price']) ? (int) $_POST['price'] : '';
            $quantity    = isset($_POST['quantity']) ? (int) $_POST['quantity'] : '';

            $validator = new FormValidator();
            $validator->notEmpty('title', $title, "Your title must not be empty");
            $validator->notEmpty('description', $description, "Your description must not be empty");
            $validator->isNumeric('price', $price, "Your price must be a number");
            $validator->isInteger('quantity', $quantity, "Your quantity must be a number");

            if($validator->isValid()) {
                $model = new PostsModel();
                $model->update($id, [
                    'title'       => $title,
                    'description' => $description,
                    'category'    => $category,
                    'price'       => $price,
                    'quantity'    => $quantity
                ]);

                App::redirect('admin/products');
            }

            else {
                $this->render('pages/admin/products_add.twig', [
                    'title'       => 'Edit product',
                    'description' => 'Products - Just a simple inventory management system.',
                    'page'        => 'products',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                        'description' => $description,
                        'price'       => $price,
                        'quantity'    => $quantity,
                        'category'    => $category
                    ]
                ]);
            }
        }

        else {
            $model2 = new PostsModel();
            $data   = $model2->find($id);

            $this->render('pages/admin/products_edit.twig', [
                'title'       => 'Edit product',
                'description' => 'Products - Just a simple inventory management system.',
                'page'        => 'products',
                'data'        => $data,
            ]);
        }
    }

    public function delete($id) {
        if(!empty($_POST)) {
            $model = new PostsModel();
            $file  = $model->find($id)->media;
            unlink(__DIR__ . '/../../public/uploads/' . $file);
            $model->delete($id);

            App::redirect('admin/products');
        }

        else {
            $model = new PostsModel();
            $data  = $model->find($id);
            $this->render('pages/admin/products_delete.twig', [
                'title'       => 'Delete product',
                'description' => 'Products - Just a simple inventory management system.',
                'page'        => 'products',
                'data'        => $data
            ]);
        }
    }

    public function single($id) {
        $model = new PostsModel();
        $post  = $model->find($id);

        $this->render('pages/single.twig', [
            'title'       => 'Single post',
            'description' => 'Post - Just a simple inventory management system.',
            'page'        => 'products',
            'post'        => $post
        ]);
    }

}
