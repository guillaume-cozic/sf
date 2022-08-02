<?php

namespace App\Application\Controller;

use App\Application\CreateBookmarkRequest;
use App\Application\CreateBookmarkUseCase;
use App\Application\DeleteBookmarkRequest;
use App\Application\DeleteBookmarkUseCase;
use App\Application\form\CreateBookmarkForm;
use App\Application\form\DeleteBookmarkForm;
use App\Application\GetBookmarksQuery;
use App\Domain\Exception\BookmarkNotFound;
use App\Domain\Exception\InvalidState;
use App\Domain\Exception\LinkInfoNotRetrieved;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class BookmarkController extends AbstractController
{
    /**
     * @Route ("/bookmarks", name="bookmarks", methods={"GET","HEAD"})
     */
    public function index(GetBookmarksQuery $getBookmarksQuery):JsonResponse
    {
        $bookmarks = $getBookmarksQuery->execute();
        return $this->json($bookmarks);
    }

    /**
     * @Route("/bookmarks", name="bookmarks.create", methods={"POST"})
     */
    public function create(
        Request $request,
        CreateBookmarkUseCase $createBookmarkUseCase,
        ValidatorInterface $validator
    ):Response
    {
        $addBookmarkForm = new CreateBookmarkForm();
        $addBookmarkForm->setUrl($request->request->get('url'));
        $errors = $validator->validate($addBookmarkForm);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        try {
            $createBookmarkRequest = new CreateBookmarkRequest($request->request->get('url'));
            $id = $createBookmarkUseCase->execute($createBookmarkRequest);
            return new Response($id.' bookmark created');
        }catch (InvalidState $e){
            return new Response($e->getMessage(), 400);
        }catch (LinkInfoNotRetrieved $e){
            // @todo affichage message d'erreur correspondant et compréhensible pour l'utilisateur
            return new Response($e->getMessage(), 500);
        }catch (\Throwable $e){
            // @todo log the error
            return new Response('Erreur...'. $e->getMessage(), 500);
        }
    }

    /**
     * @Route("/bookmarks/{id}", name="bookmarks.delete", methods={"DELETE"})
     */
    public function delete(
        string $id,
        DeleteBookmarkUseCase $deleteBookmarkUseCase,
        ValidatorInterface $validator
    ):Response
    {
        $deleteBookmarkForm = new DeleteBookmarkForm();
        $deleteBookmarkForm->setId($id);
        $errors = $validator->validate($deleteBookmarkForm);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        try {
            $deleteBookmarkRequest = new DeleteBookmarkRequest($id);
            $deleteBookmarkUseCase->execute($deleteBookmarkRequest);
            return new Response($id.' bookmark deleted');
        }catch (BookmarkNotFound $e){
            return new Response('Bookmark not found', 404);
        }
    }
}