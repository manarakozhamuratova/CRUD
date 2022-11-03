<?php

namespace App\Http\Controllers;

use App\Model\Repository\AdvertRepository;
use App\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class AdvertController
{
    public function index(ServerRequest $request, Response $response)
    {
        $advertsRepo = new AdvertRepository();
        $adverts     = $advertsRepo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
    }

    public function newAdvert(ServerRequest $request, Response $response) {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->create($advertData);

        return $response->withRedirect('/adverts');
    }
    public function advertsId(ServerRequest $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $id = $args['id'] ?? '0';
        
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getById($id);

        return $view->render($response, 'adverts/advertsId.twig', ['advert' => $advert]);
    }

    public function advertEdit(ServerRequest $request, Response $response, array $args)
    {
        $view = Twig::fromRequest($request);
        $adId = $args['id'];
        $advertsRepo = new AdvertRepository();
        $advert = $advertsRepo->getById($adId);

        return $view->render($response, 'adverts/advertsEdit.twig', ['advert' => $advert]);
    }

    // public function edit(ServerRequest $request, Response $response, $id)
    // {
    //     $repo        = new AdvertRepository();
    //     $advertData  = $request->getParsedBodyParam('advert', []);

    //     $validator = new AdvertValidator();
    //     $errors    = $validator->validate($advertData);

    //     if (!empty($errors)) {
    //         $view = Twig::fromRequest($request);

    //         return $view->render($response, 'adverts/advertsEdit.twig', [
    //             'data'   => $advertData,
    //             'id' => $id['id'],
    //             'errors' => $errors,
    //         ]);
    //     }

    //     $repo->edit($advertData, $id['id']);

    //     return $response->withRedirect('/adverts' . $id['id']);
    // }

}
