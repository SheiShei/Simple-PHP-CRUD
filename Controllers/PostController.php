<?php

class PostController
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function create(array $data): void
    {
        $post = $this->postModel->create($data);
        header('Content-Type: application/json');
        echo json_encode($post);
    }

    public function read(int $id): void
    {
        $post = $this->postModel->read($id);

        if (!$post) {
            header("HTTP/1.0 404 Not Found");
            echo 'Post not found!';
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($post);
    }

    public function update(int $id, array $data): void
    {
        $post = $this->postModel->update($id, $data);

        if (!$post) {
            header("HTTP/1.0 404 Not Found");
            echo 'Post not found!';
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($post);
    }

    public function delete(int $id): void
    {
        $response = $this->postModel->delete($id);
        if (!$response) {
            header("HTTP/1.0 404 Not Found");
            echo 'Delete unsuccessful! Post not found!';
            return;
        }

        header('Content-Type: application/json');
        echo json_encode('Successfully Deleted');
    }
}
