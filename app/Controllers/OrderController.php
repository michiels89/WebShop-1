<?php

namespace Cart\Controllers;

use Slim\Router;
use Slim\Views\Twig;
use Cart\Basket\Basket;
use Cart\Models\Product;
use Cart\Validation\Contracts\ValidatorInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Cart\Validation\Forms\OrderForm;



class OrderController
{
    protected $basket;
    
    protected $router;
    
    protected $validator;
    
    public function __construct(Basket $basket, Router $router, ValidatorInterface $validator)
    {
        $this->basket = $basket;
        $this->router = $router;
        $this->validator = $validator;
    }
    
    public function index(Request $request, Response $response, Twig $view)
    {
        $this->basket->refresh();
        
        if (!$this->basket->subTotal()){
            return $response->withRedirect($this->router->pathFor('cart.index'));
        }

        return $view->render($response,'order/index.twig');
    }
    
    public function create(Request $request, Response $response)
    {
        $this->basket->refresh();
        
        if(!$this->basket->subTotal()){
            return $response->withRedirect($this->router->pathFor('cart.index'));
        }
        // validate
            $validation = $this->validator->validate($request, OrderForm::rules());
        

        if ($validation->fails()){
            
            var_dump($validation->errors);
                die();
            return $response->withRedirect($this->router->pathFor('order.index'));
        }
        die('create order');
        
        
    }
}